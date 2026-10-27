<?php 
header("Content-Type: text/html; charset=utf-8");
require_once('../../Connections/snet.php');

$texto = isset($_GET['texto']) ? trim($_GET['texto']) : '';
if (strlen($texto) < 1) {
    echo "<ul></ul>";
    exit;
}

mysql_select_db($database_snet, $snet);

$texto_esc = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($texto) : addslashes($texto);

// Búsqueda flexible por número o código, ordenado por las más recientes
$query_obtener_codHR = sprintf(
    "SELECT cod FROM hojaruta WHERE cod LIKE '%%%s%%' ORDER BY fecha_creacion DESC LIMIT 0, 15",
    $texto_esc
);

$obtener_codHR = mysql_query($query_obtener_codHR, $snet);
$totalRows = $obtener_codHR ? mysql_num_rows($obtener_codHR) : 0;
?>
<ul>
<?php if ($totalRows > 0): ?>
    <?php while ($row = mysql_fetch_assoc($obtener_codHR)): 
        $cod = htmlspecialchars($row['cod']);
    ?>
    <li><?php echo $cod; ?></li>
    <?php endwhile; ?>
<?php endif; ?>
</ul>
<?php
if ($obtener_codHR) mysql_free_result($obtener_codHR);
?>
