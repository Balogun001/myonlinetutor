<?php

/**
 * This class is used to handle User
 * 
 * @package YoCoach
 * @author Fatbit Team
 */
class AffiliatePayouts extends MyAppModel
{

    const ADMIN_SESSION_ELEMENT = 'yoCoachAdmin';
    const DB_TBL = 'affilates_payouts';
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
            'amount', 'rfr_id', 'status'
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
        if ($status == 0) {
            $status = 'Pending';
        } else {
            $status = 'Paid';
        }
        $this->setFlds(['status' => $status, 'paid_at' => date('Y-m-d H:i:s')]);
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

    public function payment($order, $user)
    {
        $payout = new TableRecord(AffiliatePayouts::DB_TBL);
        $payout->assignValues([
            'amount' => (($order['order_total_amount'] - FatApp::getConfig('PROCESSING_FEES')) * FatApp::getConfig('AFFILIATE_COMMISSION_FEES')) / 100,
            'rfr_id' => $user['refferer'],
            'session_id' => $user['user_id'],
            'description' => 'Payout for refferer student ' . $user['user_email'],
            'status' => 'Pending',
        ]);
        if (!$payout->addNew(['HIGH_PRIORITY'])) {
            $this->error = $payout->getError();
            // return false;
        }

        return true;
    }
}
