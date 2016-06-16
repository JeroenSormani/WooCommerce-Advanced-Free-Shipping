=== WooCommerce Advanced Free Shipping ===
Contributors: sormano
Tags: woocommerce, shipping, woocommerce shipping, woocommerce free shipping, woocommerce free, woocommerce advanced free shipping, wc free shipping, wc shipping, advanced shipping, pro shipping, table rate shipping, country shipping, free shipping
Requires at least: 4.0
Tested up to: 4.5.2
Stable tag: 1.0.9
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WooCommerce Advanced Free Shipping is an plugin which allows you to set up advanced free shipping conditions.

== Description ==
WooCommerce Advanced Free Shipping is an plugin which allows you to set up advanced free shipping conditions.

*Conditions like:*

- Cart total
- Country
- Zip code
- Stock / stock status
- Weight
- Quantity
- Coupon
- many, many more...

**Look at the screenshots!**

> **Applying shipping cost**<br /><br />
> Have you given this plugin a shot and like how you can set things up?<br />
> Another plugin is available that allows you to setup shipping cost with the same conditional logic options as this plugin!<br /><br />
> **Features:**<br />
> - Add shipping cost to the shipping rates<br />
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- *Per weight*<br />
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- *Per item*<br />
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- *Extra handling fee*<br />
> - Setup a percentage based fee<br />
> - Add Advanced shipping cost via the WAS Advanced Pricing extension<br />
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- *Cost per shipping class*<br />
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- *Cost per category*<br />
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- *Cost per product*<br />
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- *Cost per weight (table rate)*<br />
> - Create shipping zones<br />
> - Set tax status<br />
> <br />
> View [WooCommerce Advanced Shipping](http://codecanyon.net/item/woocommerce-advanced-shipping/8634573)

**Translations, feature requests, ratings and donations are welcome and appreciated!**

**Translations**

- Spanish [(Andres Felipe)](https://wordpress.org/support/profile/naturalworldstm)
- Italian (Stefano Callisto)

== Installation ==

1. Upload the folder `woocommerce-advanced-free-shipping` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the settings page to fine-tune the settings if desired

== Screenshots ==

1. WooCommerce Shipping options
2. WAFS shipping conditions
3. WAFS shipping conditions possibilities

== Changelog ==

= 1.0.9 - 16-06-2016 =

* [Fix] - Fix a notice that was introduced with a change in WooCommerce 2.6

= 1.0.8 - 22-12-2015 =

* [i18n] - Portuguese (pt_PT) translation
* [i18n] - Greek (el) translation
* [Improvement] - Keep the WooCommerce -> Settings menu open while in Shipping rate options
* [Tweak] - [Dev] - Remove method prefixes on many places where possible (not all)

= 1.0.7 - 02-11-2015 =

* [Improvement] - Conditional load resources in admin
* [Improvement] - Add AJAX nonce verification
* [Remove] - WooCommerce 2.1 is no longer supported. Please update WC if you're still on a older version.

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
* Added - Added languages files for Portuguese - Brazil pt_BR

= 1.0.3 =
* Improvement - Customized user messages when saving shipping method
* Improvement - Updated some comments to comment standards
* Improvement - Overview not showing all actions when hovering only one
* Improvement - Added ABSPATH check to each file
* Improvement - Improved code comments
* Improvement - Remove globals, use WAFS() function now
* Improvement - Zip codes are now better detected (only integer values)
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
* Added - support for comma separated zip codes
* Added - filter for condition values
* Added - filter for condition descriptions


= 1.0.1 =
* Fix - Wrongful url for sub-domain websites
* Add - Added states as condition

= 1.0.0 =
* Initial release