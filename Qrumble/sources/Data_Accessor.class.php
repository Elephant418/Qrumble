<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */


class Data_Accessor {


	/*************************************************************************
	  STATIC METHODS				   
	 *************************************************************************/
	public static function fetch_content( $path ) {
		$module_manager = new Module_Manager( );
		$folders = $module_manager->fetch_data_files( $path );
		$contents = array( );
		foreach ( $folders as $folder ) {
			foreach ( self::list_files( $folder ) as $file ) {
				$data = new Data( $file );
				if ( $content = $data->parse( ) ) {
					$contents[ Data_Accessor::file_name( $file ) ] = $content;
				}
			}
		}
		return $contents;
	}
	public static function list_files( $dir ) {
		$files = array( );
		if ( is_dir( $dir ) ) {
			if ( $handle = opendir( $dir ) ) {
				while ( ( $file = readdir( $handle ) ) !== false ) {
					if ( ! is_dir( $dir . $file ) ) {
						$files[ ] = $dir . $file;
					}
				}
				closedir( $handle );
			}
		}
		return $files;
	}
	public static function file_extension( $file ) {
		return substr( $file, strrpos( $file, '.' ) + 1 );
	}
	public static function file_name( $file ) {
		$file = basename( $file );
		return substr( $file, 0, strrpos( $file, '.' ) );
	}
}

?>
