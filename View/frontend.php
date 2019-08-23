<?php
/*
* Main Plugin class
*/

// No Direct script Allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'VL_CLASS_View' ) ) {
	/*
	** Create Main Class
	*/
	class VL_CLASS_View {

		/*
		* Add Slug of the plugin
		*/
		protected $plugin_slug;
		/*
		* Creates Class Constructor
		*/
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'add_css' ) );
			add_shortcode( 'featured_offer' , array( $this, 'featured_offer' ) );
		}
			/*
			* Add Plugin CSS
			*/
			public function add_css() {
			wp_enqueue_style( 'public_css', VL_DIR_PATH.'/css/vl_style.css' );
			}


			/*
			* Display Offers Shortcode
			*/
			 function featured_offer( $atts ){
			 	global $content;
			 	ob_start();
			 	// $output = "";
				$post_id 		= sanitize_text_field( $atts['id'] );	
				// $rows_enable    = get_field('enable_row' , $post_id);
				$rows 			= get_field('featured_offers_rows' , $post_id);
				$output 		= '<div class="feature_offer_sec top_feature_offer" id="featured_sec">';
				$output 		.= '<table>
								<tbody>
								<tr>
									<th>RANK</th>
									<th>SITE</th>
									<th>BONUS</th>
									<th>DETAILS</th>
									<th>RATING</th>
									<th>PLAY</th>
								</tr>';

				  foreach ($rows as $row) {
				  	// print_r($row);
				  	$count_id = "";
				  	if ( $row['featured_icon'] == "1" ) {
							$count_id = "cont_val1";
						}
					if ( $row['enable_row'] == "1" ) {
				 	$output .= '<tr>
				 					<td><span class="count_value" id="'.$count_id.'">'.$row['rank'].'</span></td>
				 					<td>'.$row['site_title'].'</td>
				 					<td><span class="dlr_sp">'.$row['bonus'].'</span></td>
				 					<td class="deatil_csn">'.$row['offer_details'].'</td>
				 					<td class="rating_td"><span class="rat_out"><span class="rating_numb">'.$row['rating'].'</span>/5.0</span><div class="ratings">
										    <div class="empty-stars"></div>
										    <div class="full-stars" style="width:98%"></div>
										</div>
									</td>
				 					<td><a class="btn_offer thirstylink" href="'.esc_url( $row['play_button'][0]['button_url']).'">'.$row['play_button'][0]['button_text'].'</a></td>
				 				</tr>';
				 	}
				  }
				 $output .= '</tbody></table></div>';
				return $output;
			}
		}
}
