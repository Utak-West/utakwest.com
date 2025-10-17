# Cross-Site Integration Code & API Connections

## Author
Manus AI

## Date
October 16, 2025

## 1. Overview

This document provides comprehensive code examples and API connection specifications for integrating WooCommerce, Amelia Booking, HubSpot CRM, and Airtable across the HigherSelf Network ecosystem.

## 2. WordPress Plugin Structure

The HigherSelf Ecosystem Integration plugin provides a centralized solution for managing all cross-site integrations.

### 2.1. Plugin Directory Structure

```
wp-content/plugins/higherself-ecosystem-integration/
├── higherself-ecosystem-integration.php (main plugin file)
├── includes/
│   ├── class-higherself-ecosystem.php (core plugin class)
│   ├── class-higherself-ecosystem-loader.php (hooks loader)
│   ├── class-higherself-ecosystem-activator.php (activation hooks)
│   ├── class-higherself-ecosystem-deactivator.php (deactivation hooks)
│   └── integrations/
│       ├── class-woocommerce-integration.php
│       ├── class-amelia-integration.php
│       ├── class-hubspot-integration.php
│       └── class-airtable-integration.php
├── admin/
│   ├── class-higherself-ecosystem-admin.php
│   ├── css/
│   └── js/
├── public/
│   ├── class-higherself-ecosystem-public.php
│   ├── css/
│   └── js/
└── README.md
```

### 2.2. Installation Instructions

1. Copy the `higherself-ecosystem-integration` folder to `wp-content/plugins/`
2. Navigate to **Plugins** in WordPress admin
3. Activate the **HigherSelf Ecosystem Integration** plugin
4. Navigate to **Settings > HigherSelf Ecosystem** to configure API keys

## 3. HubSpot CRM Integration

### 3.1. HubSpot API Configuration

**File**: `includes/integrations/class-hubspot-integration.php`

```php
<?php
class HigherSelf_HubSpot_Integration {
    
    private $api_key;
    private $api_url = 'https://api.hubapi.com';
    
    public function __construct() {
        $this->api_key = get_option( 'higherself_hubspot_api_key' );
    }
    
    /**
     * Create or update contact in HubSpot
     *
     * @param array $contact_data Contact data
     * @return array|WP_Error Response or error
     */
    public function create_or_update_contact( $contact_data ) {
        $endpoint = $this->api_url . '/crm/v3/objects/contacts';
        
        // Prepare contact properties
        $properties = array(
            'email' => $contact_data['email'],
            'firstname' => $contact_data['first_name'],
            'lastname' => $contact_data['last_name'],
            'phone' => $contact_data['phone'],
            'property_source' => $contact_data['property'], // Custom property
            'last_order_id' => $contact_data['order_id'], // Custom property
            'last_order_total' => $contact_data['order_total'], // Custom property
            'last_order_date' => $contact_data['order_date'] // Custom property
        );
        
        // Check if contact exists
        $existing_contact = $this->get_contact_by_email( $contact_data['email'] );
        
        if ( $existing_contact ) {
            // Update existing contact
            $contact_id = $existing_contact['id'];
            $endpoint = $this->api_url . '/crm/v3/objects/contacts/' . $contact_id;
            $method = 'PATCH';
        } else {
            // Create new contact
            $method = 'POST';
        }
        
        $response = $this->make_api_request( $endpoint, $method, array(
            'properties' => $properties
        ) );
        
        return $response;
    }
    
    /**
     * Get contact by email
     *
     * @param string $email Contact email
     * @return array|null Contact data or null if not found
     */
    public function get_contact_by_email( $email ) {
        $endpoint = $this->api_url . '/crm/v3/objects/contacts/search';
        
        $response = $this->make_api_request( $endpoint, 'POST', array(
            'filterGroups' => array(
                array(
                    'filters' => array(
                        array(
                            'propertyName' => 'email',
                            'operator' => 'EQ',
                            'value' => $email
                        )
                    )
                )
            )
        ) );
        
        if ( is_wp_error( $response ) || empty( $response['results'] ) ) {
            return null;
        }
        
        return $response['results'][0];
    }
    
    /**
     * Make API request to HubSpot
     *
     * @param string $endpoint API endpoint
     * @param string $method HTTP method
     * @param array $data Request data
     * @return array|WP_Error Response or error
     */
    private function make_api_request( $endpoint, $method, $data = array() ) {
        $args = array(
            'method' => $method,
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode( $data ),
            'timeout' => 30
        );
        
        $response = wp_remote_request( $endpoint, $args );
        
        if ( is_wp_error( $response ) ) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        
        return $data;
    }
}
```

