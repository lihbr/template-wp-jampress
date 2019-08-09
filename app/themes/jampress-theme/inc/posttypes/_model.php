<?php
//add_action( 'init', 'jamPress_custom_post_type_model' );
function jamPress_custom_post_type_model() {
    $post_type         = "model";
    $post_type_support = "posts";
    $labels            = array(
        'name'               => _x( 'Models', 'Postype : Nom post', 'jamPress' ),
        'singular_name'      => _x( 'Model', 'Postype : Nom post singulier', 'jamPress' ),
        'all_items'          => _x( 'All models', 'Postype : Tous les posts', 'jamPress' ),
        'add_new'            => _x( 'Add model', 'Postype : Ajouter un nouveau', 'jamPress' ),
        'add_new_item'       => _x( 'Add new model', 'Postype : Ajouter un nouveau post', 'jamPress' ),
        'edit_item'          => _x( "Edit model", 'Postype : Editer post',  'jamPress' ),
        'new_item'           => _x( 'New model', 'Postype : Nouveau post', 'jamPress' ),
        'view_item'          => _x( "View model", 'Postype : Voir post',  'jamPress' ),
        'search_items'       => _x( 'Find model', 'Postype : Chercher post',  'jamPress' ),
        'not_found'          => _x( 'No result', 'Postype : Post non trouver', 'jamPress' ),
        'not_found_in_trash' => _x( 'No result', 'Postype : Post non trouver dans la corbeille', 'jamPress' ),
        'parent_item_colon'  => _x( 'Parent model:', 'Postype : Post parent',  'jamPress' ),
        'menu_name'          => _x( 'Models', 'Postype : Nom menu',  'jamPress' ),
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
        'rewrite'             => array( 'slug' => $post_type )
    );

    register_post_type($post_type, $args );

    register_taxonomy(
        'exemple', // slug
        array($post_type), // posttype
        array(
            'label'        => __( 'Exemple', 'jamPress' ), // label
            'rewrite'      => array( 'slug' => 'exemple' ), // rewrite
            'hierarchical' => true, // true: categorie, false: tag
        )
    );

}
