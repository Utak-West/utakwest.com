# Utak West Portfolio Website - Design Specifications

## Author
Manus AI

## Date
October 16, 2025

## 1. Overview

This document provides comprehensive design specifications for the Utak West portfolio website. The design emphasizes a dark mode aesthetic with blue tones, drawing inspiration from Apple's developer website and the Mr. Robot series, while promoting calmness and professionalism.

## 2. Design Philosophy

The Utak West portfolio website embodies the intersection of cutting-edge technology and human-centered design. The aesthetic is intentionally minimal, focusing on clarity, accessibility, and visual impact. The dark mode design reduces eye strain while the carefully selected blue palette promotes focus and calmness.

### 2.1. Key Design Principles

*   **Minimalism**: Clean layouts with generous whitespace (or "dark space")
*   **Clarity**: Clear typography hierarchy and intuitive navigation
*   **Professionalism**: Sophisticated color palette and polished interactions
*   **Technology-Forward**: Modern design patterns and smooth animations
*   **Accessibility**: WCAG AA compliant with strong contrast ratios

## 3. Color Palette

The color palette is built around deep blues and carefully selected accent colors that draw attention while maintaining a calm atmosphere.

### 3.1. Background Colors

| Color Name | Hex Code | Usage |
|------------|----------|-------|
| Primary Background | `#0A0E27` | Main page background (deep blue-black) |
| Secondary Background | `#1A1F3A` | Card surfaces and elevated elements |
| Tertiary Background | `#252B4A` | Hover states and further elevated surfaces |
| Surface Elevated | `#303654` | Modal dialogs and highest elevation |

### 3.2. Text Colors

| Color Name | Hex Code | Usage |
|------------|----------|-------|
| Heading Text | `#FFFFFF` | Primary headings (H1, H2) |
| Body Text | `#E8EAF6` | Body copy and paragraphs |
| Secondary Text | `#9FA8DA` | Captions, labels, secondary information |
| Disabled Text | `#5C6BC0` | Disabled states and placeholder text |

### 3.3. Accent Colors

| Color Name | Hex Code | Usage |
|------------|----------|-------|
| Primary CTA | `#2196F3` | Primary buttons and calls-to-action |
| Secondary CTA | `#42A5F5` | Secondary buttons and links |
| Hover State | `#64B5F6` | Button hover effects |
| Link Color | `#00BCD4` | Text links and hyperlinks |
| Success | `#4CAF50` | Success messages and confirmations |
| Warning | `#FFA726` | Warnings and alerts |

### 3.4. CSS Custom Properties

```css
:root {
  /* Backgrounds */
  --bg-primary: #0A0E27;
  --bg-secondary: #1A1F3A;
  --bg-tertiary: #252B4A;
  --bg-elevated: #303654;
  
  /* Text */
  --text-heading: #FFFFFF;
  --text-body: #E8EAF6;
  --text-secondary: #9FA8DA;
  --text-disabled: #5C6BC0;
  
  /* Accents */
  --accent-primary: #2196F3;
  --accent-secondary: #42A5F5;
  --accent-hover: #64B5F6;
  --accent-link: #00BCD4;
  --accent-success: #4CAF50;
  --accent-warning: #FFA726;
  
  /* Shadows */
  --shadow-sm: 0 2px 4px rgba(0,0,0,0.3);
  --shadow-md: 0 4px 8px rgba(0,0,0,0.4);
  --shadow-lg: 0 8px 16px rgba(0,0,0,0.5);
  --shadow-xl: 0 16px 32px rgba(0,0,0,0.6);
  
  /* Transitions */
  --transition-fast: 150ms ease-in-out;
  --transition-base: 300ms ease-in-out;
  --transition-slow: 500ms ease-in-out;
}
```

## 4. Typography

Typography plays a crucial role in establishing hierarchy and readability in the dark mode design.

### 4.1. Font Families

**Primary Font Stack** (Headings):
```css
font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
```

**Secondary Font Stack** (Body):
```css
font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
```

**Monospace Font Stack** (Code):
```css
font-family: 'Fira Code', 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas, 'Courier New', monospace;
```

### 4.2. Type Scale

| Element | Size | Weight | Line Height | Letter Spacing |
|---------|------|--------|-------------|----------------|
| H1 | 48px (3rem) | 800 | 1.2 | -0.02em |
| H2 | 36px (2.25rem) | 700 | 1.3 | -0.01em |
| H3 | 28px (1.75rem) | 700 | 1.4 | 0 |
| H4 | 24px (1.5rem) | 600 | 1.4 | 0 |
| H5 | 20px (1.25rem) | 600 | 1.5 | 0 |
| Body Large | 18px (1.125rem) | 400 | 1.7 | 0 |
| Body | 16px (1rem) | 400 | 1.7 | 0 |
| Body Small | 14px (0.875rem) | 400 | 1.6 | 0 |
| Caption | 12px (0.75rem) | 500 | 1.5 | 0.02em |

### 4.3. Typography CSS