### 3.2. HubSpot Custom Properties

Create the following custom properties in HubSpot:

| Property Name | Property Type | Field Type | Description |
|---------------|---------------|------------|-------------|
| property_source | Single-line text | Text | Source property (altagracia, the7space, utakwest) |
| last_order_id | Single-line text | Text | Last WooCommerce order ID |
| last_order_total | Number | Currency | Last order total amount |
| last_order_date | Date picker | Date | Last order date |
| last_booking_id | Single-line text | Text | Last Amelia booking ID |
| last_booking_date | Date picker | Date | Last booking date |
| last_booking_service | Single-line text | Text | Last booked service name |

## 4. Airtable Integration

### 4.1. Airtable API Configuration

**File**: `includes/integrations/class-airtable-integration.php`

```php
<?php
class HigherSelf_Airtable_Integration {
    
    private $api_key;
    private $base_id;
    private $api_url = 'https://api.airtable.com/v0';
    
    public function __construct() {
        $this->api_key = get_option( 'higherself_airtable_api_key' );
        $this->base_id = get_option( 'higherself_airtable_base_id' );
    }
    
    /**
     * Create or update record in Airtable
     *
     * @param string $table_name Table name
     * @param array $record_data Record data
     * @return array|WP_Error Response or error
     */
    public function create_or_update_record( $table_name, $record_data ) {
        $endpoint = $this->api_url . '/' . $this->base_id . '/' . urlencode( $table_name );
        
        // Check if record exists (search by email)
        $existing_record = $this->get_record_by_email( $table_name, $record_data['email'] );
        
        if ( $existing_record ) {
            // Update existing record
            $record_id = $existing_record['id'];
            $endpoint .= '/' . $record_id;
            $method = 'PATCH';
        } else {
            // Create new record
            $method = 'POST';
        }
        
        $response = $this->make_api_request( $endpoint, $method, array(
            'fields' => $record_data
        ) );
        
        return $response;
    }
    
    /**
     * Get record by email
     *
     * @param string $table_name Table name
     * @param string $email Email address
     * @return array|null Record data or null if not found
     */
    public function get_record_by_email( $table_name, $email ) {
        $endpoint = $this->api_url . '/' . $this->base_id . '/' . urlencode( $table_name );
        $endpoint .= '?filterByFormula=' . urlencode( '{Email}="' . $email . '"' );
        
        $response = $this->make_api_request( $endpoint, 'GET' );
        
        if ( is_wp_error( $response ) || empty( $response['records'] ) ) {
            return null;
        }
        
        return $response['records'][0];
    }
    
    /**
     * Make API request to Airtable
     *
     * @param string $endpoint API endpoint
     * @param string $method HTTP method
     * @param array $data Request data
     * @return array|WP_Error Response or error
     */
    private function make_api_request( $endpoint, $method, $data = array() ) {
        $args = array(
            'method' => $method,
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json'
            ),
            'timeout' => 30
        );
        
        if ( $method !== 'GET' && ! empty( $data ) ) {
            $args['body'] = json_encode( $data );
        }
        
        $response = wp_remote_request( $endpoint, $args );
        
        if ( is_wp_error( $response ) ) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        
        return $data;
    }
}
```

### 4.2. Airtable Base Structure

**Base Name**: HigherSelf Network Ecosystem

**Tables**:

1. **Customers**
   - Email (Email)
   - First Name (Single line text)
   - Last Name (Single line text)
   - Phone (Phone number)
   - Property Source (Single select: Altagracia, The 7 Space, Utak West)
   - Created Date (Created time)
   - Last Modified (Last modified time)

2. **Orders**
   - Order ID (Single line text)
   - Customer (Link to Customers table)
   - Property (Single select: Altagracia, The 7 Space, Utak West)
   - Order Total (Currency)
   - Order Date (Date)
   - Products (Long text)
   - Status (Single select: Pending, Processing, Completed, Cancelled)

3. **Bookings**
   - Booking ID (Single line text)
   - Customer (Link to Customers table)
   - Property (Single select: Altagracia, The 7 Space, Utak West)
   - Service Name (Single line text)
   - Booking Date (Date)
   - Booking Time (Single line text)
   - Status (Single select: Pending, Confirmed, Completed, Cancelled)

