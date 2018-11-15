<?php

/**
 * Definitions needed in the plugin
 *
 * @author Leon de Kraker
 * @version 0.1
 *
 * Version history
 * 0.1 Initial version
 */
// De versie moet gelijk zijn met het versie nummer in de vragenapp.php header

define('VRAGEN_VERSION', '0.0.1');
// Minimum required Wordpress version for this plugin
$test = test;

define('VRAGEN_REQUIRED_WP_VERSION', '4.0');
define('VRAGEN_PLUGIN_BASENAME', plugin_basename(VRAGEN_PLUGIN));
define('VRAGEN_PLUGIN_NAME', trim(dirname(VRAGEN_PLUGIN_BASENAME), '/'));

// Folder structure
define('VRAGEN_PLUGIN_DIR', untrailingslashit(dirname(VRAGEN_PLUGIN)));
define('VRAGEN_PLUGIN_INCLUDES_DIR', VRAGEN_PLUGIN_DIR . '/includes');
define('VRAGEN_PLUGIN_MODEL_DIR', VRAGEN_PLUGIN_INCLUDES_DIR . '/model');
define('VRAGEN_PLUGIN_ADMIN_DIR', VRAGEN_PLUGIN_DIR . '/admin');
define('VRAGEN_PLUGIN_ADMIN_VIEWS_DIR', VRAGEN_PLUGIN_ADMIN_DIR . '/views');
define('VRAGEN_PLUGIN_INCLUDES_VIEWS_DIR', VRAGEN_PLUGIN_INCLUDES_DIR . '/views');
define('VRAGEN_PLUGIN_INCLUDES_IMGS_DIR', VRAGEN_PLUGIN_INCLUDES_DIR . '/imgs');
?>