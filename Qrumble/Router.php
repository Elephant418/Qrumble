<?php

class Router extends Base_Router {


	/*************************************************************************
	  PUBLIC                   
	 *************************************************************************/
	public function resource_by_path( $path ) {
		if ( $this->is_path( $path, '' ) ) {
			return Resource_Factory::get_resource( 'page', 'welcome' );
		}
		return Resource_Factory::unknown_resource();
	}	

}

?>
