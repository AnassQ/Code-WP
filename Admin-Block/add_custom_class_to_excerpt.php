function Anass_custom_excerpt($excerpt) {
  $excerpt = str_replace( "<p", "<p class=\"box\"", $excerpt );
  return $excerpt;
}
add_filter('the_excerpt', 'Anass_custom_excerpt');
