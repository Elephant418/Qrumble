<?php

$billets = Resource_Factory::get_resources_list( 'billet' );

$this->render = '';
foreach ( $billets as $billet ) {
	$this->render[ $billet->date ] = '<a href="/2012/' . $billet->name . '">' . date( 'd m Y', $billet->date ) . ' - ' . $billet->title . '</a><br>';
}
krsort( $this->render );
$this->render = implode( '', $this->render );


$this->title = 'TGIW, Le blog du mec qui code un framework PHP sur ces mercredi';

?>
