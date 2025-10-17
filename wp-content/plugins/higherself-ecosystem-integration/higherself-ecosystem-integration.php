<?php
/**
 * Plugin Name: HigherSelf Ecosystem Integration
 * Plugin URI: https://github.com/Utak-West/utakwest.com
 * Description: Integrates WooCommerce, Amelia Booking, and CRM systems across the HigherSelf Network ecosystem
 * Version: 1.0.0
 * Author: Utak West
 * Author URI: https://utakwest.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: higherself-ecosystem
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 */
define( 'HIGHERSELF_ECOSYSTEM_VERSION', '1.0.0' );

/**
 * Plugin directory path
 */
define( 'HIGHERSELF_ECOSYSTEM_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin directory URL
 */
define( 'HIGHERSELF_ECOSYSTEM_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function activate_higherself_ecosystem() {
    require_once HIGHERSELF_ECOSYSTEM_PATH . 'includes/class-higherself-ecosystem-activator.php';
    HigherSelf_Ecosystem_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_higherself_ecosystem() {
    require_once HIGHERSELF_ECOSYSTEM_PATH . 'includes/class-higherself-ecosystem-deactivator.php';
    HigherSelf_Ecosystem_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_higherself_ecosystem' );
register_deactivation_hook( __FILE__, 'deactivate_higherself_ecosystem' );

/**
 * The core plugin class
 */
require HIGHERSELF_ECOSYSTEM_PATH . 'includes/class-higherself-ecosystem.php';

/**
 * Begins execution of the plugin.
 */
function run_higherself_ecosystem() {
    $plugin = new HigherSelf_Ecosystem();
    $plugin->run();
}
run_higherself_ecosystem();

