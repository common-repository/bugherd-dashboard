<?php

$plugin = Bugherd_Dashboard::get_instance();
$plugin_slug = $plugin->get_plugin_slug();

$bugherd_settings = get_option( $plugin_slug );

if( false === $bugherd_settings = get_option( $plugin_slug ) )
	$bugherd_settings = array();

// Update widget options
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['bugherd_settings_post']) ) {
	update_option( $plugin_slug, $_POST['bugherd_settings'] );
}

// Retrieve feed URLs
$project_id = $bugherd_settings['project_id'];
$api_key = $bugherd_settings['api_key'];
$script_install = $bugherd_settings['script_install'];

$public_feedback = $bugherd_settings['public_feedback']; ?>
<p>
	<label for="project_id">Project ID:</label>
	<input class="widefat" id="project_id" name="bugherd_settings[project_id]" type="text" value="<?php if( isset($project_id) ) echo $project_id; ?>" />
</p>

<p>
	<label for="api_key">API Key</label>
	<input class="widefat" id="api_key" name="bugherd_settings[api_key]" type="text" value="<?php if( isset($api_key) ) echo $api_key; ?>" />
</p>
<?php checked( $checked, $current, $echo ); ?>
<p>
	<input id="script_install" name="bugherd_settings[script_install]" type="checkbox" value="1" <?php echo checked(1, $script_install, false); ?> />
	<label for="script_install">Install the BugHerd script on site?</label>
</p>

<p>
	<input id="public_feedback" name="bugherd_settings[public_feedback]" disabled type="checkbox" value="1" <?php checked(1, $public_feedback, false); ?> />
	<label for="public_feedback">Allow public feedback?</label>
</p>

<input name="bugherd_settings_post" type="hidden" value="1" />