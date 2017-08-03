<?php
add_action( 'admin_init', 'tchannel_settings_init' );


function tchannel_settings_init(  ) { 

	register_setting( 'channelPage', 'tchannel_settings' );

	add_settings_section(
		'tchannel_pluginPage_section', 
		__( 'Get Telegram API ready', 'tchannel' ), 
		'tchannel_settings_section_callback', 
		'channelPage'
	);

	add_settings_field( 
		'tchannel_text_token', 
		__( 'Enter Your Telegram Bot Token', 'tchannel' ), 
		'tchannel_text_token_render', 
		'channelPage', 
		'tchannel_pluginPage_section' 
	);
	add_settings_field( 
		'tchannel_log', 
		__( 'Log Your Activity?', 'tchannel' ), 
		'tchannel_log_render', 
		'channelPage', 
		'tchannel_pluginPage_section' 
	);
	add_settings_field( 
		'tchannel_channels', 
		__( 'List of Channels', 'tchannel' ), 
		'tchannel_channels_render', 
		'channelPage', 
		'tchannel_pluginPage_section' 
	);
	add_settings_field( 
		'tchannel_groups', 
		__( 'List of Groups', 'tchannel' ), 
		'tchannel_groups_render', 
		'channelPage', 
		'tchannel_pluginPage_section' 
	);
	
$args = array(
   'public'   => true
);
$output = 'names'; // names or objects, note names is the default
$operator = 'and'; // 'and' or 'or'
$post_types = get_post_types( $args, $output, $operator ); 
foreach ( $post_types  as $post_type ) {
	if ($post_type == 'attachment' || $post_type == 'subscriber') {} else {
	add_settings_field( 
		'tbt_'.$post_type, 
		__( 'Send Notification for ', 'tchannel' ).$post_type, 
		'tchannel_post_types_render', 
		'channelPage', 
		'tchannel_pluginPage_section',
array( 'type' => $post_type )		
	);
	}
}


add_settings_section(
		'tchannel_pluginPage_section_d', 
		__( 'Default Settings', 'tchannel' ), 
		'tchannel_settings_section_d_callback', 
		'channelPage'
	);
	add_settings_field( 
		'tchannel_post_checkbox', 
		__( 'Always Ready?', 'tchannel' ), 
		'tchannel_post_checkbox_render', 
		'channelPage', 
		'tchannel_pluginPage_section_d' 
	);
	add_settings_field( 
		'tchannel_link_type', 
		__( 'Link Type', 'tchannel' ), 
		'tchannel_link_type_render', 
		'channelPage', 
		'tchannel_pluginPage_section_d' 
	);
	add_settings_field( 
		'tchannel_message_text', 
		__( 'Message Text', 'tchannel' ), 
		'tchannel_message_text_render', 
		'channelPage', 
		'tchannel_pluginPage_section_d' 
	);
	add_settings_field( 
		'tchannel_media', 
		__( 'Media', 'tchannel' ), 
		'tchannel_media_render', 
		'channelPage', 
		'tchannel_pluginPage_section_d' 
	);
}

