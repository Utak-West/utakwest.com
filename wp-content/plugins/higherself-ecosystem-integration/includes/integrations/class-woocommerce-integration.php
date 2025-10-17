<?php
/**
 * WooCommerce Integration Class
 *
 * Handles all WooCommerce-related integrations including order syncing to CRM,
 * cross-sell recommendations, and product catalog management.
 *
 * @since      1.0.0
 * @package    HigherSelf_Ecosystem
 * @subpackage HigherSelf_Ecosystem/includes/integrations
 */
class HigherSelf_WooCommerce_Integration {

    /**
     * Property mapping configuration
     *
     * @var array
     */
    private $property_config = array(
        'altagracia' => 'Altagracia Montilla',
        'the7space' => 'The 7 Space',
        'utakwest' => 'Utak West'
    );

    /**
     * Sync new WooCommerce order to CRM systems
     *
     * @param int $order_id The order ID
     */
    public function sync_order_to_crm( $order_id ) {
        // Get order object
        $order = wc_get_order( $order_id );
        
        if ( ! $order ) {
            return;
        }

        // Get customer data
        $customer_data = array(
            'email' => $order->get_billing_email(),
            'first_name' => $order->get_billing_first_name(),
            'last_name' => $order->get_billing_last_name(),
            'phone' => $order->get_billing_phone(),
            'property' => $this->get_current_property(),
            'order_id' => $order_id,
            'order_total' => $order->get_total(),
            'order_date' => $order->get_date_created()->format( 'Y-m-d H:i:s' ),
            'products' => $this->get_order_products( $order )
        );

        // Sync to HubSpot
        $this->sync_to_hubspot( $customer_data );

        // Sync to Airtable
        $this->sync_to_airtable( $customer_data );

        // Log the sync
        $this->log_sync( 'woocommerce_order', $order_id, $customer_data );
    }

    /**
     * Trigger cross-sell recommendations after order completion
     *
     * @param int $order_id The order ID
     */
    public function trigger_cross_sell( $order_id ) {
        $order = wc_get_order( $order_id );
        
        if ( ! $order ) {
            return;
        }

        $current_property = $this->get_current_property();
        $recommendations = $this->get_cross_sell_recommendations( $order, $current_property );

        // Send email with recommendations
        $this->send_cross_sell_email( $order, $recommendations );

        // Log the cross-sell trigger
        $this->log_sync( 'cross_sell_trigger', $order_id, array(
            'property' => $current_property,
            'recommendations' => $recommendations
        ) );
    }

    /**
     * Get cross-sell recommendations based on purchased products
     *
     * @param WC_Order $order The order object
     * @param string $current_property The current property identifier
     * @return array Array of recommended products
     */
    private function get_cross_sell_recommendations( $order, $current_property ) {
        $recommendations = array();
        
        // Define cross-sell mapping
        $cross_sell_map = array(
            'altagracia' => array(
                'retreat' => array(
                    'property' => 'the7space',
                    'products' => array( 'meditation-class', 'sound-bath' ),
                    'message' => 'Prepare for your retreat with a meditation class at The 7 Space'
                ),
                'masterclass' => array(
                    'property' => 'utakwest',
                    'products' => array( 'operations-consulting' ),
                    'message' => 'Take your organization to the next level with operations consulting'
                )
            ),
            'the7space' => array(
                'yoga-class' => array(
                    'property' => 'altagracia',
                    'products' => array( 'facilitation-training' ),
                    'message' => 'Enhance your practice with facilitation training from A.M. Consulting'
                ),
                'art-therapy' => array(
                    'property' => 'utakwest',
                    'products' => array( 'community-architecture-framework' ),
                    'message' => 'Learn how to build community-centered organizations'
                )
            ),
            'utakwest' => array(
                'saas-product' => array(
                    'property' => 'altagracia',
                    'products' => array( 'conflict-bravery-masterclass' ),
                    'message' => 'Build better teams with Conflict Bravery training'
                ),
                'consulting' => array(
                    'property' => 'the7space',
                    'products' => array( 'wellness-membership' ),
                    'message' => 'Balance your work with wellness at The 7 Space'
                )
            )
        );

        // Get order items and determine recommendations
        $items = $order->get_items();
        foreach ( $items as $item ) {
            $product = $item->get_product();
            $product_slug = $product->get_slug();

            // Check if there are cross-sell recommendations for this product
            if ( isset( $cross_sell_map[ $current_property ] ) ) {
                foreach ( $cross_sell_map[ $current_property ] as $key => $recommendation ) {
                    if ( strpos( $product_slug, $key ) !== false ) {
                        $recommendations[] = $recommendation;
                    }
                }
            }
        }

        return $recommendations;
    }

