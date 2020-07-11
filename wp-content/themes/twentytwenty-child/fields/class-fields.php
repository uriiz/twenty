<?php

class Rational_Meta_Box {

    private $screens = [
        'products',
    ];

    private $fields = [
        [
            'id' => 'price',
            'label' => 'Price',
            'type' => 'text',
        ],
        [
            'id' => 'sale_price',
            'label' => 'Sale Price',
            'type' => 'text',
        ],
        [
            'id' => 'is_on_sale',
            'label' => 'Is On Sale',
            'type' => 'checkbox',
        ],
        [
            'id' => 'youtube_link',
            'label' => 'Youtube Link',
            'type' => 'text',
        ],
    ];


    public function __construct() {
        add_action( 'add_meta_boxes', [$this, 'addMetaBoxes']);
        add_action( 'save_post', [$this, 'savePost']);
    }


    public function addMetaBoxes() {
        foreach ( $this->screens as $screen ) {
            add_meta_box(
                'products-fields',
                __( 'Products Fields', 'twenytweny-child' ),
                [$this, 'addMetaBoxCallback'],
                $screen,
                'advanced',
                'default'
            );
        }
    }

    public function addMetaBoxCallback( $post ) {
        wp_nonce_field( 'products_fields_data', 'products_fields_nonce' );
        $this->generateFields( $post );
    }


    public function generateFields( $post ) {

        $output = '';

        foreach ( $this->fields as $field ) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $db_value = get_post_meta( $post->ID, 'products_fields_' . $field['id'], true );
            switch ( $field['type'] ) {
                case 'checkbox':
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="checkbox" value="1">',
                        $db_value === '1' ? 'checked' : '',
                        $field['id'],
                        $field['id']
                    );
                    break;
                default:
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        $field['type'] !== 'color' ? 'class="regular-text"' : '',
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        $db_value
                    );
            }
            $output .= $this->rowFormat( $label, $input );
        }
        echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
    }


    public function rowFormat( $label, $input ) {
        return sprintf(
            '<tr><th scope="row">%s</th><td>%s</td></tr>',
            $label,
            $input
        );
    }


    public function savePost( $post_id ) {
        if ( ! isset( $_POST['products_fields_nonce'] ) )
            return $post_id;

        $nonce = $_POST['products_fields_nonce'];
        if ( !wp_verify_nonce( $nonce, 'products_fields_data' ) )
            return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        foreach ( $this->fields as $field ) {
            if ( isset( $_POST[ $field['id'] ] ) ) {
                switch ( $field['type'] ) {
                    case 'email':
                        $_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
                        break;
                    case 'text':
                        $_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
                        break;
                }
                update_post_meta( $post_id, 'products_fields_' . $field['id'], $_POST[ $field['id'] ] );
            } else if ( $field['type'] === 'checkbox' ) {
                update_post_meta( $post_id, 'products_fields_' . $field['id'], '0' );
            }
        }
    }
}
new Rational_Meta_Box;