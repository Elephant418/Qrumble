<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */

class Router extends Router_Base {


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function design_paths( $path, $paths = array( ) ) {

		// Is it a folder page ?
		if ( endswith( $path, '/' ) ) {
			$paths[ ] = $path . 'index';
		} else {
			$paths[ ] = $path;
		}
		
		// Generic page
		$dirname = dirname( $path );
		$paths[ ] = $dirname . '/default';

		// Recursive		
		if ( strlen( $dirname ) > 1 ) {
			return $this->design_paths( $dirname, $paths );
		}
		return $paths; 
	}
}

?>
