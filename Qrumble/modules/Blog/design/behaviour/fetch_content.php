<?php

if ( $main_content ) {
	$mains = $page->find( '.main' );
	if ( count( $mains ) > 0 ) {
		$mains[ 0 ]->innertext = $main_content;
	}
}

?>
