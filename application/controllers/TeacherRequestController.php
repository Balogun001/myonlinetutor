<?php

/**
 * Teacher Request Controller
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
class TeacherRequestController extends MyAppController
{

    private $userId;
    private $requestCount;

    /**
     * Initialize Teacher Request
     * 
     * @param string $action
     */
    public function __construct(string $action)
    {
        MyUtility::setUserType(User::LEARNER);
        parent::__construct($action);
        $this->userId = 0;
        if ($this->siteUserId > 0) {
            $this->userId = $this->siteUserId;
        } elseif (TeacherRequest::getSession('user_id')) {
            $this->userId = TeacherRequest::getSession('user_id');
        }
        $this->requestCount = 0;
    }

    /**
     * Render Apply to Teach Form
     */
    public function index()
    {
        if (TeacherRequest::getSession('user_id') > 0) {
            FatApp::redirectUser(MyUtility::makeUrl('TeacherRequest', 'form', [], CONF_WEBROOT_FRONTEND));
        }
        $this->set('faqs', $this->getApplyToTeachFaqs());
        $this->set('applyTeachFrm', $this->getApplyTeachFrm($this->siteLangId));
        $this->set('sectionAfterBanner', ExtraPage::getBlockContent(ExtraPage::BLOCK_APPLY_TO_TEACH_BENEFITS_SECTION, $this->siteLangId));
        $this->set('featuresSection', ExtraPage::getBlockContent(ExtraPage::BLOCK_APPLY_TO_TEACH_FEATURES_SECTION, $this->siteLangId));
        $this->set('staticBannerSection', ExtraPage::getBlockContent(ExtraPage::BLOCK_APPLY_TO_TEACH_STATIC_BANNER, $this->siteLangId));
        $this->set('becometutorSection', ExtraPage::getBlockContent(ExtraPage::BLOCK_APPLY_TO_TEACH_BECOME_A_TUTOR_SECTION, $this->siteLangId));
        $this->_template->render();
    }

    public function form()
    {
        $userId = FatUtility::int($this->userId);
        if ($userId < 1) {
            TeacherRequest::closeSession();
            FatApp::redirectUser(MyUtility::makeUrl('TeacherRequest', '', [], CONF_WEBROOT_FRONTEND));
        }
        $this->requestCount = TeacherRequest::getRequestCount($userId);
        if ($this->requestCount == FatApp::getConfig('CONF_MAX_TEACHER_REQUEST_ATTEMPT')) {
            $this->set('step', 5);
        } else {
            $this->set('step', TeacherRequest::getRequestByUserId($userId)['tereq_step'] ?? 1);
        }
        $this->set('exculdeMainHeaderDiv', false);
        $this->_template->addJs('js/jquery.form.js');
        $this->_template->addJs('js/cropper.js');
        $this->_template->render(true, false);
    }

    private function attemptReachedCheck()
    {
        $this->requestCount = TeacherRequest::getRequestCount($this->userId);
        if ($this->requestCount <= FatApp::getConfig('CONF_MAX_TEACHER_REQUEST_ATTEMPT')) {
            return true;
        }
        FatUtility::dieJsonError(Label::getLabel('LBL_YOU_HAVE_REACH_MAX_ATTEMPTS_TO_SUBMIT_REQUEST'));
    }

    /**
     * Render Form Step1
     */
    public function formStep1()
    {
        $userId = FatUtility::int($this->userId);
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $this->attemptReachedCheck();
        $frm = $this->getFormStep1($this->siteLangId);
        $photoId = (new Afile(Afile::TYPE_TEACHER_APPROVAL_PROOF))->getFile($this->userId);
        if (!empty($photoId)) {
            $fld = $frm->getField('user_photo_id');
            $fld->requirements()->setRequired(false);
        }
        $request = TeacherRequest::getRequestByUserId($userId);
        if (empty($request)) {
            $user = User::getDetail($this->userId);
            $request = [
                'tereq_first_name' => $user['user_first_name'],
                'tereq_last_name' => $user['user_last_name'],
                'tereq_phone_code' => $user['user_phone_code'],
                'tereq_phone_number' => $user['user_phone_number'],
                'tereq_user_id' => $user['user_id']
            ];
        }
        if (!empty($request)) {
            $frm->fill($request);
        }
        $this->sets([
            'frm' => $frm, 'request' => $request,
            'user' => User::getAttributesById($userId),
            'photoId' => $photoId,
        ]);
        $this->_template->render(false, false);
    }

    /**
     * Render Form Step2
     */
    public function formStep2()
    {
        $userId = FatUtility::int($this->userId);
		
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $this->attemptReachedCheck();
        $request = TeacherRequest::getRequestByUserId($userId, TeacherRequest::STATUS_PENDING);
		
        if (empty($request)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $frm = $this->getFormStep2($this->siteLangId);
        $frm->fill($request);
        if ($this->requestCount > 1 && $request['tereq_step'] == 2 && (empty($request['tereq_video_link']) || empty($request['tereq_biography']))) {
            $cancelledReq = TeacherRequest::getRequestByUserId($userId, TeacherRequest::STATUS_CANCELLED);
            unset($cancelledReq['tereq_id']);
            $frm->fill($cancelledReq);
        }
        $file = new Afile(Afile::TYPE_TEACHER_APPROVAL_IMAGE);
        $teacherApprovalImage = $file->getFile($this->userId);
        if (!$teacherApprovalImage) {
            $file = new Afile(Afile::TYPE_USER_PROFILE_IMAGE);
            $teacherApprovalImage = $file->getFile($this->userId);
        }
        $this->sets([
            'teacherApprovalImage' => $teacherApprovalImage,
            'frm' => $frm, 'userId' => $userId, 'request' => $request,
            'imageExt' => Afile::getAllowedExts(Afile::TYPE_TEACHER_APPROVAL_IMAGE),
            'fileSize' => Afile::getAllowedUploadSize(Afile::TYPE_TEACHER_APPROVAL_IMAGE),
        ]);
        $this->_template->render(false, false);
    }

    /**
     * Render Form Step3
     */
    public function formStep3()
    {
        $userId = FatUtility::int($this->userId);
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $this->attemptReachedCheck();
        $request = TeacherRequest::getRequestByUserId($userId);
        if (empty($request)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        if ($this->requestCount > 1 && $request['tereq_step'] == 3) {
            $lastRequest = TeacherRequest::getRequestByUserId($userId, TeacherRequest::STATUS_CANCELLED);
            if (!empty($lastRequest)) {
                $request['tereq_teach_langs'] = $lastRequest['tereq_teach_langs'];
                $request['tereq_speak_langs'] = $lastRequest['tereq_speak_langs'];
                $request['tereq_slang_proficiency'] = $lastRequest['tereq_slang_proficiency'];
            }
        }
        $request['tereq_teach_langs'] = empty($request['tereq_teach_langs']) ? '[]' : $request['tereq_teach_langs'];
        $request['tereq_speak_langs'] = empty($request['tereq_speak_langs']) ? '[]' : $request['tereq_speak_langs'];
        $request['tereq_slang_proficiency'] = empty($request['tereq_slang_proficiency']) ? '[]' : $request['tereq_slang_proficiency'];
        $request['tereq_teach_langs'] = json_decode($request['tereq_teach_langs'], true);
        $request['tereq_speak_langs'] = json_decode($request['tereq_speak_langs'], true);
        $request['tereq_slang_proficiency'] = json_decode($request['tereq_slang_proficiency'], true);
        $spokenLangs = SpeakLanguage::getAllLangs($this->siteLangId, true);
        $frm = $this->getFormStep3($this->siteLangId, $spokenLangs);
        $frm->fill($request);
        $this->set('frm', $frm);
        $this->set('request', $request);
        $this->set('spokenLangs', $spokenLangs);
        $this->set('user', User::getAttributesById($userId));
        $this->_template->render(false, false);
    }

    /**
     * Render Form Step4
     */
    public function formStep4()
    {
        $userId = FatUtility::int($this->userId);
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $this->attemptReachedCheck();
        $request = TeacherRequest::getRequestByUserId($userId, TeacherRequest::STATUS_PENDING);
        if (empty($request)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $frm = $this->getFormStep4();
        $frm->fill($request);
        $this->set('frm', $frm);
        $this->set('request', $request);
        $this->set('user', User::getAttributesById($userId));
        $this->_template->render(false, false);
    }

    /**
     * Render Form Step5
     */
    public function formStep5()
    {
        $userId = FatUtility::int($this->userId);
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $request = TeacherRequest::getRequestByUserId($userId);
        if (empty($request)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $this->set('request', $request);
        $this->set('user', User::getAttributesById($userId));
        $this->set('requestCount', TeacherRequest::getRequestCount($userId));
        $this->set('allowedCount', FatApp::getConfig('CONF_MAX_TEACHER_REQUEST_ATTEMPT'));
        $this->_template->render(false, false);
    }

    /**
     * Setup Step1 Form
     */
    public function setupStep1()
    {
		
        $userId = FatUtility::int($this->userId);
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $resubmit = FatApp::getPostedData('resubmit', FatUtility::VAR_INT, 0);
        $frm = $this->getFormStep1($this->siteLangId);
        $photoId = (new Afile(Afile::TYPE_TEACHER_APPROVAL_PROOF))->getFile($this->userId);
        if (!empty($photoId)) {
            $fld = $frm->getField('user_photo_id');
            $fld->requirements()->setRequired(false);
        }
        $data = FatApp::getPostedData();
        if (!empty($_FILES['user_photo_id']['tmp_name'])) {
            $data = array_merge($data, $_FILES);
        }
        if (!$post = $frm->getFormDataFromArray($data)) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        if (!empty($_FILES['user_photo_id']['tmp_name'])) {
            $file = new Afile(Afile::TYPE_TEACHER_APPROVAL_PROOF);
            if (!$file->saveFile($_FILES['user_photo_id'], $userId, true)) {
                FatUtility::dieJsonError($file->getError());
            }
        }
        
        $data = [
            'tereq_step' => 2,
            'tereq_user_id' => $userId,
            'tereq_language_id' => $this->siteLangId,
            'tereq_reference' => $userId . '-' . time(),
            'tereq_date' => date('Y-m-d H:i:s'),
            'tereq_first_name' => $post['tereq_first_name'],
            'tereq_last_name' => $post['tereq_last_name'],
            'tereq_phone_code' => $post['tereq_phone_code'],
            'tereq_phone_number' => $post['tereq_phone_number'],
        ];
        $request = TeacherRequest::getRequestByUserId($userId, TeacherRequest::STATUS_PENDING);
        if (!empty($request)) {
            $data['tereq_id'] = $request['tereq_id'];
        }
        $record = new TableRecord(TeacherRequest::DB_TBL);
        $record->assignValues($data);
        if (!$record->addNew([], $data)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_SOMETHING_WENT_WRONG_PLEASE_TRY_AGAIN'));
        }
        FatUtility::dieJsonSuccess(['step' => 2, 'msg' => Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY')]);
    }

    /**
     * Setup Profile Image
     */
    public function setupProfileImage()
    {
        if ($this->userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        if (empty($_FILES['user_profile_image'])) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $request = TeacherRequest::getRequestByUserId($this->userId, TeacherRequest::STATUS_PENDING);
        if (empty($request)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $this->attemptReachedCheck();
        if (!is_uploaded_file($_FILES['user_profile_image']['tmp_name'])) {
            FatUtility::dieJsonError(Label::getLabel('LBL_PLEASE_SELECT_A_FILE'));
        }
        $file = new Afile(Afile::TYPE_TEACHER_APPROVAL_IMAGE);
        if (!$file->saveFile($_FILES['user_profile_image'], $this->userId, true)) {
            FatUtility::dieJsonError($file->getError());
        }
        $file = MyUtility::makeFullUrl('Image', 'show', [Afile::TYPE_TEACHER_APPROVAL_IMAGE, $this->userId, Afile::SIZE_LARGE]) . '?' . time();
        FatUtility::dieJsonSuccess(['msg' => Label::getLabel('MSG_File_uploaded_successfully'), 'file' => $file]);
    }

    /**
     * Setup Step2 Form
     */
    public function setupStep2()
    {
        $userId = FatUtility::int($this->userId);
		
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $frm = $this->getFormStep2($this->siteLangId);
        if (!$post = $frm->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $request = TeacherRequest::getRequestByUserId($userId, TeacherRequest::STATUS_PENDING);
        if (empty($request)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $userImage = (new Afile(Afile::TYPE_TEACHER_APPROVAL_IMAGE))->getFile($this->userId);
        if (empty($userImage)) {
            $userImage = (new Afile(Afile::TYPE_USER_PROFILE_IMAGE))->getFile($this->userId);
            if (empty($userImage)) {
                FatUtility::dieJsonError(Label::getLabel('LBL_PROFILE_PICTURE_REQURED'));
            }
        }
        $record = new TableRecord(TeacherRequest::DB_TBL);
        $data = [
            'tereq_step' => 3,
            'tereq_id' => $request['tereq_id'],
            'tereq_video_link' => $post['tereq_video_link'],
            'tereq_biography' => $post['tereq_biography'],
        ];
        $record->assignValues($data);
        if (!$record->addNew([], $data)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_SOMETHING_WENT_WRONG_PLEASE_TRY_AGAIN'));
        }
        FatUtility::dieJsonSuccess(['step' => 3, 'msg' => Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY')]);
    }

    /**
     * Setup Step3 Form
     */
    public function setupStep3()
    {
        $userId = FatUtility::int($this->userId);
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $spokenLangs = SpeakLanguage::getAllLangs($this->siteLangId, true);
        $frm = $this->getFormStep3($this->siteLangId, $spokenLangs);
        if (!$post = $frm->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $request = TeacherRequest::getRequestByUserId($userId, TeacherRequest::STATUS_PENDING);
        if (empty($request)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $teachLangs = json_encode(array_filter(FatUtility::int($post['tereq_teach_langs'])));
        $speakLangs = [];
        $speakLangArr = array_filter(FatUtility::int(array_values($post['tereq_speak_langs'])));
        foreach ($speakLangArr as $key => $value) {
            array_push($speakLangs, $value);
        }
        $speakLangsProf = [];
        $speakLangsProfArr = array_filter(FatUtility::int(array_values($post['tereq_slang_proficiency'])));
        foreach ($speakLangsProfArr as $key => $value) {
            array_push($speakLangsProf, $value);
        }
        if (empty($speakLangs) || empty($speakLangsProf)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_SPEAK_LANGUAGE_AND_PROFICIENCY_REQUIRED'));
        }
        $record = new TableRecord(TeacherRequest::DB_TBL);
        $data = [
            'tereq_step' => 4,
            'tereq_id' => $request['tereq_id'],
            'tereq_teach_langs' => $teachLangs,
            'tereq_speak_langs' => json_encode($speakLangs),
            'tereq_slang_proficiency' => json_encode($speakLangsProf),
        ];
        $record->assignValues($data);
        if (!$record->addNew([], $data)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_SOMETHING_WENT_WRONG_PLEASE_TRY_AGAIN'));
        }
        FatUtility::dieJsonSuccess(['step' => 4, 'msg' => Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY')]);
    }

    /**
     * Setup Step4 Form
     */
    public function setupStep4()
    {
        $userId = FatUtility::int($this->userId);
        if ($userId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $frm = $this->getFormStep4();
        if (!$post = $frm->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $request = TeacherRequest::getRequestByUserId($userId);
        if (empty($request)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $qualification = new UserQualification(0, $this->userId);
        $rows = $qualification->getUQualification(false, true);
        if (empty($rows)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_TEACHER_QUALIFICATION_REQUIRED'));
        }
        $record = new TableRecord(TeacherRequest::DB_TBL);
        $record->assignValues(['tereq_step' => 5, 'tereq_terms' => $post['tereq_terms']]);
        if (!$record->update(['smt' => 'tereq_id = ?', 'vals' => [$request['tereq_id']]])) {
            FatUtility::dieJsonError(Label::getLabel('LBL_SOMETHING_WENT_WRONG_PLEASE_TRY_AGAIN'));
        }
        $mail = new FatMailer($this->siteLangId, 'teacher_request_received');
        $vars = [
            '{refnum}' => $request['tereq_reference'],
            '{name}' => $request['tereq_first_name'] . ' ' . $request['tereq_last_name'],
            '{phone}' => $request['tereq_phone_code'] . ' ' . $request['tereq_phone_number'],
            '{request_date}' => $request['tereq_date']
        ];
        $mail->setVariables($vars);
        $mail->sendMail([FatApp::getConfig('CONF_SITE_OWNER_EMAIL')]);
        FatUtility::dieJsonSuccess(['step' => 5, 'msg' => Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY')]);
    }

    /**
     * Get Step1 Form
     * 
     * @return Form
     */
    private function getFormStep1(): Form
    {
        $frm = new Form('frmFormStep1', ['id' => 'frmFormStep1']);
        $frm->addRequiredField(Label::getLabel('LBL_First_Name'), 'tereq_first_name')->requirements()->setRequired();
        $frm->addTextBox(Label::getLabel('LBL_Last_Name'), 'tereq_last_name');
        $countries = Country::getAll($this->siteLangId);
        $fld = $frm->addSelectBox(Label::getLabel('LBL_PHONE_CODE'), 'tereq_phone_code', array_column($countries, 'phone_code', 'country_id'), '', [], Label::getLabel('LBL_SELECT'));
        $fld->requirements()->setRequired(true);
        $fld = $frm->addTextBox(Label::getLabel('LBL_PHONE_NUMBER'), 'tereq_phone_number');
        $fld->requirements()->setRequired(true);
        $fld->requirements()->setRegularExpressionToValidate(AppConstant::PHONE_NO_REGEX);
        $fld->requirements()->setCustomErrorMessage(Label::getLabel('LBL_PHONE_NO_VALIDATION_MSG'));
        $frm->addHiddenField('', 'resubmit', 0);
        $frm->addFileUpload(Label::getLabel('LBL_Photo_Id'), 'user_photo_id')->requirements()->setRequired(true);
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_Save_Changes'));
        return $frm;
    }

    /**
     * Get Step2 Form
     * 
     * @return Form
     */
    private function getFormStep2(): Form
    {
        $frm = new Form('frmFormStep2', ['id' => 'frmFormStep2']);
        $frm->addFileUpload(Label::getLabel('LBL_Profile_Picture'), 'user_profile_image', ['onchange' => 'popupImage(this)', 'accept' => 'image/*']);
        $frm->addTextArea(Label::getLabel('LBL_Biography'), 'tereq_biography')->requirements()->setLength(101, 500);
        $fld = $frm->addTextBox(Label::getLabel('LBL_Introduction_video'), 'tereq_video_link');
        $fld->requirements()->setRegularExpressionToValidate(AppConstant::INTRODUCTION_VIDEO_LINK_REGEX);
        $fld->requirements()->setCustomErrorMessage(Label::getLabel('MSG_Please_Enter_Valid_Video_Link'));
        $frm->addHiddenField('', 'update_profile_img', Label::getLabel('LBL_Update_Profile_Picture'), ['id' => 'update_profile_img']);
        $frm->addHiddenField('', 'rotate_left', Label::getLabel('LBL_Rotate_Left'), ['id' => 'rotate_left']);
        $frm->addHiddenField('', 'rotate_right', Label::getLabel('LBL_Rotate_Right'), ['id' => 'rotate_right']);
        $frm->addHiddenField('', 'img_data', '', ['id' => 'img_data']);
        $frm->addHiddenField('', 'action', 'avatar', ['id' => 'avatar-action']);
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_Save_Changes'));
        return $frm;
    }

    /**
     * Get Step3 Form
     * 
     * @param int $langId
     * @param type $spokenLangs
     * @return Form
     */
    private function getFormStep3($langId, $spokenLangs): Form
    {
        $frm = new Form('frmFormStep3', ['id' => 'frmFormStep3']);
        $profArr = SpeakLanguage::getProficiencies();
        $teachLanguages = TeachLanguage::getAllLangs($langId, true);
        $fld = $frm->addCheckBoxes(Label::getLabel('LBL_LANGUAGE_TO_TEACH'), 'tereq_teach_langs', $teachLanguages);
        $fld->requirements()->setSelectionRange(1, count($teachLanguages));
        $fld->requirements()->setRequired();
        $langArr = $spokenLangs ?: SpeakLanguage::getAllLangs($langId, true);
        $proficiencyLabel = stripslashes(Label::getLabel("LBL_I_DO_NOT_SPEAK_THIS_LANGUAGE"));
        foreach ($langArr as $key => $lang) {
            $speekLangField = $frm->addCheckBox(Label::getLabel('LBL_LANGUAGE_I_SPEAK'), 'tereq_speak_langs[' . $key . ']', $key, ['class' => 'uslang_slang_id'], false, '0');
            $proficiencyField = $frm->addSelectBox(Label::getLabel('LBL_LANGUAGE_PROFICIENCY'), 'tereq_slang_proficiency[' . $key . ']', $profArr, '', ['class' => 'uslang_proficiency select__dropdown'], $proficiencyLabel);
            $proficiencyField->requirements()->setRequired();
            $speekLangField->requirements()->addOnChangerequirementUpdate(0, 'gt', $proficiencyField->getName(), $proficiencyField->requirements());
            $proficiencyField->requirements()->setRequired(false);
            $speekLangField->requirements()->addOnChangerequirementUpdate(0, 'le', $proficiencyField->getName(), $proficiencyField->requirements());
            $speekLangField->requirements()->setRequired();
            $proficiencyField->requirements()->addOnChangerequirementUpdate(0, 'gt', $proficiencyField->getName(), $speekLangField->requirements());
            $speekLangField->requirements()->setRequired(false);
            $proficiencyField->requirements()->addOnChangerequirementUpdate(0, 'le', $proficiencyField->getName(), $speekLangField->requirements());
        }
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_SAVE_CHANGES'));
        return $frm;
    }

    /**
     * Get Step4 Form
     * 
     * @return Form
     */
    private function getFormStep4(): Form
    {
        $frm = new Form('frmFormStep4', ['id' => 'frmFormStep4']);
        $frm->addCheckBox(Label::getLabel('LBL_ACCEPT_TEACHER_APPROVAL_TERMS_&_CONDITION'), 'tereq_terms', 1, [], false, 0)->requirements()->setRequired();
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_Save_Changes'));
        return $frm;
    }

    /**
     * Search Teacher Qualification
     */
    public function searchTeacherQualification()
    {
        $qualification = new UserQualification(0, $this->userId);
        $this->set("rows", $qualification->getUQualification(false, true));
        $this->set("userId", $this->userId);
        $this->_template->render(false, false);
    }

    /**
     * Render Teacher Qualification Form
     */
    public function teacherQualificationForm()
    {
        $qualificationId = FatApp::getPostedData('uqualification_id', FatUtility::VAR_INT, 0);
        $frm = UserQualification::getForm();
        if ($qualificationId > 0) {
            $qualification = new UserQualification($qualificationId, $this->userId);
            if (!$row = $qualification->getQualiForUpdate()) {
                FatUtility::dieJsonError($qualification->getError());
            }
            $frm->fill($row);
            $field = $frm->getField('certificate');
            $field->requirements()->setRequired(false);
        }
        $this->set('frm', $frm);
        $this->set('qualificationId', $qualificationId);
        $this->_template->render(false, false);
    }

    /**
     * Setup Teacher Qualification
     */
    public function setupTeacherQualification()
    {
        $frm = UserQualification::getForm();
        if (!$post = $frm->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $post['uqualification_user_id'] = $this->userId;
        $qualification = new UserQualification($post['uqualification_id']);
        $db = FatApp::getDb();
        $db->startTransaction();
        $qualification->assignValues($post);
        if (!$qualification->save()) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError($qualification->getError());
        }
        if (!empty($_FILES['certificate']['tmp_name'])) {
            if (!is_uploaded_file($_FILES['certificate']['tmp_name'])) {
                $db->rollbackTransaction();
                FatUtility::dieJsonError(Label::getLabel('LBL_PLEASE_SELECT_A_FILE'));
            }
            $uqualification_id = $qualification->getMainTableRecordId();
            $file = new Afile(Afile::TYPE_USER_QUALIFICATION_FILE);
            if (!$file->saveFile($_FILES['certificate'], $uqualification_id, true)) {
                $db->rollbackTransaction();
                FatUtility::dieJsonError($file->getError());
            }
        }
        if (!$db->commitTransaction()) {
            FatUtility::dieJsonError(Label::getLabel('MSG_SOMETHING_WENT_WRONG'));
        } else {
            FatUtility::dieJsonSuccess(Label::getLabel('MSG_SETUP_SUCCESSFUL'));
        }
    }

    /**
     * Delete Teacher Qualification
     */
    public function deleteTeacherQualification()
    {
        $qualificationId = FatApp::getPostedData('uqualification_id', FatUtility::VAR_INT, 0);
        if ($qualificationId < 1) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $qualification = new UserQualification($qualificationId, $this->userId);
        if (!$row = $qualification->getQualiForUpdate()) {
            FatUtility::dieJsonError($qualification->getError());
        }
        $userQualification = new UserQualification($qualificationId);
        if (true !== $userQualification->deleteRecord()) {
            FatUtility::dieJsonError($userQualification->getError());
        }
        $file = new Afile(Afile::TYPE_USER_QUALIFICATION_FILE);
        $file->removeFile($qualificationId, true);
        FatUtility::dieJsonSuccess(Label::getLabel('MSG_QUALIFICATION_REMOVED_SUCCESSFULY'));
    }

    /**
     * Logout Guest User
     */
    public function logoutGuestUser()
    {
        TeacherRequest::closeSession();
        FatApp::redirectUser(MyUtility::makeUrl());
    }

    /**
     * Get Apply Teach Form
     * 
     * @return Form
     */
    private function getApplyTeachFrm(): Form
    {
        $frm = new Form('frmApplyTeachFrm');
        $frm->addHiddenField('', 'user_id', 0);
        $fld = $frm->addEmailField(Label::getLabel('LBL_Email_ID'), 'user_email', '', ['autocomplete' => 'off']);
        $fld->setUnique('tbl_users', 'user_email', 'user_id', 'user_id', 'user_id');
        $fld = $frm->addPasswordField(Label::getLabel('LBL_Password'), 'user_password');
        $fld->requirements()->setRequired();
        $fld->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
        $fld->requirements()->setRegularExpressionToValidate(AppConstant::PASSWORD_REGEX);
        $fld->requirements()->setCustomErrorMessage(Label::getLabel(AppConstant::PASSWORD_CUSTOM_ERROR_MSG));
        $frm->addHiddenField('', 'user_dashboard', User::TEACHER);
        $frm->addHiddenField('', 'agree', 1)->requirements()->setRequired();
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_REGISTER_WITH_EMAIL'));
        return $frm;
    }

    private function getApplyToTeachFaqs()
    {
        $srch = Faq::getSearchObject($this->siteLangId, false);
        $srch->addMultipleFields(['faq_identifier', 'faq_id', 'faq_category', 'faq_active', 'faq_title', 'faq_description']);
        $srch->addCondition('faq_category', '=', Faq::CATEGORY_APPLY_TO_TEACH);
        $srch->addOrder('faq_active', 'desc');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        return $records;
    }

    /**
     * Teacher Setup
     */
    public function teacherSetup()
    {
		
        $frm = $this->getTeacherSignupForm();
        $post = FatApp::getPostedData();
        if (!$post = $frm->getFormDataFromArray($post)) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
		if(isset($post['user_first_name'])){
			$firstname=$post['user_first_name'];
		}else{
			$firstname='';
		}
		if(isset($post['user_last_name'])){
			$lastname=$post['user_last_name'];
		}else{
			$lastname='';
		}
		
		$data = [
		  'email'     => $post['user_email'],
		  'status'    => 'subscribed',
		  'firstname' => $firstname,
		  'lastname'  => $lastname
		];
		$this->syncMailchimp($data);
        if (!MyUtility::validatePassword($post['user_password'])) {
            FatUtility::dieJsonError(Label::getLabel('MSG_PASSWORD_MUST_BE_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC'));
        }
	
        $db = FatApp::getDb();
        $db->startTransaction();
        $userData = array_merge($post, [
            'user_dashboard' => User::TEACHER,
            'user_registered_as' => User::TEACHER,
            'user_lang_id' => MyUtility::getSiteLangId(),
            'user_timezone' => MyUtility::getSiteTimezone(),
        ]);
		
        $user = new User();
        $user->assignValues($userData);
        if (FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION') == AppConstant::NO) {
            $user->setFldValue('user_verified', date('Y-m-d H:i:s'));
        }
        if (empty(FatApp::getConfig('CONF_ADMIN_APPROVAL_REGISTRATION'))) {
            $user->setFldValue('user_active', AppConstant::YES);
        }
        if (!$user->save()) {
			
            $db->rollbackTransaction();
            FatUtility::dieJsonError(Label::getLabel("MSG_USER_COULD_NOT_BE_SET"));
        }
		
        if (!$user->setSettings($userData)) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError(Label::getLabel("MSG_USER_COULD_NOT_BE_SET"));
        }
        if (!$user->setPassword($post['user_password'])) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError(Label::getLabel("MSG_USER_COULD_NOT_BE_SET"));
        }
        if (!$db->commitTransaction()) {
            FatUtility::dieJsonError(Label::getLabel("MSG_USER_COULD_NOT_BE_SET"));
        }
        $userData['user_id'] = $user->getMainTableRecordId();
        $auth = new UserAuth();
        $res = $auth->sendSignupEmails($userData);
        if (
            FatApp::getConfig('CONF_ADMIN_APPROVAL_REGISTRATION') == AppConstant::NO &&
            FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION') == AppConstant::NO &&
            FatApp::getConfig('CONF_AUTO_LOGIN_REGISTRATION') == AppConstant::YES
        ) {
            if (!$auth->login($userData['user_email'], $userData['user_password'], MyUtility::getUserIp())) {
                FatUtility::dieJsonError($auth->getError());
            }
        } else {
            TeacherRequest::startSession($userData);
        }
        FatUtility::dieJsonSuccess([
            'msg' => $res['msg'] ?? Label::getLabel('LBL_REGISTERATION_SUCCESSFULL'),
            'redirectUrl' => MyUtility::makeUrl('TeacherRequest', 'form')
        ]);
    }
	/** Mail chimp **/
	private function syncMailchimp($data) {
		  $apiKey = '668eabf48ba2d5cd74e8679973e2d195-us8';
		  $listId = '67c21aeaf2';

		  $memberId = md5(strtolower($data['email']));
		  $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
		  $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
		  $json = json_encode([
			  'email_address' => $data['email'],
			  'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
			  'merge_fields'  => [
				  'FNAME'     => $data['firstname'],
				  'LNAME'     => $data['lastname']
			  ]
		  ]);

		  $ch = curl_init($url);

		  curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
		  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		  $result = curl_exec($ch);
		  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		  curl_close($ch);
		  
		  //return $httpCode;
	}
	
    /**
     * Get Teacher Signup Form
     * 
     * @return Form
     */
    private function getTeacherSignupForm(): Form
    {
        $frm = new Form('signupForm');
        $frm->addTextBox(Label::getLabel('LBL_FIRST_NAME'), 'user_first_name');
        $frm->addTextBox(Label::getLabel('LBL_LAST_NAME'), 'user_last_name');
        $fld = $frm->addEmailField(Label::getLabel('LBL_EMAIL_ID'), 'user_email', '', ['autocomplete="off"']);
        $fld->setUnique('tbl_users', 'user_email', 'user_id', 'user_id', 'user_id');
        $fld = $frm->addPasswordField(Label::getLabel('LBL_PASSWORD'), 'user_password');
        $fld->requirements()->setRequired();
        $fld->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
        $fld->requirements()->setRegularExpressionToValidate(AppConstant::PASSWORD_REGEX);
        $fld->requirements()->setCustomErrorMessage(Label::getLabel('MSG_Please_Enter_8_Digit_AlphaNumeric_Password'));
        $termsConditionLabel = Label::getLabel('LBL_I_accept_to_the');
        $fld = $frm->addCheckBox($termsConditionLabel, 'agree', 1);
        $fld->requirements()->setRequired();
        $fld->requirements()->setCustomErrorMessage(Label::getLabel('MSG_Terms_and_Condition_and_Privacy_Policy_are_mandatory.'));
        $frm->addHiddenField('', 'user_dashboard', User::LEARNER);
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_Register'));
        return $frm;
    }
}
