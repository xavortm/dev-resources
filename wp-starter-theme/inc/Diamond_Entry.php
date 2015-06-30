<?php

/**
 * Get and proccess content that is related to the blog posts like
 * number of words, remaining to read and such sort of functions
 * and print it or return a value. In this class are also functions
 * related to the comments area.
 *
 * Used with Dimaond_Entry::HelpMethod()
 *
 * @package WordPress
 * @subpackage Dimaond
 */


class Diamond_Entry {

	/**
	 * Print the count of words the article has.
	 *
	 * @since v1.0.0
	 */
	public static function word_count() {
		global $post;
		echo str_word_count( $post->post_content );
	}

	/**
	 * Return the count of words the article has.
	 *
	 * @since v1.0.0
	 * @return int The number of words in article
	 */
	public static function get_word_count() {
		global $post;
		return str_word_count( $post->post_content );
	}

	/**
	 * Print the author link.
	 *
	 * Because of the weird actions from the build in to the core function the_author(  ) i decided
	 * to write my own function. This will print on the screen ( by the right way ) who is the author
	 * and a link to the posts by the given author. No parameters are needed.
	 *
	 * @uses get_the_author_meta()
	 * @uses get_the_author()
	 * @uses get_author_posts_url()
	 * @since 1.0.0
	 * @return Displays the post author link and name.
	 */
	public static function author_link(){
		$link = get_author_posts_url( get_the_author_meta( 'ID' ) );
		echo '<a href="'. $link .'">'. get_the_author() .'</a>';
	}

	/**
	 * Must be called inside the loop
	 * @return [type] [description]
	 */
	public static function post_thumbnail() {

		if ( has_post_thumbnail() ) {
			$attr = array(
				'class' => "thumbnail-img"
			);

			the_post_thumbnail();
		}
		else {
			echo '<img class="thumbnail-img" src="' . get_bloginfo( 'stylesheet_directory' ) . '/assets/images/thumbnail-default.png" />';
		}

	}

}