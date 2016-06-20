<?php
$location = '';
if ( has_nav_menu( 'primary' ) ) {
	$location = 'primary';
}
$defaults = array(
    'theme_location'  => $location,
    'container'       => 'nav',
    'container_class' => 'nav',
    'menu_class' 	  => 'nav',
    'items_wrap'      => '<ul class="clearfix">%3$s</ul>',
);

wp_nav_menu( $defaults );
?>