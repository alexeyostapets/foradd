<?php
class page_register_index extends Page {
    function init(){
        parent::init();

        // Check if user is already logged in and redirect to home
        if ($this->api->auth->isLoggedIn()) {
        	$this->add('View_Info')->set('You registered already');
        }else{
        	$form=$this->add('Form_Register');
        }
        
        $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
        $this->template->set('state',$_SESSION['state']);
        $this->template->set('site',$_SERVER['HTTP_HOST']);
        $this->template->set('client_id',$this->api->getConfig('auth/facebook/app_id',0));
        
    }
    function defaultTemplate(){
    	return array('page/register/index');
    }
}

class Form_Register extends Form {
	function init(){
		parent::init();

		$model = $this->add('Model_User');
		
		// Form fields from the table user
		$this->setModel($model, array('email'));
		$this->addField('password', 'password_1', 'Password');
		$this->addField('password', 'password_2', 'Confirmation');
		
		// Form submit button
		$this->addSubmit('Register');
		
		$this->onSubmit(array($this,'checkForm'));
	}
	function checkForm(){
		$js=array();
		
		// Check if passwords not empty
		if (trim($this->get('password_1')) <> "" | trim($this->get('password_2') <> "")) {
			// Check if passwords match
			if ($this->get('password_1') != $this->get('password_2')) {
				$this->js()->atk4_form('fieldError','password_2','Passwords does not match')->execute();
			}
		} else { // If password fields are empty
			$this->js()->atk4_form('fieldError','password_1','Please enter a password')->execute();
		}

		// If form valid - save user
		$this->getModel()->set('password', $this->api->auth->encryptPassword($this->get('password_1'),$this->get('email')));

        // Generating hash for email verification
		$confirm_hash = md5(uniqid(rand(), true));
		
		$this->update();

		$this->api->redirect('register/success');
	}
}