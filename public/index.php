<?php

date_default_timezone_set( 'Europe/Paris' );
require_once( '../Qrumble/Qrumble.php' );

$qrumble = new Qrumble( 'my_site' );
echo $qrumble->render;

?>
