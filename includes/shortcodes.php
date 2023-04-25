<?php // signposts shortcode - lists categories for signposts

function hw_signpost_signposts_list_categories_with_featured_images() {
// List LOCAL SERVICES with link to each
  $terms = get_terms( 'signpost_categories' );
  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    $output = '<!-- start container --><div id="signposts-selector" class="row">';
    foreach ( $terms as $term ) {
      $term_icon = get_term_meta( $term->term_id, 'icon', true );
      $output = $output .
      '<div class="col-md-3 col-sm-4 col-xs-6">
        <div class="signpost-container">
          <a class="img-anchor ' . $term->slug . '" href="' . get_term_link( $term ) . '" aria-hidden="true">'
            . wp_get_attachment_image( $term_icon, 'full', false, array( 'class' => 'img-signpost-category', 'alt' => $term->name ) ) .
          '</a>
          <a class="signpost-details ' . $term->slug . '" href="' . get_term_link( $term ) . '">
            <p>' . $term->name . '</p>
            <div class="hover-content">
              <p>' . $term->description . '</p>
            </div>
          </a>
        </div>
      </div>';
    }
    $output = $output . '</div><!-- end of container -->';
  }
return $output;
}

add_shortcode('signposts_menu', 'hw_signpost_signposts_list_categories_with_featured_images');

/* Media object ADDRESS
------------------------ */

function hw_signpost_shortcode_signpost_address_object( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'address' => 'Mail address for the signpost', // address for the signpost
	), $atts );
	if ( empty( $content ) ) {
		$output_address = $a['address'];
	} else {
		$output_address = $content;
	}
	$label = 'Mailing address';
	$address_object = '
	<div class="media signpost signpost-address">
		<div class="media-left">
				<i class="media-object fas fa-pencil-alt fa-lg shortcode-icon" aria-hidden="true" title="' . $label . '"></i>
		</div>
		<div class="media-body"><p>' . $output_address . '</p></div>
	</div>';

	return $address_object;
}

add_shortcode( 'signpost_address', 'hw_signpost_shortcode_signpost_address_object' );

/* Media object LOCATION
------------------------ */

function hw_signpost_shortcode_signpost_location_object( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'location' => 'Physical location for the signpost', // location for the signpost
	), $atts );
	if ( empty( $content ) ) {
		$output_location = $a['location'];
	} else {
		$output_location = $content;
	}
	$label = 'Street address';
	$location_object = '
	<div class="media signpost signpost-location">
		<div class="media-left">
				<i class="media-object fas fa-map-marker-alt fa-lg shortcode-icon" aria-hidden="true"></i>
		</div>
		<div class="media-body"><p>' .$output_location . '</p></div>
	</div>';

	return $location_object;
}

add_shortcode( 'signpost_location', 'hw_signpost_shortcode_signpost_location_object' );

/* Media object WEBSITE
------------------------ */

function hw_signpost_shortcode_signpost_website_object( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'website' => get_site_url(), // website for the signpost
	), $atts );

	if ( empty( $content ) ) {
		$cleaned_url = wp_strip_all_tags($a['website']);
	} else {
		$cleaned_url = wp_strip_all_tags($content);
	}
	$display_url = preg_replace("(^https?://)", "", $cleaned_url );
	$label = 'Website';
	$website_object = '
	<div class="media signpost signpost-website">
		<div class="media-left">
				<i class="media-object fas fa-external-link-alt fa-lg shortcode-icon" aria-hidden="true" title="' . $label . '"></i>
		</div>
		<div class="media-body"><a href="' . $cleaned_url . '">' . $display_url . '</a></div>
	</div>';

	return $website_object;
}

add_shortcode( 'signpost_website', 'hw_signpost_shortcode_signpost_website_object' );

/* Media object EMAIL
------------------------ */

function hw_signpost_shortcode_signpost_email_object( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'email' => get_theme_mod( 'scaffold_org_email'), // email for the signpost
	), $atts );

	if ( empty( $content ) ) {
		$cleaned_email = wp_strip_all_tags($a['email']);
	} else {
		$cleaned_email = wp_strip_all_tags($content);
	}
	$label = 'Email address';
	$email_object = '
	<div class="media signpost signpost-email">
		<div class="media-left">
				<i class="media-object far fa-envelope fa-lg shortcode-icon" aria-hidden="true" title="' . $label . '"></i>
		</div>
		<div class="media-body"><a href="mailto:' . $cleaned_email . '">' . $cleaned_email . '</a></div>
	</div>';

	return $email_object;
}

add_shortcode( 'signpost_email', 'hw_signpost_shortcode_signpost_email_object' );

/* Media object PHONE
------------------------ */

