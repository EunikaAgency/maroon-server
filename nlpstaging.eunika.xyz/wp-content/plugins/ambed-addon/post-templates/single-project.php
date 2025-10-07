<?php
get_header(); ?>
<?php

$ambed_project_category =  get_the_terms(get_the_ID(), 'project_cat');
$ambed_project_tag =  get_the_terms(get_the_ID(), 'project_tag');
?>
<!--Project Details Start-->
<section class="project-details">
    <div class="container">
        <div class="project-details__img-box">
            <div class="project-details__img">
                <?php the_post_thumbnail('ambed_project_1170X478'); ?>
            </div>

        <div class="project-info bg-white shadow-sm p-3 p-lg-5 mx-lg-5 mx-2">
        <div class="project-info-wrapper">
            <?php if (is_array($ambed_project_category)) : ?>
            <div class="project-info-block">
                <span class="text-danger d-block mb-1"><?php esc_html_e('Category', 'ambed-addon'); ?>:</span>
                <p class="fw-bold mb-0 text-dark">
                <?php
                $cat_names = array_map(fn($cat) => esc_html($cat->name), $ambed_project_category);
                echo implode(', ', $cat_names);
                ?>
                </p>
            </div>
            <?php endif; ?>

            <?php if (is_array($ambed_project_tag)) : ?>
            <div class="project-info-block">
                <span class="text-danger d-block mb-1"><?php esc_html_e('Services', 'ambed-addon'); ?>:</span>
                <p class="fw-bold mb-0 text-dark">
                <?php
                $tag_names = array_map(fn($tag) => esc_html($tag->name), $ambed_project_tag);
                echo implode(', ', $tag_names);
                ?>
                </p>
            </div>
            <?php endif; ?>

            <?php
            $ambed_social_network = get_post_meta(get_the_ID(), 'ambed_project_social_network', true);
            if (is_array($ambed_social_network) && !empty($ambed_social_network)) :
            $has_valid_links = false;
            foreach ($ambed_social_network as $item) {
                if (!empty($item['ambed_social_network_url']) && $item['ambed_social_network_url'] !== '#') {
                $has_valid_links = true;
                break;
                }
            }
            if ($has_valid_links) : ?>
                <div class="project-info-block">
                <span class="text-danger d-block mb-2"><?php esc_html_e('Social Network', 'ambed-addon'); ?>:</span>
                <div class="d-flex gap-2">
                    <?php foreach ($ambed_social_network as $item) :
                    if (empty($item['ambed_social_network_url']) || $item['ambed_social_network_url'] === '#') continue;

                    $icon_class = isset($item['ambed_feature_is_fontawesome']) && $item['ambed_feature_is_fontawesome'] === 'yes'
                        ? $item['ambed_social_network_icon'] . ' ' . $item['ambed_feature_fontawesome_type']
                        : $item['ambed_social_network_icon'];

                    if (!empty($item['ambed_social_network_icon'])) : ?>
                        <a href="<?php echo esc_url($item['ambed_social_network_url']); ?>" class="text-dark fs-5">
                        <i class="<?php echo esc_attr($icon_class); ?>"></i>
                        </a>
                    <?php endif;
                    endforeach; ?>
                </div>
                </div>
            <?php endif;
            endif; ?>
        </div>
        </div>




<style>

.project-info{
    
    margin-top: -40px !important;
    position: relative;
    border-top-left-radius: 0px !important;
    border-bottom-left-radius: var(--bs-border-radius-xl) !important;
    border-bottom-right-radius: var(--bs-border-radius-xl) !important;
    border-top-right-radius: var(--bs-border-radius-xl) !important;
}

.project-info-wrapper {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  text-align: center;
}

.project-info-block {
  flex: 1 1 0;
  padding: 0 1.5rem;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}

/* Slanted divider between items (hidden on small screens) */
.project-info-block:not(:first-child)::before {
  content: '';
  position: absolute;
  left: 0;
  top: 10%;
  height: 80%;
  width: 2px;
  background-color: #ccc;
  transform: rotate(20deg);
  transform-origin: top left;
}

@media (max-width: 767.98px) {
  /* Hide divider on mobile */
  .project-info-block:not(:first-child)::before {
    display: none;
  }

  /* Add spacing between blocks on mobile */
  .project-info-block {
    padding-top: 1.5rem;
    padding-bottom: 1.5rem;
  }
}



</style>




        </div>
        <div class="project-details__room-wallpapers">
            <!-- <h3 class="project-details__room-wallpapers-title"><?php the_title(); ?></h3> -->
        </div>
        <?php the_content(); ?>

        <div class="projectc-details__pagination-box">
            <div class="row">
                <?php
                $ambed_prev_post = get_previous_post();


                $ambed__next_post = get_next_post();

                ?>
                <?php if ($ambed_prev_post) : ?>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="projectc-details__pagination-single">
                            <div class="projectc-details__pagination-icon">
                                <a href="<?php echo esc_url(get_permalink($ambed_prev_post->ID)); ?>"><i class="fa fa-angle-left"></i></a>
                            </div>
                            <div class="projectc-details__pagination-content">
                                <span><?php esc_html_e('Previous Post', 'ambed-addon'); ?></span>
                                <p><?php echo esc_html($ambed_prev_post->post_title); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if ($ambed__next_post) : ?>
    <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="projectc-details__pagination-single projectc-details__pagination-single-two">
            <div class="projectc-details__pagination-content">
                <span><?php esc_html_e('Next Post', 'ambed-addon'); ?></span>
                <p><?php echo esc_html($ambed__next_post->post_title); ?></p>
            </div>
            <div class="projectc-details__pagination-icon">
                <a href="<?php echo esc_url(get_permalink($ambed__next_post->ID)); ?>"><i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </div>
<?php endif; ?>
                
            </div>
        </div>
    </div>
</section>
<!--Project Details End-->


<?php
get_footer();
