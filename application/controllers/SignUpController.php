<?php

/**
 * Sign InController
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
 use Google\Service\Oauth2;
class SignUpController extends MyAppController
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
		$policyPageId = FatApp::getConfig('CONF_TERMS_AND_CONDITIONS_PAGE', FatUtility::VAR_INT, 0);
        $termPageId = FatApp::getConfig('CONF_PRIVACY_POLICY_PAGE', FatUtility::VAR_INT, 0);
        $privacyPolicyLink = $termsConditionsLink = '';
        if ($policyPageId > 0) {
            $privacyPolicyLink = MyUtility::makeUrl('Cms', 'view', [$policyPageId]);
        }
        if ($termPageId > 0) {
            $termsConditionsLink = MyUtility::makeUrl('Cms', 'view', [$policyPageId]);
        }
        $this->sets([
            'frm' => $this->getSignupForm(),
            'privacyPolicyLink' => $privacyPolicyLink,
            'termsConditionsLink' => $termsConditionsLink,
        ]);
        $this->_template->render();
    }
	private function getSignupForm(): Form
    {
        $frm = new Form('signupFrm');
        $frm->addHiddenField('', 'user_id', 0, ['id' => 'user_id']);
        $frm->addRequiredField(Label::getLabel('LBL_FIRST_NAME'), 'user_first_name');
        $frm->addTextBox(Label::getLabel('LBL_LAST_NAME'), 'user_last_name');
        $fld = $frm->addEmailField(Label::getLabel('LBL_EMAIL_ID'), 'user_email', '', ['autocomplete="off"']);
        $fld->setUnique('tbl_users', 'user_email', 'user_id', 'user_id', 'user_id');
        $fld = $frm->addPasswordField(Label::getLabel('LBL_PASSWORD'), 'user_password');
        $fld->requirements()->setRequired();
        $fld->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
        $fld->requirements()->setRegularExpressionToValidate(AppConstant::PASSWORD_REGEX);
        $fld->requirements()->setCustomErrorMessage(Label::getLabel(AppConstant::PASSWORD_CUSTOM_ERROR_MSG));
        $fld = $frm->addCheckBox(Label::getLabel('LBL_I_ACCEPT_TO_THE'), 'agree', AppConstant::NO);
        $fld->requirements()->setRequired();
        $fld->requirements()->setCustomErrorMessage(Label::getLabel('MSG_TERMS_AND_CONDITION_ARE_MANDATORY'));
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_Register'));
        return $frm;
    }
  
}
