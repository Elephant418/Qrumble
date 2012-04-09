<?php

/* This file is part of the Qrumble project.
 * Qrumble is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */


class Data {


	/*************************************************************************
	  ATTRIBUTES				 
	 *************************************************************************/
	public $data_file_path;


	/*************************************************************************
	  CONSTRUCTOR				   
	 *************************************************************************/
	public function __construct( $data_file_path ) {
		$this->data_file_path = $data_file_path;
	}
	public static function from_relative_path( $relative_data_path ) {
		return new Data( self::get_data_path( $relative_data_path ) );
	}


	/*************************************************************************
	  PUBLIC METHODS				   
	 *************************************************************************/
	public function parse( ) {
		$content = false;
		if ( is_file( $this->data_file_path ) ) {
			$content = $this->parse_file( $this->data_file_path );
		} else if ( is_dir( $this->data_file_path ) ) {
			$files = Data_Accessor::list_files( $this->data_file_path );
			foreach ( $files as $file ) {
				if ( $sub_content = $this->parse_file( $file ) ) {
					if ( ! $content ) {
						$content = array( );
					}
					$content[ Data_Accessor::file_name( $file ) ] = $sub_content;
				}
			}
		}
		return $content;
	}


	/*************************************************************************
	  PRIVATE METHODS				   
	 *************************************************************************/
	private function parse_file( $file ) {
		// TODO: Utiliser une collection de parser
		if ( Data_Accessor::file_extension( $file ) == 'md' ) {
			return Markdown( file_get_contents( $file ) );
		} else if ( Data_Accessor::file_extension( $file ) == 'ini' ) {
			return parse_ini_file( $file );
		}
		return false;
	}


	/*************************************************************************
	  STATIC METHODS				   
	 *************************************************************************/
	public static function get_data_path( $relative_data_path ) {
		$module_manager = new Module_Manager( );
		if ( $data_file_path = $module_manager->fetch_data_file( $relative_data_path . '/' ) ) {
			return $data_file_path;
		}
		// TODO: Utiliser une collection de parser
		if ( $data_file_path = $module_manager->fetch_data_file( $relative_data_path . '.ini' ) ) {
			return $data_file_path;
		}
		return $module_manager->fetch_data_file( $relative_data_path . '.md' );
	}
}

?>
