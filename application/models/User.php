<?php

/**
 * This class is used to handle User
 * 
 * @package YoCoach
 * @author Fatbit Team
 */
class User extends MyAppModel
{

    const ADMIN_SESSION_ELEMENT = 'yoCoachAdmin';
    const DB_TBL = 'tbl_users';
    const DB_TBL_PREFIX = 'user_';
    const DB_TBL_STAT = 'tbl_teacher_stats';
    const DB_TBL_STAT_PREFIX = 'tstat_';
    const DB_TBL_SETTING = 'tbl_user_settings';
    const DB_TBL_USR_BANK_INFO = 'tbl_user_bank_details';
    const DB_TBL_USR_STRIPE_CONNECT_INFO = 'tbl_user_stripe_connect_details';
    const DB_TBL_USR_BANK_INFO_PREFIX = 'ub_';
    const DB_TBL_USR_WITHDRAWAL_REQ = 'tbl_user_withdrawal_requests';
    const DB_TBL_USR_WITHDRAWAL_REQ_PREFIX = 'withdrawal_';
    const DB_TBL_LANG = 'tbl_users_lang';
    const DB_TBL_LANG_PREFIX = 'userlang_';
    const DB_TBL_USER_TO_SPOKEN_LANGUAGES = 'tbl_user_speak_languages';
    const DB_TBL_TEACHER_FAVORITE = 'tbl_user_favourite_teachers';
    const LESSION_EMAIL_BEFORE_12_HOUR = 12;
    const LESSION_EMAIL_BEFORE_24_HOUR = 24;
    const LESSION_EMAIL_BEFORE_48_HOUR = 48;
    const USER_NOTICATION_NUMBER_12 = 12;
    const USER_NOTICATION_NUMBER_24 = 24;
    const USER_NOTICATION_NUMBER_48 = 48;
    const WITHDRAWAL_METHOD_TYPE_BANK = 1;
    const WITHDRAWAL_METHOD_TYPE_PAYPAL = 2;

    /* User Types */
    const LEARNER = 1;
    const TEACHER = 2;
    const SUPPORT = 3;
    const SYSTEMS = 4;

    /**
     * Initialize User
     * 
     * @param int $userId
     */
    public function __construct(int $userId = 0)
    {
        parent::__construct(static::DB_TBL, 'user_id', $userId);
        $this->objMainTableRecord->setSensitiveFields([
            'user_password', 'user_active', 'user_verified'
        ]);
    }

