<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

namespace Haru_PrintSpace\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Haru_PrintSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_PrintSpace_Price_Table_Widget' ) ) {
    class Haru_PrintSpace_Price_Table_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-price-table';
        }

        public function get_title() {
            return esc_html__( 'Haru Price Table', 'haru-printspace' );
        }

        public function get_icon() {
            return 'eicon-price-table';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'price-table',
                'price',
                'table',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_icon',
                [
                    'label' => __( 'Price Table', 'haru-printspace' ),
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Price Table', 'haru-printspace' ),
                    'description'   => __( 'If you choose Pre Price Table you will use Style default from our theme.', 'haru-printspace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( '- Pre Price Table 1', 'haru-printspace' ),
                        'style-2'   => __( '- Pre Price Table 2', 'haru-printspace' ),
                        'style-3'   => __( '- Pre Price Table 3', 'haru-printspace' ),
                        'style-4'   => __( '- Pre Price Table 4', 'haru-printspace' ),
                        'style-5'   => __( '- Pre Price Table 5', 'haru-printspace' ),
                        'style-6'   => __( '- Pre Price Table 6 - NFT', 'haru-printspace' ),
                    ]
                ]
            );

            $this->add_control(
                'featured',
                [
                    'label'         => __( 'Featured', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'selected_icon',
                [
                    'label' => __( 'Icon', 'haru-printspace' ),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-2', 'style-4', 'style-5' ],
                    ],
                ],
            );

            $this->add_control(
                'featured_text',
                [
                    'label' => __( 'Featured Text', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Featured', 'haru-printspace' ),
                    'placeholder' => __( 'Enter your featured text', 'haru-printspace' ),
                    'label_block' => true,
                    'condition' => [
                        'featured' => [ 'yes' ],
                        'pre_style' => [ 'style-1', 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
                'title_text',
                [
                    'label' => __( 'Title', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'This is the title', 'haru-printspace' ),
                    'placeholder' => __( 'Enter your title', 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'price_unit',
                [
                    'label' => __( 'Price Unit', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( '/Month', 'haru-printspace' ),
                    'placeholder' => __( '/Month', 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'description_text',
                [
                    'label' => __( 'Description', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Description text.', 'haru-printspace' ),
                    'placeholder' => __( 'Enter your description', 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'sub_description_text',
                [
                    'label' => __( 'Sub Description', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __( 'This is the sub description', 'haru-printspace' ),
                    'placeholder' => __( 'Enter your sub description', 'haru-printspace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-2', 'style-6' ],
                    ],
                ]
            );

            $this->add_control(
                'link',
                [
                    'label' => __( 'Link', 'haru-printspace' ),
                    'type' => Controls_Manager::URL,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'placeholder' => __( 'https://your-link.com', 'haru-printspace' ),
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'link_text',
                [
                    'label' => __( 'Link Text', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Purchase Now', 'haru-printspace' ),
                    'placeholder' => __( 'Link text', 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'list_title', [
                    'label' => esc_html__( 'Title', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Title' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_disable',
                [
                    'label'         => __( 'Disable', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Disable this content.', 'haru-printspace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'list',
                [
                    'label' => esc_html__( 'Content List', 'haru-printspace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
                            'list_disable' => 'no',
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
                            'list_disable' => 'no',
                        ],
                    ],
                    'title_field' => '{{{ list_title }}}',
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-3', 'style-4', 'style-5', 'style-6' ],
                    ],
                ]
            );

            // New
            $this->add_control(
                'content_description_text',
                [
                    'label' => __( 'Content Description', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'This is the content description', 'haru-printspace' ),
                    'placeholder' => __( 'Enter your content description', 'haru-printspace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-2', 'style-4', 'style-5' ],
                    ],
                ]
            );

            $repeater_icon = new Repeater();

            $repeater_icon->add_control(
                'list_title', [
                    'label' => esc_html__( 'Title', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Title' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater_icon->add_control(
                'list_sub_title', [
                    'label' => esc_html__( 'Sub Title', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Sub Title' , 'haru-printspace' ),
                    'label_block' => true,
                ]
            );

            $repeater_icon->add_control(
                'list_title_icon',
                [
                    'label' => esc_html__( 'Icon', 'haru-printspace' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'solid',
                    ],
                    'label_block' => true,
                ]
            );

            $repeater_icon->add_control(
                'list_disable',
                [
                    'label'         => __( 'Disable', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Disable this content.', 'haru-printspace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'list_icon',
                [
                    'label' => esc_html__( 'Icon List', 'haru-printspace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater_icon->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-printspace' ),
                            'list_sub_title' => esc_html__( 'Sub Title.', 'haru-printspace' ),
                            'list_title_icon' => esc_html__( 'Select Icon', 'haru-printspace' ),
                            'list_disable' => 'no',
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-printspace' ),
                            'list_sub_title' => esc_html__( 'Sub Title.', 'haru-printspace' ),
                            'list_title_icon' => esc_html__( 'Select Icon', 'haru-printspace' ),
                            'list_disable' => 'no',
                        ],
                    ],
                    'title_field' => '{{{ list_title }}}',
                    'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
                ]
            );

            $this->add_control(
                'el_class',
                [
                    'label' => __( 'CSS Classes', 'haru-printspace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'title' => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'haru-printspace' ),
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_title_style',
                [
                    'label' => __( 'Layout', 'haru-printspace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'background_dark',
                [
                    'label'         => __( 'Background Dark', 'haru-printspace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if use for section has background dark.', 'haru-printspace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_style_icon',
                [
                    'label' => __( 'Icon', 'haru-printspace' ),
                    'tab'   => Controls_Manager::TAB_STYLE,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'selected_icon[value]',
                                'operator' => '!=',
                                'value' => '',
                            ],
                        ],
                    ],
                ]
            );

            $this->add_control(
                'primary_color',
                [
                    'label' => __( 'Primary Color', 'haru-printspace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-price-table__icon' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .haru-price-table__icon svg, {{WRAPPER}} .haru-price-table__icon *' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_style_content',
                [
                    'label' => __( 'Content', 'haru-printspace' ),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_responsive_control(
                'text_align',
                [
                    'label' => __( 'Alignment', 'haru-printspace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'haru-printspace' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'haru-printspace' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'haru-printspace' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'haru-printspace' ),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'default' => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .haru-price-table' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'price-table', 'class', 'haru-price-table' );

            if ( $settings['pre_style']  ) {
                $this->add_render_attribute( 'price-table', 'class', 'haru-price-table--' . $settings['pre_style'] );
            }

            if ( 'yes' == $settings['featured']  ) {
                 $this->add_render_attribute( 'price-table', 'class', 'plan-featured' );
            }
            

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'price-table', 'class', $settings['el_class'] );
            }

            $icon_tag = 'span';

            if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                // add old default
                $settings['icon'] = 'fa fa-star';
            }

            $has_icon = ! empty( $settings['icon'] );

            if ( ! empty( $settings['link']['url'] ) ) {
                $icon_tag = 'a';

                $this->add_link_attributes( 'link', $settings['link'] );
            }

            if ( $has_icon ) {
                $this->add_render_attribute( 'i', 'class', $settings['icon'] );
                $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
            }

            $icon_attributes = $this->get_render_attribute_string( 'icon' );
            $link_attributes = $this->get_render_attribute_string( 'link' );

            $this->add_render_attribute( 'description_text', 'class', 'haru-price-table__description' );
            $this->add_render_attribute( 'sub_description_text', 'class', 'haru-price-table__sub-description' );

            $this->add_inline_editing_attributes( 'title_text', 'none' );
            $this->add_inline_editing_attributes( 'description_text' );
            if ( ! $has_icon && ! empty( $settings['selected_icon']['value'] ) ) {
                $has_icon = true;
            }
            $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
            $is_new = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'price-table' ); ?>>
                    <?php if ( in_array( $settings['pre_style'], array( 'style-1', 'style-3', 'style-6' ) ) ) : ?>
                        <?php if ( $settings['featured_text'] && $settings['pre_style'] == 'style-1' ) : ?>
                            <div class="haru-price-table__featured"><?php echo $settings['featured_text']; ?></div>
                        <?php endif; ?>

                        <div class="haru-price-table__wrap">
                            <div class="haru-price-table__top">
                                <?php if ( $has_icon ) : ?>
                                <div class="haru-price-table__icon">
                                    <<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
                                    <?php
                                    if ( $is_new || $migrated ) {
                                        Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                    } elseif ( ! empty( $settings['icon'] ) ) {
                                        ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                                    }
                                    ?>
                                    </<?php echo $icon_tag; ?>>
                                </div>
                                <?php endif; ?>

                                <?php if ( $settings['featured_text'] && $settings['pre_style'] == 'style-3' ) : ?>
                                    <div class="haru-price-table__featured"><?php echo $settings['featured_text']; ?></div>
                                <?php endif; ?>

                                <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></div>
                                <?php endif; ?>

                                <?php if ( ! Utils::is_empty( $settings['sub_description_text'] ) ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'sub_description_text' ); ?>><?php echo $settings['sub_description_text']; ?></div>
                                <?php endif; ?>

                                <h6 class="haru-price-table__title">
                                    <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
                                    <span class="haru-price-table__unit"><?php echo esc_html( $settings['price_unit'] ); ?></span>
                                </h6>
                            </div>

                            <?php if ( $settings['list'] ) : ?>
                                <div class="haru-price-table__content">
                                    <ul class="haru-price-table__list">
                                    <?php
                                        foreach ( $settings['list'] as $item ) :
                                    ?>
                                        <li class="haru-price-table__item <?php echo ( 'yes' == $item['list_disable'] ) ? 'content-disable' : ''; ?>">
                                        <?php if ( $item['list_title'] ) : ?>
                                            <span class="content-title"><?php echo $item['list_title']; ?></span>
                                        <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $settings['link']['url'] && $settings['link_text'] ) ) : ?>
                                <?php if ( 'yes' != $settings['featured']  ) : ?>
                                    <?php if ( in_array( $settings['pre_style'], array( 'style-6' ) ) ) : ?>
                                        <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--bg-white-nft haru-button--size-large haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--style-1 haru-button--size-large haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if ( in_array( $settings['pre_style'], array( 'style-6' ) ) ) : ?>
                                         <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--bg-gradient-nft haru-button--size-large haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--style-1 haru-button--bg-primary haru-button--size-large haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif ( in_array( $settings['pre_style'], array( 'style-2' ) ) ) : ?>
                        <div class="haru-price-table__wrap">
                            <div class="haru-price-table__top">
                                <?php if ( $has_icon ) : ?>
                                <div class="haru-price-table__icon">
                                    <<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
                                    <?php
                                    if ( $is_new || $migrated ) {
                                        Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                    } elseif ( ! empty( $settings['icon'] ) ) {
                                        ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                                    }
                                    ?>
                                    </<?php echo $icon_tag; ?>>
                                </div>
                                <?php endif; ?>

                                <div class="haru-price-table__top-right">
                                    <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
                                    <div <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></div>
                                    <?php endif; ?>

                                    <?php if ( ! Utils::is_empty( $settings['sub_description_text'] ) ) : ?>
                                    <div class="haru-price-table__sub-description"><?php echo $settings['sub_description_text']; ?></div>
                                    <?php endif; ?>
                                </div>
                                
                            </div>

                            <h6 class="haru-price-table__title">
                                <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
                                <span class="haru-price-table__unit"><?php echo esc_html( $settings['price_unit'] ); ?></span>
                            </h6>

                            <?php if ( ! Utils::is_empty( $settings['content_description_text'] ) ) : ?>
                            <div class="haru-price-table__content-desc"><?php echo $settings['content_description_text']; ?></div>
                            <?php endif; ?>

                            <?php if ( $settings['list_icon'] ) : ?>
                                <div class="haru-price-table__content">
                                    <ul class="haru-price-table__list">
                                    <?php
                                        foreach ( $settings['list_icon'] as $item ) :
                                    ?>
                                        <li class="haru-price-table__item <?php echo ( 'yes' == $item['list_disable'] ) ? 'content-disable' : ''; ?>">
                                        <?php if ( $item['list_title'] ) : ?>
                                            <div class="haru-price-table__item-icon">
                                                <?php Icons_Manager::render_icon( $item['list_title_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                            </div>
                                            <div class="haru-price-table__item-content">
                                                <h6 class="haru-price-table__item-title"><?php echo esc_html( $item['list_title'] ); ?></h6>
                                                <div class="haru-price-table__item-sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
                                            </div>
                                        <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $settings['link']['url'] && $settings['link_text'] ) ) : ?>
                                <?php if ( 'yes' != $settings['featured']  ) : ?>
                                    <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--bg-white haru-button--size-medium haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--bg-gradient haru-button--size-medium haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif ( in_array( $settings['pre_style'], array( 'style-4', 'style-5' ) ) ) : ?>
                        <div class="haru-price-table__wrap">
                            <div class="haru-price-table__top">
                                <?php if ( $has_icon ) : ?>
                                <div class="haru-price-table__icon">
                                    <<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
                                    <?php
                                    if ( $is_new || $migrated ) {
                                        Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                    } elseif ( ! empty( $settings['icon'] ) ) {
                                        ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                                    }
                                    ?>
                                    </<?php echo $icon_tag; ?>>
                                </div>
                                <?php endif; ?>

                                <div class="haru-price-table__top-right">
                                    <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
                                    <div <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></div>
                                    <?php endif; ?>

                                    <?php if ( ! Utils::is_empty( $settings['sub_description_text'] ) ) : ?>
                                    <div class="haru-price-table__sub-description"><?php echo $settings['sub_description_text']; ?></div>
                                    <?php endif; ?>
                                </div>
                                
                            </div>

                            <?php if ( ! Utils::is_empty( $settings['content_description_text'] ) ) : ?>
                            <div class="haru-price-table__content-desc"><?php echo $settings['content_description_text']; ?></div>
                            <?php endif; ?>

                            <?php if ( $settings['list'] ) : ?>
                                <div class="haru-price-table__content">
                                    <ul class="haru-price-table__list">
                                    <?php
                                        foreach ( $settings['list'] as $item ) :
                                    ?>
                                        <li class="haru-price-table__item <?php echo ( 'yes' == $item['list_disable'] ) ? 'content-disable' : ''; ?>">
                                        <?php if ( $item['list_title'] ) : ?>
                                            <span class="content-title"><?php echo $item['list_title']; ?></span>
                                        <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <h6 class="haru-price-table__title">
                                <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
                                <span class="haru-price-table__unit"><?php echo esc_html( $settings['price_unit'] ); ?></span>
                            </h6>

                            <?php if ( ! empty( $settings['link']['url'] && $settings['link_text'] ) ) : ?>
                                <?php if ( 'yes' != $settings['featured']  ) : ?>
                                    <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--bg-black haru-button--size-medium haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--bg-primary haru-button--size-medium haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
