<?php
add_action( 'add_meta_boxes', 'tchannel_meta_box_add' );
function tchannel_meta_box_add()
{
$options = get_option( 'tchannel_settings' );
$args = array('public'   => true);
$output = 'names'; // names or objects, note names is the default
$operator = 'and'; // 'and' or 'or'
$post_types = get_post_types( $args, $output, $operator ); 
foreach ( $post_types  as $post_type ) {
	if ($post_type == 'attachment' || $post_type == 'subscriber') {} else {
		if (array_key_exists('tchannel_'.$post_type,$options)) {
			$option = $options['tchannel_'.$post_type];
		if ($option == $post_type) {
		add_meta_box( 'tchannel-meta-box', __('Channeller', 'tchannel'), 'tchannel_meta_box_cb', $post_type, 'side', 'high' );
		}
		}
	}
}
}

function tchannel_meta_box_cb( $post )
{
	$options = get_option( 'tchannel_settings' );
	$values = get_post_custom( $post->ID );
	$text = isset( $values['tchannel_text'] ) ? esc_attr( $values['tchannel_text'][0] ) : '';
	$selected = isset( $values['tchannel_select'] ) ? esc_attr( $values['tchannel_select'][0] ) : $options['tchannel_message_text'];
	$selectedlink = isset( $values['tchannel_link'] ) ? esc_attr( $values['tchannel_link'][0] ) : $options['tchannel_link_type'];
	$selectedimage = isset( $values['tchannel_media'] ) ? esc_attr( $values['tchannel_media'][0] ) : $options['tchannel_media'];
	wp_nonce_field( 'tchannel_nonce', 'meta_box_nonces' );
	
	?>
	<div class="telechannel">
	<p style="border-bottom: 3px solid #0A7CB5;padding-bottom: 10px;">
	<?php
	 printf(__( 'Send to Channels.', 'tchannel' )); 
	 echo '<br/>';
		$options = get_option( 'tchannel_settings' );
		$checked = '';
		if (array_key_exists('tchannel_post_checkbox',$options)) {
			if ($options['tchannel_post_checkbox'] == 'yes') {
				$checked = ' checked';
			}
		}
		$channelslist = explode("+", $options['tchannel_channels']);
		if(is_array($channelslist)) {
			foreach ($channelslist as $channel) {
			$channel_id = str_replace('@','',$channel);				
			echo $channel_id;
			echo '<span style="color:green;font-size:9px">'.get_site_option( '@'.$channel_id ).'</span></br>';
			$channel_timeid = 'tchannel_checktime_'.$channel_id;	
			$channel_timeid = get_post_meta ($post->ID, $channel_timeid,true);
			$checkedtime = '';
				if ($channel_timeid == 'on'){
							$checkedtime = ' checked';
				}
			?>
				<input type="checkbox" name="tchannel_check_<?php echo $channel_id; ?>"<?php echo $checked; ?> id="tchannel_check_<?php echo $channel_id; ?>" />
				<label for="tchannel_check_<?php echo $channel_id; ?>"><?php printf(__( 'Now', 'tchannel' ));?></label><br/>
				<input type="checkbox" name="tchannel_checktime_<?php echo $channel_id; ?>"<?php echo $checkedtime; ?> id="tchannel_checktime_<?php echo $channel_id; ?>" />
				<label for="tchannel_checktime_<?php echo $channel_id; ?>"><?php printf(__( 'Future', 'tchannel' ));?></label><br/>
			<?php
			}
		}
		if (!$options['tchannel_groups'] == '') {
		echo '<br/>';
		printf(__( 'Send to Groups', 'tchannel' )); 
		echo '<br/>';
		$groupslist = explode("+", $options['tchannel_groups']);
		if(is_array($groupslist)) {
			foreach ($groupslist as $group) {
			$grouper = str_replace('+','',$group);	
			$groupdata = explode("/", $grouper);
			$group_id = $groupdata[0];
			$group_name = $groupdata[1];
			?>
				<input type="checkbox" name="tchannel_checks_<?php echo $group_name; ?>" id="tchannel_checks_<?php echo $group_name; ?>" />
				<label for="tchannel_checks_<?php echo $group_name; ?>"><?php echo $group_name;?></label><br/>
			<?php
			}
		}			
		}

	?>
	</p>
	<p>
		<label for="tchannel_link"><?php printf(__( 'Link Type', 'tchannel' )); ?></label>
		<select name="tchannel_link" id="tchannel_link">
			<option value="fullurl" <?php selected( $selectedlink, 'url' ); ?>><?php printf(__( 'Full URL', 'tchannel' )); ?></option>
			<option value="shorturl" <?php selected( $selectedlink, 'shorturl' ); ?>><?php printf(__( 'Short URL', 'tchannel' )); ?></option>
			<option value="glass" <?php selected( $selectedlink, 'glass' ); ?>><?php printf(__( 'Glass Button', 'tchannel' )); ?></option>
			<option value="nourl" <?php selected( $selectedlink, 'nourl' ); ?>><?php printf(__( 'No URL', 'tchannel' )); ?></option>
		</select>
	</p>
	<p class="glassboxchannel"<?php if($selectedlink == 'glass' ) {} else {echo ' style="display:none;"';} ?>>
		<input id="tchannel_glass" type="text" size="20" name="tchannel_glass" placeholder="<?php printf(__( 'Glass Button Text', 'tchannel' )); ?>" />
	</p>
	<p>
		<label for="tchannel_select"><?php printf(__( 'Message Text', 'tchannel' )); ?></label>
		<select name="tchannel_select" id="tchannel_select">
			<option value="contenttext" <?php selected( $selected, 'contenttext' ); ?>><?php printf(__( 'Post Content', 'tchannel' )); ?></option>
			<option value="customtext" <?php selected( $selected, 'customtext' ); ?>><?php printf(__( 'Custom Message', 'tchannel' )); ?></option>
		</select>
	</p>


	<p class="textboxchannel"<?php if($selected == 'customtext' ) {} else {echo ' style="display:none;"';} ?>>
		<label for="tchannel_text" style="display: block;"><?php printf(__( 'Custom Message', 'tchannel' )); ?></label>
		<textarea style="width: 99%;"rows="3" onkeyup="countChar(this)" name="tchannel_text" id="tchannel_text"><?php echo $text; ?></textarea>
		<?php printf(__( 'Characters Limit: ', 'tchannel' )); ?><span id="charNum">4096</span>
	</p>
	<p>
		<label for="tchannel_media"><?php printf(__( 'Media', 'tchannel' )); ?></label>
		<select name="tchannel_media" id="tchannel_media">
			<option value="featured" <?php selected( $selectedimage, 'featured' ); ?>><?php printf(__( 'Featured Image', 'tchannel' )); ?></option>
			<option value="custom" <?php selected( $selectedimage, 'custom' ); ?>><?php printf(__( 'Custom Image', 'tchannel' )); ?></option>
			<option value="web" <?php selected( $selectedimage, 'web' ); ?>><?php printf(__( 'From Web', 'tchannel' )); ?></option>
			<option value="noimage" <?php selected( $selectedimage, 'noimage' ); ?>><?php printf(__( 'No Image', 'tchannel' )); ?></option>
			<option value="video" <?php selected( $selectedimage, 'video' ); ?>><?php printf(__( 'Video', 'tchannel' )); ?></option>
			<option value="audio" <?php selected( $selectedimage, 'audio' ); ?>><?php printf(__( 'Audio', 'tchannel' )); ?></option>
		</select>
	</p>
	<p class="imageboxchannel"<?php if($selectedimage == 'custom' ) {} else {echo ' style="display:none;"';} ?>>
		<input id="tchannel_image" type="text" size="20" name="tchannel_image" placeholder="<?php printf(__( 'Custom Image', 'tchannel' )); ?>" />
		<input id="upload_image_button" type="button" value="<?php printf(__( 'Upload Image', 'tchannel' )); ?>" /><br />
	</p>
	<p class="imageboxvideo"<?php if($selectedimage == 'video' ) {} else {echo ' style="display:none;"';} ?>>
		<input id="tchannel_video" type="text" size="20" name="tchannel_video" placeholder="<?php printf(__( 'Video', 'tchannel' )); ?>" />
		<input id="tchannel_video_time" type="text" size="20" name="tchannel_video_time" placeholder="<?php printf(__( 'Video Time (mm:ss)', 'tchannel' )); ?>" />
		<input id="upload_video_button" type="button" value="<?php printf(__( 'Upload Video', 'tchannel' )); ?>" /><br />
	</p>
	<p class="imageboxaudio"<?php if($selectedimage == 'audio' ) {} else {echo ' style="display:none;"';} ?>>
		<input id="tchannel_audio" type="text" size="20" name="tchannel_audio" placeholder="<?php printf(__( 'Audio', 'tchannel' )); ?>" />
		<input id="tchannel_audio_time" type="text" size="20" name="tchannel_audio_time" placeholder="<?php printf(__( 'Audio Time (mm:ss)', 'tchannel' )); ?>" />
		<input id="tchannel_audio_performer" type="text" size="20" name="tchannel_audio_performer" placeholder="<?php printf(__( 'Audio Performer', 'tchannel' )); ?>" />
		<input id="tchannel_audio_title" type="text" size="20" name="tchannel_audio_title" placeholder="<?php printf(__( 'Audio Title', 'tchannel' )); ?>" />
		<input id="upload_audio_button" type="button" value="<?php printf(__( 'Upload Audio', 'tchannel' )); ?>" /><br />
	</p>
	<p class="imageboxweb"<?php if($selectedimage == 'web' ){} else {echo ' style="display:none;"';} ?>>
		<input id="tchannel_web" type="text" size="20" name="tchannel_web" placeholder="<?php printf(__( 'Url From the Web', 'tchannel' )); ?>" />
		<?php printf(__( 'Uploads file to your server ', 'tchannel' )); ?>
	</div>
	<style>
	.telechannel input[type=text],.telechannel select,.telechannel textarea {width:100%;margin-top:5px;}
	input#upload_image_button,input#upload_video_button,input#upload_audio_button {
    margin-top: 5px;
    width: 100%;
    border: none;
    background-color: #0A7CB5;
    color: #fff;
    padding: 10px;
    cursor: pointer;
    margin-bottom: 10px;
}
	</style>
	 <script>
      function countChar(val) {
        var len = val.value.length;
        if (len >= 4096) {
          val.value = val.value.substring(0, 4096);
        } else {
          jQuery('#charNum').text(4096 - len);
        }
      };
	  jQuery('#tchannel_select').change(function(){
		 text = jQuery(this).val();
		 if (text=='customtext' ) {
			 jQuery('.textboxchannel').show("slow");
		 } else {
			  jQuery('.textboxchannel').hide("slow");
		 }
	  })
	  jQuery('#tchannel_link').change(function(){
		 text = jQuery(this).val();
		 if (text=='glass' ) {
			 jQuery('.glassboxchannel').show("slow");
		 } else {
			  jQuery('.glassboxchannel').hide("slow");
		 }
	  })
	  jQuery('#tchannel_media').change(function(){
		 text = jQuery(this).val();
		 if (text=='custom' ) {
			 jQuery('.imageboxchannel').show("slow");
			 jQuery('.imageboxweb').hide("slow");
			 jQuery('.imageboxvideo').hide("slow");
			 jQuery('.imageboxaudio').hide("slow");
		 } else if (text=='web' ) {
			 jQuery('.imageboxchannel').hide("slow");
			 jQuery('.imageboxvideo').hide("slow");
			 jQuery('.imageboxaudio').hide("slow");
			 jQuery('.imageboxweb').show("slow");
		 } else if (text=='video' ) {
			 jQuery('.imageboxchannel').hide("slow");
			 jQuery('.imageboxweb').hide("slow");
			 jQuery('.imageboxaudio').hide("slow");
			 jQuery('.imageboxvideo').show("slow");
		 } else if (text=='audio' ) {
			 jQuery('.imageboxchannel').hide("slow");
			 jQuery('.imageboxweb').hide("slow");
			 jQuery('.imageboxvideo').hide("slow");
			 jQuery('.imageboxaudio').show("slow");
		 } else {
			 jQuery('.imageboxchannel').hide("slow");
			 jQuery('.imageboxvideo').hide("slow");
			 jQuery('.imageboxaudio').hide("slow");
			 jQuery('.imageboxweb').hide("slow");
		 }
	  })
    </script>
	<?php	
}


