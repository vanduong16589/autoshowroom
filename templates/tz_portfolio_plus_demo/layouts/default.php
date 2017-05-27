<?php
/**
 *
 * Plazart framework layout
 *
 * @version             1.0.0
 * @package             Plazart Framework
 * @copyright			Copyright (C) 2012 - 2013 TemPlaza. All rights reserved.
 *
 */
 
// no direct access
defined('_JEXEC') or die;
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<?php $this->loadBlock('head'); ?>
</head>

<body class="<?php echo $this->bodyClass() ?>">
    <?php
    if ($this->getParam('layout_enable',1)) {
        $this->layout();
    } else {
        $this->loadBlock('body');
    }
    if ($this->getParam('framework_logo',1)) $this->loadBlock('framework');
?>
<!--    <script>-->
<!--        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){-->
<!--                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),-->
<!--            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)-->
<!--        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');-->
<!---->
<!--        ga('create', 'UA-74963988-2', 'auto');-->
<!--        ga('send', 'pageview');-->
<!---->
<!--    </script>-->
</body>
</html>