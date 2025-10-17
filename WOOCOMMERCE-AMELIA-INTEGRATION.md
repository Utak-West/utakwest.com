# WooCommerce & Amelia Booking Integration Guide

## Author
Manus AI

## Date
October 16, 2025

## 1. Overview

This document provides a comprehensive guide for integrating WooCommerce and Amelia Booking across the HigherSelf Network ecosystem, including Altagracia Montilla's website, The 7 Space, and the Utak West portfolio website.

## 2. WooCommerce Integration Strategy

WooCommerce will serve as the unified e-commerce platform across all three properties, enabling seamless product sales, digital downloads, and service bookings.

### 2.1. Installation & Configuration

**Required Plugins:**
*   WooCommerce (core plugin)
*   WooCommerce Subscriptions (for recurring services)
*   WooCommerce Bookings (for time-based services)
*   CartFlows (for sales funnels and upsells)
*   WooCommerce REST API (for cross-site integration)

**Configuration Steps:**

1.  **Install WooCommerce** on all three websites
2.  **Configure Payment Gateways**: Set up Stripe as the primary payment processor
3.  **Set Up Tax Settings**: Configure tax rates based on location
4.  **Configure Shipping**: Set up shipping zones and methods (if applicable)
5.  **Enable REST API**: Generate API keys for cross-site communication

### 2.2. Product Catalog Structure

**Product Categories:**

*   **Altagracia Montilla / A.M. Consulting**
    *   Retreats (Team Retreats, Individual Retreats, Custom Retreats)
    *   Consulting Services (Culture Transformation, Facilitation Training)
    *   Conflict Bravery™ Masterclass
    *   Digital Products (Guides, Templates, Resources)

*   **The 7 Space**
    *   Wellness Classes (Yoga, Meditation, Sound Baths, Breathwork)
    *   Art Gallery Memberships
    *   Venue Rental Packages
    *   Retail Products (Art, Wellness Products)

*   **Utak West**
    *   Consulting Services (Operations, Community Architecture, Nonprofit Management)
    *   SaaS Products (Subscriptions, Licenses)
    *   Digital Resources (Templates, Frameworks, Tools)
    *   Workshop Tickets

### 2.3. Cross-Site Product Recommendations

**Implementation Approach:**

1.  **Shared Product Database**: Create a centralized product database in Airtable
2.  **Product Syncing**: Use Zapier or n8n to sync products across all three WooCommerce instances
3.  **Recommendation Engine**: Implement a custom recommendation widget that suggests related products from other properties

**Example Recommendations:**

*   A customer purchasing a Conflict Bravery™ Masterclass on Altagracia's site sees a recommendation for a Wellness Retreat at The 7 Space
*   A customer booking a Yoga class at The 7 Space sees a recommendation for Operations Consulting from Utak West
*   A customer purchasing a SaaS product from Utak West sees a recommendation for Facilitation Training from A.M. Consulting

### 2.4. Unified Cart & Checkout (Future Enhancement)

**Phase 1**: Separate carts on each website with cross-site recommendations  
**Phase 2**: Implement a unified cart using WooCommerce REST API that allows customers to add items from all three websites to a single cart

**Technical Implementation:**

1.  Create a custom plugin that intercepts "Add to Cart" actions
2.  Use the WooCommerce REST API to add products to a centralized cart
3.  Redirect to a unified checkout page hosted on one of the properties
4.  Process orders and distribute fulfillment to the appropriate property

## 3. Amelia Booking Integration Strategy

Amelia Booking will serve as the centralized scheduling solution for all appointments, classes, and events across the ecosystem.

### 3.1. Installation & Configuration

**Required Plugin:**
*   Amelia Booking (Pro version for advanced features)

**Configuration Steps:**

1.  **Install Amelia** on all three websites (or use a single instance on one site)
2.  **Set Up Services**: Create service categories for each property
3.  **Configure Employees**: Add staff members from each property
4.  **Set Up Locations**: Configure locations for The 7 Space and other venues
5.  **Configure Notifications**: Set up email and SMS notifications for bookings
6.  **Enable Google Calendar Sync**: Sync all bookings to a central Google Calendar

### 3.2. Service Categories

**Altagracia Montilla / A.M. Consulting:**
*   Consultation Calls (30 min, 60 min)
*   Retreat Planning Sessions
*   Facilitation Training Workshops
*   Conflict Bravery™ Masterclass Sessions

