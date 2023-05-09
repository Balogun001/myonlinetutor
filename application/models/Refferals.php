<?php

/**
 * This class is used to handle Coupon
 * 
 * @package YoCoach
 * @author Fatbit Team
 */
class Refferals extends MyAppModel
{

    const DB_TBL = 'affilates_referral_history';

    private $langId = 0;

    /**
     * Initialize Coupon
     * 
     * @param int $couponId
     * @param int $langId
     */
    public function __construct()
    {
    }

    protected function check_refferal($session_id, $reffral_id)
    {
        $srch = new SearchBase(static::DB_TBL, 'id');
        $srch->addCondition('session_id', '=', $session_id);
        $srch->addCondition('refral_ids', '=', $reffral_id);
        $reffer = FatApp::getDb()->fetch($srch->getResultSet());
        if (empty($reffer)) {
            return false;
        }
        
        return $reffer;
    }

    /**
     * Save record
     * 
     * @return type
     */
    public function opened(int $ref)
    {
        // check if same session is already stored
        $check = $this->check_refferal(session_id(), $ref);
        $reffer = new TableRecord(Refferals::DB_TBL);
        $reffer->assignValues([
            'refral_ids' => $ref,
            'session_id' => session_id(),
            'descriptions' => 'Refferal link opened',
            'status' => 'Not Converted',
        ]);

        if (!isset($check['id']))
            if (!$reffer->addNew(['HIGH_PRIORITY'])) {
                $this->error = $reffer->getError();
                return false;
            }

        return true;
    }

    public function register(int $ref)
    {
        $reffer = new TableRecord(Refferals::DB_TBL);
        $reffer->assignValues([
            'refral_ids' => $ref,
            'descriptions' => 'User Signed up using refferal',
            'status' => 'Signed up',
        ]);
        if (!$reffer->addNew(['HIGH_PRIORITY'])) {
            $this->error = $reffer->getError();
            return false;
        }

        return true;
    }
}
