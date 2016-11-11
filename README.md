# expiredproducts

Expired Products for OS Commerce: This was created for a 2010 version and may no longer work.

This project has moved to : https://bitbucket.org/matthewlinton/osc_expiredproducts/

## About

Expired Products adds the ability to flag products with an expiration flag and date. This is very useful when selling things like tickets to events.

This contribution is loosely based on "Products Date Expiry" created by Axel Erpenbach (http://www.oscommerce.com/community/contributions,2064/category,all/search,events). Axel's contribution uses sql queries to filter out expired products. This is a fine method of handling product expiry, but has the downside of requiring that all products be marked with an expiration date.

Rather than filtering out expired products using an expiration date when fetching the data, Expired Products sets a field (products_does_expire) to indicate that the product does or does not expire.  This allows you to pull all the products and then filter the results within the code, or filter out expired products when fetching them from the database.

## Install

* Checkout: git clone https://github.com/matthewlinton/expiredproducts
* Change directories into the expiredproducts directory 'cd expiredproducts'
* Follow the instructions in 'expired_products.txt'

## OS Commerce

http://www.oscommerce.com/

OS Commerce is a complete framework for creating your very own online store.

## PHP Calendar

PHP Calendar (version 2.3), written by Keith Devens

http://keithdevens.com/software/php_calendar

Original source can be found in "PHP_Calendar_2.3_Keith_Devens.txt" or the url above.
"PHP_Calendar.diff" contains the changes made between his version and mine.
