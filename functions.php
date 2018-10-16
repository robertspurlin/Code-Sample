<?php
/**
 * Places and Perspectives functions and definitions
 *
 * @link http://dsi.mtsu.edu/places
 *
 * @package Places_and_Perspectives
 * 
 * TABLE OF CONTENTS:
 * 1. Underscores Boilerplate
 * 2. Custom functionality
 * 
 */


 /**
 * -------------------------------------------------------------------------------------------------------
 * BEGIN Underscores Boilerplate
 * -------------------------------------------------------------------------------------------------------
 */

if ( ! file_exists( get_template_directory() . '/class-wp-bootstrap-navwalker.php' ) ) {
	// file does not exist... return an error.
	return new WP_Error( 'class-wp-bootstrap-navwalker-missing', __( 'It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {
	// file exists... require it.
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}

if ( ! function_exists( 'places_and_perspectives_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function places_and_perspectives_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Places and Perspectives, use a find and replace
		 * to change 'places-and-perspectives' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'places-and-perspectives', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'places-and-perspectives' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'places_and_perspectives_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'places_and_perspectives_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function places_and_perspectives_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'places_and_perspectives_content_width', 640 );
}
add_action( 'after_setup_theme', 'places_and_perspectives_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */

function places_and_perspectives_scripts() {
	wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/inc/bootstrap/css/bootstrap.min.css');
	wp_enqueue_style( 'places-and-perspectives-style', get_stylesheet_uri() );

	wp_enqueue_script('jquery', get_template_directory_uri() . '/inc/jquery/jquery.min.js');
	wp_enqueue_script( 'places-and-perspectives-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/inc/bootstrap/js/bootstrap.min.js', array('jquery'), '20181012', true );
	wp_enqueue_script( 'places-and-perspectives-script', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '20181012', true );
	wp_enqueue_script( 'places-and-perspectives-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'places_and_perspectives_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * ------------------------------------------------------------------------------------------------------ 
 * END Understores Boilerplate
 * BEGIN Custom functionality
 * Author: Robert Spurlin
 * ------------------------------------------------------------------------------------------------------
 */

/**
 * Register widget area.
 */

function places_and_perspectives_widgets_init() {
	register_sidebar(array(
		'name'          => esc_html__( 'Footer Logos', 'places-and-perspectives' ),
		'id'            => 'footer-logos',
		'description'   => esc_html__( 'Add footer logos here.', 'places-and-perspectives' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',	
	));
}

add_action( 'widgets_init', 'places_and_perspectives_widgets_init' );

/**
 * The initialization of the story post type.
 */

function init_story_posttype() {
	$labels = array(
	'name' 					=>	 __('Stories'),
	'singular_name' 		=> 	 __('Story'),
	'add_new_item'          =>   __('Add New Story'),
	'all_items'             =>   __('All Stories'),
	'edit_item'             =>   __('Edit Story'),
	'new_item'              =>   __('New Story'),
	'view_item'             =>   __('View Stories'),
	'not_found'             =>   __('No Stories Found'),
	'not_found_in_trash'    =>   __('No Stories Found in Trash')
  	);

	$supports = array(
	'title',
	'editor',
	'thumbnail'
  	);

	$args = array(
	'labels'        =>   $labels,
	'menu_icon'     =>   'dashicons-book-alt',
	'description'   =>   __('Display Staff in a custom post type'),
	'public'        =>   true,
	'show_in_menu'  =>   true,
	'has_archive'   =>   true,
	'supports'      =>   $supports,
	'taxonomies' 	=> 	 array('category')
	);
	  
	register_post_type('story', $args);
}

add_action('init', 'init_story_posttype');

/**
 * All of the Custom Meta Box code in one class.
 */

class Custom_Meta_Boxes {
 
    // Constructor. Loads function on post editing and new posts. 
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
    }

    // Meta box initialization.
    public function init_metabox() {
		// Pushes metaboxes to top
		add_action( 'edit_form_after_title', array( $this, 'metabox_to_top')	   );
		// Adds the metaboxes
		add_action( 'add_meta_boxes', 		 array( $this, 'add_metabox'  )		   );
		// Handles the saving of all metaboxes
        add_action( 'save_post',      		 array( $this, 'save_metabox' ), 10, 2 );
	}
	
	// Pushes metabox to top if the metabox is set to 'advanced'. 
	public function metabox_to_top() {
		global $post, $wp_meta_boxes;
		do_meta_boxes(get_current_screen(), 'advanced', $post);
		unset($wp_meta_boxes[get_post_type($post)]['advanced']);
	}
 
    // Adds the meta box. There is a different function for each template.
    public function add_metabox() {
		global $post;
		$pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

		if ($pageTemplate == 'page-templates/home.php') {
			add_meta_box(
				'home_first_section', __( 'Hero Section', 'textdomain' ),
				array( $this, 'home_first_render_metabox' ), 'page', 'advanced', 'high'
			);
			add_meta_box(
				'home_map_section', __( 'Map Section', 'textdomain' ),
				array( $this, 'home_map_render_metabox' ), 'page', 'advanced', 'high'
			);

		 /**
		  * general_render_metabox is being re-used for all pages except home.
		  * It is just one metabox used to render the text in the hero section below title. 
		  */
		} else {
			add_meta_box(
				'general_first_section', __( 'Hero Section', 'textdomain' ),
				array( $this, 'general_render_metabox' ), 'page', 'advanced', 'high'
			);	
		}

		// Story meta boxes.
		add_meta_box(
			'story_first_section', __( 'Description and Link', 'textdomain' ),
			array( $this, 'story_render_metabox' ), 'story', 'advanced', 'high'
		);
    }
 
	// The first meta box for the home page.
    public function home_first_render_metabox( $post ) {
		global $post;
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		
		$home_title = get_post_meta( $post->ID, 'home_title', true );
		$home_description = get_post_meta( $post->ID, 'home_description', true );

		if( empty( $home_title ) ) $home_title = '';
		if( empty( $home_description ) ) $home_description = '';


		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="home_title" class="home_title_label">' . __( 'Title', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<textarea style="width:100%" id="home_title" name="home_title">'. esc_attr__( $home_title ) .'</textarea>';
		echo '			<p class="description">' . __( 'The large text displayed in the first section of the home page.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="home_description" class="home_description_label">' . __( 'Description', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<textarea style="width:100%" id="home_description" name="home_description" >'. esc_attr__( $home_description ) . '</textarea>';
		echo '			<p class="description">' . __( 'The description (in smaller text) below the large text.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';
	}
	

	// Second meta box. Uses rich text editor for the text right before the map. 
	public function home_map_render_metabox( $post ) {
		global $post;
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		
		$map_title = get_post_meta( $post->ID, 'map_title', true );
		if( empty( $map_title ) ) $map_title = '';

		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="map_title" class="map_title_label">' . __( 'Map Title', 'text_domain' ) . '</label></th>';
		echo '		<td>';
						wp_editor( $map_title, 'map_title', $settings = array('textarea'=>'map_title') );
		echo '			<p class="description">' . __( 'The text displayed right before the map.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';
	}
	
	// General meta box. Renders for everything except home. 
	public function general_render_metabox( $post ) {
		global $post;
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		
		$about_description = get_post_meta( $post->ID, 'about_description', true );

		if( empty( $about_description ) ) $about_description = '';

		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="about_description" class="about_description_label">' . __( 'Title', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<textarea style="width:100%" id="about_description" name="about_description">'. esc_attr__( $about_description ) .'</textarea>';
		echo '			<p class="description">' . __( 'The text displayed below the title in the first section.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';
	}

	// Story meta boxes. Renders description and the link itself for each story.  
	public function story_render_metabox( $post ) {
		global $post;
		wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		
		$story_description = get_post_meta( $post->ID, 'story_description', true );
		$story_link = get_post_meta( $post->ID, 'story_link', true );

		if( empty( $story_description ) ) $story_description = '';
		if( empty( $story_link ) ) $story_link = '';

		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="story_description" class="story_description_label">' . __( 'Description', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<textarea style="width:100%" id="story_description" name="story_description">'. esc_attr__( $story_description ) .'</textarea>';
		echo '			<p class="description">' . __( 'The short description below the picture.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="story_link" class="story_link_label">' . __( 'Story Link', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<textarea style="width:100%" id="story_link" name="story_link" >'. esc_attr__( $story_link ) . '</textarea>';
		echo '			<p class="description">' . __( 'The link to the story map.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';
	}
 
    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';
 
        // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }
 
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
 
        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
 
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }
 
        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
		}
		
		// Sanitize and update metadata. Divided into templates.

		// Home
		$home_new_title = isset( $_POST[ 'home_title' ] ) ? sanitize_text_field( $_POST[ 'home_title' ] ) : '';
		$home_new_description = isset( $_POST[ 'home_description' ] ) ? sanitize_text_field( $_POST[ 'home_description' ] ) : '';
		update_post_meta( $post_id, 'home_title', $home_new_title );
		update_post_meta( $post_id, 'home_description', $home_new_description );

		// Home, map title. NOTE: not being sanitized to keep html tags. 
		$map_new_title = isset( $_POST[ 'map_title' ] ) ?  $_POST[ 'map_title' ]  : '';
		update_post_meta( $post_id, 'map_title', $map_new_title );

		// General 
		$about_new_description = isset( $_POST[ 'about_description' ] ) ? sanitize_text_field( $_POST[ 'about_description' ] ) : '';
		update_post_meta( $post_id, 'about_description', $about_new_description );

		// Stories
		$story_new_description = isset( $_POST[ 'story_description' ] ) ? sanitize_text_field( $_POST[ 'story_description' ] ) : '';
		$story_new_link = isset( $_POST[ 'story_link' ] ) ? sanitize_text_field( $_POST[ 'story_link' ] ) : '';
		update_post_meta( $post_id, 'story_description', $story_new_description );
		update_post_meta( $post_id, 'story_link', $story_new_link );

    }
}

// The actual call that initalizes the custom meta boxes.  
new Custom_Meta_Boxes();

