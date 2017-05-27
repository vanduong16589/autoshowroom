<?php
/*------------------------------------------------------------------------

# Pricing Add-on

# ------------------------------------------------------------------------

# author    TuanNATemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

$addon_params = $this->params;
$thousands_separator = '';
if ($addon_params->get('thousands_separator', '0') == '0') {
    $thousands_separator = '';
} elseif ($addon_params->get('thousands_separator', '0') == 'space') {
    $thousands_separator = ' ';
} elseif ($addon_params->get('thousands_separator', '0') == 'dot') {
    $thousands_separator = '.';
} elseif ($addon_params->get('thousands_separator', '0') == 'comma') {
    $thousands_separator = ',';
}
$decimal_point = '';
if ($addon_params->get('decimal_point', '0') == 'dot') {
    $decimal_point = '.';
} elseif ($addon_params->get('decimal_point', '0') == 'comma') {
    $decimal_point = ',';
}


?>
<div <?php echo $this->getAttribute(null, null, "listing") ?>>
    <?php
    $tzvalue = number_format($value, $addon_params -> get('decimal_digit', 2), $decimal_point, $thousands_separator);
    if ($addon_params->get('symbol_placement', 'before') == 'before') {
        echo $addon_params->get('symbol_text') . $tzvalue;
    } else {
        echo $tzvalue . $addon_params->get('symbol_text');
    } ?>
</div>