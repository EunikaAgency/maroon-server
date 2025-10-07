<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( $settings['list'] ) : ?>
	<?php if ( $settings['pre_style'] == 'style-1' ) : ?>
		<div class="haru-background-creative__list haru-slick" data-slick='{"slidesToShow" : 1, "slidesToScroll" : 1, "arrows" : false, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "fade": true, "vertical" : false, "pauseOnHover": false, "pauseOnFocus": false, "autoplay": true, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?> }'>
		<?php
			foreach ( $settings['list'] as $item ) :
		?>
			<div class="haru-background-creative__item" style="background-color: <?php echo esc_attr( $item['list_bg_color'] ); ?>">
	      	</div>
		<?php endforeach; ?>
		</div>

	<?php elseif ( $settings['pre_style'] == 'style-2' ) : ?>
		<?php
			$color_arr = array();
			foreach ( $settings['list'] as $item ) {
				$color_arr[] = $item['list_bg_color'];
			}
			$first_color = $color_arr[0];
		?>
		<div style="background-color: <?php echo esc_attr( $first_color ); ?>" class="haru-background-creative__content" data-color='<?php echo wp_json_encode( $color_arr ); ?>' data-duration="<?php echo esc_attr( $settings['duration'] ); ?>">
	  	</div>
	<?php endif; ?>
<?php endif; ?>
