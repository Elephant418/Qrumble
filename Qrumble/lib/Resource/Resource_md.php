<?php

require_once( dirname(__FILE__) . '/markdown.php' );

class Resource_md extends Resource {


	/*************************************************************************
	  ATTRIBUTES                   
	 *************************************************************************/
	static $extension = 'md';
	public $file_name;
	public $name;
	public $date;
	public $title;


	/*************************************************************************
	  CONSTRUCTOR                   
	 *************************************************************************/
	public function __construct( $file_path ) {
		parent::__construct( $file_path );
		
		// Name & Date
		$this->file_name = basename( $file_path );
		$this->date = substr( $file, 0, 10 );
		if ( strptime( $this->date, '%Y-/%m-/%d' ) !== FALSE) {
			$this->name = substr( $this->file_name, 10, -3 );
		} else {
			$this->name = substr( $this->file_name, 0, -3 );
			$this->date = null;
		}

		// Title
		$content = array( );
		$file = fopen( $file_path, 'r' );
		while ( $content[ ] = fgets( $file ) ) {
		}
		$this->date = strtotime( array_shift( $content ) );
		$this->title = $content[ 0 ];
		$this->content = implode( '', $content );
	}


	/*************************************************************************
	  PUBLIC                   
	 *************************************************************************/
	public function display( ) {
		return Markdown( $this->content );
	}

}

?>
