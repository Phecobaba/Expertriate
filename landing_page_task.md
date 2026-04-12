# Landing Page Redesign Task Plan

Date: 2026-04-12
Project: Expert Traders landing pages
Scope: Homepage, About Us, FAQ, Contact, Testimonials
Constraint: Keep green + white as core colors, add a subtle gold accent

## Design Direction
- Visual theme: Trust-first, premium finance, clean and modern
- Color roles:
- Green = actions, confidence, navigation highlights
- White = readability, spacing, content surface
- Gold = premium accents only (badges, separators, key stats)
- UX goals:
- Improve mobile responsiveness
- Improve trust and clarity
- Reduce long text fatigue
- Increase CTA clarity without aggressive patterns

## Wireframe Outline (Desktop + Mobile)

## 1) Homepage Wireframe

### 1.1 Header and Top Navigation
Desktop:
- Top utility bar: welcome text (left), login/signup (right)
- Main nav: logo, Home, About, FAQ, Support, Terms, CTA button
- Sticky behavior after scroll

Mobile:
- Compact top bar (optional or hidden)
- Logo left, menu icon right
- Full-screen slide menu with primary links and CTA
- Persistent bottom floating CTA: "Get Started"

### 1.2 Hero Section
Desktop:
- Two-column layout
- Left: strong headline, one supporting paragraph, two CTAs
- Right: trust visual (product dashboard/device mockup or refined hero image)
- Mini trust row below CTA: secure, transparent, 24/7 support

Mobile:
- Single-column stacked layout
- Headline and CTA first
- Hero image below text
- Trust row converted to 2x2 badges

### 1.3 Credibility Strip
Desktop:
- Horizontal strip with 3-5 trust items:
- Security/Encryption
- Fast payouts
- Support availability
- Verified users/reviews

Mobile:
- Swipeable chips or 2-column icon grid

### 1.4 "How It Works" Section
Desktop:
- 4-step process cards in one row
- Numbered steps with simple icon and short copy

Mobile:
- Vertical timeline cards (Step 1 to Step 4)

### 1.5 Investment Packages Section
Desktop:
- Section intro + comparison cards
- Show 3 featured packages first, with "View all plans"
- Highlight 1 recommended plan using green border + soft gold badge
- Strong CTA on each card

Mobile:
- Cards in stacked format
- Recommended plan pinned near top
- Fixed bottom CTA when user reaches plan section

### 1.6 "Why Choose Us" Section
Desktop:
- 6 icon cards in 3x2 grid
- Short copy, no long paragraphs

Mobile:
- 2 cards per row or stacked carousel

### 1.7 Testimonials Section
Desktop:
- 3 testimonial cards + star rating + source hint
- Add "View all testimonials" CTA

Mobile:
- One-card slider with snap

### 1.8 FAQ Preview Section
Desktop:
- Left: short intro copy
- Right: accordion with 6-8 top questions
- Include "Go to full FAQ" button

Mobile:
- Full-width accordion
- Category filters as horizontal chips (Account, Plans, Payouts, Security)

### 1.9 Final CTA Section
Desktop:
- Clear conversion block with single message and dual CTA
- Background: subtle gradient using green-to-white and minimal gold divider

Mobile:
- Centered text + stacked CTA buttons

### 1.10 Footer
Desktop:
- 4-column footer: brand/about, quick links, support, legal + payment icons

Mobile:
- Accordion footer groups
- Legal links as compact row

## 2) About Us Page Wireframe

### 2.1 About Hero
Desktop:
- Page title + short credibility statement + breadcrumb

Mobile:
- Compact title + breadcrumb

### 2.2 Company Story
Desktop:
- Two-column layout: story copy + image/illustration

Mobile:
- Single-column with scannable blocks

### 2.3 Mission, Vision, Values
Desktop:
- 3 aligned cards

Mobile:
- Stacked cards

### 2.4 Operational Trust Section
Desktop:
- Security practices, payout process, risk policy summary
- 3 supporting stats with gold accent numbers

Mobile:
- Vertical stat cards

### 2.5 Final About CTA
Desktop and Mobile:
- "Start Investing" and "Contact Support" dual CTA block

## 3) FAQ Page Wireframe (Dedicated FAQ experience)

### 3.1 FAQ Hero + Search
Desktop:
- Page title + short intro + search bar + category chips

Mobile:
- Stacked title and search
- Horizontal scroll category chips

### 3.2 FAQ Content
Desktop:
- Two-column layout:
- Left sticky category list
- Right accordion answers

Mobile:
- Single-column accordion grouped by category

### 3.3 Support Escalation Block
Desktop and Mobile:
- "Still need help?" card with support email and contact CTA

## 4) Contact Page Wireframe
- Hero with support promise
- Contact cards (email, address, response time)
- Clean contact form with helper text and success state
- Mini FAQ strip at bottom

## 5) Testimonials Page Wireframe
- Intro headline with credibility framing
- Filter tags (new, most helpful, payouts, support)
- Masonry/card grid desktop, slider-stack mobile
- Verified badge styling using soft gold accent

## Task Backlog (Implementation Status)
- [x] Replace fixed viewport meta with mobile-responsive viewport
- [x] Rebuild header/nav structure for desktop + mobile
- [x] Redesign homepage hero and trust strip
- [x] Refactor package cards and recommended-plan emphasis
- [x] Redesign FAQ accordion with unique IDs and category grouping
- [x] Restructure About page into scannable modules
- [x] Redesign Contact and Testimonials pages to match new system
- [x] Consolidate styles into reusable classes and reduce excessive inline style dependence
- [x] Apply final green/white/gold visual polish and spacing system
- [x] QA desktop and mobile breakpoints before release
- [x] Upgrade ticker to show country flags and rotate placement across landing pages
- [x] Apply additional visual fixes (header strip removal, gold reasons styling, footer wording update)

## Next Tasks (Landing Page Fixes - No Code Yet)
- [x] Keep `Recommended` inline with `24/7 support` (no overlap/wrapping collision)
- [x] Normalize footer grid/box layout on desktop and mobile
- [x] Update ticker timing to random intervals of `7s`, `12s`, or `20s`
- [x] Replace generic investor label ("Someone") with random selection from a 100-name dataset
- [x] Fix ticker country flag rendering so flags display reliably on landing pages
- [x] Make ticker appear in the section the user is currently viewing
- [x] Make ticker text and amount styling bold for better visibility
