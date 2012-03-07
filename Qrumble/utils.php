<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */


/**************************************************************************
            STRING MANIPULATION
 *************************************************************************/
function startswith( $hay, $needle ) {
	return substr( $hay, 0, strlen( $needle ) ) == $needle;
}
function endswith( $hay, $needle ) {
	return substr( $hay, -strlen( $needle ) ) == $needle;
}
function istartswith( $hay, $needle ) {
	return startswith( strtolower( $hay ), strtolower( $needle ) );
}
function iendswith( $hay, $needle ) {
	return endswith( strtolower( $hay ), strtolower( $needle ) );
}
function contains( $hay, $needle ) {
	return ( strpos( $hay, $needle ) !== false );
}
function icontains( $hay, $needle ) {
	return contains( strtolower( $hay ), strtolower( $needle ) );
}
function must_startswith( $hay, $needle ) {
	if ( ! startswith( $hay, $needle ) ) {
		$hay = $needle . $hay;
	}
}
function must_endswith( $hay, $needle ) {
	if ( ! endswith( $hay, $needle ) ) {
		$hay .= $needle;
	}
}
function must_not_startswith( $hay, $needle ) {
	if ( startswith( $hay, $needle ) ) {
		$hay = substr( $hay, 1 );
	}
}
function must_not_endswith( $hay, $needle ) {
	if ( endswith( $hay, $needle ) ) {
		$hay = substr( $hay, 0, -1 );
	}
}

?>
