<?php
/*
  $Id: products_expiring.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCTS_EXPIRING_CALENDAR);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRODUCTS_EXPIRING_CALENDAR));

  
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">

<?php

if (isset($HTTP_GET_VARS['date'])) {
	$active_date = $HTTP_GET_VARS['date'];
} else {
        $active_date = time();
}

$month_match = date("Y-m", $active_date) . '-%';
$products_expiring_sql = "select p.products_id, pd.products_name, pd.products_description, p.products_price, p.products_tax_class_id, p.products_date_added, m.manufacturers_name, p.products_date_expire, p.products_does_expire from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_does_expire = '1' and p.products_date_expire like '" . $month_match . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_expire ASC, pd.products_name";

$i = 0;
$event = array();
$calendar_events = array();
(isset($HTTP_GET_VARS['print']) ? $len_name = 50 : $len_name = 10);
$products_expiring_query = tep_db_query($products_expiring_sql);
while ($products_expiring = tep_db_fetch_array($products_expiring_query)) {
	$event_date = split('-', $products_expiring['products_date_expire']);
        $calendar_events[ltrim($event_date[2], '0')][$i] = array( tep_href_link(FILENAME_PRODUCT_INFO) . '?products_id=' .
        $products_expiring['products_id'],
        tep_truncate_string($products_expiring['products_name'], $len_name),
        '<b>' . $products_expiring['products_name'] . '</b><br>' .
        tep_truncate_string(strip_tags($products_expiring['products_description']), 100));
        $i++;
}

if(isset($HTTP_GET_VARS['print'])) {
	echo '<div class="calendar-print"><a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . 
	     tep_image(DIR_WS_IMAGES . 'store_logo.png', STORE_NAME) . '</a>';
	echo '<br>' . tep_draw_separator('pixel_trans.gif', '10', '10') . '<br>' .
	     tep_draw_calendar($active_date, $calendar_events, 3, NULL, 0);
	echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_EXPIRING_CALENDAR) . 
	     '?date=' . $HTTP_GET_VARS['date'] . '">' . CALENDAR_BACK . '</a></div>';
} else {

?>

<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="3">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
	<td>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	  <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '10'); ?></td>
	  <td align="center">
<?php
	   echo tep_draw_calendar($active_date, $calendar_events, 3, NULL, 0);
?>
	  </td>
	  <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '10'); ?></td>
	  <tr>
		<td colspan="3"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
	  </tr>
	  <tr>
	  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
          <td>
	   <table border="0" width="100%" cellspacing="0" cellpadding="2">
	   <tr>
	    <td class="main" align="left">
		<a href="<?php echo tep_href_link(FILENAME_PRODUCTS_EXPIRING_CALENDAR) . '?date=' .
                         mktime(0, 0, 0, date("m", $active_date)-1, date("d", $active_date),
                         date("Y", $active_date)) ?>"><?php echo CALENDAR_PREVIOUS_MONTH ?></a>
	    </td>
	    <td class="main" align="center">
<?php
		if (isset($HTTP_GET_VARS['date'])) {
        	   echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_EXPIRING_CALENDAR) .
			'">' . CALENDAR_CURRENT_MONTH . '</a>';
	        } else {
		   echo CALENDAR_CURRENT_MONTH;
		}
?>
	    </td>
	    <td class="main" align="right">
		<a href="<?php echo tep_href_link(FILENAME_PRODUCTS_EXPIRING_CALENDAR) . '?date=' .
                         mktime(0, 0, 0, date("m", $active_date)+1, date("d", $active_date),
                         date("Y", $active_date)) ?>"><?php echo CALENDAR_NEXT_MONTH ?></a>
	    </td>
	    </tr>
	    <tr>
	    <td class="main">&nbsp;</td>
	    <td class="main" align="center">
		<a href="<?php echo tep_href_link(FILENAME_PRODUCTS_EXPIRING_CALENDAR) . '?print=1&date=' . $active_date; ?>
		"><?php echo CALENDAR_PRINT ?></a>
	    </td>
	    <td class="main">&nbsp;</td>
	    </tr>
	    </table>
	   </td>
	   <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
	  </tr>
	</table>
	</td>
      </tr>

    </table></td>
<!-- body_text_eof //-->
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>

<?php
}
?>
</body>

</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
