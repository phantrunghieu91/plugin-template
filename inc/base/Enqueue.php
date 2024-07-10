<?php
/**
 * @package JinsPlugin
 * Enqueue Scripts and Styles
 */
namespace inc\base;

use Inc\Base\BaseController;

class Enqueue extends BaseController
{
  public function register()
  {
    if (is_admin()) {
      add_action('admin_enqueue_scripts', array($this, 'enqueueAdminsScripts'));
    } else {
      add_action('wp_enqueue_scripts', array($this, 'enqueueFrontEndScripts'));
    }
  }

  public function enqueueAdminsScripts()
  {
    wp_enqueue_media();
    wp_enqueue_style('jins-plugin-style', $this->plugin_url . 'assets/css/jins-plugin.min.css', [], null, 'all');
    wp_enqueue_script('jins-plugins-script', $this->plugin_url . 'assets/js/jins-plugin.min.js', ['jquery'], null, true);
  }

  public function enqueueFrontEndScripts()
  {
    // check if login_manager is activated
    if ($this->isActivated('login_manager') && ! is_user_logged_in() ) {
      wp_enqueue_style('jins-plugin-auth', $this->plugin_url . 'assets/css/jins-plugin-auth.min.css', [], null, 'all');
      wp_enqueue_script('jins-plugins-auth', $this->plugin_url . 'assets/js/jins-plugin-auth.min.js', ['jquery'], null, true);
    }
  }
}