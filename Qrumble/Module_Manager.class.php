<?php

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

		if ( is_null( $modules ) ) {
			$modules = array( 'Qrumble' );
		} else if ( ! is_array( $modules ) ) {
			$modules = array( $modules );
		}
		$this->modules  = $modules;

		if ( is_null( $themes ) ) {
			$themes = array( 'Basic' );
		} else if ( ! is_array( $themes ) ) {
			$themes = array( $themes );
		}
		$this->themes  = $themes;

		$this->modules_root_path = dirname( __FILE__ ) . '/modules/';
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function fetch_page( $page ) {
		foreach ( $this->themes as $theme ) {
			if ( $page = $this->fetch_file( '/themes/' . $theme . $page . '.html' ) ) {
				return $page;
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
