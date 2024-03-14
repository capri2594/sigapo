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
define('LOCALE_FLOODING', 'Flood Protection: Your message will be sent in ');
define('LOCALE_FLOODING_SECONDS', ' seconds.');

define('LOCALE_STOPPED', 'Stopped');
define('LOCALE_ACTIVE', 'Active');
define('LOCALE_STOP', 'Stop');
define('LOCALE_START', 'Start');

# index.php
define('LOCALE_NAV_LOBBY', 'Lobby');
define('LOCALE_NAV_LOGS', 'Logs');
define('LOCALE_NAV_HELP', 'Help');
define('LOCALE_POWERED_BY', 'Powered by');

# lace.inc.php
define('LOCALE_USERS_ONLINE', 'Users Online');
define('LOCALE_SAY', 'Say');

# lib_lace.php
define('LOCALE_JOIN_MESSAGE', 'has joined the conversation.');
define('LOCALE_IDLE_TIMEOUT_MESSAGE', 'has left the conversation (Idle timeout)');
define('LOCALE_WELCOME', 'Welcome to ');
define('LOCALE_NO_POSTS', 'No one has said anything yet.');
define('LOCALE_LOG_EMPTY', 'The current log is empty.');
define('LOCALE_FILE_MISSING', 'Sorry, the file you asked for doesn\'t exist.');
define('LOCALE_GUEST', 'Guest');
define('LOCALE_TODAY', 'Today');
define('LOCALE_YESTERDAY', 'Yesterday');
define('LOCALE_VIEW_LOGS', 'View Logs');
define('LOCALE_NO_LOGS', 'No Logs.');
?>