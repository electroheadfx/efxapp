<?php

namespace Project;

class Controller_Frontend_Sendmail extends \Controller_Base_Frontend {


    public function before() {

        parent::before();
        $this->dataGlobal['themes'] = FALSE;
        $this->dataGlobal['docsheader'] = '';

    }

    /**
     * 
     * Show CMS page (managed via menu)
     * 
     */
    
    public function action_index() {

        $this->dataGlobal['body'] = 'sendmail frontend';
        $this->dataGlobal['menu_cats'] = array();
        $this->data = "";

        if (\Input::post('add')) {

            $error = false;
            $name = \Input::post('name');
            $email = \Input::post('email');
            $message = \Input::post('message');

            if ( $name == NULL ) {
                \Message::danger(__('application.sendmail.name_is_required'));
                $error = true;
            }

            if ( $email == NULL ) {
                \Message::danger(__('application.sendmail.email_is_required')); 
                $error = true;
            }

            if ( $message == NULL ) {
                \Message::danger(__('application.sendmail.message_is_required')); 
                $error = true;
            }

            if ($error) {
                \Response::redirect(\Router::get('sendmail_index'));
            }

            // Create an instance
            $fuel_email = \Email::forge();
            // Set the from address
            $fuel_email->from($email, $name);
            // Set the to address
            $fuel_email->to( \Config::get('server.contact'), \Config::get('application.seo.frontend.title'));


            // Set a subject
            $fuel_email->subject(__('application.sendmail.email_form_site').\Config::get('application.seo.frontend.site'));
            // And set the body.
            $fuel_email->body($message);

            try {
                $fuel_email->send();
                \Message::success(__('application.sendmail.email_sent'));
                \Response::redirect(\Router::get('homepage'));
            } catch(\EmailValidationFailedException $e) {
                // The validation failed
                \Log::error('Email form : The validation failed.');
            } catch(\EmailSendingFailedException $e) {
                // The driver could not send the email
                \Log::error('Email form : The driver could not send the email.');
            }

        }

        $this->theme->set_partial('content', 'project/frontend/sendmail/index')->set($this->data, null, false);

    }


}
