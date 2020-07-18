<?php

class ShortCode
{
    public function __construct()
    {

        add_shortcode('user_form', [$this,'formShortCode']);
    }

    function formShortCode($attributes)
    {

        $id = $attributes['id'];
        $formSetting = $this->formSetting($id);

        if($formSetting['only_members']){

            if ( !is_user_logged_in() ){
                return '';
            }

        }


        $atts = shortcode_atts(array(
            'file' => plugin_dir_path(__FILE__).'templates/default.php'
        ), $attributes);

        if(!$atts['file']) return '';

        $file_path = plugin_dir_path(__FILE__).'templates/default.php';
        if(!file_exists($file_path)) return '';

        ob_start();
        include($file_path);
        $html = ob_get_contents();
        ob_end_clean();
        return $html;

    }


    protected function formSetting($id)
    {
        $setting = [];
        $setting['post_type'] = get_post_meta( $id , 'user_forms_post-type', true );
        $setting['status'] = get_post_meta( $id , 'user_forms_status', true ) ? get_post_meta( $id , 'user_forms_status', true ) : 'draft' ;
        $setting['only_members'] = get_post_meta( $id , 'user_forms_only-login-member', true );

        return $setting;
    }
}
new ShortCode();