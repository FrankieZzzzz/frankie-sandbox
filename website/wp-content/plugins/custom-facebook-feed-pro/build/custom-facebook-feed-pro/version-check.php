<?php
$version_checks = array(
	$plugin_file => array(
		'@Version:\s+(.*)\n@' => 'header',
		"/CFFVER\',\s*\'([^\']*)\'/m" => 'global variable'
	),
);
