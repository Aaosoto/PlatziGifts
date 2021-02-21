<?php

function init_template(){

    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );

    register_nav_menus(
        array(
            'top_menu' => 'Menú Principal'
        )
    );

}

add_action( 'after_setup_theme','init_template' );

function assets(){

    wp_register_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css' ,'', '5.0', 'all');
    wp_register_style( 'Montserrat', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap', '', '1.0', 'all' );

    wp_enqueue_style( 'Estilos', get_stylesheet_uri(  ), array('bootstrap','Montserrat'), '1.0', 'all');

    wp_register_script('popper','https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js', '','2.6', true);
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js', array('jquery','popper'), '5.0', true);

    wp_enqueue_script('custom', get_template_directory_uri().'/assets/js/custom.js', '', 1.0, true);
}

add_action( 'wp_enqueue_scripts', 'assets' );

function sidebar(){
    register_sidebar(
        array(
            'name' => 'Pie de página',
            'id' => 'footer',
            'description' => 'Zona de Widgets para pie de página',
            'before_title' => '<p>',
            'after_title' => '</p>',
            'before_widget' => '<div id="%1$s" class="%2$s" >',
            'after_widget' => '</div>'
        )
    );
}

add_action('widgets_init' , 'sidebar');

function productos_type(){
    $labels = array(
        'name' => 'Products',
        'singular_name' => 'Product',
        'manu_name' => 'Products',
    );

    $args = array(
        'label'  => 'Productos', 
        'description' => 'Productos de Platzi',
        'labels'       => $labels,
        'supports'   => array('title','editor','thumbnail', 'revisions'),
        'public'    => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-cart',
        'can_export' => true,
        'publicly_queryable' => true,
        'rewrite'       => true,
        'show_in_rest' => true

    );    
    register_post_type('producto', $args);
}

add_action('init', 'productos_type');



function pgRegisterTax(){
    $args = array(
        'hierachical' => true,
        'labels' => array(
            'name' => 'Categorías de Productos',
            'singular_name' => 'Categoría de Productos'
        ),
        'show_in_nav_menu' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'categoria-productos')
    );
    register_taxonomy( 'categoria-productos', array('producto'), $args);
}

add_action( 'init', 'pgRegisterTax' );