<?php

/**
 * Get Methods class
 *
 * Used like helpers class, to use diferent functionality from one place.
 * All methods are static, no objects are created, this is only for direct call.
 *
 * Used with Dimaond_Get::HelpMethod()
 *
 * @package WordPress
 * @subpackage Dimaond
 */


class Diamond_Get {

	/**
	 * Return the category name or name and link to the category page.
	 *
	 * @see Dimaond_Print::category_name()
	 * @since  v1.0.0
	 */
	public static function category_name( $print_link = FALSE ) {

		// Get the most important - the category. (array of objects, we take the first one always)
		// If there is nothing, we just return empty string so there are no issues from
		// content side
		if( ! $post_category = get_the_category() ) {
			return "";
		}

		// Print the link of category
		if( $print_link ) {

			$post_category_link = get_category_link( $post_category[0]->cat_ID );
			return "<a href='{$post_category_link}'>{$post_category[0]->name}</a>";

		}

		else return $post_category[0]->name;
	}

}