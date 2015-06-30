<?php

/**
 * Call Methods class
 *
 * Used like helpers class, to use diferent functionality from one place.
 * All methods are static, no objects are created, this is only for direct call.
 *
 * Used with Diamond_Print::HelpMethod()
 *
 * @package WordPress
 * @subpackage Diamond
 */

class Diamond_Print {

	/**
	 * Print message from php. Used as for debugging or user message.
	 *
	 * @since v1.0.0
	 */
	public static function message( $msg, $class = 'notice' ) {

		// Print the surounding div and the type of message.
		echo "<div class='message-box $class'>";
		echo "<p>$msg</p>";
		echo "</div>";

	}

	/**
	 * When the class is used, it will be callsed " Diamond_Breadcrumb::print() ".
 	 * All the rest of the classes are protected. There is no need of initialization,
 	 * so no constructors will be created. (not created to work with parameters)
	 *
	 * @since v1.0.0
	 */
	public static function breadcrumbs() {

		// Initialise the object for a breadcrumb
		$bc = new Diamond_Breadcrumb();

		// One method to rule them all!
		$bc->display();

	}

	/**
	 * Category printed on screen.
	 *
	 * @param bool $print_link Print link if TRUE
	 * @since  v1.0.0
	 */
	public static function category_name( $print_link = FALSE ) {

		// Get the most important - the category. (array of objects, we take the first one always)
		$post_category = get_the_category();

		// Print the link of category
		if( $print_link ) {

			$post_category_link = get_category_link( $post_category[0]->cat_ID );
			echo "<a href='{$post_category_link}'>{$post_category[0]->name}</a>";

		}
		else echo $post_category[0]->name;
	}

}