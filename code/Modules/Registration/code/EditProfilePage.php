<?php

/**
 * Class EditProfilePage
 */
class EditProfilePage extends Page {

    private static $icon = 'boilerplate/code/Modules/Registration/images/user--pencil.png';
    private static $description = 'Edit profile content page';

}

class EditProfilePage_Controller extends Page_Controller {

    private static $allowed_actions = array(
        'EditProfileForm'
    );

    /**
     * @return Form|SS_HTTPResponse
     */
    public function EditProfileForm(){

        if(!Member::currentUser()){
            $this->setFlash('Please <a href="'.Director::absoluteBaseURL().'Security/login?BackURL='.$this->Link().'">log in</a> to edit your profile.', 'warning');
            return $this->redirect(Director::absoluteBaseURL());
        }

        $firstName = new TextField('FirstName');
        $firstName->setAttribute('placeholder', 'Enter your first name')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $surname = new TextField('Surname');
        $surname->setAttribute('placeholder', 'Enter your surname')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $email = new EmailField('Email');
        $email->setAttribute('placeholder', 'Enter your email address')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $jobTitle = new TextField('JobTitle');
        $jobTitle->setAttribute('placeholder', 'Enter your job title')
            ->addExtraClass('form-control');

        $website = new TextField('Website');
        $website->setAttribute('placeholder', 'Enter your website')
            ->addExtraClass('form-control');

        $blurb = new TextareaField('Blurb');
        $blurb->setAttribute('placeholder', 'Enter your blurb')
            ->addExtraClass('form-control');

        $confirmPassword = new ConfirmedPasswordField('Password', 'New Password');
        $confirmPassword->canBeEmpty = true;
        $confirmPassword->setAttribute('placeholder', 'Enter your password')
            ->addExtraClass('form-control');

        $passwordToggle = new LiteralField('', '<p><button class="btn btn-default btn-link" type="button" data-toggle="collapse" data-target="#togglePassword" aria-expanded="false" aria-controls="togglePassword">Change Password</button></p><div class="collapse" id="togglePassword">');
        $passwordToggleClose = new LiteralField('', '</div>');

        $fields = new FieldList(
            $firstName,
            $surname,
            $email,
            $jobTitle,
            $website,
            $blurb,
            $passwordToggle,
            $confirmPassword,
            $passwordToggleClose
        );

        $action = new FormAction('SaveProfile', 'Update Profile');
        $action->addExtraClass('btn btn-primary');
        $actions = new FieldList(
            $action
        );

        // Create action
        $validator = new RequiredFields('FirstName', 'Email');

        //Create form
        $form = new Form($this, 'EditProfileForm', $fields, $actions, $validator);

        //Populate the form with the current members data
        $Member = Member::currentUser();
        $form->loadDataFrom($Member->data());

        //Return the form
        return $form;
    }

    /**
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse
     */
    public function SaveProfile($data, $form){

        if($CurrentMember = Member::currentUser()){
            if($member = DataObject::get_one('Member', "Email = '". Convert::raw2sql($data['Email']) . "' AND ID != " . $CurrentMember->ID)){
                $form->addErrorMessage('Email', 'Sorry, that Email already exists.', 'validation');
                return $this->redirectBack();
            }else{
                // If no password don't save the field
                if(!isset($data['password'])){
                    unset($data['password']);
                }
                $this->setFlash('Your profile has been updated', 'success');
                $form->saveInto($CurrentMember);
                $CurrentMember->write();
                return $this->redirect($this->Link());
            }
        }else{
            return Security::PermissionFailure($this->controller, 'You must <a href="register">registered</a> and logged in to edit your profile:');
        }

    }

    /**
     * @return mixed
     */
    public function Saved(){
        return $this->request->getVar('saved');
    }

    /**
     * @return mixed
     */
    public function Success(){
        return $this->request->getVar('success');
    }

}