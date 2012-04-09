<?php

require( '../Qrumble/include.php' );

$qrumble = new Qrumble( );

// Production
$qrumble->add_configuration( 'http://blog.zilliox.me',      array( 'Blog', 'Qrumble' ) );

// Dev
$qrumble->add_configuration( 'http://blog.zilliox.me/dev/', array( 'Blog', 'Qrumble' ) );
$qrumble->add_configuration( 'http://local.qrumble',        array( 'Blog', 'Qrumble' ) );


$qrumble->display( );

?>
