<?php

$path = __DIR__ . '/../../assets/svgs/';

// Get all the svgs in the directory
// only supports depth of 1 and 2 directories
// i.e assets/svgs/ and assets/svgs/folder/ .

$files  = glob($path . '*.svg', GLOB_NOSORT);
$subdir_files = glob($path . '*/*.svg', GLOB_NOSORT);

$files = array_merge($files, $subdir_files);

foreach ($files as $file) {
	$pathinfo = pathinfo($file);
	if (empty($pathinfo) || !is_array($pathinfo)) {
		continue;
	}

	$array    = explode('/', $pathinfo['dirname']);
	if (empty($array) || ! is_array($array)) {
		continue;
	}

	$dir      = end($array);
	$filename = $pathinfo['filename'];

	if ($dir !== 'svgs') {
		if (empty($svgs[ $dir ]) || ! is_array($svgs[ $dir ])) {
			$svgs[ $dir ] = [];
		}
		$svgs[ $dir ][ $filename ] = file_get_contents($file);
	} else {
		$svgs[ $filename ] = file_get_contents($file);
	}
}

$json_object = json_encode($svgs);

$file_contents = "const cff_svgs = {$json_object};";

if (is_file($path . 'svgs.js')) {
	unlink($path . 'svgs.js');
}

file_put_contents($path . 'svgs.js', $file_contents);
