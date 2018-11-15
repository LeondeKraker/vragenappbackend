<?php

/**
 * Plugin Name: VragenApp
 * Plugin URI: < your plugin url >
 * Description: Plugin voor het versturen van vragen
 * Author: Leon de Kraker
 * Author URI: < your uri >
 * Version: 0.0.1
 * Text Domain: VragenApp
 * Domain Path: languages
 *
 * This is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with your plugin. If not, see <http://www.gnu.org/licenses/>.
 */
// Define the plugin name:
define('VRAGEN_PLUGIN', __FILE__);
// Include the general definition file:
require_once plugin_dir_path(__FILE__) . 'includes/defs.php';

class VragenApp
{

    public function __construct()
    {
        // Fire a hook before the class is setup.
        do_action('vragen_pre_init');
        // Load the plugin.
        add_action('init', array($this, 'init'), 1);
    }

    //Loads the plugin into WordPress.
    public function init()
    {
        // Run hook once Plugin has been initialized.
        do_action('vragen_init');
        // Load admin only components.
        if (is_admin()) {
            // Load all admin specific includes
            $this->requireAdmin();
            // Setup admin page
            $this->createAdmin();
        }
        // Load the view shortcodes
        $this->loadViews();
    }

    // Loads all admin related files into scope.
    public function requireAdmin()
    {
        // Admin controller file
        require_once VRAGEN_PLUGIN_ADMIN_DIR .
            '/VragenApp_AdminController.php';
    }

    // Admin controller functionality
    public function createAdmin()
    {
        VragenApp_AdminController::prepare();
    }

    // Load the view shortcodes:
    public function loadViews()
    {
        include VRAGEN_PLUGIN_INCLUDES_VIEWS_DIR . '/view_shortcodes.php';
    }
}
// Instantiate the class
$vragen_app = new VragenApp();
?>