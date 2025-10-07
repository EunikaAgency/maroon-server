<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Haru_PrintSpace\Classes\Helper as ControlsHelper;
use \Haru_PrintSpace\Classes\Haru_Template;

global $wp_query;

$original_query = $wp_query;

$args = ControlsHelper::get_query_args( $settings );

$wp_query = new \WP_Query( $args );
?>

<?php if ( have_posts() ) : ?>
	<?php if ( 'list-small' == $settings['pre_style'] ) : ?>

		<div class="post-list">
			<?php
		        while ( have_posts() ) : the_post();
	    			echo Haru_Template::haru_get_template( 'menu-post/post-style-1.php', $settings );
		        endwhile;
			?>
		</div>

	<?php endif; ?>

<?php else : ?>
    <div class="haru-info"><?php echo esc_html__( 'No post found', 'haru-printspace' ); ?></div>
<?php endif; ?>

<?php 
wp_reset_query();
$wp_query = $original_query;
