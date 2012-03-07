<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */

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
		
		$format_path = function( ) {
			$path = urldecode( $_SERVER[ 'REQUEST_URI' ] );
			if ( contains( $path, '?' ) ) {
				$path = substr( $url, 0, strpos( $path, '?' ) );
			}
			if ( ! contains( $path, '/' ) ) {
				$path .= '/';
			}
			return $path;
		};
		$format_url = function( ) use ( $format_path ) {
			return $_SERVER[ 'SERVER_NAME' ] . $format_path( );
		};

		$this->request_path = $format_path( );
		$this->request_url = $format_url( );
		$this->module_manager = new Module_Manager( );
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function add_configuration( $base_urls, $modules = NULL, $themes = NULL ) {

		$format_base_urls = function( $base_urls ) {
			$format_base_url = function( $base_url ) {
				if ( strpos( $base_url, '://' ) != -1 ) {
					$base_url = substr( $base_url, strpos( $base_url, '://' ) + 3 );
				}
				$base_url = must_not_endswith( $base_url, '/' );
				return $base_url;
			};
			if ( ! is_array( $base_urls ) ) { 
				$base_urls = array( $base_urls );
			}
			foreach ( array_keys( $base_urls ) as $index ) {
				$base_urls[ $index ] = $format_base_url( $base_urls[ $index ] );
			}
			return $base_urls;
		};

		foreach ( $format_base_urls( $base_urls ) as $base_url ) {
			if ( startswith( $this->request_url, $base_url ) ) {
				$this->base_url = $base_url;
				$this->request_path = substr( $this->request_url, strlen( $base_url ) );
				$this->module_manager = new Module_Manager( $modules, $themes );
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

		// Is it a folder page ?
		if ( endswith( $path, '/' ) ) {
			$path .= 'index';
		}
		
		// Is it a page ?
		if ( $page = $this->module_manager->fetch_page( $path ) ) {
			return $page;
		}
		
		// Is it a generic page ?
		$parent = dirname( $path );
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