**The 7 Space:**
*   Yoga Classes (Various styles and levels)
*   Meditation Sessions (Guided, Silent)
*   Sound Bath Experiences
*   Breathwork Workshops
*   Art Therapy Sessions
*   Venue Rental Bookings

**Utak West:**
*   Operations Consulting Calls (30 min, 60 min, 90 min)
*   SaaS Demo & Onboarding Sessions
*   Workshop Bookings
*   Speaking Engagement Inquiries

### 3.3. Unified Booking Widget

**Implementation:**

1.  Create a custom Amelia booking widget that displays services from all three properties
2.  Add filtering options to allow customers to view services by property or category
3.  Embed the widget on all three websites using a shortcode or Elementor widget

**Shortcode Example:**
```
[ameliabooking category=1,2,3 service=1,2,3,4,5]
```

**Elementor Widget:**
*   Create a custom Elementor widget that wraps the Amelia shortcode
*   Add styling options to match the dark mode design

### 3.4. Cross-Site Booking Recommendations

**Implementation:**

1.  After a customer completes a booking, display a "You might also be interested in..." section
2.  Recommend related services from other properties
3.  Use Amelia's custom fields to track which property the customer booked from

**Example Recommendations:**

*   A customer booking a consultation with Altagracia sees a recommendation for a Meditation class at The 7 Space
*   A customer booking a Yoga class at The 7 Space sees a recommendation for Operations Consulting with Utak West
*   A customer booking a SaaS demo with Utak West sees a recommendation for a Facilitation Training workshop with A.M. Consulting

## 4. Integration with CRM & Data Platforms

### 4.1. HubSpot CRM Integration

**WooCommerce to HubSpot:**

1.  Install the HubSpot for WooCommerce plugin
2.  Configure the plugin to sync orders, customers, and products to HubSpot
3.  Create custom properties in HubSpot to track which property the customer purchased from

**Amelia to HubSpot:**

1.  Use Zapier or n8n to create a workflow that triggers when a new booking is created in Amelia
2.  Send the booking data to HubSpot and create or update a contact record
3.  Add the booking details to the contact's timeline

### 4.2. Airtable Integration

**WooCommerce to Airtable:**

1.  Use Zapier or n8n to create a workflow that triggers when a new order is created in WooCommerce
2.  Send the order data to Airtable and create a new record in the "Orders" table
3.  Link the order to the customer record in the "Customers" table

**Amelia to Airtable:**

1.  Use Zapier or n8n to create a workflow that triggers when a new booking is created in Amelia
2.  Send the booking data to Airtable and create a new record in the "Bookings" table
3.  Link the booking to the customer record in the "Customers" table

### 4.3. Notion Integration

**Documentation & SOPs:**

1.  Create a Notion database for all WooCommerce and Amelia integrations
2.  Document all workflows, automation rules, and configuration settings
3.  Create SOPs for common tasks (e.g., adding a new product, creating a new service)

**Customer Journey Mapping:**

1.  Create a Notion database to map the customer journey across all three properties
2.  Track touchpoints, interactions, and conversions
3.  Use this data to optimize the customer experience

## 5. Automation Workflows

### 5.1. Uncanny Automator Workflows

**Workflow 1: New WooCommerce Order → HubSpot Contact**

*   Trigger: New order created in WooCommerce
*   Action: Create or update contact in HubSpot
*   Action: Add order details to contact timeline
*   Action: Add contact to appropriate email list

**Workflow 2: New Amelia Booking → Google Calendar Event**

*   Trigger: New booking created in Amelia
*   Action: Create event in Google Calendar
*   Action: Send confirmation email to customer
*   Action: Send reminder email 24 hours before appointment

**Workflow 3: Completed Purchase → Cross-Sell Email**

*   Trigger: Order status changed to "Completed" in WooCommerce
*   Action: Wait 3 days
*   Action: Send email with cross-sell recommendations from other properties

### 5.2. Zapier/n8n Workflows

**Workflow 1: WooCommerce Order → Airtable**

*   Trigger: New order in WooCommerce (via webhook)
*   Action: Create record in Airtable "Orders" table
*   Action: Update customer record in Airtable "Customers" table

**Workflow 2: Amelia Booking → Airtable**

*   Trigger: New booking in Amelia (via webhook)
*   Action: Create record in Airtable "Bookings" table
*   Action: Update customer record in Airtable "Customers" table

**Workflow 3: HubSpot Contact Update → Notion**

*   Trigger: Contact property changed in HubSpot
*   Action: Update corresponding record in Notion database
*   Action: Send notification to team in Slack

