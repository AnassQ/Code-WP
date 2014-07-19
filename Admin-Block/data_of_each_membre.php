//this code snippet will show to admin what to evrey membre in your blog what he add {Post - Categories - ...}
//link : http://bit.ly/1nGACYi

add_action('manage_users_columns','compteur_posts');
function compteur_posts($column_headers) {
unset($column_headers['posts']);
$column_headers['custom_posts'] = 'المحتوى';
return $column_headers;
}

add_action('manage_users_custom_column','yoursite_manage_users_custom_column',10,3);

function yoursite_manage_users_custom_column($custom_column,$column_name,$user_id) {
if ($column_name=='custom_posts') {
$counts = _compteur_posts();
$custom_column = array();
if (isset($counts[$user_id]) && is_array($counts[$user_id]))
foreach($counts[$user_id] as $count) {
$link = admin_url() . "edit.php?post_type=" . $count['type']. "&author=".$user_id;
// admin_url() . "edit.php?author=" . $user->ID;
$custom_column[] = " {$count['count']} <a href={$link}>{$count['label']}</a> <br />";
}
$custom_column = implode("\n",$custom_column);
if (empty($custom_column))
$custom_column = "لم يضف أي شيء";
$custom_column = "{$custom_column}";
}
return $custom_column;
}

function _compteur_posts() {
static $counts;
if (!isset($counts)) {
global $wpdb;
global $wp_post_types;
$sql = <<<SQL
SELECT
post_type,
post_author,
COUNT(*) AS post_count
FROM
{$wpdb->posts}
WHERE 1=1
AND post_type NOT IN ('revision','nav_menu_item')
AND post_status IN ('publish','pending', 'draft')
GROUP BY
post_type,
post_author
SQL;
$posts = $wpdb->get_results($sql);
foreach($posts as $post) {
$post_type_object = $wp_post_types[$post_type = $post->post_type];
if (!empty($post_type_object->label))
$label = $post_type_object->label;
else if (!empty($post_type_object->labels->name))
$label = $post_type_object->labels->name;
else
$label = ucfirst(str_replace(array('-','_'),' ',$post_type));
if (!isset($counts[$post_author = $post->post_author]))
$counts[$post_author] = array();
$counts[$post_author][] = array(
'label' => $label,
'count' => $post->post_count,
'type' => $post->post_type,
);
}
}
return $counts;
}
