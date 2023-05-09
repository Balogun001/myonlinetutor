<?php

/**
 * This class is used to handle User
 * 
 * @package YoCoach
 * @author Fatbit Team
 */
class AffiliateUser extends MyAppModel
{

    const ADMIN_SESSION_ELEMENT = 'yoCoachAdmin';
    const DB_TBL = 'affilates_users';
    const DB_TBL_PREFIX = '';
    /**
     * Initialize User
     * 
     * @param int $userId
     */
    public function __construct(int $userId = 0)
    {
        parent::__construct(static::DB_TBL, 'id', $userId);
        $this->objMainTableRecord->setSensitiveFields([
            'password', 'user_active', 'email_verified_at', 'facebook_id', 'google_id'
        ]);
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
     * Get User Details
     * 
     * @param int $userId
     * @return null|array
     */
    public static function getDetail(int $userId)
    {
        $srch = new SearchBase(static::DB_TBL, 'user');
        $srch->addCondition('user.id', '=', $userId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }
}
