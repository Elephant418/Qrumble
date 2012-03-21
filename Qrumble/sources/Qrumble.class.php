<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */

class Qrumble {


	/*************************************************************************
	  ATTRIBUTES                 
	 *************************************************************************/
	public $request_url;
	public $request_path;
	public $base_url;
	public $module_manager;
	public $previous_error;


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
				$this->module_manager = new Module_Manager( );
				$this->module_manager->initialize( $modules, $themes );
			}
		}
	}
	public function render( ) {
		$page = $this->get_theme_page( $this->request_path );
		$content = $page->__toString();
		return $content;
	}
	public function display( ) {
		echo $this->render( );
	}


	/*************************************************************************
	  PRIVATE METHODS                   
	 *************************************************************************/
	private function get_theme_page( $path ) {
		if ( ! $theme_file = $this->get_theme_file( $path ) ) {
			return $this->file_not_found( );
		}
		$page = file_get_html( $theme_file );
		$content_behaviour_file = substr( $theme_file, 0, strrpos( $theme_file, '.' ) ) . '.content.php';
		if ( is_file( $content_behaviour_file ) ) {
			if ( ! $data_file = $this->get_data_file( $path ) ) {
				return $this->file_not_found( );
			}
			// TODO: si oui, fetch content
			// la donner à la behaviour avec le contenu
		}
		$simple_behaviour_file = substr( $theme_file, 0, strrpos( $theme_file, '.' ) ) . '.behaviour.php';
		if ( is_file( $simple_behaviour_file ) ) {
			//TODO: Généraliser l'ouverture et le passage de variable à une behaviour			
			$base_url = $this->base_url;
			include( $simple_behaviour_file );
		}
		return $page;
	}
	private function get_data_file( $data_path ) {
		if ( $file = $this->module_manager->fetch_data_file( $data_path ) ) {
			return $file;
		}
		return false;
	}
	private function get_theme_file( $path ) {
		$router = new Router( );
		$theme_paths = $router->theme_paths( $path );

		foreach( $theme_paths as $theme_path ) {
			if ( $file = $this->module_manager->fetch_theme_file( $theme_path ) ) {
				return $file;
			}
		}

		return false;
	}
	private function file_not_found( ) {
		if ( ! is_null( $this->previous_error ) ) {
			$this->internal_error( );
		}
		$this->previous_error = '404';
		header('HTTP/1.1 404 Not Found');
		return $this->get_theme_page( '/system/404' );
	}
	private function internal_error( ) {
		if ( $this->previous_error == '500' ) {
			throw new Exception( 'Can not display the page 500 =/' );
		}
		$this->previous_error = '500';
		header('HTTP/1.1 500 Internal Server Error');
		return $this->get_theme_page( '/system/500' );
	}
}

?>
