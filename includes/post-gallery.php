<div class="fl-post-gallery-post" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">

	<a class="fl-post-gallery-link" href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
	
		<?php
		
		$image_data = wp_get_attachment_metadata(get_post_thumbnail_id());
		$class_name = 'fl-post-gallery-img';
		
		if($image_data) {
			if($image_data['width'] > $image_data['height']) {
				$class_name .= ' fl-post-gallery-img-horiz';
			}
			else {
				$class_name .= ' fl-post-gallery-img-vert';
			}
		}
		
		the_post_thumbnail('large', array('class' => $class_name));
		
		?>
		
		<div class="fl-post-gallery-text-wrap">
			<div class="fl-post-gallery-text">

				<?php if( $settings->has_icon && $settings->icon_position == 'above' ) : ?>
					<span class="fl-gallery-icon">
						<i class="<?php echo $settings->icon; ?>"></i> 
					</span>
				<?php endif; ?>
			
				<h2 class="fl-post-gallery-title" itemprop="headline"><?php the_title(); ?></h2>
			
				<?php if ( $settings->show_date ) : ?>
				<span class="fl-post-gallery-date" itemprop="datePublished" datetime="<?php echo the_time('Y-m-d'); ?>">
					<?php FLBuilderLoop::post_date($settings->date_format); ?>
				</span>
				<?php endif; ?>

				<?php if( $settings->has_icon && $settings->icon_position == 'below' ) : ?>
					<span class="fl-gallery-icon">
						<i class="<?php echo $settings->icon; ?>"></i> 
					</span>
				<?php endif; ?>

                <?php if ($settings->cta_show == 'show') : ?>
                    <a class="fl-post-cta-button" href="<?php if ($settings->cta_type == 'url') echo $settings->cta_url; else echo my_get_field( $settings->cta_custom_field ); ?>"><?php echo $settings->cta_caption; ?></a>
                <?php endif; ?>

            </div>
		</div>
	</a>
</div>