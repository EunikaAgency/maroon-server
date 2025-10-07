<?php
class Elementor_Newline_Team_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'newline_team_widget';
    }

    public function get_title() {
        return esc_html__('Newline Team', 'newline-team-widget');
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function register_controls() {
        // Header Section
        $this->start_controls_section(
            'header_section',
            [
                'label' => esc_html__('Header', 'newline-team-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tagline',
            [
                'label' => esc_html__('Tagline', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Professional Melbourne Painters', 'newline-team-widget'),
                'placeholder' => esc_html__('Type your tagline here', 'newline-team-widget'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Meet Our Expert Team of Painters', 'newline-team-widget'),
                'placeholder' => esc_html__('Type your title here', 'newline-team-widget'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('At Newline Painting, our team combines experience, skill, and pride in every project we take on. From interiors to exteriors, we deliver top-quality work that\'s built to last.', 'newline-team-widget'),
                'placeholder' => esc_html__('Type your description here', 'newline-team-widget'),
            ]
        );

        $this->end_controls_section();

        // Team Members Section
        $this->start_controls_section(
            'team_members_section',
            [
                'label' => esc_html__('Team Members', 'newline-team-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'member_image',
            [
                'label' => esc_html__('Member Image', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'member_image_alt',
            [
                'label' => esc_html__('Image Alt Text', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter alt text for the image', 'newline-team-widget'),
            ]
        );

        $repeater->add_control(
            'member_name',
            [
                'label' => esc_html__('Name', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Team Member', 'newline-team-widget'),
                'placeholder' => esc_html__('Type member name here', 'newline-team-widget'),
            ]
        );

        $repeater->add_control(
            'member_title',
            [
                'label' => esc_html__('Title', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Team Member', 'newline-team-widget'),
                'placeholder' => esc_html__('Type member title here', 'newline-team-widget'),
            ]
        );

        $repeater->add_control(
            'title_shape_image',
            [
                'label' => esc_html__('Title Shape Image', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '/wp-content/uploads/2025/03/team-one-title-box-shape-red.png',
                ],
            ]
        );

        $repeater->add_control(
            'member_link',
            [
                'label' => esc_html__('Link', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'newline-team-widget'),
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label' => esc_html__('Team Members', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'member_name' => esc_html__('Phi Dang', 'newline-team-widget'),
                        'member_title' => esc_html__('Founder and Director', 'newline-team-widget'),
                        'member_image' => [
                            'url' => '/wp-content/uploads/2025/03/Phi-Dang-Founder-and-Chief-Talking-Officer-4.jpeg',
                        ],
                        'member_image_alt' => esc_html__('Painter in Newline Painting Uniform With Arms Crossed, Smiling Confidently', 'newline-team-widget'),
                    ],
                    [
                        'member_name' => esc_html__('Edward Perez', 'newline-team-widget'),
                        'member_title' => esc_html__('Partner and Managing Lead Painter', 'newline-team-widget'),
                        'member_image' => [
                            'url' => '/wp-content/uploads/2025/03/Edward-Perez.jpg',
                        ],
                        'member_image_alt' => esc_html__('Edward Perez', 'newline-team-widget'),
                    ],
                    [
                        'member_name' => esc_html__('Fredy Lopez', 'newline-team-widget'),
                        'member_title' => esc_html__('Team Leader', 'newline-team-widget'),
                        'member_image' => [
                            'url' => '/wp-content/uploads/2025/03/Fredy-Lopez.jpg',
                        ],
                        'member_image_alt' => esc_html__('Painter in Newline Painting Uniform With Arms Crossed, Smiling Confidently', 'newline-team-widget'),
                    ],
                    [
                        'member_name' => esc_html__('Zay Diaz', 'newline-team-widget'),
                        'member_title' => esc_html__('Painter', 'newline-team-widget'),
                        'member_image' => [
                            'url' => '/wp-content/uploads/2025/03/Zay-Diaz.jpg',
                        ],
                        'member_image_alt' => esc_html__('Painter in Newline Painting Uniform With Arms Crossed, Smiling Confidently', 'newline-team-widget'),
                    ],
                ],
                'title_field' => '{{{ member_name }}}',
            ]
        );

        $this->end_controls_section();

        // Button Section
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'newline-team-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Meet the Whole Team', 'newline-team-widget'),
                'placeholder' => esc_html__('Type button text here', 'newline-team-widget'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'newline-team-widget'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'newline-team-widget'),
                'default' => [
                    'url' => '/about-us/team',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
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
        <?php
    }
}