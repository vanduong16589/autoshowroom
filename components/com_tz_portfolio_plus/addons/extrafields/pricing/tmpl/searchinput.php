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

//no direct access
defined('_JEXEC') or die('Restricted access');

$params = $this->params;

$thousands_separator = '';
if ($params->get('thousands_separator', '0') == '0') {
    $thousands_separator = '';
} elseif ($params->get('thousands_separator', '0') == 'space') {
    $thousands_separator = ' ';
} elseif ($params->get('thousands_separator', '0') == 'dot') {
    $thousands_separator = '.';
} elseif ($params->get('thousands_separator', '0') == 'comma') {
    $thousands_separator = ',';
}
$decimal_point = '';
if ($params->get('decimal_point', '0') == 'dot') {
    $decimal_point = '.';
} elseif ($params->get('decimal_point', '0') == 'comma') {
    $decimal_point = ',';
}
?>
<?php if ($params->get('tztype', 1) == 1) {
    if ($params->get('show_label', 1)) { ?>
    <label class="group-label"><?php echo $this->getTitle(); ?></label>
    <?php }
    echo JHtml::_('select.genericlist', $options_min, $this->getSearchName(), $this->getAttribute(null, null, "search"), 'value', 'text', $value_min, $this->getSearchId());
    echo JHtml::_('select.genericlist', $options_max, $this->getSearchName(), $this->getAttribute(null, null, "search"), 'value', 'text', $value_max, $this->getSearchId());
} else{
    $doc = JFactory::getDocument();
    $doc->addScript(TZ_Portfolio_PlusUri::base(true).'/addons/extrafields/pricing/libraries/jquery-ui.js');
    $doc->addStyleSheet(TZ_Portfolio_PlusUri::base(true). '/addons/extrafields/pricing/libraries/jquery-ui.css');
    $doc->addStyleSheet(TZ_Portfolio_PlusUri::base(true). '/addons/extrafields/pricing/css/style.css');
    $numberFormat   = ($params -> get('decimal_point', 0) && $params -> get('decimal_digit', 2)) || $params -> get('thousands_separator', 'comma')?true:false;
    if($numberFormat){
        $doc -> addScript(TZ_Portfolio_PlusUri::base(true).'/addons/extrafields/pricing/libraries/jquery.number.min.js');
    }

    $doc -> addScriptDeclaration('
    (function($){
        "use strict";
        $(document).ready(function () {
            var $slider_range = $(".slider-range'.$this->id.'");
            $slider_range.each(function () {
                var $parent = $(this).parent(".pricing-addon");
                $(this).slider({
                    range: true,
                    min: '.((int) $params->get('min_value', 0)).',
                    max: '.((int) $params->get('max_value', 0)).',
                    values: ['.$value_min.', '.$value_max.'],
                    slide: function (event, ui) {
                        '.(($params->get('symbol_placement', 'before') == 'before')?'
                        $parent.find(".pricing_amount").text("'
                        .$params->get('symbol_text').'" + '.($numberFormat?'$.number(ui.values[0],'
                        .$params -> get('decimal_digit', 2).',"'.$decimal_point.'","'.$thousands_separator.'")'
                        :'ui.values[0]').' + " - '
                        .$params->get('symbol_text').'" + '.($numberFormat?'$.number(ui.values[1],'
                        .$params -> get('decimal_digit', 2).',"'.$decimal_point.'","'.$thousands_separator.'")'
                        :'ui.values[1]').');':'
                        $parent.find(".pricing_amount").text('.($numberFormat?'$.number(ui.values[0],'
                        .$params -> get('decimal_digit', 2).',"'.$decimal_point.'","'.$thousands_separator.'")'
                        :'ui.values[0]').' + "'
                        .$params->get('symbol_text').'" + " - " + '.($numberFormat?'$.number(ui.values[1],'
                        .$params -> get('decimal_digit', 2).',"'.$decimal_point.'","'.$thousands_separator.'")'
                        :'ui.values[1]').' + "'.$params->get('symbol_text').'");')
                        .'$parent.find(".min_value").val(ui.values[0]);
                        $parent.find(".max_value").val(ui.values[1]);
                    }
                });
            });
        });
    })(jQuery);', 'text/javascript');
    ?>
    <div class="pricing-addon">
        <?php if ($params->get('show_label', 1)) { ?>
        <label class="group-label btn-block"><?php echo $this->getTitle();
            ?><span class="pull-right pricing_amount"><?php
                if($params->get('symbol_placement', 'before') == 'before') {
                    echo $params->get('symbol_text').number_format($value_min, $params -> get('decimal_digit', 2)
                            , $decimal_point, $thousands_separator) . ' - '.$params->get('symbol_text')
                        .number_format($value_max, $params -> get('decimal_digit', 2)
                            , $decimal_point, $thousands_separator);
                }else{
                    echo number_format($value_min, $params -> get('decimal_digit', 2)
                            , $decimal_point, $thousands_separator) .$params->get('symbol_text'). ' - '
                        .number_format($value_max, $params -> get('decimal_digit', 2)
                            , $decimal_point, $thousands_separator).$params->get('symbol_text');
                }
                ?></span></label>
        <?php } ?>
        <div class="slider-range<?php echo $this->id; ?>"></div>
        <input type="hidden" class="min_value" name="fields[<?php echo $this->id; ?>][0]" value="<?php echo $value_min;?>">
        <input type="hidden" class="max_value" name="fields[<?php echo $this->id; ?>][1]" value="<?php echo $value_max;?>">
    </div>
<?php } ?>
