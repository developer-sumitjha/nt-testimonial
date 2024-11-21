<?php

/**
 * Register a custom post type called "testimonial".
 *
 * @see get_post_type_labels() for label keys.
 */
function testimonial_init() {
	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post type general name', 'textdomain' ),
		'singular_name'         => _x( 'Testimonial', 'Post type singular name', 'textdomain' ),
		'menu_name'             => _x( 'Testimonials', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar'        => _x( 'Testimonial', 'Add New on Toolbar', 'textdomain' ),
		'add_new'               => __( 'Add New', 'textdomain' ),
		'add_new_item'          => __( 'Add New Testimonial', 'textdomain' ),
		'new_item'              => __( 'New Testimonial', 'textdomain' ),
		'edit_item'             => __( 'Edit Testimonial', 'textdomain' ),
		'view_item'             => __( 'View Testimonial', 'textdomain' ),
		'all_items'             => __( 'All Testimonials', 'textdomain' ),
		'search_items'          => __( 'Search Testimonials', 'textdomain' ),
		'parent_item_colon'     => __( 'Parent Testimonials:', 'textdomain' ),
		'not_found'             => __( 'No testimonials found.', 'textdomain' ),
		'not_found_in_trash'    => __( 'No testimonials found in Trash.', 'textdomain' ),
		'featured_image'        => _x( 'Testimonial Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'set_featured_image'    => _x( 'Set image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'remove_featured_image' => _x( 'Remove image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'use_featured_image'    => _x( 'Use as image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'archives'              => _x( 'Testimonial archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
		'insert_into_item'      => _x( 'Insert into testimonial', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this testimonial', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
		'filter_items_list'     => _x( 'Filter testimonials list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
		'items_list_navigation' => _x( 'Testimonials list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
		'items_list'            => _x( 'Testimonials list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions'),
		'menu_icon'			 => 'dashicons-portfolio'
	);

	register_post_type( 'testimonial', $args );
}

add_action( 'init', 'testimonial_init' );


// Register meta box for Position field
function testimonial_add_meta_box() {
    add_meta_box(
        'testimonial_position',
        __( 'Position', 'textdomain' ),
        'testimonial_position_meta_box_callback',
        'testimonial',
        'advanced',
        'default'
    );
}
add_action( 'add_meta_boxes', 'testimonial_add_meta_box' );

function testimonial_position_meta_box_callback( $post ) {
	wp_nonce_field( 'testimonial_save_position', 'testimonial_position_nonce' );
    $value = get_post_meta( $post->ID, '_testimonial_position', true );

    echo '<label for="testimonial_position_field">' . esc_html( 'Position', 'textdomain' ) . '</label>';
    echo '<input type="text" id="testimonial_position_field" name="testimonial_position_field" value="' . esc_attr( $value ) . '" size="25" />';

}

// Save the Position field value
function testimonial_save_position( $post_id ) {
    if ( ! isset( $_POST['testimonial_position_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['testimonial_position_nonce'], 'testimonial_save_position' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['testimonial_position_field'] ) ) {
        $position = sanitize_text_field( $_POST['testimonial_position_field'] );
        update_post_meta( $post_id, '_testimonial_position', $position );
    }
}
add_action( 'save_post', 'testimonial_save_position' );

// Add Submenu Page
function wporg_options_page()
{
	add_submenu_page(
		'edit.php?post_type=testimonial',
		'Settings',
		'Settings',
		'manage_options',
		'testimonial_setting',
		'testimonial_setting_callback'
	);
}
add_action('admin_menu', 'wporg_options_page');

function testimonial_setting_callback() {
    if (isset($_POST['submit']) && check_admin_referer('testimonial_save_setting', 'testimonial_plugin_nonce')) {
        $title = sanitize_text_field($_POST['title']);
        $sub_title = sanitize_text_field($_POST['sub-title']);
        $background_color = sanitize_hex_color($_POST['background-color']);
        $container_bg_color = sanitize_hex_color($_POST['container-bg-color']);
        $theme_color = sanitize_hex_color($_POST['theme-color']);
        $theme_style = sanitize_text_field($_POST['theme-style']); // Save the selected theme style
        $font_family = sanitize_text_field($_POST['font-family']);
        $align_testimonial_content = sanitize_text_field($_POST['align-testimonial-content']); // Save the selected theme style
		$header_testimonial_gap = sanitize_text_field($_POST['header-testimonial-gap']);
		$slider_speed = sanitize_text_field($_POST['slider-speed']);
		$slider_delay = sanitize_text_field($_POST['slider-delay']);
		$contentColor = sanitize_hex_color($_POST['content-color']);
		$titleColor = sanitize_hex_color($_POST['title-color']);
        $slides_per_view = sanitize_text_field($_POST['slides-per-view']);
        $font_weight = sanitize_text_field($_POST['font-weight']);
        $authortitle_weight = sanitize_text_field($_POST['authortitle-weight']);
        $content_font_size = sanitize_text_field($_POST['content-font-size']);
        $author_font_size = sanitize_text_field($_POST['author-font-size']);
        $authorsubtitle_weight = sanitize_text_field($_POST['author-subtitle-weight']);
        $author_subtitle_font_size = sanitize_text_field($_POST['author-subtitle-font-size']);

        update_option('testimonial_title', $title);
        update_option('testimonial_sub_title', $sub_title);
        update_option('testimonial_bg_color', $background_color);
        update_option('container_bg_color', $container_bg_color);
        update_option('theme_color', $theme_color);
        update_option('theme-style', $theme_style); // Store the theme style
        update_option('font-family', $font_family);
        update_option('align-testimonial-content', $align_testimonial_content); // Store the theme style
		update_option('header-testimonial-gap', $header_testimonial_gap);
		update_option('slider-speed', $slider_speed);
		update_option('content-color', $contentColor);
		update_option('title-color', $titleColor);
        update_option('slides-per-view', $slides_per_view);
        update_option('font-weight', $font_weight);
        update_option('authortitle-weight', $authortitle_weight);
        update_option('content-font-size', $content_font_size);
        update_option('author-font-size', $author_font_size);
        update_option('author-subtitle-weight', $authorsubtitle_weight);
        update_option('author-subtitle-font-size', $author_subtitle_font_size);


        // Optional: Add an admin notice for feedback
        add_settings_error('testimonial_messages', 'testimonial_message', 'Settings Saved', 'updated');
    }

    // Retrieve the current options
    $title = esc_attr(get_option('testimonial_title'));
    $sub_title = esc_attr(get_option('testimonial_sub_title'));
    $background_color = esc_attr(get_option('testimonial_bg_color'));
    $container_bg_color = esc_attr(get_option('container_bg_color'));
    $theme_color = esc_attr(get_option('theme_color'));
    $theme_style = esc_attr(get_option('theme-style', 'skin-1')); // Default to 'skin-1'
    $font_family = esc_attr(get_option('font-family', 'Urbanist'));
    $align_testimonial_content = esc_attr(get_option('align-testimonial-content', 'left')); // Default to 'left'
	$header_testimonial_gap = esc_attr(get_option('header-testimonial-gap'));
	$slider_speed = esc_attr(get_option('slider-speed'));
	$slider_delay = esc_attr(get_option('slider-delay'));
	$contentColor = esc_attr(get_option('content-color'));
	$titleColor = esc_attr(get_option('title-color'));
    $slides_per_view = esc_attr(get_option('slides-per-view'));
    $font_weight = esc_attr(get_option('font-weight'));
    $authortitle_weight = esc_attr(get_option('authortitle-weight'));
    $content_font_size = esc_attr(get_option('content-font-size'));
    $author_font_size = esc_attr(get_option('author-font-size'));
    $authorsubtitle_weight = esc_attr(get_option('author-subtitle-weight'));
    $author_subtitle_font_size = esc_attr(get_option('author-subtitle-font-size'));

    ?>
    <h1> Testimonial Settings </h1>
    <div class="testimonial-setting">
        <div class="col-2">
            <div class="setting-tab-content"> 
                <div class="grid-setting active">
                    <form method="post" action="">
                        <?php wp_nonce_field('testimonial_save_setting', 'testimonial_plugin_nonce'); ?>
						<div class="theme-select-sec">
                            <label for="theme-style">Theme Style</label>
                            <select name="theme-style" id="theme-style">
                                <option value="skin-1" <?php selected($theme_style, 'skin-1'); ?>>Skin One</option>
                                <option value="skin-2" <?php selected($theme_style, 'skin-2'); ?>>Skin Two</option>
                            </select>
                        </div>
                        <div class="align-testimonial-content">
                            <label for="align-testimonial-content">Align Content:</label>
                            <select name="align-testimonial-content" id="align-testimonial-content">
                                <option value="left" <?php selected($align_testimonial_content, 'left'); ?>>Left</option>
                                <option value="center" <?php selected($align_testimonial_content, 'center'); ?>>Center</option>
                                <option value="right" <?php selected($align_testimonial_content, 'right'); ?>>Right</option>
                            </select>
                        </div>
                        <div class="font-family-select">
                            <label for="font-family">Font Family:</label>
                            <select name="font-family" id="font-family">
                                <option value="Urbanist" <?php selected($font_family, 'Urbanist'); ?>>Urbanist</option>
                                <option value="Poppins" <?php selected($font_family, 'Poppins'); ?>>Poppins</option>
                                <option value="Inter" <?php selected($font_family, 'Inter'); ?>>Inter</option>
                                <option value="Roboto" <?php selected($font_family, 'Roboto'); ?>>Roboto</option>
                                <option value="DM Sans" <?php selected($font_family, 'DM Sans'); ?>>DM Sans</option>
                                <option value="Montserrat" <?php selected($font_family, 'Montserrat'); ?>>Montserrat</option>
                                <option value="Open Sans" <?php selected($font_family, 'Open Sans'); ?>>Open Sans</option>
                            </select>
                        </div>
                        <div class="content-font-size-sec">
                            <label for="content-font-size">Content Font Size</label>
                            <input type="number" name="content-font-size" id="content-font-size" value="<?php echo esc_attr($content_font_size); ?>">
                        </div>
                        <div class="font-weight-select">
                            <label for="font-weight">Content Font Weight:</label>
                            <select name="font-weight" id="font-weight">
                                <option value="100" <?php selected($font_weight, '100'); ?>>100</option>
                                <option value="200" <?php selected($font_weight, '200'); ?>>200</option>
                                <option value="300" <?php selected($font_weight, '300'); ?>>300</option>
                                <option value="400" <?php selected($font_weight, '400'); ?>>400</option>
                                <option value="500" <?php selected($font_weight, '500'); ?>>500</option>
                                <option value="600" <?php selected($font_weight, '600'); ?>>600</option>
                                <option value="700" <?php selected($font_weight, '700'); ?>>700</option>
                                <option value="800" <?php selected($font_weight, '800'); ?>>800</option>
                                <option value="900" <?php selected($font_weight, '700'); ?>>900</option>
                            </select>
                        </div>
                        <div class="author-font-size-sec">
                            <label for="author-font-size">Author Title Font Size</label>
                            <input type="number" name="author-font-size" id="author-font-size" value="<?php echo esc_attr($author_font_size); ?>">
                        </div>
                        
                        <div class="author-title-font-weight-select">
                            <label for="authortitle-weight">Author Title Font Weight:</label>
                            <select name="authortitle-weight" id="authortitle-weight">
                                <option value="100" <?php selected($authortitle_weight, '100'); ?>>100</option>
                                <option value="200" <?php selected($authortitle_weight, '200'); ?>>200</option>
                                <option value="300" <?php selected($authortitle_weight, '300'); ?>>300</option>
                                <option value="400" <?php selected($authortitle_weight, '400'); ?>>400</option>
                                <option value="500" <?php selected($authortitle_weight, '500'); ?>>500</option>
                                <option value="600" <?php selected($authortitle_weight, '600'); ?>>600</option>
                                <option value="700" <?php selected($authortitle_weight, '700'); ?>>700</option>
                                <option value="800" <?php selected($authortitle_weight, '800'); ?>>800</option>
                                <option value="900" <?php selected($authortitle_weight, '700'); ?>>900</option>
                            </select>
                        </div>
                        <div class="author-subtitle-font-size-sec">
                            <label for="author-subtitle-font-size">Author Subtitle Font Size</label>
                            <input type="number" name="author-subtitle-font-size" id="author-subtitle-font-size" value="<?php echo esc_attr($author_subtitle_font_size); ?>">
                        </div>
                        
                        <div class="author-subtitle-font-weight-select">
                            <label for="author-subtitle-weight">Author Subtitle Font Weight:</label>
                            <select name="author-subtitle-weight" id="authortitle-weight">
                                <option value="100" <?php selected($authorsubtitle_weight, '100'); ?>>100</option>
                                <option value="200" <?php selected($authorsubtitle_weight, '200'); ?>>200</option>
                                <option value="300" <?php selected($authorsubtitle_weight, '300'); ?>>300</option>
                                <option value="400" <?php selected($authorsubtitle_weight, '400'); ?>>400</option>
                                <option value="500" <?php selected($authorsubtitle_weight, '500'); ?>>500</option>
                                <option value="600" <?php selected($authorsubtitle_weight, '600'); ?>>600</option>
                                <option value="700" <?php selected($authorsubtitle_weight, '700'); ?>>700</option>
                                <option value="800" <?php selected($authorsubtitle_weight, '800'); ?>>800</option>
                                <option value="900" <?php selected($authorsubtitle_weight, '700'); ?>>900</option>
                            </select>
                        </div>
                        
                        <div class="title-sec">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" value="<?php echo esc_attr($title); ?>">
                        </div>

                        <div class="subtitle-sec">
                            <label for="sub-title">Sub Title:</label>
                            <input type="text" name="sub-title" id="sub-title" value="<?php echo esc_attr($sub_title); ?>">
                        </div>

                        <div class="background-sec">
                            <label for="background-color">Background Color:</label>
                            <input type="color" name="background-color" id="background-color" value="<?php echo esc_attr($background_color); ?>">
                        </div>

                        <div class="container-bg-sec">
                            <label for="container-bg-color">Container Background Color:</label>
                            <input type="color" name="container-bg-color" id="container-bg-color" value="<?php echo esc_attr($container_bg_color); ?>">
                        </div>
                        <div class="theme-color">
                            <label for="theme-color">Theme Color:</label>
                            <input type="color" name="theme-color" id="theme-color" value="<?php echo esc_attr($theme_color); ?>">
                        </div>
						<div class="title-color">
                            <label for="title-color">Title Color:</label>
                            <input type="color" name="title-color" id="title-color" value="<?php echo esc_attr($titleColor); ?>">
                        </div>
						<div class="content-color">
                            <label for="content-color">Content Color:</label>
                            <input type="color" name="content-color" id="content-color" value="<?php echo esc_attr($contentColor); ?>">
                        </div>
						<div class="header-testimonial-gap">
							<label for="header-testimonial-gap">Header Testimonial Gap:</label>
							<input type="number" name="header-testimonial-gap" id="header-testimonial-gap" min="0" max="1000" value="<?php echo esc_attr($header_testimonial_gap); ?>">
						</div>
                        <div class="slides-per-view">
                            <label for="slides-per-view">Slides Per View</label>
                            <input type="number" name="slides-per-view" id="slides-per-view" value="<?php echo esc_attr($slides_per_view); ?>">
                        </div>
						<div class="slider-speed">
							<label for="slider-speed">Slider Speed:</label>
							<input type="number" name="slider-speed" id="slider-speed" value="<?php echo esc_attr($slider_speed); ?>">
						</div>
						<div class="slider-delay">
							<label for="slider-delay">Slider Delay:</label>
							<input type="number" name="slider-delay" id="slider-delay" value="<?php echo esc_attr($slider_delay); ?>">
						</div>
						

                        <input type="submit" name="submit" value="Save Settings">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
