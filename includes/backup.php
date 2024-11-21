<?php


// Shortcode to call Testimonials
add_shortcode('testimonial','get_testimonial_function');

function get_testimonial_function($atts){

		// Extract shortcode attributes
		$atts = shortcode_atts(
			array(
				'type' => 'grid' // default type is 'grid'
			), 
			$atts
		);

		 // Check if the type is "slider"
		if ($atts['type'] === 'slider') {
			$title = get_option('testimonial_title','Testimonial');
			$subtitle = get_option('testimonial_sub_title','What our clients say?');
			$bgcolor = get_option('testimonial_bg_color','#eeeeee');
			$containerbgcolor = get_option('container_bg_color','#fff');
			$themecolor = get_option('theme_color','#39994E');

			// Testimonial Container
			$testimonial = '<div class="testimonial-container" style="background-color:' . esc_html( $containerbgcolor ) . '">';

			// Testimonial Header
			$testimonial .= '<div class="testimonial-header"><h1>' . esc_html( $title ) . '</h1>';
			$testimonial .= '<h6>' . esc_html( $subtitle ) . '</h6></div>';
			$testimonial .= '</div>';

			// Testimonial Section
			$testimonial .= '<swiper-container>';

			global $post;
			$myposts = get_posts( array(
				'numberposts' => 10,
				'post_type' => 'testimonial',
			) );

			if ( $myposts ) {
				foreach ( $myposts as $post ) : 
					setup_postdata( $post );
					$position = get_post_meta( $post->ID, '_testimonial_position', true );
					
					$testimonial .= '<swiper-slider>';
					$testimonial .= '<div class="testimonial-content">' . the_content() . '</div>';
					$testimonial .= '<div class="author-details"><div class="img">' . the_post_thumbnail( 'thumbnail' ) . '</div>';
					$testimonial .= '<div class="author-info"><h6>' . the_title() . '</h6>';
					$testimonial .= '<p style="color: ' . esc_html( $themecolor ) . '">' . esc_html( $position ) . '</p></div></div>';
					$testimonial .= '</swiper-slider>';
			
				endforeach;
			}
			

			$testimonial .= '</swiper-container>';
			return $testimonial;
		
		}
		
		$title = get_option('testimonial_title','Testimonial');
		$subtitle = get_option('testimonial_sub_title','What our clients say?');
		$bgcolor = get_option('testimonial_bg_color','#eeeeee');
		$containerbgcolor = get_option('container_bg_color','#fff');
		$themecolor = get_option('theme_color','#39994E');
	?>
		<div class="testimonial-container" style="background-color:<?php echo esc_html( $containerbgcolor ); ?>">
			<div class="testimonial-header">
				<h1><?php echo esc_html( $title ); ?></h1>
				<h6><?php echo esc_html( $subtitle ); ?></h6>
			</div>
			<ul class="testimonial-items">
			<?php
			global $post;

			$myposts = get_posts( array(
				'numberposts' => 10,
				'post_type' => 'testimonial',
			) );

			if ( $myposts ) {
				foreach ( $myposts as $post ) : 
					setup_postdata( $post );
					$position = get_post_meta( $post->ID, '_testimonial_position', true );
					?>
					<li class="testimonial-item" style="background-color: <?php echo esc_html( $bgcolor ); ?>">
						<div class="testimonial-content"><?php the_content(); ?></div>
						<div class="author-details">
							<div class="img">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</div>
							<div class="author-info">
								<h6><?php the_title(); ?></h6>
								<p style="color: <?php echo esc_html( $themecolor ); ?>"><?php echo esc_html( $position ); ?></p>
							</div>
						</div>
						
						
						
					</li>
				<?php
				endforeach;
				wp_reset_postdata();
			}
			?>
			</ul>
		</div>

		
<?php


}



