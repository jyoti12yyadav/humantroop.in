<?php
/**
 * TheFour Theme Customizer.
 *
 * @package TheFour
 */

/**
 * Register theme options in the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function thefour_customize_register( $wp_customize ) {
	// Remove the core header textcolor control, as it shares the main text color.
	$wp_customize->remove_control( 'header_textcolor' );

	// Add theme options section.
	$wp_customize->add_section( 'thefour-lite', array(
		'title' => esc_html__( 'Theme Options', 'thefour-lite' ),
	) );

	// Front page settings.

	// Features section.
	$wp_customize->add_setting( 'front_page_features_page', array(
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'front_page_features_page', array(
		'label'           => esc_html__( 'Features Page', 'thefour-lite' ),
		'section'         => 'thefour-lite',
		'type'            => 'dropdown-pages',
		'active_callback' => 'is_front_page',
		'description'     => wp_kses_post( __( 'The content of this page will be displayed below the hero area on your static front page.', 'thefour-lite' ) ),
	) );

	// Call to action section.
	$wp_customize->add_setting( 'front_page_cta', array(
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'front_page_cta', array(
		'label'           => esc_html__( 'Call To Action Section Content', 'thefour-lite' ),
		'section'         => 'thefour-lite',
		'type'            => 'textarea',
		'description'     => wp_kses_post( __( 'Use this section to display special offers for your products or services.', 'thefour-lite' ) ),
		'active_callback' => 'is_front_page',
	) );
	$wp_customize->selective_refresh->add_partial( 'front_page_cta', array(
		'selector'        => '.call-to-action.section',
		'render_callback' => 'thefour_customize_partial_cta',
	) );

	// Blog.
	$wp_customize->add_setting( 'front_page_blog_title', array(
		'default'           => esc_html__( 'Recent Posts', 'thefour-lite' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'front_page_blog_title', array(
		'label'           => esc_html__( 'Blog Section Title', 'thefour-lite' ),
		'section'         => 'thefour-lite',
		'type'            => 'text',
		'active_callback' => 'is_front_page',
	) );

	$wp_customize->add_setting( 'front_page_blog_number', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'thefour_validate_project_number',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'front_page_blog_number', array(
		'label'           => esc_html__( 'Number Of Blogs In blog Section', 'thefour-lite' ),
		'section'         => 'thefour-lite',
		'type'            => 'select',
		'choices'         => array(
			0 => esc_html__( 'Do not display blog section', 'thefour-lite' ),
			3 => 3,
			6 => 6,
			9 => 9,
		),
		'active_callback' => 'is_front_page',
	) );

	$wp_customize->selective_refresh->add_partial(
		'front_page_blog_number',
		array(
			'selector'            => '.blog',
			'container_inclusive' => true,
			'render_callback'     => 'thefour_refresh_blog_section',
		)
	);

	// Image section.
	$wp_customize->add_setting( 'front_page_image', array(
		'sanitize_callback' => 'thefour_sanitize_image',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'front_page_image',
		array(
			'label'           => esc_html__( 'Image', 'thefour-lite' ),
			'section'         => 'thefour-lite',
			'description'     => esc_html__( 'Displayed at the bottom of a static front page.', 'thefour-lite' ),
			'settings'        => 'front_page_image',
			'active_callback' => 'is_front_page',
		)
	) );
	$wp_customize->selective_refresh->add_partial( 'front_page_image', array(
		'selector'            => '.image.section img',
		'container_inclusive' => true,
		'render_callback'     => 'thefour_customize_partial_image_image',
	) );
	$wp_customize->add_setting( 'front_page_image_title', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'front_page_image_title', array(
		'label'           => esc_html__( 'Image Section Title', 'thefour-lite' ),
		'section'         => 'thefour-lite',
		'type'            => 'text',

		'active_callback' => 'is_front_page',
	) );
	$wp_customize->selective_refresh->add_partial( 'front_page_image_title', array(
		'selector'        => '.image.section h2',
		'render_callback' => 'thefour_customize_partial_image_title',
	) );

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'thefour_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'thefour_customize_partial_blogdescription',
	) );
}

add_action( 'customize_register', 'thefour_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function thefour_customize_preview_js() {
	wp_enqueue_script( 'thefour_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20161017', true );
}

add_action( 'customize_preview_init', 'thefour_customize_preview_js' );

/**
 * Image sanitization callback example.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 *
 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
 * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 *
 * @param string               $image Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 *
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
function thefour_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon',
	);
	// Return an array with file extension and mime_type.
	$file = wp_check_filetype( $image, $mimes );

	// If $image has a valid mime_type, return it; otherwise, return the default.
	return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Validation number of projects to show
 *
 * @param object $validity Validity object.
 * @param int    $value    The option value.
 *
 * @return object
 */
function thefour_validate_project_number( $validity, $value ) {
	$new_value = absint( $value );
	if ( $new_value != $value ) {
		$validity->add( 'invalid number', esc_html__( 'You must select valid number', 'thefour-lite' ) );
	}
	return $validity;
}


/**
 * Render the blog section title for the selective refresh partial.
 */
function thefour_customize_partial_blog_title() {
	echo esc_html( get_theme_mod( 'front_page_blog_title', __( 'Recent Posts', 'thefour-lite' ) ) );
}

/**
 * Render the call to action section title for the selective refresh partial.
 */
function thefour_customize_partial_cta() {
	echo wp_kses_post( do_shortcode( get_theme_mod( 'front_page_cta' ) ) );
}

/**
 * Render the image section title for the selective refresh partial.
 */
function thefour_customize_partial_image_title() {
	echo esc_html( get_theme_mod( 'front_page_image_title' ) );
}

/**
 * Render the image section image for the selective refresh partial.
 */
function thefour_customize_partial_image_image() {
	$image = get_theme_mod( 'front_page_image' );

	if ( ! $image ) {
		return;
	}

	$alt      = '';
	$image_id = function_exists( 'wpcom_vip_attachment_url_to_postid' ) ? wpcom_vip_attachment_url_to_postid( $image ) : attachment_url_to_postid( $image );
	if ( $image_id ) {
		$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	}
	printf( '<img src="%1$s" alt="%2$s">', esc_url( $image ), esc_attr( $alt ) );
}

/**
 * Render the site title for the selective refresh partial.
 */
function thefour_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function thefour_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Live refresh blog section.
 */
function thefour_refresh_blog_section() {
	get_template_part( 'template-parts/home/blog' );
}