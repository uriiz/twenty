    <?php

    require locate_template('classes/class-products-post-type.php');
    require locate_template('classes/class-products-taxonomy.php');
    require locate_template('classes/class-category-endpoint.php');
    require locate_template('fields/class-fields.php');
    require locate_template('fields/gallery-field.php');
    require locate_template('fields/theme-settings.php');

    function twentyTwentyStyles()
    {
        //styles
        wp_enqueue_style('parent', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('main', get_stylesheet_directory_uri() . '/assets/style/main.css', false, null);

        // scripts
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
        wp_enqueue_script('main', get_stylesheet_directory_uri() . '/assets/scripts/main.js');
    }

    add_action('wp_enqueue_scripts', 'twentyTwentyStyles');


    function removeAdminBarFromUserByEmail()
    {

        $currentUser = wp_get_current_user();

        $emails = [
            'wptest@elementor.com'
        ];

        if (in_array($currentUser->user_email, $emails) && !is_admin()) {
            show_admin_bar(false);
        }
    }

    add_action('after_setup_theme', 'removeAdminBarFromUserByEmail');


    //register products post type
    RegisterProductsPostType::create();

    // register products taxonomy
    RegisterProductsTaxonomy::create();


    function productBox($attributes)
    {
        $bgColor = $attributes['bg_color'];
        $productId = $attributes['id'];
        $output = '';

        if (!$bgColor) {
            return 'bg_color is missing';
        }
        if (!$productId) {
            return 'id is missing';
        }

        $product = get_post($productId);

        if (!$product) {
            return 'wrong id';
        }

        $price = number_format( (int) get_post_meta( $productId, 'products_fields_price', true ),2);
        if(get_post_meta( $productId, 'products_fields_price', true )){
            $price = number_format( (int) get_post_meta( $productId, 'products_fields_sale_price', true ),2);
        }

        $output .= '<div class="product-box" style="background-color:' . $bgColor . ' ">';
        $output .= '<div class="image">';
        $output .= '<img src="' . get_the_post_thumbnail_url($product->ID) . '">';
        $output .= '</div>';
        $output .= '<div class="title">';
        $output .= $product->post_title;
        $output .= '</div>';
        $output .= '<div class="price">';
        $output .= '$'.$price;
        $output .= '</div>';
        $output .= '</div>';

        return apply_filters('modify_short_code_box', $output);
    }

    add_shortcode('product-box', 'productBox');



    function modifyBoxShortCode($output)
    {
        return $output;
    }

    add_filter('modify_short_code_box', 'modifyBoxShortCode', 10, 2);







