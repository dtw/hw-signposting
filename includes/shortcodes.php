<?php // signposts shortcode - lists categories for signposts

function signposts_list_categories_with_featured_images() { 






// List LOCAL SERVICES with link to each
            $terms = get_terms( 'signpost_categories' );
             if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                 $stuff = '<div id="signposts-selector" class="row">';
                 foreach ( $terms as $term ) {

    $the_term_icon = get_term_meta( $term->term_id, 'icon', true );

                   $stuff = $stuff . '<div class="col-md-3 signpost_container">
				   <a class="' . $term->slug . '" href="' . get_term_link( $term ) . '">
				   <img class="img_signpost_category" width="150px" src="' . $the_term_icon . '" alt="' . $term->name . '" />
				   </a>
				   <p>
					<a class="' . $term->slug . '" href="' . get_term_link( $term ) . '">
						' . $term->name . '
					</a>
				   </p>
				   </div>';
                    
                 }
                   $stuff = $stuff . '</div>';
             }


return $stuff;



}

add_shortcode('signposts', 'signposts_list_categories_with_featured_images');

