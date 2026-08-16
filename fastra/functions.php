<?php
/**
 * Fastra theme functions and definitions.
 */

// Theme setup
function fastra_setup() {
    // Title tag support
    add_theme_support( 'title-tag' );

    // Post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Custom logo
    add_theme_support( 'custom-logo' );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // Register navigation menu
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'fastra' ),
    ) );
}
add_action( 'after_setup_theme', 'fastra_setup' );

// Enqueue styles and scripts
function fastra_assets() {
    // Main stylesheet (style.css)
    wp_enqueue_style( 'fastra-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Additional CSS (assets/css/main.css)
    wp_enqueue_style( 'fastra-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0' );

    // JavaScript (assets/js/main.js)
    wp_enqueue_script( 'fastra-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'fastra_assets' );

// Customizer settings
function fastra_customize_register( $wp_customize ) {

    // Section: Theme Colors
    $wp_customize->add_section( 'fastra_colors', array(
        'title'    => __( 'Theme Colors', 'fastra' ),
        'priority' => 30,
    ) );

    // Primary Color
    $wp_customize->add_setting( 'fastra_primary_color', array(
        'default'           => '#0073aa',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'fastra_primary_color', array(
        'label'    => __( 'Primary Color', 'fastra' ),
        'section'  => 'fastra_colors',
        'settings' => 'fastra_primary_color',
    ) ) );

    // Section: Layout
    $wp_customize->add_section( 'fastra_layout', array(
        'title'    => __( 'Layout', 'fastra' ),
        'priority' => 31,
    ) );

    // Container Width
    $wp_customize->add_setting( 'fastra_container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'fastra_container_width', array(
        'label'       => __( 'Container Width (px)', 'fastra' ),
        'section'     => 'fastra_layout',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 800,
            'max'  => 1600,
            'step' => 10,
        ),
    ) );
}
add_action( 'customize_register', 'fastra_customize_register' );

// Apply customizer values to frontend
function fastra_customizer_css() {
    ?>
    <style type="text/css">
        :root {
            --fastra-primary: <?php echo esc_attr( get_theme_mod( 'fastra_primary_color', '#0073aa' ) ); ?>;
            --fastra-container: <?php echo absint( get_theme_mod( 'fastra_container_width', 1200 ) ); ?>px;
        }

        a {
            color: var(--fastra-primary);
        }

        .container {
            max-width: var(--fastra-container);
        }
    </style>
    <?php
}
add_action( 'wp_head', 'fastra_customizer_css' );