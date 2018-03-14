=== FV Code Highlighter ===

Contributors:       frankverhoeven
Tags:               Formatting, Code, Highlight, Code Highlighting
Donate link:        https://www.paypal.me/FrankVerhoeven
Requires at least:  3.2
Tested up to:       4.9
Stable tag:         2.1.2

Highlight your code with beautiful highlighters.



== Description ==

Do you have a lot of code on your blog, and want to make it more readable? Then this is the plugin for you!
This plugin supports the highlighting of PHP, (x)HTML, JavaScript, CSS and XML. The default highlighter
color scheme uses the same colors Adobe's Dreamweaver is using. This makes it easy for your visitors to
recognize what type of codes you wrote and quickly read through them.
Want to modify the default color scheme? No problem! With a little bit of knowledge about CSS, you can
completely customize the output of the plugin.



== Screenshots ==

1. PHP Code with dark mode enabled
2. The configuration page.
3. PHP Code with notepaper background and toolbox
4. General Code
5. CSS Code
6. HTML Code with embedded CSS and Javascript
7. JavaScript Code
8. PHP Code



== Installation ==

This section describes how to install the plugin and get it up & running.

= Requirements =

In order to successfully use this plugin, you will need the following:

* PHP 7.0 or higher
* WordPress 3.2 or higher


= Installation Steps =

1. Upload the folder `fv-code-highlighter` to the `/wp-content/plugins/` directory.
1. Make sure the cache dir `/wp-content/plugins/fv-code-highlighter/cache` is writable by your webserver.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Choose your preferred settings on the options page: WP Admin > Appearance > Code Highlighter.
1. Place your code between <pre lang=codetype> .. code .. </pre> tags to use the highlighter. Replace `codetype` with the type of code you like to highlight (e.g. php).


= Custom Color Scheme =

If you like to make some modifications to the default color scheme, all you need is a little
bit of knowledge about CSS. Simply copy the file `fv-community-news/public/css/fvch-styles.css`
to the root of your current theme directory and start editing.



== Frequently Asked Questions ==

Q: Can this plugin be used to highlight code in comments?
A: Yes! Using the [code][/code] tags in comments will work. Even bbPress topics/replies are supported.

Q: My PHP code is not highlighted correctly?
A: With version 2.0 and up, it is required to start PHP code with PHP tags (<?php, <?=)

Q: I have a great idea for this plugin, could I make a suggestion?
A: Sure you can! [Let me know about it](https://frankverhoeven.me/wordpress-plugin-fv-code-highlighter/).

Q: What to do if I found a bug?
A: Please report the bug to me as soon as possible. This way I can solve the problem and make the plugin better for everyone.
Visit the post at [https://frankverhoeven.me/wordpress-plugin-fv-code-highlighter/](https://frankverhoeven.me/wordpress-plugin-fv-code-highlighter/).



== Changelog ==

For more details on changes, please visit the [WordPress Trac](http://plugins.trac.wordpress.org/log/fv-code-highlighter/ "FV Code Highlighter on WordPress Trac").


= 2.1.2 =

* Improvement: PHP Code is no longer required to start with PHP tags to be highlighted.


= 2.1.1 =

* Fix: PHP 7.0 Compatibility


= 2.1 =

* New: All new Dark Mode that displays code with a dark background.
* Improvement: New text select icon.
* Improvement: Use the settings API for the admin page.
* Improvement: Prepend global scope with '\' to improve performance.
* Fix: Installer fixes.


= 2.0.5 =

* Change: Require PHP >= 7.
* Improvement: General code improvements.


= 2.0.4 =

* Fix: The copy-icon is now loaded correct.


= 2.0.3 =

* Change: Code should now be placed between <pre lang=...> </pre> (old tags still work for now)
* Impovement: General code improvements


= 2.0.2 =

* New: New Xcode inspired color scheme for PHP.
* New: PHP highlighter now also highlights classes, methods and phpdoc.
* Improvement: Stylesheet is minified.
* Improvement: Colorscheme stylesheet is dynamically loaded.
* Change: Font-size unit is changed from px to em.


= 2.0 =

* New: Entirely rewritten parsing engine
* New: Bash code highlighter
* New: General highlighter that is used when a code type is not explicitly supported
* Improvement: Performance enhancements
* Improvement: Updated CSS keywords
* Change: PHP code must start with a PHP tag (<?php, <?=) for the highlighter to work correctly
* Fix: Various highlighter fixes


= 1.9.1 =

* New: A general highlighter for unsupported code types
* Improvement: Changed the html that displays code
* Improvement: Performance improvements
* Improvement: Updated PHP keywords & functions
* Change: Cache is now disabled if WP_DEBUG = true, make sure it is set to false on production!
* Fix: Fixed various styling issues


= 1.9 =

* Improvement: Code cleanup
* Fix: Switch to new author domain
* Fix: Cacher tried to delete the entire hdd in certain circumstances
* Fix: Updater check
* Fix: Code toolbox selection
