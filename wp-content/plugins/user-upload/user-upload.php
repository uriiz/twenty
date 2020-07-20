<?php
/**
 * Plugin Name: User Upload
 * Description: Build a form for users to upload posts
 * Plugin URI: https://github.com/uriiz/twenty
 * Author: Uri Izhaki
 * Version: 1.0
 * Author URI: https://github.com/uriiz/
 *
 * Text Domain: user-upload
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path(__FILE__).'ajax/Upload.php';
require_once plugin_dir_path(__FILE__).'classes/Activate.php';
require_once plugin_dir_path(__FILE__).'admin/forms/Forms.php';
require_once plugin_dir_path(__FILE__).'shortcode/ShortCode.php';



define('TEXT_DOMAIN','user-upload');
define( 'UF_VERSION', '5.1.9' );

class UserUploadPlugin
{
    public $activate ;
    public $deactivate;


    public function __construct()
    {
        $this->activate = new Activate();
        add_action( 'init', [$this->activate,'createFormPostType'] );
        add_action('admin_menu',[$this->activate,'addMenuPage']);
        add_action('wp_enqueue_scripts', [$this,'includes']);
        add_action('admin_enqueue_scripts', [$this,'includesAdmin']);
        add_filter( 'the_content', [$this,'insertFormToSingle'] );

    }


    public function insertFormToSingle($content)
    {
        if(get_post_type(get_the_ID()) == 'user_forms'){

            $form = do_shortcode('[user_form id ="'.get_the_ID().'"]');
            $content = $content.$form;

            return $content;
        }

        return $content;
    }

    public function activate()
    {
       $this->activate->createFormPostType();
       flush_rewrite_rules();
    }

    public function deactivate()
    {
        flush_rewrite_rules();
    }


    public function includesAdmin()
    {
        wp_enqueue_style('user-form', plugins_url() . '/user-upload/assets/style/admin.css', false, null);
        wp_enqueue_script('main', plugins_url() . '/user-upload/assets/scripts/admin.js');
    }

    public function includes()
    {
        wp_enqueue_style('user-form', plugins_url() . '/user-upload/assets/style/user-form.css', false, null);

        // scripts
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
        wp_enqueue_script('sweet-alerts', 'https://cdn.jsdelivr.net/npm/sweetalert2@9', array(), 1, true);
        wp_enqueue_script('main', plugins_url() . '/user-upload/assets/scripts/main.js');
    }


}

if( class_exists('UserUploadPlugin')){
    $userUpload = new UserUploadPlugin();
}


register_activation_hook(__FILE__,[$userUpload,'activate']);
register_deactivation_hook(__FILE__,[$userUpload,'deactivate']);
