<?php get_header(); ?>

<div class="container">
    <div class="single-product">

        <div class="product-image">
            <img src="<?php echo get_the_post_thumbnail_url(); ?>"/>
        </div>

        <?php get_template_part( 'components/product-data', 'data' ); ?>

    </div>
    <div class="related-products">

        <div class="title">
            <h5><?php _e('Related Products','twenty-twenty-child') ?></h5>
        </div>

        <div class="products-loop">

            <?php

            $collectCategoriesIds = [];
            $categories = get_the_terms($post->ID,'product_cat');

            foreach ($categories as $category){
                array_push($collectCategoriesIds,$category->term_id);
            }

            $args = [
                'post_type'       =>  'products',
                'post_status'     =>  'publish',
                'post__not_in'    =>  [$post->ID],
                'order'           =>  'ASC',
                'posts_per_page'  =>  '4',
                'tax_query' => [
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $collectCategoriesIds,
                    ]
                ]
            ];

            $products = new WP_Query($args);
            set_query_var( 'products', $products );
            get_template_part( 'components/loop', 'loop' );
            ?>

        </div>
    </div>
</div>


<?php get_footer() ?>
