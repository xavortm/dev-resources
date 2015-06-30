<?php

class RecentPosts extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'Diamond_recent_posts',
			__('Diamond Recent Posts', THEME_DOMAIN_NAME),
			array( 'description' => __( 'Display recent posts for Diamond theme.', THEME_DOMAIN_NAME ), )
		);

	}

	/**
	 * Front-end display of widget.
	 *
 	 * @see WP_Widget::widget()
 	 *
 	 * @param array $args     Widget arguments.
 	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// Only make the first posts big.
		$flag = false;

		// Display all the content of the widget. (this is the "front-end") ?>
		<?php $query = new WP_Query( '&posts_per_page=' . $instance['limit'] . '&cat=' . $instance['cat_id']); ?>

		<?php
		if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			if( $flag == false ) {
				?>

				<div class="featured">
					<?php Diamond_Entry::post_thumbnail('medium'); ?>
					<h4 class="featured-title"><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h4>
					<div class="featured-content">
						<?php the_excerpt(); ?>
					</div>
				</div><!-- /featured -->

				<?php
				$flag = true;
				continue;
			} else {
			// Show the content ?>
			<div>
				<div class="recent-posts-thumbnail"><?php Diamond_Entry::post_thumbnail('small'); ?></div>
				<div class="recent-posts-content">
					<h5 class='title'><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h5>
					<span class="comments"><?php comments_number( 'no responses', 'one response', '% responses' ); ?></span>
				</div>

			</div>
			<?php } // end while
			}
		} else {
			// If no posts were found, message will be printed. (or send regular message).
			// echo '<strong>No Posts were found!</strong>';
			Diamond_Print::message("No posts found!");
		} ?>

		<?php

		echo $args['after_widget'];

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		// For all inputs
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? strip_tags( $new_instance['limit'] ) : '';
		$instance['cat_id'] = ( ! empty( $new_instance['cat_id'] ) ) ? strip_tags( $new_instance['cat_id'] ) : '';


		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		// The validation for title
		if ( isset( $instance[ 'title' ] ) )
				$title = $instance[ 'title' ];
		else  	$title = __( 'New title', THEME_DOMAIN_NAME );

		// Validation for The amount of posts that will be displayed
		if ( isset( $instance[ 'limit' ] ) )
				$limit = $instance[ 'limit' ];
		else  	$limit = __( '3', THEME_DOMAIN_NAME );

		// Category ID - Should have better way, but for now this.
		if ( isset( $instance[ 'cat_id' ] ) )
				$cat_id = $instance[ 'cat_id' ];
		else  	$cat_id = __( '0', THEME_DOMAIN_NAME );


		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'diamond'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Posts Limit:' , 'diamond'); ?></label>
			<input size='3' id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'cat_id' ); ?>"><?php _e( 'Posts Category:', THEME_DOMAIN_NAME ); ?></label>
			<input size='3' id="<?php echo $this->get_field_id( 'cat_id' ); ?>" name="<?php echo $this->get_field_name( 'cat_id' ); ?>" type="text" value="<?php echo esc_attr( $cat_id ); ?>" />
		</p>
		<?php

	}

}
