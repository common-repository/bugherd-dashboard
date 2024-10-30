<?php 

$plugin = Bugherd_Dashboard::get_instance();
$plugin_slug = $plugin->get_plugin_slug();

$bugherd_settings = get_option( $plugin_slug );

$project_id = $bugherd_settings['project_id'];
$api_key = $bugherd_settings['api_key'];
	
if( empty($project_id) || empty($api_key) ){
	echo '<p style="text-align:center;">This widget must be configured.</p>';
	return false;
}

$url = 'https://www.bugherd.com/api_v2/projects/'.$project_id.'/tasks.json';

$headers = array( 'Authorization' => 'Basic ' . base64_encode( "$api_key" ) );
$result = $plugin::remote_get(
	'bugherd_project_'.$project_id, 
	$url, 
	array( 'headers' => $headers ), 
	$expiration = 60 );

$status = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,'feedback'=>0);

if( !empty($result) ){
	$tasks = json_decode($result);
	$tasks = $tasks->tasks;

	
	foreach($tasks as $task){
		$status_id = ( !is_null($task->status_id) ) ? $task->status_id : 'feedback';
		$status[$status_id]++;
	}
}

?>
<ul>
	<li class="issue-feedback"><i>Feedback: <span><?php echo $status['feedback']; ?></span></i></li>
	<li class="issue-backlog"><i>Backlog: <span><?php echo $status[0]; ?></span></i></li>
	<li class="issue-todo"><i>Todo: <span><?php echo $status[1]; ?></span></i></li>
	<li class="issue-doing"><i>Doing: <span><?php echo $status[2]; ?></span></i></li>
	<li class="issue-done"><i>Done: <span><?php echo $status[4]; ?></span></i></li>
	<li class="issue-archive"><i>Archive: <span><?php echo $status[5]; ?></span></i></li>
	
</ul>
<div class="note">Note: Issues marked as done are still subject to peer review.</div>