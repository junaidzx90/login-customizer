<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that admin attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Login_Customizer
 * @subpackage Login_Customizer/admin
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Login_Customizer
 * @subpackage Login_Customizer/admin
 * @author     Developer Junayed <admin@easeare.com>
 */
class Login_Customizer {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'LOGIN_CUSTOMIZER_VERSION' ) ) {
			$this->version = LOGIN_CUSTOMIZER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'login-customizer';

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		add_action("admin_enqueue_scripts", [$this, "admin_scripts"]);
		add_action("admin_menu", [$this, "login_customizer_admin_menu"]);
		add_action("login_enqueue_scripts", [$this, "login_enqueue_scripts_callback"]);
		add_action("login_head", [$this, "login_head_scripts_callback"]);
		add_action("login_headerurl", [$this, "login_headerurl_callback"]);
	}

	function admin_scripts(){
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . "admin/css/login-customizer-admin.css", array(), $this->version, 'all' );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'admin/js/login-customizer-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true);
	}

	function login_customizer_admin_menu(){
		add_options_page( "Login Customizer", "Login Customizer", "manage_options", "login-customizer", [$this, "login_customizer_menupage"], null );

		add_settings_section( 'lc_general_opt_section', '', '', 'lc_general_opt_page' );
		
		// Logo URL
		add_settings_field( 'lc_logo_url', 'Logo URL', [$this, 'lc_logo_url_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_logo_url' );
		// Logo redirection URL
		add_settings_field( 'lc_logo_redirection', 'Logo redirection URL', [$this, 'lc_logo_redirection_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_logo_redirection' );

		// Logo margin
		add_settings_field( 'lc_logo_margin', 'Logo margin', [$this, 'lc_logo_margin_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_logo_margin_top' );
		register_setting( 'lc_general_opt_section', 'lc_logo_margin_bottom' );

		// Logo scale
		add_settings_field( 'lc_logo_scale', 'Logo scale', [$this, 'lc_logo_scale_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_logo_scale' );

		// Body background color
		add_settings_field( 'lc_body_bg_color', 'Body background color', [$this, 'lc_body_bg_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_body_bg_color' );

		// Body color
		add_settings_field( 'lc_body_color', 'Body text color', [$this, 'lc_body_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_body_color' );

		// Form background color
		add_settings_field( 'lc_form_background_color', 'Form background color', [$this, 'lc_form_background_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_form_background_color' );
		// Form border
		add_settings_field( 'lc_form_border', 'Form border', [$this, 'lc_form_border_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_form_border' );
		// Form border radius
		add_settings_field( 'lc_form_border_radius', 'Form border radius', [$this, 'lc_form_border_radius_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_form_border_radius' );
		// Form box-shadow
		add_settings_field( 'lc_form_box_shadow_color', 'Form shadow color', [$this, 'lc_form_box_shadow_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_form_box_shadow_color' );

		// Login button background color
		add_settings_field( 'lc_login_btn_background_color', 'Login button background color', [$this, 'lc_login_btn_background_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_login_btn_background_color' );
		// Login button border
		add_settings_field( 'lc_login_btn_border', 'Login button border', [$this, 'lc_login_btn_border_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_login_btn_border' );
		// Login button border radius
		add_settings_field( 'lc_login_btn_border_radius', 'Login button border radius', [$this, 'lc_login_btn_border_radius_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_login_btn_border_radius' );
		// Login button hover background color
		add_settings_field( 'lc_login_btn_hover_bg_color', 'Login button hover background color', [$this, 'lc_login_btn_hover_bg_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_login_btn_hover_bg_color' );

		// Link color
		add_settings_field( 'lc_link_color', 'Link color', [$this, 'lc_link_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_link_color' );
		// Link hover color
		add_settings_field( 'lc_link_hover_color', 'Link hover color', [$this, 'lc_link_hover_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_link_hover_color' );
		// Link hover text-decoration
		add_settings_field( 'lc_link_hover_text_decoration', 'Link hover text-decoration', [$this, 'lc_link_hover_text_decoration_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_link_hover_text_decoration' );

		// Input focus border color
		add_settings_field( 'lc_input_focus_border_color', 'Input focus border color', [$this, 'lc_input_focus_border_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_input_focus_border_color' );
		// Input focus shadow color
		add_settings_field( 'lc_input_focus_shadow_color', 'Input focus shadow color', [$this, 'lc_input_focus_shadow_color_cb'], 'lc_general_opt_page','lc_general_opt_section' );
		register_setting( 'lc_general_opt_section', 'lc_input_focus_shadow_color' );
	}

	function lc_logo_url_cb(){
		echo '<input type="url" class="widefat" name="lc_logo_url" placeholder="URL" value="'.get_option('lc_logo_url').'">';
	}
	function lc_logo_redirection_cb(){
		echo '<input type="url" class="widefat" name="lc_logo_redirection" placeholder="URL" value="'.get_option('lc_logo_redirection').'">';
	}
	function lc_logo_margin_cb(){
		echo '<div class="logo-margin">';
		echo '<label>Top<input type="number" placeholder="0" name="lc_logo_margin_top" value="'.get_option('lc_logo_margin_top').'"></label>';
		echo '<label>Bottom<input type="number" placeholder="25px" name="lc_logo_margin_bottom" value="'.get_option('lc_logo_margin_bottom').'"></label>';
		echo '</div>';
	}
	function lc_logo_scale_cb(){
		echo '<div class="range-wrap">';
		echo '<div class="range-value"></div>';
		echo '<input class="range_input" value="'.get_option('lc_logo_scale', 1).'" type="range" name="lc_logo_scale" min="1" max="10">';
		echo '</div>';
	}
	function lc_body_bg_color_cb(){
		echo '<input type="text" name="lc_body_bg_color" id="lc_body_bg_color" data-default-color="#f0f0f1" value="'.((get_option('lc_body_bg_color')) ? get_option('lc_body_bg_color') : '#f0f0f1').'">';
	}
	function lc_body_color_cb(){
		echo '<input type="text" name="lc_body_color" id="lc_body_color" data-default-color="#3c434a" value="'.((get_option('lc_body_color')) ? get_option('lc_body_color') : '#3c434a').'">';
	}
	function lc_form_background_color_cb(){
		echo '<input type="text" name="lc_form_background_color" id="lc_form_background_color" data-default-color="#ffffff" value="'.((get_option('lc_form_background_color')) ? get_option('lc_form_background_color') : '#ffffff').'">';
	}
	function lc_form_border_cb(){
		echo '<input type="text" name="lc_form_border" placeholder="1px solid #c3c4c7" id="lc_form_border" value="'.get_option('lc_form_border').'">';
	}
	function lc_form_border_radius_cb(){
		echo '<div class="range-wrap">';
		echo '<div class="range-value"></div>';
		echo '<input class="range_input" value="'.get_option('lc_form_border_radius', 0).'" type="range" name="lc_form_border_radius" min="0" max="25">';
		echo '</div>';
	}
	function lc_form_box_shadow_color_cb(){
		echo '<input type="text" name="lc_form_box_shadow_color" id="lc_form_box_shadow_color" data-default-color="#d9d9d9" value="'.((get_option('lc_form_box_shadow_color')) ? get_option('lc_form_box_shadow_color') : '#d9d9d9').'">';
	}

	function lc_login_btn_background_color_cb(){
		echo '<input type="text" name="lc_login_btn_background_color" id="lc_login_btn_background_color" data-default-color="#2271b1" value="'.((get_option('lc_login_btn_background_color')) ? get_option('lc_login_btn_background_color') : '#2271b1').'">';
	}
	function lc_login_btn_border_cb(){
		echo '<input type="text" name="lc_login_btn_border" placeholder="1px solid" id="lc_login_btn_border" value="'.get_option('lc_login_btn_border').'">';
	}
	function lc_login_btn_border_radius_cb(){
		echo '<div class="range-wrap">';
		echo '<div class="range-value"></div>';
		echo '<input class="range_input" value="'.get_option('lc_login_btn_border_radius', 3).'" type="range" name="lc_login_btn_border_radius" min="0" max="25">';
		echo '</div>';
	}
	function lc_login_btn_hover_bg_color_cb(){
		echo '<input type="text" name="lc_login_btn_hover_bg_color" id="lc_login_btn_hover_bg_color" data-default-color="#2271b1" value="'.((get_option('lc_login_btn_hover_bg_color')) ? get_option('lc_login_btn_hover_bg_color') : '#2271b1').'">';
	}
	function lc_link_color_cb(){
		echo '<input type="text" name="lc_link_color" id="lc_link_color" data-default-color="#50575e" value="'.((get_option('lc_link_color')) ? get_option('lc_link_color') : '#50575e').'">';
	}
	function lc_link_hover_color_cb(){
		echo '<input type="text" name="lc_link_hover_color" id="lc_link_hover_color" data-default-color="#2271b1" value="'.((get_option('lc_link_hover_color')) ? get_option('lc_link_hover_color') : '#2271b1').'">';
	}
	function lc_link_hover_text_decoration_cb(){
		echo '<input type="text" name="lc_link_hover_text_decoration" id="lc_link_hover_text_decoration" placeholder="underline" value="'.get_option('lc_link_hover_text_decoration').'">';
	}
	function lc_input_focus_border_color_cb(){
		echo '<input type="text" name="lc_input_focus_border_color" id="lc_input_focus_border_color" data-default-color="#2271b1" value="'.((get_option('lc_input_focus_border_color')) ? get_option('lc_input_focus_border_color') : '#2271b1').'">';
	}
	function lc_input_focus_shadow_color_cb(){
		echo '<input type="text" name="lc_input_focus_shadow_color" id="lc_input_focus_shadow_color" data-default-color="#d9d9d9" value="'.((get_option('lc_input_focus_shadow_color')) ? get_option('lc_input_focus_shadow_color') : '#d9d9d9').'">';
	}

	function login_customizer_menupage(){
		?>
		<h3>Login customizer</h3>
		<hr>

		<form method="post" style="width: 50%" action="options.php">
			<?php
			settings_fields( 'lc_general_opt_section' );
			do_settings_sections( 'lc_general_opt_page' );
			
			submit_button(  );
			?>
		</form>	
		<?php
	}

	function login_head_scripts_callback(){
		?>
		<style>
			:root{
				--loginlogo: <?php echo ((get_option('lc_logo_url')) ? 'url('.get_option('lc_logo_url').')': 'url('.plugin_dir_url( __FILE__ )."public/image/wordpress-logo.svg".')') ?>;
				--logoScale: <?php echo ((get_option('lc_logo_scale')) ? 'scale('.get_option('lc_logo_scale').')' : 'scale(1)') ?>;
				--margin_top: <?php echo ((get_option('lc_logo_margin_top')) ? get_option('lc_logo_margin_top').'px' : '0px') ?>;
				--margin_bottom: <?php echo ((get_option('lc_logo_margin_bottom')) ? get_option('lc_logo_margin_bottom').'px' : '25px') ?>;
				--body_bg: <?php echo ((get_option('lc_body_bg_color')) ? get_option('lc_body_bg_color') : '#f0f0f1') ?>;
				--body_color: <?php echo ((get_option('lc_body_color')) ? get_option('lc_body_color') : '#3c434a') ?>;
				--form_background: <?php echo ((get_option('lc_form_background_color')) ? get_option('lc_form_background_color') : '#ffffff') ?>;
				--form_border: <?php echo ((get_option('lc_form_border')) ? get_option('lc_form_border').'px' : '1px solid #c3c4c7') ?>;
				--border_radius: <?php echo ((get_option('lc_form_border_radius')) ? get_option('lc_form_border_radius').'px' : '0px') ?>;
				--shadow_color: <?php echo ((get_option('lc_form_box_shadow_color')) ? get_option('lc_form_box_shadow_color') : '#d9d9d9') ?>;
				--button_bg: <?php echo ((get_option('lc_login_btn_background_color')) ? get_option('lc_login_btn_background_color') : '#2271b1') ?>;
				--btn_border_radius: <?php echo ((get_option('lc_login_btn_border_radius')) ? get_option('lc_login_btn_border_radius').'px' : '3px') ?>;
				--btn_border: <?php echo ((get_option('lc_login_btn_border')) ? get_option('lc_login_btn_border').'' : '1px solid') ?>;
				--btn_hover_bg_color: <?php echo ((get_option('lc_login_btn_hover_bg_color')) ? get_option('lc_login_btn_hover_bg_color') : '') ?>;
				--link_color: <?php echo ((get_option('lc_link_color')) ? get_option('lc_link_color') : '#50575e') ?>;
				--link_hover_color: <?php echo ((get_option('lc_link_hover_color')) ? get_option('lc_link_hover_color') : '#2271b1') ?>;
				--link_hover_text_decoration: <?php echo ((get_option('lc_link_hover_text_decoration')) ? get_option('lc_link_hover_text_decoration') : 'underline') ?>;
				--input_focus_border_color: <?php echo ((get_option('lc_input_focus_border_color')) ? get_option('lc_input_focus_border_color') : '#2271b1') ?>;
				--input_focus_shadow_color: <?php echo ((get_option('lc_input_focus_shadow_color')) ? get_option('lc_input_focus_shadow_color') : '#d9d9d9') ?>;
			}
		</style>
		<?php
	}

	function login_headerurl_callback(){
		return ((get_option('lc_logo_redirection')) ? get_option('lc_logo_redirection') : home_url());
	}

	function login_enqueue_scripts_callback(){
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . "public/login.css", array(), $this->version, 'all' );
	}
}
