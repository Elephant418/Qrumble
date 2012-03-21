<?php

require( '../Qrumble/include.php' );

$qrumble = new Qrumble( );

// Production
$qrumble->add_configuration( 'http://blog.zilliox.me',      array( 'Blog', 'Qrumble' ), array( 'Blog', 'Basic' ) );

// Dev
$qrumble->add_configuration( 'http://blog.zilliox.me/dev/', array( 'Blog', 'Qrumble' ), array( 'Blog', 'Basic' ) );
$qrumble->add_configuration( 'http://local.qrumble',        array( 'Blog', 'Qrumble' ), array( 'Blog', 'Basic' ) );


$qrumble->display( );

?>
