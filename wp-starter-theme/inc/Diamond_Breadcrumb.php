<?php

/**
 * When the class is used, it will be callsed " Diamond_Breadcrumb::print() ".
 * All the rest of the classes are protected. There is no need of initialization,
 * so no constructors will be created. (not created to work with parameters)
 *
 * @package WordPress
 * @subpackage The Big Magazine
 */

class Diamond_Breadcrumb {

	private $separator = ' / '; 	// Setup variables

	/**
	 * Create the structure of the breadcrumbs. Here
	 * is the basic output of what is going to be printed
	 * on the screen.
	 *
	 * When the class is used, it will be callsed " Diamond_Breadcrumb::print() ".
	 * All the rest of the classes are protected. There is no need of initialization,
	 * so no constructors will be created. (not created to work with parameters)
	 *
	 * @since v1.0.0
	 */
	public function display() {

		$home_link = esc_url( home_url( '/' ) );
		$home_text = get_bloginfo( 'name' );

		// Build the link
		$bc_homelink = "<a href='{$home_link}'>{$home_text}</a>";

		// Start the breadcrumb building.
		echo "<span class='bc_message'>";

		// Home page link (its the root, its everywhere)
		echo "<a href='{$home_link}' class='active'>{$home_text}</a>";

		// If there are more pages that will be printed, then we put the separator.
		if( !is_front_page() ) { echo $this->separator; }

		// Build the breadcrumbs now.
		global $post;

		// Create all the rest from the breadcrumb
		$this->build( $post );

		// End the breadcrumbs
		echo "</span>";

	}

	/**
	 * This method is activeted if the page that the
	 * breadcrumbs is called is not home page, meaning there
	 * will be deeper link from current page to home page.
	 *
	 * @since v1.0.0
	 */
	private function build( $global_post ) {

		if( is_single() ) {
			$post_category = get_the_category();
			$post_category_link = get_category_link( $post_category[0]->cat_ID );

			// Build the link to the category.
			echo "<a href='{$post_category_link}'>{$post_category[0]->name}</a>";
			echo $this->separator;

			// Print the post title, no link is required.
			the_title();
		}
		elseif( is_category() ) {
			$category = get_the_category();
			$category_first = $category[0]->cat_ID;
			$category_parent = $category[0]->category_parent;

			// If the category has a parent, thats what is printed first
			if( $category_parent > 0 AND $category[0]->cat_name == get_cat_title( "", FALSE ) ) {
				echo get_category_parents( $category_parent, TRUE, $this->separator, FALSE );
			}

			echo single_cat_title( '', TRUE );

		}
		elseif ( is_tag() ) {
			echo 'Tags' . $this->separator;
			echo single_tag_title( '', FALSE );
		}
		elseif ( is_archive() ) {
			echo __("Archives", "thebigmag") . $this->separator;
			the_date();
		}
		elseif ( is_author() ) {
			$curauth = get_userdata(get_query_var('author'));
			echo $curauth->display_name;
		}
		elseif ( is_404() ) {
			echo __("404 - Page Not Found", "thebigmag");
		}
		elseif ( is_year() ) {
			echo get_the_time('Y');
		}
		elseif ( is_page() ) {
			the_title();
		}
		elseif ( is_search() ) {
			$output = "Search" . $this->separator;
			echo $output . get_query_var('s');
		}

	}

}