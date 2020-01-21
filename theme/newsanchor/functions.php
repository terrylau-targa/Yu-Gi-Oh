<?php
/**
 * NewsAnchor functions and definitions
 *
 * @package NewsAnchor
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170; /* pixels */
}

if ( ! function_exists( 'newsanchor_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function newsanchor_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on NewsAnchor, use a find and replace
	 * to change 'newsanchor' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'newsanchor', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('thumb-large', 730);
	add_image_size('thumb-carousel', 410, 260, true);
	add_image_size('thumb-medium', 435);
	add_image_size('thumb-small', 80, 60, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'newsanchor' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'newsanchor_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // newsanchor_setup
add_action( 'after_setup_theme', 'newsanchor_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function newsanchor_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'newsanchor' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );


	//Footer widget areas
	$widget_areas = get_theme_mod('footer_widget_areas', '3');
	for ($i=1; $i<=$widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer ', 'newsanchor' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}	
}
add_action( 'widgets_init', 'newsanchor_widgets_init' );

//Custom widgets
require get_template_directory() . "/widgets/recent-posts.php";

/**
 * Enqueue Bootstrap
 */
function newsanchor_bootstrap() {
	wp_enqueue_style( 'newsanchor-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'newsanchor_bootstrap', 9 );

/**
 * Enqueue scripts and styles.
 */
function newsanchor_scripts() {

	wp_enqueue_style( 'newsanchor-body-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap');

	wp_enqueue_style( 'newsanchor-style', get_stylesheet_uri() );

	wp_enqueue_style( 'newsanchor-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.min.css' );	

	wp_enqueue_script( 'newsanchor-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '', true );				

	wp_enqueue_script( 'newsanchor-main', get_template_directory_uri() . '/js/main.js', array('jquery', 'imagesloaded'), '', true );	

	wp_enqueue_script( 'newsanchor-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( get_theme_mod('blog_layout') == 'masonry-layout' && (is_home() || is_archive()) ) {

		wp_enqueue_script( 'newsanchor-masonry-init', get_template_directory_uri() . '/js/masonry-init.js', array('masonry'), '', true );		
	}

	wp_enqueue_style( 'facts-custom-style', get_template_directory_uri() . '/css/customTheme.css' );
}
add_action( 'wp_enqueue_scripts', 'newsanchor_scripts' );

/**
 * Menu fallback
 */
function newsanchor_menu_fallback() {
	echo '<a class="menu-fallback" href="' . admin_url('nav-menus.php') . '">' . __( 'Create your menu here', 'newsanchor' ) . '</a>';
}

/**
 * Load html5shiv
 */
function newsanchor_html5shiv() {
    echo '<!--[if lt IE 9]>' . "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/js/html5shiv.js' ) . '"></script>' . "\n";
    echo '<![endif]-->' . "\n";
}
add_action( 'wp_head', 'newsanchor_html5shiv' ); 

/**
 * Excerpt length
 */
function newsanchor_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'newsanchor_excerpt_length', 11 );

/**
 * Set custom classes for the top menu items.
 */
function newsanchor_nav_menu_css_class( $classes = array(), $item, $args ) {
	static $top_level_count = 0;

    if($args->theme_location == 'primary'){

        if ( $item->menu_item_parent == 0 ) {
			$top_level_count++;

            if ($item->menu_order >= 0) {
                $classes[] = 'top-menu-item-' . $top_level_count % 6;
            }
        }
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'newsanchor_nav_menu_css_class', 10, 3 );

/**
 * Blog layout
 */
function newsanchor_blog_layout() {
	$layout = get_theme_mod('blog_layout','classic');
	return $layout;
}

/**
 * Single layout
 */
function newsanchor_single_layout() {
	if ( get_theme_mod('fullwidth_single') ) {
		return 'fullwidth';
	}
}

/**
 * Posts class
 */
function newsanchor_posts_clearfix( $classes ) {
	$classes[] = 'clearfix';
	return $classes;
}
add_filter( 'post_class', 'newsanchor_posts_clearfix' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load the carousel
 */
require get_template_directory() . '/inc/carousel.php';

/**
 * Dynamic styles
 */
require get_template_directory() . '/inc/styles.php';

/**
 * Gets the primary category set by Yoast SEO.
 *
 * @return array The category name, slug, and URL.
 */
function get_primary_category( $post = 0 ) {
    $cate_html = '';
	$category = get_the_category();
	$useCatLink = true;

	if ($category){
		$category_display = '';
		$category_link = '';
		if ( class_exists('WPSEO_Primary_Term') )
		{
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if (is_wp_error($term)) { 
				// Default to first category (not Yoast) if an error is returned
				$category_display = $category[0]->name;
				$category_link = get_category_link( $category[0]->term_id );
			} else { 
				// Yoast Primary category
				$category_display = $term->name;
				$category_link = get_category_link( $term->term_id );
			}
		} 
		else {
			// Default, display the first category in WP's list of assigned categories
				$category_display = $category[0]->name;
				$category_link = get_category_link( $category[0]->term_id );
			}
		}

		$cate_html .='<div class="category-name"><span>'.esc_html($category_display).'</span></div>';
		
		echo $cate_html;
}

/*Get primary in value*/
function return_primary_cate_name( $post = 0 ) {
	$category = get_the_category();
	$useCatLink = true;

	if ($category){
		$category_display = '';
		$category_link = '';
		if ( class_exists('WPSEO_Primary_Term') )
		{
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if (is_wp_error($term)) { 
				// Default to first category (not Yoast) if an error is returned
				$category_display = $category[0]->name;
			} else { 
				// Yoast Primary category
				$category_display = $term->name;
			}
		} 
		else {
			// Default, display the first category in WP's list of assigned categories
				$category_display = $category[0]->name;
			}
		}

		return $category_display;
}

//Set post view counter
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//Track post view
function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    wpb_set_post_views($post_id);
}
add_action( 'wp_head', 'wpb_track_post_views');

//Get post view
function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

//Custom article block HTML
function custom_article_block() {
	?>
	<div class="article">
		<div class="content">

			<div class="thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail('thumb-carousel'); ?>
					<?php else : ?>
					<?php echo '<img src="' . get_stylesheet_directory_uri() . '/images/placeholder.png"/>'; ?>
					<?php endif; ?>
				</a>
			</div>

			<div class="data">
				<div class="article-meta">
					<?php get_primary_category(); ?>
					<div class="published">
						<?php the_date(); ?>
					</div>
				</div>
				<div class="article-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
			</div>

		</div>
	</div>
	<?php
}

function wp_change_search_url() {
    if ( is_search() && ! empty( $_GET['s'] ) ) {
        wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
        exit();
    }  
}
add_action( 'template_redirect', 'wp_change_search_url' );

function search_filter($query) {
	if ( !is_admin() && $query->is_main_query() ) {
	  if ($query->is_search) {
		$query->set('paged', ( get_query_var('paged') ) ? get_query_var('paged') : 1 );
		$query->set('posts_per_page',6);
	  }
	}
}

function get_user_role($user_id) {
	global $wp_roles;

	$roles = array();
	$user = new WP_User( $user_id );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
	foreach ( $user->roles as $role )
		$roles[] .= translate_user_role( $role );
	}
	return implode(', ',$roles);
} 

function wpb_post_breadcrumbs(){
	ob_start();

	global $post;
	$category = get_the_category();
	?>
	<div class="post-breadcrumb">
		<a href="/" style="color: #000;">Home</a>
		<h2 style="line-height:0.7em; padding-left:10px; padding-right:10px;"> &middot; </h2>
		<a href="<?php echo get_category_link($category[0]->term_id); ?>"
			style="color: #000;"><?php echo $post->post_title; ?></a>
	</div>
	<?php
	// Turn off output buffering
	$output = ob_get_clean(); 
	
	//Return output 
	return $output; 
}
add_shortcode('wpb_post_breadcrumbs','wpb_post_breadcrumbs');

function custom_search_from() {
	?>
	<div class="section search-section">
		<form id="searchform" method="get" action="<?php echo home_url('/'); ?>">
			<div class="input-wrapper">
				<label class="screen-reader-text" for="s"></label>
				<input type="text" class="search-field" name="s" placeholder="Search">
			</div>
			<div class="search-input">
				<i class="fa fa-search"></i>
				<input type="submit" value="">
			</div>
		</form>
		<div class="recommend-category">
			<?php get_custom_catelist(12) ?>
		</div>
	</div>
	<?php
}


function limit_image_size( $file ) {
	//Get image size
	$img = getimagesize($file['tmp_name']);
    $width = $img[0];
	$height = $img[1];

	//Check file type
	$type = $file['type'];
	$is_image = strpos( $type, 'image' ) !== false;

	//Default limit minimum size
	$minimum = array('width' => '600', 'height' => '400');
	
	if ( $is_image && $width < $minimum['width'] )
		return array("error"=>"Image dimensions are too small. Minimum width is {$minimum['width']}px. Uploaded image width is $width px");
	elseif ($is_image &&  $height < $minimum['height'])
		return array("error"=>"Image dimensions are too small. Minimum height is {$minimum['height']}px. Uploaded image height is $height px");
	else
		return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'limit_image_size' );


function ampify($html='') {
    # Replace img, audio, and video elements with amp custom elements
    $html = str_ireplace(
        ['<img','<video','/video>','<audio','/audio>'],
        ['<amp-img','<amp-video','/amp-video>','<amp-audio','/amp-audio>'],
        $html
    );
    # Add closing tags to amp-img custom element
    $html = preg_replace('/<amp-img(.*?)>/', '<amp-img$1></amp-img>',$html);
    # Whitelist of HTML tags allowed by AMP
    $html = strip_tags($html,'<h1><h2><h3><h4><h5><h6><a><p><ul><ol><li><blockquote><q><cite><ins><del><strong><em><code><pre><svg><table><thead><tbody><tfoot><th><tr><td><dl><dt><dd><article><section><header><footer><aside><figure><time><abbr><div><span><hr><small><br><amp-img><amp-audio><amp-video><amp-ad><amp-anim><amp-carousel><amp-fit-rext><amp-image-lightbox><amp-instagram><amp-lightbox><amp-twitter><amp-youtube>');
    return $html;
}

/* 
* Get the long title teaser first otherwise return the default title
* return string
*/
function post_title_teaser() {
	$seoFieldTitle = getSeoFieldTitleById(get_the_ID());
	$title = ( $seoFieldTitle ) ? removeSnippetVariableOf($seoFieldTitle) : get_the_title();
	return filterFieldDislay($title);
}

/**
 * Custom Callback
 * @param string $field 
 * $field = "Wel%come *to( codex<world, the |world o^f pro?gramm&ing."
 * @return string $field
 * returns Welcome to codexworld the world of programming
 */
function filterFieldDislay (string $field) {
	return preg_replace('/[^A-Za-z0-9 ]/', '', $field);
}


/**
 * Custom Callback
 * @param string $field 
 * $field = "Wel%come *to( codex<world, the |world o^f pro?gramm&ing."
 * @return string $field
 * returns "FN-50 40 Fascinating Eclipse Facts You Never Knew - long"
 */
function removeSnippetVariableOf(String $field) {
	return preg_replace('/%%(.*)%%/',"" , $field);
}

/**
 * Custom Callback
 * @return string
 */
function getSeoFieldTitleById(int $postId) {
	return get_post_meta($postId, SEO_FIELD_TITLE, true);
}