<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn_mutya = "tunnel.pagodabox.com:3306";
$database_conn_mutya = "mutya";
$username_conn_mutya = "pearle";
$password_conn_mutya = "h0D9zQts";
$conn_mutya = mysql_pconnect($hostname_conn_mutya, $username_conn_mutya, $password_conn_mutya) or trigger_error(mysql_error(),E_USER_ERROR); 
?>