function tchannel_text_token_render(  ) { 
	$options = get_option( 'tchannel_settings' );
	?>
	<input size="60" style='direction:ltr;' type='text' name='tchannel_settings[tchannel_text_token]' value='<?php echo $options['tchannel_text_token']; ?>'>
	<?php

}
function tchannel_log_render(  ) { 

	$options = get_option( 'tchannel_settings' );
	?>
	<select name='tchannel_settings[tchannel_log]'>
		<option value='yes' <?php selected( $options['tchannel_log'], 'yes' ); ?>><?php printf(__( 'Yes', 'tchannel' )); ?></option>
		<option value='no' <?php selected( $options['tchannel_log'], 'no' ); ?>><?php printf(__( 'No', 'tchannel' )); ?></option>
	</select>

<?php

}
function tchannel_link_type_render(  ) { 

	$options = get_option( 'tchannel_settings' );
	?>
	<select name='tchannel_settings[tchannel_link_type]'>
		<option value="fullurl" <?php selected( $options['tchannel_link_type'], 'url' ); ?>><?php printf(__( 'Full URL', 'tchannel' )); ?></option>
		<option value="shorturl" <?php selected( $options['tchannel_link_type'], 'shorturl' ); ?>><?php printf(__( 'Short URL', 'tchannel' )); ?></option>
		<option value="glass" <?php selected( $options['tchannel_link_type'], 'glass' ); ?>><?php printf(__( 'Glass Button', 'tchannel' )); ?></option>
		<option value="nourl" <?php selected( $options['tchannel_link_type'], 'nourl' ); ?>><?php printf(__( 'No URL', 'tchannel' )); ?></option>
	</select>

<?php

}
function tchannel_message_text_render(  ) { 

	$options = get_option( 'tchannel_settings' );
	?>
	<select name='tchannel_settings[tchannel_message_text]'>
		<option value="contenttext" <?php selected( $options['tchannel_message_text'], 'contenttext' ); ?>><?php printf(__( 'Post Content', 'tchannel' )); ?></option>
		<option value="customtext" <?php selected( $options['tchannel_message_text'], 'customtext' ); ?>><?php printf(__( 'Custom Message', 'tchannel' )); ?></option>
	</select>

<?php

}
function tchannel_media_render(  ) { 

	$options = get_option( 'tchannel_settings' );
	?>
	<select name='tchannel_settings[tchannel_media]'>
		<option value="featured" <?php selected( $options['tchannel_media'], 'featured' ); ?>><?php printf(__( 'Featured Image', 'tchannel' )); ?></option>
		<option value="custom" <?php selected( $options['tchannel_media'], 'custom' ); ?>><?php printf(__( 'Custom Image', 'tchannel' )); ?></option>
		<option value="web" <?php selected( $options['tchannel_media'], 'web' ); ?>><?php printf(__( 'From Web', 'tchannel' )); ?></option>
		<option value="noimage" <?php selected( $options['tchannel_media'], 'noimage' ); ?>><?php printf(__( 'No Image', 'tchannel' )); ?></option>
		<option value="video" <?php selected( $options['tchannel_media'], 'video' ); ?>><?php printf(__( 'Video', 'tchannel' )); ?></option>
		<option value="audio" <?php selected( $options['tchannel_media'], 'Audio' ); ?>><?php printf(__( 'Audio', 'tchannel' )); ?></option>
	</select>

<?php

}
function tchannel_channels_render(  ) { 
	$options = get_option( 'tchannel_settings' );
	?>
	<textarea style='direction:ltr;' cols='70' rows='5' name='tchannel_settings[tchannel_channels]'><?php echo $options['tchannel_channels']; ?></textarea>
	<p><?php printf(__( 'Please write down Channel IDs separated by "+" including @ (ex: @websimaca+@webasimachannel2)', 'tchannel' )); ?></p>
	<?php
}
function tchannel_groups_render(  ) { 
	$options = get_option( 'tchannel_settings' );
	?>
	<textarea style='direction:ltr;' cols='70' rows='5' name='tchannel_settings[tchannel_groups]'><?php echo $options['tchannel_groups']; ?></textarea>
	<p><?php printf(__( 'Please write down Group IDs and Names separated by "/" and make theme separated by + (ex: -56894843/websimaGroup+-78894843/samplegroup2)', 'tchannel' )); ?></p>
	<?php
}
function tchannel_post_types_render( $type ) { 
$type = $type['type'];
	$options = get_option( 'tchannel_settings' );
	$checked = '';
	if (array_key_exists('tchannel_'.$type,$options)) {
		$option = $options['tchannel_'.$type];
		if ($option == $type) { $checked = ' checked';} else {$checked = '';}
	}
	?>
	<input type='checkbox' name='tchannel_settings[tchannel_<?php echo $type; ?>]' <?php echo $checked; ?> value='<?php echo $type; ?>'>
	<label><?php echo $type; ?></label>
	<?php
}
function tchannel_post_checkbox_render( ) { 
	$options = get_option( 'tchannel_settings' );
	$checked = '';
	if (array_key_exists('tchannel_post_checkbox',$options)) {
		$option = $options['tchannel_post_checkbox'];
		if ($option == 'yes') { $checked = ' checked';} else {$checked = '';}
	}
	?>
	<input type='checkbox' name='tchannel_settings[tchannel_post_checkbox]' <?php echo $checked; ?> value='yes'>
	<label><?php echo __( 'All Channels and Groups will be Pre Checked?', 'tchannel' ); ?></label>
	<?php
}
function tchannel_settings_section_callback(  ) { 

	echo __( 'Before updating this settings please read the Documents carefully', 'tchannel' );

}
function tchannel_settings_section_d_callback(  ) { 

	echo __( 'Set Default Values for Sending Message Meta Box', 'tchannel' ); 

}

function channeller_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
				<style>
		a.websimabanner {
			right:5%;left:auto;position: absolute;
		}
		body.rtl a.websimabanner {
			left: 5%;right:auto
		}
		</style>
		<h2><?php printf(__( 'Telegram Channel Admin', 'tchannel' )); ?></h2>
		<a class="websimabanner" href="http://websima.com/channeller" title="websima channeller"><img width="281" height="364" src="<?php echo plugins_url( 'channeller.png', __FILE__ ); ?>" alt="وبسیما تلتر"/></a>
		<?php
		settings_fields( 'channelPage' );
		do_settings_sections( 'channelPage' );
		submit_button();
		?>
		
	</form>
	<?php } ?>