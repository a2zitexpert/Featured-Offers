<?php
/*
* Main Plugin class
*/

// No Direct script Allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'VL_CLASS_Main' ) ) {
	/*
	** Create Main Class
	*/
	class VL_CLASS_Main {

		/*
		* Add Slug of the plugin
		*/
		protected $plugin_slug;
		/*
		* Creates Class Constructor
		*/
		public function __construct() {

			$this->plugin_slug = 'featured offers';
			$this->load_dependencies();
			  add_action( 'init', array( $this, 'REGISTER_VL_CPT' ) );
			  add_action( 'init', array( $this, 'add_fields_group') );
			  add_action( 'new_to_publish', array( $this, 'save_cafe_custom_fields') ); 
			  add_filter("manage_edit-featured_offers_columns",array( $this , 'offer_page_columns' ) , 30 );
			  add_action("manage_featured_offers_posts_custom_column", array( $this , 'offer_custom_columns' ),99 );
			  add_filter( 'post_row_actions', array( $this ,'remove_row_actions' ), 10, 1 );
			}
			/*
			** Load Files
			*/
			private function load_dependencies() {
				require_once( VL_PLUGIN_PATH . 'View/frontend.php' );
			}


			/**
			 * plugin activation 
			 * @see register_activation_hook()
			 */
			public static function activate() {
				add_action( 'init', array( $this, 'REGISTER_VL_CPT' ) );
			}

			/**
			 * plugin deactivation callback
			 * @see register_deactivation_hook()
			 */
			public static function deactivate() {
				flush_rewrite_rules();
			}


			/*
			* Register Post Type on activate
			* @link http://codex.wordpress.org/Function_Reference/register_post_type
			*/
			public function REGISTER_VL_CPT() {
				$labels = array(
				'name' 				=> _x( 'Featured Offers', 'Post Type General Name','featured offers' ),
				'singular_name' 	=> _x( 'featured offer', 'Post Type Singular Name', 'featured offers' ),
				'add_new' 			=> __( 'Add New', 'featured offers' ),
				'add_new_item' 		=> __( 'Add New Offer', 'featured offers' ),
				'edit_item' 		=> __( 'Edit Offer', 'featured offers' ),
				'new_item' 			=> __( 'New Offer', 'featured offers' ),
				'view_item' 		=> __( 'View Offer', 'featured offers' ),
				'search_items' 		=> __( 'Search Offers', 'featured offers' ),
				'not_found' 		=> __( 'No Offers found', 'featured offers' ),
				'not_found_in_trash'=> __( 'No Offers found in Trash', 'featured offers' ),
				'parent_item_colon' => __( 'Parent Offer:', 'featured offers' ),
				'menu_name' 		=> __( 'Featured Offers', 'featured offers' ),
				);

				$args = array(
				'labels' 			=> $labels,
				'hierarchical' 		=> false,
				'description' 		=> __( 'Featured Offers POST TYPE', 'featured offers' ),
				'supports' 			=> array( 'title' ),
				'show_ui' 			=> true,
				'show_in_menu' 		=> true,
				'menu_position' 	=> 10,
				'menu_icon' 		=> 'dashicons-images-alt2',
				'show_in_nav_menus' => false,
				'publicly_queryable'=> true,
				'exclude_from_search'=> false,
				'query_var' 		=> false,
				'can_export' 		=> true,
				'public' 			=> true,
				'has_archive' 		=> true,
				);  
			register_post_type( 'featured_offers', $args );
				// echo '<script>alert("plugin activated");</script>';
			}


			/*
			* Add Shortcode on Admin List of Offers 
			*/
			public function offer_page_columns($columns)
				{
					$columns = array(
									'title' 	=> 'Offer Table',
									'shortcode'		=> 'Shortcode',
								);
								return $columns;
				}

			/*
			** create and Add Shortcode in offer list
			*/
			public function offer_custom_columns($column)
				{
					global $post;

					if($column == 'shortcode')
					{
						echo '[featured_offer id="'.$post->ID.'"]';
					}
				}

			/*
			* Add FIelds Group Of Featured Post type
			*/
			public function add_fields_group(){
				if( function_exists('acf_add_local_field_group') ):

				acf_add_local_field_group(array(
					'key' => 'group_5b0bd999d9c86',
					'title' => 'featured offers fields',
					'fields' => array(
						array(
							'key' => 'field_5b0bd9b1c0ee6',
							'label' => 'Featured Offers Rows',
							'name' => 'featured_offers_rows',
							'type' => 'repeater',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'collapsed' => '',
							'min' => 0,
							'max' => 0,
							'layout' => 'row',
							'button_label' => '',
							'sub_fields' => array(
													array(
											'key' => 'field_5b31c560e2f4e',
											'label' => 'Enable Row',
											'name' => 'enable_row',
											'type' => 'true_false',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'message' => '',
											'default_value' => 1,
											'ui' => 0,
											'ui_on_text' => '',
											'ui_off_text' => '',
										),
								array(
								'key' => 'field_5b0d22d7bfb72',
								'label' => 'Featured Icon',
								'name' => 'featured_icon',
								'type' => 'true_false',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'message' => '',
								'default_value' => 0,
								'ui' => 0,
								'ui_on_text' => '',
								'ui_off_text' => '',
							),
								array(
									'key' => 'field_5b0bda6ac0ee7',
									'label' => 'Rank',
									'name' => 'rank',
									'type' => 'number',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'min' => '',
									'max' => '',
									'step' => '',
								),
								array(
									'key' => 'field_5b0bda90c0ee8',
									'label' => 'Site Title',
									'name' => 'site_title',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_5b0bdad3c0ee9',
									'label' => 'Bonus',
									'name' => 'bonus',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_5b0bdaecc0eea',
									'label' => 'Offer Details',
									'name' => 'offer_details',
									'type' => 'textarea',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'maxlength' => '',
									'rows' => '',
									'new_lines' => '',
								),
								array(
									'key' => 'field_5b0bdb10c0eeb',
									'label' => 'Rating',
									'name' => 'rating',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_5b0bdbc7c0eec',
									'label' => 'Play Button',
									'name' => 'play_button',
									'type' => 'repeater',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '100',
										'class' => '',
										'id' => '',
									),
									'collapsed' => '',
									'min' => 0,
									'max' => 1,
									'layout' => 'block',
									'button_label' => '',
									'sub_fields' => array(
										array(
											'key' => 'field_5b0bdbe6c0eed',
											'label' => 'Button Text',
											'name' => 'button_text',
											'type' => 'text',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'default_value' => '',
											'placeholder' => '',
											'prepend' => '',
											'append' => '',
											'maxlength' => '',
										),
										array(
											'key' => 'field_5b0bdc02c0eee',
											'label' => 'Button Url',
											'name' => 'button_url',
											'type' => 'text',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'default_value' => '',
											'placeholder' => '',
											'prepend' => '',
											'append' => '',
											'maxlength' => '',
										),
									),
								),
							),
						),
					),
					'location' => array(
						array(
							array(
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'featured_offers',
							),
						),
					),
					'menu_order' => 0,
					'position' => 'normal',
					'style' => 'default',
					'label_placement' => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen' => '',
					'active' => 1,
					'description' => '',
				));

				endif;
			}


			/*
			** Remove View And Quick Edit Option admin listing 
			*/
			public function remove_row_actions( $actions )
				{
				    if( get_post_type() === 'featured_offers' )
				        unset( $actions['view'] );
				        unset( $actions['inline hide-if-no-js'] );
				    return $actions;
				}



	} // End of class

}

?>