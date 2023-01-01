<?php

/**
 * Setup Goggle fonts URL
 * todo: see if fonts from theme editor can be obtained
 * 
 * @return string
 */
function vb_fonts_url() {

	$fonts = array(
		'family=Figtree:ital,wght@0,400;0,700;1,400',
	);

	// Make a single request for all Google Fonts.
	return esc_url_raw( 'https://fonts.googleapis.com/css2?' . implode( '&', array_unique( $fonts ) ) . '&display=swap' );

}

/**
 * enqueue scripts
 *
 * @return void
 */
function vb_fonts() {

	$fonts = vb_fonts_url();

    wp_enqueue_style( 'google-fonts', $fonts, array(), null );
}
add_action( 'wp_enqueue_scripts', 'vb_fonts' );
add_action( 'enqueue_block_editor_assets', 'vb_fonts');


/**
 * Remove theme support
 *
 * @return void
 */
// function vb_remove_theme_support(){
// 	remove_theme_support('core-block-patterns');
// }
// add_action('init', 'vb_remove_theme_support');


/**
 * Register block pattern categories
 *
 * @return void
 */
function vb_register_my_pattern_categories() {
	register_block_pattern_category(
		'vbbpc',
		array( 'label' => __( 'Vacation Block', 'vb' ) )
	);
}
add_action( 'init', 'vb_register_my_pattern_categories' );


// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

	global $wp_version;
	if ( $wp_version !== '4.7.1' ) {
	   return $data;
	}
  
	$filetype = wp_check_filetype( $filename, $mimes );
  
	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];
  
  }, 10, 4 );
  
  function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
  }
  add_filter( 'upload_mimes', 'cc_mime_types' );
  
//   function fix_svg() {
// 	echo '<style type="text/css">
// 		  .attachment-266x266, .thumbnail img {
// 			   width: 100% !important;
// 			   height: auto !important;
// 		  }
// 		  </style>';
//   }
//   add_action( 'admin_head', 'fix_svg' );