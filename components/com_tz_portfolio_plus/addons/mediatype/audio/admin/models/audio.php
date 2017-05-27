<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

class PlgTZ_Portfolio_PlusMediaTypeModelAudio extends TZ_Portfolio_PlusPluginModelAdmin
{
    // This function to upload and save data with data saved in com
    public function save($data){

        $app    = JFactory::getApplication();
        $input  = $app -> input;

        // Get params
        $params     = $this -> getState('params');

        // Get data from form
        $audio_data     = JRequest::getVar('jform',array());
        $audio_data     = $audio_data['media'][$this -> getName()];
        $files          = JRequest::getVar('jform','','files');
        $audio_files    = array();

        $mime_types     = $params -> get('audio_thumbnail_mime_type','image/jpeg,image/gif,image/png,image/bmp');
        $mime_types     = explode(',',$mime_types);
        $file_types     = $params -> get('audio_thumbnail_file_type','bmp,gif,jpg,jpeg,png');
        $file_types     = explode(',',$file_types);
        $file_sizes     = $params -> get('audio_thumbnail_file_size',10);
        $file_sizes     = $file_sizes * 1024 * 1024;

        $audio          = null;
        if($data -> media && !empty($data -> media)) {
            $audio  = new JRegistry;
            $audio -> loadString($data -> media);
            $audio  = $audio -> get($this -> getName());
        }

        // Set data when save as copy article
        if($input -> getCmd('task') == 'save2copy' && $input -> getInt('id')){
            if((isset($audio_data['thumbnail_remove']) && $audio_data['thumbnail_remove'])){
                $audio_data['thumbnail_remove']   = null;
                $audio_data['thumbnail']          = '';
            }
            if(!isset($audio_data['thumbnail_server'])
                || (isset($audio_data['thumbnail_server']) && empty($audio_data['thumbnail_server']))){
                if(isset($audio_data['thumbnail']) && $audio_data['thumbnail']) {
                    $ext        = JFile::getExt($audio_data['thumbnail']);
                    $path_copy  = str_replace('.'.$ext,'_o.'.$ext, $audio_data['thumbnail']);
                    if(JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.$path_copy)) {
                        $audio_data['thumbnail_server']   = $path_copy;
                        $audio_data['thumbnail']          = '';
                    }
                }
            }
        }


