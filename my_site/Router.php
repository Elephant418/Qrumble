<?php

class Router extends Base_Router {


	/*************************************************************************
	  PUBLIC                   
	 *************************************************************************/
	public function resource_by_path( $path ) {
		if ( $this->is_path( $path, '' ) ) {
			return Resource_Factory::get_resource( 'controller', 'index' );
		}
		if ( $file = $this->is_in_folder( $path, '2012' ) ) {
			return Resource_Factory::get_resource( 'billet', $file );
		}
		return Resource_Factory::unknown_resource();
	}	

}

?>
