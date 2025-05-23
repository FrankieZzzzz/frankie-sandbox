<?php

declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
	// The prefix configuration. If a non null value will be used, a random prefix will be generated.
	'prefix' => 'FacebookFeed\Vendor',

	// By default when running php-scoper add-prefix, it will prefix all relevant code found in the current working
	// directory. You can however define which files should be scoped by defining a collection of Finders in the
	// following configuration key.
	//
	// For more see: https://github.com/humbug/php-scoper#finders-and-paths
	'finders' => [
		Finder::create()
		      ->files()
		      ->ignoreVCS(true)
		      ->in(__DIR__ . '/build/composer/vendor/'),
		Finder::create()->append([
			__DIR__ . '/build/composer/composer.json',
		])
	],


	// When scoping PHP files, there will be scenarios where some of the code being scoped indirectly references the
	// original namespace. These will include, for example, strings or string manipulations. PHP-Scoper has limited
	// support for prefixing such strings. To circumvent that, you can define patchers to manipulate the file to your
	// heart contents.
	//
	// For more see: https://github.com/humbug/php-scoper#patchers
	'patchers' => [
		function (string $filePath, string $prefix, string $contents): string {
			// Change the contents here.

			return $contents;
		},
	],

	// PHP-Scoper's goal is to make sure that all code for a project lies in a distinct PHP namespace. However, you
	// may want to share a common API between the bundled code of your PHAR and the consumer code. For example if
	// you have a PHPUnit PHAR with isolated code, you still want the PHAR to be able to understand the
	// PHPUnit\Framework\TestCase class.
	//
	// A way to achieve this is by specifying a list of classes to not prefix with the following configuration key. Note
	// that this does not work with functions or constants neither with classes belonging to the global namespace.
	//
	// Fore more see https://github.com/humbug/php-scoper#whitelist

	// If `true` then the user defined constants belonging to the global namespace will not be prefixed.
	//
	// For more see https://github.com/humbug/php-scoper#constants--constants--functions-from-the-global-namespace
	'expose-global-constants' => true,

	// If `true` then the user defined functions belonging to the global namespace will not be prefixed.
	//
	// For more see https://github.com/humbug/php-scoper#constants--constants--functions-from-the-global-namespace
	'expose-global-functions' => true,
	'exclude-namespaces' => ['Smashballoon\Framework', 'CustomFacebookFeed'],
	'exclude-files' => ['/(\/templates\/.+?)\.php$/'],
];