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
	public static $modules_path;


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function initialize( $modules = NULL ) {
		$format_modules = function( $modules, $default_value ) {
			$formated_modules = array( );
			$default_root_path = dirname( dirname( __FILE__ ) ). '/modules/';
			if ( is_null( $modules ) || empty( $modules ) ) {
				$modules = $default_value;
			} else if ( ! is_array( $modules ) ) {
				$modules = array( $modules );
			}
			foreach ( $modules as $key => $value ) {
				if ( is_numeric( $key ) ) {
					$module_name = $value;
					$module_path = $default_root_path . $module_name . '/';
				} else {
					$module_name = $key;
					$module_path = $value . '/' . $module_name . '/';
				}
				$formated_modules[ $module_name ] = $module_path;
			}
			return $formated_modules;
		};
		self::$modules_path = $format_modules( $modules, array( 'Qrumble' ) );
		self::$modules = array_keys( self::$modules_path );
		self::$initialized = TRUE;
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function fetch_data_file( $data_path ) {
		return $this->fetch_file( '/datas/' . $data_path );
	}
	public function fetch_data_files( $data_path ) {
		return $this->fetch_files( '/datas/' . $data_path );
	}
	public function fetch_design_page( $page_path ) {
		return $this->fetch_design_file( $page_path . '.html' );
	}
	public function fetch_design_file( $file_path ) {
		if ( $absolute_file_path = $this->fetch_file( '/design/' . $file_path ) ) {
			return $absolute_file_path;
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
	private function fetch_file( $relative_paths ) {
		if ( ! is_array( $relative_paths ) ) {
			$relative_paths = array( $relative_paths );
		}
		foreach ( self::$modules_path as $module_path ) {
			foreach ( $relative_paths as $relative_path ) {
				$absolute_file_path = $module_path . $relative_path;
				// echo $absolute_file_path . '<br>';
				if ( file_exists( $absolute_file_path ) ) {
					return $absolute_file_path;
				}
			}
		}
		return false;
	}
	private function fetch_files( $relative_folder ) {
		$files = array( );
		foreach ( self::$modules_path as $module_path ) {
			$absolute_file_path = $module_path . $relative_folder;
			// echo $absolute_file_path . '<br>';
			if ( file_exists( $absolute_file_path ) ) {
				$files[ ] = $absolute_file_path;
			}
		}
		return $files;
	}


}

?>
