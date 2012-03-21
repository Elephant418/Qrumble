<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */


class Module_Manager {


	/*************************************************************************
	  ATTRIBUTES                 
	 *************************************************************************/
	public static $initialized = FALSE;
	public static $modules_root_path;
	public static $modules;
	public static $themes;


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function initialize( $modules = NULL, $themes = NULL ) {
		$format_in_array = function( $param, $default_value ) {
			if ( is_null( $param ) || empty( $param ) ) {
				$param = $default_value;
			} else if ( ! is_array( $param ) ) {
				$param = array( $param );
			}
			return $param;
		};
		self::$modules = $format_in_array( $modules, array( 'Qrumble' ) );
		self::$themes  = $format_in_array( $themes, array( 'Basic' ) );
		self::$modules_root_path = dirname( dirname( __FILE__ ) ). '/modules/';
		self::$initialized = TRUE;
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function fetch_data_file( $data_path ) {
		if ( $file_path = $this->fetch_file( '/data/' . $data_path . '.ini' ) ) {
			return $file_path;
		}
		return false;
	}
	public function fetch_theme_file( $page_path ) {
		foreach ( self::$themes as $theme ) {
			if ( $file_path = $this->fetch_file( '/themes/' . $theme . $page_path . '.html' ) ) {
				return $file_path;
			}
		}
		return false;
	}
	public function fetch_class_file( $class_name ) {
		$module_paths = array( '/classes/' . $class_name . '.class.php', '/classes/' . $class_name . '.php' );
		if ( $path = $this->fetch_file( $module_paths ) ) {
			return $path;
		}
		return false;
	}


	/*************************************************************************
	  PRIVATE METHODS                   
	 *************************************************************************/
	private function fetch_file( $module_paths ) {
		if ( ! is_array( $module_paths ) ) {
			$module_paths = array( $module_paths );
		}
		foreach ( self::$modules as $module ) {
			foreach ( $module_paths as $module_path ) {
				$absolute_file_path = self::$modules_root_path . $module . $module_path;
				if ( file_exists( $absolute_file_path ) ) {
					return $absolute_file_path;
				}
			}
		}
		return false;
	}


}

?>
