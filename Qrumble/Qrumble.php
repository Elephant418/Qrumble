<?php

require_once( dirname(__FILE__) . '/lib/Base_Router.php' );
require_once( dirname(__FILE__) . '/lib/Resource/Resource_Factory.php' );
require_once( dirname(__FILE__) . '/lib/Theme/Theme.php' );

class Qrumble {


	/*************************************************************************
	  ATTRIBUTES                 
	 *************************************************************************/
	public $render;
	static $root_folders = array( );



	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function __construct( $website, $path_prefix = '' ) {
		self::$root_folders[] = '../' . $website . '/';
		self::$root_folders[] = dirname(__FILE__) . '/';

		$path = $this->find_path( $path_prefix );
		$router = $this->instance_router( );
		$resource = $router->resource_by_path( $path );
		$theme = new Theme( $router->theme_by_path( $path ) );
		$this->render = $theme->render( $resource );
	}


	/*************************************************************************
	  PRIVATE                   
	 *************************************************************************/
	private function find_path( $path_prefix ) {
		$path = substr( $_SERVER['REQUEST_URI'], 1 );
		if ( substr( $path, 0, strlen( $path_prefix ) ) == $path_prefix ) {
			$path = substr( $path, strlen( $path_prefix ) );
		}
		return $path;
	}
	private function instance_router( ) {
		$router_file = $this->find_absolute_file_path( 'Router.php' );
		require_once( $router_file );
		return new Router();
	}


	/*************************************************************************
	  STATIC                   
	 *************************************************************************/
	static function find_absolute_file_path( $file_path ) {
		foreach ( Qrumble::$root_folders as $root_folder ) {
			$absolute_file_path = $root_folder . $file_path;
			if ( file_exists( $absolute_file_path ) ) {
				return $absolute_file_path;
			}
		}
		throw new Exception( 'File not found "' . $file_path . '".' );
	}

}

?>
