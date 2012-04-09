<?php

$page->find( '.main' )[0]->innertext .= '<p>So fuuunnn!!!</p>';

// Todo: Do that for all pages !!!
// Add Base Href
$heads = $page->find( 'head' );
if ( count( $heads ) >0 ) {
	$heads[0]->innertext = '<base href="http://' . $base_url . '">' . $heads[ 0 ];
}

?>
