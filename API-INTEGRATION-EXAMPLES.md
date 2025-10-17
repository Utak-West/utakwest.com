# API Integration Examples & Webhook Configurations

## Author
Manus AI

## Date
October 16, 2025

## 1. Overview

This document provides practical examples and configurations for setting up API integrations and webhooks across the HigherSelf Network ecosystem. These examples can be used with automation platforms like Zapier, n8n, Make.com, or custom implementations.

## 2. WooCommerce Webhooks

### 2.1. Setting Up WooCommerce Webhooks

**Location**: WooCommerce > Settings > Advanced > Webhooks

**Webhook 1: Order Created**
*   **Name**: Order Created - Sync to CRM
*   **Status**: Active
*   **Topic**: Order created
*   **Delivery URL**: `https://hooks.zapier.com/hooks/catch/[YOUR_WEBHOOK_ID]/`
*   **Secret**: [Generate a secure secret]
*   **API Version**: WP REST API Integration v3

**Webhook 2: Order Completed**
*   **Name**: Order Completed - Trigger Cross-Sell
*   **Status**: Active
*   **Topic**: Order updated
*   **Delivery URL**: `https://hooks.zapier.com/hooks/catch/[YOUR_WEBHOOK_ID]/`
*   **Secret**: [Generate a secure secret]
*   **API Version**: WP REST API Integration v3

### 2.2. WooCommerce Webhook Payload Example

```json
{
  "id": 12345,
  "parent_id": 0,
  "status": "completed",
  "currency": "USD",
  "version": "8.2.0",
  "prices_include_tax": false,
  "date_created": "2025-10-16T10:30:00",
  "date_modified": "2025-10-16T10:35:00",
  "discount_total": "0.00",
  "discount_tax": "0.00",
  "shipping_total": "0.00",
  "shipping_tax": "0.00",
  "cart_tax": "0.00",
  "total": "250.00",
  "total_tax": "0.00",
  "customer_id": 1,
  "order_key": "wc_order_abc123",
  "billing": {
    "first_name": "John",
    "last_name": "Doe",
    "company": "",
    "address_1": "123 Main St",
    "address_2": "",
    "city": "Newark",
    "state": "NJ",
    "postcode": "07102",
    "country": "US",
    "email": "john.doe@example.com",
    "phone": "(555) 123-4567"
  },
  "shipping": {
    "first_name": "John",
    "last_name": "Doe",
    "company": "",
    "address_1": "123 Main St",
    "address_2": "",
    "city": "Newark",
    "state": "NJ",
    "postcode": "07102",
    "country": "US"
  },
  "payment_method": "stripe",
  "payment_method_title": "Credit Card (Stripe)",
  "transaction_id": "ch_abc123",
  "line_items": [
    {
      "id": 1,
      "name": "Operations Consulting - 60 min",
      "product_id": 100,
      "variation_id": 0,
      "quantity": 1,
      "tax_class": "",
      "subtotal": "250.00",
      "subtotal_tax": "0.00",
      "total": "250.00",
      "total_tax": "0.00",
      "sku": "ops-consult-60",
      "price": 250
    }
  ],
  "meta_data": [
    {
      "id": 1,
      "key": "property_source",
      "value": "utakwest"
    }
  ]
}
```

## 3. Amelia Booking Webhooks

### 3.1. Setting Up Amelia Webhooks

Amelia doesn't have built-in webhook support, so we'll use WordPress hooks to trigger webhooks.

**File**: `wp-content/themes/[your-theme]/functions.php`

```php
<?php
/**
 * Trigger webhook when new Amelia booking is created
 */
add_action('AmeliaBookingAdded', 'trigger_amelia_webhook', 10, 1);

function trigger_amelia_webhook($booking) {
    // Webhook URL (e.g., Zapier, n8n, Make.com)
    $webhook_url = 'https://hooks.zapier.com/hooks/catch/[YOUR_WEBHOOK_ID]/';
    
    // Prepare booking data
    $booking_data = array(
        'id' => $booking['id'],
        'status' => $booking['status'],
        'bookingStart' => $booking['bookingStart'],
        'bookingEnd' => $booking['bookingEnd'],
        'customer' => array(
            'id' => $booking['customer']['id'],
            'firstName' => $booking['customer']['firstName'],
            'lastName' => $booking['customer']['lastName'],
            'email' => $booking['customer']['email'],
            'phone' => $booking['customer']['phone']
        ),
        'service' => array(
            'id' => $booking['service']['id'],
            'name' => $booking['service']['name'],
            'price' => $booking['service']['price']
        ),
        'property' => get_property_identifier() // Custom function to identify property
    );
    
    // Send webhook
    wp_remote_post($webhook_url, array(
        'headers' => array('Content-Type' => 'application/json'),
        'body' => json_encode($booking_data),
        'timeout' => 30
    ));
}

/**
 * Get property identifier based on site URL
 */
function get_property_identifier() {
    $site_url = get_site_url();
    
    if (strpos($site_url, 'altagraciamontilla.com') !== false) {
        return 'altagracia';
    } elseif (strpos($site_url, 'the7space.com') !== false) {
        return 'the7space';
    } elseif (strpos($site_url, 'utakwest.com') !== false) {
        return 'utakwest';
    }
    
    return 'unknown';
}
```

