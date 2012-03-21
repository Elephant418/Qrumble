<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */

class Router_Base {


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function __construct( ) {
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function theme_paths( $path ) {
		return array( $path ); 
	}
}

?>
