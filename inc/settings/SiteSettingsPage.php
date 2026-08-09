<?php
namespace Sheehan\Settings;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DOMAIN: Content Options — Settings API page (no ACF). Covers all
 * site text and images that would otherwise be hardcoded: contact details,
 * the credentials-bar copy, third-party IDs, and every image selected
 * from the WordPress Media Library.
 */
class SiteSettingsPage {

	const OPTION_GROUP = 'sheehan_settings';
	const PAGE_SLUG     = 'sheehan-theme-options';

	public static function tabs() {
		return array(
			'general'  => __( 'General', 'sheehan-health' ),
			'home'     => __( 'Home', 'sheehan-health' ),
			'about'    => __( 'About', 'sheehan-health' ),
			'services' => __( 'Services', 'sheehan-health' ),
			'blog'     => __( 'Blog', 'sheehan-health' ),
			'faq'      => __( 'FAQ', 'sheehan-health' ),
			'contact'  => __( 'Contact Us', 'sheehan-health' ),
			'careers'  => __( 'Join Our Clinical Team', 'sheehan-health' ),
		);
	}

	/** Section id => [tab, label]. Sitewide content (nav/footer/popup/integrations) lives under "General"; homepage-only content lives under "Home", grouped by the section it appears in. */
	public static function sections() {
		return array(
			'contact'           => array( 'tab' => 'general', 'label' => __( 'Contact & Site Info', 'sheehan-health' ) ),
			'images_global'     => array( 'tab' => 'general', 'label' => __( 'Site-wide Images', 'sheehan-health' ) ),
			'integrations'      => array( 'tab' => 'general', 'label' => __( 'Integrations', 'sheehan-health' ) ),
			'social'            => array( 'tab' => 'general', 'label' => __( 'Social & Reviews Links', 'sheehan-health' ) ),
			'home_hero'         => array( 'tab' => 'home', 'label' => __( 'Hero', 'sheehan-health' ) ),
			'home_services'     => array( 'tab' => 'home', 'label' => __( 'Services', 'sheehan-health' ) ),
			'home_referral'     => array( 'tab' => 'home', 'label' => __( 'Referral CTA', 'sheehan-health' ) ),
			'home_why'          => array( 'tab' => 'home', 'label' => __( 'Why Choose Us', 'sheehan-health' ) ),
			'home_blog'         => array( 'tab' => 'home', 'label' => __( 'Blog', 'sheehan-health' ) ),
			'home_testimonials' => array( 'tab' => 'home', 'label' => __( 'Testimonials', 'sheehan-health' ) ),
			'images_home'       => array( 'tab' => 'home', 'label' => __( 'Homepage Images', 'sheehan-health' ) ),
			'about_banner'      => array( 'tab' => 'about', 'label' => __( 'Page Banner', 'sheehan-health' ) ),
			'about_story'       => array( 'tab' => 'about', 'label' => __( 'Story / Expertise / Approach', 'sheehan-health' ) ),
			'about_founders'    => array( 'tab' => 'about', 'label' => __( 'Meet Our Founders', 'sheehan-health' ) ),
			'about_cta'         => array( 'tab' => 'about', 'label' => __( 'Bottom CTA', 'sheehan-health' ) ),
			'services_banner'   => array( 'tab' => 'services', 'label' => __( 'Services Page Banner', 'sheehan-health' ) ),
			'ncc_banner'        => array( 'tab' => 'services', 'label' => __( 'Neurological Continence Care - Page Banner', 'sheehan-health' ) ),
			'ncc_sections'      => array( 'tab' => 'services', 'label' => __( 'Neurological Continence Care - Section Headings', 'sheehan-health' ) ),
			'ncc_conditions'    => array( 'tab' => 'services', 'label' => __( 'Neurological Continence Care - Condition Cards', 'sheehan-health' ) ),
			'ncc_support'       => array( 'tab' => 'services', 'label' => __( 'Neurological Continence Care - "How We Can Help" Cards', 'sheehan-health' ) ),
			'ncc_cta'           => array( 'tab' => 'services', 'label' => __( 'Neurological Continence Care - Bottom CTA', 'sheehan-health' ) ),
			// Prepared ahead of the future Contact Us page — also covers the popup shown site-wide today.
			'contact_popup'     => array( 'tab' => 'contact', 'label' => __( 'Contact Popup', 'sheehan-health' ) ),
			'faq_banner'       => array( 'tab' => 'faq', 'label' => __( 'Page Banner', 'sheehan-health' ) ),
			'faq_categories'    => array( 'tab' => 'faq', 'label' => __( 'Questions', 'sheehan-health' ) ),
			'blog_banner'       => array( 'tab' => 'blog', 'label' => __( 'Page Banner', 'sheehan-health' ) ),
			'contact_banner'    => array( 'tab' => 'contact', 'label' => __( 'Page Banner', 'sheehan-health' ) ),
			'contact_info'      => array( 'tab' => 'contact', 'label' => __( 'Info Cards', 'sheehan-health' ) ),
			'contact_form'      => array( 'tab' => 'contact', 'label' => __( 'Form Section', 'sheehan-health' ) ),
			'contact_help'      => array( 'tab' => 'contact', 'label' => __( 'How We Can Help', 'sheehan-health' ) ),
			'contact_steps'     => array( 'tab' => 'contact', 'label' => __( 'What to Expect', 'sheehan-health' ) ),
			'careers_banner'    => array( 'tab' => 'careers', 'label' => __( 'Page Banner', 'sheehan-health' ) ),
			'careers_benefits'  => array( 'tab' => 'careers', 'label' => __( 'Benefits Cards', 'sheehan-health' ) ),
			'careers_form'      => array( 'tab' => 'careers', 'label' => __( 'Application Form Section', 'sheehan-health' ) ),
		);
	}