### 3.2. Amelia Booking Payload Example

```json
{
  "id": 789,
  "status": "approved",
  "bookingStart": "2025-10-20T14:00:00",
  "bookingEnd": "2025-10-20T15:00:00",
  "customer": {
    "id": 456,
    "firstName": "Jane",
    "lastName": "Smith",
    "email": "jane.smith@example.com",
    "phone": "(555) 987-6543"
  },
  "service": {
    "id": 12,
    "name": "Operations Consulting - 60 min",
    "price": 250
  },
  "property": "utakwest"
}
```

## 4. HubSpot API Integration

### 4.1. Creating a Contact in HubSpot

**Endpoint**: `POST https://api.hubapi.com/crm/v3/objects/contacts`

**Headers**:
```
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
```

**Request Body**:
```json
{
  "properties": {
    "email": "john.doe@example.com",
    "firstname": "John",
    "lastname": "Doe",
    "phone": "(555) 123-4567",
    "property_source": "utakwest",
    "last_order_id": "12345",
    "last_order_total": "250.00",
    "last_order_date": "2025-10-16"
  }
}
```

**Response**:
```json
{
  "id": "123456789",
  "properties": {
    "createdate": "2025-10-16T10:30:00.000Z",
    "email": "john.doe@example.com",
    "firstname": "John",
    "lastname": "Doe",
    "phone": "(555) 123-4567",
    "property_source": "utakwest",
    "last_order_id": "12345",
    "last_order_total": "250.00",
    "last_order_date": "2025-10-16",
    "hs_object_id": "123456789",
    "lastmodifieddate": "2025-10-16T10:30:00.000Z"
  },
  "createdAt": "2025-10-16T10:30:00.000Z",
  "updatedAt": "2025-10-16T10:30:00.000Z",
  "archived": false
}
```

### 4.2. Updating a Contact in HubSpot

**Endpoint**: `PATCH https://api.hubapi.com/crm/v3/objects/contacts/{contactId}`

**Headers**:
```
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
```

**Request Body**:
```json
{
  "properties": {
    "last_order_id": "12346",
    "last_order_total": "350.00",
    "last_order_date": "2025-10-17"
  }
}
```

### 4.3. Searching for a Contact by Email

**Endpoint**: `POST https://api.hubapi.com/crm/v3/objects/contacts/search`

**Headers**:
```
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
```

**Request Body**:
```json
{
  "filterGroups": [
    {
      "filters": [
        {
          "propertyName": "email",
          "operator": "EQ",
          "value": "john.doe@example.com"
        }
      ]
    }
  ]
}
```

**Response**:
```json
{
  "total": 1,
  "results": [
    {
      "id": "123456789",
      "properties": {
        "email": "john.doe@example.com",
        "firstname": "John",
        "lastname": "Doe",
        "createdate": "2025-10-16T10:30:00.000Z"
      },
      "createdAt": "2025-10-16T10:30:00.000Z",
      "updatedAt": "2025-10-16T10:30:00.000Z",
      "archived": false
    }
  ]
}
```

## 5. Airtable API Integration

### 5.1. Creating a Record in Airtable

**Endpoint**: `POST https://api.airtable.com/v0/{baseId}/{tableName}`

**Headers**:
```
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
```

**Request Body** (Customers table):
```json
{
  "fields": {
    "Email": "john.doe@example.com",
    "First Name": "John",
    "Last Name": "Doe",
    "Phone": "(555) 123-4567",
    "Property Source": "Utak West"
  }
}
```

**Response**:
```json
{
  "id": "recABC123",
  "createdTime": "2025-10-16T10:30:00.000Z",
  "fields": {
    "Email": "john.doe@example.com",
    "First Name": "John",
    "Last Name": "Doe",
    "Phone": "(555) 123-4567",
    "Property Source": "Utak West"
  }
}
```

### 5.2. Updating a Record in Airtable

