<?php // Manual de PHP de WebEstilo.com

// session_register('contador');
echo '<a href="'.$PHP_SELF.'?'.$SID.'">Contador vale: '.++$_SESSION['contador']. '</a>';
?>
