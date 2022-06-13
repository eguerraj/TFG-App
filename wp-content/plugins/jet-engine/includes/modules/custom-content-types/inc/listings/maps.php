<?php
namespace Jet_Engine\Modules\Custom_Content_Types\Listings;

use Jet_Engine\Modules\Custom_Content_Types\Module;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Maps {

	public $coord_key = null;
	public $source    = null;

	public function __construct( $source ) {

		if ( ! jet_engine()->modules->get_module( 'maps-listings' )->instance ) {
			return;
		}

		$this->coord_key = jet_engine()->modules->get_module( 'maps-listings' )->instance->lat_lng->meta_key;
		$this->source    = $source;

		add_action(
			'jet-engine/maps-listing/sources/register',
			array( $this, 'register_cct_source' )
		);

		add_filter(
			'jet-engine/maps-listing/source',
			array( $this, 'set_cct_source' ),
			10, 2
		);

		add_filter(
			'jet-engine/maps-listing/settings/fields',
			array( $this, 'add_cct_fields' )
		);

		add_filter(
			'jet-engine/custom-content-types/db/exclude-fields',
			array( $this, 'exclude_coord_field' )
		);

		add_filter(
			'jet-engine/maps-listing/get-marker-types',
			array( $this, 'add_cct_marker_image_type' )
		);

		add_filter(
			'jet-engine/maps-listing/get-marker-label-types',
			array( $this, 'add_cct_marker_label_type' )
		);

		add_action(
			'jet-engine/maps-listing/widget/custom-marker-label-controls',
			array( $this, 'add_marker_cct_field_control' )
		);

		add_filter(
			'jet-engine/maps-listing/custom-marker/dynamic_image_cct',
			array( $this, 'get_marker_from_cct_field' ),
			10, 3
		);

		add_filter(
			'jet-engine/maps-listing/marker-label/cct_field',
			array( $this, 'get_marker_from_cct_field' ),
			10, 3
		);

		add_filter(
			'jet-engine/blocks-views/maps-listing/attributes',
			array( $this, 'add_marker_cct_field_attr' )
		);

	}

	public function register_cct_source( $sources_manager ) {
		require_once Module::instance()->module_path( 'listings/maps-source.php' );

		$sources_manager->register_source( new CCT_Maps_Source() );
	}

	public function set_cct_source( $source, $obj ) {

		if ( ! isset( $obj->cct_slug ) ) {
			return $source;
		}

		return $this->source;
	}

	public function add_cct_fields( $fields ) {

		$cct_groups = array();

		foreach ( Module::instance()->manager->get_content_types() as $type => $instance ) {

			$cct_fields = $instance->get_fields_list( 'text' );
			$prefixed_fields = array();

			if ( empty( $cct_fields ) ) {
				continue;
			}

			foreach ( $cct_fields as $key => $label ) {

				if ( 'cct_status' === $key ) {
					continue;
				}

				$prefixed_fields[] = array(
					'value' => 'cct::' . $type . '__' . $key,
					'label' => $label,
				);
			}

			$cct_groups[] = array(
				'label'  => __( 'Content Type:', 'jet-engine' ) . ' ' . $instance->get_arg( 'name' ),
				'values' => $prefixed_fields,
			);
		}

		$cct_groups = wp_list_pluck( $cct_groups, 'values', 'label' );

		return array_merge( $fields, $cct_groups );
	}

	public function exclude_coord_field( $exclude ) {

		if ( $this->coord_key ) {
			$exclude[] = $this->coord_key;
		}

		return $exclude;
	}

	public function add_cct_marker_image_type( $types ) {
		$types['dynamic_image_cct'] = __( 'Custom Content Type Dynamic Image', 'jet-engine' );
		return $types;
	}

	public function add_cct_marker_label_type( $types ) {
		$types['cct_field'] = __( 'Custom Content Type Field', 'jet-engine' );
		return $types;
	}

	public function add_marker_cct_field_control( $widget ) {

		$groups = array();

		foreach ( Module::instance()->manager->get_content_types() as $type => $instance ) {

			$fields = $instance->get_fields_list();
			$prefixed_fields = array();

			foreach ( $fields as $key => $label ) {
				$prefixed_fields[ $type . '__' . $key ] = $label;
			}

			$groups[] = array(
				'label'   => __( 'Content Type:', 'jet-engine' ) . ' ' . $instance->get_arg( 'name' ),
				'options' => $prefixed_fields,
			);

		}

		$widget->add_control(
			'marker_cct_field',
			array(
				'label'      => __( 'Field', 'jet-engine' ),
				'type'       => \Elementor\Controls_Manager::SELECT,
				'groups'     => $groups,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'relation' => 'and',
							'terms'    => array(
								array(
									'name'  => 'marker_type',
									'value' => 'text',
								),
								array(
									'name'  => 'marker_label_type',
									'value' => 'cct_field',
								),
							),
						),
						array(
							'name'  => 'marker_type',
							'value' => 'dynamic_image_cct',
						),
					),
				),
			)
		);

	}

	public function get_marker_from_cct_field( $result, $obj, $settings ) {

		if ( ! isset( $obj->cct_slug ) ) {
			return $result;
		}

		if ( empty( $settings['marker_cct_field'] ) ) {
			return $result;
		}

		$field = $settings['marker_cct_field'];

		return jet_engine()->listings->data->get_prop( $field, $obj );
	}

	public function add_marker_cct_field_attr( $attrs = array() ) {

		$attrs['marker_cct_field'] = array(
			'type'    => 'string',
			'default' => '',
		);

		return $attrs;
	}

}
