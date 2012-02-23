<?php

class Theme {


	/*************************************************************************
	  ATTRIBUTES                   
	 *************************************************************************/
	public $theme_name;


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function __construct( $theme_name ) {
		$this->theme_name = $theme_name;
	}


	/*************************************************************************
	  PUBLIC                   
	 *************************************************************************/
	public function render( $resource ) {
		$theme = Qrumble::find_absolute_file_path( 'theme/' . $this->theme_name . '.php' );

		ob_start();
		include( $theme );		
		$render = ob_get_contents();
		ob_end_clean();

		return $render;
	}


}

?>
