<?php

    add_action('admin_init','mobileBarColor');

    function mobileBarColor()
    {
        add_settings_field('header_mobile_color','Header Mobile Color','customColor','general');
        register_setting('general','header_mobile_color');

    }

    function customColor(){

        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style( 'wp-color-picker' );

        echo '<input type="text" name="header_mobile_color" id="header_mobile_color" value="'.get_option('header_mobile_color').'">';

        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#header_mobile_color').wpColorPicker();
            });
        </script>
        <?php
    }