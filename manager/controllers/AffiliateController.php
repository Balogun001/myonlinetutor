<?php

/**
 * AffiliateController Controller is used for Configurations handling
 *  
 * @package YoCoach
 * @author Auramatics
 */
class AffiliateController extends AdminBaseController
{
    /* these variables must be only those which will store array type data and will saved as serialized array [ */

    private $serializeArrayValues = [];

    /* ] */

    /**
     * Initialize Configurations
     * 
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
        $this->set("includeEditor", true);
        $this->objPrivilege->canViewGeneralSettings();
    }

    public function index()
    {
        $this->set('form', $this->getUserSearchForm());
        $this->_template->addJs(['js/jquery.form.js']);
        $this->_template->render();
    }

    /**
     * Search & List Users
     */
    public function search()
    {
        $frmSearch = $this->getUserSearchForm();
        if (!$post = $frmSearch->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieWithError(current($frmSearch->getValidationErrors()));
        }
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = $post['page'];
        $srch = new SearchBase('affilates_users');
        $srch->addOrder('affilates_users.user_active', 'DESC');
        $srch->addOrder('affilates_users.id', 'DESC');
        $keyword = trim(FatApp::getPostedData('keyword', FatUtility::VAR_STRING, ''));
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('mysql_func_CONCAT(fname," ", lname)', 'like', '%' . $keyword . '%', 'AND', true);
            $cnd->attachCondition('affilates_users.email', 'like', '%' . $keyword . '%');
        }
        if ($post['user_id'] > 0) {
            $srch->addCondition('affilates_users.user_id', '=', FatUtility::int($post['user_id']));
        }
        if ($post['user_active'] != '') {
            $srch->addCondition('affilates_users.user_active', '=', $post['user_active']);
        }
        if ($post['user_verified'] != '') {
            if ($post['user_verified'] == AppConstant::YES) {
                $srch->addDirectCondition('affilates_users.email_verified_at IS NOT NULL');
            } elseif ($post['user_verified'] == AppConstant::NO) {
                $srch->addDirectCondition('affilates_users.email_verified_at IS NULL');
            }
        }

