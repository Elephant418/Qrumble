<?php

require( dirname( __FILE__ ) . '/utils.php' );
require( dirname( __FILE__ ) . '/Module_Manager.class.php' );

class Qrumble {


	/*************************************************************************
	  ATTRIBUTES                 
	 *************************************************************************/
	public $request_url;
	public $request_path;
	public $base_url;
	public $module_manager;


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function __construct( ) {
		$url = $_SERVER['SERVER_NAME'] . urldecode( $_SERVER['REQUEST_URI'] );
		if ( contains( $url, '?' ) ) {
			$url = substr( $url, 0, strpos( $url, '?' ) );
		}
		if ( ! contains( $url, '/' ) ) {
			$url .= '/';
		}
		$this->request_url = $url;
		$this->module_manager = new Module_Manager( );
		$this->request_path = substr( $this->request_url, strpos( $this->request_url, '/' ) );
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function add_configuration( $base_urls, $modules = NULL, $themes = NULL ) {
		if ( ! is_array( $base_urls ) ) { 
			$base_urls = array( $base_urls );
		}

		foreach ( $base_urls as $base_url ) {
			if ( strpos( $base_url, '://' ) != -1 ) {
				$base_url = substr( $base_url, strpos( $base_url, '://' ) + 3 );
			}
			if ( endswith( $base_url, '/' ) ) {
				$base_url = substr( $base_url, 0, -1 );
			}
			if ( startswith( $this->request_url, $base_url ) ) {
				$this->module_manager = new Module_Manager( $modules, $themes );
				$this->base_url = $base_url;
				$this->request_path = substr( $this->request_url, strlen( $base_url ) );
			}
		}
	}
	public function render( $return = FALSE ) {
		$page = $this->get_page( $this->request_path );
		$content = file_get_contents( $page );
		if ( $return ) {
			return $content;
		}
		echo $content;
	}


	/*************************************************************************
	  PRIVATE METHODS                   
	 *************************************************************************/
	private function get_page( $path, $original_path = NULL ) {
		
		// Is it a generic folder ?
		if ( endswith( $path, '/' ) ) {
			if ( $page = $this->module_manager->fetch_page( $path . 'index' ) ) {
				return $page;
			}

			// Error 404 ?
			if ( $path == '/' ) {
				return $this->get_page_404( $original_path );
			}
			$path = substr( $path, 0, -1 );
		}
		
		// Is it a page ?
		if ( $page = $this->module_manager->fetch_page( $path ) ) {
			return $page;
		}
		
		// Is it a generic page ?
		$parent = substr( $path, 0, strrpos( $path, '/' ) );
		if ( $page = $this->module_manager->fetch_page( $parent . '/page' ) ) {
			return $page;
		}
		
		// Is it a parent ?
		if ( is_null( $original_path ) ) {
			$original_path = $path;
		}
		if ( strlen( $parent ) > 1 ) {
			return $this->get_page( $parent, $original_path );
		}

		// Error 404
		return $this->get_page_404( $original_path );
		
	}
	private function get_page_404( $original_path ) {
		if ( $original_path != '/system/404' ) {
			header('HTTP/1.1 404 Not Found');
			return $this->get_page( '/system/404' );
		}
		if ( $original_path != '/system/500' ) {
			header('HTTP/1.1 500 Internal Server Error');
			return $this->get_page( '/system/500' );
		}
		throw new Exception( 'Page 500 not found =/' );
	}


}

?>