        // Check video code if it doesn't have data remove thumbnail and reset data
        if($audio_data && count($audio_data)){
            if($audio_data['type'] == 'embed'){
                if(!isset($audio_data['embed_code'])
                    || (isset($audio_data['embed_code']) && empty($audio_data['embed_code']))){

                    // Delete thumbnail if it created
                    if(isset($audio_data['thumbnail']) && $audio_data['thumbnail']){
                        // Delete original thumbnail
                        $thumbnail_url  = str_replace('.'.JFile::getExt($audio_data['thumbnail']),'_o.'
                            .JFile::getExt($audio_data['thumbnail']), $audio_data['thumbnail']);
                        JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                $thumbnail_url));

                        // Delete thumbnail which them resized
                        if ($params && $thumb_size = $params->get('audio_thumbnail_size')) {
                            $thumb_size = $this->prepareImageSize($thumb_size);

                            foreach ($thumb_size as $_size) {
                                $size = json_decode($_size);
                                $thumbnail_url  = str_replace('.'.JFile::getExt($audio_data['thumbnail']),'_'
                                    .$size -> image_name_prefix.'.'
                                    .JFile::getExt($audio_data['thumbnail']), $audio_data['thumbnail']);
                                JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                        $thumbnail_url));
                            }
                        }
                    }

                    foreach($audio_data as $key => $vdata){
                        $audio_data[$key]   = '';
                    }

                    unset($audio_data['thumbnail_server']);
                    if(isset($audio_data['thumbnail_remove'])){
                        unset($audio_data['thumbnail_remove']);
                    }

                    $this -> __save($data,$audio_data);
                    return;
                }

            }elseif($audio_data['type'] == 'soundcloud'){
                if(!isset($audio_data['code'])
                    || (isset($audio_data['code']) && empty($audio_data['code']))){

                    // Delete thumbnails if they were created
                    if(isset($audio_data['thumbnail']) && $audio_data['thumbnail']){
                        // Delete original thumbnail
                        $thumbnail_url  = str_replace('.'.JFile::getExt($audio_data['thumbnail']),'_o.'
                            .JFile::getExt($audio_data['thumbnail']), $audio_data['thumbnail']);
                        JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                $thumbnail_url));

                        // Delete thumbnail which them resized
                        if ($params && $thumb_size = $params->get('audio_thumbnail_size')) {
                            $thumb_size = $this->prepareImageSize($thumb_size);

                            foreach ($thumb_size as $_size) {
                                $size = json_decode($_size);
                                $thumbnail_url  = str_replace('.'.JFile::getExt($audio_data['thumbnail']),'_'
                                    .$size -> image_name_prefix.'.'
                                    .JFile::getExt($audio_data['thumbnail']), $audio_data['thumbnail']);
                                JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                        $thumbnail_url));
                            }
                        }
                    }

                    foreach($audio_data as $key => $vdata){
                        $audio_data[$key]   = '';
                    }

                    unset($audio_data['thumbnail_server']);
                    if(isset($audio_data['thumbnail_remove'])){
                        unset($audio_data['thumbnail_remove']);
                    }

                    $this -> __save($data,$audio_data);
                    return;
                }
            }
        }

        // Upload thumbnail and create data for thumbnail to store database
        $original   = null;
        $filename   = null;
        $thumbType  = null;
        $_fileName  = ((!$data -> alias)?uniqid() .'tz_portfolio_plus_'.time():$data -> alias)
            .'-'.$data -> id.'-a';

        // Get thumbnail data from form
        if($files  && isset($files['tmp_name']['media']['audio'])){
            if(isset($files['name']['media']['audio']['thumbnail_client'])) {
                $audio_files['name']        = $files['name']['media']['audio']['thumbnail_client'];
                $audio_files['type']        = $files['type']['media']['audio']['thumbnail_client'];
                $audio_files['tmp_name']    = $files['tmp_name']['media']['audio']['thumbnail_client'];
                $audio_files['error']       = $files['error']['media']['audio']['thumbnail_client'];
                $audio_files['size']        = $files['size']['media']['audio']['thumbnail_client'];
            }
        }


        // Upload video's thumbnail
        if (count($audio_files) && !empty($audio_files['tmp_name'])) {
            $thumbType = JFile::getExt($audio_files['name']);

            //-- Check thumbnail information --//
            // Check MIME Type
            if (!in_array($audio_files['type'], $mime_types)) {
                $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNINVALID_MIME'), 'notice');
                return false;
            }

            // Check file type
            if (!in_array($thumbType, $file_types)) {
                $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNFILETYPE'), 'notice');
                return false;
            }

            // Check file size
            if ($audio_files['size'] > $file_sizes) {
                $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNFILETOOLARGE'), 'notice');
                return false;
            }
            //-- End check thumbnail information --//

            // Before upload image to file must delete original file
            if ($audio && isset($audio->thumbnail) && !empty($audio->thumbnail)) {
                $audio_url  = $audio->thumbnail;
                $audio_type = JFile::getExt($audio_url);
                $audio_url  = str_replace('.' . $audio_type, '_o'. '.' . $audio_type, $audio_url);

                // Execute delete thumbnail
                JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                        $audio_url));
            }

            $original = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_ROOT . DIRECTORY_SEPARATOR . $_fileName . '_o.' . $thumbType;

            // Upload original thumbnail
            if (JFile::upload($audio_files['tmp_name'], $original)) {
                $filename = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_BASE . '/' . $_fileName . '.' . $thumbType;
            }

            if($input -> getCmd('task') == 'save2copy' && $input -> getInt('id')){
                $audio_data['thumbnail_server']   = null;
            }

        } elseif ($audio_data['thumbnail_server'] && !empty($audio_data['thumbnail_server'])) {
            $thumbType = JFile::getExt($audio_data['thumbnail_server']);
            $audio_thumb = new JImage(JPATH_ROOT . DIRECTORY_SEPARATOR . $audio_data['thumbnail_server']);
            $audio_property = $audio_thumb->getImageFileProperties($audio_thumb->getPath());

            //-- Check thumbnail information --//
            // Check MIME Type
            if (!in_array($audio_property->mime, $mime_types)) {
                $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNINVALID_MIME'), 'notice');
                return false;
            }

            // Check file type
            if (!in_array($thumbType, $file_types)) {
                $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNFILETYPE'), 'notice');
                return false;
            }

            // Check file size
            if ($audio_property->filesize > $file_sizes) {
                $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNFILETOOLARGE'), 'notice');
                return false;
            }
            //-- End check thumbnail information --//

            // Before upload image to file must delete original file
            if ($audio && isset($audio->thumbnail) && !empty($audio->thumbnail)) {
                $audio_url = $audio->thumbnail;
                $audio_type = JFile::getExt($audio_url);
                $audio_url = str_replace('.' . $audio_type, '_o'
                    . '.' . $audio_type, $audio_url);
                JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                        $audio_url));
            }

            $original = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_ROOT . DIRECTORY_SEPARATOR . $_fileName . '_o.' . $thumbType;

            // Upload original thumbnail
            if (JFile::copy($audio_thumb->getPath(), $original)) {
                $filename = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_BASE . '/' . $_fileName . '.' . $thumbType;
            }
        }else{
            if(!isset($audio_data['thumbnail']) || (isset($audio_data['thumbnail']) && empty($audio_data['thumbnail']))
                || (isset($audio_data['thumbnail']) && !empty($audio_data['thumbnail']) &&
                    isset($audio_data['thumbnail_remove']) && !empty($audio_data['thumbnail_remove']))) {
                // Upload thumbnail from soundcloud

                if ($audio_data['type'] == 'soundcloud' && isset($audio_data['code']) && !empty($audio_data['code'])) {
                    tzportfolioplusimport('phpclass.http_fetcher');
                    tzportfolioplusimport('phpclass.readfile');

                    // Upload thumbnail from soundcloud
                    $file       = new Services_Yadis_PlainHTTPFetcher();
                    $thumbUrl   = null;
                    $url        = null;

                    // Create thumbnail url with code from soundcloud
                    if($client_id = $params -> get('soundcloud_client_id','4a24c193db998e3b88c34cad41154055')) {
                        $url = 'http://api.soundcloud.com/tracks/' . $audio_data['code']
                            . '.json?client_id=' . $client_id;
                    }

                    if ($url) {
                        $thumb = $file->get($url);

                        // Check thumbnail exists
                        if ($thumb->status == '404') {
                            $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNINVALID'), 'notice');
                            return false;
                        }

                        $thumb    = json_decode($thumb -> body);

                        if($thumb -> artwork_url && !empty($thumb -> artwork_url)){
                            $thumbUrl   = $thumb -> artwork_url;
                        }
                        else{
                            $audioUser   = $thumb -> user;
                            if($audioUser -> avatar_url && !empty($audioUser -> avatar_url)){
                                $thumbUrl   = $audioUser -> avatar_url;
                            }
                        }

                        if($thumbUrl){

                            if(JString::strrpos($thumbUrl,'-',0) != false){
                                $thumbUrl = JString::substr($thumbUrl,0,JString::strrpos($thumbUrl,'-',0)+1).'t500x500.'.JFile::getExt($thumbUrl);
                            }

                            $thumbType  = JFile::getExt($thumbUrl);

                            //Upload thumbnail
                            if ($thumb = $file->get($thumbUrl)) {

                                //-- Check thumbnail information --//
                                // Check MIME Type
                                if (isset($thumb->headers) && isset($thumb->headers['Content-Type'])
                                    && !empty($thumb->headers['Content-Type'])
                                    && !in_array($thumb->headers['Content-Type'], $mime_types)
                                ) {
                                    $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNINVALID_MIME'), 'notice');
                                    return false;
                                }

                                // Check file type
                                if (!in_array($thumbType, $file_types)) {
                                    $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNFILETYPE'), 'notice');
                                    return false;
                                }

                                // Check file size
                                if (isset($thumb->headers) && isset($thumb->headers['Content-Type'])
                                    && !empty($thumb->headers['Content-Type'])
                                    && $thumb->headers['Content-Length'] > $file_sizes
                                ) {
                                    $app->enqueueMessage(JText::_('PLG_MEDIATYPE_AUDIO_THUMBNAIL_ERROR_WARNFILETOOLARGE'), 'notice');
                                    return false;
                                }
                                //-- End check thumbnail information --//

                                // Before upload image to file must delete original file
                                if ($audio && isset($audio->thumbnail) && !empty($audio->thumbnail)) {
                                    $audio_url = $audio->thumbnail;
                                    $audio_type = JFile::getExt($audio_url);
                                    $audio_url = str_replace('.' . $audio_type, '_o'
                                        . '.' . $audio_type, $audio_url);
                                    JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                            $audio_url));
                                }

                                $original = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_ROOT . DIRECTORY_SEPARATOR . $_fileName . '_o.' . $thumbType;

                                // Upload original thumbnail
                                if (JFile::write($original, $thumb->body)) {
                                    $filename = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_BASE . '/' . $_fileName . '.' . $thumbType;
                                }
                            }
                        }
                    }

                    unset($audio_data['thumbnail_remove']);

                }
            }
        }
        // Upload image with resize
        if($filename && !empty($filename) && $original && !empty($original)) {
            if ($params && $thumb_size = $params->get('audio_thumbnail_size')) {
			
				if(!is_array($thumb_size) && preg_match_all('/(\{.*?\})/',$thumb_size,$match)) {
					$thumb_size = $match[1];
				}
									
                if (JFile::exists($original)) {
                    $thumbnail = new JImage($original);
                    foreach ($thumb_size as $_size) {
                        $size = json_decode($_size);

                        // Before upload image to file must delete original file
                        if($audio && isset($audio -> thumbnail) && !empty($audio -> thumbnail)){
                            $audio_url  = $audio -> thumbnail;
                            $audio_type = JFile::getExt($audio_url);
                            $audio_url  = str_replace('.'.$audio_type,'_'.$size -> image_name_prefix
                                .'.'.$audio_type,$audio_url);
                            JFile::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/',DIRECTORY_SEPARATOR,
                                    $audio_url));
                        }

                        // Create new ratio from new with of image size param
                        $thumbProperties    = $thumbnail->getImageFileProperties($original);
                        $newH               = ($thumbProperties->height * $size->width) / ($thumbProperties->width);
                        $newImage           = $thumbnail->resize($size->width, $newH);

                        $newPath = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_ROOT . DIRECTORY_SEPARATOR
                            . $_fileName . '_' . $size->image_name_prefix . '.' . $thumbType;

                        // Generate image to file
                        $newImage->toFile($newPath, $thumbProperties->type);

                    }
                }
            }
            $audio_data['thumbnail'] = $filename;
        }

        unset($audio_data['thumbnail_server']);

        $this -> __save($data,$audio_data);

    }

    public function delete(&$article){
        if($article){
            if(is_object($article)){
                if($article -> media && !empty($article -> media)) {
                    $media  = new JRegistry;
                    $media -> loadString($article -> media);

                    $media  = $media -> get($this -> getName());
                    $params = $this -> getState('params');

                    if($media){
                        if(isset($media -> thumbnail) && !empty($media -> thumbnail)){
                            // Delete original image
                            $image_url  = str_replace('.'.JFile::getExt($media->thumbnail),
                                '_o.'.JFile::getExt($media->thumbnail),$media->thumbnail);
                            JFile::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/',DIRECTORY_SEPARATOR,
                                    $image_url));
                        }

                        // Delete image with some size
                        if($image_size = $params -> get('audio_thumbnail_size', array())){

                            $image_size = $this -> prepareImageSize($image_size);

                            if(is_array($image_size) && count($image_size)){
                                foreach($image_size as $_size){
                                    $size           = json_decode($_size);

                                    // Delete image
                                    if(isset($media -> thumbnail) && !empty($media -> thumbnail)) {
                                        // Create file name and execute delete image
                                        $image_url = str_replace('.' . JFile::getExt($media->thumbnail), '_' . $size->image_name_prefix
                                            . '.' . JFile::getExt($media->thumbnail), $media->thumbnail);
                                        JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                                $image_url));
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
    }
}