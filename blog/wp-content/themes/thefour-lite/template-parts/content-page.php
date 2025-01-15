<?php
/**
 * The template used for displaying page.
 *
 * @package TheFour
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content clearfix">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'thefour-lite' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

</article>
