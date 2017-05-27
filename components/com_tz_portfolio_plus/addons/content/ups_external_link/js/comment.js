/*------------------------------------------------------------------------

 # TZ Portfolio Plus Extension

 # ------------------------------------------------------------------------

 # Author:    DuongTVTemPlaza

 # Copyright: Copyright (C) 2015 templaza.com. All Rights Reserved.

 # @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

 # Websites: http://www.templaza.com

 # Technical Support:  Forum - http://templaza.com/Forum

 -------------------------------------------------------------------------*/

//(function($){
"use strict";
    function tzPortfolioAjaxCommentCount($element, itemid, text, link) {
        if ($element.length) {
            if ($element.find('.name a').length) {
                var url = 'index.php?option=com_tz_portfolio_plus&task=portfolio.plugin_ajax&type=content&plugin=comment',
                    $href = [],
                    $articleId = [];
                if (link) {
                    url = link;
                }
                $element.map(function (index, obj) {
                    if (jQuery(obj).find('.name a').length) {
                        if (jQuery(obj).find('.name a').attr('href').length) {
                            $href.push(jQuery(obj).find('.name a').attr('href'));
                            if (jQuery(obj).attr('id')) {
                                $articleId.push(jQuery(obj).attr('id'));
                            }
                        }
                    }
                });

                jQuery.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        Itemid: itemid,
                        url: window.Base64.encode(window.JSON.encode($href)),
                        id: window.Base64.encode(window.JSON.encode($articleId))
                    }
                }).success(function (data) {
                    if (data && data.length) {
                        var $comment = window.JSON.decode(data);
                        if (typeof $comment == 'object') {
                            jQuery.each($comment, function (key, value) {
                                if (jQuery('#' + key).find('.TzPortfolioCommentCount').length) {
                                    jQuery('#' + key).find('.TzPortfolioCommentCount').html(text + '<span>' + value + '</span>');
                                }
                            });
                        }
                    }
                });
            }
        }
    }
//})(jQuery);