## 5. Amelia Booking Integration

### 5.1. Amelia Webhook Configuration

**File**: `includes/integrations/class-amelia-integration.php`

```php
<?php
class HigherSelf_Amelia_Integration {
    
    /**
     * Sync booking to CRM systems
     *
     * @param array $booking Booking data from Amelia
     */
    public function sync_booking_to_crm( $booking ) {
        // Extract booking data
        $customer_data = array(
            'email' => $booking['customer']['email'],
            'first_name' => $booking['customer']['firstName'],
            'last_name' => $booking['customer']['lastName'],
            'phone' => $booking['customer']['phone'],
            'property' => $this->get_current_property(),
            'booking_id' => $booking['id'],
            'service_name' => $booking['service']['name'],
            'booking_date' => $booking['bookingStart'],
            'booking_time' => date( 'H:i', strtotime( $booking['bookingStart'] ) )
        );
        
        // Sync to HubSpot
        $hubspot = new HigherSelf_HubSpot_Integration();
        $hubspot->create_or_update_contact( $customer_data );
        
        // Sync to Airtable
        $airtable = new HigherSelf_Airtable_Integration();
        $airtable->create_or_update_record( 'Bookings', $customer_data );
    }
    
    /**
     * Trigger booking workflow (send confirmation, add to calendar, etc.)
     *
     * @param array $booking Booking data from Amelia
     */
    public function trigger_booking_workflow( $booking ) {
        // Send confirmation email
        $this->send_booking_confirmation( $booking );
        
        // Add to Google Calendar
        $this->add_to_google_calendar( $booking );
        
        // Schedule reminder email (24 hours before)
        $this->schedule_reminder_email( $booking );
    }
    
    /**
     * Send booking confirmation email
     *
     * @param array $booking Booking data
     */
    private function send_booking_confirmation( $booking ) {
        $to = $booking['customer']['email'];
        $subject = 'Booking Confirmation - ' . $booking['service']['name'];
        
        $message = '<html><body>';
        $message .= '<h2>Your booking is confirmed!</h2>';
        $message .= '<p>Thank you for booking with us. Here are your booking details:</p>';
        $message .= '<ul>';
        $message .= '<li><strong>Service:</strong> ' . esc_html( $booking['service']['name'] ) . '</li>';
        $message .= '<li><strong>Date:</strong> ' . esc_html( date( 'F j, Y', strtotime( $booking['bookingStart'] ) ) ) . '</li>';
        $message .= '<li><strong>Time:</strong> ' . esc_html( date( 'g:i A', strtotime( $booking['bookingStart'] ) ) ) . '</li>';
        $message .= '</ul>';
        $message .= '<p>We look forward to seeing you!</p>';
        $message .= '</body></html>';
        
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        
        wp_mail( $to, $subject, $message, $headers );
    }
    
    /**
     * Add booking to Google Calendar
     *
     * @param array $booking Booking data
     */
    private function add_to_google_calendar( $booking ) {
        // This would typically use the Google Calendar API
        // For now, we'll just log the action
        error_log( 'Adding booking ' . $booking['id'] . ' to Google Calendar' );
    }
    
    /**
     * Schedule reminder email
     *
     * @param array $booking Booking data
     */
    private function schedule_reminder_email( $booking ) {
        $booking_time = strtotime( $booking['bookingStart'] );
        $reminder_time = $booking_time - ( 24 * 60 * 60 ); // 24 hours before
        
        wp_schedule_single_event( $reminder_time, 'higherself_send_booking_reminder', array( $booking['id'] ) );
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
}
```

## 6. Zapier/n8n Workflow Examples

### 6.1. WooCommerce Order → Airtable Workflow (Zapier)

**Trigger**: New Order in WooCommerce (via webhook)

**Actions**:
1. **Get Customer from Airtable** (search by email)
2. **Create or Update Customer in Airtable**
3. **Create Order Record in Airtable**
4. **Send Slack Notification** (optional)

