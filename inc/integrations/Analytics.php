<?php
namespace Sheehan\Integrations;

if ( ! defined( 'ABSPATH' ) ) exit;

/** DOMAIN: Analytics — GA4 + Meta Pixel, IDs pulled from Content Options (pre-filled with sensible defaults). */
class Analytics {

	public static function register() {
		add_action( 'wp_head', array( __CLASS__, 'output' ), 5 );
	}

	public static function output() {
		$ga_id  = get_option( 'sheehan_ga_id', 'G-EMP6WLNHMV' );
		$pixel  = get_option( 'sheehan_meta_pixel_id', '1076524434707182' );

		if ( $ga_id ) :
			?>
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());
			  gtag('config', '<?php echo esc_js( $ga_id ); ?>');
			</script>
			<?php
		endif;

		if ( $pixel ) :
			?>
			<script>
			  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			  n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			  n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			  t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			  document,'script','https://connect.facebook.net/en_US/fbevents.js');
			  fbq('init', '<?php echo esc_js( $pixel ); ?>');
			  fbq('track', 'PageView');
			</script>
			<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo esc_attr( $pixel ); ?>&ev=PageView&noscript=1" alt=""></noscript>
			<?php
		endif;
	}
}
