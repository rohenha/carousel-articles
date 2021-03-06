<?php
class SCA_Enqueue_Styles{

    public function __construct(){
		add_action( 'wp_enqueue_scripts', array($this, 'SCA_enqueue_styles'), 1000 );
		add_action('admin_head', array($this, 'SCA_admin_css'), 1000);
    }

	// Scripts and styles added in the hader and the footer of the page
	public function SCA_enqueue_styles() {
		wp_enqueue_style( 'slick',  plugin_dir_url( __FILE__ ) . '../css/slick.css' );
		wp_enqueue_style( 'slick-theme',  plugin_dir_url( __FILE__ ) . '../css/slick-theme.css' );
		wp_enqueue_script( 'slick', plugin_dir_url( __FILE__ ) . '../js/slick.min.js' ,  '' ,  '' ,  true);
		wp_enqueue_script( 'slick-js', plugin_dir_url( __FILE__ ) . '../js/app.js' ,  '' ,  '' ,  true);
	}

	// Input style added in admin panel
	public function SCA_admin_css() {
		wp_enqueue_style( 'input',  plugin_dir_url( __FILE__ ) . 'css/input.css' );
	}

}
