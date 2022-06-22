<?php

/**
 * Bible Controller is used for Bible Content handling
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
class BibleContentController extends AdminBaseController
{

    /**
     * Initialize Bible Content
     * 
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBibleContent();
    }

    /**
     * Render Bible Content Search Form
     */
    public function index()
    {
        $this->set('srchFrm', $this->getSearchForm());
        $this->set("canEdit", $this->objPrivilege->canEditBibleContent(true));
        $this->_template->render();
    }

    /**
     * Setup
     */
    public function setup()
    {
        $this->objPrivilege->canEditBibleContent();
        $frm = $this->getForm();
        $postedData = FatApp::getPostedData();
        $postedData['image'] = 1;
        if (!$post = $frm->getFormDataFromArray($postedData)) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $bibleContentId = FatUtility::int($post['biblecontent_id']);
        $bibleContent = new BibleContent($bibleContentId);
        $bibleContent->assignValues($post);
        if (!$bibleContent->save()) {
            FatUtility::dieJsonError($bibleContent->getError());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_SETUP_SUCCESSFUL'));
    }

    /**
     * Search
     */
    public function search()
    {
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $post = $searchForm->getFormDataFromArray($data);
        $srch = new SearchBase(BibleContent::DB_TBL);
        $srch->joinTable(BibleContent::DB_TBL_LANG, 'LEFT JOIN', 'biblecontent_id = biblecontentlang_biblecontent_id AND biblecontentlang_lang_id=' . $this->siteLangId);
        if (!empty($post['keyword'])) {
            $srch->addCondition('biblecontent_title', 'like', '%' . $post['keyword'] . '%');
        }
        
        if ($post['biblecontent_active'] != '') {
            $srch->addCondition('biblecontent_active', '=', intval($post['biblecontent_active']));
        }
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addOrder('biblecontent_active', 'DESC');
        $srch->addOrder('biblecontent_order', 'ASC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('postedData', $post);
        $this->set("arr_listing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set("canEdit", $this->objPrivilege->canEditBibleContent(true));
        $this->_template->render(false, false);
    }

    /**
     * Render Bible Content Form
     * 
     * @param type $contentId
     */
    public function form($contentId = 0)
    {
        $contentId = FatUtility::int($contentId);
        $frm = $this->getForm($contentId);
        if ($contentId > 0) {
            $data = BibleContent::getBibleContentById($contentId);
            if (empty($data)) {
                FatUtility::dieJsonError("Invalid Request");
            }
            $videoUrl = $data['biblecontent_url'];
            $videoData = CommonHelper::getVideoDetail($videoUrl);
            if ($videoData['video_thumb']) {
                $frm->getField('biblecontent_url')->attachField($frm->addHtml('', 'video_display', '<img id="displayVideo" alt="" width="100" height="100" src=' . $videoData['video_thumb'] . '>'));
            }
            $frm->fill($data);
        }
        $this->set('frm', $frm);
        $this->set('contentId', $contentId);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    /**
     * Render Bible Content Lang Form
     * 
     * @param int $biblecontent_id
     * @param int $langId
     */
    public function langForm($biblecontent_id, $langId = 0)
    {
        $biblecontent_id = FatUtility::int($biblecontent_id);
        if (1 > $biblecontent_id) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $langId = FatUtility::int($langId);
        if ($langId == 0) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $bibleLangFrm = $this->getLangForm($biblecontent_id, $langId);
        $langData = BibleContent::getAttributesByLangId($langId, $biblecontent_id);
        if ($langData) {
            $bibleLangFrm->fill($langData);
        }
        $this->set('languages', Language::getAllNames());
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('biblecontent_id', $biblecontent_id);
        $this->set('bible_lang_id', $langId);
        $this->set('bibleLangFrm', $bibleLangFrm);
        $this->_template->render(false, false);
    }

    /**
     * Lang Setup
     */
    public function langSetup()
    {
        $this->objPrivilege->canEditBibleContent();
        $post = FatApp::getPostedData();
        $biblecontent_id = $post['biblecontent_id'];
        $langId = $post['lang_id'];
        if ($biblecontent_id == 0 || $langId == 0) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $frm = $this->getLangForm($biblecontent_id, $langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $data = [
            'biblecontentlang_lang_id' => $langId,
            'biblecontentlang_biblecontent_id' => $biblecontent_id,
            'biblecontentlang_biblecontent_title' => $post['biblecontentlang_biblecontent_title']
        ];
        $bible = new BibleContent($biblecontent_id);
        if (!$bible->updateLangData($langId, $data)) {
            FatUtility::dieJsonError($bible->getError());
        }
        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = BibleContent::getAttributesByLangId($langId, $biblecontent_id)) {
                $newTabLangId = $langId;
                break;
            }
        }
        $data = [
            'langId' => $newTabLangId,
            'biblecontent_id' => $biblecontent_id,
            'msg' => Label::getLabel('MSG_Setup_Successful')
        ];
        FatUtility::dieJsonSuccess($data);
    }

    /**
     * Change Status
     */
    public function changeStatus()
    {
        $this->objPrivilege->canEditBibleContent();
        $biblecontent_active = FatApp::getPostedData('biblecontent_active', FatUtility::VAR_INT, -1);
        if (!in_array($biblecontent_active, [0, 1])) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $biblecontent_id = FatApp::getPostedData('biblecontent_id', FatUtility::VAR_INT, 0);
        $bibleContent = new BibleContent($biblecontent_id);
        if (!$bibleContent->loadFromDb()) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        if (!$bibleContent->changeStatus($biblecontent_active)) {
            FatUtility::dieJsonError($bibleContent->getError());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY'));
    }

    /**
     * Delete Record
     */
    public function deleteRecord()
    {
        $this->objPrivilege->canEditBibleContent();
        $biblecontent_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($biblecontent_id < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $db = FatApp::getDb();
        $db->deleteRecords(BibleContent::DB_TBL, ['smt' => 'biblecontent_id = ?', 'vals' => [$biblecontent_id]]);
        if ($db->getError()) {
            FatUtility::dieJsonError($db->getError());
        }
        $db->deleteRecords(BibleContent::DB_TBL_LANG, ['smt' => 'biblecontentlang_biblecontent_id = ?', 'vals' => [$biblecontent_id]]);
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_RECORD_DELETED_SUCCESSFULLY'));
    }

    /**
     * Update Order
     */
    public function updateOrder()
    {
        $this->objPrivilege->canEditBibleContent();
        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $BibleContent = new BibleContent();
            if (!$BibleContent->updateOrder($post['bibleList'])) {
                FatUtility::dieJsonError($BibleContent->getError());
            }
            FatUtility::dieJsonSuccess(Label::getLabel('LBL_ORDER_UPDATED_SUCCESSFULLY'));
        }
    }

    /**
     * Get Lang Form
     * 
     * @param int $biblecontent_id
     * @param int $langId
     * @return form
     */
    private function getLangForm(int $biblecontent_id, int $langId): form
    {
        $frm = new Form('frmBibleLang');
        $frm->addHiddenField('', 'biblecontent_id', $biblecontent_id);
        $frm->addHiddenField('', 'lang_id', $langId);
        $frm->addRequiredField(Label::getLabel('LBL_Bible_Title'), 'biblecontentlang_biblecontent_title');
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_Save_Changes'));
        return $frm;
    }

    /**
     * Get Search Form
     * 
     * @return Form
     */
    private function getSearchForm(): Form
    {
        $frm = new Form('frmPagesSearch');
        $f1 = $frm->addTextBox('Content Heading', 'keyword', '');
        $frm->addSelectBox('Status', 'biblecontent_active', AppConstant::getActiveArr(), '', []);
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', 'Search');
        $fld_cancel = $frm->addButton("", "btn_clear", "Clear", ['onClick' => 'clearSearch()']);
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    /**
     * Get Form
     * 
     * @return Form
     */
    private function getForm(): Form
    {
        $frm = new Form('frmBlock');
        $frm->addHiddenField('', 'biblecontent_id', '');
        $frm->addRequiredField(Label::getLabel('LBL_TITLE'), 'biblecontent_title');
        $videoFld = $frm->addRequiredField(Label::getLabel('LBL_YOUTUBE_URL'), 'biblecontent_url', '', ['onblur' => 'validateYoutubelink(this);']);
        $videoFld->requirements()->setRequired(true);
        $frm->addSelectBox('Status', 'biblecontent_active', AppConstant::getActiveArr(), '', [], '');
        $frm->addSubmitButton('', 'btn_submit', 'Save Changes');
        return $frm;
    }

}
