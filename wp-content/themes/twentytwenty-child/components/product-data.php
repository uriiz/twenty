<div class="product-data">

    <div class="title">
        <h1><?php the_title(); ?></h1>
    </div>

    <?php if ( have_posts() ) : ?>
        <div class="description">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile;?>
        </div>
    <?php endif; ?>

    <div class="prices">

        <?php

        $isOnSale = get_post_meta( $post->ID, 'products_fields_is_on_sale', true );
        $price = number_format( (int) get_post_meta( $post->ID, 'products_fields_price', true ),2);

        if (get_post_meta( $post->ID, 'products_fields_sale_price', true )){
            $salePrice = number_format( (int) get_post_meta( $post->ID, 'products_fields_sale_price', true ),2);
        }else{
            $salePrice = false;
        }

        ?>

        <div class="regular-price">
            <?php if( $isOnSale && $salePrice ): ?>

                <p><del>$<?php echo $price ?></del></p>

            <?php else: ?>

                <p>$<?php echo $price ?></p>

            <?php endif ?>
        </div>
        <?php if( $isOnSale && $salePrice ): ?>
            <div class="sale-price">

                <p>$<?php echo $salePrice ?></p>

            </div>
        <?php endif ?>
    </div>

    <div class="gallery">

        <?php $images = get_post_meta($post->ID, 'vdw_gallery_id', true); ?>

        <?php if(!empty($images)): ?>

            <div class="image">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>"/>
            </div>

            <?php foreach ($images as $imageId): ?>

                <div class="image">
                    <img src="<?php echo wp_get_attachment_image_src($imageId,'full')[0] ?>" alt="">
                </div>

            <?php endforeach; ?>
        <?php endif ?>

    </div>

    <?php if($video = get_post_meta( $post->ID, 'products_fields_youtube_link', true )): ?>
    <div class="video">
        <h5><?php _e('Video','twentytwenty-child') ?></h5>
        <iframe width="100%"
                src="<?php echo $video ?>"
                frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
        </iframe>
    </div>
    <?php endif ?>

</div>