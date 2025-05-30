=== User Submitted Posts – Enable Users to Submit Posts from the Front End ===

Plugin Name: User Submitted Posts
Plugin URI: https://perishablepress.com/user-submitted-posts/
Description: Enables your visitors to submit posts and images from anywhere on your site.
Tags: frontend post, submit post, guest post, visitor post, public post
Author: Jeff Starr
Author URI: https://plugin-planet.com/
Donate link: https://monzillamedia.com/donate.html
Contributors: specialk
Requires at least: 4.6
Tested up to: 6.7
Stable tag: 20250327
Version:    20250327
Requires PHP: 5.6.20
Text Domain: usp
Domain Path: /languages
License: GPL v2 or later

Enable visitors to submit posts and images from the front-end of your site. Many features including anti-spam security, content restriction, and more.



== Description ==

**🏆 The #1 Plugin for User-Generated Content!**

*Enable visitors to submit posts from the front end of your site.*

User Submitted Posts (USP) provides a front-end form that enables visitors to submit posts and upload images. Just add the following shortcode to any Post, Page, or Widget:

[user-submitted-posts]

That's all there is to it! Your site now can accept user generated content. Everything is super easy to customize via Plugin Settings page.

The post-submission form may include any/all of the following fields:

* Name
* Email
* URL
* Post Title
* Post Tags
* Post Category
* Post Content
* Custom Field 1
* Custom Field 2
* Custom Checkbox
* Challenge Question
* Google reCAPTCHA (v2 or v3)
* Post Images
* Agree to Terms

Each of these fields may be set as required, optional, or disabled. You can set the Post Status of submitted posts as "Pending", "Draft", "Publish Immediately", or publish after a specific number of approved posts. 

USP enables users to upload any number of images when submitting a post. You can customize the min/max width, height, and number of submitted images.

USP also includes a Login/Register Form, and three shortcodes to control access and restrict content (more information below).


*🚀 User Submitted Posts is the first and best plugin for front-end content!*


### ✨ Core Features ###

* Includes a fast & secure post-submission form
* Includes a simple login/register/password form
* Display forms anywhere via shortcode or template tag
* Includes shortcode to display a list of submitted posts
* Includes shortcodes to control access and restrict content
* Includes template tags to display submitted post content
* Includes configurable Custom Field for the post-submit form
* You choose which fields to display on the post-submit form
* Automatically display all submitted content on the front end
* Display post-submit & login forms via Text or HTML widgets
* Receive email notification alerts for submitted posts
* Image preview thumbnails for selected images
* NEW: front-end post deletion (via email link)

*Boost your site value with user-generated content!*


### ✨ Form Features ###

