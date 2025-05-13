<?php

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Includes\Widgets\Traits\Button_Trait;

class Card_List_Widget extends Widget_Base
{
    use Button_Trait;

    public function get_name(): string
    {
        return 'hello_world_widget_2';
    }

    public function get_title(): string
    {
        return esc_html__('Card List', 'elementor-addon');
    }

    public function get_icon(): string
    {
        return 'eicon-code';
    }

    public function get_categories(): array
    {
        return ['basic'];
    }

    public function get_keywords(): array
    {
        return ['card', 'list'];
    }

    protected function register_controls()
    {
        // Card List Section
        $this->start_controls_section(
            'section_card_list',
            [
                'label' => esc_html__('Card List', 'elementor-addon'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        // Card Number (automatically generated but can be overridden)
        $repeater->add_control(
            'card_number',
            [
                'label' => esc_html__('Card Number', 'elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => '1',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        // Left Section Content
        $repeater->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Card Heading', 'elementor-addon'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'elementor-addon'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Card description text goes here.', 'elementor-addon'),
                'rows' => 5,
            ]
        );

        // Right Section - Image
        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Choose Image', 'elementor-addon'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'none',
            ]
        );

        // Register button controls for each card
        $repeater->start_controls_section(
            'section_button',
            [
                'label' => esc_html__('Button', 'elementor-addon'),
            ]
        );
        // Button Controls in Repeater
        $repeater->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Click here', 'elementor-addon'),
                'placeholder' => esc_html__('Click here', 'elementor-addon'),
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label' => esc_html__('Link', 'elementor-addon'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-addon'),
            ]
        );

        $repeater->add_control(
            'button_size',
            [
                'label' => esc_html__('Size', 'elementor-addon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'sm',
                'options' => [
                    'xs' => esc_html__('Extra Small', 'elementor-addon'),
                    'sm' => esc_html__('Small', 'elementor-addon'),
                    'md' => esc_html__('Medium', 'elementor-addon'),
                    'lg' => esc_html__('Large', 'elementor-addon'),
                    'xl' => esc_html__('Extra Large', 'elementor-addon'),
                ],
            ]
        );

        $repeater->add_control(
            'button_selected_icon',
            [
                'label' => esc_html__('Icon', 'elementor-addon'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
            ]
        );

        $repeater->add_control(
            'button_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'elementor-addon'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $repeater->end_controls_section();

        $this->add_control(
            'cards',
            [
                'label' => esc_html__('Cards', 'elementor-addon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'card_number' => '1',
                        'heading' => esc_html__('Card #1', 'elementor-addon'),
                        'description' => esc_html__('First card description', 'elementor-addon'),
                    ],
                    [
                        'card_number' => '2',
                        'heading' => esc_html__('Card #2', 'elementor-addon'),
                        'description' => esc_html__('Second card description', 'elementor-addon'),
                    ],
                ],
                'title_field' => '{{{ heading }}}',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'section_card_style',
            [
                'label' => esc_html__('Card Style', 'elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-list-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .card-list-item',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .card-list-item',
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Padding', 'elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_margin',
            [
                'label' => esc_html__('Margin', 'elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Number Style
        $this->start_controls_section(
            'section_number_style',
            [
                'label' => esc_html__('Number Style', 'elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__('Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'number_typography',
                'selector' => '{{WRAPPER}} .card-number',
            ]
        );

        $this->end_controls_section();

        // Heading Style
        $this->start_controls_section(
            'section_heading_style',
            [
                'label' => esc_html__('Heading Style', 'elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .card-heading',
            ]
        );

        $this->end_controls_section();

        // Description Style
        $this->start_controls_section(
            'section_description_style',
            [
                'label' => esc_html__('Description Style', 'elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .card-description',
            ]
        );

        $this->end_controls_section();

        // Button Style Section
        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__('Button', 'elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Button alignment
        $this->add_responsive_control(
            'button_align',
            [
                'label' => esc_html__('Alignment', 'elementor-addon'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'elementor-addon'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-addon'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'elementor-addon'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .card-button-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

       

        // Button text color
        $this->start_controls_tabs('button_tabs');

        // Normal state
        $this->start_controls_tab(
            'button_normal',
            [
                'label' => esc_html__('Normal', 'elementor-addon'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover state
        $this->start_controls_tab(
            'button_hover',
            [
                'label' => esc_html__('Hover', 'elementor-addon'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'elementor-addon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Button border radius
        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button padding
        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

       

        $this->end_controls_section();

        // Image Style
        $this->start_controls_section(
            'section_image_style',
            [
                'label' => esc_html__('Image Style', 'elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .card-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Button styles are automatically registered by the Button_Trait
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['cards'])) {
            return;
        }
?>

        <div class="card-list-wrapper">
            <?php foreach ($settings['cards'] as $index => $item) : ?>
                <div class="card-list-item elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
                    <div class="card-number"><?php echo esc_html($item['card_number']); ?></div>

                    <div class="card-content-wrapper">
                        <div class="card-left-section">
                            <h3 class="card-heading"><?php echo esc_html($item['heading']); ?></h3>
                            <div class="card-description"><?php echo wp_kses_post($item['description']); ?></div>

                            <?php if (!empty($item['button_text'])) : ?>
                                <div class="card-button-wrapper">
                                    <a href="<?php echo esc_url($item['button_link']['url']); ?>"
                                        class="elementor-button elementor-size-<?php echo esc_attr($item['button_size']); ?>"
                                        <?php if ($item['button_link']['is_external']) : ?> target="_blank" <?php endif; ?>
                                        <?php if ($item['button_link']['nofollow']) : ?> rel="nofollow" <?php endif; ?>
                                        <?php if ($item['button_hover_animation']) : ?> data-animation="<?php echo esc_attr($item['button_hover_animation']); ?>" <?php endif; ?>>
                                        <?php if ($item['button_selected_icon']['value']) : ?>
                                            <span class="elementor-button-icon">
                                                <i class="<?php echo esc_attr($item['button_selected_icon']['value']); ?>"></i>
                                            </span>
                                        <?php endif; ?>
                                        <span class="elementor-button-text"><?php echo esc_html($item['button_text']); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($item['image']['url'])) : ?>
                            <div class="card-image">
                                <?php echo Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'image'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
    }

    protected function content_template()
    {
    ?>
        <div class="card-list-wrapper">
            <# _.each(settings.cards, function(item, index) {
                var image={
                id: item.image.id,
                url: item.image.url,
                size: item.thumbnail_size,
                dimension: item.thumbnail_custom_dimension,
                model: view.getEditModel()
                };
                var imageUrl=elementor.imagesManager.getImageUrl(image);
                #>
                <div class="card-list-item elementor-repeater-item-{{ item._id }}">
                    <div class="card-number">{{{ item.card_number }}}</div>

                    <div class="card-content-wrapper">
                        <div class="card-left-section">
                            <h3 class="card-heading">{{{ item.heading }}}</h3>
                            <div class="card-description">{{{ item.description }}}</div>

                            <# if (item.button_text) { #>
                                <div class="card-button-wrapper">
                                    <a href="{{ item.button_link.url }}"
                                        class="elementor-button elementor-size-{{ item.button_size }}"
                                        <# if (item.button_link.is_external) { #> target="_blank" <# } #>
                                            <# if (item.button_link.nofollow) { #> rel="nofollow" <# } #>
                                                    <# if (item.button_hover_animation) { #> data-animation="{{ item.button_hover_animation }}" <# } #>>
                                                            <# if (item.button_selected_icon.value) { #>
                                                                <span class="elementor-button-icon">
                                                                    <i class="{{ item.button_selected_icon.value }}"></i>
                                                                </span>
                                                                <# } #>
                                                                    <span class="elementor-button-text">{{{ item.button_text }}}</span>
                                    </a>
                                </div>
                                <# } #>
                        </div>

                        <# if (item.image.url) { #>
                            <div class="card-image">
                                <img src="{{ imageUrl }}" alt="">
                            </div>
                            <# } #>
                    </div>
                </div>
                <# }); #>
        </div>
<?php
    }

    protected function set_repeater_button_settings($item)
    {
        $settings = [
            'text' => $item['text'] ?? '',
            'link' => $item['link'] ?? ['url' => ''],
            'selected_icon' => $item['selected_icon'] ?? '',
            'button_size' => $item['button_size'] ?? 'md',
            'button_hover_animation' => $item['button_hover_animation'] ?? '',
        ];

        $this->set_settings($settings);
    }
}
