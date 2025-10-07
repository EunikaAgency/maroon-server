<?php
/**
 * Widget Class
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Wpnw_Pro_Widget
 *
 * @extends  WP_Widget
 */
abstract class Wpnw_Pro_Widget extends WP_Widget {

	/**
	 * Widget Title.
	 *
	 * @var string
	 */
	public $widget_title;

	/**
	 * CSS class.
	 *
	 * @var string
	 */
	public $widget_cssclass;

	/**
	 * Widget description.
	 *
	 * @var string
	 */
	public $widget_description;

	/**
	 * Widget ID.
	 *
	 * @var string
	 */
	public $widget_id;

	/**
	 * Widget name.
	 *
	 * @var string
	 */
	public $widget_name;

	/**
	 * Settings.
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Settings defaults.
	 *
	 * @var array
	 */
	public $defaults;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'						=> $this->widget_cssclass,
			'description'					=> $this->widget_description,
			'customize_selective_refresh'	=> true,
		);

		parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
	}

	/**
	 * Get default settings
	 *
	 */
	public function default_settings() {

		// Taking some defaults
		$default_fields = array(
								'title' => $this->widget_title
								);
		$fields			= $this->settings;

		// Creating defaults
		if( ! empty( $fields ) ) {
			foreach ( $fields as $field_key => $field_val ) {

				if( ! empty( $field_val['params'] ) ) {
					foreach ( $field_val['params'] as $param_key => $param_val ) {
						
						// If no shortcode paramter name is set
						if( empty( $param_val['name'] ) ) {
							continue;
						}

						if( isset( $param_val['default'] ) ) {
							$default_field_val = $param_val['default'];
						} else if ( isset( $param_val['value'] ) && is_scalar( $param_val['value'] ) ) {
							$default_field_val = $param_val['value'];
						} else if ( isset( $param_val['value'] ) && is_array( $param_val['value'] ) ) {
							$default_field_val = key( $param_val['value'] );
						} else {
							$default_field_val = '';
						}

						$default_fields[ $param_val['name'] ] = $default_field_val;

					} // End of inner for each

					// Some extra parameter
					$default_fields['tab'] = 'general';
				}
			}
		}

		return $default_fields;
	}

	/**
	 * Output the html at the start of a widget.
	 *
	 * @param array $args Arguments.
	 * @param array $instance Instance.
	 */
	public function widget_start( $args, $instance ) {

		echo $args['before_widget'];

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
	}

	/**
	 * Output the html at the end of a widget.
	 *
	 * @param  array $args Arguments.
	 */
	public function widget_end( $args, $instance ) {
		echo $args['after_widget'];
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * @see    WP_Widget->update
	 * @param  array $new_instance New instance.
	 * @param  array $old_instance Old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance		= $old_instance;
		$new_instance	= wp_parse_args( (array)$new_instance, $this->defaults );

		if ( empty( $this->settings ) ) {
			return $instance;
		}

		// Loop settings and get values to save.
		foreach ( $this->settings as $key => $setting ) {

			if( ! empty( $setting['params'] ) ) {
				foreach ( $setting['params'] as $param_key => $param_val ) {
					
					// If shortcode paramter name or field type is not set
					if( empty( $param_val['name'] ) || empty( $param_val['type'] ) ) {
						continue;
					}

					$param_name = $param_val['name'];

					// Format the value based on settings type.
					switch ( $param_val['type'] ) {
						case 'number':
							
							// Min validation
							if( isset( $param_val['min'] ) && $new_instance[ $param_name ] < $param_val['min'] ) {
								$new_instance[ $param_name ] = $param_val['min'];
							}

							// Max Validation
							if( isset( $param_val['max'] ) && $new_instance[ $param_name ] > $param_val['max'] ) {
								$new_instance[ $param_name ] = $param_val['max'];
							}

							$validation					= isset( $param_val['validation'] )	? $param_val['validation']	: 'int';
							$default_value				= isset( $param_val['value'] )		? $param_val['value']		: '';
							$instance[ $param_name ]	= wpnw_pro_clean_number( $new_instance[ $param_name ], $default_value, $validation );
							break;

						case 'textarea':
							$instance[ $param_name ] = sanitize_textarea_field( $new_instance[ $param_name ] );
							break;

						case 'colorpicker':
							$default_value				= isset( $param_val['value'] )				? $param_val['value']			: '';
							$color_value				= ! empty( $new_instance[ $param_name ] )	? $new_instance[ $param_name ]	: $default_value;
							$instance[ $param_name ]	= wpnw_pro_clean_color( $color_value );
							break;

						case 'checkbox':
							$instance[ $param_name ] = empty( $new_instance[ $param_name ] ) ? 0 : 1;
							break;

						default:
							$instance[ $param_name ] = isset( $new_instance[ $param_name ] ) ? wpnw_pro_clean( $new_instance[ $param_name ] ) : '';
							break;
					}					
				}
			}
		}

		// Extra parameter
		$instance['title']	= wpnw_pro_clean( $new_instance['title'] );
		$instance['tab']	= wpnw_pro_clean( $new_instance['tab'] );

		return $instance;
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @see   WP_Widget->form
	 *
	 * @param array $instance Instance.
	 */
	public function form( $instance ) {

		if ( empty( $this->settings ) ) {
			return;
		}

		// Merge with dafaults
		$title_field_render	= false;
		$instance			= wp_parse_args( (array)$instance, $this->defaults );

		// HTML start
		echo '<div class="wpnw-wdgt-accordion-wrap wpnw-widget-wrap">';

		foreach ($this->settings as $setting_key => $setting_data) {

			$section_title 	= isset( $setting_data['title'] ) 		? $setting_data['title'] 			: '';
			$section_params	= ! empty( $setting_data['params'] )	? (array)$setting_data['params'] 	: '';
			$section_class	= ( $instance['tab'] != $setting_key )	? 'wpnw-hide'						: '';

			if( ! $section_params ) {
				continue;
			}

			echo '<div class="wpnw-wdgt-accordion-header wpnw-wdgt-accordion-header-'.$setting_key.'" data-target="'.$setting_key.'"><i class="dashicons dashicons-admin-generic"></i> '.$section_title.'<i class="dashicons dashicons-arrow-down-alt2" title="'. esc_html__('Click to toggle', 'sp-news-and-widget') .'"></i></div>';
			echo '<div class="wpnw-wdgt-accordion-cnt wpnw-wdgt-accordion-cnt-'.$setting_key .' '. $section_class.'">';

			// Title Field For Widget
			if( ! $title_field_render ) {
			echo '<p>
					<label for="'. esc_attr( $this->get_field_id( 'title' ) ) .'">' . __('Title', 'sp-news-and-widget') . ':</label>
					<input class="widefat wpnw-widget-title-inp" id="'. esc_attr( $this->get_field_id( 'title' ) ) .'" name="'.esc_attr( $this->get_field_name( 'title' ) ).'" type="text" value="'. esc_attr( $instance['title'] ) .'" />
				</p>';

				$title_field_render = true;
			}

			foreach ( $section_params as $param_key => $param_val ) {

				// If field name is not there then return
				if( empty( $param_val['name'] ) ) {
					continue;
				}

				$name		= $param_val['name'];
				$desc		= ! empty( $param_val['desc'] ) 	? $param_val['desc']			: '';
				$heading	= ! empty( $param_val['heading'] )	? $param_val['heading']			: '';
				$value		= isset( $instance[ $name ] )		? $instance[ $name ]			: '';
				$class 		= ! empty( $param_val['class'] ) 	? 'wpnw-'.$name.' '.$param_val['class'] : 'wpnw-'.$name;

				switch ( $param_val['type'] ) {

					case 'text':
						?>
						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php echo $heading; ?>:</label>
							<input class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
							<?php if( $desc ) { ?><em><?php echo $desc; ?></em><?php } ?>
						</p>
						<?php
						break;

					case 'number':
						?>
						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php echo $heading; ?>:</label>
							<input class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
							<?php if( $desc ) { ?><em><?php echo $desc; ?></em><?php } ?>
						</p>
						<?php
						break;

					case 'dropdown':
						?>
						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php echo $heading; ?>:</label><br/>
							<select class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>">
								<?php foreach ( $param_val['value'] as $option_key => $option_value ) : ?>
									<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $value ); ?>><?php echo esc_html( $option_value ); ?></option>
								<?php endforeach; ?>
							</select><br/>
							<?php if( $desc ) { ?><em><?php echo $desc; ?></em><?php } ?>
						</p>
						<?php
						break;

					case 'textarea':
						?>
						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php echo $heading; ?>:</label>
							<textarea class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" cols="20" rows="3"><?php echo esc_textarea( $value ); ?></textarea>
							<?php if( $desc ) { ?><em><?php echo $desc; ?></em><?php } ?>
						</p>
						<?php
						break;

					case 'checkbox':
						?>
						<p>
							<input class="checkbox <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" type="checkbox" value="1" <?php checked( $value, 1 ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php echo $heading; ?></label>
							<?php if( $desc ) { ?><em><?php echo $desc; ?></em><?php } ?>
						</p>
						<?php
						break;

					case 'colorpicker':

						// Color Picker HTML for Beaver Builder
						if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) { ?>
							
							<p>
								<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php echo $heading; ?>:</label><br/>
								<div class="fl-color-picker fl-color-picker-has-reset">
									<button class="fl-color-picker-color" style="animation-name: fl-grab-attention; background-color: <?php echo esc_attr( $value ); ?>;">
										<svg class="fl-color-picker-icon" width="18px" height="18px" viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
											<g fill-rule="evenodd">
												<path d="M17.7037706,2.62786498 L15.3689327,0.292540631 C14.9789598,-0.0975135435 14.3440039,-0.0975135435 13.954031,0.292540631 L10.829248,3.41797472 L8.91438095,1.49770802 L7.4994792,2.91290457 L8.9193806,4.33310182 L0,13.2493402 L0,18 L4.74967016,18 L13.6690508,9.07876094 L15.0839525,10.4989582 L16.4988542,9.08376163 L14.5789876,7.16349493 L17.7037706,4.03806084 C18.0987431,3.64800667 18.0987431,3.01791916 17.7037706,2.62786498 Z M3.92288433,16 L2,14.0771157 L10.0771157,6 L12,7.92288433 L3.92288433,16 Z"></path>
											</g>
										</svg>
									</button>

									<button class="fl-color-picker-clear">
										<svg width="13px" height="13px" viewBox="0 0 13 13" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
											<g transform="translate(-321.000000, -188.000000)">
												<path d="M326.313708,193.313708 L326.313708,186.313708 L328.313708,186.313708 L328.313708,193.313708 L335.313708,193.313708 L335.313708,195.313708 L328.313708,195.313708 L328.313708,202.313708 L326.313708,202.313708 L326.313708,195.313708 L319.313708,195.313708 L319.313708,193.313708 L326.313708,193.313708 Z" transform="translate(327.313708, 194.313708) rotate(-45.000000) translate(-327.313708, -194.313708) "></path>
											</g>
										</svg>
									</button>
									<input class="wpnw-wdgt-color-box fl-color-picker-value <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" type="hidden" value="<?php echo esc_attr( $value ); ?>" />
									<div class="fl-clear"></div>
								</div>
								<?php if( $desc ) { ?><br/><em><?php echo $desc; ?></em><?php } ?>
							</p>

						<?php } else { ?>

							<p>
								<label for="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>"><?php echo $heading; ?>:</label><br/>
								<input class="wpnw-wdgt-color-box <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
								<?php if( $desc ) { ?><br/><em><?php echo $desc; ?></em><?php } ?>
							</p>

						<?php }

						break;
				}
			}

			echo '</div><!-- end .wpnw-wdgt-accordion-cnt -->';

		} // End of main foreach

		echo '<input type="hidden" name="'.$this->get_field_name('tab').'" value="'.esc_attr( $instance['tab'] ).'" class="wpnw-wdgt-sel-tab" />';
		echo '<input type="hidden" name="'.$this->get_field_name('refresh').'" value="" class="wpnw-wdgt-refresh-inp" />';
		echo '</div><!-- end .wpnw-wdgt-accordion-wrap -->';
	}
}