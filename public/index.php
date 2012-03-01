<!DOCTYPE html>
<html>
<head>
	<title>Qrumble</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php

require( '../Qrumble/Qrumble.class.php' );

$qrumble = new Qrumble( );

// Production
$qrumble->add_configuration( 'http://blog.zilliox.me', 'Qrumble' );

// Local
$qrumble->add_configuration( 'http://localhost/Qrumble/public/', array( 'Qrumble', 'Blog') );

$qrumble->render( );

?>

<body>
</html>
