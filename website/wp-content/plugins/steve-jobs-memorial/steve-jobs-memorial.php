<?php
/*
Plugin Name: Steve Jobs Memorial
Description: In memory of Steve Jobs.
Version: 11.10.05
Author: Unknown Author
*/
wp_enqueue_script("jquery");

class stevejobsmemorial_class
{
	function __construct() {
		if (is_admin())
		{
		}
		else
		{
			$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
			if (strpos($browser, 'Mobile') === false && strpos($browser, 'Symbian') === false && strpos($browser, 'Opera M') === false && strpos($browser, 'Android') === false && stripos($browser, 'HTC_') === false && strpos($browser, 'Fennec/') === false && stripos($browser, 'Blackberry') === false) {
				add_action("wp_footer", array(&$this, "front_header_desktop"));
				add_action("wp_footer", array(&$this, "front_footer_desktop"));
			} else {
				if (empty($_COOKIE["steve_jobs_memorial_blocked"])) {
					add_action("wp_footer", array(&$this, "front_header_mobile"));
					add_action("wp_footer", array(&$this, "front_footer_mobile"));
					setcookie("steve_jobs_memorial_blocked", "yes", time()+3600*24*30, "/", ".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
				}
			}
		}
	}

	function front_header_desktop()
	{
		echo '
<style type="text/css">
.steve-jobs-memorial-box {
	width: 330px;
	height: 27px;
	position: fixed;
	bottom: 0px;
	right: 20px;
	overflow: hidden;
	z-index: 9999;
}
.steve-jobs-memorial-content {
	width: 320px;
	height: 135px;
	background-color: #000;
	-moz-box-shadow: 0 0 5px #000;
	-webkit-box-shadow: 0 0 5px #000;
	box-shadow: 0 0 5px #000;
	-moz-border-radius: 5px 0px 0px 0px;
	border-radius: 5px 0px 0px 0px;
	margin-top: 32px;
	margin-left: 5px;
	position: relative;
}
.steve-jobs-memorial-tab {
	width: 43px;
	height: 27px;
	background: #000 url('.get_bloginfo("wpurl").'/wp-content/plugins/steve-jobs-memorial/arrow_up.png) 15px 4px no-repeat;
	-moz-box-shadow: 0 0 5px #000;
	-webkit-box-shadow: 0 0 5px #000;
	box-shadow: 0 0 5px #000;
	-moz-border-radius: 5px 5px 0px 0px;
	border-radius: 5px 5px 0px 0px;
	cursor: pointer;
	float: right;
	margin-top: 5px;
	margin-right: 5px;
}
img.steve-jobs-memorial-foto {
	border: 1px solid #DDD;
	padding: 3px;
	background-color: #CCC;
	margin: 15px;
	float: left;
	border-radius: 3px;
	-moz-box-shadow: 0 0 5px #FFF;
	-webkit-box-shadow: 0 0 5px #FFF;
	box-shadow: 0 0 5px #FFF;
}
p.steve-jobs-memorial-quote {
	color: white;
	font-family: arial;
	font-size: 12px;
	text-align: right;
	padding: 10px 15px 10px 10px;
	margin: 0px;
	line-height: 20px;
}
p.steve-jobs-memorial-quote em {font-size: 13px;}
p.steve-jobs-memorial-text {
	color: #CCC;
	font-family: arial;
	font-size: 12px;
	text-align: left;
	padding: 10px;
	margin: 25px 0px 0px 0px;
	text-align: center;
	line-height: 20px;
}
</style>
<!--[if lt IE 7]>
<style type="text/css">
.steve-jobs-memorial-box {
	display: none;
}
</style>
<![endif]-->
<script type="text/javascript">
	jQuery(document).ready(function() {
		var steve_jobs_memorial_box_height_min = jQuery(".steve-jobs-memorial-tab").height();
		var steve_jobs_memorial_box_height_max = jQuery(".steve-jobs-memorial-tab").height() + jQuery(".steve-jobs-memorial-content").height();
		var steve_jobs_memorial_box_height_next = steve_jobs_memorial_box_height_max;
		jQuery(".steve-jobs-memorial-tab").click(function() {
			jQuery(".steve-jobs-memorial-box").animate({
				height: steve_jobs_memorial_box_height_next
			}, 300, function() {
				if (steve_jobs_memorial_box_height_next <= steve_jobs_memorial_box_height_min) {
					steve_jobs_memorial_box_height_next = steve_jobs_memorial_box_height_max;
					jQuery(".steve-jobs-memorial-tab").css("backgroundImage", "url('.get_bloginfo("wpurl").'/wp-content/plugins/steve-jobs-memorial/arrow_up.png)");
				}
				else {
					jQuery(".steve-jobs-memorial-tab").css("backgroundImage", "url('.get_bloginfo("wpurl").'/wp-content/plugins/steve-jobs-memorial/arrow_down.png)");
					steve_jobs_memorial_box_height_next = steve_jobs_memorial_box_height_min;
				}
			});
		});
	});
</script>
';
	}

	function front_footer_desktop()
	{
		echo '
<div class="steve-jobs-memorial-box">
	<div class="steve-jobs-memorial-tab"></div>
	<div class="steve-jobs-memorial-content">
	<img class="steve-jobs-memorial-foto" src="'.get_bloginfo("wpurl").'/wp-content/plugins/steve-jobs-memorial/stevejobs.png" height="90" alt="Steve Jobs Memorial">
	<p class="steve-jobs-memorial-quote">
		<em>Stay Hungry, Stay Foolish!</em><br />
		Steve Jobs
	</p>
	<p class="steve-jobs-memorial-text">In memory of Steve Jobs</p>
	</div>
</div>
';
	}

	function front_header_mobile()
	{
		echo '
<style type="text/css">
.steve-jobs-memorial-mobile-box {
	width: 330px;
	position: absolute;
	top: -200px;
	left: 20px;
	overflow: hidden;
	z-index: 9999;
}
.steve-jobs-memorial-mobile-content {
	width: 320px;
	height: 130px;
	background-color: #000;
	-moz-box-shadow: 0 0 5px #000;
	-webkit-box-shadow: 0 0 5px #000;
	box-shadow: 0 0 5px #000;
	-moz-border-radius: 5px 0px 5px 5px;
	border-radius: 5px 0px 5px 5px;
	margin-top: 23px;
	margin-left: 5px;
	margin-bottom: 5px;
	position: relative;
}
.steve-jobs-memorial-mobile-tab {
	width: 31px;
	height: 18px;
	background: #000 url("'.get_bloginfo("wpurl").'/wp-content/plugins/steve-jobs-memorial/close.png") 10px 4px no-repeat;
	-moz-box-shadow: 0 0 5px #000;
	-webkit-box-shadow: 0 0 5px #000;
	box-shadow: 0 0 5px #000;
	-moz-border-radius: 5px 5px 0px 0px;
	border-radius: 5px 5px 0px 0px;
	cursor: pointer;
	float: right;
	margin-top: 5px;
	margin-right: 5px;
}
img.steve-jobs-memorial-mobile-foto {
	border: 1px solid #DDD;
	padding: 3px;
	background-color: #CCC;
	margin: 15px;
	float: left;
	border-radius: 3px;
	-moz-box-shadow: 0 0 5px #FFF;
	-webkit-box-shadow: 0 0 5px #FFF;
	box-shadow: 0 0 5px #FFF;
}
p.steve-jobs-memorial-mobile-quote {
	color: white;
	font-family: arial;
	font-size: 12px;
	text-align: right;
	padding: 10px 15px 10px 10px;
	margin: 0px;
	line-height: 20px;
}
p.steve-jobs-memorial-mobile-quote em {font-size: 13px;}
p.steve-jobs-memorial-mobile-text {
	color: #CCC;
	font-family: arial;
	font-size: 12px;
	text-align: left;
	padding: 10px;
	margin: 25px 0px 0px 0px;
	text-align: center;
	line-height: 20px;
}
</style>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var sjmm_left = parseInt((jQuery(document).width() - jQuery(".steve-jobs-memorial-mobile-box").width())/2);
		jQuery(".steve-jobs-memorial-mobile-box").css("left", sjmm_left);
		jQuery(".steve-jobs-memorial-mobile-box").animate({top: 50}, 300, function() {});
		jQuery(".steve-jobs-memorial-mobile-tab").click(function() {
			jQuery(".steve-jobs-memorial-mobile-box").animate({top: -200}, 300, function() {});
		});
	});
</script>
';
	}

	function front_footer_mobile()
	{
		echo '
<div class="steve-jobs-memorial-mobile-box">
	<div class="steve-jobs-memorial-mobile-tab"></div>
	<div class="steve-jobs-memorial-mobile-content">
	<img class="steve-jobs-memorial-mobile-foto" src="'.get_bloginfo("wpurl").'/wp-content/plugins/steve-jobs-memorial/stevejobs.png" height="90" alt="Steve Jobs Memorial">
	<p class="steve-jobs-memorial-mobile-quote">
		<em>Stay Hungry, Stay Foolish!</em><br />
		Steve Jobs
	</p>
	<p class="steve-jobs-memorial-mobile-text">In memory of Steve Jobs</p>
	</div>
</div>
';
	}
	
}
$stevejobsmemorial = new stevejobsmemorial_class();
?>