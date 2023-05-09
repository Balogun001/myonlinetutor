<?php

/**
 * This class is used to handle Paypal Payouts
 * 
 * @package YoCoach
 * @author Fatbit Team
 */
class StripeConnect extends FatModel
{

    public $pmethod;
    public $settings;

    const KEY = 'StripeConnect';

    public function __construct()
    {
        $this->pmethod = [];
        $this->settings = [];
        parent::__construct();
    }

    public static function getWithdrawalForm(array $paymentMethod): Form
    {
        $currency = MyUtility::getSystemCurrency();
        $frm = new Form('frmWithdrawal');
        $frm->addRadioButtons(Label::getLabel('LBL_Payout_Type'), 'withdrawal_payment_method_id', $paymentMethod);
        $defaultCurLbl = Label::getLabel('LBL_ENTER_AMOUNT_TO_BE_ADDED_[{currency-code}]');
        $defaultCurLbl = str_replace('{currency-code}', $currency['currency_code'], $defaultCurLbl);
        $frm->addHiddenField(Label::getLabel('LBL_Stripe_Connect_Id'), 'stripe_connect_id');
        $frm->addRequiredField(Label::getLabel('LBL_First_Name'), 'user_first_name');
        $frm->addTextBox(Label::getLabel('LBL_Last_Name'), 'user_last_name');
        $frm->addTextBox(Label::getLabel('LBL_Routing_Number'), 'routing_number');
        $frm->addRequiredField(Label::getLabel('LBL_Email'), 'user_email');
        $frm->addRequiredField(Label::getLabel('LBL_Account_Number'), 'account_number');
        $currency = Currency::getAll();
        $fld = $frm->addSelectBox(Label::getLabel('LBL_CURRENCY'), 'user_currency', array_column($currency, 'currency_code', 'currency_code'), FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 0), [], Label::getLabel('LBL_SELECT'));
        $fld->requirements()->setRequired(true);
        $fld = $frm->addRequiredField($defaultCurLbl, 'withdrawal_amount');
        $fld->requirements()->setFloat(true);
        $fld->requirements()->setRange(FatApp::getConfig("CONF_MIN_WITHDRAW_LIMIT"), 999999);
        $frm->addTextArea(Label::getLabel('LBL_Other_Info_Instructions'), 'withdrawal_comments');
        $frm->addHiddenField('', 'pmethod_code', StripeConnect::KEY);
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_Send_Request'));
        $frm->addButton("", "btn_cancel", Label::getLabel('LBL_Cancel'));
        return $frm;
    }

}
