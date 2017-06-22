<?php
/**
 * Goedemorgen Theme Customizer.
 *
 * @package Goedemorgen
 */

// List all needed files for the Customizer.
$extensions_files = array(
    'sanitization-callbacks.php',
    'add-panels.php',
    'add-sections.php',
    'add-controls.php',
);

// Set path to Customizer extensions.
$extensions_path = get_template_directory() . '/inc/customizer/extensions/';

// Load Customizer files.
foreach ( $extensions_files as $file ) {
    require_once( $extensions_path . $file );
}

/**
 * Enqueue script for custom customize control.
 */
function goedemorgen_enqueue_custom_controls_js() {
    wp_enqueue_script( 'goedemorgen-customize-controls', get_template_directory_uri() . '/inc/customizer/js/customize-controls.js', array( 'customize-controls' ) );
}
add_action( 'customize_controls_enqueue_scripts', 'goedemorgen_enqueue_custom_controls_js', 0 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function goedemorgen_customize_preview_js() {
	wp_enqueue_script( 'goedemorgen-customize-preview', get_template_directory_uri() . '/inc/customizer/js/customize-preview.js', array( 'jquery', 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'goedemorgen_customize_preview_js' );