add_action( 'save_post', 'tchannel_meta_box_save' );
function tchannel_meta_box_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonces'] ) || !wp_verify_nonce( $_POST['meta_box_nonces'], 'tchannel_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['tchannel_text'] ) )
		update_post_meta( $post_id, 'tchannel_text', wp_kses( $_POST['tchannel_text'], $allowed ) );
	if( isset( $_POST['tchannel_image'] ) )
		update_post_meta( $post_id, 'tchannel_image', wp_kses( $_POST['tchannel_image'], $allowed ) );
	if( isset( $_POST['tchannel_video'] ) )
		update_post_meta( $post_id, 'tchannel_video', wp_kses( $_POST['tchannel_video'], $allowed ) );	
	if( isset( $_POST['tchannel_video_time'] ) )
		update_post_meta( $post_id, 'tchannel_video_time', wp_kses( $_POST['tchannel_video_time'], $allowed ) );	
	if( isset( $_POST['tchannel_audio'] ) )
		update_post_meta( $post_id, 'tchannel_audio', wp_kses( $_POST['tchannel_audio'], $allowed ) );	
	if( isset( $_POST['tchannel_audio_time'] ) )
		update_post_meta( $post_id, 'tchannel_audio_time', wp_kses( $_POST['tchannel_audio_time'], $allowed ) );	
	if( isset( $_POST['tchannel_audio_performer'] ) )
		update_post_meta( $post_id, 'tchannel_audio_performer', wp_kses( $_POST['tchannel_audio_performer'], $allowed ) );	
	if( isset( $_POST['tchannel_audio_title'] ) )
		update_post_meta( $post_id, 'tchannel_audio_title', wp_kses( $_POST['tchannel_audio_title'], $allowed ) );	
	if( isset( $_POST['tchannel_web'] ) )
		update_post_meta( $post_id, 'tchannel_web', wp_kses( $_POST['tchannel_web'], $allowed ) );		
	if( isset( $_POST['tchannel_select'] ) )
		update_post_meta( $post_id, 'tchannel_select', esc_attr( $_POST['tchannel_select'] ) );
	if( isset( $_POST['tchannel_link'] ) )
		update_post_meta( $post_id, 'tchannel_link', esc_attr( $_POST['tchannel_link'] ) );
	if( isset( $_POST['tchannel_media'] ) )
		update_post_meta( $post_id, 'tchannel_media', esc_attr( $_POST['tchannel_media'] ) );
	if( isset( $_POST['tchannel_glass'] ) )
		update_post_meta( $post_id, 'tchannel_glass', esc_attr( $_POST['tchannel_glass'] ) );
	
	$options = get_option( 'tchannel_settings' );
	$channelslist = explode("+", $options['tchannel_channels']);
		if(is_array($channelslist)) {
			foreach ($channelslist as $channel) {		
				$channel_id = str_replace('@','',$channel);	
				$channel_id = 'tchannel_check_'.$channel_id;	
				$chk = ( isset( $_POST[$channel_id] ) && $_POST[$channel_id] ) ? 'on' : 'off';
				if ($chk == 'on'){
							ch_sendmessage_publish ($post_id, $channel);
						}
		}
	}
	$channelslist = explode("+", $options['tchannel_channels']);
		if(is_array($channelslist)) {
			foreach ($channelslist as $channel) {		
				$channel_id = str_replace('@','',$channel);	
				$channel_id = 'tchannel_checktime_'.$channel_id;	
				$chk = ( isset( $_POST[$channel_id] ) && $_POST[$channel_id] ) ? 'on' : 'off';
				if ($chk == 'on'){
							update_post_meta ($post_id, $channel_id,'on');
						}
		}
	}
	$groupslist = explode("+", $options['tchannel_groups']);
		if(is_array($groupslist)) {
			foreach ($groupslist as $group) {		
			$grouper = str_replace('+','',$group);	
			$groupdata = explode("/", $grouper);
			$group_id = $groupdata[0];
			$groupname = $groupdata[1];

				$groupname = 'tchannel_checks_'.$groupname;	
				$chk = ( isset( $_POST[$groupname] ) && $_POST[$groupname] ) ? 'on' : 'off';
				if ($chk == 'on'){
							ch_sendmessage_publish ($post_id, $group_id);
						}
		}
	}
}
?>