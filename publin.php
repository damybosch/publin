<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Publin
 *
 * @wordpress-plugin
 * Plugin Name:       Publin Online Publicaties
 * Description:       Online publiceren van magazines / tijdschriften
 * Version:           1.0.0
 * Author:            Damy Bosch | Advice
 * Author URI:        https://www.advice.nl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       publin
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
define( 'PUBLIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-publin-activator.php
 */
function activate_publin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-publin-activator.php';
	Publin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-publin-deactivator.php
 */
function deactivate_publin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-publin-deactivator.php';
	Publin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_publin' );
register_deactivation_hook( __FILE__, 'deactivate_publin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-publin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_publin() {

	$plugin = new Publin();
	$plugin->run();

}
run_publin();
