<?php
/**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2007 qadram software <support@qadram.com>
*
*  Checkout AUTHORS file for more information on the developers
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
*  USA
*
*/
function textToHtml( $text )
{
    return nl2br( htmlentities( $text ) );
}

function htmlToText( $text )
{
    return html_entity_decode( str_replace( '<br />', "\r\n", $text ) );
}

function redirect( $file )
{
    $host = $_SERVER[ 'HTTP_HOST' ];
    $uri = rtrim( dirname( $_SERVER[ 'PHP_SELF' ] ), '/\\' );
    header( 'Location: http://' . $host . $uri . '/' . $file );
    exit();
}

function assigned($var)
{
    return($var!=null);
}

class EAbort extends Exception
{
}

function Abort()
{
    throw new EAbort();
}

function extractjscript($html)
{
    $result="";
    $pattern='@<script[^>]*?>.*?</script>@si';
    $scripts=preg_match_all($pattern, $html, $out);
    $onlyhtml=preg_replace($pattern,'',$html);

    reset($out[0]);
    while(list($key, $script)=each($out[0]))
    {
        $script=str_replace("<script language=\"Javascript\">","",$script);
        $script=str_replace("<script language=\"JavaScript\">","",$script);
        $script=str_replace('<script type="text/javascript">',"",$script);
        $script=str_replace('<script type="text/javascript" language="JavaScript">',"",$script);
        $script=str_replace("</script>","",$script);
        $result.=trim($script);
    }
    return(array($result,$onlyhtml));
}

function __unserialize($sObject)
{
    $__ret =preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $sObject );

    return unserialize($__ret);
}

function safeunserialize($input)
{
    $result=unserialize($input);
    if ($result===false)
    {
        $result=__unserialize($input);
    }
    return($result);
}

?>
