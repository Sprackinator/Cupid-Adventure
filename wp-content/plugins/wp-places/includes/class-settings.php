<?php
/**
 * WP_Places Settings
 *
 * @since   NEXT
 * @package WP_Places
 */

require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';

/**
 * WP_Places Settings class.
 *
 * @since NEXT
 */
class WPP_Settings {

	/**
	 * Parent plugin class
	 *
	 * @var    class
	 * @since  NEXT
	 */
	protected $plugin = null;

	/**
	 * Option key, and option page slug
	 *
	 * @var    string
	 * @since  NEXT
	 */
	protected $key = 'wp_places_settings';

	/**
	 * Options page metabox id
	 *
	 * @var    string
	 * @since  NEXT
	 */
	protected $metabox_id = 'wp_places_settings_metabox';

	/**
	 * Options Page title
	 *
	 * @var    string
	 * @since  NEXT
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 *
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Saved options.
	 */
	public $options = '';

	/**
	 * Constructor
	 *
	 * @since  NEXT
	 *
	 * @param  object $plugin Main plugin object.
	 *
	 * @return void
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;
		$this->hooks();

		$this->legacy_update();

		$this->title   = __( 'WP_Places Settings', 'wp-places' );
		$this->options = get_option( 'wp_places_settings' );

	}

	/**
	 * Initiate our hooks
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
	}

	/**
	 * Register our setting to WP
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function admin_init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Check if this is an update and pass the setting on.
	 *
	 * @author Gary Kovar
	 *
	 * @since  2.0.0
	 *
	 * @return null
	 */
	public function legacy_update() {
		if ( ! get_option( 'wp_places_legacy' ) ) {
			$this->retrieve_old_settings();
			update_option( 'wp_places_legacy', true, true );
		}
	}

	/**
	 * if the old settings exist, retrieve and then delete them.
	 *
	 * @author Gary Kovar
	 *
	 * @since  2.0.0
	 *
	 * @return null
	 */
	public function retrieve_old_settings() {

		$old_setting[ 'google_places_api_key' ]   = get_option( 'WP_Places_Google_Id_Setting' );
		$old_setting[ 'powered_by_google_image' ] = get_option( 'WP_Places_Google_Attr_Setting_check' );
		$old_setting[ 'style' ]                   = get_option( 'WP_Places_CSS' );
		$old_setting[ 'show_div' ]                = get_option( 'WP_Places_Display_Div' );
		$old_setting[ 'post_types' ]			  = $this->selected_post_types();

		update_option( 'wp_places_settings', $old_setting );

		delete_option( 'WP_Places_Google_Id_Setting' );
		delete_option( 'WP_Places_Google_Attr_Setting_check' );
		delete_option( 'WP_Places_CSS' );
		delete_option( 'WP_Places_Display_Div' );


	}


	/**
	 * Add menu options page
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page(
			$this->title,
			$this->title,
			'manage_options',
			$this->key,
			array( $this, 'admin_page_display' )
		);

		// Include CMB CSS in the head to avoid FOUC.
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo esc_attr( $this->key ); ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Add custom fields to the options page.
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function add_options_page_metabox() {

		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove.
				'key'   => 'options-page',
				'value' => array( $this->key ),
			),
		) );

		$cmb->add_field( array(
			'name' => 'Google Places API Key',
			'id'   => 'google_places_api_key',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => 'Add the \'Powered by Google\' Image the Google TOS Requires:',
			'id'   => 'powered_by_google_image',
			'type' => 'checkbox',
		) );

		$cmb->add_field( array(
			'name' => 'Embed a div in content using the style below:',
			'id'   => 'show_div',
			'type' => 'checkbox',
		) );

		$cmb->add_field( array(
			'name' => 'WP_Places Style:',
			'id'   => 'style',
			'type' => 'textarea',
		) );

		$cmb->add_field( array(
			'name'              => 'Post Types:',
			'id'                => 'post_types',
			'type'              => 'multicheck',
			'options_cb'        => array( $this, 'get_post_types' ),
			'select_all_button' => true,
		) );

	}

	/**
	 * Get a list of posts-types and their display names.
	 *
	 * @return array of post-type slug as key and name as value
	 *
	 * @author Gary Kovar
	 *
	 * @since  2.0.0
	 */
	public function get_post_types() {

		$args = array(
			'public' => true,
		);

		$post_types = get_post_types( $args, 'objects' );

		foreach ( $post_types as $post_type ) {
			$posts_array[ $post_type->name ] = $post_type->labels->name;
		}

		return $posts_array;
	}

	/**
	 * Returns the google places api key.
	 *
	 * @author Gary Kovar
	 *
	 * @since  2.0.0
	 *
	 * @return string
	 */
	public function places_api_key() {

		if ( array_key_exists( 'google_places_api_key', $this->options ) ) {
			return $this->options[ 'google_places_api_key' ];
		}

		return null;

	}

	/**
	 * Returns an array of the post-types to allow places on.
	 *
	 * @author Gary Kovar
	 *
	 * @since  2.0.0
	 *
	 * @return array of post-type slugs
	 */
	public function selected_post_types() {

		if ( array_key_exists( 'post_types', $this->options ) && is_array( $this->options[ 'post_types' ] ) ) {
			return $this->options[ 'post_types' ];
		}

		return array( 'posts', 'pages' );

	}


	/**
	 * Returns whether or not to display the div.
	 *
	 * @author Gary Kovar
	 *
	 * @since  2.0.0
	 *
	 * @return $content
	 */
	public function embed_div() {

		if ( isset ($this->options['show_div']) ){

			return $this->options[ 'show_div' ];
		}

	}


	/**
	 * Returns embedded div.
	 *
	 * @author Gary Kovar
	 *
	 * @since  2.0.0
	 *
	 * @return $content
	 */
	public function get_div() {

		return $this->options[ 'style' ];

	}

	/**
	 * Returns embedded div.
	 *
	 * @author Gary Kovar
	 *
	 * @since  2.0.0
	 *
	 * @return $content
	 */
	public function get_powered_by_google() {

		return $this->options[ 'powered_by_google_image' ];

	}

	public function get_api_key() {
		return $this->options[ 'google_places_api_key' ];
	}

}