**Endpoint**: `PATCH https://api.airtable.com/v0/{baseId}/{tableName}/{recordId}`

**Headers**:
```
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
```

**Request Body**:
```json
{
  "fields": {
    "Phone": "(555) 123-9999"
  }
}
```

### 5.3. Searching for a Record by Email

**Endpoint**: `GET https://api.airtable.com/v0/{baseId}/{tableName}?filterByFormula={Email}="john.doe@example.com"`

**Headers**:
```
Authorization: Bearer YOUR_API_KEY
```

**Response**:
```json
{
  "records": [
    {
      "id": "recABC123",
      "createdTime": "2025-10-16T10:30:00.000Z",
      "fields": {
        "Email": "john.doe@example.com",
        "First Name": "John",
        "Last Name": "Doe",
        "Phone": "(555) 123-4567",
        "Property Source": "Utak West"
      }
    }
  ],
  "offset": null
}
```

## 6. Complete Integration Workflow Example

### 6.1. Scenario: New WooCommerce Order

**Step 1: WooCommerce Webhook Triggered**
*   Event: New order created
*   Webhook sends order data to Zapier/n8n

**Step 2: Search for Existing Customer in HubSpot**
*   API call to HubSpot to search by email
*   If found, get contact ID
*   If not found, prepare to create new contact

**Step 3: Create or Update Contact in HubSpot**
*   If contact exists, update with new order data
*   If contact doesn't exist, create new contact

**Step 4: Create or Update Customer in Airtable**
*   Search Airtable Customers table by email
*   Create or update customer record

**Step 5: Create Order Record in Airtable**
*   Create new record in Orders table
*   Link to customer record

**Step 6: Send Confirmation Email**
*   Use email service (SendGrid, Mailgun, etc.)
*   Send order confirmation with cross-sell recommendations

**Step 7: Log Activity**
*   Log the integration activity for monitoring

### 6.2. n8n Workflow JSON

```json
{
  "name": "WooCommerce Order to CRM",
  "nodes": [
    {
      "parameters": {
        "httpMethod": "POST",
        "path": "woocommerce-order",
        "responseMode": "responseNode"
      },
      "name": "Webhook",
      "type": "n8n-nodes-base.webhook",
      "typeVersion": 1,
      "position": [250, 300],
      "webhookId": "abc123"
    },
    {
      "parameters": {
        "operation": "search",
        "resource": "contact",
        "email": "={{$json[\"billing\"][\"email\"]}}"
      },
      "name": "Search HubSpot Contact",
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
        "conditions": {
          "number": [
            {
              "value1": "={{$json[\"total\"]}}",
              "operation": "larger",
              "value2": 0
            }
          ]
        }
      },
      "name": "Contact Exists?",
      "type": "n8n-nodes-base.if",
      "typeVersion": 1,
      "position": [650, 300]
    },
    {
      "parameters": {
        "operation": "create",
        "resource": "contact",
        "email": "={{$node[\"Webhook\"].json[\"billing\"][\"email\"]}}",
        "additionalFields": {
          "firstname": "={{$node[\"Webhook\"].json[\"billing\"][\"first_name\"]}}",
          "lastname": "={{$node[\"Webhook\"].json[\"billing\"][\"last_name\"]}}",
          "phone": "={{$node[\"Webhook\"].json[\"billing\"][\"phone\"]}}",
          "property_source": "={{$node[\"Webhook\"].json[\"meta_data\"][0][\"value\"]}}",
          "last_order_id": "={{$node[\"Webhook\"].json[\"id\"]}}",
          "last_order_total": "={{$node[\"Webhook\"].json[\"total\"]}}",
          "last_order_date": "={{$node[\"Webhook\"].json[\"date_created\"]}}"
        }
      },
      "name": "Create HubSpot Contact",
      "type": "n8n-nodes-base.hubspot",
      "typeVersion": 1,
      "position": [850, 200],
      "credentials": {
        "hubspotApi": {
          "id": "1",
          "name": "HubSpot account"
        }
      }
    },
    {
      "parameters": {
        "operation": "update",
        "resource": "contact",
        "contactId": "={{$node[\"Search HubSpot Contact\"].json[\"id\"]}}",
        "updateFields": {
          "last_order_id": "={{$node[\"Webhook\"].json[\"id\"]}}",
          "last_order_total": "={{$node[\"Webhook\"].json[\"total\"]}}",
          "last_order_date": "={{$node[\"Webhook\"].json[\"date_created\"]}}"
        }
      },
      "name": "Update HubSpot Contact",
      "type": "n8n-nodes-base.hubspot",
      "typeVersion": 1,
      "position": [850, 400],
      "credentials": {
        "hubspotApi": {
          "id": "1",
          "name": "HubSpot account"
        }
      }
    },
    {
      "parameters": {
        "operation": "append",
        "application": "appABC123",
        "table": "Customers",
        "options": {}
      },
      "name": "Create Airtable Customer",
      "type": "n8n-nodes-base.airtable",
      "typeVersion": 1,
      "position": [1050, 300],
      "credentials": {
        "airtableApi": {
          "id": "2",
          "name": "Airtable account"
        }
      }
    },
    {
      "parameters": {
        "respondWith": "json",
        "responseBody": "={{JSON.stringify({\"success\": true, \"message\": \"Order synced to CRM\"})}}"
      },
      "name": "Respond to Webhook",
      "type": "n8n-nodes-base.respondToWebhook",
      "typeVersion": 1,
      "position": [1250, 300]
    }
  ],
  "connections": {
    "Webhook": {
      "main": [[{"node": "Search HubSpot Contact", "type": "main", "index": 0}]]
    },
    "Search HubSpot Contact": {
      "main": [[{"node": "Contact Exists?", "type": "main", "index": 0}]]
    },
    "Contact Exists?": {
      "main": [
        [{"node": "Update HubSpot Contact", "type": "main", "index": 0}],
        [{"node": "Create HubSpot Contact", "type": "main", "index": 0}]
      ]
    },
    "Create HubSpot Contact": {
      "main": [[{"node": "Create Airtable Customer", "type": "main", "index": 0}]]
    },
    "Update HubSpot Contact": {
      "main": [[{"node": "Create Airtable Customer", "type": "main", "index": 0}]]
    },
    "Create Airtable Customer": {
      "main": [[{"node": "Respond to Webhook", "type": "main", "index": 0}]]
    }
  }
}
```

