<?php

/**
 * @file
 * settings.developer.php (Drupal 7.x)
 *
 * This settings file is intended to contain settings specific to a local
 * development environment, by overriding options set in settings.php
 * 
 * This file will be automatically included in the project if it is copied to
 * sites/default/settings.local.php, as settings.php contains the following
 * logic:
 * 
 * if (file_exists(dirname(__FILE__) . '/settings.local.php')) {
 *  require_once(dirname(__FILE__) .'/settings.local.php');
 * }
 *
 *
 * Note: This file should be copied outside of the project folder and renamed
 * to settings.local.php for it to be included in a local environment. This file
 * should not be kept under revision control.
 *
 */

/**
 * Development tool toggles
 */
$_use_devel = FALSE;


/**
 * Local database settings.
 */
$databases['default']['default'] = array(
  'driver' => 'mysql',
  'database' => '',
  'username' => '',
  'password' => '',
  'host' => '',
);

/**
 * Disable caching & aggregation.
 */
$conf['cache'] = 0;
$conf['preprocess_css'] = 0;
$conf['preprocess_js'] = 0;
$conf['block_cache'] = 0;

/**
 * Full error reporting.
 */
$conf['error_level '] = 2;
error_reporting(-1);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

/**
 * Email configuration.
 */
$conf['smtp_host '] = 'mailtrap.io';
$conf['smtp_port '] = 25;
$conf['smtp_username'] = '';
$conf['smtp_password'] = '';

/**
 * Use environment indicator, if available.
 */
$conf['environment_indicator_overwrite'] = TRUE;
$conf['environment_indicator_overwritten_name'] = 'Local development';
$conf['environment_indicator_overwritten_color'] = '#ff5555';
$conf['environment_indicator_overwritten_text_color'] = '#ffffff';
$conf['environment_indicator_overwritten_position'] = 'top';
$conf['environment_indicator_overwritten_fixed'] = FALSE;

/**
 * Devel settings, for easier toggling of functionality.
 */
if ($_use_devel) {
  $conf['dev_query'] = 1;
  $conf['devel_query_display'] = 1;
  $conf['devel_execution'] = 5;
  $conf['devel_store_queries'] = 0;
  $conf['devel_store_random'] = 1;
  $conf['devel_xhprof_enabled'] = 0;
  $conf['devel_xhprof_directory'] =  "/var/www/xhprof";
  $conf['devel_xhprof_url'] =  "http://debianvm/xhprof/xhprof_html";
  $conf['devel_redirect_page'] = 0;
  $conf['devel_query_sort'] = "0";
}
