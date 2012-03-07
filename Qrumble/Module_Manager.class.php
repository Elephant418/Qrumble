<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */


class Module_Manager {


	/*************************************************************************
	  ATTRIBUTES                 
	 *************************************************************************/
	public $modules_root_path;
	public $modules;
	public $themes;


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function __construct( $modules = NULL, $themes = NULL ) {

		$format_in_array = function( $param, $default_value ) {
			if ( is_null( $param ) || is_empty( $param ) ) {
				$param = $default_value;
			} else if ( ! is_array( $param ) ) {
				$param = array( $param );
			}
			return $param;
		};

		$this->modules = $format_in_array( $modules, array( 'Qrumble' ) );
		$this->themes  = $format_in_array( $themes, array( 'Basic' ) );
		$this->modules_root_path = dirname( __FILE__ ) . '/modules/';
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function fetch_page( $page ) {
		foreach ( $this->themes as $theme ) {
			if ( $path = $this->fetch_file( '/themes/' . $theme . $page . '.html' ) ) {
				return $path;
			}
		}
		return false;
	}


	/*************************************************************************
	  PRIVATE METHODS                   
	 *************************************************************************/
	private function fetch_file( $path_file ) {
		foreach ( $this->modules as $module ) {
			$absolute_file_path = $this->modules_root_path . $module . $path_file;
			if ( is_file( $absolute_file_path ) ) {
				return $absolute_file_path;
			}
		}
		return false;
	}


}

?>
