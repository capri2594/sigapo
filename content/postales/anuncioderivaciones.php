<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Comunicado - Actualización SIGAPO 2026</title>
    <link href="../css/theme_variables.css" rel="stylesheet" type="text/css" />
    <script src="../js/theme_switcher.js" type="text/javascript"></script>
    <style type="text/css">
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Modo Claro */
        body,
        body[data-theme="light"],
        html[data-theme="light"] body {
            background-color: #f8fafc;
            color: #18181b;
        }

        html[data-theme="light"] .announcement-container,
        body[data-theme="light"] .announcement-container,
        :root:not([data-theme="dark"]) .announcement-container {
            background-color: #f8fafc;
        }

        html[data-theme="light"] .memo-card,
        body[data-theme="light"] .memo-card,
        :root:not([data-theme="dark"]) .memo-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        html[data-theme="light"] .memo-row,
        body[data-theme="light"] .memo-row,
        :root:not([data-theme="dark"]) .memo-row {
            border-bottom: 1px solid #e2e8f0;
        }

        html[data-theme="light"] .memo-label,
        body[data-theme="light"] .memo-label,
        :root:not([data-theme="dark"]) .memo-label {
            color: #50000e;
        }

        html[data-theme="light"] .memo-value,
        body[data-theme="light"] .memo-value,
        :root:not([data-theme="dark"]) .memo-value {
            color: #18181b;
        }

        html[data-theme="light"] .memo-value strong,
        body[data-theme="light"] .memo-value strong,
        :root:not([data-theme="dark"]) .memo-value strong {
            color: #18181b;
        }

        html[data-theme="light"] .memo-body,
        body[data-theme="light"] .memo-body,
        :root:not([data-theme="dark"]) .memo-body {
            color: #334155;
        }

        html[data-theme="light"] .memo-body li,
        body[data-theme="light"] .memo-body li,
        :root:not([data-theme="dark"]) .memo-body li {
            color: #334155;
        }

        html[data-theme="light"] .action-box,
        body[data-theme="light"] .action-box,
        :root:not([data-theme="dark"]) .action-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        html[data-theme="light"] .action-text,
        body[data-theme="light"] .action-text,
        :root:not([data-theme="dark"]) .action-text {
            color: #b45309;
        }

        html[data-theme="light"] .action-subtext,
        body[data-theme="light"] .action-subtext,
        :root:not([data-theme="dark"]) .action-subtext {
            color: #64748b;
        }

        /* Modo Oscuro Institucional GADOR Oruro */
        body[data-theme="dark"],
        html[data-theme="dark"] body {
            background-color: #1a080c;
            color: #f8fafc;
        }

        html[data-theme="dark"] .announcement-container {
            background-color: #1a080c;
        }

        html[data-theme="dark"] .memo-card {
            background: #280d14;
            border: 1px solid rgba(180, 138, 40, 0.25);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }

        html[data-theme="dark"] .memo-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        html[data-theme="dark"] .memo-label {
            color: #ffffff;
        }

        html[data-theme="dark"] .memo-value {
            color: #ffffff;
        }

        html[data-theme="dark"] .memo-value strong {
            color: #ffffff;
        }

        html[data-theme="dark"] .memo-body {
            color: #e2e8f0;
        }

        html[data-theme="dark"] .memo-body li {
            color: #e2e8f0;
        }

        html[data-theme="dark"] .action-box {
            background-color: #280d14;
            border: 1px solid rgba(180, 138, 40, 0.25);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }

        html[data-theme="dark"] .action-text {
            color: #ffffff;
        }

        html[data-theme="dark"] .action-subtext {
            color: #cbd5e1;
        }

        /* Estructura común */
        .announcement-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 15px;
            border-radius: 8px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header-banner {
            background: linear-gradient(135deg, #4d000d 0%, #680014 50%, #4d000d 100%);
            border-radius: 8px;
            padding: 16px;
            text-align: center;
            border: 1px solid rgba(180, 138, 40, 0.4);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3), 0 0 12px rgba(180, 138, 40, 0.2);
        }

        .header-banner h1 {
            font-size: 20px;
            font-weight: 800;
            margin: 0 0 6px 0;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .header-banner h2 {
            font-size: 13px;
            font-weight: 700;
            margin: 0;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            text-shadow: 0 0 10px rgba(180, 138, 40, 0.4);
        }

        .memo-card {
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .memo-row {
            display: flex;
            margin-bottom: 8px;
            padding-bottom: 8px;
        }

        .memo-row:last-of-type {
            margin-bottom: 15px;
        }

        .memo-label {
            flex: 0 0 80px;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .memo-value {
            flex: 1;
            font-size: 13px;
            line-height: 1.4;
        }

        .memo-body {
            font-size: 13px;
            line-height: 1.6;
            text-align: justify;
            margin-top: 15px;
        }

        .memo-body p {
            margin: 0 0 12px 0;
        }

        .memo-body ul {
            margin: 10px 0 15px 0;
            padding-left: 20px;
        }

        .memo-body li {
            margin-bottom: 6px;
        }

        .action-box {
            border-radius: 8px;
            padding: 16px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .action-text {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .action-btn {
            display: inline-block;
            background: linear-gradient(135deg, #50000e 0%, #6e0015 100%);
            border: 1px solid rgba(180, 138, 40, 0.45);
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 24px;
            border-radius: 6px;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            box-shadow: 0 4px 12px rgba(80, 0, 14, 0.4);
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #640012 0%, #881337 100%);
            border-color: #ffffff;
            box-shadow: 0 6px 16px rgba(80, 0, 14, 0.6), 0 0 12px rgba(180, 138, 40, 0.4);
            transform: translateY(-2px);
        }

        .action-subtext {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body>
    <div class="announcement-container">
        <!-- Banner Superior -->
        <header class="header-banner">
            <h1>Comunicado</h1>
            <h2>G.A.D.OR. / S.D.P.D. / A.T.I. Nº 001/2026</h2>
        </header>

        <!-- Contenedor del Memorándum / Instructivo -->
        <main class="memo-card">
            <div class="memo-row">
                <span class="memo-label">A:</span>
                <span class="memo-value"><strong>SECRETARIOS DEPARTAMENTALES, DIRECTORES, JEFES DE UNIDAD, ENCARGADOS DE ÁREA Y RESPONSABLES DE PROYECTOS</strong></span>
            </div>
            <div class="memo-row">
                <span class="memo-label">DE:</span>
                <span class="memo-value"><strong>Ing. Reynaldo Jesús Flores Jaillita</strong><br />ENCARGADO DEL ÁREA DE TECNOLOGÍAS DE LA INFORMACIÓN</span>
            </div>
            <div class="memo-row">
                <span class="memo-label">REF:</span>
                <span class="memo-value"><strong>ACTUALIZACIÓN BASE DE DATOS DEL SISTEMA DE CORRESPONDENCIA SIGAPO 2026</strong></span>
            </div>
            <div class="memo-row">
                <span class="memo-label">Fecha:</span>
                <span class="memo-value">Oruro, 01 de enero de 2026</span>
            </div>

            <!-- Cuerpo del Comunicado -->
            <div class="memo-body">
                <p>El Área de Tecnologías de la Información, dependiente de la Secretaría Departamental de Planificación del Desarrollo del Gobierno Autónomo Departamental de Oruro, comunica a todos los usuarios del SIGAPO que deben llenar el formulario de registro y actualización para la gestión 2026. El formulario se encuentra disponible en línea mediante el botón <strong>"ACTUALIZAR DATOS SIGAPO 2026"</strong>, para lo cual podrán acceder con su cuenta y contraseña de la gestión anterior. La información requerida es la siguiente:</p>
                
                <ul>
                    <li>Denominación (Secretaría, Dirección, Unidad, Área, Servicios Departamentales o Proyectos).</li>
                    <li>Sigla.</li>
                    <li>Edificio donde se encuentra ubicada la oficina (Edificio Central, Ex Hotel Prefectural, SEDEDE, SEDAG, SEDES, Hospital General, etc.).</li>
                    <li>Nombres del personal que conforma su dependencia.</li>
                    <li>Número telefónico del personal.</li>
                    <li>Número telefónico de la oficina.</li>
                    <li>Número de fax (si corresponde).</li>
                    <li>Nombre de la o las personas encargadas del manejo de la correspondencia (usuario/s del SIGAPO).</li>
                </ul>

                <p>Una vez ingresada la información solicitada, el sistema generará un documento en formato PDF que deberá ser <strong>impreso</strong> y presentado para su validación al Área de Tecnologías de la Información hasta el <strong>12 de enero de 2026</strong> impostergablemente. La información debe ser fidedigna y contemplar únicamente a los funcionarios actualmente activos. Se ruega tomar en cuenta el presente instructivo, ya que las dependencias que no presenten el formulario no serán habilitadas para la gestión 2026.</p>
                
                <p>Asimismo, se aclara que la actualización en línea es obligatoria para que las cuentas de SIGAPO puedan ser activadas y operadas en la presente gestión.</p>
            </div>
        </main>

        <!-- Recuadro de Acción / Botón -->
        <section class="action-box">
            <span class="action-text">Acceso para Actualización de Funcionarios</span>
            <a href="../registro_sigapo/index.php" class="action-btn" target="_blank" rel="noopener noreferrer">Actualizar Datos SIGAPO 2026</a>
            <span class="action-subtext">Presentar reporte impreso hasta el 12 de enero de 2026</span>
        </section>
    </div>
</body>
</html>