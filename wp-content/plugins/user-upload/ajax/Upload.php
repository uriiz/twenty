<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Upload
{
    public function __construct()
    {
        add_action('wp_ajax_upload_post', [$this, 'uploadPost']);
        add_action('wp_ajax_nopriv_upload_post', [$this, 'uploadPost']);
    }

    public function uploadPost()
    {

        $postId = wp_insert_post([
            'post_title' => $_POST['title'] ,
            'post_content' => $_POST['content'] ,
            'post_status' => $_POST['status'],
            'post_author' => get_current_user_id() ? get_current_user_id() : 1,
            'post_type' => $_POST['post_type']
        ]);


          if($_POST['post_type'] == 'product'){

              update_post_meta( $postId, '_regular_price', $_POST['price'] );
              update_post_meta( $postId, '_sku', $_POST['sku'] );

              if($_POST['quantity']){
                  update_post_meta( $postId, '_stock', $_POST['quantity'] );
                  update_post_meta( $postId, '_manage_stock', 'yes' );
              }

          }

          if ($_POST['thumbnail']){

              $imageId = $this->uploadMedia($_POST['thumbnail']);
              set_post_thumbnail($postId,$imageId);

          }
        wp_die();
    }

    public function uploadMedia($imageBase)
    {

        $upload_dir = wp_upload_dir();
        $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
        $img = $imageBase;


        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        $decoded = base64_decode($img) ;

        $filename = 'configurator.png';
        $hashed_filename  = md5( $filename . microtime() ) . '_' . $filename;
        $image_upload  = file_put_contents( $upload_path . $hashed_filename, $decoded );

        if( !function_exists( 'wp_handle_sideload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        if( !function_exists( 'wp_get_current_user' ) ) {
            require_once( ABSPATH . 'wp-includes/pluggable.php' );
        }

        $file             = array();
        $file['error']    = '';
        $file['tmp_name'] = $upload_path . $hashed_filename;
        $file['name']     = $hashed_filename;
        $file['type']     = 'image/png';
        $file['size']     = filesize( $upload_path . $hashed_filename );

        $file_return      = wp_handle_sideload( $file, array( 'test_form' => false ) );

        $filename = $file_return['file'];
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $upload_dir['url'] . '/' . basename($filename)
        );
        $attach_id = wp_insert_attachment( $attachment, $filename, 289 );


        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
        wp_update_attachment_metadata( $attach_id, $attach_data );


        return $attach_id;
    }
}

new Upload();