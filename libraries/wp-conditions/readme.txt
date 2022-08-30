WP Conditions is a framework developed by Jeroen Sormani <info@jeroensormani.com>
It is intended to be used on plugins like build by Jeroen such as Advanced Shipping, Advanced Fees etc.

Copyright © 2017 Jeroen Sormani


# Current version: 1.0.12

# Changelog

= 1.0.12 - 30/12/2021 =

* [Fix] - Adding condition group did not change the template ID(s)

= 1.0.11 - 30/11/2021 =

* [Improvement] - Update repeater.js to have onAddElement() action
* [Improvement] - Improved matching for weight condition (fix float matching issue)
* [Improvement] - Style improvements
* [Fix] - Javascript error undefined variable saving sorting order

= 1.0.10 - 25/11/2019 =

* [Fix] - Coupon condition possibly giving warning when no coupon is applied
* [Improvement] - Allow for 'Coupon' - equal - {empty} - for a 'no coupon applied' condition

= 1.0.9 - 05/07/2019 =

* [Add] - Value field input validation for order amount / weight conditions
* [Fix] - 'No shipping class' in shipping class condition not always working as expected
* [Fix] - Possible notice from 'Page' condition on non-pages
* [Fix] - Duplicating condition groups with conditions using Select2 now continue to work
* [Improvement] - Shipping method condition matches only against chosen methods of available shipping packages

= 1.0.8 - 20/08/2018 =

* [Improvement] - Stock status condition now includes 'On backorder'
* [Improvement] - Remove old WC 2.X backwards compatibility code
* [Improvement] - 'Shipping method' condition matches on rate ID, method ID or instance ID.
* [Improvement] - Clean up the CSS styles.
* [Fix] - 'Country' condition not working with 'not equal to' when using a continent.

= 1.0.7 - 14/06/2018 =

* [Improvement] - Product Category condition now uses enhanced search field
* [Fix] - Prevent notice for stock condition when cart is empty

= 1.0.6 - 29/01/2018 =

* [Fix] -  New condition on new condition group gets the wrong condition ID assigned
* [Improvement] - Accept array in value dropdown with selected() function

= 1.0.5 - 26/09/2017 =

- [Improvement] - WC 3.2 changes to prevent notices

= 1.0.4 - 01/09/2017 =

- [Improvement] - Use WC_Method:get_method_title() instead of get_title() to get method title.

= 1.0.3 - 28/06/2017 =

- [Fix] - 'User role' condition 'Guest' wasn't working
- [Improvement] - Allow conditions outside postbox / multiple times inside. Not limited to .postbox class.
- [Add] - Zipcode range support. E.g. 'Zipcode' = 'equal to' = '10000-20000,30000-40000'

= 1.0.2 - 28/04/2017 =


- [Add] - Volume condition
- [Add] - Support for 'Guest' users in the 'User role' condition
- [Fix] - Use 9 length IDs for new fields - prevents too big numbers for 32-bits systems.


= 1.0.1 =

- [Add] - WC 3.0 compatibility

= 1.0.0 =

First release
