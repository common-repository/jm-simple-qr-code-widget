<?php
defined('ABSPATH') 
	or die('No!');

class JM_SQR_Widget extends WP_Widget {

	public $textdomain = 'jm-sqrw';
	
	// constructor
	function __construct() {
		$widget_ops = array('classname' => 'sqrw-widget', 'description' => __( 'This widget adds a QR Code to your posts', $this->textdomain ) );
		$control_ops = array();
		$this->WP_Widget( 'sqrw', __('QR CODE', $this->textdomain ) , $widget_ops, $control_ops );
		
	}


	// widget form creation
	function form($instance) {	
		
		$defaults = $this->get_defaults();
        $params   = wp_parse_args( $instance, $defaults );
		
		// Check values if( $instance) { 
		$title 	  = $instance ? esc_attr($instance['title']) : ''; 
		$alt 	  = $instance ? esc_attr($instance['alt']) : ''; 
		$ssl 	  = $instance ? $instance['ssl'] : 'no'; 
		
		//var_dump($params);
      ?>
		
		
		<!--
		
		 TITLE AND ALT
		
		
		
		-->
		
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', $this->textdomain); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		
		<p>
		<label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Alternative text for image', $this->textdomain); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo $alt; ?>" />
		</p>
		
		<!--
		
		
		chs
		
		
		-->
		
		<p>
		<label for="<?php echo $this->get_field_id('chs'); ?>"><?php _e('size of the square (max: 1000x1000px)', $this->textdomain); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('chs'); ?>" min="100" max="1000" name="<?php echo $this->get_field_name('chs'); ?>" type="number" value="<?php echo $params['chs']; ?>" />
		</p>
		
		<!--
		
		
		chld
		
		
		-->
		
		<p>
		<label for="<?php echo $this->get_field_id('chld'); ?>"><?php _e('Error connection code (chld)', $this->textdomain); ?></label>
		<select style="width:300px;" id="<?php echo $this->get_field_id('chld'); ?>" name="<?php echo $this->get_field_name('chld'); ?>">
			<option value="L" <?php selected($params['chld'], 'L'); ?>><?php _e('L (low, ~7% destroyed data may be corrected)',$this->textdomain);?> </option>
			<option value="M" <?php selected($params['chld'], 'M'); ?>><?php _e('M (middle, ~15% destroyed data may be corrected)',$this->textdomain);?> </option>
			<option value="Q" <?php selected($params['chld'], 'Q'); ?>><?php _e('Q (quality, ~25% destroyed data may be corrected)',$this->textdomain);?> </option>			
			<option value="H" <?php selected($params['chld'], 'H'); ?>><?php _e('H (high, ~30% destroyed data may be corrected)',$this->textdomain);?> </option>
		</select>
		</p>

		<!--
		
		
		https
		
		
		-->
		<p>
		<label for="<?php echo $this->get_field_id('ssl'); ?>"><?php _e('Enable SSL?', $this->textdomain); ?></label>
		<select style="width:300px;" id="<?php echo $this->get_field_id('ssl'); ?>" name="<?php echo $this->get_field_name('ssl'); ?>">
			<option value="yes" <?php selected($ssl, 'yes'); ?>><?php _e('Yes',$this->textdomain);?> </option>
			<option value="no" <?php selected($ssl, 'no'); ?>><?php _e('No',$this->textdomain);?> </option>
		</select>
		</p>
		
		
				
		<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
	  
	  $instance = $old_instance;
      // Fields
      $instance['title'] 	= strip_tags($new_instance['title']);
      $instance['ssl'] 		= (bool) $new_instance['ssl'];
      $instance['alt'] 		= strip_tags($new_instance['alt']);
	  $instance['chs'] 		= (int) $new_instance['chs'];
	  $instance['chld'] 	= $new_instance['chld'];
	  
	  $this->delete_cache();
	  
     return $instance;
	}

	// widget display
	function widget($args, $instance) {
	   extract( $args );
	   
	   global $post;
	   
	   if( !is_null( $post ) ) {
	   
		   echo $before_widget;
		   
		   
			   // Display the widget
			   echo '<!-- JM Simple QR Code Widget '.SQRW_VERSION.' -->'."\n";
			   echo '<div class="widget-text jm-sqrw">';
			   
			   $cached = get_site_transient( $post->ID.'_qr_code' );
				// Check if code exist in cache.
				if( $cached === false ) {
		 
				   // these are the widget options
				   $title 				= apply_filters('widget_title', $instance['title']);
				   $alt					= $instance['alt'];		
				   $ssl					= $instance['ssl'];			   
				   $chs					= $instance['chs'];
				   $chld				= $instance['chld'];
				   
				   ob_start();
						   // Check if title is set
				   if ( $title ) {
					  echo $before_title . $title . $after_title;
				   }
				   
				   $args = array(
					'chs' 				=>  $chs.'x'.$chs, // because the API works this way
					'chld' 				=>  $chld
				   ); 
				   
					$url = get_permalink();	
					   
					echo $this->get_qr_code_by_post_url( $url, $args, $alt, $ssl )."\n";
					
					echo '</div>';
				   
					$cached = ob_get_contents();
					ob_end_clean();
					

					// Add to cache for 1 day.
					set_site_transient( $post->ID.'_qr_code', $cached );
					
				}
			
		   echo $cached;
		   
		   echo '<!-- /JM Simple QR Code Widget '.SQRW_VERSION.' -->'."\n";	
			   
		   echo $after_widget;
		}

	}
	
	
	// get QR code by post URL
	public function get_qr_code_by_post_url( $url, $args = array(), $alt, $ssl = false )
	{
		
		$defaults 		= $this->get_defaults();
        $params   		= wp_parse_args( $args, $defaults );
        $params['chl']  = urlencode( $url );
        $params['cht']	= 'qr';

		$protocol = $ssl ? "https" : "http";
		$host   = "chart.googleapis.com";
		$qr_code_api = $protocol . ':' . '//' . $host . '/chart';
		
		$qr_api_call = add_query_arg( $params, $qr_code_api );
		$read = wp_remote_get( $qr_api_call  );
		 
		if( ! is_wp_error( $read  ) 
			&& isset( $read ['response']['code'] )        
			&& 200 == $read ['response']['code'] )
		{
			
			return '<img class="qr-code" src="' . $qr_api_call . '"  alt="' . $alt . '" />';
			
		} else {
		
			return $error = current_user_can('administrator') ? __('QR Code API is down or CURL is not enabled on server!', $this->textdomain) . ' ' . $qr_api_call  : '<!--' . __('Silence is gold !', $this->textdomain) . '-->';
		}
	}
	
	//default settings
	protected function get_defaults() {
	
		$defaults = array(
		'chs' 				=> '250',
		'chld' 				=> 'L',
		);
		
		return $defaults;
	}
	
	//when cache need to be deleted
	protected function delete_cache() {
		global $wpdb;
		$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE ('%_qr_code')");
		
    }


}