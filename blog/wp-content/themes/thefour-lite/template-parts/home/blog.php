<?php
/**
 * The template part for displaying latest blog posts in the frontend.
 *
 * @package TheFour
 */

$blog_number = get_theme_mod( 'front_page_blog_number', 6 );
if ( ! $blog_number ) {
	return;
}

$query = new WP_Query( array(
	'posts_per_page'      => $blog_number,
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
) );

if ( ! $query->have_posts() ) {
	return;
}
?>

<section class="section blog">

	<!-- <h2><?php echo esc_html( __( 'Recent Posts', 'thefour-lite' ) ); ?></h2> -->
	<h2><?php echo esc_html( get_theme_mod( 'front_page_blog_title', __( 'Recent Posts', 'thefour-lite' ) ) ); ?></h2>

	<div class="grid">
		<?php
		while ( $query->have_posts() ) : $query->the_post();
			get_template_part( 'template-parts/content', 'grid' );
		endwhile;
		wp_reset_postdata();
		?>
	</div>

</section>
