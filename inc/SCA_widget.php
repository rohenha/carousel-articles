<?php
class SCA_Widget extends WP_Widget {

	public function __construct(){
		parent::__construct('slider-articles', 'Slider d\'articles', array('description' => 'Un slider pour afficher un slider avec les articles'));
	}

	public function widget($args, $instance){
		echo do_shortcode('[carousel-posts
		slide_to_show='.$instance['slide_to_show'].'
		slide_to_scroll='.$instance['slide_to_scroll'].'
		autoplay='.$instance['autoplay'].'
		autoplay_speed='.$instance['autoplay_speed'].'
		center_mode='.$instance['center_mode'].'
		arrows='.$instance['arrows'].'
		center_padding='.$instance['center_padding'].'
		infinite='.$instance['infinite'].'
		dots='.$instance['dots'].'
		adaptiveHeight='.$instance['adaptiveHeight'].'
		speed='.$instance['speed'].'
		variableWidth='.$instance['variableWidth'].'
		 ]');
	}

	public function form($instance){
		$slide_to_show = isset($instance['slide_to_show']) ? $instance['slide_to_show'] : '';
		$slide_to_scroll = isset($instance['slide_to_scroll']) ? $instance['slide_to_scroll'] : '';
		$autoplay = isset($instance['autoplay']) ? $instance['autoplay'] : '';
		$autoplay_speed = isset($instance['autoplay_speed']) ? $instance['autoplay_speed'] : '';
		$center_mode = isset($instance['center_mode']) ? $instance['center_mode'] : '';
		$arrows = isset($instance['arrows']) ? $instance['arrows'] : '';
		$infinite = isset($instance['infinite']) ? $instance['infinite'] : '';
		$dots = isset($instance['dots']) ? $instance['dots'] : '';
		$adaptiveHeight = isset($instance['adaptiveHeight']) ? $instance['adaptiveHeight'] : '';
		$speed = isset($instance['speed']) ? $instance['speed'] : '';
		$variableWidth = isset($instance['variableWidth']) ? $instance['variableWidth'] : '';
		$center_padding = isset($instance['center_padding']) ? $instance['center_padding'] : '';

		echo "<div><p>Slide to Show</p><input class='widefat' id='".$this->get_field_id('slide_to_show')."' name='".$this->get_field_name('slide_to_show')."' type='number' value='".$slide_to_show."'/></div>";
		echo "<div><p>Slide to Scroll</p><input class='widefat' id='".$this->get_field_id('slide_to_scroll')."' name='".$this->get_field_name('slide_to_scroll')."' type='number' value='".$slide_to_scroll."'/></div>";
		$checked = $autoplay == "on" ?  "checked" : "";
		echo "<div><p>Autoplay</p><div class='checkbox-carousel-class'><input type='checkbox' class='tgl tgl-ios' id='".$this->get_field_id('autoplay')."' name='".$this->get_field_name('autoplay')."' ".$checked."><label class='tgl-btn' for='".$this->get_field_name('autoplay')."'></label></div></div>";
		echo "<div><p>Autoplay Speed</p><input class='widefat' id='".$this->get_field_id('autoplay_speed')."' name='".$this->get_field_name('autoplay_speed')."' type='text' value='".$autoplay_speed."'/></div>";
		$checked = $center_mode == "on" ?  "checked" : "";
		echo "<div><p>Center Mode</p><div class='checkbox-carousel-class'><input type='checkbox' class='tgl tgl-ios' id='".$this->get_field_id('center_mode')."' name='".$this->get_field_name('center_mode')."' ".$checked."><label class='tgl-btn' for='".$this->get_field_name('center_mode')."'></label></div></div>";
		echo "<div><p>Center Padding</p><input class='widefat' id='".$this->get_field_id('center_padding')."' name='".$this->get_field_name('center_padding')."' type='number' value='".$center_padding."'/></div>";
		$checked = $arrows == "on" ?  "checked" : "";
		echo "<div><p>Arrows</p><div class='checkbox-carousel-class'><input type='checkbox' class='tgl tgl-ios' id='".$this->get_field_id('arrows')."' name='".$this->get_field_name('arrows')."' ".$checked."><label class='tgl-btn' for='".$this->get_field_name('arrows')."'></label></div></div>";
		echo "<div><p>Speed</p><input class='widefat' id='".$this->get_field_id('speed')."' name='".$this->get_field_name('speed')."' type='number' value='".$speed."'/></div>";
		$checked = $infinite == "on" ?  "checked" : "";
		echo "<div><p>Infinite</p><div class='checkbox-carousel-class'><input type='checkbox' class='tgl tgl-ios' id='".$this->get_field_id('infinite')."' name='".$this->get_field_name('infinite')."' ".$checked."><label class='tgl-btn' for='".$this->get_field_name('infinite')."'></label></div></div>";
		$checked = $dots == "on" ?  "checked" : "";
		echo "<div><p>Dots</p><div class='checkbox-carousel-class'><input type='checkbox' class='tgl tgl-ios' id='".$this->get_field_id('dots')."' name='".$this->get_field_name('dots')."' ".$checked."><label class='tgl-btn' for='".$this->get_field_name('dots')."'></label></div></div>";
		$checked = $adaptiveHeight == "on" ?  "checked" : "";
		echo "<div><p>Adaptive Height</p><div class='checkbox-carousel-class'><input type='checkbox' class='tgl tgl-ios' id='".$this->get_field_id('adaptiveHeight')."' name='".$this->get_field_name('adaptiveHeight')."' ".$checked."><label class='tgl-btn' for='".$this->get_field_name('adaptiveHeight')."'></label></div></div>";
		$checked = $variableWidth == "on" ?  "checked" : "";
		echo "<div><p>Variable Width</p><div class='checkbox-carousel-class'><input type='checkbox' class='tgl tgl-ios' id='".$this->get_field_id('variableWidth')."' name='".$this->get_field_name('variableWidth')."' ".$checked."><label class='tgl-btn' for='".$this->get_field_name('variableWidth')."'></label></div></div>";

	}
}
