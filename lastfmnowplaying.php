<?php
/*
Plugin Name: LastFM Now Playing
Plugin URI: http://fridayanabaabullah.wordpress.com
Description: Display current recent track
Author: Fridayana Baabullah
Version: 1.0.3
Author URI: http://fridayanabaabullah.wordpress.com
*/

class LastFmNowPlaying_Widget extends WP_Widget {
	
	/**
	 * Process the widget
	 */
	function LastFmNowPlaying_Widget () {
		$widget_ops = array (
			'classname' => 'lastfmnowplaying_class',
			'description' => 'Display current recent track'
		);
		
		$this->WP_Widget('LastFmNowPlaying_Widget', 'LastFM Now Playing',
			$widget_ops
		);
	}
	
	/**
	 * Display the widget form in the admin dashboard
	 */
	function form ($instance) {
		$defaults = array (
			'title' => 'Now Playing',
			'username' => 'baabullah',
			'limit' => 10,
			'interval' => 5,
			'width' => 164
		);
		
		$instance = wp_parse_args ( (array) $instance, $defaults);
		
		$title = $instance['title'];
		$username = $instance['username'];
		$limit = $instance['limit'];
		$interval = $instance['interval'];
		$width = $instance['width'];
		?>
		
		<p>Widget Title: <input class="widefat" name="<?php echo $this->get_field_name ('title'); ?>" type="text" value="<?php echo esc_attr ($title); ?>" /></p>
		<p>LastFM Username: <input class="widefat" name="<?php echo $this->get_field_name ('username'); ?>" type="text" value="<?php echo esc_attr ($username); ?>" /></p>
		<p>Song Limit: <input class="widefat" name="<?php echo $this->get_field_name ('limit'); ?>" type="text" value="<?php echo esc_attr ($limit); ?>" /></p>
		<p>Refresh Interval (in minute): <input class="widefat" name="<?php echo $this->get_field_name ('interval'); ?>" type="text" value="<?php echo esc_attr ($interval); ?>" /></p>
		<p>Image Width (if your template doesnt provide jQuery): <input class="widefat" name="<?php echo $this->get_field_name ('width'); ?>" type="text" value="<?php echo esc_attr ($width); ?>" /></p>
		
		<?php
	}
	
	/**
	 * Process widget options to save
	 */
	function update ($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags ($new_instance['title']);
		$instance['username'] = strip_tags ($new_instance['username']);
		$instance['limit'] = (int) strip_tags ($new_instance['limit']);
		$instance['interval'] = (int) strip_tags ($new_instance['interval']);
		$instance['width'] = (int) strip_tags ($new_instance['width']);
		
		return $instance;
	}
	
	/**
	 * Display the widget
	 */
	function widget ($args, $instance) {
		extract ($args);
		
		echo $before_widget;
		$title = apply_filters ('widget_title', $instance['title']);
		$username = empty ($instance['username']) ? '&nbsp;' : $instance['username'];
		$limit = empty ($instance['limit']) ? '10' : $instance['limit'];
		$interval = empty ($instance['interval']) ? '5' : $instance['interval'];
		$width = empty ($instance['width']) ? '164' : $instance['width'];
		
		if (!empty ($title)) {
			echo $before_title . $title . $after_title;
		}
		$div_id = 'lastfmnowplaying_' . time();
		echo '<div id="'. $div_id .'">Loading tracks..</div>';
		?>

<script type="text/javascript">
	try {
		if (jQuery) {
			jQuery(document).ready(function () {
				lastfmnowplaying_reloadTrack('<?php echo $div_id; ?>');
				setInterval("lastfmnowplaying_reloadTrack('<?php echo $div_id; ?>')", <?php echo $interval; ?> * 60000);
			});
		}
	} catch (Exception) {
		var theDiv = document.getElementById('<?php echo $div_id ?>');
		if (theDiv) {
			theDiv.innerHTML = '<img alt="LastFM Now Playing" src="http://play.eprofile.web.id/lastfm/lastfm.php?output=image&username=<?php echo $username; ?>&width=<?php echo $width ?>"/>';
		}
	}
	
	function lastfmnowplaying_reloadTrack(div_id) {
		if (jQuery) {			
			var url = 'http://play.eprofile.web.id/lastfm/lastfm.php?username=<?php echo $username; ?>&limit=<?php echo $limit; ?>';
			jQuery.ajax({
				url : url,
				dataType : 'jsonp',
				success : function (data) {
					var $div = jQuery('#' + div_id);
					
					$div.fadeOut(function () {
						
						$div.html('');
						
						var listhtml = '<ul>';
						var tracks = data.recenttracks.track;
						for (var i=0; i < tracks.length; i++) {
							if (i == 0) {
								listhtml += '<li class="lastfmnowplaying_playing"><span class="lastfmnowplaying_artist_name">' + tracks[i].artist['#text'] + '</span> - <span class="lastfmnowplaying_song_name">' + tracks[i].name + '</span>';
							}
							else {
								listhtml += '<li><span class="lastfmnowplaying_artist_name">' + tracks[i].artist['#text'] + '</span> - <span class="lastfmnowplaying_song_name">' + tracks[i].name + '</span>';
							}
						}
						listhtml += '</ul>';
						
						$div.html(listhtml);
						$div.fadeIn();
					});
					
				}
			});
		}
	}
</script>
		
		<?php
				
		echo $after_widget;
	}
}

add_action ('widgets_init', 'lastfmnowplaying_widgets_init');
function lastfmnowplaying_widgets_init () {
	register_widget ('LastFmNowPlaying_Widget');
}
