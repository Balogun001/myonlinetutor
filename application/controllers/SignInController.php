<?php

/**
 * Sign InController
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
 use Google\Service\Oauth2;
class SignInController extends MyAppController
{

    /**
     * Initialize Group Classes
     * 
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
    }

    /**
     * Render Group Classes|Packages
     */
    public function index() {
		$this->set('frm', UserAuth::getSigninForm());
        $this->_template->render();
    }

  
}
