<?php 

add_action('widgets_init','anass_mostcommented');

function anass_mostcommented() {
	register_widget('anass_mostcommented');
	}

class anass_mostcommented extends WP_Widget {
	function anass_mostcommented() {
			
		$widget_ops = array('classname' => 'mostcommented','description' => 'التدوينات الأكثر تعليقاََ');		
		$this->WP_Widget('mostcommented','AnassQ -الأكثر تعليقا',$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
	
		
		echo $before_widget;

		
		if ( $title )
			echo $before_title . $title . $after_title;
?>

<div class="mostcommented">
  
		<ul>

			<?php $popular = new WP_Query('orderby=comment_count&posts_per_page=4&ignore_sticky_posts=1'); ?>
			<?php $count = 1; ?>

			<?php while ($popular->have_posts()) : $popular->the_post(); ?>

			<li id="comment<?php echo $count++ ?>">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> (<?php comments_number('0','1','%'); ?>)
			</li>

			<?php endwhile; ?>
		</ul>

</div>
<?php 
		
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['feed_url'] = strip_tags( $new_instance['feed_url'] );

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>">العنوان :</label>
  <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
</p>

<?php 
}
	} //end class
