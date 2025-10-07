<section class="team-section py-5 newline-team-widget-container">
    <div class="container">
        <div class="row team-header mb-5">
            <div class="col-xl-7 col-lg-6 team-header-left">
                <div class="section-header text-lg-start">
                    <?php if ($settings['tagline']) : ?>
                        <span class="section-tagline d-block mb-2"><?php echo esc_html($settings['tagline']); ?></span>
                    <?php endif; ?>
                    
                    <?php if ($settings['title']) : ?>
                        <h2 class="section-title"><?php echo esc_html($settings['title']); ?></h2>
                    <?php endif; ?>
                    
                    <div class="section-line"></div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 team-header-right">
                <?php if ($settings['description']) : ?>
                    <p class="mb-0 fw-bold"><?php echo esc_html($settings['description']); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($settings['team_members']) : ?>
            <div class="row team-members">
                <?php foreach ($settings['team_members'] as $member) : ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 team-member">
                        <div class="team-member-card">
                            <div class="member-image-box">
                                <div class="member-image">
                                    <img src="<?php echo esc_url($member['member_image']['url']); ?>" 
                                            alt="<?php echo esc_attr($member['member_image_alt']); ?>" 
                                            class="img-fluid">
                                </div>
                            </div>
                            <div class="member-content">
                                <div class="member-title-box">
                                    <div class="member-title-shape">
                                        <?php if ($member['title_shape_image']['url']) : ?>
                                            <img decoding="async" src="<?php echo esc_url($member['title_shape_image']['url']); ?>" alt="">
                                        <?php endif; ?>
                                        <div class="member-title-text">
                                            <?php if ($member['member_title']) : ?>
                                                <p class="member-title"><?php echo esc_html($member['member_title']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($member['member_name']) : ?>
                                    <h3 class="member-name">
                                        <?php if ($member['member_link']['url']) : ?>
                                            <a href="<?php echo esc_url($member['member_link']['url']); ?>" 
                                                target="<?php echo esc_attr($member['member_link']['is_external'] ? '_blank' : '_self'); ?>"
                                                rel="<?php echo esc_attr($member['member_link']['nofollow'] ? 'nofollow' : ''); ?>">
                                                <?php echo esc_html($member['member_name']); ?>
                                            </a>
                                        <?php else : ?>
                                            <?php echo esc_html($member['member_name']); ?>
                                        <?php endif; ?>
                                    </h3>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($settings['button_text']) : ?>
            <div class="text-center mt-4 meet-team-btn">
                <a href="<?php echo esc_url($settings['button_link']['url']); ?>" 
                    class="btn btn-meet-team"
                    target="<?php echo esc_attr($settings['button_link']['is_external'] ? '_blank' : '_self'); ?>"
                    rel="<?php echo esc_attr($settings['button_link']['nofollow'] ? 'nofollow' : ''); ?>">
                    <span><?php echo esc_html($settings['button_text']); ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>