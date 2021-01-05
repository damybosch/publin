<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Publin
 * @subpackage Publin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Publin
 * @subpackage Publin/admin
 * @author     Your Name <email@example.com>
 */


class Publin_Admin {

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
	 * @param      string    $publin       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $publin, $version ) {

		$this->publin = $publin;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Publin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Publin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->publin, plugin_dir_url( __FILE__ ) . 'css/publin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Publin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Publin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->publin, plugin_dir_url( __FILE__ ) . 'js/publin-admin.js', array( 'jquery' ), $this->version, false );

	}

	

	public function create_post_types() {

		// * Toevoegen Menu Item Backend
		add_action( 'admin_menu', 'wporg_options_page' );
			function wporg_options_page() {
				add_menu_page(
					'Publin',
					'Publin',
					'manage_options',
					'publin',
					'publin_options_page_html',
					'dashicons-book',
					80
				);
			}

		// * Toevoegen Magazines Posttype onder Publin
		register_post_type('publin_magazines',
			array(
				'labels'      => array(
					'name'          => __('Magazines', 'textdomain'),
					'singular_name' => __('Magazine', 'textdomain'),
				),
					'show_in_menu'        => 'publin',
					'rewrite' => array('slug' => 'magazines'),
					'public'      => true,
					'has_archive' => true,
					'supports' => array('thumbnail', 'title')
			)
		);
		
		// * Toevoegen MagazinesPages Posttype onder Publin
		register_post_type('publin_magazinePages',
			array(
				'labels'      => array(
					'name'          => __('Magazine Pages', 'textdomain'),
					'singular_name' => __('Magazine Page', 'textdomain'),
				),
					'show_in_menu'        => 'publin',
					'capability_type'    =>  'page',
					'public'      => true,
					'has_archive' => true,
   					'supports' => array('thumbnail', 'editor', 'revisions', 'title')
			)
		);
		
		
	}

	public function create_magazine_metaboxes() {
		

		// https://github.com/bainternet/My-Meta-Box/blob/master/class-usage-demo.php
		// * Maak gebruik van externe class zodat aanmaken van metaboxes makkelijker gaat.
		require_once("includes/meta-box-class/my-meta-box-class.php");

		if(is_admin()) {
			$prefix = 'pmb_';
			// * Maak meta box basis informatie magazine
			$config = array(
				'id'             => 'basic-info',          // meta box id, unique per meta box
				'title'          => 'Basis informatie Magazine',          // meta box title
				'pages'          => array('publin_magazines'),      // post types, accept custom post types as well, default is array('post'); optional
				'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
				'priority'       => 'high',            // order of meta box: high (default), low; optional
				'fields'         => array(),            // list of meta fields (can be added by field arrays)
				'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
				'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			  );

			$basic_info =  new AT_Meta_Box($config);
			$basic_info->addText($prefix.'subTitle',array('name'=> 'Subtitle'));
			$basic_info->addText($prefix.'company',array('name'=> 'Company Name'));
			
			$basic_info->addImage($prefix.'company-logo',array('name'=> 'Company Logo '));


			$basic_info->Finish();
			// ! Eindig meta box basis informatie

			// * Maak meta box template instellingen magazine
			$config2 = array(
				'id'             => 'template setting',          // meta box id, unique per meta box
				'title'          => 'Template Settings',          // meta box title
				'pages'          => array('publin_magazines'),      // post types, accept custom post types as well, default is array('post'); optional
				'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
				'priority'       => 'high',            // order of meta box: high (default), low; optional
				'fields'         => array(),            // list of meta fields (can be added by field arrays)
				'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
				'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			  );

			$template =  new AT_Meta_Box($config2);
			$template->addSelect($prefix.'navigationTemplate',array('standard'=>'Standard','squared'=>'Squared', 'rounded' => 'Rounded'),array('name'=> 'Navigation Template ', 'std'=> array('standard')));
			$template->addSelect($prefix.'navigationPosition',array('top'=>'Top','bottom'=>'Bottom', 'left' => 'Left', 'right' => 'Right'),array('name'=> 'Navigation Position ', 'std'=> array('top')));
			$template->addColor($prefix.'headerBackgroundColor',array('name'=> 'Header Background Color '));
			$template->addColor($prefix.'headerTextColor',array('name'=> 'Header Text Color '));


			$template->Finish();
			// ! Eindig meta box template instellingen

			
		};

		
	
	}

}
// * Voeg de koppeling tussen magazines en magazines_pages toe.
include_once 'includes/publin-magazines-connect.php';