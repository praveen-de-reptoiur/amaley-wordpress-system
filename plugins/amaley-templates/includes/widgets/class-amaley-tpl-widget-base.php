<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

abstract class Amaley_Tpl_Widget_Base extends \Elementor\Widget_Base {

    public function get_style_depends() {
        return array( 'amaley-templates-frontend' );
    }

    public function get_script_depends() {
        return array( 'amaley-templates-frontend' );
    }

    protected function tpl_setting( $path, $default = '' ) {
        if ( function_exists( 'amaley_tpl_setting' ) ) {
            return amaley_tpl_setting( $path, $default );
        }
        return $default;
    }

    protected function current_product() {
        if ( ! function_exists( 'wc_get_product' ) ) {
            return false;
        }

        global $product;

        if ( $product instanceof \WC_Product ) {
            return $product;
        }

        $post_id = get_the_ID();
        if ( $post_id ) {
            $maybe_product = wc_get_product( $post_id );
            if ( $maybe_product instanceof \WC_Product ) {
                return $maybe_product;
            }
        }

        return false;
    }

    protected function acf_value( $field_name, $post_id = 0 ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }

        if ( ! $field_name || ! $post_id ) {
            return '';
        }

        if ( function_exists( 'get_field' ) ) {
            return get_field( $field_name, $post_id );
        }

        return get_post_meta( $post_id, $field_name, true );
    }

    protected function text_value( $value ) {
        if ( is_array( $value ) ) {
            return '';
        }
        if ( is_object( $value ) ) {
            return '';
        }
        return trim( (string) $value );
    }

    protected function post_object_link( $value ) {
        if ( empty( $value ) ) {
            return '';
        }

        $post_id = 0;
        if ( is_object( $value ) && isset( $value->ID ) ) {
            $post_id = (int) $value->ID;
        } elseif ( is_numeric( $value ) ) {
            $post_id = (int) $value;
        } elseif ( is_array( $value ) && isset( $value['ID'] ) ) {
            $post_id = (int) $value['ID'];
        }

        if ( ! $post_id ) {
            return '';
        }

        $title = get_the_title( $post_id );
        $link  = get_permalink( $post_id );

        if ( ! $title ) {
            return '';
        }

        if ( $link ) {
            return '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>';
        }

        return esc_html( $title );
    }

    protected function post_object_text( $value ) {
        if ( empty( $value ) ) {
            return '';
        }

        if ( is_object( $value ) && isset( $value->ID ) ) {
            return get_the_title( (int) $value->ID );
        }

        if ( is_numeric( $value ) ) {
            return get_the_title( (int) $value );
        }

        if ( is_array( $value ) && isset( $value['ID'] ) ) {
            return get_the_title( (int) $value['ID'] );
        }

        return '';
    }



    protected function post_object_post_id( $value ) {
        if ( empty( $value ) ) {
            return 0;
        }

        if ( is_object( $value ) && isset( $value->ID ) ) {
            return (int) $value->ID;
        }

        if ( is_numeric( $value ) ) {
            return (int) $value;
        }

        if ( is_array( $value ) && isset( $value['ID'] ) ) {
            return (int) $value['ID'];
        }

        return 0;
    }

    protected function origin_item_icon_html( $value, $label = '' ) {
        $post_id = $this->post_object_post_id( $value );

        if ( $post_id && has_post_thumbnail( $post_id ) ) {
            $thumb = get_the_post_thumbnail(
                $post_id,
                'thumbnail',
                array(
                    'class'   => 'amaley-tpl-origin-panel__icon-img',
                    'loading' => 'lazy',
                    'alt'     => esc_attr( get_the_title( $post_id ) ),
                )
            );

            if ( $thumb ) {
                return '<span class="amaley-tpl-origin-panel__icon amaley-tpl-origin-panel__icon--image" aria-hidden="true">' . $thumb . '</span>';
            }
        }

        $fallbacks = array(
            'Cluster'          => 'CL',
            'SHG Group'        => 'SG',
            'Producer / Maker' => 'PM',
            'Village / Source' => 'VL',
            'Region / Belt'    => 'RG',
            'Batch Type'       => 'BT',
            'Season'           => 'SN',
        );

        $text = isset( $fallbacks[ $label ] ) ? $fallbacks[ $label ] : strtoupper( substr( wp_strip_all_tags( (string) $label ), 0, 2 ) );

        return '<span class="amaley-tpl-origin-panel__icon amaley-tpl-origin-panel__icon--fallback" aria-hidden="true">' . esc_html( $text ) . '</span>';
    }

    protected function render_origin_item( $label, $value, $raw_value = null ) {
        if ( ! $value ) {
            return;
        }

        if ( null === $raw_value ) {
            $raw_value = $value;
        }
        ?>
        <div class="amaley-tpl-origin-panel__item">
            <?php echo wp_kses_post( $this->origin_item_icon_html( $raw_value, $label ) ); ?>
            <div class="amaley-tpl-origin-panel__item-content">
                <span class="amaley-tpl-origin-panel__label"><?php echo esc_html( $label ); ?></span>
                <strong><?php echo wp_kses_post( $value ); ?></strong>
            </div>
        </div>
        <?php
    }

    protected function fallback_product_message() {
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            echo '<div class="amaley-tpl-editor-note">Amaley product widget preview: open this inside an Elementor Single Product template or preview with a WooCommerce product.</div>';
        }
    }

    protected function add_field_name_controls( $fields = array() ) {
        foreach ( $fields as $control_id => $data ) {
            $this->add_control(
                $control_id,
                array(
                    'label'       => isset( $data['label'] ) ? $data['label'] : $control_id,
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'default'     => isset( $data['default'] ) ? $data['default'] : '',
                    'label_block' => true,
                )
            );
        }
    }
}
