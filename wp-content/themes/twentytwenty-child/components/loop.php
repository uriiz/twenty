<?php while ($products->have_posts()) : $products->the_post(); ?>
    <div class="product-item">
        <a href="<?php the_permalink() ?>">
            <?php if(get_post_meta( $post->ID, 'products_fields_is_on_sale', true ) && get_post_meta( $post->ID, 'products_fields_sale_price', true )): ?>
                <div class="sale">
                    <?php _e('SALE', 'twenty-twenty-child') ?>
                </div>
            <?php endif; ?>
            <div class="overflow-wrap">
                <div class="image">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>"
                         title="<?php the_title(); ?>"
                         alt="<?php the_title(); ?>">
                </div>
            </div>
            <div class="title">
                <p><?php the_title(); ?></p>
            </div>
        </a>
    </div>
<?php endwhile;
wp_reset_query(); ?>