<?php
/**
 * SIGAPO 2026 - API Backend para Módulo "SIGAPO Spark"
 * (Chat Interno en Tiempo Real, Directorio de Presencia y Comunicados en Masa / Broadcast)
 * Compatible con PHP 5.x + MySQL (ext/mysql) y codificación UTF-8
 */
if (!isset($_SESSION)) {
    session_name("LoginSIRC");
    session_start();
}
header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate");

require_once(dirname(__FILE__) . '/../../Connections/snet.php');

if (!isset($_SESSION['user']) || trim($_SESSION['user']) === '') {
    echo json_encode(array(
        "status" => "unauthenticated",
        "message" => "Sesión no iniciada"
    ));
    exit;
}

mysql_select_db($database_snet, $snet);
@mysql_query("SET NAMES 'utf8'", $snet);

// Helpers de sanitización y codificación segura a UTF-8
function spark_esc($val) {
    return function_exists("mysql_real_escape_string")
        ? mysql_real_escape_string($val)
        : addslashes($val);
}

function spark_utf8($str) {
    if ($str === null) return '';
    if (preg_match('//u', $str)) {
        return $str;
    }
    return utf8_encode($str);
}

// 1. Inicialización automática de tablas en la Base de Datos si no existen
function spark_ensure_tables($snet) {
    $sqlChat = "CREATE TABLE IF NOT EXISTS `sigapo_chat_mensajes` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `remitente_cuenta` VARCHAR(60) NOT NULL,
        `remitente_nombre` VARCHAR(150) NOT NULL DEFAULT '',
        `destinatario_cuenta` VARCHAR(60) NOT NULL,
        `mensaje` TEXT NOT NULL,
        `tipo` VARCHAR(20) NOT NULL DEFAULT 'texto',
        `leido` TINYINT(1) NOT NULL DEFAULT 0,
        `fecha_envio` DATETIME NOT NULL,
        `fecha_lectura` DATETIME DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `idx_dest_leido` (`destinatario_cuenta`, `leido`),
        KEY `idx_conversacion` (`remitente_cuenta`, `destinatario_cuenta`, `id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    @mysql_query($sqlChat, $snet);

    $sqlCom = "CREATE TABLE IF NOT EXISTS `sigapo_comunicados` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `autor_cuenta` VARCHAR(60) NOT NULL,
        `autor_nombre` VARCHAR(150) NOT NULL DEFAULT '',
        `autor_dep` VARCHAR(150) NOT NULL DEFAULT '',
        `titulo` VARCHAR(200) NOT NULL,
        `mensaje` TEXT NOT NULL,
        `prioridad` VARCHAR(20) NOT NULL DEFAULT 'normal',
        `alcance_tipo` VARCHAR(20) NOT NULL DEFAULT 'todos',
        `alcance_valor` VARCHAR(100) NOT NULL DEFAULT '',
        `activo` TINYINT(1) NOT NULL DEFAULT 1,
        `fecha_creacion` DATETIME NOT NULL,
        `fecha_expiracion` DATETIME DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `idx_activo_fecha` (`activo`, `fecha_creacion`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    @mysql_query($sqlCom, $snet);

    $sqlAck = "CREATE TABLE IF NOT EXISTS `sigapo_comunicados_lectura` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `comunicado_id` INT(11) NOT NULL,
        `usuario_cuenta` VARCHAR(60) NOT NULL,
        `usuario_nombre` VARCHAR(150) NOT NULL DEFAULT '',
        `usuario_dep` VARCHAR(150) NOT NULL DEFAULT '',
        `fecha_lectura` DATETIME NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `uq_com_user` (`comunicado_id`, `usuario_cuenta`),
        KEY `idx_comunicado` (`comunicado_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    @mysql_query($sqlAck, $snet);
}

spark_ensure_tables($snet);

$currentUser = trim($_SESSION['user']);
$currentFun  = isset($_SESSION['fun']) ? trim($_SESSION['fun']) : $currentUser;
$currentDep  = isset($_SESSION['dep']) ? trim($_SESSION['dep']) : '';
$currentCodDep = isset($_SESSION['cod_dep']) ? trim($_SESSION['cod_dep']) : '';

// Si faltan datos en sesión, recuperarlos de funcionario/dependencia
if ($currentFun === '' || $currentCodDep === '') {
    $uEsc = spark_esc($currentUser);
    $qInfo = "SELECT f.nombre, f.dependencia_cod, f.cargo, d.nombredep, d.sigla
              FROM funcionario f
              LEFT JOIN dependencia d ON f.dependencia_cod = d.cod
              WHERE f.usuario_cuenta = '$uEsc' LIMIT 1";
    $rInfo = @mysql_query($qInfo, $snet);
    if ($rInfo && ($rowInfo = mysql_fetch_assoc($rInfo))) {
        $currentFun = $rowInfo['nombre'] ? $rowInfo['nombre'] : $currentUser;
        $currentCodDep = $rowInfo['dependencia_cod'] ? $rowInfo['dependencia_cod'] : '';
        $currentDep = $rowInfo['nombredep'] ? $rowInfo['nombredep'] : '';
        $_SESSION['fun'] = $currentFun;
        $_SESSION['cod_dep'] = $currentCodDep;
        $_SESSION['dep'] = $currentDep;
    }
}

// Actualizar latido de sesión en tabla `session` (ventana de 90 segundos)
function spark_update_presence($currentUser, $snet) {
    $now = time();
    $limite = $now - 90;
    $uEsc = spark_esc($currentUser);
    $sid = spark_esc(session_id());
    $ip  = spark_esc(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1');

    @mysql_query("DELETE FROM session WHERE tiempo < $limite", $snet);
    $res = @mysql_query("SELECT cuenta FROM session WHERE cuenta = '$uEsc' LIMIT 1", $snet);
    if ($res && mysql_num_rows($res) > 0) {
        @mysql_query("UPDATE session SET tiempo = '$now', ip = '$ip' WHERE cuenta = '$uEsc'", $snet);
    } else {
        @mysql_query("INSERT INTO session (cuenta, session_id, tiempo, ip) VALUES ('$uEsc', '$sid', '$now', '$ip')", $snet);
    }

    $resCount = @mysql_query("SELECT COUNT(DISTINCT cuenta) AS cnt FROM session WHERE cuenta != ''", $snet);
    if ($resCount && ($rCnt = mysql_fetch_assoc($resCount))) {
        return max(1, intval($rCnt['cnt']));
    }
    return 1;
}

function spark_resolve_avatar($cuenta) {
    $clean = basename(trim($cuenta));
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : 'C:/xampp/htdocs';
    $relFile = "perfiles/fotos/" . $clean . ".jpg";
    $absFile = dirname(__FILE__) . "/../../perfiles/fotos/" . $clean . ".jpg";
    if (file_exists($absFile)) {
        return $relFile;
    }
    return "perfiles/fotos/default_avatar013.jpg";
}

$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : 'poll';
$uEsc = spark_esc($currentUser);
$codDepEsc = spark_esc($currentCodDep);

// ============================================================================
// ACCIÓN 1: POLL (Latido en tiempo real cada 7s: presencia, mensajes y broadcast)
// ============================================================================
if ($action === 'poll') {
    $onlineCount = spark_update_presence($currentUser, $snet);
    $lastMsgId = isset($_REQUEST['last_msg_id']) ? intval($_REQUEST['last_msg_id']) : 0;
    $chatWith  = isset($_REQUEST['chat_with']) ? trim($_REQUEST['chat_with']) : '';
    $lastChatId = isset($_REQUEST['last_chat_id']) ? intval($_REQUEST['last_chat_id']) : 0;

    // Si el usuario tiene abierta la ventana de chat con alguien, marcar como leídos sus mensajes entrantes
    if ($chatWith !== '') {
        $peerEsc = spark_esc($chatWith);
        @mysql_query("UPDATE sigapo_chat_mensajes
                      SET leido = 1, fecha_lectura = NOW()
                      WHERE remitente_cuenta = '$peerEsc'
                        AND destinatario_cuenta = '$uEsc'
                        AND leido = 0", $snet);
    }

    // Conteo de no leídos agrupado por remitente
    $unreadTotal = 0;
    $unreadByUser = array();
    $qUnread = "SELECT remitente_cuenta, COUNT(*) AS cnt
                FROM sigapo_chat_mensajes
                WHERE destinatario_cuenta = '$uEsc' AND leido = 0
                GROUP BY remitente_cuenta";
    $rUnread = @mysql_query($qUnread, $snet);
    if ($rUnread) {
        while ($rowU = mysql_fetch_assoc($rUnread)) {
            $c = intval($rowU['cnt']);
            $unreadByUser[spark_utf8($rowU['remitente_cuenta'])] = $c;
            $unreadTotal += $c;
        }
    }

    // Últimos mensajes entrantes nuevos para disparar alerta sonora / notificación / zumbido
    $newIncoming = array();
    $maxMsgId = $lastMsgId;
    $condNew = ($lastMsgId > 0) ? " AND m.id > $lastMsgId " : " AND m.leido = 0 ";
    $qInc = "SELECT m.id, m.remitente_cuenta, m.remitente_nombre, m.mensaje, m.tipo, m.fecha_envio
             FROM sigapo_chat_mensajes m
             WHERE m.destinatario_cuenta = '$uEsc' $condNew
             ORDER BY m.id ASC LIMIT 15";
    $rInc = @mysql_query($qInc, $snet);
    if ($rInc) {
        while ($rowI = mysql_fetch_assoc($rInc)) {
            $idI = intval($rowI['id']);
            if ($idI > $maxMsgId) $maxMsgId = $idI;
            $newIncoming[] = array(
                "id" => $idI,
                "from" => spark_utf8($rowI['remitente_cuenta']),
                "from_name" => spark_utf8($rowI['remitente_nombre']),
                "mensaje" => spark_utf8($rowI['mensaje']),
                "tipo" => spark_utf8($rowI['tipo']),
                "fecha" => $rowI['fecha_envio'],
                "hora" => date('H:i', strtotime($rowI['fecha_envio'])),
                "avatar" => spark_resolve_avatar($rowI['remitente_cuenta'])
            );
        }
    } else {
        // Obtener el max id actual para inicializar el puntero del cliente
        $rMax = @mysql_query("SELECT MAX(id) AS max_id FROM sigapo_chat_mensajes WHERE destinatario_cuenta = '$uEsc'", $snet);
        if ($rMax && ($rowM = mysql_fetch_assoc($rMax))) {
            $maxMsgId = max($lastMsgId, intval($rowM['max_id']));
        }
    }

    if ($lastMsgId === 0) {
        $rMax = @mysql_query("SELECT MAX(id) AS max_id FROM sigapo_chat_mensajes WHERE destinatario_cuenta = '$uEsc'", $snet);
        if ($rMax && ($rowM = mysql_fetch_assoc($rMax))) {
            $maxMsgId = max($maxMsgId, intval($rowM['max_id']));
        }
        // En la carga inicial no bombardear con sonidos de mensajes viejos, solo si son zumbidos recientes (< 60 seg)
        $filteredInc = array();
        foreach ($newIncoming as $inc) {
            if ($inc['tipo'] === 'zumbido' && (time() - strtotime($inc['fecha'])) < 60) {
                $filteredInc[] = $inc;
            }
        }
        $newIncoming = $filteredInc;
    }

    // Mensajes nuevos de la conversación activa (si chat_with está abierto)
    $activeChatMessages = array();
    $peerOnline = false;
    if ($chatWith !== '') {
        $peerEsc = spark_esc($chatWith);
        $rPeerOn = @mysql_query("SELECT cuenta FROM session WHERE cuenta = '$peerEsc' LIMIT 1", $snet);
        $peerOnline = ($rPeerOn && mysql_num_rows($rPeerOn) > 0);

        $condChatId = ($lastChatId > 0) ? " AND id > $lastChatId " : "";
        $qActive = "SELECT id, remitente_cuenta, remitente_nombre, destinatario_cuenta, mensaje, tipo, leido, fecha_envio
                    FROM sigapo_chat_mensajes
                    WHERE ((remitente_cuenta = '$uEsc' AND destinatario_cuenta = '$peerEsc')
                       OR  (remitente_cuenta = '$peerEsc' AND destinatario_cuenta = '$uEsc'))
                      $condChatId
                    ORDER BY id ASC LIMIT 50";
        $rActive = @mysql_query($qActive, $snet);
        if ($rActive) {
            while ($rowA = mysql_fetch_assoc($rActive)) {
                $activeChatMessages[] = array(
                    "id" => intval($rowA['id']),
                    "from" => spark_utf8($rowA['remitente_cuenta']),
                    "from_name" => spark_utf8($rowA['remitente_nombre']),
                    "to" => spark_utf8($rowA['destinatario_cuenta']),
                    "mensaje" => spark_utf8($rowA['mensaje']),
                    "tipo" => spark_utf8($rowA['tipo']),
                    "leido" => intval($rowA['leido']),
                    "fecha" => $rowA['fecha_envio'],
                    "hora" => date('H:i', strtotime($rowA['fecha_envio'])),
                    "is_mine" => (strtolower($rowA['remitente_cuenta']) === strtolower($currentUser))
                );
            }
        }
    }

    // Verificar si existe algún Comunicado en Masa (Broadcast) activo pendiente de lectura para este usuario
    $pendingBroadcast = null;
    $qBroad = "SELECT c.id, c.autor_cuenta, c.autor_nombre, c.autor_dep, c.titulo, c.mensaje,
                      c.prioridad, c.alcance_tipo, c.alcance_valor, c.fecha_creacion
               FROM sigapo_comunicados c
               LEFT JOIN sigapo_comunicados_lectura l
                 ON l.comunicado_id = c.id AND l.usuario_cuenta = '$uEsc'
               WHERE c.activo = 1
                 AND l.id IS NULL
                 AND (c.fecha_expiracion IS NULL OR c.fecha_expiracion > NOW())
                 AND (
                     c.alcance_tipo = 'todos'
                     OR c.alcance_tipo = 'online'
                     OR (c.alcance_tipo = 'dependencia' AND c.alcance_valor = '$codDepEsc')
                 )
               ORDER BY
                 CASE c.prioridad WHEN 'urgente' THEN 1 WHEN 'importante' THEN 2 ELSE 3 END ASC,
                 c.id DESC
               LIMIT 1";
    $rBroad = @mysql_query($qBroad, $snet);
    if ($rBroad && ($rowB = mysql_fetch_assoc($rBroad))) {
        $pendingBroadcast = array(
            "id" => intval($rowB['id']),
            "autor_cuenta" => spark_utf8($rowB['autor_cuenta']),
            "autor_nombre" => spark_utf8($rowB['autor_nombre']),
            "autor_dep" => spark_utf8($rowB['autor_dep']),
            "titulo" => spark_utf8($rowB['titulo']),
            "mensaje" => spark_utf8($rowB['mensaje']),
            "prioridad" => spark_utf8($rowB['prioridad']),
            "alcance_tipo" => spark_utf8($rowB['alcance_tipo']),
            "alcance_valor" => spark_utf8($rowB['alcance_valor']),
            "fecha" => date('d/m/Y H:i', strtotime($rowB['fecha_creacion']))
        );
    }

    echo json_encode(array(
        "status" => "ok",
        "current_user" => spark_utf8($currentUser),
        "current_fun" => spark_utf8($currentFun),
        "current_dep" => spark_utf8($currentDep),
        "online_count" => $onlineCount,
        "unread_total" => $unreadTotal,
        "unread_by_user" => $unreadByUser,
        "max_msg_id" => $maxMsgId,
        "new_incoming" => $newIncoming,
        "active_chat_messages" => $activeChatMessages,
        "peer_online" => $peerOnline,
        "pending_broadcast" => $pendingBroadcast
    ));
    exit;
}

// ============================================================================
// ACCIÓN 2: ROSTER (Directorio completo de funcionarios agrupado + estado online)
// ============================================================================
if ($action === 'roster') {
    spark_update_presence($currentUser, $snet);

    // Mapear usuarios en línea actualmente
    $onlineMap = array();
    $rOn = @mysql_query("SELECT cuenta FROM session WHERE cuenta != ''", $snet);
    if ($rOn) {
        while ($rowO = mysql_fetch_assoc($rOn)) {
            $onlineMap[strtolower(trim($rowO['cuenta']))] = true;
        }
    }

    // Mapear conteo de mensajes no leídos por remitente
    $unreadMap = array();
    $rUn = @mysql_query("SELECT remitente_cuenta, COUNT(*) AS cnt
                         FROM sigapo_chat_mensajes
                         WHERE destinatario_cuenta = '$uEsc' AND leido = 0
                         GROUP BY remitente_cuenta", $snet);
    if ($rUn) {
        while ($rowU = mysql_fetch_assoc($rUn)) {
            $unreadMap[strtolower(trim($rowU['remitente_cuenta']))] = intval($rowU['cnt']);
        }
    }

    // Obtener funcionarios activos y sus dependencias
    $qRos = "SELECT f.usuario_cuenta, f.nombre, f.cargo, f.dependencia_cod,
                    d.nombredep, d.sigla
             FROM funcionario f
             LEFT JOIN dependencia d ON f.dependencia_cod = d.cod
             WHERE f.usuario_cuenta IS NOT NULL
               AND TRIM(f.usuario_cuenta) != ''
             ORDER BY d.nombredep ASC, f.nombre ASC";
    $rRos = @mysql_query($qRos, $snet);

    $users = array();
    $depsMap = array();
    $seenAccounts = array();

    if ($rRos) {
        while ($row = mysql_fetch_assoc($rRos)) {
            $cta = trim($row['usuario_cuenta']);
            $ctaLow = strtolower($cta);
            if ($cta === '' || isset($seenAccounts[$ctaLow])) continue;
            $seenAccounts[$ctaLow] = true;

            $depCod = trim($row['dependencia_cod']);
            $depNom = trim($row['nombredep']) !== '' ? trim($row['nombredep']) : 'Sin Dependencia Asignada';
            $depSigla = trim($row['sigla']);

            if ($depCod !== '' && !isset($depsMap[$depCod])) {
                $depsMap[$depCod] = array(
                    "cod" => spark_utf8($depCod),
                    "nombre" => spark_utf8($depNom),
                    "sigla" => spark_utf8($depSigla)
                );
            }

            // No incluir al propio usuario en su lista de contactos para chatear consigo mismo
            if ($ctaLow === strtolower($currentUser)) {
                continue;
            }

            $isOnline = isset($onlineMap[$ctaLow]);
            $unreadCnt = isset($unreadMap[$ctaLow]) ? $unreadMap[$ctaLow] : 0;

            $users[] = array(
                "cuenta" => spark_utf8($cta),
                "nombre" => spark_utf8($row['nombre'] ? $row['nombre'] : $cta),
                "cargo" => spark_utf8($row['cargo'] ? $row['cargo'] : 'Funcionario'),
                "dep_cod" => spark_utf8($depCod),
                "dep_nombre" => spark_utf8($depNom),
                "dep_sigla" => spark_utf8($depSigla),
                "online" => $isOnline ? 1 : 0,
                "unread" => $unreadCnt,
                "avatar" => spark_resolve_avatar($cta)
            );
        }
    }

    // Ordenar: 1) Con mensajes no leídos, 2) En línea primero, 3) Alfabético por nombre
    usort($users, function($a, $b) {
        if ($a['unread'] != $b['unread']) {
            return ($b['unread'] - $a['unread']);
        }
        if ($a['online'] != $b['online']) {
            return ($b['online'] - $a['online']);
        }
        return strcasecmp($a['nombre'], $b['nombre']);
    });

    echo json_encode(array(
        "status" => "ok",
        "users" => $users,
        "dependencias" => array_values($depsMap)
    ));
    exit;
}

// ============================================================================
// ACCIÓN 3: HISTORY (Cargar historial de conversación 1 a 1 con un funcionario)
// ============================================================================
if ($action === 'history') {
    $peer = isset($_REQUEST['peer']) ? trim($_REQUEST['peer']) : '';
    if ($peer === '') {
        echo json_encode(array("status" => "error", "message" => "Destinatario no especificado"));
        exit;
    }
    $peerEsc = spark_esc($peer);

    // Marcar como leídos los mensajes entrantes de este contacto
    @mysql_query("UPDATE sigapo_chat_mensajes
                  SET leido = 1, fecha_lectura = NOW()
                  WHERE remitente_cuenta = '$peerEsc'
                    AND destinatario_cuenta = '$uEsc'
                    AND leido = 0", $snet);

    // Información del contacto
    $peerInfo = array(
        "cuenta" => spark_utf8($peer),
        "nombre" => spark_utf8($peer),
        "cargo" => "",
        "dep_nombre" => "",
        "online" => 0,
        "avatar" => spark_resolve_avatar($peer)
    );
    $qP = "SELECT f.nombre, f.cargo, d.nombredep
           FROM funcionario f
           LEFT JOIN dependencia d ON f.dependencia_cod = d.cod
           WHERE f.usuario_cuenta = '$peerEsc' LIMIT 1";
    $rP = @mysql_query($qP, $snet);
    if ($rP && ($rowP = mysql_fetch_assoc($rP))) {
        $peerInfo['nombre'] = spark_utf8($rowP['nombre'] ? $rowP['nombre'] : $peer);
        $peerInfo['cargo'] = spark_utf8($rowP['cargo']);
        $peerInfo['dep_nombre'] = spark_utf8($rowP['nombredep']);
    }
    $rOn = @mysql_query("SELECT cuenta FROM session WHERE cuenta = '$peerEsc' LIMIT 1", $snet);
    if ($rOn && mysql_num_rows($rOn) > 0) {
        $peerInfo['online'] = 1;
    }

    // Últimos 60 mensajes de la conversación
    $qHist = "SELECT * FROM (
                SELECT id, remitente_cuenta, remitente_nombre, destinatario_cuenta, mensaje, tipo, leido, fecha_envio
                FROM sigapo_chat_mensajes
                WHERE (remitente_cuenta = '$uEsc' AND destinatario_cuenta = '$peerEsc')
                   OR (remitente_cuenta = '$peerEsc' AND destinatario_cuenta = '$uEsc')
                ORDER BY id DESC LIMIT 60
              ) sub ORDER BY id ASC";
    $rHist = @mysql_query($qHist, $snet);
    $messages = array();
    if ($rHist) {
        while ($rowM = mysql_fetch_assoc($rHist)) {
            $messages[] = array(
                "id" => intval($rowM['id']),
                "from" => spark_utf8($rowM['remitente_cuenta']),
                "from_name" => spark_utf8($rowM['remitente_nombre']),
                "to" => spark_utf8($rowM['destinatario_cuenta']),
                "mensaje" => spark_utf8($rowM['mensaje']),
                "tipo" => spark_utf8($rowM['tipo']),
                "leido" => intval($rowM['leido']),
                "fecha" => $rowM['fecha_envio'],
                "hora" => date('H:i', strtotime($rowM['fecha_envio'])),
                "is_mine" => (strtolower($rowM['remitente_cuenta']) === strtolower($currentUser))
            );
        }
    }

    echo json_encode(array(
        "status" => "ok",
        "peer" => $peerInfo,
        "messages" => $messages
    ));
    exit;
}

// ============================================================================
// ACCIÓN 4: SEND_MSG (Enviar mensaje de chat o Zumbido a otro funcionario)
// ============================================================================
if ($action === 'send_msg') {
    $to = isset($_REQUEST['to']) ? trim($_REQUEST['to']) : '';
    $msg = isset($_REQUEST['mensaje']) ? trim($_REQUEST['mensaje']) : '';
    $tipo = isset($_REQUEST['tipo']) ? trim($_REQUEST['tipo']) : 'texto';

    if ($to === '' || ($msg === '' && $tipo !== 'zumbido')) {
        echo json_encode(array("status" => "error", "message" => "Datos incompletos"));
        exit;
    }

    if ($tipo === 'zumbido' && $msg === '') {
        $msg = "⚡ Ha enviado un ZUMBIDO de atención urgente.";
    }

    $toEsc = spark_esc($to);
    $funEsc = spark_esc($currentFun);
    $msgEsc = spark_esc($msg);
    $tipoEsc = spark_esc($tipo);

    $qIns = "INSERT INTO sigapo_chat_mensajes
             (remitente_cuenta, remitente_nombre, destinatario_cuenta, mensaje, tipo, leido, fecha_envio)
             VALUES ('$uEsc', '$funEsc', '$toEsc', '$msgEsc', '$tipoEsc', 0, NOW())";
    $ok = @mysql_query($qIns, $snet);
    if (!$ok) {
        echo json_encode(array("status" => "error", "message" => mysql_error()));
        exit;
    }
    $newId = mysql_insert_id($snet);

    echo json_encode(array(
        "status" => "ok",
        "message_item" => array(
            "id" => intval($newId),
            "from" => spark_utf8($currentUser),
            "from_name" => spark_utf8($currentFun),
            "to" => spark_utf8($to),
            "mensaje" => spark_utf8($msg),
            "tipo" => spark_utf8($tipo),
            "leido" => 0,
            "fecha" => date('Y-m-d H:i:s'),
            "hora" => date('H:i'),
            "is_mine" => true
        )
    ));
    exit;
}

// ============================================================================
// ACCIÓN 5: SEND_BROADCAST (Emitir Comunicado en Masa / Broadcast estilo Spark)
// ============================================================================
if ($action === 'send_broadcast') {
    $titulo = isset($_REQUEST['titulo']) ? trim($_REQUEST['titulo']) : '';
    $mensaje = isset($_REQUEST['mensaje']) ? trim($_REQUEST['mensaje']) : '';
    $prioridad = isset($_REQUEST['prioridad']) ? trim($_REQUEST['prioridad']) : 'normal';
    $alcanceTipo = isset($_REQUEST['alcance_tipo']) ? trim($_REQUEST['alcance_tipo']) : 'todos';
    $alcanceValor = isset($_REQUEST['alcance_valor']) ? trim($_REQUEST['alcance_valor']) : '';
    $horasVigencia = isset($_REQUEST['horas_vigencia']) ? intval($_REQUEST['horas_vigencia']) : 24;

    if ($titulo === '' || $mensaje === '') {
        echo json_encode(array("status" => "error", "message" => "El título y el mensaje del comunicado son obligatorios."));
        exit;
    }

    if (!in_array($prioridad, array('normal', 'importante', 'urgente'))) {
        $prioridad = 'normal';
    }
    if (!in_array($alcanceTipo, array('todos', 'online', 'dependencia'))) {
        $alcanceTipo = 'todos';
    }
    if ($horasVigencia <= 0 || $horasVigencia > 720) {
        $horasVigencia = 24;
    }

    $titEsc = spark_esc($titulo);
    $msgEsc = spark_esc($mensaje);
    $prioEsc = spark_esc($prioridad);
    $alcTipoEsc = spark_esc($alcanceTipo);
    $alcValEsc = spark_esc($alcanceValor);
    $funEsc = spark_esc($currentFun);
    $depEsc = spark_esc($currentDep !== '' ? $currentDep : 'Administración SIGAPO');

    $qInsB = "INSERT INTO sigapo_comunicados
              (autor_cuenta, autor_nombre, autor_dep, titulo, mensaje, prioridad, alcance_tipo, alcance_valor, activo, fecha_creacion, fecha_expiracion)
              VALUES
              ('$uEsc', '$funEsc', '$depEsc', '$titEsc', '$msgEsc', '$prioEsc', '$alcTipoEsc', '$alcValEsc', 1, NOW(), DATE_ADD(NOW(), INTERVAL $horasVigencia HOUR))";
    $ok = @mysql_query($qInsB, $snet);
    if (!$ok) {
        echo json_encode(array("status" => "error", "message" => mysql_error()));
        exit;
    }
    $comId = intval(mysql_insert_id($snet));

    // Registrar lectura automática para el propio emisor para que no le salte su propio modal
    @mysql_query("INSERT IGNORE INTO sigapo_comunicados_lectura
                  (comunicado_id, usuario_cuenta, usuario_nombre, usuario_dep, fecha_lectura)
                  VALUES ($comId, '$uEsc', '$funEsc', '$depEsc', NOW())", $snet);

    echo json_encode(array(
        "status" => "ok",
        "comunicado_id" => $comId
    ));
    exit;
}

// ============================================================================
// ACCIÓN 6: ACK_BROADCAST (Confirmar lectura "✅ Enterado" de un Comunicado)
// ============================================================================
if ($action === 'ack_broadcast') {
    $comId = isset($_REQUEST['comunicado_id']) ? intval($_REQUEST['comunicado_id']) : 0;
    if ($comId <= 0) {
        echo json_encode(array("status" => "error", "message" => "ID inválido"));
        exit;
    }
    $funEsc = spark_esc($currentFun);
    $depEsc = spark_esc($currentDep);

    @mysql_query("INSERT IGNORE INTO sigapo_comunicados_lectura
                  (comunicado_id, usuario_cuenta, usuario_nombre, usuario_dep, fecha_lectura)
                  VALUES ($comId, '$uEsc', '$funEsc', '$depEsc', NOW())", $snet);

    echo json_encode(array("status" => "ok", "comunicado_id" => $comId));
    exit;
}

// ============================================================================
// ACCIÓN 7: LIST_BROADCASTS (Listar comunicados masivos y acuses de lectura)
// ============================================================================
if ($action === 'list_broadcasts') {
    $qList = "SELECT c.*,
                     (SELECT COUNT(*) FROM sigapo_comunicados_lectura l WHERE l.comunicado_id = c.id) AS total_lecturas,
                     d.nombredep AS alcance_dep_nombre
              FROM sigapo_comunicados c
              LEFT JOIN dependencia d ON (c.alcance_tipo = 'dependencia' AND c.alcance_valor = d.cod)
              WHERE c.activo = 1
              ORDER BY c.id DESC
              LIMIT 25";
    $rList = @mysql_query($qList, $snet);
    $items = array();
    if ($rList) {
        while ($row = mysql_fetch_assoc($rList)) {
            $alcLabel = "Todos los funcionarios";
            if ($row['alcance_tipo'] === 'online') {
                $alcLabel = "Usuarios en línea";
            } elseif ($row['alcance_tipo'] === 'dependencia') {
                $alcLabel = $row['alcance_dep_nombre'] ? $row['alcance_dep_nombre'] : ("Dependencia #" . $row['alcance_valor']);
            }
            $items[] = array(
                "id" => intval($row['id']),
                "autor_cuenta" => spark_utf8($row['autor_cuenta']),
                "autor_nombre" => spark_utf8($row['autor_nombre']),
                "autor_dep" => spark_utf8($row['autor_dep']),
                "titulo" => spark_utf8($row['titulo']),
                "mensaje" => spark_utf8($row['mensaje']),
                "prioridad" => spark_utf8($row['prioridad']),
                "alcance_tipo" => spark_utf8($row['alcance_tipo']),
                "alcance_label" => spark_utf8($alcLabel),
                "fecha" => date('d/m/Y H:i', strtotime($row['fecha_creacion'])),
                "total_lecturas" => intval($row['total_lecturas']),
                "is_mine" => (strtolower($row['autor_cuenta']) === strtolower($currentUser))
            );
        }
    }

    echo json_encode(array(
        "status" => "ok",
        "broadcasts" => $items
    ));
    exit;
}

// ============================================================================
// ACCIÓN 8: BROADCAST_READERS (Ver quiénes confirmaron lectura de un comunicado)
// ============================================================================
if ($action === 'broadcast_readers') {
    $comId = isset($_REQUEST['comunicado_id']) ? intval($_REQUEST['comunicado_id']) : 0;
    $readers = array();
    if ($comId > 0) {
        $qR = "SELECT usuario_cuenta, usuario_nombre, usuario_dep, fecha_lectura
               FROM sigapo_comunicados_lectura
               WHERE comunicado_id = $comId
               ORDER BY fecha_lectura DESC LIMIT 200";
        $rR = @mysql_query($qR, $snet);
        if ($rR) {
            while ($row = mysql_fetch_assoc($rR)) {
                $readers[] = array(
                    "cuenta" => spark_utf8($row['usuario_cuenta']),
                    "nombre" => spark_utf8($row['usuario_nombre']),
                    "dep" => spark_utf8($row['usuario_dep']),
                    "fecha" => date('d/m/Y H:i:s', strtotime($row['fecha_lectura'])),
                    "avatar" => spark_resolve_avatar($row['usuario_cuenta'])
                );
            }
        }
    }
    echo json_encode(array(
        "status" => "ok",
        "readers" => $readers
    ));
    exit;
}

echo json_encode(array("status" => "error", "message" => "Acción no reconocida"));
?>

