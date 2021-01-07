<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Publin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $publin    The ID of this plugin.
	 */
	private $publin;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $publin       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $publin, $version ) {

		$this->publin = $publin;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$handle = 'publin_custom_css';
		$page_id = get_the_ID();

		

		wp_enqueue_style( 'publin_framework', plugin_dir_url( __FILE__ ) . 'css/framework.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'publin_menu_variations', plugin_dir_url( __FILE__ ) . 'css/menu-variations.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->publin, plugin_dir_url( __FILE__ ) . 'css/publin-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( $handle, plugin_dir_url( __FILE__ ) . 'css/publin-custom.css', array(), $this->version, 'all' );
		$custom_css = self::render_css();
		wp_add_inline_style( $handle, $custom_css );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		

		if(is_post_type_archive('publin_magazinepages')) {
			$siteURL = get_site_url();
			$pluginDir = plugin_dir_url( __FILE__ );

			wp_enqueue_script( 'publin-js', plugin_dir_url( __FILE__ ) . 'js/publin.js', array( 'jquery' ), $this->version, false );

			wp_localize_script(
				'publin-js',
				'publin_php_vars',
				array( 
					'siteUrl' => $siteURL,
					'pluginDir' => $pluginDir,
				)
			);
		}
		if(is_post_type_archive( 'publin_magazinepages' )) {
			wp_enqueue_script( $this->publin, plugin_dir_url( __FILE__ ) . 'js/publin-public.js', array( 'jquery' ), $this->version, true );
		}

	}

	// * Render CCS uit php bestand.
	function render_css () {
		$css = '';

		$page_id = get_the_ID();
	
		$file     = plugin_dir_path( __FILE__ ) . 'css/includes/frontend.css.php';
	
		ob_start();
		include $file;
		// self::render();
		$css .= ob_get_clean();

		return $css;
	}

	// * Render JS uit php bestand.
	function render_js () {
		$js = '';

		$file = plugin_dir_path( __FILE__ ) . 'js/includes/frontend.js.php';

		ob_start();
		include $file;
		$js .= ob_get_clean();

		return $js;
	}

	

	

}

add_filter('template_include', 'publin_magazine_templates');
	function publin_magazine_templates( $template ) {
		$page_magazines = array('publin_magazines');
		$page_magazinepages = array('publin_magazinepages');

		if (is_singular($page_magazines)) {
			$template = plugin_dir_path( dirname( __FILE__ ) ).'/public/templates/single-magazine.php';
		}else if( is_singular($page_magazinepages)) {
			$template = plugin_dir_path( dirname( __FILE__ ) ).'/public/templates/single-magazinepages.php';
		}

		return $template;
	}
