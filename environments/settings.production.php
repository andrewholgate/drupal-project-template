<?php

/**
 * @file
 * settings.production.php (Drupal 7.x)
 *
 * This settings file is intended to contain settings for the production environment
 * by overriding options set in settings.php
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
 * to settings.local.php for it to be included in the production environment.
 * This file should not be kept under revision control.
 *
 */

/**
 * Production database settings.
 */
$databases['default']['default'] = array(
  'driver' => 'mysql',
  'database' => '',
  'username' => '',
  'password' => '',
  'host' => '',
);
