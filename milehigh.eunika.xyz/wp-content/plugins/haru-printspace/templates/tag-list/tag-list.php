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
	<div class="haru-tag-list__list">
	<?php
		foreach ( $settings['list'] as $item ) :
		$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
    	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
	?>
		<div class="elementor-repeater-item-<?php echo $item['_id']; ?> haru-tag-list__item">
			<?php if ( $item['list_link']['url'] ) : ?>
  			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
      		<?php endif; ?>
				<?php if ( $item['list_title'] ) : ?>
		          	<span class="tag-title"><?php echo $item['list_title']; ?></span>
		      	<?php endif; ?>
	      	<?php if ( $item['list_link']['url'] ) : ?>
          	</a>
          	<?php endif; ?>
      	</div>
	<?php endforeach; ?>
	</div>
<?php elseif ( $settings['list_tag'] ) : ?>
	<div class="haru-tag-list__list">
	<?php
		foreach ( $settings['list_tag'] as $item ) :
		$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
    	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
	?>
		<div class="elementor-repeater-item-<?php echo $item['_id']; ?> haru-tag-list__item">
			<?php if ( $item['list_link']['url'] ) : ?>
  			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
      		<?php endif; ?>
				<?php if ( $item['list_title'] ) : ?>
		          	<span class="tag-title">
		          		<span class="tag-text">
		          			<?php echo $item['list_title']; ?>
	          			</span>
		          	</span>
		      	<?php endif; ?>
	      	<?php if ( $item['list_link']['url'] ) : ?>
          	</a>
          	<?php endif; ?>
      	</div>
	<?php endforeach; ?>
	</div>
<?php endif; ?>

