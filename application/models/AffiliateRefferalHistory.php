<?php

/**
 * This class is used to handle User
 * 
 * @package YoCoach
 * @author Fatbit Team
 */
class AffiliateRefferalHistory extends MyAppModel
{

    const ADMIN_SESSION_ELEMENT = 'yoCoachAdmin';
    const DB_TBL = 'affilates_referral_history';
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
            'refral_ids', 'status', 'user_email'
        ]);
    }

    /**
     * Update Status
     * 
     * @param int $status
     * @return bool
     */
    public function updateStatus()
    {
        $query = "UPDATE " . static::DB_TBL . " SET `descriptions` = 'Refferal purchased the session', `status` = 'Converted' WHERE `id` = " . $this->getMainTableRecordId();
        if (!FatApp::getDb()->query($query)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    /**
     * Update Status
     * 
     * @param int $status
     * @return bool
     */
    public function updateRefferal($status, $email, $descriptions)
    {
        $query = "UPDATE " . static::DB_TBL . " SET `user_email` = '$email', `descriptions` = '$descriptions', `status` = '$status' WHERE `id` = " . $this->getMainTableRecordId();
        if (!FatApp::getDb()->query($query)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    public function getDetailByUser($user_email)
    {
        $srch = new SearchBase(static::DB_TBL, 'user');
        $srch->addCondition('user.user_email', '=', $user_email);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    /**
     * Get User Details
     * 
     * @param int $userId
     * @return null|array
     */
    public static function getDetail($reff_id, $session_id)
    {
        $srch = new SearchBase(static::DB_TBL, 'user');
        $srch->addCondition('user.refral_ids', '=', $reff_id);
        $srch->addCondition('user.session_id', '=', $session_id);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return FatApp::getDb()->fetch($srch->getResultSet());
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
}
