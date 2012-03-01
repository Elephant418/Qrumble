<?php

require( dirname( __FILE__ ) . '/utils.php' );

class Qrumble {


	/*************************************************************************
	  ATTRIBUTES                 
	 *************************************************************************/
	public $request_url;
	public $request_path;
	public $base_url;
	public $modules = array( 'Qrumble' );


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function __construct( ) {
		$this->request_url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function add_configuration( $base_urls, $modules ) {
		if ( ! is_array( $base_urls ) ) { 
			$base_urls = array( $base_urls );
		}

		foreach ( $base_urls as $base_url ) {
			if ( strpos( $base_url, '://' ) != -1 ) {
				$base_url = substr( $base_url, strpos( $base_url, '://' ) + 3 );
				echo $base_url.'<br>';
			}
			if ( startswith( $this->request_url, $base_url ) ) {
				if ( ! is_array( $modules ) ) { 
					$modules = array( $modules );
				}
				$this->modules = $modules;
				$this->base_url = $base_url;
				$this->request_path = substr( $this->request_url, strlen( $base_url ) );
			}
		}
	}
	public function render( ) {
		echo 'Hello World : ' . $this->request_path;
	}


}

?>