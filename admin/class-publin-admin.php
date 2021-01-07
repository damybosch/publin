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
		wp_enqueue_script( $this->publin . "_jqueryui", "https://code.jquery.com/ui/1.12.1/jquery-ui.min.js", array(), '1.12.1', true );

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
					'hierarchical' => true,
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
					// 'hierarchical' => true,
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true, 
					'query_var' => true,
					'capability_type' => 'page',
					'has_archive' => true, 
   					'supports' => array('thumbnail', 'editor', 'revisions', 'title', 'page-attributes')
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
				'priority'       => 'low',            // order of meta box: high (default), low; optional
				'fields'         => array(),            // list of meta fields (can be added by field arrays)
				'local_images'   => true,          // Use local or hosted images (meta box images for add/remove)
				'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			  );

			$basic_info =  new AT_Meta_Box($config);
			$basic_info->addText($prefix.'subTitle',array('name'=> 'Ondertitel'));
			$basic_info->addText($prefix.'company',array('name'=> 'Bedrijfsnaam'));
			$basic_info->addText($prefix.'website',array('name'=> 'Website'));
			$basic_info->addText($prefix.'facebook',array('name'=> 'Facebook'));
			$basic_info->addText($prefix.'instagram',array('name'=> 'Instagram'));
			$basic_info->addText($prefix.'linkedin',array('name'=> 'Linkedin'));
			$basic_info->addImage($prefix.'company-logo',array('name'=> 'Bedrijfslogo '));


			$basic_info->Finish();
			// ! Eindig meta box basis informatie

			// * Maak meta box template instellingen magazine
			$config2 = array(
				'id'             => 'template setting',          // meta box id, unique per meta box
				'title'          => 'Template Settings',          // meta box title
				'pages'          => array('publin_magazines'),      // post types, accept custom post types as well, default is array('post'); optional
				'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
				'priority'       => 'low',            // order of meta box: high (default), low; optional
				'fields'         => array(),            // list of meta fields (can be added by field arrays)
				'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
				'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			  );

			$template =  new AT_Meta_Box($config2);
			$template->addText($prefix.'fontFamily',array('name'=> 'Google Font Family'));
			$template->addColor($prefix.'menubarBackground',array('name'=> 'Menubalk Achtergrond kleur '));
			$template->addColor($prefix.'menubarTextColor',array('name'=> 'Menubalk Tekst Kleur '));
			$template->addSelect($prefix.'navigationTemplate',array('standard'=>'Standard','squared'=>'Squared', 'rounded' => 'Rounded'),array('name'=> 'Navigeer knoppen style ', 'std'=> array('standard')));
			$template->addColor($prefix.'navButtonBackground',array('name'=> 'Navigeer knoppen achtergrond '));
			$template->addColor($prefix.'navButtonColor',array('name'=> 'Navigeer knoppen tekst kleur '));
			$template->addCheckboxList($prefix.'menubarbuttons',array('website'=>'Website ','startpagina'=>'Startpagina ', 'menuicoon' => 'Menu Icoon '),array('name'=> 'Menubalk knoppen '));


			$template->Finish();
			// ! Eindig meta box template instellingen

			$config3 = array(
				'id'             => 'menu setting',          // meta box id, unique per meta box
				'title'          => 'Menu Setting',          // meta box title
				'pages'          => array('publin_magazines'),      // post types, accept custom post types as well, default is array('post'); optional
				'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
				'priority'       => 'low',            // order of meta box: high (default), low; optional
				'fields'         => array(),            // list of meta fields (can be added by field arrays)
				'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
				'use_with_theme' => false 
			);

			$menuSettings =  new AT_Meta_Box($config3);
			$menuSettings->addSelect($prefix.'menuTemplate',array('1-column'=>'1 column','2-column'=>'2 column'),array('name'=> 'Menu Template ', 'std'=> array('1-column')));
			$menuSettings->addCheckbox($prefix.'subtitleInMenu',array('name'=> 'Ondertitel in Menu? '));
			$menuSettings->addCheckbox($prefix.'pageCount',array('name'=> 'Pagina Teller? '));
			$menuSettings->addCheckbox($prefix.'thumbnailInMenu',array('name'=> 'Thumbnail in Menu? '));
			$menuSettings->addColor($prefix.'menuBackground',array('name'=> 'Menu Achtergrond Kleur '));
			$menuSettings->addColor($prefix.'menuTextColor',array('name'=> 'Menu Tekst Kleur '));



			$menuSettings->Finish();

			// * META BOXES voor magazinepages
			$config4 = array(
				'id'             => 'magazine page settings',          // meta box id, unique per meta box
				'title'          => 'Magazine Page Settings',          // meta box title
				'pages'          => array('publin_magazinepages'),      // post types, accept custom post types as well, default is array('post'); optional
				'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
				'priority'       => 'low',            // order of meta box: high (default), low; optional
				'fields'         => array(),            // list of meta fields (can be added by field arrays)
				'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
				'use_with_theme' => false 
			);

			$magazinepages =  new AT_Meta_Box($config4);
			$magazinepages->addText($prefix.'subTitle',array('name'=> 'Subtitle'));


			$magazinepages->Finish();

			function magazine_template_view() {
				$screens = [ 'publin_magazines' ];
				foreach ( $screens as $screen ) {
					add_meta_box(
						'magazine-template-view',                 // Unique ID
						'Magazine template weergave',      // Box title
						'magazine_template_view_html',  // Content callback, must be of type callable
						$screen                            // Post type
					);
				}
			}
			add_action( 'add_meta_boxes', 'magazine_template_view' );

			function magazine_template_view_html( $post ) {
				$value = get_post_meta( $post->ID, 'pms_template', true );
				?>
				<table class="form-table">
					<tbody>
						<tr>
							<td class="at-field">
							<div class="at-label"><label for="magazine-template">Kies een weergave</label></div>
							<input type="radio" name="pms_template" id="top" value="top" <?php echo ($value == 'top' ? 'checked' : '1'); ?> ><label for="top">Top</label>
							<input type="radio" name="pms_template" id="bottom" value="bottom" <?php echo ($value == 'bottom' ? "checked" : '2'); ?> ><label for="bottom">Bottom</label>
							<input type="radio" name="pms_template" id="left" value="left" <?php echo ($value == 'left' ? 'checked' : '3'); ?> ><label for="left">Left</label>
							<input type="radio" name="pms_template" id="right" value="right" <?php echo ($value == 'right' ? 'checked' : '4'); ?> ><label for="right">Right</label>
							</td>
						</tr>
					</tbody>
				</table>
				
				
				<?php
			}

			function magazine_template_view_save( $post_id ) {
				if ( array_key_exists( 'pms_template', $_POST ) ) {
					update_post_meta(
						$post_id,
						'pms_template',
						$_POST['pms_template']
					);
				}
			}
			add_action( 'save_post', 'magazine_template_view_save' );

			
		};

		
	
	}

}
// * Voeg de koppeling tussen magazines en magazines_pages toe.
include_once 'includes/publin-magazines-connect.php';