## 6. CartFlows Integration

CartFlows will be used to create optimized sales funnels and upsell sequences for high-value products and services.

### 6.1. Funnel Structure

**Retreat Booking Funnel (Altagracia Montilla):**

1.  **Landing Page**: Retreat overview and benefits
2.  **Checkout Page**: Retreat booking with upsells (e.g., add-on workshops, private sessions)
3.  **Upsell Page**: Offer related services from The 7 Space (e.g., pre-retreat meditation class)
4.  **Thank You Page**: Confirmation and next steps

**Wellness Class Funnel (The 7 Space):**

1.  **Landing Page**: Class overview and schedule
2.  **Checkout Page**: Class booking with upsells (e.g., class packages, memberships)
3.  **Upsell Page**: Offer related services from A.M. Consulting (e.g., Facilitation Training)
4.  **Thank You Page**: Confirmation and next steps

**SaaS Product Funnel (Utak West):**

1.  **Landing Page**: Product overview and features
2.  **Checkout Page**: Subscription purchase with upsells (e.g., premium support, consulting hours)
3.  **Upsell Page**: Offer related services from A.M. Consulting or The 7 Space
4.  **Thank You Page**: Onboarding instructions and next steps

### 6.2. A/B Testing

Use CartFlows' built-in A/B testing features to optimize funnel performance:

*   Test different headlines and copy on landing pages
*   Test different upsell offers
*   Test different checkout page layouts

## 7. Implementation Timeline

### Phase 1: Foundation (Weeks 1-2)

*   Install WooCommerce and Amelia on all three websites
*   Configure payment gateways and basic settings
*   Set up product catalogs and service categories

### Phase 2: Integration (Weeks 3-4)

*   Integrate WooCommerce and Amelia with HubSpot CRM
*   Set up Airtable databases and sync workflows
*   Configure Notion documentation

### Phase 3: Automation (Weeks 5-6)

*   Create Uncanny Automator workflows
*   Set up Zapier/n8n workflows
*   Test all automation sequences

### Phase 4: CartFlows (Weeks 7-8)

*   Create sales funnels for high-value products and services
*   Set up upsell sequences
*   Implement A/B testing

### Phase 5: Testing & Optimization (Weeks 9-10)

*   Comprehensive testing of all integrations
*   User acceptance testing
*   Performance optimization
*   Launch to production

## 8. Success Metrics

### E-commerce Metrics

*   **Conversion Rate**: Percentage of visitors who make a purchase
*   **Average Order Value (AOV)**: Average amount spent per order
*   **Cross-Sell Rate**: Percentage of customers who purchase from multiple properties
*   **Cart Abandonment Rate**: Percentage of carts that are abandoned before checkout

### Booking Metrics

*   **Booking Completion Rate**: Percentage of booking attempts that are completed
*   **Average Booking Value**: Average revenue per booking
*   **Cross-Property Booking Rate**: Percentage of customers who book services from multiple properties
*   **Cancellation Rate**: Percentage of bookings that are cancelled

### Customer Metrics

*   **Customer Lifetime Value (CLV)**: Total revenue generated by a customer over their lifetime
*   **Customer Retention Rate**: Percentage of customers who make repeat purchases
*   **Net Promoter Score (NPS)**: Customer satisfaction and likelihood to recommend

## 9. Maintenance & Support

### Regular Tasks

*   **Weekly**: Review booking and order data, check for errors or issues
*   **Monthly**: Analyze performance metrics, optimize funnels and workflows
*   **Quarterly**: Review and update product catalogs and service offerings
*   **Annually**: Comprehensive audit of all integrations and systems

### Support Resources

*   WooCommerce Documentation: https://woocommerce.com/documentation/
*   Amelia Documentation: https://wpamelia.com/documentation/
*   CartFlows Documentation: https://cartflows.com/docs/
*   HubSpot API Documentation: https://developers.hubspot.com/docs/api/overview

## 10. References

*   [1] WooCommerce Integration Summary (`/home/ubuntu/Altagracia-Montilla/WOOCOMMERCE_INTEGRATION_SUMMARY.md`)
*   [2] Amelia Booking Integration Summary (`/home/ubuntu/the7space-website/AMELIA-BOOKING-INTEGRATION-SUMMARY.md`)
*   [3] The 7 Space Cross-Platform Strategy Map (Knowledge Base)
*   [4] Ecosystem Integration Data (`/home/ubuntu/ecosystem-integration-data.md`)

