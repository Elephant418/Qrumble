<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */

function __autoload( $class_name ) {
	$module_manager = new Module_Manager( );
	if ( ! $module_manager::$initialized ) {
		throw new Exception( 'Unknown class & Module manager not initialized' );
	}
	if ( ! $path = $module_manager->fetch_class_file( $class_name ) ) {
		throw new Exception( 'Unknown class ' + $class_name );
	}
	require_once( $path );
}
