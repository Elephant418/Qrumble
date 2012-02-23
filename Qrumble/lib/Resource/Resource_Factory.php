<?php

require_once( dirname(__FILE__) . '/Resource.php' );
require_once( dirname(__FILE__) . '/Resource_md.php' );
require_once( dirname(__FILE__) . '/Resource_php.php' );

class Resource_Factory {


	/*************************************************************************
	  ATTRIBUTES                   
	 *************************************************************************/
	static $resource_types = array( 'Resource_md', 'Resource_php' );
	static $unknown_resource = array( 'type' => 'page', 'name' => '404' );


	/*************************************************************************
	  STATIC                   
	 *************************************************************************/
	static function get_resource( $type, $name ) {
		
		// Find the file path of the resource
		foreach ( Qrumble::$root_folders as $root_folder ) {
			foreach ( self::$resource_types as $resource_type ) {
				$absolute_file_path = $root_folder . 'data/' . $type . '/' . $name . '.' . $resource_type::$extension;
				if ( file_exists( $absolute_file_path ) ) {
					return new $resource_type( $absolute_file_path );
				}
			}
		}

		// Exception if the unknown resource is not found 
		if ( self::is_unknown_resource( $type, $name ) ) {
			throw new Exception( 'The unknown resource is not found' );
		}
		
		// Return then unknown resource
		return self::unknown_resource( );
	}
	static function is_unknown_resource( $type, $name ) {
		return ( $type == self::$unknown_resource[ 'type' ] && $name == self::$unknown_resource[ 'name' ] );
	}
	static function unknown_resource( ) {
		return Resource_Factory::get_resource( self::$unknown_resource[ 'type' ], self::$unknown_resource[ 'name' ] );
	}
	static function get_resources_list( $type ) {
		$resources = array( );
		
		// Find the folder path of the resource
		$folders = array( );
		foreach ( Qrumble::$root_folders as $root_folder ) {
			$folder = $root_folder . 'data/' . $type . '/';
			if ( is_dir( $folder ) ) {
				$folders[ ] = $folder;
			}
		}

		// Find the resource in the folders
		foreach ( $folders as $folder ) {
			$directory = opendir( $folder );
			while ( $file = readdir( $directory ) ) {
				if ( $file != '.' && $file != '..' && ! is_dir( $dirname.$file ) ) {
					foreach ( self::$resource_types as $resource_type ) {
						$extension = '.' . $resource_type::$extension;
						if ( substr( $file, -strlen( $extension ) ) == $extension ) {
							$resources[ ] = new $resource_type( $folder . $file );
						}
					}
				}
			}
		}

		return $resources;
	}

}

?>
