<?php
namespace Sheehan\CPT;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DOMAIN: "Services" — custom post type, no ACF available, with no public
 * URL of its own (cards expand inline on the Home/Services accordion — they
 * are never links; only "Neurological Continence Care" gets a real
 * standalone page, a plain WordPress Page at /services/neurological-continence-care
 * (a child of the Services Page), unrelated to this CPT's permalink). All
 * fields are plain WordPress post meta edited via a classic meta box:
 * numeric display priority (also
 * inline-editable from the admin list table), a pre-defined icon key, a
 * short description, one or two labelled "what we provide" bullet lists
 * (the second is optional, for a card covering two audiences), and a
 * featured flag (promotes the post to the "Our specialty" card).
 */
class ServicesPostType {

	const POST_TYPE = 'service';

	public static function register() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
		add_action( 'save_post_' . self::POST_TYPE, array( __CLASS__, 'save_meta' ) );
		add_filter( 'manage_' . self::POST_TYPE . '_posts_columns', array( __CLASS__, 'admin_columns' ) );
		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', array( __CLASS__, 'render_admin_column' ), 10, 2 );
		add_filter( 'manage_edit-' . self::POST_TYPE . '_sortable_columns', array( __CLASS__, 'sortable_admin_columns' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'sort_admin_list_by_priority' ) );
		// Rewrite rules only need flushing once per activation (individual
		// service post URLs 404 under /services/ until they are) — doing it
		// here means an editor never has to know to visit Settings → Permalinks.
		add_action( 'after_switch_theme', array( __CLASS__, 'flush_rewrites_once' ) );
		add_action( 'wp_ajax_sheehan_update_service_priority', array( __CLASS__, 'ajax_update_priority' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_list_inline_script' ) );
		// Services have no free-form body copy (every field is structured meta), so the
		// block editor's empty canvas is dropped — the classic editor renders the meta
		// box as one continuous form right under the title instead of a collapsed
		// accordion below an unused content area.
		add_filter( 'use_block_editor_for_post_type', array( __CLASS__, 'disable_block_editor' ), 10, 2 );
	}

	public static function disable_block_editor( $use_block_editor, $post_type ) {
		return self::POST_TYPE === $post_type ? false : $use_block_editor;
	}

	/**
	 * Priority must be unique across all services (it's the only thing that
	 * controls display order — a tie would make two cards fight for the same
	 * slot). If the requested value is already taken by another service,
	 * bumps it up to the next free integer instead of silently allowing the
	 * clash. Server-side only — enforced here and in the AJAX handler below,
	 * never trusted from client input alone.
	 */
	private static function resolve_unique_priority( $requested, $post_id ) {
		global $wpdb;
		$taken = $wpdb->get_col( $wpdb->prepare(
			"SELECT pm.meta_value FROM {$wpdb->postmeta} pm
			 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			 WHERE pm.meta_key = '_service_priority' AND p.post_type = %s AND p.ID != %d AND p.post_status != 'trash'",
			self::POST_TYPE,
			$post_id
		) );
		$taken = array_map( 'intval', $taken );
		$priority = $requested;
		while ( in_array( $priority, $taken, true ) ) {
			$priority++;
		}
		return $priority;
	}

	/** Powers the inline-editable Priority column below — lets an editor change priority without opening each post. */
	public static function ajax_update_priority() {
		check_ajax_referer( 'sheehan_service_priority' );
		$post_id  = intval( $_POST['post_id'] ?? 0 );
		if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_send_json_error( 'forbidden', 403 );
		}
		$priority = self::resolve_unique_priority( intval( $_POST['priority'] ?? 10 ), $post_id );
		update_post_meta( $post_id, '_service_priority', $priority );
		wp_send_json_success( array( 'priority' => $priority ) );
	}

	/** Tiny inline script (no separate .js file needed for one field) that saves priority via AJAX on change, on the Services list screen only. */
	public static function admin_list_inline_script( $hook ) {
		global $post_type;
		if ( 'edit.php' !== $hook || self::POST_TYPE !== $post_type ) {
			return;
		}
		$nonce = wp_create_nonce( 'sheehan_service_priority' );
		wp_add_inline_script( 'jquery-core', "
			jQuery(function($){
				$(document).on('change', '.sheehan-priority-input', function(){
					var input = $(this);
					$.post(ajaxurl, {
						action: 'sheehan_update_service_priority',
						_ajax_nonce: '{$nonce}',
						post_id: input.data('post-id'),
						priority: input.val()
					}).done(function(res){
						input.css('background', '#e6f7ee');
						if (res && res.data && res.data.priority !== undefined && String(res.data.priority) !== input.val()) {
							input.val(res.data.priority);
							input.css('background', '#fff3cd');
						}
					}).fail(function(){ input.css('background', '#fde8e8'); });
				});
			});
		" );
	}

	public static function flush_rewrites_once() {
		self::register_post_type();
		flush_rewrite_rules();
	}

	/** Adds a sortable "Priority" and "Featured" column to the Services admin list table, so priority can be reviewed/reordered without opening each post. */
	public static function admin_columns( $columns ) {
		$new = array();
		foreach ( $columns as $key => $label ) {
			$new[ $key ] = $label;
			if ( 'title' === $key ) {
				$new['service_priority'] = __( 'Priority', 'sheehan-health' );
				$new['service_featured'] = __( 'Featured', 'sheehan-health' );
			}
		}
		return $new;
	}

	public static function render_admin_column( $column, $post_id ) {
		if ( 'service_priority' === $column ) {
			$priority = get_post_meta( $post_id, '_service_priority', true );
			printf(
				'<input type="number" class="sheehan-priority-input" data-post-id="%d" value="%s" style="width:60px">',
				$post_id,
				esc_attr( '' !== $priority ? $priority : '10' )
			);
		} elseif ( 'service_featured' === $column ) {
			echo '1' === get_post_meta( $post_id, '_service_featured', true ) ? '★' : '—';
		}
	}

	public static function sortable_admin_columns( $columns ) {
		$columns['service_priority'] = 'service_priority';
		return $columns;
	}

	public static function sort_admin_list_by_priority( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() || self::POST_TYPE !== $query->get( 'post_type' ) ) {
			return;
		}
		if ( 'service_priority' === $query->get( 'orderby' ) ) {
			$query->set( 'meta_key', '_service_priority' );
			$query->set( 'orderby', 'meta_value_num' );
		}
	}

	public static function register_post_type() {
		register_post_type( self::POST_TYPE, array(
			'labels'       => array(
				'name'          => __( 'Services', 'sheehan-health' ),
				'singular_name' => __( 'Service', 'sheehan-health' ),
				'add_new_item'  => __( 'Add New Service', 'sheehan-health' ),
				'edit_item'     => __( 'Edit Service', 'sheehan-health' ),
			),
			'public'          => false,
			'publicly_queryable' => false,
			'show_ui'         => true,
			'has_archive'     => false,
			'rewrite'         => false,
			'menu_icon'       => 'dashicons-heart',
			'menu_position'   => 5,
			'show_in_menu'    => true,
			'capability_type' => 'post',
			'supports'        => array( 'title', 'thumbnail' ),
			'show_in_rest'    => true,
		) );
	}

	public static function add_meta_box() {
		add_meta_box(
			'sheehan_service_details',
			__( 'Service Details', 'sheehan-health' ),
			array( __CLASS__, 'render_meta_box' ),
			self::POST_TYPE,
			'normal',
			'high'
		);
	}

	public static function render_meta_box( $post ) {
		wp_nonce_field( 'sheehan_service_save', 'sheehan_service_nonce' );
		$priority   = get_post_meta( $post->ID, '_service_priority', true );
		if ( '' === $priority ) {
			// New service, no priority saved yet — default to "next in line"
			// (current published count + 1) instead of a fixed 10, so services
			// are added in registration order without the editor doing the maths.
			$priority = wp_count_posts( self::POST_TYPE )->publish + 1;
		}
		$icon       = get_post_meta( $post->ID, '_service_icon', true );
		$short_desc = get_post_meta( $post->ID, '_service_short_desc', true );
		$bullets    = get_post_meta( $post->ID, '_service_bullets', true );
		$featured   = get_post_meta( $post->ID, '_service_featured', true );
		$icons      = \Sheehan\Templates\service_icon_options();
		?>
		<p>
			<label><strong><?php esc_html_e( 'Description', 'sheehan-health' ); ?></strong></label><br>
			<textarea name="service_short_desc" rows="4" style="width:100%"><?php echo esc_textarea( $short_desc ); ?></textarea>
		</p>
		<p>
			<label><strong><?php esc_html_e( 'Bullet list heading', 'sheehan-health' ); ?></strong></label><br>
			<input type="text" name="service_bullets_label" value="<?php echo esc_attr( get_post_meta( $post->ID, '_service_bullets_label', true ) ?: 'Service includes:' ); ?>" style="width:100%">
		</p>
		<p>
			<label><strong><?php esc_html_e( 'Bullet points - one per line', 'sheehan-health' ); ?></strong></label><br>
			<textarea name="service_bullets" rows="6" style="width:100%"><?php echo esc_textarea( is_array( $bullets ) ? implode( "\n", $bullets ) : $bullets ); ?></textarea>
		</p>
		<p>
			<label><strong><?php esc_html_e( 'Card icon', 'sheehan-health' ); ?></strong></label><br>
			<span style="color:#666;font-size:12px"><?php esc_html_e( 'Pick the icon that best matches this service - shown in the top-left of the card.', 'sheehan-health' ); ?></span>
			<div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:8px;max-width:520px">
				<?php foreach ( $icons as $key => $svg ) : $checked = ( $icon === $key ); ?>
					<label style="display:flex;flex-direction:column;align-items:center;gap:4px;width:70px;padding:8px 4px;border:2px solid <?php echo $checked ? '#219aa8' : '#ddd'; ?>;border-radius:8px;cursor:pointer;background:<?php echo $checked ? '#eaf6f7' : '#fff'; ?>">
						<input type="radio" name="service_icon" value="<?php echo esc_attr( $key ); ?>" <?php checked( $checked ); ?> style="margin:0">
						<span style="color:#219aa8"><?php echo $svg; ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</p>
		<p>
			<label><strong><?php esc_html_e( 'Order on the page', 'sheehan-health' ); ?></strong></label><br>
			<span style="color:#666;font-size:12px"><?php esc_html_e( 'Lower number shows first. Must be unique - if another service already uses this number, it will be bumped up automatically on save.', 'sheehan-health' ); ?></span><br>
			<input type="number" name="service_priority" value="<?php echo esc_attr( $priority ); ?>" style="width:100px">
		</p>
		<p>
			<label>
				<input type="checkbox" name="service_featured" value="1" <?php checked( $featured, '1' ); ?>>
				<strong><?php esc_html_e( 'Feature this service (shown as the highlighted "Our specialty" card instead of the grid)', 'sheehan-health' ); ?></strong>
			</label>
		</p>
		<p style="border-top:1px solid #ddd;padding-top:12px;margin-top:8px">
			<label><strong><?php esc_html_e( 'Second bullet list (optional - only if this card covers two audiences)', 'sheehan-health' ); ?></strong></label><br>
			<span style="color:#666;font-size:12px"><?php esc_html_e( 'Leave both fields below blank if not needed.', 'sheehan-health' ); ?></span>
		</p>
		<p>
			<label><?php esc_html_e( 'Second list heading', 'sheehan-health' ); ?></label><br>
			<input type="text" name="service_bullets2_label" value="<?php echo esc_attr( get_post_meta( $post->ID, '_service_bullets2_label', true ) ); ?>" style="width:100%">
		</p>
		<p>
			<label><?php esc_html_e( 'Second list bullet points - one per line', 'sheehan-health' ); ?></label><br>
			<?php $bullets2 = get_post_meta( $post->ID, '_service_bullets2', true ); ?>
			<textarea name="service_bullets2" rows="4" style="width:100%"><?php echo esc_textarea( is_array( $bullets2 ) ? implode( "\n", $bullets2 ) : $bullets2 ); ?></textarea>
		</p>
		<?php
	}

	public static function save_meta( $post_id ) {
		if ( ! isset( $_POST['sheehan_service_nonce'] ) || ! wp_verify_nonce( $_POST['sheehan_service_nonce'], 'sheehan_service_save' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$priority = self::resolve_unique_priority( intval( $_POST['service_priority'] ?? 10 ), $post_id );
		update_post_meta( $post_id, '_service_priority', $priority );
		update_post_meta( $post_id, '_service_icon', sanitize_key( $_POST['service_icon'] ?? '' ) );
		update_post_meta( $post_id, '_service_short_desc', sanitize_textarea_field( $_POST['service_short_desc'] ?? '' ) );
		$bullets = array_filter( array_map( 'trim', explode( "\n", (string) ( $_POST['service_bullets'] ?? '' ) ) ) );
		update_post_meta( $post_id, '_service_bullets', array_map( 'sanitize_text_field', $bullets ) );
		update_post_meta( $post_id, '_service_bullets_label', sanitize_text_field( $_POST['service_bullets_label'] ?? 'Service includes:' ) );
		update_post_meta( $post_id, '_service_bullets2_label', sanitize_text_field( $_POST['service_bullets2_label'] ?? '' ) );
		$bullets2 = array_filter( array_map( 'trim', explode( "\n", (string) ( $_POST['service_bullets2'] ?? '' ) ) ) );
		update_post_meta( $post_id, '_service_bullets2', array_map( 'sanitize_text_field', $bullets2 ) );
		update_post_meta( $post_id, '_service_featured', isset( $_POST['service_featured'] ) ? '1' : '0' );
	}

	/** Published services ordered by priority — consumed by template-parts/home/services.php and the Services page. Pass posts_per_page to cap the homepage feed. */
	public static function get_ordered( $args = array() ) {
		$query = new \WP_Query( array_merge( array(
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => -1,
			'meta_key'       => '_service_priority',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		), $args ) );
		return $query->posts;
	}

	/** The single post marked "Featured" (lowest priority if more than one is flagged), or null. */
	public static function get_featured() {
		$posts = self::get_ordered( array(
			'posts_per_page' => 1,
			'meta_query'     => array( array( 'key' => '_service_featured', 'value' => '1' ) ),
		) );
		return $posts ? $posts[0] : null;
	}
}
