<?php
class Columns{

    public function __construct(){
		add_filter('manage_posts_columns', array($this, 'ST4_columns_head'));
		add_action('manage_posts_custom_column', array($this, 'ST4_columns_content'), 10, 2);
		add_filter( 'manage_edit-post_sortable_columns', array($this, 'post_carousel_sortable_columns') );
		add_action( 'pre_get_posts', array($this, 'carousel_toggle_orderby') );

    }

	// Ajoute la nouvelle colonne dans l'affichage de tous les posts
	function ST4_columns_head($defaults) {
	    $defaults['post_carousel'] = 'Carousel';
	    return $defaults;
	}

	// Affiche la valeur du custom field pour chaque post.
	function ST4_columns_content($column_name, $post_ID) {
	    if ($column_name == 'post_carousel') {
			$meta_key = 'carousel_toggle';
			$meta_value = get_post_meta( $post_ID, $meta_key, true );
	        if ($meta_value == "on") {
	        	echo '<p>Activé</p>';
	        }
	    }
	}

	// Rend la colonne triable
	function post_carousel_sortable_columns( $sortable_columns ) {
	   $sortable_columns[ 'post_carousel' ] = 'post_carousel';
	   return $sortable_columns;
	}
	// Créé la requête pour n'afficher que les posts qui on le custom field Carousel activé
	function carousel_toggle_orderby( $query ) {
	    if( ! is_admin() )
	        return;
	    $orderby = $query->get( 'orderby');
	    if( 'post_carousel' == $orderby ) {
	        $query->set('meta_key','carousel_toggle');
	        $query->set( 'orderby', 'meta_value' );
	    }
	}

}
