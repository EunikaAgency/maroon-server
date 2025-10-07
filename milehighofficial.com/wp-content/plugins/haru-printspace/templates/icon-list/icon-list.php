<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Elementor\Icons_Manager;

if ( $settings['list'] ) : ?>
	<ul class="haru-icon-list__list">
	<?php
		foreach ( $settings['list'] as $item ) :
		$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
    	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
	?>
		<li class="haru-icon-list__item haru-icon-list__columns-<?php echo esc_attr( $settings['columns'] ); ?> haru-icon-list__columns--tablet-<?php echo esc_attr( $settings['columns_tablet'] ); ?> haru-icon-list__columns--mobile-<?php echo esc_attr( $settings['columns_mobile'] ); ?>">
			<div class="haru-icon-list__item-wrap">
				<?php if ( $item['list_link']['url'] ) : ?>
      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
          		<?php endif; ?>
				<div class="haru-icon-list__image">
					<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
	      		</div>
	      		<div class="haru-icon-list__content">
	              	<h6 class="haru-icon-list__title"><?php echo esc_html( $item['list_title'] ); ?></h6>
	              	<div class="haru-icon-list__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
              	</div>
	      		<?php if ( $item['list_link']['url'] ) : ?>
              	</a>
              	<?php endif; ?>
          	</div>
      	</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if ( $settings['list_icon'] ) : ?>
	<?php if ( in_array( $settings['pre_style'], array( 'style-2' ) ) ) : ?>
		<ul class="haru-icon-list__list">
		<?php
			foreach ( $settings['list_icon'] as $item ) :
			$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>
			<li class="haru-icon-list__item">
				<div class="haru-icon-list__item-wrap">
					<?php if ( $item['list_link']['url'] ) : ?>
	      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	          		<?php endif; ?>
					<div class="haru-icon-list__icon">
						<?php Icons_Manager::render_icon( $item['list_title_icon'], [ 'aria-hidden' => 'true' ] ); ?>
		      		</div>
		      		<div class="haru-icon-list__content">
		              	<h6 class="haru-icon-list__title"><?php echo esc_html( $item['list_title'] ); ?></h6>

		              	<?php if ( $item['list_description'] ) : ?>
		              	<div class="haru-icon-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
		              	<?php endif; ?>
	              	</div>
		      		<?php if ( $item['list_link']['url'] ) : ?>
	              	</a>
	              	<?php endif; ?>
	          	</div>
	      	</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php
		if ( in_array( $settings['pre_style'], array( 'style-3' ) ) ) :

		$slick_arrows_style = 'haru-slick--nav-opacity haru-slick--nav-center';
		if ( $settings['arrows_style'] == 'center-opacity' ) {
			$slick_arrows_style = 'haru-slick--nav-opacity haru-slick--nav-center';
		}

		if ( $settings['arrows_style'] == 'top-right-border' ) {
			$slick_arrows_style = 'haru-slick--nav-border haru-slick--nav-top-right';
		}
	?>
		<ul class="haru-icon-list__list haru-slick <?php echo esc_attr( $slick_arrows_style ); ?>" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
			<?php 
				foreach (  $settings['list_icon'] as $item ) :
				$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
	        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
			?>
				<li class="haru-icon-list__item">
					<div class="haru-icon-list__item-wrap">
						<?php if ( $item['list_link']['url'] ) : ?>
		      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
		          		<?php endif; ?>
						<div class="haru-icon-list__icon">
							<?php Icons_Manager::render_icon( $item['list_title_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			      		</div>
			      		<div class="haru-icon-list__content">
			              	<h6 class="haru-icon-list__title"><?php echo esc_html( $item['list_title'] ); ?></h6>
			              	<div class="haru-icon-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
		              	</div>
			      		<?php if ( $item['list_link']['url'] ) : ?>
		              	</a>
		              	<?php endif; ?>
		          	</div>
		      	</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php if ( in_array( $settings['pre_style'], array( 'style-4' ) ) ) : ?>
		<ul class="haru-icon-list__list">
		<?php
			foreach ( $settings['list_icon'] as $item ) :
			$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>
			<li class="haru-icon-list__item">
				<?php if ( $item['list_link']['url'] ) : ?>
      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
          		<?php endif; ?>
				<div class="haru-icon-list__item-wrap">
					
					<div class="haru-icon-list__icon">
						<?php Icons_Manager::render_icon( $item['list_title_icon'], [ 'aria-hidden' => 'true' ] ); ?>
		      		</div>
		      		<div class="haru-icon-list__content">
		              	<h6 class="haru-icon-list__title"><?php echo esc_html( $item['list_title'] ); ?></h6>

		              	<?php if ( $item['list_description'] ) : ?>
		              	<div class="haru-icon-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
		              	<?php endif; ?>
	              	</div>
	          	</div>
	          	<?php if ( $item['list_link']['url'] ) : ?>
              	</a>
              	<?php endif; ?>
	      	</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
<?php endif; ?>