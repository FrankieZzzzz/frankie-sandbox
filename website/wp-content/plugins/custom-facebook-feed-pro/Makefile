.PHONY: generate-svgs package

generate-svgs:
	php build/custom-facebook-feed-pro/generate-svgs.php
package: generate-svgs
	./vendor/smashballoon/smash-bundler/bin/bundler . custom-facebook-feed-pro