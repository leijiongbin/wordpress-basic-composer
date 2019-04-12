<?php


/**
 *
 * Admin Page View.
 *
 * @package Custom_Post_Type_Permalinks
 * @since 0.9.4
 * */
class CPTP_Module_Admin extends CPTP_Module {

	public function add_hook() {
		add_action( 'admin_init', array( $this, 'settings_api_init' ), 30 );
	}


	/**
	 *
	 * Setting Init
	 *
	 * @since 0.7
	 */
	public function settings_api_init() {
		add_settings_section( 'cptp_setting_section',
			'',
			array( $this, 'setting_section_callback_function' ),
			'permalink'
		);

		$post_types = CPTP_Util::get_post_types();

		foreach ( $post_types as $post_type ) {
			$obj = get_post_type_object( $post_type );
			add_settings_field(
				$post_type . '_structure',
				__($obj->label, 'custom-post-type-permalinks'),
				array( $this, 'setting_structure_callback_function' ),
				'permalink',
				'cptp_setting_section',
				array( 'label_for' => $post_type . '_structure', 'post_type' => $post_type )
			);
			register_setting( 'permalink', $post_type . '_structure' );
		}




	}

	public function setting_section_callback_function() {
		//
	}

	public function setting_structure_callback_function( $option ) {
		$post_type  = $option['post_type'];
		$name       = $option['label_for'];
		$pt_object  = get_post_type_object( $post_type );
		$slug       = $pt_object->rewrite['slug'];
		$with_front = $pt_object->rewrite['with_front'];

		$value = CPTP_Util::get_permalink_structure( $post_type );

		$disabled = false;
		if ( isset( $pt_object->cptp_permalink_structure ) and $pt_object->cptp_permalink_structure ) {
			$disabled = true;
		}

		if ( ! $value ) {
			$value = CPTP_DEFAULT_PERMALINK;
		}

		global $wp_rewrite;
		$front = substr( $wp_rewrite->front, 1 );
		if ( $front and $with_front ) {
			$slug = $front . $slug;
		}
		?>
		<p>
			<code><?php echo esc_html( home_url() . ( $slug ? '/' : '' ) . $slug ); ?></code>
			<input name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" type="text"
			       class="regular-text code "
			       value="<?php echo esc_attr( $value ); ?>" <?php disabled( $disabled, true, true ); ?> />
		</p>
		<?php
	}


}

