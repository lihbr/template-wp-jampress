<?php
/**
 * Modify the saved json path
 * Make sure the directory is set to 755 at least
 * @param  string $path the old path
 * @return string       return new path
 */
function jamPress_acf_json_save_point( $path ) {

  // update path
  $path = get_stylesheet_directory() . '/acf-json';

  // return
  return $path;

}
add_filter( 'acf/settings/save_json', 'jamPress_acf_json_save_point' );

/**
 * Modify the loaded json path
 * @param  array $paths old path
 * @return array        new path
 */
function jamPress_my_acf_json_load_point( $paths ) {

  // remove original path (optional)
  unset( $paths[ 0 ] );

  // append path
  $paths[] = get_stylesheet_directory() . '/acf-json';

  // return
  return $paths;

}
add_filter( 'acf/settings/load_json', 'jamPress_my_acf_json_load_point' );

/**
 * jamPress_is_searcheable list all the custom fields and taxonomies we want to include in our search query
 * @return array list of custom fields
 */
function jamPress_is_searcheable(){
  $list_searcheable = array(
    'title',
    'sub_title',
    'excerpt_short',
    'excerpt_long',
    'brand_logo',
    'brand_product_type',
    'brand_article',
    'brand-category',
    'brand-made_type'
  );
  return $list_searcheable;
}

/**
 * jamPress_advanced_custom_search search
 * that encompasses ACF/advanced custom fields
 * and taxonomies and split expression before request
 *
 * @param  query-part/string      $where    the initial "where" part of the search query
 * @param  object                 $wp_query
 * @return query-part/string      $where    the "where" part of the search query as we customized
 *
 * see https://vzurczak.wordpress.com/2013/06/15/extend-the-default-wordpress-search/
 * credits to Vincent Zurczak for the base query structure/spliting tags section
 */
function jamPress_advanced_custom_search( $where, $wp_query ) {
  global $wpdb;
  global $table_prefix;
  if ( empty( $where ) )
    return $where;

  // get search expression
  $terms = $wp_query->query_vars[ 's' ];

  // explode search expression to get search terms
  $exploded = explode( ' ', $terms );
  if( $exploded === FALSE || count( $exploded ) == 0 )
    $exploded = array( 0 => $terms );

  // reset search in order to rebuilt it as we whish
  $where = '';

  // get searcheable_acf, a list of advanced custom fields you want to search content in
  $list_searcheable_acf = jamPress_is_searcheable();
  foreach( $exploded as $tag ) {
    $where .= "
      AND (
        (" . $table_prefix . "posts.post_title LIKE '%$tag%')
        OR (" . $table_prefix . "posts.post_content LIKE '%$tag%')
        OR EXISTS (
          SELECT * FROM " . $table_prefix . "postmeta
            WHERE post_id = " . $table_prefix . "posts.ID
              AND (";
    foreach ( $list_searcheable_acf as $searcheable_acf ) {
        if ( $searcheable_acf == $list_searcheable_acf[0] ) {
          $where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
        } else {
          $where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
        }
    }
    $where .= ")
      )
      OR EXISTS (
        SELECT * FROM ". $table_prefix . "comments
        WHERE comment_post_ID = " . $table_prefix . "posts.ID
          AND comment_content LIKE '%$tag%'
      )
      OR EXISTS (
        SELECT * FROM " . $table_prefix . "terms
        INNER JOIN " . $table_prefix . "term_taxonomy
          ON " . $table_prefix . "term_taxonomy.term_id = " . $table_prefix . "terms.term_id
        INNER JOIN " . $table_prefix . "term_relationships
          ON " . $table_prefix . "term_relationships.term_taxonomy_id = " . $table_prefix . "term_taxonomy.term_taxonomy_id
        WHERE (
        taxonomy = 'post_tag'
          OR taxonomy = 'category'";
        foreach ( $list_searcheable_acf as $searcheable_acf ) {
          $where .= "OR taxonomy = '$searcheable_acf'";
        }
        $where .= "
        )
          AND object_id = " . $table_prefix . "posts.ID
          AND " . $table_prefix . "terms.name LIKE '%$tag%'
      )
    )";
  }

  return $where;
}

add_filter( 'posts_search', 'jamPress_advanced_custom_search', 500, 2 );
