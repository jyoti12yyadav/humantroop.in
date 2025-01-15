<?php
/**
 * Add required and recommended plugins.
 *
 * @package thefour-lite
 */

add_action( 'tgmpa_register', 'thefour_lite_register_required_plugins' );
add_filter( 'ocdi/register_plugins', 'thefour_lite_register_ocdi_plugins' );

function thefour_lite_register_required_plugins() {
	tgmpa( thefour_lite_required_plugins(), [
		'id'          => 'thefour-lite',
		'has_notices' => true,
	] );
}

function thefour_lite_register_ocdi_plugins( $plugins ) {
	return array_merge( $plugins, thefour_lite_required_plugins() );
}

/**
 * List of required plugins
 */
function thefour_lite_required_plugins() {
	return [
		[
			'name'     =>  'Jetpack',
			'slug'     => 'jetpack',
		],
		[
			'name' =>  'Slim SEO',
			'slug' => 'slim-seo',
		],
		[
			'name' =>  'Falcon',
			'slug' => 'falcon',
		],
		[
			'name' =>  'One Click Demo Import',
			'slug' => 'one-click-demo-import',
		],
	];
}