        $srch->addMultipleFields([
            'affilates_users.id as user_id', 'email as user_email', 'email_verified_at as user_verified',
            'user_active', 'created_at as user_created',
            'CONCAT(fname, " ", lname) AS user_full_name'
        ]);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $arrListing = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->sets([
            'arrListing' => $arrListing,
            'page' => $page,
            'postedData' => $post,
            'pageSize' => $pagesize,
            'pageCount' => $srch->pages(),
            'recordCount' => $srch->recordCount(),
            'canEdit' => $this->objPrivilege->canEditUsers(false),
        ]);
        $this->_template->render(false, false);
    }

    /**
     * Get User Search Form
     * 
     * @return Form
     */
    private function getUserSearchForm(): Form
    {
        $frm = new Form('frmUserSearch');
        $frm->addTextBox(Label::getLabel('LBL_NAME_OR_EMAIL'), 'keyword', '', ['id' => 'keyword', 'autocomplete' => 'off']);
        $frm->addSelectBox(Label::getLabel('LBL_USER_TYPE'), 'type', User::getUserTypes());
        $frm->addSelectBox(Label::getLabel('LBL_EMAIL_VERIFIED'), 'user_verified', AppConstant::getYesNoArr());
        $frm->addSelectBox(Label::getLabel('LBL_STATUS'), 'user_active', AppConstant::getActiveArr());
        $frm->addDateField(Label::getLabel('LBL_REG_DATE_FROM'), 'user_regdate_from', '', ['readonly' => 'readonly']);
        $frm->addDateField(Label::getLabel('LBL_REG_DATE_TO'), 'user_regdate_to', '', ['readonly' => 'readonly']);
        $frm->addHiddenField('', 'page', 1);
        $frm->addHiddenField('', 'user_id', '');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_SEARCH'));
        $fld_cancel = $frm->addButton("", "btn_clear", Label::getLabel('LBL_CLEAR'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    /**
     * Change Status
     */
    public function changeStatus()
    {
        $this->objPrivilege->canEditUsers();
        $userId = FatApp::getPostedData('userId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (empty(AffiliateUser::getAttributesById($userId, 'id'))) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }

        $user = new AffiliateUser($userId);
        if (!$user->updateStatus($status)) {
            FatUtility::dieJsonError($user->getError());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY'));
    }

    /**
     * User refferals
     * 
     * @param int $userId
     */
    public function refferals($userId = 0)
    {
        $data = AffiliateUser::getDetail($userId);
        if (empty($data)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $userId = FatUtility::int($userId);
        $postData = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $srch = new SearchBase('affilates_referral_history');
        $srch->joinTable('affilates_user_referral_ids', 'INNER JOIN', 'affilates_user_referral_ids.referral_id = affilates_referral_history.refral_ids');
        $srch->addCondition('affilates_user_referral_ids.user_id', '=', $userId);
        $srch->addOrder('affilates_referral_history.id', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $postData['userId'] = $userId;

        $this->sets([
            'arrListing' => FatApp::getDb()->fetchAll($srch->getResultSet()),
            'pageCount' => $srch->pages(),
            'recordCount' => $srch->recordCount(),
            'page' => $page,
            'pageSize' => $pagesize,
            'userId' => $userId,
            'postedData' => $postData,
            'canEdit' => $this->objPrivilege->canEditUsers(true)
        ]);
        $this->_template->render(false, false);
    }

    /**
     * User refferals
     * 
     * @param int $userId
     */
    public function payouts($userId = 0)
    {
        $data = AffiliateUser::getDetail($userId);
        if (empty($data)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $userId = FatUtility::int($userId);
        $postData = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $srch = new SearchBase('affilates_payouts');

        $srch->joinTable('affilates_user_referral_ids', 'INNER JOIN', 'affilates_user_referral_ids.referral_id = affilates_payouts.rfr_id');
        $srch->addCondition('affilates_user_referral_ids.user_id', '=', $userId);
        $srch->addOrder('affilates_payouts.id', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $postData['userId'] = $userId;
        $srch->addMultipleFields([
            'affilates_payouts.*'
        ]);
        $this->sets([
            'arrListing' => FatApp::getDb()->fetchAll($srch->getResultSet()),
            'pageCount' => $srch->pages(),
            'recordCount' => $srch->recordCount(),
            'page' => $page,
            'pageSize' => $pagesize,
            'userId' => $userId,
            'postedData' => $postData,
            'canEdit' => $this->objPrivilege->canEditUsers(true)
        ]);
        $this->_template->render(false, false);
    }

    public function payoutUpdate()
    {
        $this->objPrivilege->canEditUsers();
        $id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);

        if (empty(AffiliatePayouts::getAttributesById($id, 'id'))) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }

        $payout = new AffiliatePayouts($id);
        if (!$payout->updateStatus($status)) {
            FatUtility::dieJsonError($payout->getError());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY'));
    }

    public function accountDetails($userId = 0)
    {
        $data = AffiliateUser::getDetail($userId);
        if (empty($data)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $userId = FatUtility::int($userId);
        $postData = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $srch = new SearchBase('affilates_users_account_details');
        $srch->addCondition('affilates_users_account_details.user_id', '=', $userId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $postData['userId'] = $userId;
        
        $this->sets([
            'arrListing' => FatApp::getDb()->fetchAll($srch->getResultSet()),
            'pageCount' => $srch->pages(),
            'recordCount' => $srch->recordCount(),
            'page' => $page,
            'pageSize' => $pagesize,
            'userId' => $userId,
            'postedData' => $postData,
            'canEdit' => $this->objPrivilege->canEditUsers(true)
        ]);
        $this->_template->render(false, false);
    }
}
