<?php
/**
 * Breadcrumbs Options for Astra theme.
 *
 * @package     Astra
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2019, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       Astra 1.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Breadcrumbs_Configs' ) ) {

	/**
	 * Customizer Sanitizes Initial setup
	 */
	class Astra_Breadcrumbs_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Astra-Breadcrumbs Settings.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.7.0
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$breadcrumb_source_list = apply_filters(
				'astra_breadcrumb_source_list',
				array(
					'default' => __( 'Default', 'astra' ),
				),
				'breadcrumb-list'
			);

			$_configs = array(

				/*
				 * Breadcrumb
				 */
				array(
					'name'     => 'section-breadcrumb',
					'type'     => 'section',
					'title'    => __( 'Breadcrumb', 'astra' ),
					'panel'    => 'panel-layout',
					'priority' => 20,
				),

				/**
				 * Option: Breadcrumb Source
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[select-breadcrumb-source]',
					'default'         => 'default',
					'section'         => 'section-breadcrumb',
					'required'        => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'           => __( 'Breadcrumb Source', 'astra' ),
					'type'            => 'control',
					'control'         => 'select',
					'priority'        => 5,
					'choices'         => $breadcrumb_source_list,
					'active_callback' => array( $this, 'is_third_party_breadcrumb_active' ),
				),

				/**
				 * Option: Breadcrumb Position
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-position]',
					'default'  => 'none',
					'section'  => 'section-breadcrumb',
					'title'    => __( 'Breadcrumb Position', 'astra' ),
					'type'     => 'control',
					'control'  => 'select',
					'priority' => 10,
					'choices'  => array(
						'none'                   => __( 'None', 'astra' ),
						'astra_masthead_content' => __( 'Inside Header', 'astra' ),
						'astra_header_after'     => __( 'After Header', 'astra' ),
						'astra_entry_top'        => __( 'Before Title', 'astra' ),
					),
				),

				/**
				 * Option: Breadcrumb Separator
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-separator]',
					'type'     => 'control',
					'control'  => 'text',
					'section'  => 'section-breadcrumb',
					'default'  => astra_get_option( 'breadcrumb-separator' ) ? astra_get_option( 'breadcrumb-separator' ) : '»',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[select-breadcrumb-source]', '==', 'default' ),
							array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
						),
					),
					'priority' => 15,
					'title'    => __( 'Breadcrumb Separator', 'astra' ),
				),

				/**
				 * Option: Disable Breadcrumb on Categories
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-disable-categories]',
					'default'  => astra_get_option( 'breadcrumb-disable-categories' ),
					'type'     => 'control',
					'section'  => 'section-breadcrumb',
					'required' => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'    => __( 'Disable on Categories?', 'astra' ),
					'priority' => 25,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Disable Breadcrumb on Search
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-disable-search]',
					'default'  => astra_get_option( 'breadcrumb-disable-search' ),
					'type'     => 'control',
					'section'  => 'section-breadcrumb',
					'required' => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'    => __( 'Disable on Search?', 'astra' ),
					'priority' => 30,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Disable Breadcrumb on Archive
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-disable-archive]',
					'default'  => astra_get_option( 'breadcrumb-disable-archive' ),
					'type'     => 'control',
					'section'  => 'section-breadcrumb',
					'required' => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'    => __( 'Disable on Archive?', 'astra' ),
					'priority' => 35,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Disable Breadcrumb on Single Page
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-disable-single-page]',
					'default'  => astra_get_option( 'breadcrumb-disable-single-page' ),
					'type'     => 'control',
					'section'  => 'section-breadcrumb',
					'required' => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'    => __( 'Disable on Single Page?', 'astra' ),
					'priority' => 40,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Disable Breadcrumb on Single Post
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-disable-single-post]',
					'default'  => astra_get_option( 'breadcrumb-disable-single-post' ),
					'type'     => 'control',
					'section'  => 'section-breadcrumb',
					'required' => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'    => __( 'Disable on Single Post?', 'astra' ),
					'priority' => 45,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Disable Breadcrumb on Singular
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-disable-singular]',
					'default'  => astra_get_option( 'breadcrumb-disable-singular' ),
					'type'     => 'control',
					'section'  => 'section-breadcrumb',
					'required' => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'    => __( 'Disable on Singular?', 'astra' ),
					'priority' => 50,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Disable Breadcrumb on 404 Page
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-disable-404-page]',
					'default'  => astra_get_option( 'breadcrumb-disable-404-page' ),
					'type'     => 'control',
					'section'  => 'section-breadcrumb',
					'required' => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'    => __( 'Disable on 404 Page?', 'astra' ),
					'priority' => 55,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Breadcrumb Alignment
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[breadcrumb-alignment]',
					'default'  => 'left',
					'section'  => 'section-breadcrumb',
					'required' => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'title'    => __( 'Breadcrumb Alignment', 'astra' ),
					'type'     => 'control',
					'control'  => 'select',
					'priority' => 60,
					'choices'  => array(
						'left'   => __( 'Left', 'astra' ),
						'center' => __( 'Center', 'astra' ),
						'right'  => __( 'Right', 'astra' ),
					),
				),

				/**
				 * Option: Breadcrumb Spacing
				 */
				array(
					'name'           => ASTRA_THEME_SETTINGS . '[breadcrumb-spacing]',
					'default'        => astra_get_option( 'breadcrumb-spacing' ),
					'type'           => 'control',
					'transport'      => 'postMessage',
					'control'        => 'ast-responsive-spacing',
					'priority'       => 65,
					'title'          => __( 'Breadcrumb Spacing', 'astra' ),
					'linked_choices' => true,
					'unit_choices'   => array( 'px', 'em', '%' ),
					'choices'        => array(
						'top'    => __( 'Top', 'astra' ),
						'right'  => __( 'Right', 'astra' ),
						'bottom' => __( 'Bottom', 'astra' ),
						'left'   => __( 'Left', 'astra' ),
					),
					'required'       => array( ASTRA_THEME_SETTINGS . '[breadcrumb-position]', '!=', 'none' ),
					'section'        => 'section-breadcrumb',
				),

			);

			return array_merge( $configurations, $_configs );

		}

		/**
		 * Decide if Notice for Header Built using Custom Layout should be displayed.
		 * This runs teh target rules to check if the page neing previewed has a header built using Custom Layout.
		 *
		 * @return boolean  True - If the notice should be displayed, False - If the notice should be hidden.
		 */
		public function is_third_party_breadcrumb_active() {

			// Check if breadcrumb is turned on from WPSEO option.
			$wpseo_option = get_option( 'wpseo_internallinks' );

			if ( function_exists( 'yoast_breadcrumb' ) && $wpseo_option && true === $wpseo_option['breadcrumbs-enable'] ) {
				return true;
			} elseif ( function_exists( 'bcn_display' ) ) {
				// Check if breadcrumb is turned on from Breadcrumb NavXT plugin.
				return true;
			} elseif ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
				return true;
			} else {
				return false;
			}
		}
	}
}

new Astra_Breadcrumbs_Configs();
