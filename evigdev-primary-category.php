<?php

/**
 * Primary Category Plugin
 *
 * @link              https://www.linkedin.com/in/bigmanku/
 * @since             1.0.0
 * @package           Evigdev_Primary_Category
 *
 * @wordpress-plugin
 * Plugin Name:       Primary Category
 * Plugin URI:        https://www.linkedin.com/in/bigmanku/
 * Description:       WordPress plugin that allows publishers to designate a primary category for posts
 * Version:           1.0.0
 * Author:            Aliaksandr Kazhukhouski
 * Author URI:        https://www.linkedin.com/in/bigmanku/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       evigdev-primary-category
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EVIGDEV_PRIMARY_CATEGORY_VERSION', '0.1.0' );

$autoloader = trailingslashit( __DIR__ ) . 'vendor/autoload.php';
if ( file_exists( $autoloader ) ) {
	require_once $autoloader;
}

/**
 * Each functionality part of the plugin is provided via subscribers and is tied to actions and filters.
 * Consequently, we don't need an action to start the plugin.
 */
\EvigDev\PrimaryCategory\Core::instance()->init( __FILE__ );
