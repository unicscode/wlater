<?php
/**
 * Functions and template tags used in theme header
 */

if ( ! function_exists( 'electro_enqueue_styles' ) ) {
	/**
	 * Enqueues all styles used by the theme
	 */
	function electro_enequeue_styles() {

		global $electro_version;

		if ( apply_filters( 'electro_load_default_fonts', true ) ) {
			wp_enqueue_style( 'electro-fonts', electro_fonts_url(), array(), null );
		}

		$css_vendors = apply_filters( 'electro_css_vendors', array(
			'bootstrap'		=> 'bootstrap.min.css',
			'fontawesome'	=> 'font-awesome.min.css',
			'animate'		=> 'animate.min.css',
			'font-electro'	=> 'font-electro.css'
		) );

		foreach( $css_vendors as $handle => $css_file ) {
			wp_enqueue_style( $handle, get_template_directory_uri() . '/assets/css/' . $css_file, '', $electro_version );
		}

		if ( is_rtl() ) {
			wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/assets/css/bootstrap-rtl.min.css', '', $electro_version  );
			wp_enqueue_style( 'electro-rtl-style', get_template_directory_uri() . '/rtl.min.css', '', $electro_version );
		} else {
			wp_enqueue_style( 'electro-style', get_template_directory_uri() . '/style.min.css', '', $electro_version );
		}

		if ( is_child_theme() && apply_filters( 'electro_load_child_theme', false ) ) {
			wp_enqueue_style( 'electro-child-style', get_stylesheet_uri(), '', $electro_version );
		}

		if ( apply_filters( 'electro_use_predefined_colors', true ) ) {
			$color_css_file = apply_filters( 'electro_primary_color', 'yellow' );
			wp_enqueue_style( 'electro-color', get_template_directory_uri() . '/assets/css/colors/' . $color_css_file . '.min.css', '', $electro_version );
		}

		wp_dequeue_style( 'wcqi-css' );
	}
}

