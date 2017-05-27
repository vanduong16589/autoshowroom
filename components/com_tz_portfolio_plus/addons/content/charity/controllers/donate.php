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

// No direct access.
defined('_JEXEC') or die;

tzportfolioplusimport('controller.form');

class PlgTZ_Portfolio_PlusContentCharityControllerDonate extends TZ_Portfolio_Plus_AddOnControllerForm
{

    public function process_donation($key = null, $urlVar = null)
    {

        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app   = JFactory::getApplication();
        $lang  = JFactory::getLanguage();
        $model = $this->getModel();
        $table = $model->getTable();
        $data  = $this->input->post->get('jform', array(), 'array');
        $checkin = property_exists($table, 'checked_out');
        $context = "$this->option.edit.$this->context";
        $task = $this->getTask();
        $input  = $app->input;

//        var_dump($input->get('return')); die;
        // Determine the name of the primary key for the data.
        if (empty($key))
        {
            $key = $table->getKeyName();
        }

        // To avoid data collisions the urlVar may be different from the primary key.
        if (empty($urlVar))
        {
            $urlVar = $key;
        }

        $recordId = $this->input->getInt($urlVar);

        // Populate the row id from the session.
        $data[$key] = $recordId;

        // The save2copy task needs to be handled slightly differently.
        if ($task == 'save2copy')
        {
            // Check-in the original row.
            if ($checkin && $model->checkin($data[$key]) === false)
            {
                // Check-in failed. Go back to the item and display a notice.
                $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
                $this->setMessage($this->getError(), 'error');

                $addonIdURL		= ($addon_id = $this->input -> getInt('addon_id'))?'&addon_id='.$addon_id:'';
                $view           = $this -> input -> getCmd('view');
                $this->setRedirect(
                    JRoute::_('index.php?option=' . $this->option . '&view='.$view
                        .$addonIdURL.'&addon_view=' . $this->view_item. $this->getRedirectToItemAppend($recordId, $urlVar)
                        , false
                    )
                );

                return false;
            }

            // Reset the ID and then treat the request as for Apply.
            $data[$key] = 0;
            $task = 'apply';
        }

        // Access check.
//        if (!$this->allowSave($data, $key))
//        {
//            $this->setError(JText::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'));
//            $this->setMessage($this->getError(), 'error');
//
//            $addonIdURL		= ($addon_id = $this->input -> getInt('addon_id'))?'&addon_id='.$addon_id:'';
//            $view           = $this -> input -> getCmd('view');
//            $this->setRedirect(
//                JRoute::_('index.php?option=' . $this->option . '&view='.$view
//                    .$addonIdURL.'&addon_view=' . $this->view_list. $this->getRedirectToItemAppend()
//                    , false
//                )
//            );
//
//            return false;
//        }

        // Validate the posted data.
        // Sometimes the form needs some posted data, such as for plugins and modules.
        $form = $model->getForm($data, false);

        if (!$form)
        {
            $app->enqueueMessage($model->getError(), 'error');

            return false;
        }

        // Test whether the data is valid.
        $validData = $model->validate($form, $data);

        // Check for validation errors.
        if ($validData === false)
        {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
            {
                if ($errors[$i] instanceof Exception)
                {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                }
                else
                {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            // Save the data in the session.
            $app->setUserState($context . '.data', $data);

            // Redirect back to the edit screen.
//            $addonIdURL		= ($addon_id = $this->input -> getInt('addon_id'))?'&addon_id='.$addon_id:'';
//            $view           = $this -> input -> getCmd('view');
//            $this->setRedirect(
//                JRoute::_('index.php?option=' . $this->option . '&view='.$view
//                    .$addonIdURL.'&addon_view=' . $this->view_item. $this->getRedirectToItemAppend($recordId, $urlVar)
//                    , false
//                )
//            );

            $this->setRedirect($this->getReturnPage());

            return false;
        }

        // Attempt to save the data.
        if (!$model->save($validData))        {

            // Save the data in the session.
            $app->setUserState($context . '.data', $validData);

            // Redirect back to the edit screen.

            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));

            $this->setMessage($this->getError(), 'error');

//            $addonIdURL		= ($addon_id = $this->input -> getInt('addon_id'))?'&addon_id='.$addon_id:'';
//            $view           = $this -> input -> getCmd('view');
//            $this->setRedirect(
//                JRoute::_('index.php?option=' . $this->option . '&view='.$view
//                    .$addonIdURL.'&addon_view=' . $this->view_item. $this->getRedirectToItemAppend($recordId, $urlVar)
//                    , false
//                )
//            );

            $this->setRedirect($this->getReturnPage());

            return false;
        }

        // Save succeeded, so check-in the record.
        if ($checkin && $model->checkin($validData[$key]) === false)
        {
            // Save the data in the session.
            $app->setUserState($context . '.data', $validData);

            // Check-in failed, so go back to the record and display a notice.
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
            $this->setMessage($this->getError(), 'error');

            $addonIdURL		= ($addon_id = $this->input -> getInt('addon_id'))?'&addon_id='.$addon_id:'';
            $view           = $this -> input -> getCmd('view');
            $this->setRedirect(
                JRoute::_('index.php?option=' . $this->option . '&view='.$view
                    .$addonIdURL.'&addon_view=' . $this->view_item. $this->getRedirectToItemAppend($recordId, $urlVar)
                    , false
                )
            );

            return false;
        }

        $this->setMessage(
            JText::_(
                ($lang->hasKey($this->text_prefix . ($recordId == 0 && $app->isSite() ? '_SUBMIT' : '') . '_SAVE_SUCCESS')
                    ? $this->text_prefix
                    : 'JLIB_APPLICATION') . ($recordId == 0 && $app->isSite() ? '_SUBMIT' : '') . '_SAVE_SUCCESS'
            )
        );

        // Redirect the user and adjust session state based on the chosen task.
        switch ($task)
        {
            case 'apply':
                // Set the record data in the session.
                $recordId = $model->getState($this->context . '.id');
                $this->holdEditId($context, $recordId);
                $app->setUserState($context . '.data', null);
                $model->checkout($recordId);

                // Redirect back to the edit screen.
                $addonIdURL		= ($addon_id = $this->input -> getInt('addon_id'))?'&addon_id='.$addon_id:'';
                $view           = $this -> input -> getCmd('view');
                $this->setRedirect(
                    JRoute::_('index.php?option=' . $this->option . '&view='.$view
                        .$addonIdURL.'&addon_view=' . $this->view_item. $this->getRedirectToItemAppend($recordId, $urlVar)
                        , false
                    )
                );
                break;

            case 'save2new':
                // Clear the record id and data from the session.
                $this->releaseEditId($context, $recordId);
                $app->setUserState($context . '.data', null);

                // Redirect back to the edit screen.
                $addonIdURL		= ($addon_id = $this->input -> getInt('addon_id'))?'&addon_id='.$addon_id:'';
                $view           = $this -> input -> getCmd('view');
                $this->setRedirect(
                    JRoute::_('index.php?option=' . $this->option . '&view='.$view
                        .$addonIdURL.'&addon_view=' . $this->view_item. $this->getRedirectToItemAppend(null, $urlVar)
                        , false
                    )
                );
                break;

            default:
                // Clear the record id and data from the session.
                $this->releaseEditId($context, $recordId);
                $app->setUserState($context . '.data', null);

                // Redirect to the list screen.
                $addonIdURL		= ($addon_id = $this->input -> getInt('addon_id'))?'&addon_id='.$addon_id:'';
                $view           = $this -> input -> getCmd('view');
                $this->setRedirect(
                    JRoute::_('index.php?option=' . $this->option . '&view='.$view
                        .$addonIdURL.'&addon_view=' . $this->view_list. $this->getRedirectToItemAppend()
                        , false
                    )
                );
                break;
        }

        // Invoke the postSave method to allow for the child class to access the model.
        $this->postSaveHook($model, $validData);

        // If ok, redirect to the return page.

        ////////////////////////////////////////////////////// Paypal ////////////////////////////////////

        $linkReturn = $this->getReturnPage();
        $checkV     = strpos($linkReturn,'&');
        $idElement  = $model->getIDElement();
        $payView    = base64_encode('paypalre'.$idElement);

        if($checkV === false) {
            $linkV = JRoute::_($this->getReturnPage().'?charity_view='.$payView);
        }

        if($checkV !== false) {
            $linkV = JRoute::_($this->getReturnPage().'&charity_view='.$payView);
        }

        ////////////////////////////////////////////////////  End Paypal  ////////////////////////////////////

        $this->setRedirect($linkV);
//        return 0;
//        return true;
    }

