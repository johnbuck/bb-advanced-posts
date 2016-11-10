<?php if($settings->layout == 'grid') : // GRID ?>

.fl-node-<?php echo $id; ?> .fl-post-grid-post {    
	margin-bottom: <?php echo $settings->post_spacing; ?>px;
	width: <?php echo $settings->post_width; ?>px;
}
.fl-node-<?php echo $id; ?> .fl-post-grid-sizer {
	width: <?php echo $settings->post_width; ?>px;
}

@media screen and (max-width: <?php echo $settings->post_width + $settings->post_spacing; ?>px) {
	.fl-node-<?php echo $id; ?> .fl-post-grid,
	.fl-node-<?php echo $id; ?> .fl-post-grid-post,
	.fl-node-<?php echo $id; ?> .fl-post-grid-sizer {
		width: 100% !important;
	}
}

<?php elseif( $settings->layout == 'gallery' ) : ?>

	<?php 

		$text_bg_color    = !empty( $settings->text_bg_color ) ? $settings->text_bg_color : 'ffffff';
		$text_bg_opacity  = !empty( $settings->text_bg_opacity ) ? $settings->text_bg_opacity : '100';
		$text_bg          = 'rgba('. implode( ',', FLBuilderColor::hex_to_rgb( $text_bg_color ) ) .','. ( $text_bg_opacity/100 ) .')';

	 ?>

	<?php if( !empty( $settings->text_color ) ) : ?>
	.fl-node-<?php echo $id; ?> .fl-post-gallery-link,
	.fl-node-<?php echo $id; ?> .fl-post-gallery-link .fl-post-gallery-title{
		color: #<?php echo $settings->text_color ?>;
	}
	<?php endif; ?>

	.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap{
		background-color: #<?php echo $text_bg_color; ?>;
		background-color: <?php echo $text_bg; ?>;
	}

	<?php if( isset( $settings->has_icon ) && $settings->has_icon == 'yes' ): ?>

		.fl-node-<?php echo $id ?> .fl-post-gallery .fl-gallery-icon{
		<?php if( $settings->icon_position == 'above' ) : ?>
			margin-bottom: 10px;
		<?php else : ?>
			margin-top: 10px;
		<?php endif; ?>
		}
		
		<?php if( !empty( $settings->icon_size ) || !empty( $settings->icon_color ) ) : ?>
			.fl-node-<?php echo $id ?> .fl-post-gallery .fl-gallery-icon i,
			.fl-node-<?php echo $id ?> .fl-post-gallery .fl-gallery-icon i:before {
			<?php if( !empty( $settings->icon_size ) ) : ?>
				width: <?php echo $settings->icon_size ?>px;
				height: <?php echo $settings->icon_size ?>px;
				font-size: <?php echo $settings->icon_size ?>px;
			<?php endif; ?>
			<?php if( !empty( $settings->icon_color ) ) : ?>
				color: #<?php echo $settings->icon_color ?>;
			<?php endif; ?>
			}
		<?php endif; ?>

	<?php endif; ?>

	<?php if( isset( $settings->hover_transition ) && $settings->hover_transition != 'fade' ) : ?>
		.fl-node-<?php echo $id ?> .fl-post-gallery-text{
		<?php if( $settings->hover_transition == 'slide-up' ) : ?>
			-webkit-transform: translate3d(-50%,-30%,0); 
			   -moz-transform: translate3d(-50%,-30%,0); 
			    -ms-transform: translate(-50%,-30%); 
					transform: translate3d(-50%,-30%,0); 		
		<?php elseif( $settings->hover_transition == 'slide-down' ) : ?>
			-webkit-transform: translate3d(-50%,-70%,0); 
			   -moz-transform: translate3d(-50%,-70%,0); 
			    -ms-transform: translate(-50%,-70%); 
					transform: translate3d(-50%,-70%,0); 		
		<?php elseif( $settings->hover_transition == 'scale-up' ) : ?>
			-webkit-transform: translate3d(-50%,-50%,0) scale(.7); 
			   -moz-transform: translate3d(-50%,-50%,0) scale(.7); 
			    -ms-transform: translate(-50%,-50%) scale(.7); 
					transform: translate3d(-50%,-50%,0) scale(.7); 
		<?php elseif( $settings->hover_transition == 'scale-down' ) : ?>
			-webkit-transform: translate3d(-50%,-50%,0) scale(1.3); 
			   -moz-transform: translate3d(-50%,-50%,0) scale(1.3); 
			    -ms-transform: translate(-50%,-50%) scale(1.3); 
					transform: translate3d(-50%,-50%,0) scale(1.3); 
		<?php endif; ?>
		}

	<?php endif; ?>

<?php endif; ?>