**Zapier Configuration**:
```json
{
  "trigger": {
    "type": "webhook",
    "url": "https://hooks.zapier.com/hooks/catch/[YOUR_WEBHOOK_ID]/",
    "method": "POST"
  },
  "actions": [
    {
      "app": "Airtable",
      "action": "Find Record",
      "table": "Customers",
      "field": "Email",
      "value": "{{trigger.billing.email}}"
    },
    {
      "app": "Airtable",
      "action": "Create or Update Record",
      "table": "Customers",
      "fields": {
        "Email": "{{trigger.billing.email}}",
        "First Name": "{{trigger.billing.first_name}}",
        "Last Name": "{{trigger.billing.last_name}}",
        "Phone": "{{trigger.billing.phone}}",
        "Property Source": "{{trigger.meta_data.property}}"
      }
    },
    {
      "app": "Airtable",
      "action": "Create Record",
      "table": "Orders",
      "fields": {
        "Order ID": "{{trigger.id}}",
        "Customer": "{{step2.id}}",
        "Property": "{{trigger.meta_data.property}}",
        "Order Total": "{{trigger.total}}",
        "Order Date": "{{trigger.date_created}}",
        "Status": "{{trigger.status}}"
      }
    }
  ]
}
```

### 6.2. Amelia Booking → HubSpot Workflow (n8n)

**n8n Workflow JSON**:
```json
{
  "nodes": [
    {
      "parameters": {
        "httpMethod": "POST",
        "path": "amelia-booking",
        "responseMode": "responseNode",
        "options": {}
      },
      "name": "Webhook",
      "type": "n8n-nodes-base.webhook",
      "typeVersion": 1,
      "position": [250, 300]
    },
    {
      "parameters": {
        "operation": "upsert",
        "email": "={{$json[\"customer\"][\"email\"]}}",
        "additionalFields": {
          "firstname": "={{$json[\"customer\"][\"firstName\"]}}",
          "lastname": "={{$json[\"customer\"][\"lastName\"]}}",
          "phone": "={{$json[\"customer\"][\"phone\"]}}",
          "property_source": "={{$json[\"property\"]}}",
          "last_booking_id": "={{$json[\"id\"]}}",
          "last_booking_date": "={{$json[\"bookingStart\"]}}",
          "last_booking_service": "={{$json[\"service\"][\"name\"]}}"
        }
      },
      "name": "HubSpot",
      "type": "n8n-nodes-base.hubspot",
      "typeVersion": 1,
      "position": [450, 300],
      "credentials": {
        "hubspotApi": {
          "id": "1",
          "name": "HubSpot account"
        }
      }
    },
    {
      "parameters": {
        "respondWith": "json",
        "responseBody": "={{JSON.stringify({\"success\": true, \"message\": \"Booking synced to HubSpot\"})}}"
      },
      "name": "Respond to Webhook",
      "type": "n8n-nodes-base.respondToWebhook",
      "typeVersion": 1,
      "position": [650, 300]
    }
  ],
  "connections": {
    "Webhook": {
      "main": [[{"node": "HubSpot", "type": "main", "index": 0}]]
    },
    "HubSpot": {
      "main": [[{"node": "Respond to Webhook", "type": "main", "index": 0}]]
    }
  }
}
```

## 7. Testing & Deployment

### 7.1. Testing Checklist

- [ ] Test WooCommerce order creation and CRM sync
- [ ] Test Amelia booking creation and CRM sync
- [ ] Test cross-sell email sending
- [ ] Test HubSpot API connection
- [ ] Test Airtable API connection
- [ ] Test Zapier/n8n workflows
- [ ] Test error handling and logging

### 7.2. Deployment Steps

1. **Install Plugin on All Sites**
   - Altagracia Montilla website
   - The 7 Space website
   - Utak West website

2. **Configure API Keys**
   - HubSpot API key
   - Airtable API key and Base ID
   - Any other required credentials

3. **Set Up Webhooks**
   - WooCommerce webhooks for order events
   - Amelia webhooks for booking events
   - Zapier/n8n webhook URLs

4. **Test Integrations**
   - Create test orders and bookings
   - Verify data syncs to all systems
   - Check email notifications

5. **Monitor & Optimize**
   - Review sync logs regularly
   - Monitor error rates
   - Optimize based on performance data

## 8. References

*   [1] HubSpot API Documentation (https://developers.hubspot.com/docs/api/overview)
*   [2] Airtable API Documentation (https://airtable.com/developers/web/api/introduction)
*   [3] WooCommerce REST API Documentation (https://woocommerce.github.io/woocommerce-rest-api-docs/)
*   [4] Amelia Hooks Documentation (https://wpamelia.com/hooks/)

