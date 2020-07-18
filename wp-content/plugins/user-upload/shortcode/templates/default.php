
<div class="user-forms-wrap">
    <div class="user-forms-title">
        <h2><?php echo get_the_title($id) ?></h2>
    </div>

    <div class="user-forms-content">
        <?php
                $contentPost = get_post($id);
                $content = $contentPost->post_content;
                echo $content;
        ?>
    </div>

    <form class="user-form">
        <input type="hidden" id="user-form-post-type" value="<?php echo $formSetting['post_type'] ?>">
        <input type="hidden" id="user-form-status" value="<?php echo $formSetting['status'] ?>">
        <div class="wrap-input">
            <input type="text"
                   id="user-form-post-title"
                   placeholder="<?php _e('Title',TEXT_DOMAIN) ?>"
            >
        </div>

        <div class="wrap-input">
            <textarea
                placeholder="<?php _e('Content',TEXT_DOMAIN) ?>"
                id="user-form-post-content"
            ></textarea>
        </div>

        <div class="wrap-input">
            <input type='file' id="imgInp" />
            <img style="display: none" id="user-form-thumbnail" src="#" alt="your image" />
        </div>

        <div class="wrap-input wrap-input-submit">
            <input
                value="<?php _e('Submit',TEXT_DOMAIN) ?>"
                id="user-form-submit"
                type="submit">

        </div>

    </form>

</div>
