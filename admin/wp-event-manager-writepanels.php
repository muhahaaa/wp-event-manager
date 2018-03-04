<?php/** This file use to cretae fields of wp event manager at admin side.*/if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directlyclass WP_Event_Manager_Writepanels {	/**	 * __construct function.	 *	 * @access public	 * @return void	 */	public function __construct() {		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );		add_action( 'save_post', array( $this, 'save_post' ), 1, 2 );		add_action( 'event_manager_save_event_listing', array( $this, 'save_event_listing_data' ), 20, 2 );	}	/**	 * event_listing_fields function.	 *	 * @access public	 * @return void	 */	public function event_listing_fields() {	    		global $post;		$current_user = wp_get_current_user();		if( isset($post->ID) ){			$registration = metadata_exists( 'post', $post->ID, '_registration' ) ? get_post_meta( $post->ID, '_registration', true ) : $current_user->user_email;			$expiry_date = get_post_meta( $post->ID, '_event_expiry_date', true );		}		else{			$registration = $current_user->user_email;			$expiry_date ='';		}		$fields = array(		        '_view_count' => array(					'label'       => __( 'Total View Count', 'wp-event-manager' ),					'type'        => 'text',					'required'    => true,					'placeholder' => 'View Count',					'priority'    => 1				),								'_registration' => array(    				'label'       => __( 'Registration Email or URL', 'wp-event-manager' ),    				'placeholder' => __( 'URL or email which attendees use to register', 'wp-event-manager' ),    				'description' => __( 'This field is required for the "registration" area to appear beneath the listing.', 'wp-event-manager' ),						'value'       => $registration,    				'priority'    => 2			    ),								'_event_title' => array(					'label'       => __( 'Event Title', 'wp-event-manager' ),					'type'        => 'text',					'required'    => true,					'placeholder' => 'event title',					'priority'    => 3				),				'_event_type' => array(					'label'       => __( 'Event Type', 'wp-event-manager' ),					'type'        => 'term-select',					'required'    => true,					'placeholder' => '',					'priority'    => 4,					'default'     => 'meeting-or-networking-event',					'taxonomy'    => 'event_listing_type'				),				'_event_category' => array(					'label'       => __( 'Event Category', 'wp-event-manager' ),					'type'        => 'term-multiselect',					'required'    => true,					'placeholder' => '',					'priority'    => 5,					'default'     => '',					'taxonomy'    => 'event_listing_category'				),				'_event_online' => array(							        'label'=> __('Online Event','wp-event-manager' ),							      	'name'  =>'event_online',							        'type'  => 'radio',									'default'  => 'no',									'options'  => array(												'yes' => __( 'Yes', 'wp-event-manager' ),												'no' => __( 'No', 'wp-event-manager' ),											),									'priority'    => 6,									'required'=>true		 		 ),				 		 		 		 '_event_venue_name' => array(					'label'       => __( 'Venue Name', 'wp-event-manager' ),					'type'        => 'text',					'required'    => true,										'placeholder' => __( 'Please enter the venue name', 'wp-event-manager' ),					'priority'    => 7				),					'_event_address' => array(					'label'       => __( 'Address', 'wp-event-manager' ),					'type'        => 'text',					'required'    => true,										'placeholder' => __( 'Please enter street name and number', 'wp-event-manager' ),					'priority'    => 8				),								'_event_pincode' => array(					'label'       => __( 'Pincode', 'wp-event-manager' ),					'type'        => 'text',					'required'    => true,					'placeholder' => __( 'Please enter pincode (Area code)', 'wp-event-manager' ),					'priority'    => 9				),				'_event_location' => array(					'label'       => __( 'Location', 'wp-event-manager' ),					'description' => __( 'Leave this blank if the location is not important', 'wp-event-manager' ),					'type'        => 'text',					'required'    => true,					'placeholder' => __( 'e.g. "Berlin","Munich"', 'wp-event-manager' ),					'priority'    => 10				),				'_event_banner' => array(					'label'       => __( 'Event Banner', 'wp-event-manager' ),					'type'        => 'file',					'required'    => false,					'placeholder' => '',					'priority'    => 11,					'ajax'        => true,					'multiple'    => true,					'allowed_mime_types' => array(						'jpg'  => 'image/jpeg',						'jpeg' => 'image/jpeg',						'gif'  => 'image/gif',						'png'  => 'image/png'					)				),				'_event_description' => array(					'label'       => __( 'Description', 'wp-event-manager' ),					'type'        => 'text',					'required'    => true,					'placeholder' => '',					'priority'    => 12				),				'_event_time_format' => array(  								'label'=> __( 'Time Format', 'wp-event-manager' ),								'type'  => 'radio',								'default'  => '24_hour_format',								'options'  => array(											    '12_hour_format' => __( '12 hour format', 'wp-event-manager' ),											    '24_hour_format' => __( '24 hour format', 'wp-event-manager' )								 		    ),								'priority'    => 12,							        'required'=>true	  							  ),				'_event_start_date' => array(  								'label'=> __('Start Date', 'wp-event-manager' ),								'placeholder'  => __( 'Please enter event start date', 'wp-event-manager' ),																'type'  => 'text',								'priority'    => 13,								'required'=>true	  							  ),							  				'_event_start_time' => array(  								'label'=> __('Start Time', 'wp-event-manager' ),								'placeholder'  => __( 'Please enter event start time', 'wp-event-manager' ),																'type'  => 'text',								'priority'    => 14,								'required'=>true	  							  ),				'_event_end_date' => array(							        'label'=> __('End Date', 'wp-event-manager' ),							        'placeholder'  => __( 'Please enter event end date', 'wp-event-manager' ),							        							        'type'  => 'text',									'priority'    => 15,							       'required'=>true							  ),							  				'_event_end_time' => array(							        'label'=> __('End Time', 'wp-event-manager' ),							        'placeholder'  => __( 'Please enter event end time', 'wp-event-manager' ),							        							        'type'  => 'text',									'priority'    => 16,							        'required'=>true							  ),				'_event_ticket_options' => array(							        'label'=> __('Ticket Options', 'wp-event-manager' ),							      								        'type'  => 'radio',									'default'  => 'free',									'options'  => array(											'paid' => __( 'Paid', 'wp-event-manager' ),  											'free' => __( 'Free', 'wp-event-manager' ) 								 		),								   'priority'    => 17,							       'required'=>true		 		 ),		                '_event_ticket_price' => array(							        'label'=> __('Price', 'wp-event-manager' ),							        'placeholder'  => __( 'Please enter ticket price', 'wp-event-manager' ),							        							        'type'  => 'text',									'priority'    => 18,							        'required'=>true							  ),						'_event_link_to_eventpage' => array(									'label'       => __( 'Link To Event Page', 'wp-event-manager' ),																		'type'        => 'text',									'required'    => false,														'placeholder' => __( 'e.g http://ww.example.com', 'wp-event-manager' ),									'priority'    => 20				),				'_event_registration_deadline' => array(									'label'       => __( 'Registration Deadline', 'wp-event-manager' ),																								'type'        => 'text',									'required'    => false,														'placeholder' => __( 'Please enter registration deadline', 'wp-event-manager' ),									'priority'    => 21				),				'_organizer_name' => array(								'label'       => __( 'Organization name', 'wp-event-manager' ),								'type'        => 'text',								'required'    => true,								'placeholder' => __( 'Enter the name of the organization', 'wp-event-manager' ),								'priority'    => 22				),				'_organizer_logo' => array(								'label'       => __( 'Logo', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => '',								'priority'    => 23,											),				'_organizer_description' => array(					'label'       => __( 'Organizer Description', 'wp-event-manager' ),					'type'        => 'text',					'required'    => true,					'placeholder' => '',					'priority'    => 24				),						'_organizer_contact_person_name' => array(								'label'       => __( 'Contact Person Name', 'wp-event-manager' ),								'type'        => 'text',								'required'    => true,								'placeholder' => __( 'Enter contact person name in your organization', 'wp-event-manager' ),								'priority'    => 25				),				'_organizer_email' => array(								'label'       => __( 'Organization Email', 'wp-event-manager' ),								'type'        => 'text',								'required'    => true,								'placeholder' => __( 'Enter your email address', 'wp-event-manager' ),								'priority'    => 26				),				'_organizer_website' => array(								'label'       => __( 'Website', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Website URL e.g http://www.yourorganization.com', 'wp-event-manager' ),								'priority'    => 27				),				'_organizer_tagline' => array(								'label'       => __( 'Tagline', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Your organization tagline', 'wp-event-manager' ),								'maxlength'   => 64,								'priority'    => 28				),				'_organizer_video' => array(								'label'       => __( 'Video', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'A link to a video about your organization', 'wp-event-manager' ),								'priority'    => 29				),				'_organizer_youtube' => array(								'label'       => __( 'Youtube', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Youtube Channel URL e.g http://www.youtube.com/channel/yourcompany', 'wp-event-manager' ),								'priority'    => 30				),				'_organizer_google_plus' => array(								'label'       => __( 'Google+', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Google+ URL e.g http://plus.google.com/yourcompany', 'wp-event-manager' ),								'priority'    => 31				),				'_organizer_facebook' => array(								'label'       => __( 'Facebook', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Facebook URL e.g http://www.facebook.com/yourcompany', 'wp-event-manager' ),								'priority'    => 32				),				'_organizer_linkedin' => array(								'label'       => __( 'Linkedin', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Linkedin URL e.g http://www.linkedin.com/company/yourcompany', 'wp-event-manager' ),								'priority'    => 33				),				'_organizer_twitter' => array(								'label'       => __( 'Twitter username', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( '@yourorganizer', 'wp-event-manager' ),								'priority'    => 34				),				'_organizer_xing' => array(								'label'       => __( 'Xing', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Xing URL e.g http://www.xing.com/companies/yourcompany', 'wp-event-manager' ),								'priority'    => 35				),				'_organizer_pinterest' => array(								'label'       => __( 'Pinterest', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Pinterest URL e.g http://www.pinterest.com/yourcompany', 'wp-event-manager' ),								'priority'    => 36				),				'_organizer_instagram' => array(								'label'       => __( 'Instagram', 'wp-event-manager' ),								'type'        => 'text',								'required'    => false,								'placeholder' => __( 'Instagram URL e.g http://www.instagram.com/yourcompany', 'wp-event-manager' ),								'priority'    => 37				),						 				'_cancelled' => array(					'label'       => __( 'Event Cancelled', 'wp-event-manager' ),					'type'        => 'checkbox',					'priority'    => 38,					'description' => __( 'Cancelled listings will no longer accept registration.', 'wp-event-manager' ),				 )		);		if ( $current_user->has_cap( 'manage_event_listings' ) ) {			$fields['_featured'] = array(				'label'       => __( 'Featured Listing', 'wp-event-manager' ),				'type'        => 'checkbox',				'description' => __( 'Featured listings will be sticky during searches, and can be styled differently.', 'wp-event-manager' ),				'priority'    => 39			);			$fields['_event_expiry_date'] = array(				'label'       => __( 'Listing Expiry Date', 'wp-event-manager' ),				'placeholder' => __( 'yyyy-mm-dd', 'wp-event-manager' ),				'priority'    => 40,					'value'       => $expiry_date,			);		}		if ( $current_user->has_cap( 'edit_others_event_listings' ) ) {			$fields['_event_author'] = array(				'label'    => __( 'Posted by', 'wp-event-manager' ),				'type'     => 'author',				'priority' => 41			);		}		$fields = apply_filters( 'event_manager_event_listing_data_fields', $fields );		$backend_selected_fields = get_option('event_manager_backend_form_fields',true);		if(!empty($backend_selected_fields) && is_array($backend_selected_fields) ){			foreach( $backend_selected_fields as $field_key => $field_value ) {				if(substr($field_key,0,1) != '_'){					$backend_selected_fields['_'.$field_key] = $backend_selected_fields[$field_key];					unset($backend_selected_fields[$field_key]);				}				if(isset($fields[$field_key]))				{					foreach($fields[$field_key] as $key => $value){						if(!isset($backend_selected_fields[$field_key][$key]))							$backend_selected_fields[$field_key][$key] = $fields[$field_key][$key];												}				}			}			$fields = $backend_selected_fields;		}		uasort( $fields, array( $this, 'sort_by_priority' ) );		return $fields;	}	/**	 * Sort array by priority value	 */	protected function sort_by_priority( $a, $b ) {	    if ( ! isset( $a['priority'] ) || ! isset( $b['priority'] ) || $a['priority'] === $b['priority'] ) {	        return 0;	    }	    return ( $a['priority'] < $b['priority'] ) ? -1 : 1;	}	/**	 * add_meta_boxes function.	 *	 * @access public	 * @return void	 */	public function add_meta_boxes() {		global $wp_post_types;		add_meta_box( 'event_listing_data', sprintf( __( '%s Data', 'wp-event-manager' ), $wp_post_types['event_listing']->labels->singular_name ), array( $this, 'event_listing_data' ), 'event_listing', 'normal', 'high' );				if ( ! get_option( 'event_manager_enable_event_types' ) ) {			remove_meta_box( 'event_listing_typediv', 'event_listing', 'side');		} elseif ( false == event_manager_multiselect_event_type() ) {			remove_meta_box( 'event_listing_typediv', 'event_listing', 'side');			add_meta_box( 'event_listing_type', __( 'Event Listings', 'wp-event-manager' ), array( $this, 'event_listing_metabox' ),'event_listing' ,'side','core');		}		/* We dont need this now we will improve this later		if ( ! get_option( 'event_manager_enable_categories' ) ) {			remove_meta_box( 'event_listing_categorydiv', 'event_listing', 'side');		} elseif ( false == event_manager_multiselect_event_category() ) {			remove_meta_box( 'event_listing_categorydiv', 'event_listing', 'side');			add_meta_box( 'event_listing_category', __( 'Event Listings', 'wp-event-manager' ), array( $this, 'event_listing_metabox' ),'event_listing' ,'side','core');		}		*/		}		/**	 * event_listing_metabox function.	 *	 * @param mixed $post	 * @param 	 */	function event_listing_metabox( $post ) {		//Set up the taxonomy object and get terms		$taxonomy = 'event_listing_type';		$tax = get_taxonomy( $taxonomy );//This is the taxonomy object event			//The name of the form		$name = 'tax_input[' . $taxonomy . ']';			//Get all the terms for this taxonomy		$terms = get_terms( $taxonomy, array( 'hide_empty' => 0 ) );		$postterms = get_the_terms( $post->ID, $taxonomy );		$current = ( $postterms ? array_pop( $postterms ) : false );		$current = ( $current ? $current->term_id : 0 );		//Get current and popular terms		$popular = get_terms( $taxonomy, array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );		$postterms = get_the_terms( $post->ID,$taxonomy );		$current = ($postterms ? array_pop($postterms) : false);		$current = ($current ? $current->term_id : 0);		?>				<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">					<!-- Display tabs-->				<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">					<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all" tabindex="3"><?php echo $tax->labels->all_items; ?></a></li>					<li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop" tabindex="3"><?php _e( 'Most Used' ); ?></a></li>				</ul>					<!-- Display taxonomy terms -->				<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">					<ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">						<?php   foreach($terms as $term){							$id = $taxonomy.'-'.$term->term_id;							echo "<li id='$id'><label class='selectit'>";							echo "<input type='radio' id='in-$id' name='{$name}'".checked($current,$term->term_id,false)."value='$term->term_id' />$term->name<br />";						   echo "</label></li>";						}?>				   </ul>				</div>					<!-- Display popular taxonomy terms -->				<div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">					<ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >						<?php   foreach($popular as $term){							$id = 'popular-'.$taxonomy.'-'.$term->term_id;							echo "<li id='$id'><label class='selectit'>";							echo "<input type='radio' id='in-$id'".checked($current,$term->term_id,false)."value='$term->term_id' />$term->name<br />";							echo "</label></li>";						}?>				   </ul>			   </div>				</div>			<?php		}			/**	 * input_file function.	 *	 * @param mixed $key	 * @param mixed $field	 */	public static function input_file( $key, $field ) {		global $thepostid;		if ( ! isset( $field['value'] ) ) {			$field['value'] = get_post_meta( $thepostid, $key, true );		}		if ( empty( $field['placeholder'] ) ) {			$field['placeholder'] = 'http://';		}		if ( ! empty( $field['name'] ) ) {			$name = $field['name'];		} else {			$name = $key;		}	?>			<p class="form-field">			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?>: <?php if ( ! empty( $field['description'] ) ) : ?><span class="tips" data-tip="<?php echo esc_attr( $field['description'] ); ?>">[?]</span><?php endif; ?></label>			<?php			if ( ! empty( $field['multiple'] ) ) {				foreach ( (array) $field['value'] as $value ) {					?><span class="file_url"><input type="text" name="<?php echo esc_attr( $name ); ?>[]" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" value="<?php echo esc_attr( $value ); ?>" /><button class="button button-small wp_event_manager_upload_file_button" data-uploader_button_text="<?php _e( 'Use file', 'wp-event-manager' ); ?>"><?php _e( 'Upload', 'wp-event-manager' ); ?></button></span><?php				}			} else {				?><span class="file_url"><input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" /><button class="button button-small wp_event_manager_upload_file_button" data-uploader_button_text="<?php _e( 'Use file', 'wp-event-manager' ); ?>"><?php _e( 'Upload', 'wp-event-manager' ); ?></button></span><?php			}			if ( ! empty( $field['multiple'] ) ) {				?><button class="button button-small wp_event_manager_add_another_file_button" data-field_name="<?php echo esc_attr( $key ); ?>" data-field_placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" data-uploader_button_text="<?php _e( 'Use file', 'wp-event-manager' ); ?>" data-uploader_button="<?php _e( 'Upload', 'wp-event-manager' ); ?>"><?php _e( 'Add file', 'wp-event-manager' ); ?></button><?php			}			?>		</p>		<?php	}	/**	 * input_text function.	 *	 * @param mixed $key	 * @param mixed $field	 */	public static function input_text( $key, $field ) {		global $thepostid;		if ( ! isset( $field['value'] ) ) {			$field['value'] = get_post_meta( $thepostid, $key, true );		}		if ( ! empty( $field['name'] ) ) {			$name = $field['name'];		} else {			$name = $key;		}		?>			<p class="form-field">			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?>: <?php if ( ! empty( $field['description'] ) ) : ?><span class="tips" data-tip="<?php echo esc_attr( $field['description'] ); ?>">[?]</span><?php endif; ?></label>			<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" />		</p>		<?php	}	/**	 * input_text function.	 *	 * @param mixed $key	 * @param mixed $field	 */	public static function input_textarea( $key, $field ) {		global $thepostid;		if ( ! isset( $field['value'] ) ) {			$field['value'] = get_post_meta( $thepostid, $key, true );		}		if ( ! empty( $field['name'] ) ) {			$name = $field['name'];		} else {			$name = $key;		}	?>		<p class="form-field">			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?>: <?php if ( ! empty( $field['description'] ) ) : ?><span class="tips" data-tip="<?php echo esc_attr( $field['description'] ); ?>">[?]</span><?php endif; ?></label>			<textarea name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"><?php echo esc_html( $field['value'] ); ?></textarea>		</p>		<?php	}	/**	 * input_select function.	 *	 * @param mixed $key	 * @param mixed $field	 */	public static function input_select( $key, $field ) {	   		global $thepostid;		if ( ! isset( $field['value'] ) ) {			$field['value'] = get_post_meta( $thepostid, $key, true );		}		if ( ! empty( $field['name'] ) ) {			$name = $field['name'];		} else {			$name = $key;		}		?>		<p class="form-field">			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?>: <?php if ( ! empty( $field['description'] ) ) : ?><span class="tips" data-tip="<?php echo esc_attr( $field['description'] ); ?>">[?]</span><?php endif; ?></label>			<select name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $key ); ?>">				<?php foreach ( $field['options'] as $key => $value ) : ?>				<option value="<?php echo esc_attr( $key ); ?>" <?php if ( isset( $field['value'] ) ) selected( $field['value'], $key ); ?>><?php echo esc_html( $value ); ?></option>				<?php endforeach; ?>			</select>		</p>		<?php	}	/**	 * input_select function.	 *	 * @param mixed $key	 * @param mixed $field	 */	public static function input_multiselect( $key, $field ) {		global $thepostid;		if ( ! isset( $field['value'] ) ) {			$field['value'] = get_post_meta( $thepostid, $key, true );		}		if ( ! empty( $field['name'] ) ) {			$name = $field['name'];		} else {			$name = $key;		}		?>		<p class="form-field">			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?>: <?php if ( ! empty( $field['description'] ) ) : ?><span class="tips" data-tip="<?php echo esc_attr( $field['description'] ); ?>">[?]</span><?php endif; ?></label>			<select multiple="multiple" name="<?php echo esc_attr( $name ); ?>[]" id="<?php echo esc_attr( $key ); ?>">				<?php foreach ( $field['options'] as $key => $value ) : ?>				<option value="<?php echo esc_attr( $key ); ?>" <?php if ( ! empty( $field['value'] ) && is_array( $field['value'] ) ) selected( in_array( $key, $field['value'] ), true ); ?>><?php echo esc_html( $value ); ?></option>				<?php endforeach; ?>			</select>		</p>		<?php	}	/**	 * input_checkbox function.	 *	 * @param mixed $key	 * @param mixed $field	 */	public static function input_checkbox( $key, $field ) {		global $thepostid;		if ( empty( $field['value'] ) ) {			$field['value'] = get_post_meta( $thepostid, $key, true );		}		if ( ! empty( $field['name'] ) ) {			$name = $field['name'];		} else {			$name = $key;		}		?>		<p class="form-field form-field-checkbox">			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?></label>			<input type="checkbox" class="checkbox" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $key ); ?>" value="1" <?php checked( $field['value'], 1 ); ?> />			<?php if ( ! empty( $field['description'] ) ) : ?><span class="description"><?php echo $field['description']; ?></span><?php endif; ?>		</p>		<?php	}	/**	 * Box to choose who posted the event	 *	 * @param mixed $key	 * @param mixed $field	 */	 	public static function input_author( $key, $field ) {		global $thepostid, $post;		if ( ! $post || $thepostid !== $post->ID ) {			$the_post  = get_post( $thepostid );			$author_id = $the_post->post_author;		} else {			$author_id = $post->post_author;		}		$posted_by      = get_user_by( 'id', $author_id );		$field['value'] = ! isset( $field['value'] ) ? get_post_meta( $thepostid, $key, true ) : $field['value'];		$name           = ! empty( $field['name'] ) ? $field['name'] : $key;		?>		<p class="form-field form-field-author">			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?>:</label>			<span class="current-author">				<?php					if ( $posted_by ) {						echo '<a href="' . admin_url( 'user-edit.php?user_id=' . absint( $author_id ) ) . '">#' . absint( $author_id ) . ' &ndash; ' . $posted_by->user_login . '</a>';					} else {						 _e( 'Guest User', 'wp-event-manager' );					}				?> <a href="#" class="change-author button button-small"><?php _e( 'Change', 'wp-event-manager' ); ?></a>			</span>			<span class="hidden change-author">				<input type="number" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $key ); ?>" step="1" value="<?php echo esc_attr( $author_id ); ?>" style="width: 4em;" />				<span class="description"><?php _e( 'Enter the ID of the user, or leave blank if submitted by a guest.', 'wp-event-manager' ) ?></span>			</span>		</p>		<?php	}	/**	 * input_radio function.	 *	 * @param mixed $key	 * @param mixed $field	 */	public static function input_radio( $key, $field ) {		global $thepostid;		if ( empty( $field['value'] ) ) {			$field['value'] = get_post_meta( $thepostid, $key, true );		}		if ( ! empty( $field['name'] ) ) {			$name = $field['name'];		} else {			$name = $key;		}		?>		<p class="form-field form-field-checkbox">			<label><?php echo esc_html( $field['label'] ) ; ?></label>			<?php foreach ( $field['options'] as $option_key => $value ) : ?>				<label><input type="radio" class="radio" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>" value="<?php echo esc_attr( $option_key ); ?>" <?php checked( $field['value'], $option_key ); ?> /> <?php echo esc_html( $value ); ?></label>			<?php endforeach; ?>			<?php if ( ! empty( $field['description'] ) ) : ?><span class="description"><?php echo $field['description']; ?></span><?php endif; ?>		</p>		<?php	}	/**	 * event_listing_data function.	 *	 * @access public	 * @param mixed $post	 * @return void	 */	public function event_listing_data( $post ) {		global $post, $thepostid;		$thepostid = $post->ID;		echo '<div class="wp_event_manager_meta_data">';		wp_nonce_field( 'save_meta_data', 'event_manager_nonce' );		do_action( 'event_manager_event_listing_data_start', $thepostid );		foreach ( $this->event_listing_fields() as $key => $field ) {			$type = ! empty( $field['type'] ) ? $field['type'] : 'text';			if ( has_action( 'event_manager_input_' . $type ) ) {				do_action( 'event_manager_input_' . $type, $key, $field );			} elseif ( method_exists( $this, 'input_' . $type ) ) {				call_user_func( array( $this, 'input_' . $type ), $key, $field );			}		}		do_action( 'event_manager_event_listing_data_end', $thepostid );		echo '</div>';	}		/**	 * save_post function.	 *	 * @access public	 * @param mixed $post_id	 * @param mixed $post	 * @return void	 */	public function save_post( $post_id, $post ) {		if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;		if ( is_int( wp_is_post_revision( $post ) ) ) return;		if ( is_int( wp_is_post_autosave( $post ) ) ) return;		if ( empty($_POST['event_manager_nonce']) || ! wp_verify_nonce( $_POST['event_manager_nonce'], 'save_meta_data' ) ) return;		if ( ! current_user_can( 'edit_post', $post_id ) ) return;		if ( $post->post_type != 'event_listing' ) return;		do_action( 'event_manager_save_event_listing', $post_id, $post );	}	/**	 * save_event_listing_data function.	 *	 * @access public	 * @param mixed $post_id	 * @param mixed $post	 * @return void	 */	public function save_event_listing_data( $post_id, $post ) {		global $wpdb;		// These need to exist		add_post_meta( $post_id, '_cancelled', 0, true );		add_post_meta( $post_id, '_featured', 0, true );		// Save fields		foreach ( $this->event_listing_fields() as $key => $field ) {			//Event Expiry date			if ( '_event_expiry_date' === $key ) {            				if ( ! empty( $_POST[ $key ] ) ) {					update_post_meta( $post_id, $key, date( 'Y-m-d', strtotime( sanitize_text_field( $_POST[ $key ] ) ) ) );				} else {				    update_post_meta( $post_id, $key, '' );				}			}			// Locations			elseif ( '_event_location' === $key ) {				if ( update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) ) ) {					// Location data will be updated by hooked in methods				} elseif ( apply_filters( 'event_manager_geolocation_enabled', true ) && ! WP_Event_Manager_Geocode::has_location_data( $post_id ) ) {					WP_Event_Manager_Geocode::generate_location_data( $post_id, sanitize_text_field( $_POST[ $key ] ) );				}			}			elseif ( '_event_author' === $key ) {				$wpdb->update( $wpdb->posts, array( 'post_author' => $_POST[ $key ] > 0 ? absint( $_POST[ $key ] ) : 0 ), array( 'ID' => $post_id ) );			}			// Everything else					else {				$type = ! empty( $field['type'] ) ? $field['type'] : '';				switch ( $type ) {					case 'textarea' :						update_post_meta( $post_id, $key,wp_kses_post( stripslashes( $_POST[ $key ] ) ) );					break;					case 'checkbox' :						if ( isset( $_POST[ $key ] ) ) {							update_post_meta( $post_id, $key, 1 );						} else {							update_post_meta( $post_id, $key, 0 );						}					break;					default :						if ( ! isset( $_POST[ $key ] ) ) {							continue;						} elseif ( is_array( $_POST[ $key ] ) ) {							update_post_meta( $post_id, $key, array_filter( array_map( 'sanitize_text_field', $_POST[ $key ] ) ) );						} else {							update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );						}					break;				}			}		}		/* Set Post Status To Expired If Already Expired */		$expiry_date = get_post_meta( $post_id, '_event_expires', true );		$today_date  = date( 'Y-m-d', current_time( 'timestamp' ) );		$post_status = $expiry_date && $today_date > $expiry_date ? 'expired' : false;		if( $post_status ) {			remove_action( 'event_manager_save_event_listing', array( $this, 'save_event_listing_data' ), 20, 2 );			$event_data = array(					'ID'          => $post_id,					'post_status' => $post_status,			);			wp_update_post( $event_data);			add_action( 'event_manager_save_event_listing', array( $this, 'save_event_listing_data' ), 20, 2 );		}	}}new WP_Event_Manager_Writepanels();