function hw_signpost_shortcode_signpost_phone_object( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'phone' => '01494 32 48 32', // email for the signpost
	), $atts );

	if ( empty( $content ) ) {
		$cleaned_phone = wp_strip_all_tags($a['phone']);
	} else {
		$cleaned_phone = wp_strip_all_tags($content);
	}
	$label = 'Telephone';
	$phone_object = '
	<div class="media signpost signpost-phone">
		<div class="media-left">
				<i class="media-object fas fa-phone fa-lg shortcode-icon" aria-hidden="true" title="' . $label . '"></i>
		</div>
		<div class="media-body"><p>'. $cleaned_phone . '</p></div>
	</div>';

	return $phone_object;
}

add_shortcode( 'signpost_phone', 'hw_signpost_shortcode_signpost_phone_object' );

/* Media object SMS/TEXT
------------------------ */

function hw_signpost_shortcode_signpost_text_object( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'text' => '01494 32 48 32', // sms number for the signpost
	), $atts );

	if ( empty( $content ) ) {
		$cleaned_text = wp_strip_all_tags($a['text']);
	} else {
		$cleaned_text = wp_strip_all_tags($content);
	}
	$label = 'Text Message Number';
	$text_object = '
	<div class="media signpost signpost-text">
		<div class="media-left">
				<i class="media-object fas fa-sms fa-lg shortcode-icon" aria-hidden="true" title="' . $label . '"></i>
		</div>
		<div class="media-body"><p>'. $cleaned_text . '</p></div>
	</div>';

	return $text_object;
}

add_shortcode( 'signpost_text', 'hw_signpost_shortcode_signpost_text_object' );

/* Media object signpost

This inserts the content of a signpost as a callout

------------------------ */

function hw_signpost_shortcode_signpost_callout( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'signpost_id' => (int)'49784', // this is the A&E signpost
		'hide_title'  => 'false', // set to false by default
	), $atts, 'embed_signpost' );

	// fetch the signpost
	$content_post = get_post($a['signpost_id']);
	// get and clean up the content and title
	$content = apply_filters('the_content', $content_post->post_content);
	$title = apply_filters('the_title', $content_post->post_title);
	$content = do_shortcode($content);

	// typecast
	$a['hide_title'] = filter_var( $a['hide_title'], FILTER_VALIDATE_BOOLEAN );
	$label = 'Attention';
	$signpost_object = '
	<div class="media callout callout-signpost">
		<div class="media-left callout">
				<i class="media-object fas fa-map-signs fa-2x shortcode-icon" aria-hidden="true" title="' . $label . '"></i>
		</div>
		<div class="media-body callout">';
		if ( ! $a['hide_title'] ) {
			$signpost_object .= '<h3>' . $title . '</h3>';
		}
		$signpost_object .= $content . '</div>
	</div>';

	return $signpost_object;
}

add_shortcode( 'embed_signpost', 'hw_signpost_shortcode_signpost_callout' );

/*	Add a special bootstrap accordion panel with [signpost_panel title="Step 1 of X" signpost_id="54673"] - this tag is self-closing
		Based on the supplied signpost_id, this fetches a signpost Post and displays the content (without the title)
		in a bootstrap accordion panel.

    Requires the scaffold-widget-tweaks plugin
*/

function hwbucks_shortcode_signpost_accordion_panel( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'title' => 'Step 1',
			'signpost_id' => (int)'49784', // this is the A&E signpost
			'expanded' => 'false', // set true to expand first panel
		), $atts );

		// fetch the signpost
		$content_post = get_post($a['signpost_id']);
		// get and clean up the content and title
		$content = apply_filters('the_content', $content_post->post_content);
		$title = apply_filters('the_title', $content_post->post_title);
		$content = do_shortcode($content);

		// this depends on the user
		// if the expanded attribute is set to true the panel will be expanded automatically.
		if ($a['expanded'] == 'true') {
			$panel_heading_class = '';
			$panel_collapse_class = ' in';
		} else {
		// bootstrap JS adds the collapsed class on toggle but we want to start with it so we can style panels collapsed on load without the JS firing
			$panel_heading_class = ' collapsed';
			$panel_collapse_class = '';
		}

		$accordion_output_start = '
	<div class="panel panel-default">
		<div class="panel-heading' . $panel_heading_class . '" data-toggle="collapse" data-parent="#accordion" data-target="#' . $a['signpost_id'] . '">
			<h4 class="panel-title"><i class="fas fa-caret-right" aria-hidden="true"></i>' . $a['title'] . '</h4>
		</div>
		<div id="' . $a['signpost_id'] . '" class="panel-collapse collapse' . $panel_collapse_class . '">
			<div class="panel-body">' . $content;

		$accordion_output_end = '
			</div>
		</div>
	</div>';

	if(is_user_logged_in()){
		$accordion_output_start .= '<p class="edit-signpost"><a href="'. get_edit_post_link($a['signpost_id']) . '">Edit signpost</a></p>';
	};

	return $accordion_output_start . $accordion_output_end;
}

add_shortcode('signpost_panel', 'hwbucks_shortcode_signpost_accordion_panel');

?>
