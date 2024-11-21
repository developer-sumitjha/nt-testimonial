<?php

// Shortcode to call Testimonials
add_shortcode('testimonial', 'get_testimonial_grid_function');

function get_testimonial_grid_function($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'type' => 'grid' // default type is 'grid'
        ),
        $atts
    );

    // Common options
    $title = get_option('testimonial_title', 'Testimonial');
    $subtitle = get_option('testimonial_sub_title', 'What our clients say?');
    $bgcolor = get_option('testimonial_bg_color', '#eeeeee');
    $containerbgcolor = get_option('container_bg_color', '#fff');
    $themecolor = get_option('theme_color', '#39994E');
	$header_testimonial_gap = get_option('header-testimonial-gap', '48');
	$slider_speed = get_option('slider-speed', '5000');
	$slider_delay = get_option('slider-delay', '2500');
	$contentColor = get_option('content-color', '#777777');
	$titleColor = get_option('title-color', '#222222');
    $theme_style = get_option('theme-style', 'skin-1');
    $align_testimonial_content = get_option('align-testimonial-content', 'left');
    $font_family = get_option('font-family', 'Urbanist');
    $slides_per_view = get_option('slides-per-view', '3');
    $font_weight = get_option('font-weight', '400');
    $authortitle_weight = get_option('authortitle-weight', '500');
    $content_font_size = get_option('content-font-size', '16');
    $author_font_size = get_option('author-font-size', '20');
    $authorsubtitle_weight = get_option('author-subtitle-weight', '500');
    $author_subtitle_font_size = get_option('author-subtitle-font-size', '16');

    // Start building the testimonial output
    $testimonial = '<div class="testimonial-container" style="background-color:' . esc_html($containerbgcolor) . '; padding: 96px 32px;">';
    $testimonial .= '<div class="testimonial-header" style="margin-bottom:' . esc_html($header_testimonial_gap) . 'px;"><h1>' . esc_html($title) . '</h1>';
    $testimonial .= '<h6>' . esc_html($subtitle) . '</h6></div>';

    global $post;
    $myposts = get_posts(array(
        'numberposts' => 6,
        'post_type' => 'testimonial',
    ));

    // If type is "slider"
    if ($atts['type'] === 'slider') {
        $testimonial .= '<swiper-container navigation="true" pagination="true" pagination-dynamic-bullets="true" slides-per-view="' . $slides_per_view .'" speed="' . $slider_speed . '" loop="true" space-between="24" autoplay-delay="' . $slider_delay . '" autoplay-disable-on-interaction="false">';

        if ($myposts) {
            foreach ($myposts as $post) {
                setup_postdata($post);
                $position = get_post_meta($post->ID, '_testimonial_position', true);
                if($theme_style === 'skin-1' && $align_testimonial_content === 'left'){
                    $testimonial .= '<swiper-slide class="skin-1 align-left" style="background-color: ' . esc_html($bgcolor) . ';">';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '</swiper-slide>';

                } else if($theme_style === 'skin-2' && $align_testimonial_content === 'left'){
                    $testimonial .= '<swiper-slide class="skin-2 align-left" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    
                    $testimonial .= '</swiper-slide>';
                } else if($theme_style === 'skin-1' && $align_testimonial_content === 'center'){
                    $testimonial .= '<swiper-slide class="skin-1 align-center" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '</swiper-slide>';

                } else if($theme_style === 'skin-2' && $align_testimonial_content === 'center'){
                    $testimonial .= '<swiper-slide class="skin-2 align-center" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    
                    $testimonial .= '</swiper-slide>';
                } else if($theme_style === 'skin-1' && $align_testimonial_content === 'right'){
                    $testimonial .= '<swiper-slide class="skin-1 align-right" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '</swiper-slide>';

                } else if($theme_style === 'skin-2' && $align_testimonial_content === 'right'){
                    $testimonial .= '<swiper-slide class="skin-2 align-right" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    
                    $testimonial .= '</swiper-slide>';
                }
            }
            wp_reset_postdata();
        }

        $testimonial .= '</swiper-container>';

    } else {
        // Default grid view
        $testimonial .= '<ul class="testimonial-items">';

        if ($myposts) {
            foreach ($myposts as $post) {
                setup_postdata($post);
                $position = get_post_meta($post->ID, '_testimonial_position', true);

                if($theme_style === 'skin-1' && $align_testimonial_content === 'left'){
                    $testimonial .= '<li class="testimonial-item skin-1 align-left" style="background-color: ' . esc_html($bgcolor) . ';">';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '</li>';
                } else if($theme_style === 'skin-2' && $align_testimonial_content === 'left'){
                    $testimonial .= '<li class="testimonial-item skin-2 align-left" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    
                    $testimonial .= '</li>';
                } else if($theme_style === 'skin-1' && $align_testimonial_content === 'center'){
                    $testimonial .= '<li class="testimonial-item skin-1 align-center" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '</li>';
                } else if($theme_style === 'skin-2' && $align_testimonial_content === 'center'){
                    $testimonial .= '<li class="testimonial-item skin-2  align-center" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    
                    $testimonial .= '</li>';
                }else if($theme_style === 'skin-1' && $align_testimonial_content === 'right'){
                    $testimonial .= '<li class="testimonial-item skin-1 align-right" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '</li>';
                } else if($theme_style === 'skin-2' && $align_testimonial_content === 'right'){
                    $testimonial .= '<li class="testimonial-item skin-2  align-right" style="background-color: ' . esc_html($bgcolor) . '">';
                    $testimonial .= '<div class="author-details"><div class="img">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</div>';
                    $testimonial .= '<div class="author-info"><h6 style="color:' . esc_html($titleColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($authortitle_weight) . ';font-size:' . esc_html($author_font_size) . 'px;">' . get_the_title() . '</h6>';
                    $testimonial .= '<p style="color: ' . esc_html($themecolor) . '; font-family:' . esc_html($font_family) .';;font-weight:' . esc_html($authorsubtitle_weight) . ';font-size:' . esc_html($author_subtitle_font_size) . 'px;">' . esc_html($position) . '</p></div></div>';
                    $testimonial .= '<div class="testimonial-content" style="color:' . esc_html($contentColor) .'; font-family:' . esc_html($font_family) .';font-weight:' . esc_html($font_weight) . ';font-size:' . esc_html($content_font_size) . 'px;">' . get_the_content() . '</div>';
                    
                    $testimonial .= '</li>';
                }
            }
            wp_reset_postdata();
        }

        $testimonial .= '</ul>';
    }

    $testimonial .= '</div>'; // Close testimonial container

    return $testimonial; // Return the final output
}
