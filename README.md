# Sheehan Health — WordPress Theme

Custom WordPress theme for the Sheehan Health homepage.

## Structure (domain-driven)

```
functions.php                 theme bootstrap
inc/config/Domain.php         getDomain() + external URLs (referral form, socials)
inc/config/Redirects.php      central old-URL → new-URL map (301s)
inc/cpt/ServicesPostType.php  "Services" CPT — native meta (no ACF)
inc/settings/                 Settings API — Content Options page (texts + Media Library images)
inc/integrations/Analytics.php    GA4 + Meta Pixel (<head>)
inc/integrations/GooglePlaces.php Google reviews, fetched server-side, API key never exposed
inc/template-tags.php         icon map, checkmark svg, theme_image_url() helper
page-templates/services.php   "Services Page" template — assign to a real WP Page
page-templates/neurological-continence-care.php  standalone page for the one service with its own URL
template-parts/home/*         one file per homepage section
template-parts/global/*       floating CTA + contact popup (used in footer.php)
assets/css/style.css          all visual styling
assets/js/main.js             all interactivity (nav, accordion, hero animation, popup, parallax…)
assets/js/head-boot.js        no-JS failsafe, inlined in <head> before first paint
assets/images/placeholder-*   striped placeholders shown until real images are uploaded
```

## Required plugins

- **Contact Form 7** — the popup form renders `[contact-form-7 id="bacfd9e"]`.
  Configure the 4 fields (Full name, E-mail, Phone, Message) and SMTP
  (Gmail, Force From Email) in CF7 itself.
- Any SMTP plugin (WP Mail SMTP, etc.) for the Gmail relay.

## First-time setup (wp-admin)

1. **Pages → Add Page** — create a page titled "Home" (any content, it's
   unused) and set it as the static front page in **Settings → Reading**
   ("Your homepage displays" → "A static page" → Home). WordPress still
   renders `front-page.php`'s custom design regardless — this step only
   gives Home a real Page entry so SEO/analytics plugins can attach to it.
2. **Pages → Add Page** — create a page titled "Services", slug
   `services`, and set **Template → Services Page** in the page attributes
   panel. Then add "Neurological Continence Care" as a **child page of
   Services** (Page Attributes → Parent → Services), slug
   `neurological-continence-care`, **Template → Neurological Continence
   Care** — this makes it live at `/services/neurological-continence-care`.
   Do the same for "About" (slug `about`, **Template → About Page**), and
   "Contact Us" (slug `contact-us`, **Template → Contact Page**). Do the
   same for FAQ (slug `faq`) using the default template, then fill in its
   content normally — it isn't a custom-designed page, just a plain
   WordPress page the nav links to.
3. **Appearance → Content Options → General** — enter phone numbers,
   custom domain (if needed), the site-wide logo, GA/Meta Pixel IDs
   (pre-filled with sensible defaults), Google Places API key + Place ID,
   and social/review links. The browser tab icon is set separately via
   WordPress's native **Settings → General → Site Icon**.
4. **Appearance → Content Options → Home** — enter the credentials-bar
   text (service location, business hours) and upload the homepage images
   (banner signature, wordmark, referral background photo, NDIS seal, 4
   accreditation logos). Until uploaded, each shows a striped placeholder
   labelled with what goes there.
5. **Appearance → Content Options → Services** — the tab covers both the Services page banner and every Neurological Continence Care section (banner, section headings, all 9 condition cards, all 4 "how we can help" cards, bottom CTA) — all pre-filled with the approved copy.
6. **Services** (left admin menu) — add each service; "Display priority"
   controls homepage order, "Featured" promotes one to the "Our specialty"
   card. Until any Services post exists, the homepage shows sized
   placeholder cards instead.
7. **Posts** — the 3 most recent published posts feed the homepage Blog
   section automatically; until any post is published, sized placeholder
   cards are shown.
8. **Settings → Permalinks** — resave once after activation so post URLs
   and the Services page work.

## Link map (already wired)

- "Make a Referral" / "Access Full Referral Form" (hero, floating CTA,
  referral band) → `https://sheehanhealth.snapforms.com.au/form/referral-form`
- "Book a Consult" → links to the Contact Us page (`/contact-us`)
- Footer Facebook / Instagram / Google Reviews icons → Content Options →
  General → Social & Reviews Links
- Footer e-mail icon → `getDomain() + '/contact-us'`
- Nav links → `getDomain() + '/about'`, `/services`, `/blog`, `/faq`,
  `/contact-us` etc. — edit the `$nav_items` array in `header.php` if a
  slug differs from what's live. "Neurological Continence Care" isn't a
  top-level nav item — it's reached via the featured card on Home/Services
  at `/services/neurological-continence-care`.
