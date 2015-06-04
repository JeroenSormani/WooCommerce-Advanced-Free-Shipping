=== WooCommerce Advanced Free Shipping ===
Contributors: sormano
Donate link: http://www.jeroensormani.com/donate/
Tags: woocommerce, shipping, woocommerce shipping, woocommerce free shipping, woocommerce free, woocommerce advanced free shipping, wc free shipping, wc shipping, advanced shipping, pro shipping, table rate shipping, country shipping, free shipping
Requires at least: 3.6
Tested up to: 4.2.2
Stable tag: 1.0.6
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WooCommerce Advanced Free Shipping is an plugin which allows you to set up advanced free shipping conditions.

== Description ==
WooCommerce Advanced Free Shipping is an plugin which allows you to set up advanced free shipping conditions.

*Conditions like:*

- Cart total
- Country
- Zipcode
- Stock / stock status
- Weight
- Quantity
- Coupon
- many, many more...

**Look at the screenshots!**

**Translations, feature requests, ratings and donations are welcome and appreciated!**

**Translations**

- Spanish [(Andres Felipe)](https://wordpress.org/support/profile/naturalworldstm)
- Italian [(Stefano Callisto)]

== Installation ==

1. Upload the folder `woocommerce-advanced-free-shipping` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the settings page to fine-tune the settings if desired

== Screenshots ==

1. WooCommerce Shipping options
2. WAFS shipping conditions
3. WAFS shipping conditions possibilities

== Changelog ==

= 1.0.6 - 04-06-2015 =

* [Add] - Escaping/sanitizing to different elements
* Improvement - Shipping class matching function now uses varation shiping class instead of the parents'
* [i18n] - Add Italian translation

= 1.0.5 - 14-12-2014 =

* Fix - Hide other shipping doesn't save in rare cases
* Improvement - Use of WC() singleton instead of $woocommerce global
* Improvement - Add background color to overview table every other row

= 1.0.4 =
* Fix - Weight condition wasn't working
* Fix - Cash On Delivery for WAFS
* Added - Added languages files for Portugese - Brazil pt_BR

= 1.0.3 =
* Improvement - Customized user messages when saving shipping method
* Improvement - Updated some comments to comment standards
* Improvement - Overview not showing all actions when hovering only one
* Improvement - Added ABSPATH check to each file
* Improvement - Improved code comments
* Improvement - Remove globals, use WAFS() function now
* Improvement - Zipcodes are now better detected (only integer values)
* Improvement - Load textdomains
* Improvement - Add compatibility for custom value fields
* Improvement - Add world wide state support
* Fix - No notice on shipping title in DEBUG mode
* Fix - Loading icon on sub directory websites
* Fix - Condition description didn't show sometimes
* Fix - 'Category' - 'Not equal to' error
* Fix - Showing drafts in overview
* Removed - Author from overview, who needs that?


= 1.0.2 = 07/03/2014
* Added - support for comma separated zipcodes
* Added - filter for condition values
* Added - filter for condition descriptions


= 1.0.1 =
* Fix - Wrongful url for sub-domain websites
* Add - Added states as condition

= 1.0.0 =
* Initial release