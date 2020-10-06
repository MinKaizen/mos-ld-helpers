<?php

/**
 * Plugin Name: MOS Learndash Helpers
 * Description: Helper functions and shortcodes for LearnDash
 */


// Check for wordpress environment
if ( !defined( 'WPINC' ) ) {
  die;
}

// // Check for LearnDash plugin
// if ( !defined( 'LEARNDASH_VERSION' ) ) {
//   return;
// }

require_once( 'classes/MosLdHelpersPlugin.php' );

if ( class_exists( 'MosLdHelpersPlugin' ) ) {
  $mos_ld_helpers_plugin = new MosLdHelpersPlugin( __FILE__ );
  $mos_ld_helpers_plugin->init();
}