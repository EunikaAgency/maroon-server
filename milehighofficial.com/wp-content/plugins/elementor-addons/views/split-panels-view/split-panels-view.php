    <?php if ( ! empty($panels) ) : ?>
    <div class="split-panels" <?php echo $this->get_render_attribute_string('wrapper'); ?>>
        <?php foreach ( $panels as $index => $panel ) :
            $bg = !empty($panel['panel_bg']['url']) ? esc_url($panel['panel_bg']['url']) : '';
            $link = !empty($panel['panel_link']['url']) ? esc_url($panel['panel_link']['url']) : '#';
            $title = esc_html($panel['panel_title']);
            $text = esc_html($panel['panel_text']);
            $elements = !empty($panel['panel_elements']) ? $panel['panel_elements'] : ['title','text','button'];
            
            // Generate unique class for styling individual panels
            $panel_class = 'elementor-repeater-item-' . $panel['_id'];
            
            // Preload the first image for LCP optimization
            if ($index === 0 && $bg) {
                echo '<link rel="preload" as="image" href="' . $bg . '" fetchpriority="high">';
            }
        ?>

        <div class="panel <?php echo esc_attr($panel_class); ?>" data-bg="<?php echo $bg; ?>"
            <?php if($index === 0): ?> style="
                background-image: url('<?php echo $bg; ?>');
                background-size: cover;
                background-position: center;
                position: relative;
                height: 55vh;
            "<?php endif; ?>
        >
            <div class="panel-bg" 
                <?php if($index === 0): ?>style="background: linear-gradient(45deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);"<?php endif; ?>>
                <?php if ($bg && $index === 0): ?>
                    <img src="<?php echo $bg; ?>" 
                        alt="<?php echo esc_attr($title); ?>" 
                        fetchpriority="high"
                        decoding="async"
                        width="1280" 
                        height="720"
                        style="position:absolute;width:100%;height:100%;object-fit:cover;opacity:0;pointer-events:none;" />
                <?php endif; ?>
            </div>

            <?php if (!empty($panel['panel_vertical_label'])) : ?>
                <h3 class="vertical-label" aria-hidden="true">
                    <?php echo esc_html($panel['panel_vertical_label']); ?>
                </h3>
            <?php endif; ?>

            
            <div class="panel-content" role="article" aria-labelledby="panel-title-<?php echo $index; ?>">
                <div class="content-container">
                    <?php if (in_array('title', $elements)) : ?>
                        <h2 id="panel-title-<?php echo $index; ?>"><?php echo $title; ?></h2>
                    <?php endif; ?>
                    
                    <?php if (in_array('text', $elements)) : ?>
                        <p><?php echo $text; ?></p>
                    <?php endif; ?>
                    
                    <?php if (in_array('button', $elements)) : ?>
                        <a href="<?php echo $link; ?>" 
                        class="panel-btn hover-con hover-icon"
                        <?php if (!empty($panel['panel_link']['is_external'])): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                        <?php if (!empty($panel['panel_link']['nofollow'])): ?>rel="nofollow"<?php endif; ?>>
                            <span>
                                <?php echo !empty($panel['panel_button_text']) ? esc_html($panel['panel_button_text']) : 'Learn More'; ?>
                            </span>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php 
    // Add inline critical CSS for immediate render - prevents CLS
    if (!wp_doing_ajax() && !is_admin()): 
    ?>
    <style>
    /* Critical CSS for immediate render - prevents CLS */
    .split-panels { 
        display: flex; 
        flex-direction: column; 
        height: auto; 
        max-width: 2000px; 
        margin: 0 auto; 
    }
    .split-panels .panel { 
        flex: none; 
        display: flex; 
        position: relative; 
        overflow: hidden; 
        width: 100%; 
        height: 60vh; 
    }
    .split-panels .panel-content { 
        flex: 1; 
        display: flex; 
        flex-direction: column; 
        justify-content: center; 
        align-items: center; 
        color: white; 
        position: relative; 
        z-index: 1; 
    }
    .split-panels .panel-bg { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background-size: cover; 
        background-position: center; 
        z-index: 0; 
    }
    /* Ensure LCP image is visible immediately */
    .split-panels .panel:first-child .panel-bg {
        background-image: url('<?php echo !empty($panels[0]['panel_bg']['url']) ? $panels[0]['panel_bg']['url'] : ''; ?>') !important;
    }
    @media (min-width: 1025px) { 
        .split-panels { 
            flex-direction: row; 
            height: 52vh; 
        } 
        .split-panels .panel { 
            flex: 1; 
            height: auto; 
        } 
    }
    </style>
    <?php endif; ?>

    <?php endif; ?>