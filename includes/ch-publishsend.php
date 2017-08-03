<?php
add_action( 'publish_future_post', 'ch_send_future_post' );
function ch_send_future_post( $post_id ) {
	$options = get_option( 'tchannel_settings' );
	$channelslist = explode("+", $options['tchannel_channels']);
	if(is_array($channelslist)) {
		foreach ($channelslist as $channel) {		
			$channel_id = str_replace('@','',$channel);	
			$channel_id = 'tchannel_checktime_'.$channel_id;	
			$chk = get_post_meta ($post_id, $channel_id,true);
			if ($chk == 'on'){
				ch_sendmessage_publish ($post_id, $channel);
			}
		}
	}
}
function ch_sendmessage_publish($post_ID,$channel) {
	   $link = get_post_meta ($post_ID,'tchannel_link',true);
	   $keyboard = 'no';
	   if ($link == 'fullurl') {
		   $url = get_permalink($post_ID); 
	   } elseif ($link == 'shorturl') {
		   $url = wp_get_shortlink($post_ID);
	   } elseif ($link == 'glass') {
		   $url = wp_get_shortlink($post_ID);
		   $glass = get_post_meta ($post_ID,'tchannel_glass',true);
		   if ($glass == '') {
			   $glass = get_the_title($post_ID);
		   }
		   $keyboard = array(
					array( 
					array('text'=>$glass,'url'=>$url),
					),
				);
	   } elseif ($link == 'nourl') {
		   $url = '';
	   }
	   
	   $type = get_post_meta ($post_ID,'tchannel_select',true);
	   if ($type == 'contenttext'){
		    $content_post = get_post($post_ID);
			$content = $content_post->post_content;
			if ($link == 'glass') {
		   $message = $content;
			} else {
		   $message = $url.chr(10).$content;
			}
	   } elseif ($type == 'customtext'){
		   if ($link == 'glass') { 
		   $message = get_post_meta ($post_ID,'tchannel_text',true);
		   } else {
		   $message = $url.chr(10).get_post_meta ($post_ID,'tchannel_text',true);
		   }   
	   } 
	   $image = 'no';
		$media =  get_post_meta ($post_ID,'tchannel_media',true);
		if ($media == 'featured') {
			$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		} elseif ($media == 'custom') {
			$image = get_post_meta ($post_ID,'tchannel_image',true);
		} elseif ($media == 'video') {
			$video = get_post_meta ($post_ID,'tchannel_video',true);
			$videotime = get_post_meta ($post_ID,'tchannel_video_time',true);
			$image = 'video';
		} elseif ($media == 'audio') {
			$audio = get_post_meta ($post_ID,'tchannel_audio',true);
			$audiotime = get_post_meta ($post_ID,'tchannel_audio_time',true);
			$audioperformer = get_post_meta ($post_ID,'tchannel_audio_performer',true);
			$audiotitle = get_post_meta ($post_ID,'tchannel_audio_title',true);
			$image = 'audio';
		} elseif ($media == 'web') {
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
			$photo = get_post_meta ($post_ID,'tchannel_web',true);
			$image = media_sideload_image($photo, $post_ID, '', 'src'); 
		} elseif ($media == 'noimage') {
			$image = 'no';
		}
	
	$options = get_option( 'tchannel_settings' );
	$token = $options['tchannel_text_token'];
	
		if ($image == 'no') {
				$chat_id = $channel;
				channeller_sendmessagebot ($chat_id,$message,$message,$keyboard);
		} else {
			if ($image == 'video') {
				$logger =  $message.' <br />Video:'.$video;
				$chat_id = $channel;
				channeller_sendvideo($chat_id, $message, $video,$logger,$videotime);				
			} elseif ($image == 'audio') {
				$logger =  $message.' <br />Audio:'.$audio;
				$chat_id = $channel;
				channeller_sendaudio($chat_id, $message, $audio,$logger,$audiotime,$audioperformer,$audiotitle);				
			} else {
				$logger =  $message.' <br />image:'.$image;
				$chat_id = $channel;
				channeller_sendphoto($chat_id, $message, $image,$logger,$keyboard);
			}
		} 
}
?>