<?php
    // Background Color
    if ( ! empty( $settings->cta_bg_color ) && empty( $settings->cta_bg_hover_color ) ) {
    $settings->bg_hover_color = $settings->cta_bg_color;
    }

    // Old Background Gradient Setting
    if ( isset( $settings->cta_three_d ) && $settings->cta_three_d ) {
    $settings->cta_style = 'gradient';
    }

    // Background Gradient
    if ( ! empty( $settings->cta_bg_color ) ) {
    $bg_grad_start = FLBuilderColor::adjust_brightness( $settings->cta_bg_color, 30, 'lighten' );
    }
    if ( ! empty( $settings->cta_bg_hover_color ) ) {
    $bg_hover_grad_start = FLBuilderColor::adjust_brightness( $settings->cta_bg_hover_color, 30, 'lighten' );
    }

    // Border Size
    if ( 'transparent' == $settings->cta_style ) {
    $border_size = $settings->cta_border_size;
    }
    else {
    $border_size = 1;
    }

    // Border Color
    if ( ! empty( $settings->cta_bg_color ) ) {
    $border_color = FLBuilderColor::adjust_brightness( $settings->cta_bg_color, 12, 'darken' );
    }
    if ( ! empty( $settings->cta_bg_hover_color ) ) {
    $border_hover_color = FLBuilderColor::adjust_brightness( $settings->cta_bg_hover_color, 12, 'darken' );
    }

    ?>
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button,
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited {

    font-size: <?php echo $settings->cta_font_size; ?>px;
    line-height: <?php echo $settings->cta_font_size + 2; ?>px;
    padding: <?php echo $settings->cta_padding . 'px ' . ($settings->cta_padding * 2) . 'px'; ?>;
    border-radius: <?php echo $settings->cta_border_radius; ?>px;
    -moz-border-radius: <?php echo $settings->cta_border_radius; ?>px;
    -webkit-border-radius: <?php echo $settings->cta_border_radius; ?>px;

<?php if ( 'custom' == $settings->cta_width ) : ?>
    width: <?php echo $settings->cta_custom_width; ?>px;
<?php endif; ?>

<?php if ( ! empty( $settings->cta_bg_color ) ) : ?>
    background: #<?php echo $settings->cta_bg_color; ?>;
    border: <?php echo $cta_border_size; ?>px solid #<?php echo $cta_border_color; ?>;

    <?php if ( 'transparent' == $settings->cta_style ) : // Transparent ?>
        background-color: rgba(<?php echo implode( ',', FLBuilderColor::hex_to_rgb( $settings->cta_bg_color ) ) ?>, <?php echo $settings->cta_bg_opacity/100; ?>);
    <?php endif; ?>

    <?php if( 'gradient' == $settings->cta_style ) : // Gradient ?>
        background: -moz-linear-gradient(top,  #<?php echo $bg_grad_start; ?> 0%, #<?php echo $settings->cta_bg_color; ?> 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $bg_grad_start; ?>), color-stop(100%,#<?php echo $settings->cta_bg_color; ?>)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  #<?php echo $bg_grad_start; ?> 0%,#<?php echo $settings->cta_bg_color; ?> 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  #<?php echo $bg_grad_start; ?> 0%,#<?php echo $settings->cta_bg_color; ?> 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  #<?php echo $bg_grad_start; ?> 0%,#<?php echo $settings->cta_bg_color; ?> 100%); /* IE10+ */
        background: linear-gradient(to bottom,  #<?php echo $bg_grad_start; ?> 0%,#<?php echo $settings->cta_bg_color; ?> 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $bg_grad_start; ?>', endColorstr='#<?php echo $settings->cta_bg_color; ?>',GradientType=0 ); /* IE6-9 */
    <?php endif; ?>

<?php endif; ?>
    }

<?php if ( ! empty( $settings->cta_text_color ) ) : ?>
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button,
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited,
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button *,
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited * {
    color: #<?php echo $settings->cta_text_color; ?>;
    }
<?php endif; ?>

<?php if ( ! empty( $settings->cta_bg_hover_color ) ) : ?>
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:focus {

    background: #<?php echo $settings->cta_bg_hover_color; ?>;
    border: <?php echo $border_size; ?>px solid #<?php echo $border_hover_color; ?>;

    <?php if ( 'transparent' == $settings->cta_style ) : // Transparent ?>
        background-color: rgba(<?php echo implode( ',', FLBuilderColor::hex_to_rgb( $settings->cta_bg_hover_color ) ) ?>, <?php echo $settings->cta_bg_opacity/100; ?>);
    <?php endif; ?>

    <?php if ( 'gradient' == $settings->cta_style ) : // Gradient ?>
        background: -moz-linear-gradient(top,  #<?php echo $bg_hover_grad_start; ?> 0%, #<?php echo $settings->cta_bg_hover_color; ?> 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $bg_hover_grad_start; ?>), color-stop(100%,#<?php echo $settings->cta_bg_hover_color; ?>)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  #<?php echo $bg_hover_grad_start; ?> 0%,#<?php echo $settings->cta_bg_hover_color; ?> 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  #<?php echo $bg_hover_grad_start; ?> 0%,#<?php echo $settings->cta_bg_hover_color; ?> 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  #<?php echo $bg_hover_grad_start; ?> 0%,#<?php echo $settings->cta_bg_hover_color; ?> 100%); /* IE10+ */
        background: linear-gradient(to bottom,  #<?php echo $bg_hover_grad_start; ?> 0%,#<?php echo $settings->cta_bg_hover_color; ?> 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $bg_hover_grad_start; ?>', endColorstr='#<?php echo $settings->cta_bg_hover_color; ?>',GradientType=0 ); /* IE6-9 */
    <?php endif; ?>
    }
<?php endif; ?>

<?php if ( ! empty( $settings->text_hover_color ) ) : ?>
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:focus,
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover *,
    .fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:focus * {
    color: #<?php echo $settings->text_hover_color; ?>;
    }
<?php endif; ?>