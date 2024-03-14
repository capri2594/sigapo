<?php
    function redirect( $query_string )
    {
        $host = $_SERVER[ 'HTTP_HOST' ];
        $uri = $_SERVER[ 'PHP_SELF' ];

        header( "Location: http://" . $host . $uri . '?' . $query_string );
        exit;
    }
?>
