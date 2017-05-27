<?php
/**
 * Plazart Framework
 * Author: Sonle
 * Version: 1.1
 * @copyright   Copyright (C) 2012 - 2013 TemPlaza.com. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Add JavaScript Frameworks
//JHtml::_('bootstrap.framework');

// Add Stylesheets
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/bootstrap/css/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/themes/'.$this -> params -> get('theme','default').'/template.css');

// Load optional rtl Bootstrap css and Bootstrap bugfixes
JHtmlBootstrap::loadCss($includeMaincss = false, $this->direction);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <jdoc:include type="head" />
    <?php
    $app    = JFactory::getApplication();
    $template   = $app -> getTemplate(true);
    $tplparams  = $this -> params;

    // include fonts
    $font_iter = 1;
    $inlinecss  =   '';
    while($tplparams->get('font_name_group'.$font_iter, 'tzFontNull') !== 'tzFontNull') {
        $font_data = explode(';', $tplparams->get('font_name_group'.$font_iter, ''));

        if(isset($font_data) && count($font_data) >= 2) {
            $font_type = $font_data[0];
            $font_name = $font_data[1];

            if($tplparams->get('font_rules_group'.$font_iter, '') != ''){
                if($font_type == 'standard') {
                    $this->addStyleDeclaration($tplparams->get('font_rules_group'.$font_iter, '') . ' { font-family: ' . $font_name . '; }'."\n");
                } elseif($font_type == 'google') {
                    $font_link = $font_data[2];
                    $font_family = $font_data[3];
                    $this->addStyleSheet($font_link);
                    $this->addStyleDeclaration($tplparams->get('font_rules_group'.$font_iter, '') . ' { font-family: '.$font_family.', Arial, sans-serif; }'."\n");
                } elseif($font_type == 'squirrel') {
                    $this->addStyleSheet(PLAZART_TEMPLATE_REL. '/fonts/' . $font_name . '/stylesheet.css');
                    $this->addStyleDeclaration($tplparams->get('font_rules_group'.$font_iter, '') . ' { font-family: ' . $font_name . ', Arial, sans-serif; }'."\n");
                } elseif($font_type == 'edge') {
                    $font_link = $font_data[2];
                    $font_family = $font_data[3];
                    $this->addScript($font_link);
                    $this->addStyleDeclaration($tplparams->get('font_rules_group'.$font_iter, '') . ' { font-family: ' . $font_family . ', sans-serif; }'."\n");
                }
            }
        }

        $font_iter++;
    }?>
    <!--[if lt IE 9]>
    <script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script>
    <![endif]-->
</head>
<body class="contentpane">
<jdoc:include type="message" />
<div class="container-fluid">
    <div class="row">
<jdoc:include type="component" />
    </div>
</div>
</body>
</html>