* Google reCAPTCHA: v2 ("I am not a bot") or v3 (hidden recaptcha)
* Built-in client-side form validation with [Parsley](https://parsleyjs.org/)
* Stops spam via input validation, captcha, and hidden field
* Use either Challenge Question, Google reCAPTCHA, or both!
* Option to set submitted images as WP Featured Images
* Option to require users to be logged in to use the form
* Option to use WP's Rich Text Editor (RTE) for post content
* Redirect user to any URL or current page after submission
* Use the default HTML5 form or customize your own form
* Use the default form styles or add your own custom CSS
* Form fields may be set as optional or required
* Many action & filter hooks for advanced customization

*USP is simple to use and built with clean, secure code via the WP API!*


### ✨ More Features ###

* Translated into 20+ languages
* Automatically detects logged-in users
* Regularly updated to stay current with WordPress
* Multiple emails supported in email alerts
* Option to set a default post category
* Option to disable loading of form JavaScript & CSS
* Option to specify URL for targeted resource loading
* Option to disable tracking of IP addresses
* Option to specify custom email alert subject
* Option to specify custom email alert message
* Option to submit posts as WP Posts or Pages
* Choose which categories users are allowed to select
* Assign submitted posts to any registered user
* Customizable success, error, and upload messages
* Works with or without Gutenberg Block Editor

*USP provides many options to help you create the perfect form!*


### ✨ Content Restriction ###

USP provides three "Access Control" shortcodes to control access and restrict content. Here are some examples to give you an idea of how it works.

Display form and/or content only to users with a specific capability:

	[usp_access cap="read" deny="Message for users without read capability"]
		[user-submitted-posts] // Put the USP form or any other content here.
	[/usp_access]

Display form and/or any content to logged-in users:

	[usp_member deny="Message for users who are not logged in"]
		[user-submitted-posts] // Put the USP form or any other content here.
	[/usp_member]

Display form and/or any content to visitors only:

	[usp_visitor deny="Message for users who are logged in"]
		[user-submitted-posts] // Put the USP form or any other content here.
	[/usp_visitor]

You can add and use Access Control shortcodes on any WP Post or Page. Tip: you can find this information (and more) in the plugin settings, under "Display the Form" &gt; "Access Control".


### ✨ Image Uploads ###

* Optionally enable visitors to upload any number of images
* Specify minimum & maximum allowed images for each post
* Specify minimum & maximum width & height for images
* Automatically set submitted images as Featured Images
* Automatically display submitted images on the front end
* Includes template tags to display submitted images
* Includes shortcodes to display submitted images


### ✨ Post Management ###

* Custom Fields saved w/ each post: name, IP, URL, and image URLs
* Set posts to any status: Draft, Pending, Publish, or Moderate
* One-click filtering of submitted posts on the Admin Posts page

*Plus much more! Too many features to list them all!*


### ✨ Translations ###

User Submitted Posts supports translation into any language. Current translations include the following languages:

	Arabic                - usp-ar
	Bengali               - usp-bn_BD
	Chinese (Simplified)  - usp-zh_CN
	Chinese (Traditional) - usp-zh_TW
	Czech                 - usp-cs_CZ
	Dutch                 - usp-nl_NL
	French (France)       - usp-fr_FR
	German                - usp-de_DE
	Greek                 - usp-el
	Hebrew                - usp-he_IL
	Hindi                 - usp-hi_IN
	Irish                 - usp-ga
	Italian               - usp-it_IT
	Japanese              - usp-ja
	Korean                - usp-ko_KR
	Norwegian             - usp-no
	Persian               - usp-fa_IR
	Polish                - usp-pl_PL
	Portuguese (Brazil)   - usp-pt_BR
	Portuguese (Portugal) - usp-pt_PT
	Punjabi               - usp-pa_IN
	Romanian              - usp-ro_RO
	Russian               - usp-ru_RU
	Serbian               - usp-sr_RS
	Slovenian             - usp-sl_SI
	Spanish (Spain)       - usp-es_ES
	Swedish               - usp-sv_SE
	Turkish               - usp-tr_TR
	Urdu                  - usp-ur

__Note:__ most of the default translations are made via Google Translate. So they are automated and may be a little rough. Feel free to make your own translation as desired. Need a translation into your language? [Let me know!](https://plugin-planet.com/support/#contact)


### ✨ Pro Version ###

__USP Pro__ now available at [Plugin Planet](https://plugin-planet.com/usp-pro/)!

Pro version includes many, many more features and settings, with unlimited custom forms, infinite custom fields, multimedia file uploads, and much more. [Check it out &raquo;](https://plugin-planet.com/usp-pro/)


### ✨ Privacy ###

__User Data:__ This plugin enables users to submit post content. It collects data _only_ from users who voluntarily submit content via the USP form. The only involuntary data that is collected is the IP address of the person submitting the form. The plugin provides an option to disable IP collection completely.

__Cookies:__ This plugin uses simple cookies to enable dynamic form functionality. No cookies are used for any other purpose.

__Services:__ This plugin provides an option to enable Google reCaptcha, which is provided by Google as a third-party service. For details on privacy and more, please refer to official documentation for [Google reCaptcha](https://developers.google.com/recaptcha/). No other outside services or locations are accessed/used by this plugin.


### ✨ Developer ###

User Submitted Posts is developed and maintained by [Jeff Starr](https://twitter.com/perishable), 15-year [WordPress developer](https://plugin-planet.com/) and [book author](https://books.perishablepress.com/).



== Installation ==

### How to install the plugin ###

1. Upload the plugin to your blog and activate
2. Configure your options via the plugin settings
3. Display the form via shortcode or template tag

[More info on installing WP plugins](https://wordpress.org/support/article/managing-plugins/#installing-plugins)


### How to use the plugin ###

To display the form on any WP Post, Page, or widget, add the shortcode:

	[user-submitted-posts]

Or, to display the form anywhere in your theme, add the template tag:

	<?php if (function_exists('user_submitted_posts')) user_submitted_posts(); ?>


### Customizing the form ###

There are three main ways of customizing the form:

* Plugin settings, you can show/hide fields, configure options, etc.
* Custom form template (see "Custom Submission Form" for more info)
* By using USP action/filter hooks (advanced)

USP Hooks:

`Filters:
usp_post_status
usp_post_author
usp_form_shortcode
usp_mail_subject
usp_mail_message
usp_new_post
usp_input_validate
usp_require_login
usp_default_title

Actions:
usp_submit_success
usp_submit_error
usp_insert_before
usp_insert_after
usp_files_before
usp_files_after`

Check out the [complete list of action hooks for User Submitted Posts](https://perishablepress.com/action-filter-hooks-user-submitted-posts/)

More info about [WordPress Actions and Filters](https://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters)


### Custom Submission Form ###

Out of the box, User Submitted Posts provides a highly configurable submission form. Simply visit the plugin settings to control which fields are displayed, set the Challenge Question, configure submitted images, and much more. 

There are situations, however, where advanced form configuration may be required. In order to allow for this, USP makes it possible to create a custom submission form. Here are the steps:

First, copy these two plugin files:

	/user-submitted-posts/resources/usp.css
	/user-submitted-posts/views/submission-form.php

Then, paste those two files into a directory named `/usp/` in your theme:

	/wp-content/themes/your-theme/usp/usp.css
	/wp-content/themes/your-theme/usp/submission-form.php

Lastly, visit the plugin settings and change "Form style" to "Custom Form + CSS". You now may customize the two files as desired; they will not be overwritten when the plugin is updated. For help with making basic changes to the custom form, check out the [USP FAQs](https://perishablepress.com/faqs-user-submitted-posts/#customize-form) at Perishable Press.

Alternately, you can set the option "Form style" to "HTML5 Form + Disable CSS" to use the default USP form along with your own CSS. FYI: here is a list of [USP CSS selectors](https://m0n.co/e). 

Or, to go further with unlimited custom forms, [check out USP Pro](https://plugin-planet.com/usp-pro/) :)


### Displaying submitted posts ###

User-submitted posts are handled by WordPress as regular WP Posts. So they are displayed along with your other posts according to your theme design. Additionally, each submitted post includes a set of Custom Fields that include the following information:

* `is_submission` - indicates that the post is a user-submitted post
* `user_submit_image` - the URL of the submitted image (one custom field per image)
* `user_submit_ip` - the IP address of the submitted-post author
* `user_submit_name` - the name of the submitted-post author
* `user_submit_url` - the submitted URL
* `usp_custom_field` - configurable Custom Field

There are numerous ways to display these Custom Fields. The easiest way is to visit the plugin settings and configure the options available under "Auto-Display Content". There you can enable auto-display of submitted email address, URL, and images. Note that submitted images also are uploaded to the WP Media Library.

For more flexibility, you can use a variety of WP Template Tags (e.g., [get_post_meta()](https://codex.wordpress.org/Function_Reference/get_post_meta)) to display Custom Fields. Here are some tutorials for more information:

* [WordPress Custom Fields, Part I: The Basics](https://perishablepress.com/wordpress-custom-fields-tutorial/)
* [WordPress Custom Fields, Part II: Tips and Tricks](https://perishablepress.com/wordpress-custom-fields-tips-tricks/)

And here are some tutorials that may help with custom display of submitted images:

* [Display all images attached to post](https://wp-mix.com/display-images-attached-post/)
* [Display images with links](https://wp-mix.com/display-images-with-user-submitted-posts/)

Also, here is a [Helper Plugin to display Custom Fields](https://plugin-planet.com/usp-pro-custom-field-helper-plugin/). It originally is designed for use with USP Pro, but also works great with the free version of USP.


### Auto Display Images ###

To automatically display submitted images on the front end, visit the plugin settings, "Images Auto-Display" and select whether to display the images before or after post content. Save changes.


### Featured Images ###

To set submitted images as Featured Images (aka Post Thumbnails) for submitted posts, visit the plugin settings, "Image Uploads" and check the box to enable "Featured Image". Save changes.


### Shortcodes ###

User Submitted Posts provides a set of useful shortcodes. Check out the "Display the Form" panel in the plugin settings for examples and more information.

	[user-submitted-posts]                        : displays the form on any Post or Page
	[usp-login-form]                              : displays a login/register/password form
	[usp_display_posts]                           : displays list of all submitted posts
	[usp_gallery]                                 : displays a gallery of all submitted images for the current post
	[usp-reset-button url="https://example.com/"] : displays a button to reset the form
	[usp_access cap="read" deny=""][/usp_access]  : limits access to specific user capability
	[usp_visitor deny=""][/usp_visitor]           : limits access to visitors (not logged in) only
	[usp_member deny=""][/usp_member]             : limits access to logged-in users


Here is more info about these shortcodes:

__`[user-submitted-posts]`__

Displays the post-submit form. This shortcode does not accept any attributes.


__`[usp-login-form]`__

Displays the login/register/password form. This shortcode does not accept any attributes.

To add Google reCaptcha to the form, you can use any good reCaptcha plugin. Here are a few examples:

* [reCAPTCHA Lite](https://wordpress.org/plugins/recaptcha-lite/)
* [Smart Captcha (reCAPTCHA)](https://wordpress.org/plugins/smart-recaptcha/)
* [reCaptcha by BestWebSoft](https://wordpress.org/plugins/google-captcha/)

These are not endorsements for these plugins. They have been tested and work with the USP login/register/password form. 


__`[usp_display_posts]`__

Displays a list of all submitted posts. This shortcode accepts two optional attributes, "userid" and "numposts". Examples:

	[usp_display_posts]                           : default displays all submitted posts by all authors
	[usp_display_posts userid="current"]          : displays all submitted posts by current logged-in user
	[usp_display_posts userid="1"]                : displays all submitted posts by registered user with ID = 1
	[usp_display_posts userid="Pat Smith"]        : displays all submitted posts by author name "Pat Smith"
	[usp_display_posts userid="all"]              : displays all submitted posts by all users/authors
	[usp_display_posts userid="all" numposts="5"] : limit to 5 posts from all users
	[usp_display_posts post_type="page"]          : display only submitted pages

So the shortcode attributes can be used to customize the post list as desired. Note that the Pro version of USP provides many more options for the [display-posts shortcode](https://plugin-planet.com/usp-pro-display-list-submitted-posts/).


__`[usp_gallery]`__

__Note:__ This shortcode works only when added to a submitted post. It does nothing when added anywhere else.

Displays a gallery of all submitted images for the current post. Customize via the following attributes:

	size    = image size as thumbnail, medium, large or full -> default = thumbnail
	format  = whether to make the image a linked image       -> default = image (can use image or image_link)
	target  = whether to open linked image in new tab        -> default = blank (can use blank or self)
	class   = optional custom class name(s)                  -> default = none
	number  = the number of images to display for each post  -> default = 100
	post_id = an optional post ID to use                     -> default = false (uses global/current post)
	
	Check out the source code inline notes for more info


__`[usp-reset-button]`__

Displays a button to reset the form. Accepts the following attributes:

	class  = classes for the parent element (optional, default: none)
	value  = link text (optional, default: "Reset form")
	url    = the URL where your form is displayed (required, default: none)
	custom = any attributes or custom code for the link element (optional, default: none)

Note that the `url` attribute accepts `%%current%%` for the current URL (useful when the form is displayed in the sidebar).


__`[usp_access]`__

Limits access to specific user capability. Example:

	[usp_access cap="read"]
		Content for users that have "read" access
	[/usp_access]

The `cap` attribute specifies the required capability or capabilities (comma-separated). This shortcode also accepts an optional `deny` attribute. The `deny` attribute displays a message to users who are denied access. Tip: to include markup in the deny message, you can use `{tag}` to display `<tag>`. Check out the "Display the Form" panel in the plugin settings for examples and more info.


__`[usp_visitor]`__

Limits access to visitors (not logged in) only. Example:

	[usp_visitor]
		Content for for users who are not logged in
	[/usp_visitor]

This shortcode accepts an optional `deny` attribute. The `deny` attribute displays a message to users who are denied access. Tip: to include markup in the deny message, you can use `{tag}` to display `<tag>`. Check out the "Display the Form" panel in the plugin settings for examples and more info.


__`[usp_member]`__

Limits access to logged-in users. Example:

	[usp_member]
		Content for for users who are logged in
	[/usp_member]

This shortcode accepts an optional `deny` attribute. The `deny` attribute displays a message to users who are denied access. Tip: to include markup in the deny message, you can use `{tag}` to display `<tag>`. Check out the "Display the Form" panel in the plugin settings for examples and more info.


### Template tags ###

User Submitted Posts provides a set of useful template tags:

	/*
		Display the Post-Submission Form
		Usage: <?php if (function_exists('user_submitted_posts')) user_submitted_posts(); ?>
	*/
	
	user_submitted_posts()
	
	
	/*
		Display the Login/Register/Password Form
		Usage: <?php if (function_exists('usp_login_form')) usp_login_form(); ?>
	*/
	
	usp_login_form()
	
	
	/*
		Display a configurable list of submitted posts
		Usage: <?php if (function_exists('usp_display_posts')) echo usp_display_posts(array('userid' => 'all', 'numposts' => -1)); ?>
	*/
	
	usp_display_posts()
	
	
	/* 
		Check if post is a submitted post
		Returns true or false
		Usage: <?php if (usp_is_public_submission()) return true; ?>
	*/
	
	usp_is_public_submission()
	
	
	/* 
		Get all image URLs
		Returns an array of image URLs that are attached to the current submitted post
		Usage: <?php $images = usp_get_post_images(); foreach ($images as $image) echo $image; ?>
	*/
	
	usp_get_post_images()
	
	
	/* 
		Display all images
		Outputs a set of <img> tags for images attached to the current submitted post
		Usage: <?php usp_post_attachments($size, $beforeUrl, $afterUrl, $numberImages, $postId); ?>
		Parameters:
			$size         = image size: thumbnail, medium, large or full -> default = full
			$beforeUrl    = text/markup displayed before each image URL  -> default = <img src="
			$afterUrl     = text/markup displayed after each image URL   -> default = " />
			$numberImages = number of images to display for each post    -> default = false (display all)
			$postId       = an optional post ID to use                   -> default = uses global post
	*/
	
	usp_post_attachments()
	
	
	/* 
		Display submitted author name and URL
		This tag displays one of the following:
			- The author's submitted name as a link (if both 'User Name' and 'User URL' fields are included in the form)
			- The author's submitted name as plain text (if 'User Name' is included in the form, but 'User URL' is not included)
			- The author's registered username as a link to the author's post archive (if 'User Name' is not included in the form)
			
		Usage: <?php usp_author_link(); ?>
	*/
	
	usp_author_link()
	
	
	/*
		Get an array of image URLs, wrapped in optional HTML
		Syntax: <?php if (function_exists('usp_get_images')) $images = usp_get_images($size, $format, $target, $class, $number, $post_id); ?>
		Usage:  <?php if (function_exists('usp_get_images')) $images = usp_get_images(); foreach ($images as $image) echo $image; ?>
		Parameters:
				$size    = image size as thumbnail, medium, large or full -> default = thumbnail
				$format  = whether to make the image a linked image       -> default = image (can use image or image_link)
				$target  = whether to open linked image in new tab        -> default = blank (can use blank or self)
				$class   = optional custom class name(s)                  -> default = none
				$number  = the number of images to display for each post  -> default = 100
				$post_id = an optional post ID to use                     -> default = false (uses global/current post)
		
		Check out the source code inline notes for more info
	*/
	
	usp_get_images()


These template tags should work out of the box when included in your theme template file(s). Keep in mind that for some of the tags to work, there must be some existing submitted posts and/or images available. 

The source code for these tags is located in `/library/template-tags.php` and `shortcode-login.php`.


### Upgrades ###

To upgrade User Submitted Posts, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Important!__ The `/custom/` directory is deprecated. If you are using a custom form template, please move it to `/wp-content/your-theme/usp/`. For more information, check out the "Custom Submission Form" section under [Installation](https://wordpress.org/plugins/user-submitted-posts/#installation).

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. Submitted posts are NOT removed if you deactivate the plugin, reset default options, or uninstall the plugins; that is, all submitted posts must be removed manually.


### Restore Default Options ###

To restore default plugin options, either uninstall/reinstall the plugin, or visit the plugin settings &gt; Restore Default Options.


### Uninstalling ###

User Submitted Posts cleans up after itself. All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen. Submitted posts are NOT removed if you deactivate the plugin, reset default options, or uninstall the plugins; that is, _all submitted posts must be removed manually_.


### Pro Version ###

Pro version of USP now available! USP Pro includes many more awesome features and settings, with unlimited custom forms, infinite custom fields, multimedia file uploads, and much, much more.

* [Check out USP Pro for virtually limitless form-building action &raquo;](https://plugin-planet.com/usp-pro/) 
* [Read what users are saying about USP Pro &raquo;](https://plugin-planet.com/testimonials/)


### Like the plugin? ###

If you like USP, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/user-submitted-posts/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!



== Upgrade Notice ==

To upgrade User Submitted Posts, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Important!__ The `/custom/` directory is deprecated. If you are using a custom form template, please move it to `/wp-content/your-theme/usp/`. For more information, check out the "Custom Submission Form" section under [Installation](https://wordpress.org/plugins/user-submitted-posts/#installation).

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. Submitted posts are NOT removed if you deactivate the plugin, reset default options, or uninstall the plugins; that is, all submitted posts (and any attached meta data) must be removed manually.



== Screenshots ==

1. USP Settings Screen (panels toggled closed)
2. USP Plugin Settings, showing default options (panels toggle open/closed)
3. USP Form (with all fields enabled)
4. USP Form (with just a few fields enabled)
5. Example showing how to display the form on a Page (using a shortcode)

More screenshots and infos available at the [USP Homepage](https://perishablepress.com/user-submitted-posts/)



== Frequently Asked Questions ==

**Can you add this feature or that feature?**

Please check the [Pro version of USP](https://plugin-planet.com/usp-pro/), which includes many of the most commonly requested features from users. The free version also may include new features in future updates.


**Images are not uploaded or displaying**

If everything is configured properly, USP will display submitted images on the front-end. If that is not happening, here are some things to check:

* Make sure that the setting "Images Auto-Display" is enabled
* And/or make sure that the setting "Featured Image" is enabled
* And/or make sure that your theme is set up to display submitted images

Assuming that everything is set up to display submitted images, here are some further things to check:

* Is there any error message when trying to submit an image? 
* Check that the submitted images are uploaded to the Media Library
* Check that the URL of the submitted image is attached to the submitted post as a Custom Field (on Edit Post screen)
* Check the permission settings on the upload folder(s) by ensuring that you can successfully upload image files directly via the Media Uploader
* Double-check that all the "Image Uploads" settings make sense, and that the images being uploaded meet the specified requirements

Note: when changing permissions on files and folders, it is important to use the least-restrictive settings possible. If you have to use more permissive settings, it is important to secure the directory against malicious activity. For more information check out: [Secure Media Uploads](https://digwp.com/2012/09/secure-media-uploads/)


**How to set submitted image as the featured image?**

Here are the steps:

1. Visit USP settings &gt; Options panel &gt; Image Uploads &gt; Featured Image
2. Check the box and click "Save Settings" to save your changes

Note that this setting merely assigns the submitted image as the Featured Image; it's up to your theme's single.php file to include `the_post_thumbnail()` to display the Featured Images. If your theme is not so equipped, [check out this tutorial at WP-Mix](https://wp-mix.com/set-attachment-featured-image/).


**How to require login?**

Visit the plugin settings and enable the option to "Require User Login". That will display the submission form only to logged-in users. To go further and require login for other types of content, there are many techniques available to you. For more information check out my WP-Mix post, [WordPress Require User Login](https://wp-mix.com/wordpress-require-user-login/), which provides a good summary of the possibilities. Also note: [USP Pro includes built-in shortcodes](https://plugin-planet.com/usp-pro-display-form-logged-in-users/) to display forms and other content to registered/logged-in users and/or guests/logged-out users.


**How do I change the appearance of the submission form?**

The easiest way to customize the form is via the plugin settings. There you can choose one of the following form configurations:

* HTML5 Form + Default CSS (Recommended)
* HTML5 Form + Disable CSS (Provide your own styles)
* Custom Form + Custom CSS (Provide your own form template & styles)

Additionally, you can configure the settings to show/hide specific fields, control the number and size of submitted images, customize the Challenge Question, and much more.

To go beyond what's possible with the plugin settings, USP enables creation of a custom submission form. To learn how, check out the "Custom Submission Form" section under [Installation](https://wordpress.org/plugins/user-submitted-posts/installation/). And for advanced customization, developers can use [USP action and filter hooks](https://perishablepress.com/action-filter-hooks-user-submitted-posts/).

Or, to go further with unlimited custom forms, [check out USP Pro](https://plugin-planet.com/usp-pro/) :)


**What is the "alternate" form?**

Inside of the `/views/` directory, you will find an alternate form template named `submission-form-alt.php`. This template is identical to that used for the default form, with the exception that it returns the post-submit form in addition to the success message. You can use the alternate form template by following the steps provided via the "Custom Submission Form" section of the plugin documentation/readme.


**What about security and spam?**

User Submitted Posts uses the WordPress API to keep everything secure, fast, and flexible. The plugin also features Google reCAPTCHA, Challenge Question, and hidden anti-spam field to stop automated spam and bad bots.


**Can I include video?**

The free version of USP supports uploads of images only, but some hosted videos may be included in the submitted content (textarea) by simply including the video URL on its own line. See [this page](https://codex.wordpress.org/Embeds) for more info. Note that [USP Pro](https://plugin-planet.com/usp-pro/) enables users to [upload video and much more](https://plugin-planet.com/usp-pro-allowed-file-types/#file-formats).


**How do I reset the plugin settings?**

To reset plugin settings to factory defaults:

1. Visit "Restore Default Options" in the plugin settings
2. Check the box and save your changes
3. Deactivate the plugin and then reactivate it
4. Plugin settings now are restored to defaults

Restoring default settings does not delete any submitted posts. Even if you completely remove the plugin, the submitted posts will not be deleted. You have to remove them manually, if desired.


**How do I enable the "Add Media" button for all users?**

Question: How do I enable the "Add Media" button for all users (even if not registered)?

Answer: Users must have sufficient capabilities to access the Media Library and the "Add Media" button. This is a security measure aimed at preventing foul play. The Pro version of USP provides an option to [enable Add Media uploads for all user levels](https://plugin-planet.com/usp-pro-enable-non-admin-users-upload-media/).


**Can you explain the setting "Registered Username"?**

When "Registered Username" is enabled:

* If the user is logged in, their registered username is used as the Post Author
* If the user is logged out, the setting "Assigned Author" is used as the Post Author
	
When "Registered Username" is disabled:

* The setting "Assigned Author" always is used as the Post Author for all users (whether logged in or not)


**How can I translate this plugin?**

Currently the easiest and most flexible method is to [use GlotPress to translate USP](https://translate.wordpress.org/projects/wp-plugins/user-submitted-posts). That is the recommended translation route going forward, but for the time being you may also translate using a plugin such as [Loco Translate](https://wordpress.org/plugins/loco-translate/). FYI, USP's translation files are located in the `/languages/` directory.


**Why am I not receiving the Email Alerts?**

Normally the plugin sends an Email Alert each time a post is submitted. If that is not happening in your case, you will need to troubleshoot your setup. Here is a guide on [Troubleshooting Email](https://perishablepress.com/email-troubleshooting-guide/) that should help.


**How to disable image preview feature?**

To disable the image-preview thumbnail feature, add the following line to the plugin setting, "Custom Content":

`<script>var usp_disable_previews = true;</script>`

Save changes and done.


**How to disable fancy category/tag select script?**

USP uses the Chosen.js library to enhance the behavior and appearance of the Category and Tag fields. The enhanced fields will be displayed when either/both of the following are true:

* The option "Multiple Categories" is enabled (for Category field)
* The option "Use Existing Tags" is enabled (for Tag field)

If you want to disable the fancy Chosen script for these fields, you can do so by adding the following code snippet to your WordPress site:

`<script>var usp_disable_chosen = true;</script>`

Save changes and done. Also just FYI, here is a guide that explains [how to add custom code to WordPress](https://digwp.com/2022/02/custom-code-wordpress/).


**How to change the language for Google reCaptcha?**

By default, the Google reCaptcha field is displayed in English. To change that to some other language, first locate the two-digit abbreviation for your language [here](https://developers.google.com/recaptcha/docs/language). Then add the following code to your theme (or child theme) functions.php, or add via [custom plugin](https://digwp.com/2022/02/custom-code-wordpress/):

`function usp_recaptcha_querystring($query) { return 'en'; }
add_filter('usp_recaptcha_querystring', 'usp_recaptcha_querystring');`

Notice where it says `en`, that is the two-character language code you want to replace with your own. Then save changes and done.


**Where can I check out a demo of the USP form?**

There is a simplified [USP Demo](https://perishablepress.com/wp/wp-content/online/pages/user-submitted-posts-demo.html) at Perishable Press. Note the demo form is non-functional, just there to give you a general idea. The actual form provided by the plugin has more features, functionality, etc.


**How to allow blank targets in post content?**

By default, USP removes any `target="_blank"` attributes in submitted post content. This is a recommended security feature. It is possible however to allow blank targets:

`function usp_content_patterns($array) { return array(); }
add_filter('usp_content_patterns', 'usp_content_patterns');`

That code can be added via theme (or child theme) functions.php, or add via [custom plugin](https://digwp.com/2022/02/custom-code-wordpress/).


**How to disable all HTML tags in submitted posts?**

Add the code snippet provided [here](https://perishablepress.com/faqs-user-submitted-posts/#allowed-tags).


**How does the remote delete post link work?**

When `%%delete_link%%` is included in your email alert template, a link will be included that the user can click to delete their submitted post. This works when the user who submitted the post is logged in to WordPress. It does not work for users who are not logged in, or are not the post author. For more details and tips, check out the [USP FAQs](https://perishablepress.com/faqs-user-submitted-posts/#delete-post-message) at Perishable Press.


**How to remove placeholder text on submission form?**

You can either enable the custom form and modify the output/HTML directly, or you can just add the following to the plugin's "Custom Content" option:

`<script>jQuery(document).ready(function($) {
	$('.usp-title label').text('This is the label');
	$('.usp-title input').attr('placeholder', 'This is the placeholder');
});</script>`

Change the two text strings, "This is the label" and "This is the placeholder" to whatever you would like. Then save changes and done.


**More FAQs**

Want to read some more FAQs? Check out the [USP FAQs at Perishable Press](https://perishablepress.com/faqs-user-submitted-posts/)


**Questions? Feedback?**

Send any questions or feedback via my [contact form](https://plugin-planet.com/support/#contact). Thanks! :)



== ✨ Support Development ==

I develop and maintain this free plugin with love for the WordPress community. To show support, you can [make a donation](https://monzillamedia.com/donate.html) or purchase one of my books: 

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)
* [Wizard's SQL Recipes for WordPress](https://books.perishablepress.com/downloads/wizards-collection-sql-recipes-wordpress/)

And/or purchase one of my premium WordPress plugins:

* [BBQ Pro](https://plugin-planet.com/bbq-pro/) - Super fast WordPress firewall
* [Blackhole Pro](https://plugin-planet.com/blackhole-pro/) - Automatically block bad bots
* [Banhammer Pro](https://plugin-planet.com/banhammer-pro/) - Monitor traffic and ban the bad guys
* [GA Google Analytics Pro](https://plugin-planet.com/ga-google-analytics-pro/) - Connect WordPress to Google Analytics
* [Simple Ajax Chat Pro](https://plugin-planet.com/simple-ajax-chat-pro/) - Unlimited chat rooms
* [USP Pro](https://plugin-planet.com/usp-pro/) - Unlimited front-end forms

Links, tweets and likes also appreciated. Thanks! :)



== Changelog ==

*Thank you to everyone who shares feedback for User Submitted Posts!*

If you like USP, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/user-submitted-posts/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!


**20250327**

* Improves sanitization of custom checkbox field
* Tests on WordPress 6.8


**20241026**

* Replaces deprecated function `get_page_by_title()`
* Adds new filter hook `usp_check_duplicates`
* Adds "Show Support" panel to settings page
* Updates plugin settings page
* Updates all translation files
* Updates default translation template
* Tests on WordPress 6.7


Full changelog @ [https://plugin-planet.com/wp/changelog/user-submitted-posts.txt](https://plugin-planet.com/wp/changelog/user-submitted-posts.txt)