    /**
     * Get User Details
     * 
     * @param int $userId
     * @return null|array
     */
    public static function getDetail(int $userId)
    {
        $srch = new SearchBase(static::DB_TBL, 'user');
        $srch->joinTable(static::DB_TBL_SETTING, 'INNER JOIN', 'uset.user_id = user.user_id', 'uset');
        $srch->addDirectCondition('user.user_deleted IS NULL');
        $srch->addCondition('user.user_id', '=', $userId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }
    public static function getStripeDetail(int $userId){
        $srch = new SearchBase('tbl_user_stripe_connect_details');
        $srch->addCondition('tbl_user_stripe_connect_details.user_id', '=', $userId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    /**
     * Get User Types
     * 
     * @param int $key
     * @return string|array
     */
    public static function getUserTypes(int $key = null)
    {
        $arr = [
            User::LEARNER => Label::getLabel('LBL_Learner'),
            User::TEACHER => Label::getLabel('LBL_Teacher'),
        ];
        return AppConstant::returArrValue($arr, $key);
    }

    /**
     * Get Teacher Profile Progress
     * 
     * @return array
     */
    public static function getProfileProgress(int $userId): array
    {
        $srch = new SearchBase(User::DB_TBL, 'user');
        $srch->joinTable(TeacherStat::DB_TBL, 'LEFT JOIN', 'testat.testat_user_id = user.user_id', 'testat');
        $srch->addMultiplefields([
            'if(IFNULL(testat.testat_minprice,0) > 0 && IFNULL(testat.testat_maxprice,0) > 0,1,0) as priceCount',
            'if(IFNULL(testat.testat_teachlang,0) = 1 && IFNULL(testat.testat_speaklang,0) = 1,1,0) as languagesCount',
            'if(user.user_country_id > 0 && user.user_timezone != "" && user.user_username != "",1,0) as generalProfile',
            'IFNULL(testat.testat_preference,0) as preferenceCount',
            'IFNULL(testat.testat_qualification,0) as uqualificationCount',
            'IFNULL(testat.testat_availability,0) as generalAvailabilityCount',
        ]);
        $srch->addCondition('user.user_is_teacher', '=', AppConstant::YES);
        $srch->addCondition('user.user_id', '=', $userId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $teacherRow = FatApp::getDb()->fetch($srch->getResultSet());
        if (empty($teacherRow)) {
            return [];
        }
        $teacherRowCount = count($teacherRow);
        $teacherFieldSum = array_sum($teacherRow);
        $teacherRow += [
            'totalFields' => $teacherRowCount,
            'totalFilledFields' => $teacherFieldSum,
            'percentage' => round((($teacherFieldSum * 100) / $teacherRowCount), 2),
            'isProfileCompleted' => ($teacherRowCount == $teacherFieldSum),
        ];
        return $teacherRow;
    }

    /**
     * Save User
     * 
     * @return type
     */
    public function save()
    {
        if ($this->getMainTableRecordId() == 0) {
            $this->setFldValue('user_created', date('Y-m-d H:i:s'));
        }

        // Code Goes to MyAppModel Save Method (RGCUSTOM)
        //return true;
        $db = FatApp::getDb();

        return parent::save();
    }

    /**
     * Set Password
     * 
     * @param string $password
     * @return bool
     */
    public function setPassword(string $password): bool
    {
        $this->setFldValue('user_password', UserAuth::encryptPassword($password));
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    /**
     * Assign Gift Card to user
     *
     * @param string $email
     * @return bool
     */
    public function assignGiftCard(string $email): bool
    {
        if (!FatApp::getDb()->updateFromArray(Giftcard::DB_TBL, ['ordgift_receiver_id' => $this->getMainTableRecordId()], ['smt' => 'ordgift_receiver_email = ?', 'vals' => [$email]])) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    /**
     * Set Settings
     * 
     * @param array $data
     * @return bool
     */
    public function setSettings(array $data): bool
    {
        $userId = $this->getMainTableRecordId();
        if (empty($userId)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST');
            return false;
        }
        $userSetting = new UserSetting($userId);
        if (!$userSetting->saveData($data)) {
            $this->error = $userSetting->getError();
            return false;
        }
        return true;
    }

    /**
     * Change Email
     * 
     * @param string $email
     * @return bool
     */
    public function changeEmail(string $email): bool
    {
        $userId = $this->getMainTableRecordId();
        if (empty($userId)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST');
            return false;
        }
        $this->setFldValue('user_email', $email);
        return $this->save();
    }

    /**
     * Verify Account
     * 
     * @return bool
     */
    public function verifyAccount(): bool
    {
        $userId = $this->getMainTableRecordId();
        if (empty($userId)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST');
            return false;
        }
        $this->setFldValue('user_verified', date('Y-m-d H:i:s'));
        return $this->save();
    }

    /**
     * Update Status
     * 
     * @param int $status
     * @return bool
     */
    public function updateStatus(int $status = 1): bool
    {
        if (empty($this->mainTableRecordId)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST');
            return false;
        }
        $this->setFlds(['user_active' => $status]);
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    /**
     * Get User Bank Info
     * 
     * @return boolean
     */
    public function getUserBankInfo()
    {
        if (($this->getMainTableRecordId() < 1)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST_USER_NOT_INITIALIZED');
            return false;
        }
        $srch = new SearchBase(static::DB_TBL_USR_BANK_INFO, 'tub');
        $srch->addMultipleFields([
            'ub_bank_name', 'ub_account_holder_name',
            'ub_account_number', 'ub_ifsc_swift_code', 'ub_bank_address', 'ub_paypal_email_address'
        ]);
        $srch->addCondition('ub_user_id', '=', $this->getMainTableRecordId());
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetch($rs);
    }

    /**
     * Get User Paypal Info
     * 
     * @return boolean
     */
    public function getUserPaypalInfo()
    {
        if (($this->getMainTableRecordId() < 1)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST_USER_NOT_INITIALIZED');
            return false;
        }
        $srch = new SearchBase(static::DB_TBL_USR_BANK_INFO, 'tub');
        $srch->addMultipleFields(['ub_paypal_email_address']);
        $srch->addCondition('ub_user_id', '=', $this->getMainTableRecordId());
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetch($rs);
    }

    /**
     * Update Bank Info
     * 
     * @param array $data
     * @return boolean
     */
    public function updateBankInfo(array $data = [])
    {
        if (($this->getMainTableRecordId() < 1)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST_USER_NOT_INITIALIZED');
            return false;
        }
        $assignValues = [
            'ub_user_id' => $this->getMainTableRecordId(),
            'ub_bank_name' => $data['ub_bank_name'],
            'ub_account_holder_name' => $data['ub_account_holder_name'],
            'ub_account_number' => $data['ub_account_number'],
            'ub_ifsc_swift_code' => $data['ub_ifsc_swift_code'],
            'ub_bank_address' => $data['ub_bank_address'],
        ];
        if (!FatApp::getDb()->insertFromArray(static::DB_TBL_USR_BANK_INFO, $assignValues, false, [], $assignValues)) {
            $this->error = $this->db->getError();
            return false;
        }
        return true;
    }
    public function updateStripeConnectInfo(array $data = [])
    {
       
        if (($this->getMainTableRecordId() < 1)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST_USER_NOT_INITIALIZED');
            return false;
        }
       
        
        $stripe =  new \Stripe\StripeClient('sk_test_51KlBYRBHOKvtnZNpHREAc3JTMGf8tMDaRutHzeMXKV8lFoocoQgropFRKVZIQZmMT9qHWdCEmWW0RIytwFOBa0XE00Xx5dsY8H');
         \Stripe\Stripe::setApiKey('sk_test_51KlBYRBHOKvtnZNpHREAc3JTMGf8tMDaRutHzeMXKV8lFoocoQgropFRKVZIQZmMT9qHWdCEmWW0RIytwFOBa0XE00Xx5dsY8H');

         try {
            $account = \Stripe\Account::create([
                'country' =>  trim($data['user_country_code']),
                'type' => 'custom',
                'email' => trim($data['user_email']),
                'tos_acceptance' => [
                    'date' => time(),
                    'ip' => $_SERVER['REMOTE_ADDR'], // Assumes you're not using a proxy
                ],
                'external_account' => [
                    'object' => 'bank_account',
                    'country' =>  trim($data['user_country_code']),
                    'currency' => trim($data['user_currency']),
                    'account_holder_name' => trim($data['user_first_name']) . ' ' . trim($data['user_last_name']),
                    'account_holder_type' => 'individual',
                    'routing_number' => isset($data['routing_number']) ? trim($data['routing_number']) : NULL,//110000000
                    'account_number' => trim($data['account_number']),
                ],
                'business_type' => 'individual',
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                ['business_profile' => [
                    'mcc' => '5734',
                    'url' => 'https://myonlinetutor.co/'
                ]]
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $msg['msg'] = $e->getMessage();
            $msg['status'] = 0;
            return $msg;
        }
            $accountLinks =  $stripe->accountLinks->create(
                [
                    'account' => $account->id,
                    'refresh_url' => "https://myonlinetutor.co/dashboard/account/profile-info?msg=success",
                    'return_url' => "https://myonlinetutor.co/dashboard/account/profile-info",
                    'type' => 'account_onboarding',
                    'collect' => 'eventually_due',
                ]
            );
            $assignValues = [
                'user_id' => $this->getMainTableRecordId(),
                'user_country_code' => $data['user_country_code'],
                'user_currency' => $data['user_currency'],
                'user_first_name' => $data['user_first_name'],
                'user_last_name' => $data['user_last_name'],
                'user_email' => $data['user_email'],
                'account_number' => $data['account_number'],
                'routing_number' => isset($data['routing_number']) ? trim($data['routing_number']) : NULL,
                'stripe_connect_id' => $account->id,
            ];
            if (!FatApp::getDb()->insertFromArray(static::DB_TBL_USR_STRIPE_CONNECT_INFO, $assignValues, false, [], $assignValues)) {
                $this->error = $this->db->getError();
                return false;
            }
        return $accountLinks->url;
    }
    public function StripeConnectWithdrawal(array $data = []){
        $stripe =  new \Stripe\StripeClient('sk_test_51KlBYRBHOKvtnZNpHREAc3JTMGf8tMDaRutHzeMXKV8lFoocoQgropFRKVZIQZmMT9qHWdCEmWW0RIytwFOBa0XE00Xx5dsY8H');
        try {
            $stripe->accounts->update(
                $data['stripe_connect_id'],
                ['tos_acceptance' => ['date' => time(), 'ip' => $_SERVER['REMOTE_ADDR']]]
              );
            $transfer = $stripe->transfers->create([
                'amount' => $data['withdrawal_amount'] * 100,
                'currency' => 'usd',
                'destination' => $data['stripe_connect_id'],
                'transfer_group' => 'ORDER_95',
            ]);
        
        } catch (Exception $e) {
            $msg['msg'] = $e->getMessage();
            $msg['status'] = 0;
            return $msg;
        }
    }

    public function updatePaypalInfo($data = [])
    {
        if (($this->getMainTableRecordId() < 1)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST_USER_NOT_INITIALIZED');
            return false;
        }
        $assignValues = [
            'ub_user_id' => $this->getMainTableRecordId(),
            'ub_paypal_email_address' => $data['ub_paypal_email_address']
        ];
        if (!FatApp::getDb()->insertFromArray(static::DB_TBL_USR_BANK_INFO, $assignValues, false, [], $assignValues)) {
            $this->error = $this->db->getError();
            return false;
        }
        return true;
    }

    public static function getWalletBalance(int $userId): float
    {
        $setting = UserSetting::getSettings($userId, ['user_wallet_balance']);
        return FatUtility::float($setting['user_wallet_balance'] ?? 0);
    }

    /**
     * Get Last Withdraw Request
     */
    public static function getLastWithdrawal($userId)
    {
        $userId = FatUtility::int($userId);
        $srch = new SearchBase(static::DB_TBL_USR_WITHDRAWAL_REQ, 'tuwr');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('withdrawal_user_id', '=', $userId);
        $srch->addOrder('withdrawal_request_date', 'desc');
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    /**
     * Add Withdrawal Request
     * 
     * @param array $data
     * @return boolean
     */
    public function addWithdrawalRequest(array $data)
    {
        $userId = FatUtility::int($data['ub_user_id']);
        unset($data['ub_user_id']);
        if ($userId < 1) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST.');
            return false;
        }
        $assignFields = [
            'withdrawal_user_id' => $userId,
            'withdrawal_amount' => $data['withdrawal_amount'],
            'withdrawal_payment_method_id' => $data['withdrawal_payment_method_id'],
            'withdrawal_comments' => $data['withdrawal_comments'],
            'withdrawal_status' => WithdrawRequest::STATUS_PENDING,
            'withdrawal_transaction_fee' => $data['withdrawal_transaction_fee'],
            'withdrawal_request_date' => date('Y-m-d H:i:s'),
        ];
        switch ($data['pmethod_code']) {
            case BankPayout::KEY:
                $assignFields += [
                    'withdrawal_bank' => $data['ub_bank_name'],
                    'withdrawal_account_holder_name' => $data['ub_account_holder_name'],
                    'withdrawal_account_number' => $data['ub_account_number'],
                    'withdrawal_ifc_swift_code' => $data['ub_ifsc_swift_code'],
                    'withdrawal_bank_address' => $data['ub_bank_address'],
                ];
                break;
            case PaypalPayout::KEY:
                $assignFields += ['withdrawal_paypal_email_id' => $data['ub_paypal_email_address'],];
                break;
        }
        if (!FatApp::getDb()->insertFromArray(static::DB_TBL_USR_WITHDRAWAL_REQ, $assignFields)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return FatApp::getDb()->getInsertId();
    }

    /**
     * Setup Favorite Teacher
     * 
     * @param int $teacherId
     * @return bool
     * 
     */
    public function setupFavoriteTeacher(int $teacherId): bool
    {
        $data = ['uft_user_id' => $this->getMainTableRecordId(), 'uft_teacher_id' => $teacherId];
        if (!FatApp::getDb()->insertFromArray(static::DB_TBL_TEACHER_FAVORITE, $data, false, [], $data)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    /**
     * Get Favourites
     * 
     * @param array $filter
     * @param int $langId
     * @return array
     */
    public function getFavourites(array $filter, int $langId = 0): array
    {
        $srch = new SearchBase(User::DB_TBL_TEACHER_FAVORITE, 'uft');
        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'uft_teacher_id = ut.user_id', 'ut');
        $srch->joinTable(Afile::DB_TBL, 'LEFT JOIN', 'file.file_record_id = uft_teacher_id and file.file_type = ' . Afile::TYPE_USER_PROFILE_IMAGE, 'file');
        $srch->joinTable(UserTeachLanguage::DB_TBL, 'LEFT  JOIN', 'ut.user_id = utsl.utlang_user_id', 'utsl');
        $srch->joinTable(TeachLanguage::DB_TBL, 'LEFT JOIN', 'tlang_id = utsl.utlang_tlang_id');
        $srch->joinTable(TeachLanguage::DB_TBL_LANG, 'LEFT JOIN', 'tlanglang_tlang_id = utsl.utlang_tlang_id AND tlanglang_lang_id = ' . $langId, 'sl_lang');
        $srch->addMultipleFields([
            'utsl.utlang_user_id',
            'GROUP_CONCAT(DISTINCT IFNULL(tlang_name, tlang_identifier)) as teacherTeachLanguageName',
            'uft_teacher_id', 'file_id', 'user_username', 'user_first_name', 'user_last_name', 'user_country_id'
        ]);

        $srch->addCondition('uft_user_id', '=', $this->getMainTableRecordId());
        $srch->addCondition('ut.user_is_teacher', '=', AppConstant::YES);
        $srch->addCondition('user_active', '=', AppConstant::ACTIVE);
        $srch->addDirectCondition('user_verified IS NOT NULL');
        if (!empty($filter['keyword'])) {
            $srch->addCondition('mysql_func_concat(`user_first_name`," ",`user_last_name`)', 'like', '%' . $filter['keyword'] . '%', 'AND', true);
        }
        $srch->addGroupBy('uft_teacher_id');
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pageSize = AppConstant::PAGESIZE;
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $dataArr['Favourites'] = FatApp::getDb()->fetchAll($srch->getResultSet());
        $dataArr['pagingArr'] = [
            'pageCount' => $srch->pages(), 'page' => $page,
            'pageSize' => $pageSize, 'recordCount' => $srch->recordCount()
        ];
        return $dataArr;
    }

    /**
     * Can Withdraw
     * 
     * @param int $userId
     * @return bool
     */
    public static function canWithdraw(int $userId): bool
    {
        return (bool) self::getAttributesById($userId, 'user_is_teacher');
    }

    /**
     * Get By Email
     * 
     * @param string $email
     * @return null|array
     */
    public static function getByEmail(string $email)
    {
        $srch = new SearchBase(User::DB_TBL, 'user');
        $srch->joinTable(User::DB_TBL_SETTING, 'INNER JOIN', 'user.user_id=uset.user_id', 'uset');
        $srch->addMultipleFields([
            'user.user_id as user_id', 'user_first_name', 'user_last_name', 'user_email',
            'user_username', 'user_password', 'user_timezone', 'user_lang_id',
            'user_country_id', 'user_is_teacher', 'user_active', 'user_verified', 'user_dashboard'
        ]);
        $srch->addCondition('user_email', '=', $email);
        $srch->addDirectCondition('user_deleted IS NULL');
        $srch->doNotCalculateRecords();
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    /**
     * Get By Username
     * 
     * @param string $username
     * @param array $fields
     * @return null|array
     */
    public static function getByUsername(string $username, array $fields = null)
    {
        $srch = new SearchBase(User::DB_TBL, 'user');
        $srch->joinTable(User::DB_TBL_SETTING, 'INNER JOIN', 'user.user_id=uset.user_id', 'uset');
        if (is_null($fields)) {
            $fields = [
                'user.user_id as user_id', 'user_first_name', 'user_last_name', 'user_email',
                'user_username', 'user_password', 'user_timezone', 'user_lang_id',
                'user_country_id', 'user_is_teacher', 'user_active', 'user_verified', 'user_dashboard'
            ];
        }
        $srch->addMultipleFields($fields);
        $srch->addCondition('user_username', '=', $username);
        $srch->addDirectCondition('user_deleted IS NULL');
        $srch->doNotCalculateRecords();
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    /**
     * Get Biography 
     * 
     * @param int $langId
     * @return null|array
     */
    public function getBio(int $langId)
    {
        $srch = new SearchBase(User::DB_TBL_LANG);
        $srch->addCondition('userlang_lang_id', '=', $langId);
        $srch->addCondition('userlang_user_id', '=', $this->getMainTableRecordId());
        $srch->addMultipleFields(['userlang_lang_id', 'user_biography']);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    /**
     * Is User Delete
     * 
     * @param int $userId
     * @return bool
     */
    public static function isUserDelete(int $userId): bool
    {
        $srch = new SearchBase(static::DB_TBL);
        $srch->addCondition('user_id', '=', $userId);
        $srch->addDirectCondition('user_deleted IS NOT NULL');
        $srch->addFld('count(*) as total');
        $srch->doNotCalculateRecords();
        $user = FatApp::getDb()->fetch($srch->getResultSet());
        return ($user['total'] > 0);
    }

    /**
     * Validate Teacher
     * 
     * @param int $langId
     * @param int $learnerId
     * @return type
     */
    public function validateTeacher(int $langId, int $learnerId)
    {
        $srch = new TeacherSearch($langId, $learnerId, User::LEARNER);
        $srch->joinTable(UserSetting::DB_TBL, 'INNER JOIN', 'us.user_id = teacher.user_id', 'us');
        $srch->addMultipleFields([
            'teacher.user_id', 'teacher.user_first_name', 'teacher.user_country_id',
            'teacher.user_last_name', 'us.user_trial_enabled', 'us.user_book_before'
        ]);
        $srch->addCondition('teacher.user_id', '=', $this->getMainTableRecordId());
        $srch->applyPrimaryConditions();
        $srch->setPageSize(1);
        $teacher = FatApp::getDb()->fetch($srch->getResultSet());
        return empty($teacher) ? false : $teacher;
    }

    /**
     * Update Refferer
     * 
     * @param int $Refferer
     * @return bool
     */
    public function updateRefferer(int $refferer = 1): bool
    {
        if (empty($this->mainTableRecordId)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST');
            return false;
        }
        $this->setFlds(['refferer' => $refferer]);
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    public function updateReffererPaid(): bool
    {
        if (empty($this->mainTableRecordId)) {
            $this->error = Label::getLabel('ERR_INVALID_REQUEST');
            return false;
        }
        $this->setFlds(['refferer_paid' => 1]);
        if (!$this->save()) {
            return false;
        }
        return true;
    }
}
