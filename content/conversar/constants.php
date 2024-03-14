<?php

define('LACE_VERSION', '0.1.6-b1');

// Message Types
define('LACE_TEXT_MESSAGE', 0);
define('LACE_ACTN_MESSAGE', 1);
define('LACE_TIME_MESSAGE', 2);
define('LACE_DATE_MESSAGE', 3);
define('LACE_JOIN_MESSAGE', 4);
define('LACE_PART_MESSAGE', 5);
define('LACE_KICK_MESSAGE', 6);
define('LACE_IDLE_MESSAGE', 7);
define('LACE_NICK_MESSAGE', 8);

# Data File Locations

/** Filesystem location of the datafile directory including trailing
    slash. Default is the /data directory beneath the directory
    this configuration file is in.

    Note: this is the filesystem path, not the URL.
    */
define('LACE_DATADIR', dirname(__FILE__).'/data/');

/** Location of the archived data files (logs) including
    trailing slash. */
define('LACE_LOGDIR', LACE_DATADIR.'logs/');

/** Location and filename of the main data file. */
define('LACE_FILE', LACE_DATADIR.'lace.dat');

/** Location and filename of the current log data file */
define('LACE_LOGFILE', LACE_DATADIR.'log.dat');

/** Location and filename of the activity (user list) file */
define('LACE_ACTIVITY_FILE', LACE_DATADIR.'activity.dat');

?>