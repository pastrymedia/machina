# Machina Header Nav

WordPress plugin that registers a menu location and displays it inside the header for a Machina Framework child theme.

## Description

The default method of getting a menu to appear in the top right of a site using a child theme of the Machina Framework, is to add a create a menu in Appearance -> Menus, and then place a Custom Menu widget in the Header Right widget area. While this works, it produces markup as seen in screenshot 1, and which has the following problems:

 * Since the menu is output from a widget, you end up with all of the extraneous widget and widget area markup - in a child theme with HTML5 support, that's the widget area `aside`, the widget `section`, and the widget wrap `div`. In themes without HTML5 support, it's three levels of `div` elements instead. Not only is this more DOM elements to render (performance), but all markup in the site header is pushing the real page content further down the source; search engines apparently put higher value on content at the top of the source (which is why Machina ensures primary and secondary sidebars come lower in the source than the main content, irrespective of where they are displayed on screen).
 * In HTML5 themes, what could be a site's main navigation is wrapped in an `aside` element. It's not known whether this has any impact on SEO. Theoretically at least, search engines may put less value on navigation found in an `aside` or otherwise treat it differently.

This plugin registers a new menu location called Header and, if a menu is assigned to it, displays it before the Header Right area. If you don't have any widgets in the Header Right area, then Machina ensures that none of that widget area markup is output, so you end up with code like screenshot 2. If you do want a widget in the Header Right area, that's fine - it can be positioned and styled as you want, without negatively affecting the navigation menu as well.

## Screenshots

![Screenshot of markup using Custom Menu widget](assets/screenshot-1.png)
_Screenshot 1: Markup using Custom Menu widget._

---

![Screenshot of markup using this plugin](assets/screenshot-2.png)
_Screenshot 2: Markup using this plugin._

## Requirements
 * WordPress 3.0+
 * Machina 2.0+

## Installation

### Upload

1. Download the latest tagged archive (choose the "zip" option).
2. Go to the __Plugins -> Add New__ screen and click the __Upload__ tab.
3. Upload the zipped archive directly.
4. Go to the Plugins screen and click __Activate__.

### Manual

1. Download the latest tagged archive (choose the "zip" option).
2. Unzip the archive.
3. Copy the folder to your `/wp-content/plugins/` directory.
4. Go to the Plugins screen and click __Activate__.

Check out the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Git

Using git, browse to your `/wp-content/plugins/` directory and clone this repository:

`git clone git@github.com:machina-header-nav.git`

Then go to your Plugins screen and click __Activate__.

## Updates

This plugin supports the [GitHub Updater](https://github.com/afragen/github-updater) plugin, so if you install that, this plugin becomes automatically updateable direct from GitHub.

## Usage

Once activated, head to Appearance -> Menus. Create a menu as usual, and assign it to the Header menu location.

## Customising

### CSS

The plugin should work with all Machina child themes, though you may need to add styles to position the output in the traditional place of top right, e.g.:

~~~css
.nav-header {
	float: right;
	text-align: right;
	width: 50%;
}
~~~

Adjust the width as needed to allow enough space for your title area and menu items.

### Priority

The plugin includes a `machina_header_nav_priority` filter, with a default value of 12. Use a value of 6-9 to add the nav before the title + widget area, or 11-14 to add it after. If you want to add it in between, you'll need to remove and re-build `machina_do_header()` function so that the output of the widget area is in a different function that can be hooked to a later priority.

To add the nav before the title + widget area markup in the source, you can use the following:

~~~php
add_filter( 'machina_header_nav_priority', 'prefix_machina_header_nav_priority' );
/**
 * Change the order of the nav within the header (Machina Header Nav plugin)
 *
 * @param  int $priority Existing priority. Default is 12.
 *
 * @return int           New priority.
 */
function prefix_machina_header_nav_priority( $priority ) {
	return 8;
}
~~~

### Top Menu (above `<header>`)

If you give the above priority filter a value of less than 5, then the output will be before the `<header>`, so that you can display what might be considered a Top menu. Of course, this might mean that the "Header" menu location label is confusing, but since that string is internationalised, it's possible to filter that and change it to make it easier for users to understand:

~~~php
add_filter( 'gettext', 'prefix_machina_header_nav_name', 10, 3 );
/**
 * Change the name of the Header menu location added by Machina Header Nav plugin.
 */
function prefix_machina_header_nav_name( $translated_text, $original_text, $domain ) {
	if ( 'machina-header-nav' === $domain && 'Header' === $original_text )
		return 'Top';
}
~~~

### Removing the Menu

If you want the menu to not display, perhaps on a landing page, then you can do the following:

~~~php
if ( class_exists( 'Machina_Header_Nav' ) )
	remove_action( 'machina_header', array( Machina_Header_Nav::get_instance(), 'show_menu' ), apply_filters( 'machina_header_nav_priority', 12 ) );
~~~

## Credits

Built by [Machina Themes](https://twitter.com/)
Copyright 2013 [Machina Themes](http://machinathemes.com/)