    /**
     * Send cross-sell email to customer
     *
     * @param WC_Order $order The order object
     * @param array $recommendations Array of recommendations
     */
    private function send_cross_sell_email( $order, $recommendations ) {
        if ( empty( $recommendations ) ) {
            return;
        }

        $to = $order->get_billing_email();
        $subject = 'You might also be interested in...';
        
        // Build email content
        $message = '<html><body>';
        $message .= '<h2>Thank you for your purchase!</h2>';
        $message .= '<p>Based on your recent order, we thought you might be interested in these offerings from our ecosystem:</p>';
        
        foreach ( $recommendations as $recommendation ) {
            $message .= '<div style="margin: 20px 0; padding: 20px; background: #f5f5f5; border-radius: 8px;">';
            $message .= '<h3>' . esc_html( $recommendation['message'] ) . '</h3>';
            $message .= '<p>From: ' . esc_html( $this->property_config[ $recommendation['property'] ] ) . '</p>';
            $message .= '<p><a href="' . esc_url( $this->get_property_url( $recommendation['property'] ) ) . '" style="background: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Learn More</a></p>';
            $message .= '</div>';
        }
        
        $message .= '</body></html>';

        // Set email headers
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );

        // Send email
        wp_mail( $to, $subject, $message, $headers );
    }

    /**
     * Get order products
     *
     * @param WC_Order $order The order object
     * @return array Array of product data
     */
    private function get_order_products( $order ) {
        $products = array();
        
        foreach ( $order->get_items() as $item ) {
            $product = $item->get_product();
            $products[] = array(
                'name' => $product->get_name(),
                'sku' => $product->get_sku(),
                'price' => $product->get_price(),
                'quantity' => $item->get_quantity()
            );
        }
        
        return $products;
    }

    /**
     * Sync customer data to HubSpot
     *
     * @param array $customer_data Customer data array
     */
    private function sync_to_hubspot( $customer_data ) {
        $hubspot_integration = new HigherSelf_HubSpot_Integration();
        $hubspot_integration->create_or_update_contact( $customer_data );
    }

    /**
     * Sync customer data to Airtable
     *
     * @param array $customer_data Customer data array
     */
    private function sync_to_airtable( $customer_data ) {
        $airtable_integration = new HigherSelf_Airtable_Integration();
        $airtable_integration->create_or_update_record( 'Orders', $customer_data );
    }

    /**
     * Get current property identifier
     *
     * @return string Property identifier
     */
    private function get_current_property() {
        $site_url = get_site_url();
        
        if ( strpos( $site_url, 'altagraciamontilla.com' ) !== false ) {
            return 'altagracia';
        } elseif ( strpos( $site_url, 'the7space.com' ) !== false ) {
            return 'the7space';
        } elseif ( strpos( $site_url, 'utakwest.com' ) !== false ) {
            return 'utakwest';
        }
        
        return 'unknown';
    }

    /**
     * Get property URL
     *
     * @param string $property Property identifier
     * @return string Property URL
     */
    private function get_property_url( $property ) {
        $urls = array(
            'altagracia' => 'https://altagraciamontilla.com',
            'the7space' => 'https://the7space.com',
            'utakwest' => 'https://utakwest.com'
        );
        
        return isset( $urls[ $property ] ) ? $urls[ $property ] : '';
    }

    /**
     * Log sync activity
     *
     * @param string $type Sync type
     * @param int $id Record ID
     * @param array $data Data that was synced
     */
    private function log_sync( $type, $id, $data ) {
        if ( ! get_option( 'higherself_ecosystem_enable_logging' ) ) {
            return;
        }

        $log_entry = array(
            'timestamp' => current_time( 'mysql' ),
            'type' => $type,
            'id' => $id,
            'data' => $data
        );

        $logs = get_option( 'higherself_ecosystem_sync_logs', array() );
        $logs[] = $log_entry;

        // Keep only last 100 log entries
        if ( count( $logs ) > 100 ) {
            $logs = array_slice( $logs, -100 );
        }

        update_option( 'higherself_ecosystem_sync_logs', $logs );
    }
}