	public static function fields() {
		return array(
			// -- General tab: Contact & Site Info (sitewide) ---------------
			array( 'id' => 'sheehan_phone_display', 'label' => 'Phone number', 'desc' => 'Shown in the footer, e.g. "0123 456 789".', 'section' => 'contact', 'type' => 'text', 'default' => '0452 536 347' ),
			array( 'id' => 'sheehan_phone_tel', 'label' => 'Phone number for calls', 'desc' => 'Dial format for mobile tap-to-call, e.g. +61123456789.', 'section' => 'contact', 'type' => 'text', 'default' => '+61452536347' ),
			array( 'id' => 'sheehan_domain_override', 'label' => 'Custom domain', 'desc' => 'Advanced - only fill in to force a different domain than the current one, otherwise leave blank.', 'section' => 'contact', 'type' => 'text', 'default' => '' ),
			// -- General tab: Site-wide Images -------------------------------
			array( 'id' => 'sheehan_logo_nav', 'label' => 'Nav logo', 'desc' => 'Cursive signature only, used in the top menu. Shown white automatically.', 'section' => 'images_global', 'type' => 'image' ),
			array( 'id' => 'sheehan_logo_footer', 'label' => 'Footer logo', 'desc' => 'Signature + "Nurse Consultancy" text, used in the footer. Shown white automatically.', 'section' => 'images_global', 'type' => 'image' ),
			// -- General tab: Integrations (sitewide) -----------------------
			array( 'id' => 'sheehan_ga_id', 'label' => 'Google Analytics ID', 'desc' => 'Your GA4 measurement ID.', 'section' => 'integrations', 'type' => 'text', 'default' => 'G-EMP6WLNHMV' ),
			array( 'id' => 'sheehan_meta_pixel_id', 'label' => 'Meta Pixel ID', 'desc' => 'Used for Facebook/Instagram ad tracking.', 'section' => 'integrations', 'type' => 'text', 'default' => '1076524434707182' ),
			array( 'id' => 'sheehan_google_places_api_key', 'label' => 'Google Places API key', 'desc' => 'Fetches Google reviews for Testimonials. Server-side only.', 'section' => 'integrations', 'type' => 'password' ),
			array( 'id' => 'sheehan_google_place_id', 'label' => 'Google Place ID', 'desc' => 'Identifies your business listing (used with the API key above).', 'section' => 'integrations', 'type' => 'text' ),
			// -- General tab: Social & Reviews Links (sitewide, shown in footer) --
			array( 'id' => 'sheehan_facebook_url', 'label' => 'Facebook page URL', 'desc' => 'Footer Facebook icon link.', 'section' => 'social', 'type' => 'text', 'default' => 'https://www.facebook.com/sheehanhealth.com.au/' ),
			array( 'id' => 'sheehan_instagram_url', 'label' => 'Instagram page URL', 'desc' => 'Footer Instagram icon link.', 'section' => 'social', 'type' => 'text', 'default' => 'https://www.instagram.com/sheehan_health/' ),
			array( 'id' => 'sheehan_google_reviews_url', 'label' => 'Google Reviews page URL', 'desc' => 'Footer Google icon link.', 'section' => 'social', 'type' => 'text', 'default' => '' ),
			// -- Home tab: Hero -----------------------------------------------
			array( 'id' => 'sheehan_hero_heading_1', 'label' => 'Heading - line 1', 'desc' => '', 'section' => 'home_hero', 'type' => 'text', 'default' => 'Person-centred' ),
			array( 'id' => 'sheehan_hero_heading_2', 'label' => 'Heading - line 2', 'desc' => 'Always shown emphasised.', 'section' => 'home_hero', 'type' => 'text', 'default' => 'specialist' ),
			array( 'id' => 'sheehan_hero_heading_3', 'label' => 'Heading - line 3', 'desc' => '', 'section' => 'home_hero', 'type' => 'text', 'default' => 'nursing care' ),
			array( 'id' => 'sheehan_hero_lead', 'label' => 'Supporting text', 'desc' => '', 'section' => 'home_hero', 'type' => 'textarea', 'default' => 'A boutique team of AHPRA-registered nurse consultants, supporting NDIS participants across NSW with quiet expertise, genuine care, and a truly person-centred approach to every consultation, home visit, and care plan we thoughtfully provide.' ),
			array( 'id' => 'sheehan_hero_btn_referral', 'label' => 'Button - referral', 'desc' => '', 'section' => 'home_hero', 'type' => 'text', 'default' => 'Make a Referral' ),
			array( 'id' => 'sheehan_hero_btn_consult', 'label' => 'Button - consult', 'desc' => '', 'section' => 'home_hero', 'type' => 'text', 'default' => 'Book a Consult' ),
			array( 'id' => 'sheehan_address_label', 'label' => 'Service location', 'desc' => 'Shown in the credentials bar.', 'section' => 'home_hero', 'type' => 'text', 'default' => 'Sydney, NSW  •  Australia-wide Telehealth' ),
			array( 'id' => 'sheehan_hours_label', 'label' => 'Business hours', 'desc' => 'Shown in the credentials bar.', 'section' => 'home_hero', 'type' => 'text', 'default' => 'Mon–Fri, 8am–5pm' ),
			// -- Home tab: Services --------------------------------------------
			array( 'id' => 'sheehan_services_eyebrow', 'label' => 'Eyebrow', 'desc' => '', 'section' => 'home_services', 'type' => 'text', 'default' => 'Our services' ),
			array( 'id' => 'sheehan_services_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to emphasise it.', 'section' => 'home_services', 'type' => 'text', 'default' => 'Clinical services built around *you*' ),
			array( 'id' => 'sheehan_services_subtext', 'label' => 'Subtext', 'desc' => '', 'section' => 'home_services', 'type' => 'textarea', 'default' => 'A full continence and clinical care service, delivered by AHPRA-registered nurses across the NDIS.' ),
			array( 'id' => 'sheehan_services_cta', 'label' => 'Button label', 'desc' => '', 'section' => 'home_services', 'type' => 'text', 'default' => 'View all services' ),
			// -- Home tab: Referral CTA -----------------------------------------
			array( 'id' => 'sheehan_referral_eyebrow', 'label' => 'Eyebrow', 'desc' => '', 'section' => 'home_referral', 'type' => 'text', 'default' => 'Referrals' ),
			array( 'id' => 'sheehan_referral_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to emphasise it.', 'section' => 'home_referral', 'type' => 'text', 'default' => 'Access the *Referral Form*' ),
			array( 'id' => 'sheehan_referral_body', 'label' => 'Body text', 'desc' => '', 'section' => 'home_referral', 'type' => 'textarea', 'default' => 'Simple, fast and confidential. We accept referrals from plan coordinators, support workers, GPs and families.' ),
			array( 'id' => 'sheehan_referral_cta', 'label' => 'Button label', 'desc' => '', 'section' => 'home_referral', 'type' => 'text', 'default' => 'Access Full Referral Form' ),
			// -- Home tab: Why Choose Us ----------------------------------------
			array( 'id' => 'sheehan_why_eyebrow', 'label' => 'Eyebrow', 'desc' => '', 'section' => 'home_why', 'type' => 'text', 'default' => 'Why choose us' ),
			array( 'id' => 'sheehan_why_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to emphasise it.', 'section' => 'home_why', 'type' => 'text', 'default' => 'The Sheehan Health *difference*' ),
			array( 'id' => 'sheehan_why_1_title', 'label' => 'Card 1 - title', 'desc' => '', 'section' => 'home_why', 'type' => 'text', 'default' => 'Person-Centred Care' ),
			array( 'id' => 'sheehan_why_1_desc', 'label' => 'Card 1 - text', 'desc' => '', 'section' => 'home_why', 'type' => 'textarea', 'default' => 'Every care plan is tailored around the individual, not a one-size-fits-all approach.' ),
			array( 'id' => 'sheehan_why_2_title', 'label' => 'Card 2 - title', 'desc' => '', 'section' => 'home_why', 'type' => 'text', 'default' => 'Evidence-Based Practice' ),
			array( 'id' => 'sheehan_why_2_desc', 'label' => 'Card 2 - text', 'desc' => '', 'section' => 'home_why', 'type' => 'textarea', 'default' => 'Clinical decisions grounded in current best-practice guidelines and research.' ),
			array( 'id' => 'sheehan_why_3_title', 'label' => 'Card 3 - title', 'desc' => '', 'section' => 'home_why', 'type' => 'text', 'default' => 'Local Community' ),
			array( 'id' => 'sheehan_why_3_desc', 'label' => 'Card 3 - text', 'desc' => '', 'section' => 'home_why', 'type' => 'textarea', 'default' => 'Specialists serving St George & Sutherland Shire, NSW · Telehealth Australia-wide for 20+ years.' ),
			array( 'id' => 'sheehan_why_4_title', 'label' => 'Card 4 - title', 'desc' => '', 'section' => 'home_why', 'type' => 'text', 'default' => 'Telehealth Nationwide' ),
			array( 'id' => 'sheehan_why_4_desc', 'label' => 'Card 4 - text', 'desc' => '', 'section' => 'home_why', 'type' => 'textarea', 'default' => 'Remote consultations available across all of Australia.' ),
			// -- Home tab: Blog --------------------------------------------------
			array( 'id' => 'sheehan_blog_eyebrow', 'label' => 'Eyebrow', 'desc' => '', 'section' => 'home_blog', 'type' => 'text', 'default' => 'Latest articles' ),
			array( 'id' => 'sheehan_blog_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to emphasise it.', 'section' => 'home_blog', 'type' => 'text', 'default' => 'From the *Sheehan Health* blog' ),
			array( 'id' => 'sheehan_blog_subtext', 'label' => 'Subtext', 'desc' => '', 'section' => 'home_blog', 'type' => 'textarea', 'default' => 'Practical insights on NDIS, continence care, wound management and living well.' ),
			array( 'id' => 'sheehan_blog_cta', 'label' => 'Button label', 'desc' => '', 'section' => 'home_blog', 'type' => 'text', 'default' => 'View all articles' ),
			// -- Home tab: Testimonials ------------------------------------------
			array( 'id' => 'sheehan_testimonials_eyebrow', 'label' => 'Eyebrow', 'desc' => '', 'section' => 'home_testimonials', 'type' => 'text', 'default' => 'Testimonials' ),
			array( 'id' => 'sheehan_testimonials_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to emphasise it.', 'section' => 'home_testimonials', 'type' => 'text', 'default' => 'What families & coordinators *say*' ),
			// -- Home tab: Homepage Images ------------------------------------
			array( 'id' => 'sheehan_hero_bg_photo', 'label' => 'Hero background photo', 'desc' => 'Optional photo behind the banner gradient.', 'section' => 'images_home', 'type' => 'image' ),
			array( 'id' => 'sheehan_hero_signature_img', 'label' => 'Hero signature', 'desc' => 'The large animated "Sheehan Health" cursive image.', 'section' => 'images_home', 'type' => 'image' ),
			array( 'id' => 'sheehan_hero_consultancy_img', 'label' => 'Hero "Nurse Consultancy" wordmark', 'desc' => 'Settles in under the signature once it finishes animating.', 'section' => 'images_home', 'type' => 'image' ),
			array( 'id' => 'sheehan_referral_bg_img', 'label' => 'Referral section background photo', 'desc' => '', 'section' => 'images_home', 'type' => 'image' ),
			array( 'id' => 'sheehan_ndis_badge_img', 'label' => 'NDIS seal', 'desc' => 'Badge next to the Services heading.', 'section' => 'images_home', 'type' => 'image' ),
			array( 'id' => 'sheehan_affiliation_1_img', 'label' => 'Accreditation logo - APNA', 'desc' => '', 'section' => 'images_home', 'type' => 'image' ),
			array( 'id' => 'sheehan_affiliation_2_img', 'label' => 'Accreditation logo - AHPRA', 'desc' => '', 'section' => 'images_home', 'type' => 'image' ),
			array( 'id' => 'sheehan_affiliation_3_img', 'label' => 'Accreditation logo - Continence Foundation of Australia', 'desc' => '', 'section' => 'images_home', 'type' => 'image' ),
			array( 'id' => 'sheehan_affiliation_4_img', 'label' => 'Accreditation logo - NDIS Registered Provider', 'desc' => '', 'section' => 'images_home', 'type' => 'image' ),
			// -- Services tab: Page Banner -------------------------------------
			array( 'id' => 'sheehan_services_page_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'services_banner', 'type' => 'text', 'default' => 'Specialist nursing for *every stage* of care' ),
			array( 'id' => 'sheehan_services_page_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'services_banner', 'type' => 'textarea', 'default' => "Our boutique team of clinicians provides specialised continence services, specialist nursing and education tailored to each person's individual needs. Through evidence-based practice and close collaboration with clients, families and healthcare professionals, we deliver practical support that promotes health, independence and quality of life." ),
			array( 'id' => 'sheehan_services_bg_img', 'label' => 'Banner background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'services_banner', 'type' => 'image' ),
			// -- Services tab: Neurological Continence Care - Page Banner -----
			array( 'id' => 'sheehan_ncc_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'ncc_banner', 'type' => 'text', 'default' => 'Neurological *Continence Care*' ),
			array( 'id' => 'sheehan_ncc_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'ncc_banner', 'type' => 'textarea', 'default' => 'Sheehan Health provides specialist continence care for people whose bladder or bowel function is affected by a neurological condition. These conditions can interrupt the nerve signals between the brain, spinal cord and bladder or bowel, leading to issues such as urgency, incomplete emptying, loss of sensation or difficulty knowing when you need to go. Because the cause is neurological, management looks different too, built around the specific condition, not just the symptom.' ),
			array( 'id' => 'sheehan_ncc_bg_img', 'label' => 'Banner background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'ncc_banner', 'type' => 'image' ),
			// -- Services tab: Neurological Continence Care - Section Headings
			array( 'id' => 'sheehan_ncc_conditions_eyebrow', 'label' => 'Conditions section - eyebrow', 'desc' => '', 'section' => 'ncc_sections', 'type' => 'text', 'default' => 'Conditions' ),
			array( 'id' => 'sheehan_ncc_conditions_heading', 'label' => 'Conditions section - heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'ncc_sections', 'type' => 'text', 'default' => 'Conditions we *support*' ),
			array( 'id' => 'sheehan_ncc_conditions_subtext', 'label' => 'Conditions section - supporting text', 'desc' => '', 'section' => 'ncc_sections', 'type' => 'textarea', 'default' => 'Bladder and bowel symptoms can appear differently depending on the underlying neurological condition.' ),
			array( 'id' => 'sheehan_ncc_support_eyebrow', 'label' => '"How we support you" section - eyebrow', 'desc' => '', 'section' => 'ncc_sections', 'type' => 'text', 'default' => 'Getting support' ),
			array( 'id' => 'sheehan_ncc_support_heading', 'label' => '"How we support you" section - heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'ncc_sections', 'type' => 'text', 'default' => 'How we can *help*' ),
			// -- Services tab: Neurological Continence Care - Condition Cards -
			array( 'id' => 'sheehan_ncc_cond_1_name', 'label' => 'Card 1 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => 'Multiple sclerosis' ),
			array( 'id' => 'sheehan_ncc_cond_1_desc', 'label' => 'Card 1 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Where demyelination can disrupt the nerve pathways controlling bladder and bowel function.' ),
			array( 'id' => 'sheehan_ncc_cond_2_name', 'label' => 'Card 2 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => "Parkinson's disease" ),
			array( 'id' => 'sheehan_ncc_cond_2_desc', 'label' => 'Card 2 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Where bladder symptoms often emerge or worsen as motor symptoms progress.' ),
			array( 'id' => 'sheehan_ncc_cond_3_name', 'label' => 'Card 3 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => 'Spinal cord injury' ),
			array( 'id' => 'sheehan_ncc_cond_3_desc', 'label' => 'Card 3 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Where the location and severity of the injury determines the pattern of bladder and bowel involvement.' ),
			array( 'id' => 'sheehan_ncc_cond_4_name', 'label' => 'Card 4 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => 'Spina bifida' ),
			array( 'id' => 'sheehan_ncc_cond_4_desc', 'label' => 'Card 4 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Present from birth, affecting the nerve pathways that control bladder and bowel function.' ),
			array( 'id' => 'sheehan_ncc_cond_5_name', 'label' => 'Card 5 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => 'Acquired brain injury' ),
			array( 'id' => 'sheehan_ncc_cond_5_desc', 'label' => 'Card 5 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Where the area affected can change awareness of bladder and bowel needs, not just control over them.' ),
			array( 'id' => 'sheehan_ncc_cond_6_name', 'label' => 'Card 6 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => 'Stroke' ),
			array( 'id' => 'sheehan_ncc_cond_6_desc', 'label' => 'Card 6 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Where bladder control is often affected in the early stages and can improve significantly with rehabilitation.' ),
			array( 'id' => 'sheehan_ncc_cond_7_name', 'label' => 'Card 7 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => 'Cerebral palsy' ),
			array( 'id' => 'sheehan_ncc_cond_7_desc', 'label' => 'Card 7 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Where bladder and bowel function is affected differently depending on the type and severity of motor involvement.' ),
			array( 'id' => 'sheehan_ncc_cond_8_name', 'label' => 'Card 8 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => "Huntington's disease" ),
			array( 'id' => 'sheehan_ncc_cond_8_desc', 'label' => 'Card 8 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Where bladder and bowel control is often affected alongside movement and cognition as it progresses.' ),
			array( 'id' => 'sheehan_ncc_cond_9_name', 'label' => 'Card 9 - name', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'text', 'default' => 'Motor neurone disease' ),
			array( 'id' => 'sheehan_ncc_cond_9_desc', 'label' => 'Card 9 - text', 'desc' => '', 'section' => 'ncc_conditions', 'type' => 'textarea', 'default' => 'Where bowel function can be affected as much as bladder function, particularly as mobility and muscle control decline.' ),
			// -- Services tab: Neurological Continence Care - "How We Can Help" Cards --
			array( 'id' => 'sheehan_ncc_supp_1_title', 'label' => 'Card 1 - title', 'desc' => '', 'section' => 'ncc_support', 'type' => 'text', 'default' => 'Comprehensive Continence Assessments' ),
			array( 'id' => 'sheehan_ncc_supp_1_desc', 'label' => 'Card 1 - text', 'desc' => '', 'section' => 'ncc_support', 'type' => 'textarea', 'default' => 'Neurological conditions affect bladder and bowel function differently to non-neurological causes, so assessment needs to look beyond the bladder or bowel itself. Our Clinical Nurse Consultants assess how your specific condition is affecting function, forming the basis for a management plan built around it.' ),
			array( 'id' => 'sheehan_ncc_supp_2_title', 'label' => 'Card 2 - title', 'desc' => '', 'section' => 'ncc_support', 'type' => 'text', 'default' => 'Neurogenic Bladder & Bowel Management' ),
			array( 'id' => 'sheehan_ncc_supp_2_desc', 'label' => 'Card 2 - text', 'desc' => '', 'section' => 'ncc_support', 'type' => 'textarea', 'default' => 'We review and adjust your management plan as your condition changes, working with your care team, including specialists such as neurologists, urologists and gastroenterologists where relevant. Neurogenic bladder and bowel function rarely stays the same for long, so a plan set once needs to keep evolving.' ),
			array( 'id' => 'sheehan_ncc_supp_3_title', 'label' => 'Card 3 - title', 'desc' => '', 'section' => 'ncc_support', 'type' => 'text', 'default' => 'Urinary Catheter Management (IDC, SPC & ISC)' ),
			array( 'id' => 'sheehan_ncc_supp_3_desc', 'label' => 'Card 3 - text', 'desc' => '', 'section' => 'ncc_support', 'type' => 'textarea', 'default' => 'Catheter use, whether indwelling, suprapubic or intermittent self-catheterisation, becomes more common when bladder function is affected by a neurological condition. We provide ongoing, evidence-based care that adapts as your needs change, helping prevent infection and maintain comfort.' ),
			array( 'id' => 'sheehan_ncc_supp_4_title', 'label' => 'Card 4 - title', 'desc' => '', 'section' => 'ncc_support', 'type' => 'text', 'default' => 'NDIS Continence Reports & Funding Support' ),
			array( 'id' => 'sheehan_ncc_supp_4_desc', 'label' => 'Card 4 - text', 'desc' => '', 'section' => 'ncc_support', 'type' => 'textarea', 'default' => 'Documenting continence supports for NDIS funding gets harder when the underlying cause is neurological, the connection between diagnosis and daily impact both need to be captured clearly. Our reports address the reasonable and necessary criteria with detail specific to your condition.' ),
			// -- Services tab: Neurological Continence Care - Bottom CTA ------
			array( 'id' => 'sheehan_ncc_cta_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'ncc_cta', 'type' => 'text', 'default' => 'Ready to talk to a clinician who understands *your condition*?' ),
			array( 'id' => 'sheehan_ncc_cta_body', 'label' => 'Body text', 'desc' => '', 'section' => 'ncc_cta', 'type' => 'textarea', 'default' => 'Access the Referral Form or Contact Us - our clinical team responds promptly to every enquiry.' ),
			array( 'id' => 'sheehan_ncc_cta_bg_img', 'label' => 'Background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'ncc_cta', 'type' => 'image' ),
			// -- Contact tab: Contact Popup -------------------------------------
			array( 'id' => 'sheehan_contact_popup_eyebrow', 'label' => 'Eyebrow', 'desc' => '', 'section' => 'contact_popup', 'type' => 'text', 'default' => 'Get in touch' ),
			array( 'id' => 'sheehan_contact_popup_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to emphasise it; put a line break where the second line should start.', 'section' => 'contact_popup', 'type' => 'textarea', 'default' => "How can we\n*help you?*" ),
			array( 'id' => 'sheehan_contact_popup_sub', 'label' => 'Supporting text', 'desc' => '', 'section' => 'contact_popup', 'type' => 'textarea', 'default' => 'Ask a question or request more information. We reply within 1 business day.' ),
			// -- Blog tab: Page Banner ------------------------------------------
			array( 'id' => 'sheehan_blog_page_heading', 'label' => 'Heading', 'desc' => '', 'section' => 'blog_banner', 'type' => 'text', 'default' => 'From the Sheehan Health Blog' ),
			array( 'id' => 'sheehan_blog_page_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'blog_banner', 'type' => 'textarea', 'default' => 'Practical insights on NDIS, continence care, wound management and specialist nursing.' ),
			array( 'id' => 'sheehan_blog_bg_img', 'label' => 'Banner background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'blog_banner', 'type' => 'image' ),
			// -- FAQ tab: Page Banner ------------------------------------------
			array( 'id' => 'sheehan_faq_heading', 'label' => 'Heading', 'desc' => '', 'section' => 'faq_banner', 'type' => 'text', 'default' => 'Frequently Asked Questions' ),
			array( 'id' => 'sheehan_faq_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'faq_banner', 'type' => 'textarea', 'default' => "Answers to common questions about our specialist nursing services, appointments, NDIS reports and Telehealth. Can't find what you're looking for? Get in touch and we'll help." ),
			array( 'id' => 'sheehan_faq_bg_img', 'label' => 'Banner background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'faq_banner', 'type' => 'image' ),
			// -- FAQ tab: Questions --------------------------------------------
			// Each category is one field: a title, then one "Q: ...\nA: ..." pair
			// per question, blank line between pairs. Kept as a single textarea
			// per category (24 questions total) rather than one field per
			// question - a dedicated CPT would be overkill for fixed FAQ copy.
			array( 'id' => 'sheehan_faq_cat_1_title', 'label' => 'Category 1 - title', 'desc' => '', 'section' => 'faq_categories', 'type' => 'text', 'default' => 'Specialist Nursing Services' ),
			array( 'id' => 'sheehan_faq_cat_1_body', 'label' => 'Category 1 - questions (Q: / A: pairs, blank line between each)', 'desc' => '', 'section' => 'faq_categories', 'type' => 'textarea', 'default' =>
"Q: What does Sheehan Health do?
A: Sheehan Health provides specialist Clinical Nurse Consultant (CNC)-led nursing services for people with continence concerns, bladder and bowel dysfunction, urinary catheters, wounds, diabetes and complex disability-related health needs. We provide comprehensive assessments, clinical recommendations and education to improve independence, dignity, health outcomes and quality of life.

Q: Who does Sheehan Health support?
A: We primarily support adolescents and adults living with disability, neurological conditions, chronic health conditions and complex care needs. Many of our clients are NDIS participants, although we also provide services to private clients, aged care providers, families and organisations seeking specialist nursing advice.

Q: What services does Sheehan Health provide?
A: Our services include continence assessments, bladder and bowel management, urinary catheter management, complex nursing assessments, pressure injury and wound management, diabetes management, NDIS clinical reports and funding recommendations, telehealth consultations.

Q: Why do I need a clinical nurse consultant?
A: A Clinical Nurse Consultant (CNC) is an experienced Registered Nurse with advanced qualifications and specialist expertise. While Registered Nurses provide excellent day-to-day clinical care, CNCs focus on comprehensive assessments, complex clinical decision-making and developing evidence-based management plans. They also work closely with GPs, specialists and multidisciplinary teams, and prepare detailed reports to support ongoing healthcare planning and, where appropriate, NDIS funding applications.

Q: Can you recommend continence products?
A: Yes. We assess each person's individual needs and recommend suitable continence products based on their continence status, lifestyle, mobility, skin integrity and personal goals. As an independent consultancy, we provide unbiased clinical recommendations and can assist with product trials where available." ),
			array( 'id' => 'sheehan_faq_cat_2_title', 'label' => 'Category 2 - title', 'desc' => '', 'section' => 'faq_categories', 'type' => 'text', 'default' => 'Appointments and Getting Started' ),
			array( 'id' => 'sheehan_faq_cat_2_body', 'label' => 'Category 2 - questions (Q: / A: pairs, blank line between each)', 'desc' => '', 'section' => 'faq_categories', 'type' => 'textarea', 'default' =>
"Q: Do I need a referral?
A: No formal referral is required. We accept referrals from clients, family members, support coordinators, GPs, specialists, hospitals, allied health professionals and care providers. Our referral form helps us collect the information needed to ensure your assessment is appropriate and efficient.

Q: How do I make an appointment?
A: Simply contact our office or complete our referral form. Once we receive your information, we'll review your needs and arrange an appointment with the most appropriate clinician. You'll receive confirmation by phone and email before your appointment.

Q: Can I book an urgent appointment?
A: Yes. All referrals are clinically triaged according to urgency. Where there has been a significant change in health, continence, catheter function or skin integrity, we will make every effort to prioritise an appointment.

Q: What happens at the appointment?
A: Your Clinical Nurse Consultant will complete a comprehensive assessment, including your medical history, medications, bladder and bowel function, mobility, skin integrity, current supports and personal goals. Where appropriate, we also review bladder diaries, bowel charts, wound documentation and specialist reports to develop individualised recommendations.

Q: What should I bring to my appointment?
A: A medication list, bladder/bowel charts, recent hospital letters, continence products and previous reports.

Q: Can my family member or support worker attend?
A: Yes. We encourage family members, carers, support workers and Support Coordinators to attend appointments where appropriate and with the client's consent. Their input often provides valuable information and helps ensure everyone understands the recommendations." ),
			array( 'id' => 'sheehan_faq_cat_3_title', 'label' => 'Category 3 - title', 'desc' => '', 'section' => 'faq_categories', 'type' => 'text', 'default' => 'NDIS and Clinical Reports' ),
			array( 'id' => 'sheehan_faq_cat_3_body', 'label' => 'Category 3 - questions (Q: / A: pairs, blank line between each)', 'desc' => '', 'section' => 'faq_categories', 'type' => 'textarea', 'default' =>
"Q: Do I need to be an NDIS participant?
A: No. While most of our clients are NDIS participants, we also provide services to private clients, aged care providers and organisations requiring specialist nursing assessments or education.

Q: Do you complete NDIS reports?
A: Yes. We prepare comprehensive Clinical Nurse Consultant reports to assess continence and complex nursing needs, provide evidence-based recommendations and support access to reasonable and necessary NDIS funding. Reports are tailored to each participant and aligned with current NDIS legislation and best practice.

Q: Can you support funding reviews?
A: Yes. We regularly assist participants and Support Coordinators by reviewing existing supports, identifying changing clinical needs and preparing updated recommendations to support plan reviews, reassessments and change of circumstances requests.

Q: Are you an NDIS Registered Provider?
A: Yes. Sheehan Health has been a Registered NDIS Provider since 2019 and complies with the NDIS Practice Standards and Quality & Safeguards Commission requirements." ),
			array( 'id' => 'sheehan_faq_cat_4_title', 'label' => 'Category 4 - title', 'desc' => '', 'section' => 'faq_categories', 'type' => 'text', 'default' => 'Telehealth and Locations' ),
			array( 'id' => 'sheehan_faq_cat_4_body', 'label' => 'Category 4 - questions (Q: / A: pairs, blank line between each)', 'desc' => '', 'section' => 'faq_categories', 'type' => 'textarea', 'default' =>
"Q: Where does Sheehan Health provide services?
A: We provide mobile Clinical Nurse Consultant services throughout Sydney, Wollongong and surrounding regions. Telehealth consultations are available Australia-wide where clinically appropriate.

Q: Do you offer Telehealth?
A: Yes. We provide secure Telehealth consultations via Zoom, Microsoft Teams or telephone where clinically appropriate. Telehealth is ideal for follow-up reviews, education, NDIS report assessments, continence reviews and support for families, carers and multidisciplinary teams. If a hands-on assessment is required, we'll discuss this before your appointment." ),
			// -- Contact tab: Page Banner ------------------------------------------
			array( 'id' => 'sheehan_contact_heading', 'label' => 'Heading', 'desc' => '', 'section' => 'contact_banner', 'type' => 'text', 'default' => 'Get in Touch' ),
			array( 'id' => 'sheehan_contact_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'contact_banner', 'type' => 'textarea', 'default' => "Whether you're looking for specialised nursing support, would like to make a referral, or simply have a question about our services, we're here to help. Complete the contact form below or get in touch using the details provided. Our team will respond as soon as possible and help guide you to the right support." ),
			array( 'id' => 'sheehan_contact_bg_img', 'label' => 'Banner background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'contact_banner', 'type' => 'image' ),
			// -- Contact tab: Info Cards --------------------------------------------
			array( 'id' => 'sheehan_contact_info_1_body', 'label' => 'Phone card - note', 'desc' => 'Phone number itself comes from General - Contact & Site Info.', 'section' => 'contact_info', 'type' => 'text', 'default' => 'Speak directly with our team during business hours.' ),
			array( 'id' => 'sheehan_contact_info_2_body', 'label' => 'Email card - note', 'desc' => 'Email address itself comes from General - Contact & Site Info.', 'section' => 'contact_info', 'type' => 'text', 'default' => 'Send us your enquiry anytime.' ),
			array( 'id' => 'sheehan_contact_info_3_body', 'label' => 'Service Areas card - text', 'desc' => '', 'section' => 'contact_info', 'type' => 'textarea', 'default' => 'In-home services across Sydney, NSW, with Telehealth available Australia-wide.' ),
			array( 'id' => 'sheehan_contact_info_4_title', 'label' => 'Business Hours card - hours', 'desc' => '', 'section' => 'contact_info', 'type' => 'text', 'default' => 'Monday - Friday' ),
			array( 'id' => 'sheehan_contact_info_4_body', 'label' => 'Business Hours card - note', 'desc' => '', 'section' => 'contact_info', 'type' => 'text', 'default' => 'Contact us to discuss availability.' ),
			// -- Contact tab: Form Section ------------------------------------------
			array( 'id' => 'sheehan_contact_form_heading', 'label' => 'Heading', 'desc' => '', 'section' => 'contact_form', 'type' => 'text', 'default' => 'Send Us a Message' ),
			array( 'id' => 'sheehan_contact_form_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'contact_form', 'type' => 'text', 'default' => 'Fill out the form below and one of our team members will be in touch as soon as possible.' ),
			// -- Contact tab: How We Can Help ---------------------------------------
			array( 'id' => 'sheehan_contact_help_heading', 'label' => 'Heading', 'desc' => '', 'section' => 'contact_help', 'type' => 'text', 'default' => 'How We Can Help' ),
			array( 'id' => 'sheehan_contact_help_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'contact_help', 'type' => 'textarea', 'default' => "Whether you're a client, family member, support coordinator or healthcare professional, we're here to help with:" ),
			array( 'id' => 'sheehan_contact_help_bullets', 'label' => 'Bullets - one per line', 'desc' => '', 'section' => 'contact_help', 'type' => 'textarea', 'default' => "General enquiries about our nursing services\nNDIS referrals and support\nClinical assessments and nursing support\nTelehealth consultations\nQuestions about the most appropriate service for your needs" ),
			// -- Contact tab: What to Expect -----------------------------------------
			array( 'id' => 'sheehan_contact_steps_heading', 'label' => 'Heading', 'desc' => '', 'section' => 'contact_steps', 'type' => 'text', 'default' => 'What to Expect' ),
			array( 'id' => 'sheehan_contact_step_1_title', 'label' => 'Step 1 - title', 'desc' => '', 'section' => 'contact_steps', 'type' => 'text', 'default' => "We'll review your enquiry." ),
			array( 'id' => 'sheehan_contact_step_1_body', 'label' => 'Step 1 - text', 'desc' => '', 'section' => 'contact_steps', 'type' => 'textarea', 'default' => 'Our team will carefully review your message and ensure it reaches the most appropriate clinician.' ),
			array( 'id' => 'sheehan_contact_step_2_title', 'label' => 'Step 2 - title', 'desc' => '', 'section' => 'contact_steps', 'type' => 'text', 'default' => "We'll get in touch." ),
			array( 'id' => 'sheehan_contact_step_2_body', 'label' => 'Step 2 - text', 'desc' => '', 'section' => 'contact_steps', 'type' => 'textarea', 'default' => "We'll contact you to discuss your needs, answer your questions and talk you through the next steps." ),
			array( 'id' => 'sheehan_contact_step_3_title', 'label' => 'Step 3 - title', 'desc' => '', 'section' => 'contact_steps', 'type' => 'text', 'default' => "We'll guide you from there." ),
			array( 'id' => 'sheehan_contact_step_3_body', 'label' => 'Step 3 - text', 'desc' => '', 'section' => 'contact_steps', 'type' => 'textarea', 'default' => "Whether you're seeking ongoing nursing support, an assessment or professional advice, we'll help you understand your options and recommend the most appropriate pathway." ),
			// -- About tab: Page Banner ------------------------------------------
			array( 'id' => 'sheehan_about_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'about_banner', 'type' => 'text', 'default' => 'Expert clinical care, delivered with a *personal* approach' ),
			array( 'id' => 'sheehan_about_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'about_banner', 'type' => 'textarea', 'default' => 'Founded in 2018 by Registered Nurses Tracy and Phil Sheehan, Sheehan Health Nurse Consultancy brings together more than 30 years of specialist nursing experience with a genuine commitment to providing expert, individualised care.' ),
			array( 'id' => 'sheehan_about_bg_img', 'label' => 'Banner background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'about_banner', 'type' => 'image' ),
			// -- About tab: Story / Expertise / Approach --------------------------
			array( 'id' => 'sheehan_about_story_title', 'label' => 'Story - title', 'desc' => '', 'section' => 'about_story', 'type' => 'text', 'default' => 'Our Story' ),
			array( 'id' => 'sheehan_about_story_body', 'label' => 'Story - text', 'desc' => '', 'section' => 'about_story', 'type' => 'textarea', 'default' => "Throughout her nursing career, Tracy saw how often clinical care became more about processes than people. Together, Tracy and Phil founded Sheehan Health to create a boutique nurse consultancy where clinical expertise, time and genuine relationships remain at the centre of every client's care. Their vision was simple: a small, experienced clinical team supporting people from their first assessment onward." ),
			array( 'id' => 'sheehan_about_expertise_title', 'label' => 'Expertise - title', 'desc' => '', 'section' => 'about_story', 'type' => 'text', 'default' => 'Our Expertise' ),
			array( 'id' => 'sheehan_about_expertise_body', 'label' => 'Expertise - text', 'desc' => '', 'section' => 'about_story', 'type' => 'textarea', 'default' => 'Today, Sheehan Health Nurse Consultancy is a Registered NDIS Provider delivering specialised community nursing and continence services across Sydney, with Telehealth consultations available Australia-wide. Our team works closely with clients, families, GPs, specialists, support coordinators and allied health professionals, providing nursing assessments, NDIS reports and practical recommendations shaped around each person\'s needs.' ),
			array( 'id' => 'sheehan_about_approach_title', 'label' => 'Approach - title', 'desc' => '', 'section' => 'about_story', 'type' => 'text', 'default' => 'Our Approach' ),
			array( 'id' => 'sheehan_about_approach_body', 'label' => 'Approach - text', 'desc' => '', 'section' => 'about_story', 'type' => 'textarea', 'default' => "While our experience shapes everything we do, it's our approach that defines us. Before recommending anything, we take the time to understand each person's circumstances, not just their diagnosis, but their daily life. That's what a personalised assessment means to us: not a checklist, but a conversation that shapes independent, evidence-based advice. It's how every client leaves feeling informed and confident about what comes next." ),
			// -- About tab: Meet Our Founders -------------------------------------
			array( 'id' => 'sheehan_about_founders_eyebrow', 'label' => 'Section eyebrow', 'desc' => '', 'section' => 'about_founders', 'type' => 'text', 'default' => 'Our Team' ),
			array( 'id' => 'sheehan_about_founders_heading', 'label' => 'Section heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'about_founders', 'type' => 'text', 'default' => 'Meet Our *Founders*' ),
			array( 'id' => 'sheehan_about_founders_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'about_founders', 'type' => 'text', 'default' => 'A word from the people leading your care.' ),
			array( 'id' => 'sheehan_about_founder_1_photo', 'label' => 'Founder 1 - photo', 'desc' => '', 'section' => 'about_founders', 'type' => 'image' ),
			array( 'id' => 'sheehan_about_founder_1_name', 'label' => 'Founder 1 - name', 'desc' => '', 'section' => 'about_founders', 'type' => 'text', 'default' => 'Tracy Sheehan RN MPH' ),
			array( 'id' => 'sheehan_about_founder_1_body', 'label' => 'Founder 1 - bio', 'desc' => '', 'section' => 'about_founders', 'type' => 'textarea', 'default' => 'With more than 30 years of nursing experience, Tracy has worked across emergency care, intensive care, mental health, research, clinical consultancy and community nursing. She holds a Bachelor of Nursing, a Master of Public Health and postgraduate qualifications in continence care. At Sheehan Health, Tracy leads the clinical services of the consultancy, providing comprehensive assessments, clinical reports and evidence-based recommendations to support clients with a wide range of complex health needs.' ),
			array( 'id' => 'sheehan_about_founder_2_photo', 'label' => 'Founder 2 - photo', 'desc' => '', 'section' => 'about_founders', 'type' => 'image' ),
			array( 'id' => 'sheehan_about_founder_2_name', 'label' => 'Founder 2 - name', 'desc' => '', 'section' => 'about_founders', 'type' => 'text', 'default' => 'Phil Sheehan RN' ),
			array( 'id' => 'sheehan_about_founder_2_body', 'label' => 'Founder 2 - bio', 'desc' => '', 'section' => 'about_founders', 'type' => 'textarea', 'default' => 'Phil is a Registered Nurse with a background in nursing leadership and management. Throughout his career, he has focused on the operational and organisational side of healthcare, bringing valuable experience in practice management and service coordination. At Sheehan Health, Phil oversees the day-to-day operations of the consultancy, helping ensure every client receives a professional, organised and seamless experience.' ),
			// -- About tab: Bottom CTA ---------------------------------------------
			array( 'id' => 'sheehan_about_cta_heading', 'label' => 'Heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'about_cta', 'type' => 'text', 'default' => "Let's find the right *support* for you" ),
			array( 'id' => 'sheehan_about_cta_body', 'label' => 'Supporting text', 'desc' => '', 'section' => 'about_cta', 'type' => 'textarea', 'default' => "Whether you're ready to get started or simply exploring your options, we're here to help." ),
			array( 'id' => 'sheehan_about_cta_bg_img', 'label' => 'Background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'about_cta', 'type' => 'image' ),
			// -- Careers tab: Page Banner -----------------------------------------
			array( 'id' => 'sheehan_careers_heading', 'label' => 'Heading', 'desc' => '', 'section' => 'careers_banner', 'type' => 'text', 'default' => 'Join Our Clinical Team' ),
			array( 'id' => 'sheehan_careers_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'careers_banner', 'type' => 'textarea', 'default' => "The people around us are the best thing about our profession. We're looking for experienced multidisciplinary clinicians who share our values to join us in delivering person-centred nursing care." ),
			array( 'id' => 'sheehan_careers_bg_img', 'label' => 'Banner background photo', 'desc' => 'Same treatment as the Referral CTA background.', 'section' => 'careers_banner', 'type' => 'image' ),
			// -- Careers tab: Benefits Cards ---------------------------------------
			array( 'id' => 'sheehan_careers_benefits_eyebrow', 'label' => 'Section eyebrow', 'desc' => '', 'section' => 'careers_benefits', 'type' => 'text', 'default' => 'Why Sheehan Health' ),
			array( 'id' => 'sheehan_careers_benefits_heading', 'label' => 'Section heading', 'desc' => 'Wrap a word in *asterisks* to show it emphasised.', 'section' => 'careers_benefits', 'type' => 'text', 'default' => 'Why clinicians choose to *work with us*' ),
			array( 'id' => 'sheehan_careers_benefit_1_title', 'label' => 'Benefit 1 - title', 'desc' => '', 'section' => 'careers_benefits', 'type' => 'text', 'default' => 'Person-centred practice' ),
			array( 'id' => 'sheehan_careers_benefit_1_body', 'label' => 'Benefit 1 - text', 'desc' => '', 'section' => 'careers_benefits', 'type' => 'textarea', 'default' => 'Work alongside a boutique, like-minded team that values evidence-based, person-centred care above all else.' ),
			array( 'id' => 'sheehan_careers_benefit_2_title', 'label' => 'Benefit 2 - title', 'desc' => '', 'section' => 'careers_benefits', 'type' => 'text', 'default' => 'Flexible arrangements' ),
			array( 'id' => 'sheehan_careers_benefit_2_body', 'label' => 'Benefit 2 - text', 'desc' => '', 'section' => 'careers_benefits', 'type' => 'textarea', 'default' => 'Flexible scheduling and telehealth options that support a genuine, sustainable work-life balance.' ),
			array( 'id' => 'sheehan_careers_benefit_3_title', 'label' => 'Benefit 3 - title', 'desc' => '', 'section' => 'careers_benefits', 'type' => 'text', 'default' => 'Ongoing development' ),
			array( 'id' => 'sheehan_careers_benefit_3_body', 'label' => 'Benefit 3 - text', 'desc' => '', 'section' => 'careers_benefits', 'type' => 'textarea', 'default' => 'Access to clinical mentoring, professional development and a supportive multidisciplinary network.' ),
			// -- Careers tab: Application Form Section -----------------------------
			array( 'id' => 'sheehan_careers_form_eyebrow', 'label' => 'Section eyebrow', 'desc' => '', 'section' => 'careers_form', 'type' => 'text', 'default' => 'Expression of Interest' ),
			array( 'id' => 'sheehan_careers_form_heading', 'label' => 'Section heading', 'desc' => '', 'section' => 'careers_form', 'type' => 'text', 'default' => 'Send us your CV' ),
			array( 'id' => 'sheehan_careers_form_subtext', 'label' => 'Supporting text', 'desc' => '', 'section' => 'careers_form', 'type' => 'textarea', 'default' => "Fill in the form below and attach your resume. We'll be in touch if a suitable opportunity arises." ),
			array( 'id' => 'sheehan_careers_form_card_heading', 'label' => 'Form card - title', 'desc' => '', 'section' => 'careers_form', 'type' => 'text', 'default' => 'Expression of Interest' ),
			array( 'id' => 'sheehan_careers_form_card_body', 'label' => 'Form card - text', 'desc' => '', 'section' => 'careers_form', 'type' => 'textarea', 'default' => "Fill in the form below and attach your resume. We'll be in touch if a suitable opportunity arises." ),
		);
	}

	public static function register() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'settings' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_assets' ) );
	}

	public static function menu() {
		add_theme_page(
			__( 'Sheehan Health - Content Options', 'sheehan-health' ),
			__( 'Content Options', 'sheehan-health' ),
			'manage_options',
			self::PAGE_SLUG,
			array( __CLASS__, 'render_page' )
		);
	}

	public static function admin_assets( $hook ) {
		if ( 'appearance_page_' . self::PAGE_SLUG !== $hook ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script( 'sheehan-admin-settings', SHEEHAN_THEME_URI . '/assets/js/admin-settings.js', array( 'jquery' ), '1.0.0', true );
	}

	public static function settings() {
		$sections = self::sections();
		foreach ( self::fields() as $field ) {
			$tab      = $sections[ $field['section'] ]['tab'];
			if ( 'image' === $field['type'] ) {
				$sanitize = 'esc_url_raw';
			} elseif ( 'textarea' === $field['type'] ) {
				$sanitize = 'sanitize_textarea_field'; // preserves line breaks (sanitize_text_field strips them)
			} else {
				$sanitize = 'sanitize_text_field';
			}
			// Registered per-tab (not one shared group) — otherwise saving one
			// tab's form makes WordPress blank out every field that belongs to
			// a different tab, since options.php clears any registered option
			// not present in the submitted form.
			register_setting( self::OPTION_GROUP . '_' . $tab, $field['id'], array(
				'sanitize_callback' => $sanitize,
				'default'           => $field['default'] ?? '',
			) );
		}
		foreach ( $sections as $id => $section ) {
			add_settings_section( $id, $section['label'], '__return_false', self::PAGE_SLUG . '-' . $section['tab'] );
		}
		foreach ( self::fields() as $field ) {
			$tab = $sections[ $field['section'] ]['tab'];
			add_settings_field( $field['id'], $field['label'], array( __CLASS__, 'render_field' ), self::PAGE_SLUG . '-' . $tab, $field['section'], $field );
		}
	}

	public static function render_field( $field ) {
		// Same rule as the front-end opt() helper: an empty saved value falls
		// back to the registered default, so the admin field always shows
		// meaningful starting text instead of looking blank/broken.
		$value = get_option( $field['id'], '' );
		if ( '' === trim( (string) $value ) ) {
			$value = $field['default'] ?? '';
		}
		if ( 'image' === $field['type'] ) {
			?>
			<div class="sheehan-image-field">
				<input type="text" class="regular-text sheehan-image-url" name="<?php echo esc_attr( $field['id'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>" value="<?php echo esc_attr( $value ); ?>">
				<button type="button" class="button sheehan-select-image"><?php esc_html_e( 'Select from Media Library', 'sheehan-health' ); ?></button>
				<div class="sheehan-image-preview"><?php if ( $value ) : ?><img src="<?php echo esc_url( $value ); ?>" style="max-height:60px;margin-top:8px;display:block"><?php endif; ?></div>
			</div>
			<?php
		} elseif ( 'password' === $field['type'] ) {
			printf( '<input type="password" class="regular-text" autocomplete="new-password" name="%1$s" value="%2$s">', esc_attr( $field['id'] ), esc_attr( $value ) );
		} elseif ( 'textarea' === $field['type'] ) {
			printf( '<textarea class="large-text" rows="3" name="%1$s">%2$s</textarea>', esc_attr( $field['id'] ), esc_textarea( $value ) );
		} else {
			printf( '<input type="text" class="regular-text" name="%1$s" value="%2$s">', esc_attr( $field['id'] ), esc_attr( $value ) );
		}
		if ( ! empty( $field['desc'] ) ) {
			printf( '<p class="description">%s</p>', esc_html( $field['desc'] ) );
		}
	}

	public static function render_page() {
		$tabs        = self::tabs();
		$current_tab = isset( $_GET['tab'] ) && isset( $tabs[ $_GET['tab'] ] ) ? $_GET['tab'] : 'general';
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Sheehan Health - Content Options', 'sheehan-health' ); ?></h1>
			<h2 class="nav-tab-wrapper">
				<?php foreach ( $tabs as $key => $label ) : ?>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=' . self::PAGE_SLUG . '&tab=' . $key ) ); ?>" class="nav-tab<?php echo $current_tab === $key ? ' nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
				<?php endforeach; ?>
			</h2>
			<form method="post" action="options.php">
				<?php
				$has_fields = false;
				foreach ( self::sections() as $section ) {
					if ( $section['tab'] === $current_tab ) { $has_fields = true; break; }
				}
				if ( ! $has_fields ) :
					echo '<p>' . esc_html__( 'No editable content yet for this page - content will appear here once this page is built.', 'sheehan-health' ) . '</p>';
				else :
					settings_fields( self::OPTION_GROUP . '_' . $current_tab );
					do_settings_sections( self::PAGE_SLUG . '-' . $current_tab );
					submit_button();
				endif;
				?>
			</form>
		</div>
		<?php
	}
}
