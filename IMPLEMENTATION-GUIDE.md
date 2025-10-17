# Utak West Portfolio Website - Implementation Guide

## Author
Manus AI

## Date
October 16, 2025

## 1. Overview

This guide provides step-by-step instructions for implementing the Utak West portfolio website using WordPress and Elementor. It covers local development setup, theme configuration, Elementor page building, and deployment to production.

## 2. Prerequisites

Before you begin, ensure you have the following installed on your local machine:

*   **Local WordPress Environment**: Local by Flywheel, XAMPP, MAMP, or similar
*   **VS Code**: For editing code
*   **Git**: For version control
*   **Node.js & npm**: For any build tools (optional)

## 3. Local Development Setup

### 3.1. Install WordPress Locally

1.  Download and install **Local by Flywheel** (https://localwp.com/)
2.  Create a new WordPress site named "utakwest"
3.  Choose "Preferred" environment (PHP 8.0+, MySQL 5.7+)
4.  Set admin username and password
5.  Start the site

### 3.2. Clone the GitHub Repository

```bash
cd ~/Local\ Sites/utakwest/app/public/
git clone https://github.com/Utak-West/utakwest.com.git .
```

### 3.3. Install Required Plugins

Navigate to **Plugins > Add New** and install the following plugins:

*   **Elementor** (free version)
*   **Elementor Pro** (purchase license)
*   **WooCommerce**
*   **Amelia Booking**
*   **Uncanny Automator**
*   **CartFlows**
*   **All in One SEO** (or Yoast SEO)

Activate all plugins after installation.

### 3.4. Install and Activate Theme

1.  Navigate to **Appearance > Themes > Add New**
2.  Install a lightweight Elementor-compatible theme (e.g., **Hello Elementor**, **Astra**, or **GeneratePress**)
3.  Activate the theme

## 4. Importing the Dark Mode Design System

### 4.1. Add Custom CSS

1.  Navigate to **Appearance > Customize > Additional CSS**
2.  Copy the contents of `/assets/css/dark-mode.css` from the repository
3.  Paste into the Additional CSS field
4.  Click **Publish**

### 4.2. Configure Elementor Global Settings

1.  Navigate to **Elementor > Settings > Style**
2.  Click on **Global Colors**
3.  Add the following colors:

| Color Name | Hex Code | Usage |
|------------|----------|-------|
| Primary Background | `#0A0E27` | Main background |
| Secondary Background | `#1A1F3A` | Card surfaces |
| Heading Text | `#FFFFFF` | Headings |
| Body Text | `#E8EAF6` | Body copy |
| Primary Accent | `#2196F3` | CTAs |
| Link Color | `#00BCD4` | Links |

4.  Click on **Global Fonts**
5.  Set up the following fonts:

| Font Type | Font Family | Weight | Size |
|-----------|-------------|--------|------|
| Primary Heading | Inter | 800 | 48px |
| Secondary Heading | Inter | 700 | 36px |
| Body | Inter | 400 | 16px |

## 5. Building Pages with Elementor

### 5.1. Homepage

**Step 1: Create a New Page**

1.  Navigate to **Pages > Add New**
2.  Title the page "Home"
3.  Click **Edit with Elementor**

**Step 2: Build the Hero Section**

1.  Add a new section with **Full Width** layout
2.  Set section height to **Fit To Screen**
3.  Set background color to `var(--bg-primary)` or `#0A0E27`
4.  Add a **Heading** widget:
    *   Text: "Utak West"
    *   HTML Tag: H1
    *   Color: `#FFFFFF`
    *   Typography: Inter, 800 weight, 48px
5.  Add another **Heading** widget:
    *   Text: "Community Architect & Operations Specialist"
    *   HTML Tag: H2
    *   Color: `#9FA8DA`
    *   Typography: Inter, 400 weight, 24px
6.  Add two **Button** widgets:
    *   Button 1: "View Portfolio" (Primary style, link to `/portfolio`)
    *   Button 2: "Schedule Consultation" (Secondary style, link to `/contact`)

**Step 3: Build the About Section**

1.  Add a new section with **Boxed** layout
2.  Set background color to `var(--bg-secondary)` or `#1A1F3A`
3.  Add two columns (50/50 split)
4.  Left column:
    *   Add **Text Editor** widget with bio content
5.  Right column:
    *   Add **Image** widget with professional headshot

**Step 4: Build the Services Section**

1.  Add a new section with **Boxed** layout
2.  Set background color to `var(--bg-primary)` or `#0A0E27`
3.  Add a **Heading** widget: "Services"
4.  Add three columns (33/33/33 split)
5.  In each column, add an **Icon Box** widget:
    *   Service 1: Consulting Services
    *   Service 2: SaaS Products
    *   Service 3: Resources

**Step 5: Build the Portfolio Highlights Section**

1.  Add a new section with **Boxed** layout
2.  Set background color to `var(--bg-secondary)` or `#1A1F3A`
3.  Add a **Heading** widget: "Featured Projects"
4.  Add a **Portfolio** widget (or use **Post Grid** if available)
5.  Configure to display 3-6 featured projects

**Step 6: Build the CTA Section**

1.  Add a new section with **Full Width** layout
2.  Set background color to `var(--bg-tertiary)` or `#252B4A`
3.  Add a **Heading** widget: "Ready to work together?"
4.  Add a **Button** widget: "Schedule a Consultation"

**Step 7: Publish the Page**

1.  Click **Update** to save changes
2.  Navigate to **Settings > Reading**
3.  Set "Home" as the front page

### 5.2. Portfolio Page

**Step 1: Create a New Page**

1.  Navigate to **Pages > Add New**
2.  Title the page "Portfolio"
3.  Click **Edit with Elementor**

**Step 2: Build the Portfolio Grid**

1.  Add a new section with **Boxed** layout
2.  Add a **Heading** widget: "Portfolio"
3.  Add a **Portfolio** widget (or **Post Grid**)
4.  Configure to display all projects
5.  Add filter options by category (if available)

**Step 3: Publish the Page**

1.  Click **Update** to save changes

### 5.3. Services Page

**Step 1: Create a New Page**

1.  Navigate to **Pages > Add New**
2.  Title the page "Services"
3.  Click **Edit with Elementor**

**Step 2: Build the Services Overview**

1.  Add a new section with **Boxed** layout
2.  Add a **Heading** widget: "Services"
3.  Add a **Text Editor** widget with overview content

**Step 3: Build Service Detail Sections**

1.  For each service (Consulting, SaaS, Resources):
    *   Add a new section
    *   Add a **Heading** widget with service name
    *   Add a **Text Editor** widget with service description
    *   Add a **Button** widget: "Learn More" or "Book Now"

**Step 4: Publish the Page**

1.  Click **Update** to save changes

### 5.4. About Page

**Step 1: Create a New Page**

1.  Navigate to **Pages > Add New**
2.  Title the page "About"
3.  Click **Edit with Elementor**

**Step 2: Build the About Content**

1.  Add a new section with **Boxed** layout
2.  Add a **Heading** widget: "About Utak West"
3.  Add a **Text Editor** widget with detailed bio
4.  Add sections for:
    *   Roles & Responsibilities
    *   Skills & Expertise
    *   Professional Background

**Step 3: Publish the Page**

1.  Click **Update** to save changes

### 5.5. Contact Page

**Step 1: Create a New Page**

1.  Navigate to **Pages > Add New**
2.  Title the page "Contact"
3.  Click **Edit with Elementor**

**Step 2: Build the Contact Form**

1.  Add a new section with **Boxed** layout
2.  Add a **Heading** widget: "Get In Touch"
3.  Add a **Form** widget (Elementor Pro) or use **Contact Form 7**
4.  Configure form fields: Name, Email, Subject, Message
5.  Set up email notifications

**Step 3: Add Booking Widget**

1.  Add a new section
2.  Add a **Heading** widget: "Schedule a Consultation"
3.  Add a **Shortcode** widget with Amelia booking shortcode:
    ```
    [ameliabooking]
    ```

**Step 4: Publish the Page**

1.  Click **Update** to save changes

## 6. WooCommerce Configuration

### 6.1. Basic Setup

1.  Navigate to **WooCommerce > Settings**
2.  Complete the Setup Wizard:
    *   Store Details: Enter business information
    *   Industry: Select "Services" or "Technology"
    *   Product Types: Select "Services" and "Digital Products"
    *   Business Details: Enter tax and shipping information
    *   Theme: Choose "Continue with my active theme"

### 6.2. Payment Gateway

1.  Navigate to **WooCommerce > Settings > Payments**
2.  Enable **Stripe**
3.  Click **Manage** to configure Stripe settings
4.  Enter Stripe API keys (get from Stripe dashboard)
5.  Save changes

### 6.3. Create Products

1.  Navigate to **Products > Add New**
2.  Create products for:
    *   Consulting Services (hourly rates, packages)
    *   SaaS Products (subscriptions)
    *   Digital Resources (templates, frameworks)

## 7. Amelia Booking Configuration

### 7.1. Basic Setup

1.  Navigate to **Amelia > Settings**
2.  Configure general settings:
    *   Company Name: "Utak West"
    *   Company Website: "utakwest.com"
    *   Company Phone: Enter phone number
3.  Configure notification settings:
    *   Email notifications for bookings
    *   SMS notifications (optional)

### 7.2. Create Services

1.  Navigate to **Amelia > Services**
2.  Create services for:
    *   Operations Consulting (30 min, 60 min, 90 min)
    *   SaaS Demo & Onboarding
    *   Workshop Bookings

### 7.3. Set Up Employees

1.  Navigate to **Amelia > Employees**
2.  Add "Utak West" as an employee
3.  Assign services to the employee
4.  Set availability schedule

### 7.4. Configure Google Calendar Sync

1.  Navigate to **Amelia > Settings > Integrations**
2.  Enable Google Calendar integration
3.  Authorize with Google account
4.  Select calendar to sync

## 8. Version Control with Git

### 8.1. Commit Changes

```bash
cd ~/Local\ Sites/utakwest/app/public/
git add .
git commit -m "Initial website build with Elementor"
git push origin main
```

### 8.2. Regular Commits

Make regular commits as you make changes:

```bash
git add .
git commit -m "Description of changes"
git push origin main
```

## 9. Testing

### 9.1. Functionality Testing

*   Test all navigation links
*   Test all forms (contact form, booking form)
*   Test WooCommerce checkout process
*   Test Amelia booking process

### 9.2. Responsive Testing

*   Test on mobile devices (iPhone, Android)
*   Test on tablets (iPad)
*   Test on desktop browsers (Chrome, Firefox, Safari, Edge)

### 9.3. Performance Testing

*   Use Google PageSpeed Insights to test performance
*   Optimize images if needed
*   Minify CSS and JavaScript

### 9.4. Accessibility Testing

*   Use WAVE or axe DevTools to test accessibility
*   Ensure all images have alt text
*   Ensure proper heading hierarchy
*   Test keyboard navigation

## 10. Deployment to Production

### 10.1. Choose a Hosting Provider

Recommended hosting providers:

*   **WP Engine** (managed WordPress hosting)
*   **Kinsta** (managed WordPress hosting)
*   **SiteGround** (shared/managed hosting)
*   **Cloudways** (cloud hosting)

### 10.2. Export from Local

1.  Install **All-in-One WP Migration** plugin
2.  Navigate to **All-in-One WP Migration > Export**
3.  Choose **Export To > File**
4.  Download the export file

### 10.3. Import to Production

1.  Install WordPress on production server
2.  Install **All-in-One WP Migration** plugin
3.  Navigate to **All-in-One WP Migration > Import**
4.  Upload the export file
5.  Complete the import process

### 10.4. Update URLs

1.  Navigate to **Settings > General**
2.  Update **WordPress Address** and **Site Address** to production URL
3.  Save changes

### 10.5. Configure DNS

1.  Point domain (utakwest.com) to hosting provider's nameservers
2.  Wait for DNS propagation (can take up to 48 hours)

### 10.6. Install SSL Certificate

1.  Most hosting providers offer free SSL certificates via Let's Encrypt
2.  Enable SSL in hosting control panel
3.  Update WordPress to use HTTPS

### 10.7. Final Testing

*   Test all functionality on production site
*   Verify all links and forms work correctly
*   Test payment processing (use test mode first)
*   Test booking system

## 11. Maintenance & Updates

### 11.1. Regular Updates

*   Update WordPress core monthly
*   Update plugins weekly
*   Update theme as needed

### 11.2. Backups

*   Set up daily automated backups
*   Store backups off-site (e.g., Dropbox, Google Drive)
*   Test backup restoration quarterly

### 11.3. Security

*   Install a security plugin (e.g., Wordfence, Sucuri)
*   Enable two-factor authentication
*   Use strong passwords
*   Limit login attempts

### 11.4. Performance Monitoring

*   Monitor site speed with Google PageSpeed Insights
*   Monitor uptime with UptimeRobot or Pingdom
*   Review Google Analytics monthly

## 12. Troubleshooting

### Common Issues

**Issue: Elementor not loading**
*   Solution: Clear browser cache, disable conflicting plugins

**Issue: Dark mode colors not applying**
*   Solution: Check that custom CSS is properly added to Customizer

**Issue: WooCommerce checkout not working**
*   Solution: Check payment gateway settings, test in sandbox mode

**Issue: Amelia bookings not syncing to Google Calendar**
*   Solution: Re-authorize Google Calendar integration

## 13. Resources

*   **Elementor Documentation**: https://elementor.com/help/
*   **WooCommerce Documentation**: https://woocommerce.com/documentation/
*   **Amelia Documentation**: https://wpamelia.com/documentation/
*   **WordPress Codex**: https://codex.wordpress.org/

## 14. Support

For additional support, refer to:

*   **Design Specifications**: `/DESIGN-SPECIFICATIONS.md`
*   **WooCommerce & Amelia Integration**: `/WOOCOMMERCE-AMELIA-INTEGRATION.md`
*   **Integration Architecture**: `/integration-architecture.md`
*   **GitHub Repository**: https://github.com/Utak-West/utakwest.com

