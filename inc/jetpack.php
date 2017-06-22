<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 *
 * @package Goedemorgen
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function goedemorgen_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'goedemorgen_infinite_scroll_render',
		'footer'    => 'page',
		'wrapper'	=> false,
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'goedemorgen_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function goedemorgen_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'components/post/content', 'search' );
		else :
			get_template_part( 'components/post/content' );
		endif;
	}
}

/**
 * Return early if Author Bio is not available.
 */
function goedemorgen_author_bio() {
	if ( ! function_exists( 'jetpack_author_bio' ) ) {
		get_template_part( 'components/post/author', 'section' );
	} else {
		jetpack_author_bio();
	}
}

/**
 * Author Bio Avatar Size.
 */
function goedemorgen_author_bio_avatar_size() {
	return 352;
}
add_filter( 'jetpack_author_bio_avatar_size', 'goedemorgen_author_bio_avatar_size' );
