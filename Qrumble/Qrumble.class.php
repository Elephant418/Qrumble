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
	public $themes  = array( 'Basic' );


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function __construct( ) {
		$this->request_url = $_SERVER['SERVER_NAME'] . urldecode( $_SERVER['REQUEST_URI'] );
	}


	/*************************************************************************
	  PUBLIC METHODS                   
	 *************************************************************************/
	public function add_configuration( $base_urls, $modules = array( 'Qrumble' ), $themes = array( 'Basic' ) ) {
		if ( ! is_array( $base_urls ) ) { 
			$base_urls = array( $base_urls );
		}

		foreach ( $base_urls as $base_url ) {
			if ( strpos( $base_url, '://' ) != -1 ) {
				$base_url = substr( $base_url, strpos( $base_url, '://' ) + 3 );
			}
			if ( startswith( $this->request_url, $base_url ) ) {
				//$this->modules = is_array( $modules ) ? $modules : array( $modules );
				//$this->themes  = is_array( $themes  ) ? $themes  : array( $themes  );
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
