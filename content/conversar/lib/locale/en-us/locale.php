<?php
/** Timezone offset between where your server is hosted and
    where you live (in hours).

    For example, if you live in California but the server where
    Lace is installed is in Florida, you are three hours behind
    your server and should set LOCALE_TIMEZONE_OFFSET to -3.

    This setting only is helpful for synchronizing Lace's internal
    timestamps and other time-sensitive functions to a single locale.
    It will not help someone outside your own locale see time
    related output relfect their own locale.
*/
define('LOCALE_TIMEZONE_OFFSET', 0);

# lace.js
define('LOCALE_FLOODING', 'Protección de inundaciones: Su mensaje será enviado en');
define('LOCALE_FLOODING_SECONDS', ' segundos.');

define('LOCALE_STOPPED', 'Parado');
define('LOCALE_ACTIVE', 'Activo');
define('LOCALE_STOP', 'Detener');
define('LOCALE_START', 'Iniciar');

# index.php
define('LOCALE_NAV_LOBBY', 'Lobby');
define('LOCALE_NAV_LOGS', 'Logs');
define('LOCALE_NAV_HELP', 'Help');
define('LOCALE_POWERED_BY', 'Powered by');

# lace.inc.php
define('LOCALE_USERS_ONLINE', 'Usuarios Conectados');
define('LOCALE_SAY', 'Dice');

# lib_lace.php
define('LOCALE_JOIN_MESSAGE', 'Se ha sumado a la conversación.');
define('LOCALE_IDLE_TIMEOUT_MESSAGE', 'Ha abandonado la conversación (inactivo)');
define('LOCALE_WELCOME', 'Bienvenido a ');
define('LOCALE_NO_POSTS', 'Nadie ha dicho nada todavía.');
define('LOCALE_LOG_EMPTY', 'El registro actual está vacía.');
define('LOCALE_FILE_MISSING', 'Lo sentimos, el archivo que ha pedido no existe.');
define('LOCALE_GUEST', 'Invitado');
define('LOCALE_TODAY', 'Hoy');
define('LOCALE_YESTERDAY', 'Ayer');
define('LOCALE_VIEW_LOGS', 'Ver Registros');
define('LOCALE_NO_LOGS', 'No hay Registros.');
?>