if ( ! function_exists( 'electro_enqueue_scripts' ) ) {
	/**
	 * Enqueues all scripts used by the theme
	 */
	function electro_enqueue_scripts() {

		global $electro_version;

		wp_enqueue_script( 'tether-js',		get_template_directory_uri() . '/assets/js/tether.min.js', array( 'jquery' ), $electro_version, true );
		wp_enqueue_script( 'bootstrap-js', 	get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery', 'tether-js' ), $electro_version, true );
		wp_enqueue_script( 'waypoints-js', 	get_template_directory_uri() . '/assets/js/jquery.waypoints.min.js', array( 'jquery' ), $electro_version, true );

		if( apply_filters( 'electro_enable_sticky_header', true ) ) {
			wp_enqueue_script( 'waypoints-sticky-js',	get_template_directory_uri() . '/assets/js/waypoints-sticky.min.js', array( 'jquery' ), $electro_version, true );
		}

		if( apply_filters( 'electro_enable_live_search', false ) ) {
			wp_enqueue_script( 'typeahead', get_template_directory_uri() . '/assets/js/typeahead.bundle.min.js', array( 'jquery' ), $electro_version, true );
			wp_enqueue_script( 'handlebars', get_template_directory_uri() . '/assets/js/handlebars.min.js', array( 'typeahead' ), $electro_version, true );
		}

		if( apply_filters( 'electro_enable_scrollup', true ) ) {
			wp_enqueue_script( 'easing-js',		get_template_directory_uri() . '/assets/js/jquery.easing.min.js', array( 'jquery' ), $electro_version, true );
			wp_enqueue_script( 'scrollup-js',	get_template_directory_uri() . '/assets/js/scrollup.min.js', array( 'jquery' ), $electro_version, true );
		}

		if( apply_filters( 'electro_enable_bootstrap_hover', true ) ) {
			wp_enqueue_script( 'bootstrap-hover-dropdown-js', get_template_directory_uri() . '/assets/js/bootstrap-hover-dropdown.min.js', array( 'bootstrap-js' ), $electro_version, true );
		}

		wp_enqueue_script( 'electro-js', 	get_template_directory_uri() . '/assets/js/electro.min.js', array( 'jquery', 'bootstrap-js' ), $electro_version, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );

		wp_enqueue_script( 'pace', get_template_directory_uri() . '/assets/js/pace.min.js', array( 'jquery' ), $electro_version, true );

		$admin_ajax_url = admin_url( 'admin-ajax.php' );
		$current_lang   = apply_filters( 'wpml_current_language', NULL ); 
		
		if ( $current_lang ) {
			$admin_ajax_url = add_query_arg( 'lang', $current_lang, $admin_ajax_url );
		}

		$electro_options = apply_filters( 'electro_localize_script_data', array(
			'rtl'					=> is_rtl() ? '1' : '0',
			'ajax_url'				=> $admin_ajax_url,
			'ajax_loader_url'		=> get_template_directory_uri() . '/assets/images/ajax-loader.gif',
			'enable_sticky_header'	=> apply_filters( 'electro_enable_sticky_header', true ),
			'enable_live_search'	=> apply_filters( 'electro_enable_live_search', false ),
			'live_search_limit'		=> apply_filters( 'electro_live_search_limit', 10 ),
			'live_search_template'	=> apply_filters( 'electro_live_search_template', '<a href="{{url}}" class="media live-search-media"><img src="{{image}}" class="media-left media-object flip pull-left" height="60" width="60"><div class="media-body"><p>{{{value}}}</p></div></a>' ),
			'live_search_empty_msg'	=> apply_filters( 'electro_live_search_empty_msg', esc_html__( 'Unable to find any products that match the currenty query', 'electro' ) ),
			'deal_countdown_text'	=> apply_filters( 'electro_deal_countdown_timer_clock_text', array(
				'days_text'		=> esc_html__( 'Days', 'electro' ),
				'hours_text'	=> esc_html__( 'Hours', 'electro' ),
				'mins_text'		=> esc_html__( 'Mins', 'electro' ),
				'secs_text'		=> esc_html__( 'Secs', 'electro' ),
			) ),
			'typeahead_options'     => array( 'hint' => false, 'highlight' => true ),
		) );

		wp_localize_script( 'electro-js', 'electro_options', $electro_options );
	}
}

if ( ! function_exists( 'electro_fonts_url' ) ) {
	/**
	 * Register Google Fonts for Electro
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function electro_fonts_url() {

		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== esc_html_x( 'on', 'Open Sans font: on or off', 'electro' ) ) {
			$fonts[] =  'Open Sans:400,300,600,700,800,800italic,700italic,600italic,400italic,300italic';
		}

		$fonts = apply_filters( 'electro_google_fonts', $fonts );

		/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
		$subset = esc_html_x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'electro' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
}

if ( ! function_exists( 'electro_scripts' ) ) {
	/**
	 * Enqueues styles and scripts used by the theme
	 */
	function electro_scripts() {

		// Enqueue styles
		electro_enequeue_styles();

		// Enqueue scripts
		electro_enqueue_scripts();
	}
}

if ( ! function_exists( 'electro_remove_locale_stylesheet' ) ) {
	/**
	 * Dequeue locale styles
	 */
	function electro_remove_locale_stylesheet() {
		remove_action( 'wp_head', 'locale_stylesheet' );
	}
}

if ( ! function_exists( 'electro_get_header' ) ) {
	function electro_get_header( $header = '' ) {
		$header_style = apply_filters( 'electro_header_style', 'v1' );

		if( ! empty( $header ) ) {
			$header_style = $header;
		}

		get_header( $header_style );
	}
}

if ( ! function_exists( 'electro_skip_links' ) ) {
	/**
	 * Skip Links
	 */
	function electro_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php _e( 'Skip to navigation', 'electro' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'electro' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'has_electro_mobile_header' ) ) {
	/**
	 * Load Different Header for Mobile
	 */
	function has_electro_mobile_header() {
		return apply_filters( 'has_electro_mobile_header', true );
	}
}

if ( ! function_exists( 'electro_top_bar' ) ) {
	/**
	 * Displays Top Bar
	 */
	function electro_top_bar() {

		if ( apply_filters( 'electro_enable_top_bar', true ) ) : ?>

		<?php 

		$top_bar_classes = 'top-bar';

		if ( has_electro_mobile_header() ) {
			if ( apply_filters( 'electro_hide_top_bar_in_mobile', true ) ) {
				$top_bar_classes .= ' hidden-md-down';
			}
		}

		?>

		<div class="<?php echo esc_attr( $top_bar_classes ); ?>">
			<div class="container">
			<?php
				wp_nav_menu( array(
					'theme_location'	=> 'topbar-left',
					'container'			=> false,
					'depth'				=> 2,
					'menu_class'		=> 'nav nav-inline pull-left animate-dropdown flip',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker()
				) );

				wp_nav_menu( array(
					'theme_location'	=> 'topbar-right',
					'container'			=> false,
					'depth'				=> 2,
					'menu_class'		=> 'nav nav-inline pull-right animate-dropdown flip',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker()
				) );
			?>
			</div>
		</div><!-- /.top-bar -->

		<?php endif;
	}
}

if ( ! function_exists( 'electro_row_wrap_start' ) ) {
	/**
	 * Prints Electro row wrapper
	 */
	function electro_row_wrap_start() {
		?>
		<div class="row">
		<?php
	}
}

if ( ! function_exists( 'electro_row_wrap_end' ) ) {
	/**
	 * Closes row wrapper
	 */
	function electro_row_wrap_end() {
		?>
		</div><!-- /.row -->
		<?php
	}
}

if ( ! function_exists ( 'electro_header_logo' ) ) {
	/**
	 * Displays theme logo
	 *
	 */
	function electro_header_logo() {

		return false;
	}
}

if ( ! function_exists( 'electro_primary_nav' ) ) {
	/**
	 * Displays Primary Navigation
	 */
	function electro_primary_nav() {
		?>
		<div class="container">
			<div class="primary-nav animate-dropdown">
			<div class="clearfix">
				 <button class="navbar-toggler hidden-sm-up pull-right flip" type="button" data-toggle="collapse" data-target="#default-header">
				    	&#9776;
				 </button>
			 </div>

			<div class="collapse navbar-toggleable-xs" id="default-header">
				<?php
					wp_nav_menu( array(
						'theme_location'	=> 'primary-nav',
						'container'			=> false,
						'menu_class'		=> 'nav nav-inline yamm',
						'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						'walker'            => new wp_bootstrap_navwalker()
					) );
				?>
			</div>
		</div>
		</div>
		
		<?php
	}
}

if ( ! function_exists( 'electro_handheld_header' ) ) {
	/**
	 * Displays HandHeld Header
	 */
	function electro_handheld_header() {
		if( has_electro_mobile_header() ) : ?>
			<div class="container hidden-lg-up">
				<div class="handheld-header">
					<?php
					/**
					 * @hooked electro_header_logo - 10
					 * @hooked electro_handheld_nav - 20
					 */
					do_action( 'electro_header_handheld' ); ?>
				</div>
			</div>
		<?php endif;
	}
}

if ( ! function_exists( 'electro_handheld_nav' ) ) {
	/**
	 * Displays HandHeld Navigation
	 */
	function electro_handheld_nav() {
		?>
		<div class="handheld-navigation-wrapper">
			<div class="handheld-navbar-toggle-buttons clearfix">
				<button class="navbar-toggler navbar-toggle-hamburger hidden-lg-up pull-right flip" type="button">
					<i class="fa fa-bars" aria-hidden="true"></i>
				</button>
				<button class="navbar-toggler navbar-toggle-close hidden-lg-up pull-right flip" type="button">
					<i class="ec ec-close-remove"></i>
				</button>
			</div>

			<div class="handheld-navigation hidden-lg-up" id="default-hh-header">
				<span class="ehm-close"><?php _e( 'Close', 'electro' ); ?></span>
				<?php
					wp_nav_menu( array(
						'theme_location'	=> 'hand-held-nav',
						'container'			=> false,
						'menu_class'		=> 'nav nav-inline yamm',
						'fallback_cb'       => 'electro_handheld_nav_fallback',
						'walker'            => new wp_bootstrap_navwalker()
					) );
				?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_handheld_nav_fallback' ) ) {
	/**
	 * Displays HandHeld Navigation Fallback
	 */
	function electro_handheld_nav_fallback() {
		wp_nav_menu( array(
			'theme_location'	=> 'all-departments-menu',
			'container'			=> false,
			'menu_class'		=> 'nav nav-inline yamm',
			'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
			'walker'            => new wp_bootstrap_navwalker(),
		) );
	}
}

if ( ! function_exists( 'electro_header_support_info' ) ) {
	/**
	 * Displays header support info
	 */
	function electro_header_support_info() {

		$support_number = apply_filters( 'electro_header_support_number', '<strong>Support</strong> (+800) 856 800 604' );
		$support_email 	= apply_filters( 'electro_header_support_email', 'Email: info@electro.com' );
		$support_icon   = apply_filters( 'electro_header_support_icon', 'ec ec-support' );

		if ( apply_filters( 'electro_show_header_support_info', true ) ) : ?>
		<div class="header-support-info">
			<div class="media">
				<span class="media-left support-icon media-middle"><i class="<?php echo esc_attr( $support_icon ); ?>"></i></span>
				<div class="media-body">
					<span class="support-number"><?php echo wp_kses_post( $support_number ); ?></span><br/>
					<span class="support-email"><?php echo wp_kses_post( $support_email ); ?></span>
				</div>
			</div>
		</div><?php
		endif;
	}
}

if ( ! function_exists( 'electro_header_search_box' ) ) {
	/**
	 * Displays search box at the header
	 */
	function electro_header_search_box() {

	}
}

if ( ! function_exists( 'electro_breadcrumb' ) ) {
	function electro_breadcrumb( $args = array() ) {

		if ( apply_filters( 'electro_show_breadcrumb' , true ) ){

			if ( is_woocommerce_activated() ) {
				woocommerce_breadcrumb();
			} else {

				require get_template_directory() . '/inc/classes/class-electro-breadcrumb.php';

				$args = wp_parse_args( $args, apply_filters( 'woocommerce_breadcrumb_defaults', array(
					'delimiter'   => '<span class="delimiter"><i class="fa fa-angle-right"></i></span>',
					'wrap_before' => '<nav class="woocommerce-breadcrumb">',
					'wrap_after'  => '</nav>',
					'before'      => '',
					'after'       => '',
					'home'        => _x( 'Home', 'breadcrumb', 'electro' )
				) ) );

				$breadcrumbs = new Electro_Breadcrumb();

				if ( $args['home'] ) {
					$breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
				}

				$args['breadcrumb'] = $breadcrumbs->generate();

				electro_get_template( 'global/breadcrumb.php', $args );
			}
		}
	}
}

if ( ! function_exists( 'electro_jumbotron' ) ) {
	function electro_jumbotron( $args = array() ) {
		electro_get_template( 'sections/jumbotron.php', $args );
	}
}

if ( ! function_exists( 'electro_add_data_hover_attribute' ) ) {
	function electro_add_data_hover_attribute( $atts, $item, $args, $depth ) {
		if( $args->has_children && $depth === 0 ) {

			$dropdown_trigger = apply_filters( 'electro_' . $args->theme_location . '_dropdown_trigger', 'click', $args->theme_location );
			if( $dropdown_trigger == 'hover' ) {
				$atts['data-hover'] = 'dropdown';

				if( isset( $atts['data-toggle'] ) ) {
					unset( $atts['data-toggle'] );
				}
			}
		}

		return $atts;
	}
}
