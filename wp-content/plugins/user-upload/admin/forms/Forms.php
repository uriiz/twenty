<?php

class Forms
{
    private $postTypes = [];

    private $screens = [
        'user_forms',
    ];
    private $fields = [
        [
            'id' => 'post-type',
            'label' => 'Post Type',
            'type' => 'select',
        ],
        [
            'id' => 'status',
            'label' => 'Status After Upload',
            'type' => 'select',
            'options' => [
                'publish',
                'draft',
            ]
        ],
        [
            'id' => 'only-login-member',
            'label' => 'Only Login Member ?',
            'type' => 'checkbox',
        ],
        [
            'id' => 'upload-image',
            'label' => 'Upload Thumbnail ?',
            'type' => 'checkbox',
        ],
        [
            'id' => 'short-code',
            'label' => 'Short Code',
            'type' => 'text',

        ],
    ];

    /**
     * Class construct method. Adds actions to their respective WordPress hooks.
     */
    public function __construct()
    {

        add_action('init', function () {
            $types = get_post_types([], 'object');

            $removePostType = [
                'attachment',
                'revision',
                'nav_menu_item',
                'custom_css',
                'customize_changeset',
                'oembed_cache',
                'user_request',
                'wp_block'
            ];

            foreach ($types as $type) {
                if (in_array($type->name, $removePostType)) {
                    continue;
                }
                array_push($this->postTypes, $type->name);
            }
        }, 10);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_post']);
    }

    /**
     * Hooks into WordPress' add_meta_boxes function.
     * Goes through screens (post types) and adds the meta box.
     */
    public function add_meta_boxes()
    {
        foreach ($this->screens as $screen) {
            add_meta_box(
                'user-forms',
                __('Form Options', 'user_forms'),
                [$this, 'add_meta_box_callback'],
                $screen,
                'advanced',
                'default'
            );
        }
    }

    /**
     * Generates the HTML for the meta box
     *
     * @param object $post WordPress post object
     */
    public function add_meta_box_callback($post)
    {
        wp_nonce_field('user_forms_data', 'user_forms_nonce');
        $this->generate_fields($post);
    }

    /**
     * Generates the field's HTML for the meta box.
     */
    public function generate_fields($post)
    {
        $output = '';
        foreach ($this->fields as $field) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $db_value = get_post_meta($post->ID, 'user_forms_' . $field['id'], true);
            switch ($field['type']) {
                case 'checkbox':
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="checkbox" value="1">',
                        $db_value === '1' ? 'checked' : '',
                        $field['id'],
                        $field['id']
                    );
                    break;
                case 'select':
                    $input = sprintf(
                        '<select id="%s" name="%s">',
                        $field['id'],
                        $field['id']
                    );
                    if($field['id'] != 'status'){
                        $field['options'] = $this->postTypes;
                    }

                    foreach ($field['options'] as $key => $value) {
                        $field_value = !is_numeric($key) ? $key : $value;
                        $input .= sprintf(
                            '<option %s value="%s">%s</option>',
                            $db_value === $field_value ? 'selected' : '',
                            $field_value,
                            $value
                        );
                    }
                    $input .= '</select>';
                    break;
                default:

                    if($field['id'] != 'short-code'){
                        $input = sprintf(
                            '<input %s id="%s" name="%s" type="%s" value="%s">',
                            $field['type'] !== 'color' ? 'class="regular-text"' : '',
                            $field['id'],
                            $field['id'],
                            $field['type'],
                            $db_value
                        );
                    }else{
                        $input = sprintf(
                            '<input readonly %s id="%s" name="%s" type="%s" value="%s">',
                            $field['type'] !== 'color' ? 'class="regular-text"' : '',
                            $field['id'],
                            $field['id'],
                            $field['type'],
                            $db_value
                        );
                    }

            }
            $output .= $this->row_format($label, $input);
        }
        echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
    }

    /**
     * Generates the HTML for table rows.
     */
    public function row_format($label, $input)
    {
        return sprintf(
            '<tr><th scope="row">%s</th><td>%s</td></tr>',
            $label,
            $input
        );
    }

    /**
     * Hooks into WordPress' save_post function
     */
    public function save_post($post_id)
    {
        if (!isset($_POST['user_forms_nonce']))
            return $post_id;

        $nonce = $_POST['user_forms_nonce'];
        if (!wp_verify_nonce($nonce, 'user_forms_data'))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        foreach ($this->fields as $field) {
            if (isset($_POST[$field['id']])) {
                switch ($field['type']) {
                    case 'email':
                        $_POST[$field['id']] = sanitize_email($_POST[$field['id']]);
                        break;
                    case 'text':
                        $_POST[$field['id']] = sanitize_text_field($_POST[$field['id']]);
                        break;
                }

                if($field['id'] != 'short-code'){
                    update_post_meta($post_id, 'user_forms_' . $field['id'], $_POST[$field['id']]);
                }else{
                    $shortCode = '[user_form id =';
                    $shortCode .= $post_id;
                    $shortCode .= ']';

                    update_post_meta($post_id, 'user_forms_' . $field['id'], $shortCode);
                }


            } else if ($field['type'] === 'checkbox') {
                update_post_meta($post_id, 'user_forms_' . $field['id'], '0');
            }
        }
    }
}

new Forms;