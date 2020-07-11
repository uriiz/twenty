<?php
/**
 * Template Name: Home Page
 */
get_header();
?>

<div class="container">

    <div class="products-loop">

        <?php
        $args = [
            'post_type'       =>  'products',
            'post_status'     =>  'publish',
            'order'           =>  'ASC',
            'posts_per_page'  =>  '12',
        ];

        $products = new WP_Query($args);
        set_query_var( 'products', $products );
        get_template_part( 'components/loop', 'loop' );
        ?>

    </div>

    <?php if ( have_posts() ) : ?>
        <div class="home-content">

            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile;?>

        </div>
    <?php endif; ?>
</div>


<?php get_footer(); ?>