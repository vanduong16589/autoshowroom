<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2015 templaza.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

JLoader::import('route',JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR
    .'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR.'helpers');
JLoader::import('framework',JPATH_ADMINISTRATOR.'/components/com_tz_portfolio_plus/includes');

/**
 * Pagenavigation plugin class.
 */
class PlgTZ_Portfolio_PlusContentComment extends TZ_Portfolio_PlusPlugin
{
    protected $articles         = null;
    protected $commentCounts    = null;
    protected $autoloadLanguage = true;

    public function onAddContentType(){
        $type           = array();
        $type_layout    = new stdClass();
        $lang           = JFactory::getLanguage();

        // Create comment's count type
        $lang_key = 'PLG_' . $this->_type . '_' . $this->_name . '_COUNT_TITLE';
        $lang_key = strtoupper($lang_key);

        if ($lang->hasKey($lang_key)) {
            $type_layout->text = JText::_($lang_key);
        } else {
            $type_layout->text = $this->_name;
        }

        $type_layout->value = $this->_name.':count';

        $type[]             = clone($type_layout);

        // Create comment type
        $lang_key = 'PLG_' . $this->_type . '_' . $this->_name . '_TITLE';
        $lang_key = strtoupper($lang_key);

        if ($lang->hasKey($lang_key)) {
            $type_layout->text = JText::_($lang_key);
        } else {
            $type_layout->text = $this->_name;
        }

        $type_layout->value = $this->_name;

        $type[]             = clone($type_layout);

        return $type;
    }

    public function onLoadData($context, $articles, $params){

        if($articles) {
            // Merge plugin and article params
            $_params = clone($this->params);
            $_params->merge($params);

            $threadLink     = null;
            $commentCounts  = null;

            if($_params -> get('comment_function_type','default') != 'js'){

                tzportfolioplusimport('phpclass.http_fetcher');
                tzportfolioplusimport('phpclass.readfile');

                $fetch       = new Services_Yadis_PlainHTTPFetcher();

                // Get comment counts for all items(articles)
                if($_params -> get('show_comment_count',1)){

                    if(is_array($articles)){
                        foreach ($articles as $item) {
                            $link   = JRoute::_(TZ_Portfolio_PlusHelperRoute::getArticleRoute($item -> slug, $item -> catslug),true,-1);
                            if ($_params->get('comment_type', 'facebook') == 'disqus') {
                                $threadLink[]   = '&amp;thread[]=link:' . urlencode($link);
                            } elseif ($_params->get('comment_type', 'facebook') == 'facebook') {
                                $threadLink[]   = '&amp;urls[]=' . urlencode($link);
                            }
                        }
                    }else{
                        if ($_params->get('comment_type', 'facebook') == 'disqus') {
                            $threadLink .= '&amp;thread=link:'.urlencode($articles -> fullLink);
                        } elseif ($_params->get('comment_type', 'facebook') == 'facebook') {
                            $threadLink .= '&amp;ids='.$articles -> fullLink;
                        }

                    }

                    // From Disqus
                    if($_params -> get('comment_type','facebook') == 'disqus'){
                        if($threadLink){
                            if(is_array($threadLink) && count($threadLink)) {
                                $url = 'https://disqus.com/api/3.0/threads/list.json?api_secret='
                                    . $_params->get('disqus_secretkey', '4sLbLjSq7ZCYtlMkfsG7SS5muVp7DsGgwedJL5gRsfUuXIt6AX5h6Ae6PnNREMiB')
                                    . '&amp;forum=' . $_params->get('disqus_subdomain', 'templazatoturials')
                                    . implode('',$threadLink) . '&amp;include=open';

                                $content    = $fetch -> get($url);

                                if($content){
                                    if($body    = json_decode($content -> body)){
                                        if($responses = $body -> response){
                                            if(!is_array($responses)){
                                                $app    = JFactory::getApplication();
                                                $app -> enqueueMessage(JText::_('PLG_CONTENT_COMMENT_DISQUS_INVALID_SECRET_KEY'), 'notice');
                                            }
                                            if(is_array($responses) && count($responses)){
                                                foreach($responses as $response){
                                                    $commentCounts[$response ->link]   = $response -> posts;
                                                }
                                            }
                                        }
                                    }
                                }
                            }else{
                                $url        = 'https://disqus.com/api/3.0/threads/listPosts.json?api_secret='
                                    .$_params -> get('disqus_secretkey','4sLbLjSq7ZCYtlMkfsG7SS5muVp7DsGgwedJL5gRsfUuXIt6AX5h6Ae6PnNREMiB')
                                    .'&amp;forum='.$_params -> get('disqus_subdomain','templazatoturials')
                                    .$threadLink.'&amp;include=approved';

                                $content    = $fetch -> get($url);

                                if($content){
                                    if($body    = json_decode($content -> body)){
                                        if($responses = $body -> response){
                                            $commentCounts[$articles -> fullLink]   = count($responses);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // From Facebook
                    if($_params -> get('comment_type','facebook') == 'facebook'){
                        if($threadLink){

                            if(is_array($threadLink) && count($threadLink)){
                                $url        = 'http://api.facebook.com/restserver.php?method=links.getStats'
                                    .implode('',$threadLink);
                                $content    = $fetch -> get($url);

                                if($content){
                                    if($bodies = $content -> body){
                                        if(preg_match_all('/\<link_stat\>(.*?)\<\/link_stat\>/ims',$bodies,$matches)){
                                            if(isset($matches[1]) && !empty($matches[1])){
                                                foreach($matches[1]as $val){
                                                    $match  = null;
                                                    if(preg_match('/\<url\>(.*?)\<\/url\>.*?\<comment_count\>(.*?)\<\/comment_count\>/msi',$val,$match)){
                                                        if(isset($match[1]) && isset($match[2])){
                                                            $commentCounts[$match[1]]    = $match[2];
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }else{
                                $url        = 'http://graph.facebook.com/?ids='
                                    .$threadLink;
                                $content    = $fetch -> get($url);
                                $contentUrl = $articles -> fullLink;

                                if($content){
                                    if($body = $content -> body){
                                        if(isset($body -> $contentUrl -> comments)){
                                            $commentCounts[$articles -> fullLink]   = $body -> $contentUrl  -> comments;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                // End Get comment counts for all items(articles)
            }
            $this -> commentCounts  = $commentCounts;
            $this -> articles       = $articles;
        }
    }

    public function onAfterDisplayAdditionInfo($context, &$article, &$params, $page = 0, $layout = 'default'){
        list($extension, $vName)   = explode('.', $context);

        $item       = clone($article);
        $_params    = clone($this->params);
        $_params->merge($params);

        if($_params -> get('comment_type','facebook') == 'disqus' ||
            $_params -> get('comment_type','facebook') == 'facebook'){
            if($this -> commentCounts && count($this -> commentCounts)){
                if(array_key_exists($article -> fullLink,$this -> commentCounts)){
                    $item -> commentCount   = $this -> commentCounts[$article -> fullLink];
                }else{
                    $item -> commentCount   = 0;
                }
            }else{
                $item -> commentCount   = 0;
            }
        }elseif($_params -> get('comment_type','facebook') == 'jcomment'){
            JLoader::import('jcomments',JPATH_SITE.'/components/com_jcomments');
            if(class_exists('JComments')){
                $item -> commentCount   = JComments::getCommentsCount((int) $article -> id,'com_tz_portfolio_plus');
            }
        }
        if($extension == 'module' || $extension == 'modules'){
            if($path = $this -> getModuleLayout($this -> _type, $this -> _name, $extension, $vName, $layout.'_count')){
                // Display html
                ob_start();
                include $path;
                $html = ob_get_contents();
                ob_end_clean();
                $html = trim($html);
                return $html;
            }
        }elseif(in_array($context, array('com_tz_portfolio_plus.portfolio', 'com_tz_portfolio_plus.date'
        , 'com_tz_portfolio_plus.featured', 'com_tz_portfolio_plus.tags', 'com_tz_portfolio_plus.users'))){
            if ($view = $this->getView($vName, 'count', $item, $params)) {
                // Display html
                ob_start();
                $view->display();
                $html = ob_get_contents();
                ob_end_clean();
                $html = trim($html);
                return $html;
            }
        }
    }

    public function onContentDisplayArticleView($context, &$article, $params, $page = 0, $layout = null){
        list($extension, $vName)   = explode('.', $context);

        $item   = clone($article);
        $_params    = clone($this->params);
        $_params->merge($params);

        if($_params -> get('comment_type','facebook') == 'disqus' ||
            $_params -> get('comment_type','facebook') == 'facebook'){
            if($this -> commentCounts && count($this -> commentCounts)){
                if(array_key_exists($article -> fullLink,$this -> commentCounts)){
                    $item -> commentCount   = $this -> commentCounts[$article -> fullLink];
                }else{
                    $item -> commentCount   = 0;
                }
            }else{
                $item -> commentCount   = 0;
            }
        }elseif($_params -> get('comment_type','facebook') == 'jcomment'){
            JLoader::import('jcomments',JPATH_SITE.'/components/com_jcomments');
            if(class_exists('JComments')){
                $item -> commentCount   = JComments::getCommentsCount((int) $article -> id,'com_tz_portfolio_plus');
                $item -> comment        = JComments::showComments($article ->id, 'com_tz_portfolio_plus', $article -> title);
            }
        }
        if($extension == 'module' || $extension == 'modules'){
            if($path = $this -> getModuleLayout($this -> _type, $this -> _name, $extension, $vName, $layout)){
                // Display html
                ob_start();
                include $path;
                $html = ob_get_contents();
                ob_end_clean();
                $html = trim($html);
                return $html;
            }
        }else {
            if ($view = $this->getView($vName, $layout, $item, $params)) {
                // Display html
                ob_start();
                $view->display();
                $html = ob_get_contents();
                ob_end_clean();
                $html = trim($html);
                return $html;
            }
        }
    }

}
?>