## 7. Testing API Integrations

### 7.1. Using Postman

1. **Import Collection**: Create a Postman collection with all API endpoints
2. **Set Environment Variables**: Configure API keys and base URLs
3. **Test Each Endpoint**: Verify responses and error handling
4. **Create Test Scenarios**: Test complete workflows end-to-end

### 7.2. Using cURL

**Test HubSpot Contact Creation**:
```bash
curl -X POST \
  https://api.hubapi.com/crm/v3/objects/contacts \
  -H 'Authorization: Bearer YOUR_API_KEY' \
  -H 'Content-Type: application/json' \
  -d '{
    "properties": {
      "email": "test@example.com",
      "firstname": "Test",
      "lastname": "User"
    }
  }'
```

**Test Airtable Record Creation**:
```bash
curl -X POST \
  https://api.airtable.com/v0/YOUR_BASE_ID/Customers \
  -H 'Authorization: Bearer YOUR_API_KEY' \
  -H 'Content-Type: application/json' \
  -d '{
    "fields": {
      "Email": "test@example.com",
      "First Name": "Test",
      "Last Name": "User"
    }
  }'
```

## 8. Error Handling & Logging

### 8.1. Common Error Scenarios

*   **API Rate Limits**: Implement exponential backoff and retry logic
*   **Authentication Failures**: Verify API keys and refresh tokens
*   **Network Timeouts**: Set appropriate timeout values and handle gracefully
*   **Invalid Data**: Validate data before sending to APIs
*   **Duplicate Records**: Implement upsert logic to handle duplicates

### 8.2. Logging Best Practices

*   Log all API requests and responses
*   Include timestamps and request IDs
*   Store logs in a centralized location (e.g., CloudWatch, Loggly)
*   Set up alerts for critical errors
*   Review logs regularly for optimization opportunities

## 9. Security Considerations

### 9.1. API Key Management

*   Store API keys in environment variables, not in code
*   Use different API keys for development, staging, and production
*   Rotate API keys regularly
*   Implement IP whitelisting where possible

### 9.2. Webhook Security

*   Verify webhook signatures
*   Use HTTPS for all webhook endpoints
*   Implement rate limiting
*   Validate all incoming data

## 10. References

*   [1] WooCommerce Webhooks Documentation (https://woocommerce.com/document/webhooks/)
*   [2] HubSpot API Documentation (https://developers.hubspot.com/docs/api/overview)
*   [3] Airtable API Documentation (https://airtable.com/developers/web/api/introduction)
*   [4] n8n Documentation (https://docs.n8n.io/)
*   [5] Zapier Webhooks Documentation (https://zapier.com/help/create/code-webhooks/trigger-zaps-from-webhooks)

