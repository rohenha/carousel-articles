<?php
class Shortcode{

	public function __construct(){
		add_shortcode('carousel-posts', array($this, 'create_carousel_posts'));
	}

	public function create_carousel_posts($atts, $content){
		// Attributes
		$atts = shortcode_atts(
			array(
				'slide_to_show' => 1,
				'slide_to_scroll' => 3,
				'autoplay' => false,
				'autoplay_speed' => 2000,
				'center_mode' => false,
				'arrows' => false,
				'center_padding' => 60,
				'infinite' => false,
				'dots' => false,
				'adaptiveHeight' => false,
				'speed' => 400,
				'variableWidth' => false,
			),
			$atts
		);
		$autoplay = $atts["autoplay"] == "on" ?  "true" : "false";
		$arrows = $atts["arrows"] == "on" ?  "true" : "false";
		$center_mode = $atts["center_mode"] == "on" ?  "true" : "false";
		$infinite = $atts["infinite"] == "on" ?  "true" : "false";
		$dots = $atts["dots"] == "on" ?  "true" : "false";
		$adaptiveHeight = $atts["adaptiveHeight"] == "on" ?  "true" : "false";
		$variableWidth = $atts["variableWidth"] == "on" ?  "true" : "false";
		?>
		<ul class="carousel-articles" data-slick='{
			"slidesToShow": <?php echo $atts["slide_to_show"];?>,
			"slidesToScroll": <?php echo $atts["slide_to_scroll"];?>,
			"autoplay" : <?php echo $autoplay ;?>,
			"autoplaySpeed" : <?php echo $atts["autoplay_speed"];?>,
			"centerMode" : <?php echo $center_mode;?>,
			"centerPadding" : "<?php echo $atts["center_padding"];?>px",
			"arrows" : <?php echo $arrows;?>,
			"infinite" : <?php echo $infinite;?>,
			"dots" : <?php echo $dots;?>,
			"adaptiveHeight" : <?php echo $adaptiveHeight;?>,
			"speed" : <?php echo $atts["speed"]; ?>,
			"variableWidth" : <?php echo $variableWidth;?>
		}'>
		<?php
		$args = array(
			'post_type' => 'post',
			'orderby'   => 'meta_value',
			'meta_key'  => 'carousel_toggle',
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				echo '<li><a href="'.get_permalink($post->ID).'">
				<img src="'.wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0].'"/>
				<h3>' . get_the_title( $query->post->ID ) . '</h3>
				</a></li>';
			}
			wp_reset_postdata();
		}
		echo '</ul>';
	}
}
