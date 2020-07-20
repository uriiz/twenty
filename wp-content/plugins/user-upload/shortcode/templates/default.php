<div class="user-forms-wrap">

    <?php if (get_post_type(get_the_ID()) != 'user_forms'): ?>
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
    <?php endif ?>
    <?php
            $message = $formSetting['message'] ? $formSetting['message'] : 'Thank You'
    ?>
    <form class="user-form">
        <input type="hidden" id="user-form-post-type" value="<?php echo $formSetting['post_type'] ?>">
        <input type="hidden" id="user-form-status" value="<?php echo $formSetting['status'] ?>">
        <input type="hidden" id="user-form-success" value="<?php echo $message ?>">
        <input type="hidden" id="user-form-error" value="Wrong">
        <div class="wrap-input">
            <input type="text"
                   id="user-form-post-title"
                   placeholder="<?php _e('Title', TEXT_DOMAIN) ?>"
            >
        </div>

        <div class="wrap-input">
            <textarea
                    placeholder="<?php _e('Content', TEXT_DOMAIN) ?>"
                    id="user-form-post-content"
            ></textarea>
        </div>
        <?php if ($formSetting['has_price']): ?>
            <div class="wrap-input">
                <input type="number"
                       id="user-form-price"
                       placeholder="<?php _e('Price', TEXT_DOMAIN) ?>"
                >
            </div>
        <?php endif; ?>

        <?php if ($formSetting['quantity']): ?>
            <div class="wrap-input">
                <input type="number"
                       id="user-form-quantity"
                       placeholder="<?php _e('Quantity', TEXT_DOMAIN) ?>"
                >
            </div>
        <?php endif; ?>


        <?php if ($formSetting['sku']): ?>
            <div class="wrap-input">
                <input type="text"
                       id="user-form-sku"
                       placeholder="<?php _e('Sku', TEXT_DOMAIN) ?>"
                >
            </div>
        <?php endif; ?>


        <?php if ($formSetting['thumbnail']): ?>
            <div class="wrap-input wrap-input-upload">
                <button type="button" class="upload-image-user-forms">
                    <?php _e('Upload Image', TEXT_DOMAIN) ?>
                </button>
                <input type='file' id="imgInp" accept='image/*'/>
                <img style="display: none" id="user-form-thumbnail" src="#" alt="your image"/>
            </div>

        <?php endif; ?>

        <div class="wrap-input wrap-input-submit">

            <button type="submit" id="user-form-submit">

                <div>
                    <?php _e('Submit', TEXT_DOMAIN) ?>
                </div>
                <div class="load">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
    <g>
        <path d="M256.001,0c-8.284,0-15,6.716-15,15v96.4c0,8.284,6.716,15,15,15s15-6.716,15-15V15C271.001,6.716,264.285,0,256.001,0z"
        />
    </g>
</g>
                        <g>
                            <g>
                                <path d="M256.001,385.601c-8.284,0-15,6.716-15,15V497c0,8.284,6.716,15,15,15s15-6.716,15-15v-96.399
			C271.001,392.316,264.285,385.601,256.001,385.601z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M196.691,123.272l-48.2-83.485c-4.142-7.175-13.316-9.633-20.49-5.49c-7.174,4.142-9.632,13.316-5.49,20.49l48.2,83.485
			c2.778,4.813,7.82,7.502,13.004,7.502c2.545,0,5.124-0.648,7.486-2.012C198.375,139.62,200.833,130.446,196.691,123.272z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M389.491,457.212l-48.199-83.483c-4.142-7.175-13.316-9.633-20.49-5.49c-7.174,4.142-9.632,13.316-5.49,20.49
			l48.199,83.483c2.778,4.813,7.82,7.502,13.004,7.502c2.545,0,5.124-0.648,7.486-2.012
			C391.175,473.56,393.633,464.386,389.491,457.212z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M138.274,170.711L54.788,122.51c-7.176-4.144-16.348-1.685-20.49,5.49c-4.142,7.174-1.684,16.348,5.49,20.49
			l83.486,48.202c2.362,1.364,4.941,2.012,7.486,2.012c5.184,0,10.226-2.69,13.004-7.503
			C147.906,184.027,145.448,174.853,138.274,170.711z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M472.213,363.51l-83.484-48.199c-7.176-4.142-16.349-1.684-20.49,5.491c-4.142,7.175-1.684,16.349,5.49,20.49
			l83.484,48.199c2.363,1.364,4.941,2.012,7.486,2.012c5.184,0,10.227-2.69,13.004-7.502
			C481.845,376.825,479.387,367.651,472.213,363.51z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M111.401,241.002H15c-8.284,0-15,6.716-15,15s6.716,15,15,15h96.401c8.284,0,15-6.716,15-15
			S119.685,241.002,111.401,241.002z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M497,241.002h-96.398c-8.284,0-15,6.716-15,15s6.716,15,15,15H497c8.284,0,15-6.716,15-15S505.284,241.002,497,241.002z"
                                />
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M143.765,320.802c-4.142-7.175-13.314-9.633-20.49-5.49l-83.486,48.2c-7.174,4.142-9.632,13.316-5.49,20.49
			c2.778,4.813,7.82,7.502,13.004,7.502c2.545,0,5.124-0.648,7.486-2.012l83.486-48.2
			C145.449,337.15,147.907,327.976,143.765,320.802z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M477.702,128.003c-4.142-7.175-13.315-9.632-20.49-5.49l-83.484,48.2c-7.174,4.141-9.632,13.315-5.49,20.489
			c2.778,4.813,7.82,7.503,13.004,7.503c2.544,0,5.124-0.648,7.486-2.012l83.484-48.2
			C479.386,144.351,481.844,135.177,477.702,128.003z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M191.201,368.239c-7.174-4.144-16.349-1.685-20.49,5.49l-48.2,83.485c-4.142,7.174-1.684,16.348,5.49,20.49
			c2.362,1.364,4.941,2.012,7.486,2.012c5.184,0,10.227-2.69,13.004-7.502l48.2-83.485
			C200.833,381.555,198.375,372.381,191.201,368.239z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M384.001,34.3c-7.175-4.144-16.349-1.685-20.49,5.49l-48.199,83.483c-4.143,7.174-1.685,16.348,5.49,20.49
			c2.362,1.364,4.941,2.012,7.486,2.012c5.184,0,10.226-2.69,13.004-7.502l48.199-83.483
			C393.633,47.616,391.175,38.442,384.001,34.3z"/>
                            </g>

                        </svg>
                </div>
            </button>
        </div>

    </form>

</div>
