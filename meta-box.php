<?php
class Meta_Box{

    public function __construct(){
		// Setup meta box on post editor screen
		add_action( 'load-post.php', array($this, 'article_carousel_post_meta_boxes_setup') );
		add_action( 'load-post-new.php', array($this, 'article_carousel_post_meta_boxes_setup') );
		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', array($this, 'carousel_save_post_class_meta'), 10, 2 );
		add_action( 'bulk_edit_custom_box', array($this, 'carousel_quick_edit_custom_box'), 1000, 2 );
		add_action( 'quick_edit_custom_box', array($this, 'carousel_quick_edit_custom_box'), 1000, 2 );
		add_filter( 'post_class', array($this, 'carousel_toggle') );

    }

	/* Meta box setup function. */
	function article_carousel_post_meta_boxes_setup() {
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'article_carousel_add_post_meta_boxes' );
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'carousel_save_post_class_meta', 10, 2 );
	}

	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function article_carousel_add_post_meta_boxes() {
	  add_meta_box(
	    'article-in-carousel',      // Unique ID
	    esc_html__( 'Carousel', 'example' ),    // Title
	    'article_carousel_post_class_meta_box',   // Callback function
	    'post',         // Admin page (or post type)
	    'side',         // Context
	    'high'         // Priority
	  );
	}

	/* Display the post meta box. */
	function article_carousel_post_class_meta_box( $object, $box ) {
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
		<p>Post ID : '.$post_id.'</p>
		<p>Meta Key : '.$meta_key.'</p>
		<p>Meta Value : '.$meta_value.'</p>
		<p>Checked : '.$checked.'</p>
		<div class="checkbox-carousel-class">
			<input type="checkbox" class="tgl tgl-ios" id="carousel_toggle" name="carousel_toggle" '. $checked.'>
			<label class="tgl-btn" for="carousel_toggle"></label>
		</div>';
	}

	////////////////////////////////////////////////////////////////////////////////
	function carousel_quick_edit_custom_box( $column_name, $post_type ) {
	   switch ( $post_type ) {
	      case 'post':
	         switch( $column_name ) {
	            case 'post_carousel':
	               article_carousel_post_class_meta_box();
	               break;
	         }
	         break;
	   }
	}


	///////////////////////////////////////////////////////////////////////////////////
	// Créer le meta box
	///////////////////////////////////////////////////////////////////////////////////
	/* Save the meta box's post metadata. */
	function carousel_save_post_class_meta( $post_id, $post ) {
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
	function carousel_toggle( $classes ) {
	  $post_id = get_the_ID();
	  if ( !empty( $post_id ) ) {
	    $post_class = get_post_meta( $post_id, 'carousel_toggle', true );
	    /* If a post class was input, sanitize it and add it to the post class array. */
	    if ( !empty( $post_class ) )
	      $classes[] = sanitize_html_class( $post_class );
	  }
	  return $classes;
	}
}
