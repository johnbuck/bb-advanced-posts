<div class="fl-post-feed-post<?php if($settings->image_position == 'beside') echo ' fl-post-feed-image-beside'; if(has_post_thumbnail() && $settings->show_image) echo ' fl-post-feed-has-image'; ?>" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">

	<?php if(has_post_thumbnail() && $settings->show_image) : ?>
	<div class="fl-post-feed-image">
		<a href="<?php bbap_permalink($settings); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail($settings->image_size, array('itemprop' => 'image')); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="fl-post-feed-header">
		<h2 class="fl-post-feed-title" itemprop="headline">
            <?php if ( $settings->disable_single_post_link != 'yes' ) { ?>
			    <a href="<?php bbap_permalink($settings); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            <?php } else { ?>
                <?php the_title(); ?>
            <?php } ?>
		</h2>
		<?php if ( ($settings->show_author || $settings->show_date || $settings->show_comments) && $settings->meta_fields_position == 'before') : ?>
		<div class="fl-post-feed-meta">
			<?php if($settings->show_author) : ?>
				<span class="fl-post-feed-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
					<?php

					printf(
						_x( 'By %s', '%s stands for author name.', 'fl-builder' ),
						'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" itemprop="url"><span itemprop="name">' . get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ) . '</span></a>'
					);

					?>
				</span>
			<?php endif; ?>
			<?php if($settings->show_date) : ?>
				<?php if($settings->show_author) : ?>
					<span class="fl-sep"> | </span>
				<?php endif; ?>
				<span class="fl-post-feed-date" itemprop="datePublished" datetime="<?php echo the_time('Y-m-d'); ?>">
					<?php FLBuilderLoop::post_date($settings->date_format); ?>
				</span>
			<?php endif; ?>

			<?php if($settings->show_comments) : ?>
				<?php if($settings->show_author || $settings->show_date) : ?>
					<span class="fl-sep"> | </span>
				<?php endif; ?>
				<span class="fl-post-feed-comments">
					<?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?>
				</span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>

	<?php if($settings->show_content || $settings->show_more_link) : ?>
	<div class="fl-post-feed-content" itemprop="text">
		<?php 
			
		if ($settings->show_content) {
			
			if ( 'full' == $settings->content_type ) {
				the_content();
			}
			else {
				the_excerpt(); 
			}
		}
		
		?>

        <?php if ( ($settings->show_author || $settings->show_date || $settings->show_comments) && $settings->meta_fields_position == 'after') : ?>
            <div class="fl-post-feed-meta">
                <?php if($settings->show_author) : ?>
                    <span class="fl-post-feed-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
					<?php

                    printf(
                        _x( 'By %s', '%s stands for author name.', 'fl-builder' ),
                        '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" itemprop="url"><span itemprop="name">' . get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ) . '</span></a>'
                    );

                    ?>
				</span>
                <?php endif; ?>
                <?php if($settings->show_date) : ?>
                    <?php if($settings->show_author) : ?>
                        <span class="fl-sep"> | </span>
                    <?php endif; ?>
                    <span class="fl-post-feed-date" itemprop="datePublished" datetime="<?php echo the_time('Y-m-d'); ?>">
					<?php FLBuilderLoop::post_date($settings->date_format); ?>
				</span>
                <?php endif; ?>

                <?php if($settings->show_comments) : ?>
                    <?php if($settings->show_author || $settings->show_date) : ?>
                        <span class="fl-sep"> | </span>
                    <?php endif; ?>
                    <span class="fl-post-feed-comments">
					<?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?>
				</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

	<?php endif; ?>

    <?php if ($settings->cta_show == 'show') : ?>
        <div class="<?php echo $module->get_classname(); ?>">
            <a href="<?php if ($settings->cta_type == 'url') echo $settings->cta_url; else echo my_get_field($settings->cta_custom_field); ?>" <?php if ($settings->cta_target == 'blank') {?> target="_blank" <?php } ?> class="fl-button" role="button">
                <?php if ( ! empty( $settings->icon ) && ( 'before' == $settings->icon_position || ! isset( $settings->icon_position ) ) ) : ?>
                    <i class="fl-button-icon fl-button-icon-before fa <?php echo $settings->icon; ?>"></i>
                <?php endif; ?>
                <span class="fl-button-text"><?php echo $settings->cta_caption; ?></span>
                <?php if ( ! empty( $settings->icon ) && 'after' == $settings->icon_position ) : ?>
                    <i class="fl-button-icon fl-button-icon-after fa <?php echo $settings->icon; ?>"></i>
                <?php endif; ?>
            </a>
        </div>
    <?php endif; ?>

    <?php if($settings->show_more_link) : ?>
		<a class="fl-post-feed-more" href="<?php if ( trim($settings->more_link_url) == '') bbap_permalink($settings); else echo esc_url( $settings->more_link_url ); ?>" title="<?php the_title_attribute(); ?>"><?php echo $settings->more_link_text; ?></a>	
	<?php endif; ?>

	<div class="fl-clear"></div>
</div>