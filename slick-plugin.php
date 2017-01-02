<?php
/*
Plugin Name: Slick Plugin
Plugin URI: http://www.romain-breton.com
Description: Un plugin permettant l'utilisation de slick
Version: 0.1
Author: Romain Breton
Author URI: http://www.romain-breton.com
License: GPL2
*/
include_once plugin_dir_path( __FILE__ ).'inc/SCA_enqueue-styles.php';
include_once plugin_dir_path( __FILE__ ).'inc/SCA_meta-box.php';
include_once plugin_dir_path( __FILE__ ).'inc/SCA_columns.php';
include_once plugin_dir_path( __FILE__ ).'inc/SCA_shortcode.php';
include_once plugin_dir_path( __FILE__ ).'inc/SCA_widget.php';

class SCA_Plugin{
	public function __construct(){
		// Enable the use of shortcodes in text widgets.
		add_filter( 'widget_text', 'do_shortcode' );
		new SCA_Enqueue_Styles();
		// new Meta_Box();
		new SCA_Columns();
		new SCA_Shortcode();
		new SCA_Widget();
		add_action('widgets_init', function(){register_widget('SCA_Widget');});
	}
}
new SCA_Plugin();

// Setup meta box on post editor screen
add_action( 'load-post.php', 'SCA_carousel_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'SCA_carousel_post_meta_boxes_setup' );
/* Save post meta on the 'save_post' hook. */
add_action( 'save_post', 'SCA_carousel_save_post_class_meta', 10, 2 );
/* Meta box setup function. */
function SCA_carousel_post_meta_boxes_setup() {
  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'SCA_carousel_add_post_meta_boxes' );
  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 'SCA_carousel_save_post_class_meta', 10, 2 );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function SCA_carousel_add_post_meta_boxes() {
  add_meta_box(
    'article-in-carousel',      // Unique ID
    esc_html__( 'Carousel', 'example' ),    // Title
    'SCA_carousel_post_class_meta_box',   // Callback function
    'post',         // Admin page (or post type)
    'side',         // Context
    'high'         // Priority
  );
}

/* Display the post meta box. */
function SCA_carousel_post_class_meta_box( $object, $box ) {
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'article_carousel_post_class_nonce' );
	/* Check if the current user has permission to edit the post. */
	$post_id = $post->ID;
	/* Get the meta key. */
	$meta_key = 'carousel_toggle';
	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );
	$checked = $meta_value == "on" ?  "checked" : "";
	echo'<p>'. _e( "Ajouter l'article dans le carousel", "example" ).'</p>
	<div class="checkbox-carousel-class"><input type="checkbox" class="tgl tgl-ios" id="carousel_toggle" name="carousel_toggle" '. $checked.'><label class="tgl-btn" for="carousel_toggle"></label></div>';
}

////////////////////////////////////////////////////////////////////////////////
add_action( 'bulk_edit_custom_box', 'SCA_article_quick_edit_custom_box', 10, 2 );
add_action( 'quick_edit_custom_box', 'SCA_article_quick_edit_custom_box', 10, 2 );
function SCA_article_quick_edit_custom_box( $column_name, $post_type ) {
   switch ( $post_type ) {
      case 'post':
         switch( $column_name ) {
            case 'post_carousel':
               SCA_carousel_post_class_meta_box();
               break;
         }
         break;
   }
}


///////////////////////////////////////////////////////////////////////////////////
// Créer le meta box
///////////////////////////////////////////////////////////////////////////////////
/* Save the meta box's post metadata. */
function SCA_carousel_save_post_class_meta( $post_id, $post ) {
  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['article_carousel_post_class_nonce'] ) || !wp_verify_nonce( $_POST['article_carousel_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;
  $post_type = get_post_type_object( $post->post_type );
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;
  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['carousel_toggle'] ) ? sanitize_html_class( $_POST['carousel_toggle'] ) : '' );
  $meta_key = 'carousel_toggle';

  $meta_value = get_post_meta( $post_id, $meta_key, true );
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}

/* Filter the post class hook with our custom post class function. */
add_filter( 'post_class', 'SCA_carousel_toggle' );
function SCA_carousel_toggle( $classes ) {
  $post_id = get_the_ID();
  if ( !empty( $post_id ) ) {
    $post_class = get_post_meta( $post_id, 'carousel_toggle', true );
    /* If a post class was input, sanitize it and add it to the post class array. */
    if ( !empty( $post_class ) )
      $classes[] = sanitize_html_class( $post_class );
  }
  return $classes;
}