    public function notification() {
        $this->paypal = JRequest::get('post');
    }

    public function paymentcancel() {
        $this->paypal = JRequest::get('post');

        $this->setMessage(JText::_('Donate Cancel'));

        $linkReturn     = $this->getReturnPage();
        $linkRedirect   = JRoute::_($linkReturn);

        $this->setRedirect($linkRedirect);

        return true;

    }

    public function received() {

        $lang  = JFactory::getLanguage();
        $model = $this->getModel();

        $this->paypal = JRequest::get('post');

        $paypal_status = $this->paypal['payment_status'];

        if (strcmp($paypal_status, 'Completed') == 0) {
            $new_status = 'C';
        } elseif (strcmp($paypal_status, 'Pending') == 0) {
            $new_status = 'P';
        } else {
            $new_status = 'X';
        }

        $linkReturn     = $this->getReturnPage();
//                var_dump($linkReturn); die;
        $linkRedirect   = JRoute::_($linkReturn);
//                var_dump($linkRedirect); die();
//                JRoute::_('index.php?option=' . $this->option . '&view='.$view
//                    .$addonIdURL.'&addon_view=' . $this->view_item. $this->getRedirectToItemAppend($recordId, $urlVar)
//                    , false
//                )

        if($new_status == 'C') {

            $result = $model->savePaypal($this->paypal);

            if($result == true) {

                $this->setMessage(JText::_('Thank You Donate'));
                $this->setRedirect($linkRedirect);

                return true;

            }else {

                $this->setMessage(JText::_('Donate not success','error'));
                $this->setRedirect($linkRedirect);

                return true;
            }
        }

        if($new_status == 'P') {

            $this->setMessage(JText::_('Donate Pending'));
            $this->setRedirect($linkRedirect);

            return true;

        }

        if($new_status == 'X') {

            $this->setMessage(JText::_('Donate Cancel'));
            $this->setRedirect($linkRedirect);
            return true;

        }

        $this->setRedirect($linkRedirect);

        return false;
    }

}