```css
/* Headings */
h1, .h1 {
  font-size: 3rem;
  font-weight: 800;
  line-height: 1.2;
  letter-spacing: -0.02em;
  color: var(--text-heading);
}

h2, .h2 {
  font-size: 2.25rem;
  font-weight: 700;
  line-height: 1.3;
  letter-spacing: -0.01em;
  color: var(--text-heading);
}

h3, .h3 {
  font-size: 1.75rem;
  font-weight: 700;
  line-height: 1.4;
  color: var(--text-heading);
}

/* Body */
body {
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.7;
  color: var(--text-body);
  background-color: var(--bg-primary);
}

p {
  margin-bottom: 1.5rem;
}

/* Links */
a {
  color: var(--accent-link);
  text-decoration: none;
  transition: color var(--transition-fast);
}

a:hover {
  color: var(--accent-hover);
}
```

## 5. Component Library

### 5.1. Buttons

**Primary Button**
```css
.btn-primary {
  background-color: var(--accent-primary);
  color: #FFFFFF;
  padding: 12px 32px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  border: none;
  cursor: pointer;
  transition: all var(--transition-base);
  box-shadow: var(--shadow-md);
}

.btn-primary:hover {
  background-color: var(--accent-hover);
  box-shadow: var(--shadow-lg);
  transform: translateY(-2px);
}
```

**Secondary Button**
```css
.btn-secondary {
  background-color: transparent;
  color: var(--accent-primary);
  padding: 12px 32px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  border: 2px solid var(--accent-primary);
  cursor: pointer;
  transition: all var(--transition-base);
}

.btn-secondary:hover {
  background-color: var(--accent-primary);
  color: #FFFFFF;
  box-shadow: var(--shadow-md);
}
```

### 5.2. Cards

**Basic Card**
```css
.card {
  background-color: var(--bg-secondary);
  border-radius: 12px;
  padding: 32px;
  box-shadow: var(--shadow-md);
  transition: all var(--transition-base);
}

.card:hover {
  background-color: var(--bg-tertiary);
  box-shadow: var(--shadow-lg);
  transform: translateY(-4px);
}
```

**Project Card**
```css
.project-card {
  background-color: var(--bg-secondary);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: var(--shadow-md);
  transition: all var(--transition-base);
}

.project-card:hover {
  box-shadow: var(--shadow-xl);
  transform: translateY(-8px);
}

.project-card-image {
  width: 100%;
  height: 240px;
  object-fit: cover;
}

.project-card-content {
  padding: 24px;
}

.project-card-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--text-heading);
  margin-bottom: 12px;
}

.project-card-description {
  font-size: 1rem;
  color: var(--text-secondary);
  line-height: 1.6;
}
```

### 5.3. Navigation

**Header Navigation**
```css
.header {
  background-color: rgba(10, 14, 39, 0.95);
  backdrop-filter: blur(10px);
  padding: 20px 0;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  box-shadow: var(--shadow-sm);
}

.nav-menu {
  display: flex;
  gap: 32px;
  list-style: none;
}

.nav-link {
  color: var(--text-body);
  font-weight: 500;
  transition: color var(--transition-fast);
}

.nav-link:hover {
  color: var(--accent-primary);
}

.nav-link.active {
  color: var(--accent-primary);
  border-bottom: 2px solid var(--accent-primary);
}
```

### 5.4. Forms

**Input Fields**
```css
.form-input {
  background-color: var(--bg-secondary);
  border: 2px solid transparent;
  border-radius: 8px;
  padding: 12px 16px;
  color: var(--text-body);
  font-size: 1rem;
  width: 100%;
  transition: all var(--transition-fast);
}

.form-input:focus {
  outline: none;
  border-color: var(--accent-primary);
  background-color: var(--bg-tertiary);
}

.form-input::placeholder {
  color: var(--text-disabled);
}
```

**Textarea**
```css
.form-textarea {
  background-color: var(--bg-secondary);
  border: 2px solid transparent;
  border-radius: 8px;
  padding: 12px 16px;
  color: var(--text-body);
  font-size: 1rem;
  width: 100%;
  min-height: 120px;
  resize: vertical;
  transition: all var(--transition-fast);
}

.form-textarea:focus {
  outline: none;
  border-color: var(--accent-primary);
  background-color: var(--bg-tertiary);
}
```

## 6. Page Layouts

### 6.1. Homepage

**Hero Section**
*   Full-height section with centered content
*   Large heading (H1) with name and title
*   Subheading describing role and expertise
*   Two CTAs: "View Portfolio" (primary) and "Schedule Consultation" (secondary)
*   Subtle animated background gradient

**About Section**
*   Two-column layout (text left, image right)
*   Professional headshot or illustration
*   Brief bio highlighting key achievements
*   Links to HigherSelf Network, The 7 Space, and A.M. Consulting

**Services Section**
*   Three-column grid of service cards
*   Each card includes icon, title, and description
*   Services: Consulting, SaaS Products, Resources

**Portfolio Highlights**
*   Featured projects in a grid layout
*   Project cards with images and brief descriptions
*   "View All Projects" CTA

**Testimonials**
*   Carousel or grid of client testimonials
*   Client name, role, and company
*   Quote in larger text

