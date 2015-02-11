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
$_use_devel = 0;


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
$conf['error_level'] = 2;
error_reporting(-1);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

/**
 * Email configuration.
 */
$conf['smtp_host'] = 'mailtrap.io';
$conf['smtp_port'] = 25;
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
  $conf['devel_query_display'] = 1;
  $conf['devel_execution'] = 5;
  $conf['dev_timer'] = 1;
  $conf['devel_memory'] = 1;
  $conf['devel_query_sort'] = 0;
  $conf['devel_page_alter'] = 0;
  $conf['devel_raw_names'] = 0;
  $conf['devel_rebuild_theme_registry'] = 0;
  $conf['admin_menu_display'] = 'plid';
  $conf['admin_menu_show_all'] = 0;

  $conf['devel_redirect_page'] = 1;
  $conf['devel_error_handlers'] = array(0,1,2,3,4);
  $conf['devel_krumo_skin'] = 'blue';

  $conf['devel_use_uncompressed_jquery'] = 1;

  // XHProf settings.
  $conf['devel_xhprof_enabled'] = 1;
  $conf['devel_xhprof_directory'] =  "/usr/share/php";
  $conf['devel_xhprof_url'] =  "/xhprof_html";
}

