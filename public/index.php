<?php

require( '../Qrumble/Qrumble.class.php' );

$qrumble = new Qrumble( );

// Production
$qrumble->add_configuration( 'http://blog.zilliox.me', 'Qrumble' );

// Dev
$qrumble->add_configuration( 'http://blog.zilliox.me/dev/', array( 'Blog', 'Qrumble' ), array( 'Blog', 'Basic' ) );

$qrumble->render( );

?>
