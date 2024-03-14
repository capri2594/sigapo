<?php
    require_once("blog_db.php");

    class AdminLogin
    {
        function EnsureLogin()
        {
            global $BlogDB;

            $loginid = $_COOKIE[ 'loginid' ];

            if( !empty( $loginid ) && preg_match( '/^[a-z0-9]{1,}$/i', $loginid ) )
            {
                $BlogDB->Query1->close();
                $BlogDB->Query1->SQL = "SELECT * FROM admins WHERE LoginID = '" . mysql_real_escape_string( $loginid ) . "'";
                $BlogDB->Query1->open();

                if( $BlogDB->Query1->RecordCount == 1 )
                    return;
            }

            header( 'Location: admin_do_login.php' );
        }

        function TryLogin( $username, $password )
        {
            global $BlogDB;

            if( !empty( $username ) && !empty( $password ) && preg_match( '/^[a-z0-9]{1,}$/i', $username ) && preg_match( '/^[a-z0-9]{1,}$/i', $password ) )
            {
                $BlogDB->Query1->close();
                $BlogDB->Query1->SQL = "SELECT * FROM admins " .
                                         "WHERE Username = '" . mysql_real_escape_string( $username ) . "' AND " .
                                         "Password = '" . mysql_real_escape_string( $password ) . "'";
                $BlogDB->Query1->open();

                if( $BlogDB->Query1->RecordCount == 1 )
                {
                    $loginid = md5( uniqid( rand(), true ) . time() );

                    $BlogDB->Query1->close();
                    $BlogDB->Query1->LimitStart = -1;
                    $BlogDB->Query1->LimitCount = -1;
                    $BlogDB->Query1->SQL = "UPDATE admins SET LoginID = '" . mysql_real_escape_string( $loginid ) . "' " .
                                             "WHERE Username = '" . mysql_real_escape_string( $username ) . "' AND " .
                                             "Password = '" . mysql_real_escape_string( $password ) . "'";

                    $BlogDB->Query1->open();

                    setcookie( 'loginid', $loginid );

                    return true;
                }
            }

            return false;
        }
    }

    global $AdminLogin;

    $AdminLogin = new AdminLogin();

    function GetAdminLogin()
    {
        global $AdminLogin;

        return $AdminLogin;
    }
?>
