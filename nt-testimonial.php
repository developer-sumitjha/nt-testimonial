<?php
/*
 * Plugin Name:       Testimonial Grid & Carousel 
 * Plugin URI:        https://sumitjha.info.np/plugins/portfolio
 * Description:       Best WordPress Testimonial Plugin for WordPress to display your clients review in grid and slider view with great customization option.
 * Version:           1.0.0
 * Author:            Sumit Jha
 * Author URI:        https://sumitjha.info.np/
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Includes

require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/settings.php';



// Enqueue Plugin CSS file
wp_enqueue_style('testimonial-styles', plugin_dir_url( __FILE__ ) . 'css/testimonial.css', array(), '1.0.0', false);
wp_enqueue_style('testimonial-admin-styles', plugin_dir_url( __FILE__ ) . 'css/testimonial-admin.css', array(), '1.0.0', false);
wp_enqueue_script('testimonial-swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js', array(), '1.0.0', false);
wp_enqueue_script('testimonial-admin-script', plugin_dir_url( __FILE__ ) . 'js/admin-script.js', array(), '1.0.0', false);


