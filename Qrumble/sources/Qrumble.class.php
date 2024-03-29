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
	public function add_configuration( $base_urls, $modules = NULL ) {

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
				$this->module_manager->initialize( $modules );
			}
		}
	}
	public function render( ) {
		$page = $this->get_design_page( $this->request_path );
		$content = $page->__toString();
		return $content;
	}
	public function display( ) {
		echo $this->render( );
	}


	/*************************************************************************
	  PRIVATE METHODS                   
	 *************************************************************************/
	private function get_design_page( $path ) {
		if ( ! $design_file = $this->fetch_design_page( $path ) ) {
			return $this->file_not_found( );
		}
		$page = file_get_html( $design_file );	
		$scripts = $page->find( 'script[type="text/php"]' );
		foreach ( $scripts as $script ) {
			$main_content = FALSE;
			if ( $script->rel == "main_content" ) {
				if ( ! $main_content = $this->file_get_data( $path ) ) {
					return $this->file_not_found( );
				}
			}
			$page = $this->execute_behaviour( $page, $script->src, $main_content );
			$script->outertext = '';
		}
		return $page;
	}


	/*************************************************************************
	  PRIVATE DOM METHODS                   
	 *************************************************************************/
	// TODO: Faire une fonction hors contexte objet
	private function execute_behaviour( $page, $behaviour_path, $main_content = FALSE ) {
		$behaviour_file = $this->module_manager->fetch_design_file( $behaviour_path );
		if ( is_file( $behaviour_file ) ) {
			$base_url = $this->base_url;
			include( $behaviour_file );
		}
		return $page;
	}


	/*************************************************************************
	  PRIVATE FILE ACCESS METHODS                   
	 *************************************************************************/
	private function fetch_design_page( $path ) {
		$router = new Router( );
		$design_paths = $router->design_paths( $path );

		foreach( $design_paths as $design_path ) {
			if ( $file = $this->module_manager->fetch_design_page( $design_path ) ) {
				return $file;
			}
		}

		return false;
	}
	private function file_get_data( $data_path ) {
		$data = Data::from_relative_path( $data_path );
		return $data->parse( );
	}


	/*************************************************************************
	  PRIVATE ERROR METHODS                   
	 *************************************************************************/
	private function file_not_found( ) {
		if ( ! is_null( $this->previous_error ) ) {
			$this->internal_error( );
		}
		$this->previous_error = '404';
		header('HTTP/1.1 404 Not Found');
		return $this->get_design_page( '/system/404' );
	}
	private function internal_error( ) {
		if ( $this->previous_error == '500' ) {
			throw new Exception( 'Can not display the page 500 =/' );
		}
		$this->previous_error = '500';
		header('HTTP/1.1 500 Internal Server Error');
		return $this->get_design_page( '/system/500' );
	}
}

?>