**CTA Section**
*   Centered content with strong CTA
*   "Ready to work together?" heading
*   "Schedule a Consultation" button

### 6.2. Portfolio Page

**Portfolio Grid**
*   Filterable grid of projects
*   Filter by category (HigherSelf Network, The 7 Space, A.M. Consulting, SaaS, etc.)
*   Project cards with hover effects
*   Modal or dedicated page for project details

**Project Detail View**
*   Hero image or video
*   Project title and description
*   Technologies used
*   Role and responsibilities
*   Outcomes and impact
*   Link to live project (if applicable)

### 6.3. Services Page

**Services Overview**
*   Detailed description of each service offering
*   Pricing information (if applicable)
*   Booking CTA for consultations

**Service Categories**
1.  **Operations Consulting**
    *   Community architecture
    *   Nonprofit management
    *   Business development
    *   Process optimization

2.  **SaaS Products**
    *   Custom solutions
    *   Automation technologies
    *   Integration platforms

3.  **Resources**
    *   Templates
    *   Frameworks
    *   Tools
    *   Educational content

### 6.4. About Page

**Detailed Bio**
*   Comprehensive background
*   Professional journey
*   Key achievements and milestones

**Roles & Responsibilities**
*   Executive Director of HigherSelf Network
*   Operations Architect for The 7 Space
*   Operations Architect for A.M. Consulting

**Skills & Expertise**
*   Full-stack development
*   Automation technologies
*   SaaS architecture
*   Community building
*   Nonprofit management

### 6.5. Contact Page

**Contact Form**
*   Name, email, subject, message fields
*   Submit button
*   Success/error messaging

**Contact Information**
*   Email address
*   Social media links
*   Location (if applicable)

**Booking Integration**
*   Embedded Amelia booking widget
*   "Schedule a Consultation" CTA

## 7. Responsive Design

The website will be fully responsive, adapting to different screen sizes and devices.

### 7.1. Breakpoints

| Breakpoint | Width | Device Type |
|------------|-------|-------------|
| Mobile | < 768px | Smartphones |
| Tablet | 768px - 1024px | Tablets |
| Desktop | 1024px - 1440px | Laptops |
| Large Desktop | > 1440px | Desktop monitors |

### 7.2. Mobile Considerations

*   Hamburger menu for navigation
*   Stacked layouts for multi-column sections
*   Larger touch targets for buttons and links
*   Optimized images for faster loading

## 8. Animations & Interactions

### 8.1. Scroll Animations

*   Fade-in animations for sections as they enter the viewport
*   Parallax effects for hero sections (subtle)
*   Smooth scroll behavior

### 8.2. Hover Effects

*   Button hover states with color change and elevation
*   Card hover states with elevation and slight scale
*   Link hover states with color change

### 8.3. Loading States

*   Skeleton screens for content loading
*   Progress indicators for form submissions
*   Smooth transitions between states

## 9. Accessibility

### 9.1. WCAG AA Compliance

*   Minimum contrast ratio of 4.5:1 for text
*   Keyboard navigation support
*   ARIA labels for interactive elements
*   Alt text for all images

### 9.2. Focus States

```css
*:focus {
  outline: 2px solid var(--accent-primary);
  outline-offset: 2px;
}
```

## 10. Performance Optimization

### 10.1. Image Optimization

*   WebP format with fallbacks
*   Lazy loading for images below the fold
*   Responsive images with srcset

### 10.2. Code Optimization

*   Minified CSS and JavaScript
*   Critical CSS inlined
*   Deferred loading for non-critical scripts

### 10.3. Caching

*   Browser caching for static assets
*   CDN for asset delivery

## 11. Elementor Implementation Guide

### 11.1. Global Settings

1.  **Theme Style**: Set to "Dark" in Elementor settings
2.  **Global Colors**: Add all color palette colors as global colors
3.  **Global Fonts**: Set up Inter for headings and body, Fira Code for code
4.  **Container Width**: 1200px max-width for content

### 11.2. Creating Reusable Templates

1.  **Header Template**: Create a header template with logo and navigation
2.  **Footer Template**: Create a footer template with links and copyright
3.  **Hero Section Template**: Create a reusable hero section template
4.  **Card Template**: Create a reusable card template for projects and services

### 11.3. Custom CSS

Add the CSS custom properties and component styles to the Elementor custom CSS section or in a child theme's style.css file.

## 12. Next Steps

1.  Set up WordPress and Elementor locally
2.  Install required plugins (Elementor Pro, WooCommerce, Amelia)
3.  Import color palette and typography settings
4.  Create page templates in Elementor
5.  Build out individual pages
6.  Test responsiveness and accessibility
7.  Optimize for performance
8.  Deploy to staging environment
9.  Final testing and QA
10. Deploy to production

## 13. References

*   [1] Dark Mode Design Research (`/home/ubuntu/dark-mode-design-research.md`)
*   [2] Material Design Dark Theme Guidelines (https://m2.material.io/design/color/dark-theme.html)
*   [3] Apple Human Interface Guidelines (https://developer.apple.com/design/human-interface-guidelines/)

