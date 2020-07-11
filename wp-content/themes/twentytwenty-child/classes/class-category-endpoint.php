<?php

if (!defined('ABSPATH')) {
    exit;
}

class CategoryEndPoint
{

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'categoryId']);
    }

    public function categoryId()
    {
        register_rest_route('v1', '/category-id/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'getCategoryProductsById'],
        ]);

        register_rest_route('v1', '/category-name/(?P<name>[a-zA-Z0-9%]+)', [
            'methods' => 'GET',
            'callback' => [$this, 'getCategoryProductsByName'],
        ]);
    }

    public function getCategoryProductsByName(WP_REST_Request $request)
    {

        $fixSpacesFromUrl = str_replace('%20',' ',$request->get_params());

        $productsIds = get_posts([
            'post_type' => 'products',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => [
                $this->setDynamicQuery('name',$fixSpacesFromUrl)
            ]
        ]);

        if (empty($productsIds)) {
            return null;
        }

        return $this->filterProductFields($productsIds);
    }

    public function getCategoryProductsById(WP_REST_Request $request)
    {
        $productsIds = get_posts([
            'post_type' => 'products',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => [
                $this->setDynamicQuery('id',$request->get_params())
            ]
        ]);

        if (empty($productsIds)) {
            return null;
        }

        return $this->filterProductFields($productsIds);

    }

    public function setDynamicQuery($type, $urlParam)
    {
        if( !$type ){
            return;
        }

        if($type == 'name'){
            return [
                'taxonomy' => 'product_cat',
                'field' => 'name',
                'terms' => $urlParam,
            ];
        }

        if($type == 'id'){
            return [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $urlParam,
            ];
        }

    }

    public function filterProductFields($productsIds)
    {
        return array_map(function ($id) {

            $price = number_format( (int) get_post_meta( $id , 'products_fields_price', true ),2);
            $isOnSale = get_post_meta( $id , 'products_fields_is_on_sale', true );
            $salePrice = number_format( (int) get_post_meta( $id , 'products_fields_sale_price', true ),2);;

            return [
                'title' => get_the_title($id),
                'description' => get_post($id)->post_content,
                'image' => get_the_post_thumbnail_url($id),
                'is_on_sale' => $isOnSale ? true : false,
                'price' => $price,
                'sale_price' => $salePrice != '0.00' ? $salePrice : false,
            ];
        }, $productsIds);

    }
}

new CategoryEndPoint();