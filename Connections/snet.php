<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_snet = "192.168.128.102";
$database_snet = "dbsirc_2024";
$username_snet = "sdafp";
$password_snet = "finanzas";
$snet = mysql_pconnect($hostname_snet, $username_snet, $password_snet) or trigger_error(mysql_error(),E_USER_ERROR); 
?>