<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0);

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_snet = "192.168.128.102";
$database_snet = "dbsirc_2026";
$username_snet = "root";
$password_snet = "ingreso";
$snet = mysql_pconnect($hostname_snet, $username_snet, $password_snet) or trigger_error(mysql_error(),E_USER_ERROR); 
?>