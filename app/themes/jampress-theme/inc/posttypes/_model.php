<?php
//add_action( 'init', 'jamPress_custom_post_type_model' );
function jamPress_custom_post_type_model() {
    $post_type                = 'model';
    $post_type_plural         = 'models';
    $ucfirst_post_type        = ucfirst($post_type);
    $ucfirst_post_type_plural = ucfirst($post_type_plural);
    $slug                     = $post_type;

    $post_type_support        = 'posts';
    $labels                   = array(
        'name'               => _x( $ucfirst_post_type_plural, "$ucfirst_post_type : Post name",             'jamPress' ),
        'singular_name'      => _x( $ucfirst_post_type,        "$ucfirst_post_type : Post name singular",    'jamPress' ),
        'all_items'          => _x( "All $post_type_plural",   "$ucfirst_post_type : All posts",             'jamPress' ),
        'add_new'            => _x( "Add $post_type",          "$ucfirst_post_type : Add new",               'jamPress' ),
        'add_new_item'       => _x( "Add new $post_type",      "$ucfirst_post_type : Add new post",          'jamPress' ),
        'edit_item'          => _x( "Edit $post_type",         "$ucfirst_post_type : Edit post",             'jamPress' ),
        'new_item'           => _x( "New $post_type",          "$ucfirst_post_type : New post",              'jamPress' ),
        'view_item'          => _x( "View $post_type",         "$ucfirst_post_type : See post",              'jamPress' ),
        'search_items'       => _x( "Find $post_type",         "$ucfirst_post_type : Search post",           'jamPress' ),
        'not_found'          => _x( "No result",               "$ucfirst_post_type : Post not found",        'jamPress' ),
        'not_found_in_trash' => _x( "No result",               "$ucfirst_post_type : Post not found in bin", 'jamPress' ),
        'parent_item_colon'  => _x( "Parent $post_type:",      "$ucfirst_post_type : Parent post",           'jamPress' ),
        'menu_name'          => _x( $ucfirst_post_type_plural, "$ucfirst_post_type : Menu name",             'jamPress' ),
    );

    $args = array(
        'labels'              => $labels,
        'hierarchical'        => false,
        'supports'            => array( 'title', 'thumbnail', 'editor' ),
        'public'              => true, // single.php
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-slides',
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false, // in search
        'has_archive'         => false, // archive.php
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => array( 'slug' => $slug )
    );

    register_post_type($slug, $args );

    $category = 'example';
    register_taxonomy(
        $category, // slug
        array($slug), // posttype
        array(
            'label'        => __( ucfirst($category), 'jamPress' ), // label
            'rewrite'      => array( 'slug' => $category ), // rewrite
            'hierarchical' => true, // true: categorie, false: tag
        )
    );

}
