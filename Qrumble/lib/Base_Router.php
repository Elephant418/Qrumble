<?php

class Base_Router {


	/*************************************************************************
	  PUBLIC                   
	 *************************************************************************/
	public function theme_by_path( $path ) {
		return 'default';
	}


	/*************************************************************************
	  PROTECTED                   
	 *************************************************************************/
	protected function is_path( $path, $reference ) {
		return $path == $reference;
	}
	protected function is_in_folder( $path, $folder ) {
		if ( substr( $path, 0, strlen( $folder ) + 1 ) !== $folder . '/' ) {
			return false;
		}
		return $this->file_in_folder( $path, $folder );
	}
	protected function file_in_folder( $path, $folder ) {
		return substr( $path, strlen( $folder ) + 1 );
	}

}

?>
