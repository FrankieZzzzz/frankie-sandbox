<?php

// load theme child functions
require_once "functions/theme_child_functions.php";

// ACF
require_once "functions/theme_acf.php";

// unfiltered_html capability override
require_once "functions/remove_kses.php";

// load custom visual composer functions
require_once "functions/theme_vc.php";

// Shortcodes
require_once "functions/theme_shortcodes.php";

// Custom Post Types
require_once "functions/theme_cpt.php";

// Mmenu
require_once "functions/includes/autoload_class/MmenuMenuWalker.php";
