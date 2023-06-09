<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'setupWithdrawalReq(this); return(false);');
$payoutTypeFld = $frm->getField('withdrawal_payment_method_id');
$amountFld = $frm->getField('withdrawal_amount');
$pmethodCodeFld = $frm->getField('pmethod_code');
if ($pmethodCodeFld->value == PaypalPayout::KEY) {
    $emailFld = $frm->getField('ub_paypal_email_address');
} elseif ($pmethodCodeFld->value == BankPayout::KEY) {
    $bankNameFld = $frm->getField('ub_bank_name');
    $honderNameFld = $frm->getField('ub_account_holder_name');
    $accountNumberFld = $frm->getField('ub_account_number');
    $swiftCodeFld = $frm->getField('ub_ifsc_swift_code');
    $bankAddressFld = $frm->getField('ub_bank_address');
} else {
    $stripeConnectField = $frm->getField('stripe_connect_id');
    $firstNameField = $frm->getField('user_first_name');
    $lastNameField = $frm->getField('user_last_name');
    $emailField = $frm->getField('user_email');
    $accountNumberField = $frm->getField('account_number');
    $currencyField = $frm->getField('user_currency');
    $routingNumberField = $frm->getField('routing_number');

    $frm->getField('stripe_connect_id')->addFieldtagAttribute('disabled', 'disabled');
    $frm->getField('user_first_name')->addFieldtagAttribute('disabled', 'disabled');
    $frm->getField('user_last_name')->addFieldtagAttribute('disabled', 'disabled');
    $frm->getField('user_email')->addFieldtagAttribute('disabled', 'disabled');
    $frm->getField('account_number')->addFieldtagAttribute('disabled', 'disabled');
    $frm->getField('user_currency')->addFieldtagAttribute('disabled', 'disabled');
    $frm->getField('routing_number')->addFieldtagAttribute('disabled', 'disabled');
}
$commentFld = $frm->getField('withdrawal_comments');
$submitBtnFld = $frm->getField('btn_submit');
$cancelBtnFld = $frm->getField('btn_cancel');
$cancelBtnFld->setFieldTagAttribute('onClick', 'closeForm()');
?>
<div class="facebox-panel">
    <div class="facebox-panel__head">
        <h4><?php echo Label::getLabel('LBL_REQUEST_WITHDRAWAL'); ?></h4>
    </div>
    <div class="facebox-panel__body">
        <?php echo $frm->getFormTag(); ?>
        <?php echo $pmethodCodeFld->getHTML(); ?>
        <div class="row">
            <div class="col-sm-12 col-lg-12 col-lg-6 col-md-12">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">
                            <?php echo $payoutTypeFld->getCaption(); ?>
                            <?php if ($payoutTypeFld->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <ul class="list-inline list-inline--onehalf">
                                <?php foreach ($payoutTypeFld->options as $id => $label) { ?>
                                    <li>
                                        <label>
                                            <span class="radio">
                                                <input type="radio" name="<?php echo $payoutTypeFld->getName(); ?>" value="<?php echo $id; ?>" onchange="getWithdrwalRequestForm(this.value);" <?php echo ($payoutTypeFld->value == $id) ? 'checked="checked"' : ''; ?> />
                                                <i class="input-helper"></i>
                                            </span>
                                            <?php echo $label; ?>
                                        </label>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($pmethodCodeFld->value == PaypalPayout::KEY) { ?>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $amountFld->getCaption(); ?>
                                <?php if ($amountFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $amountFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $emailFld->getCaption(); ?>
                                <?php if ($emailFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $emailFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-lg-6 col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $commentFld->getCaption(); ?>
                                <?php if ($commentFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $commentFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        if ($pmethodCodeFld->value == BankPayout::KEY) { ?>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $amountFld->getCaption(); ?>
                                <?php if ($amountFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $amountFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php echo $bankNameFld->getCaption(); ?>
                                    <?php if ($bankNameFld->requirement->isRequired()) { ?>
                                        <span class="spn_must_field">*</span>
                                    <?php } ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $bankNameFld->getHtml(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $honderNameFld->getCaption(); ?>
                                <?php if ($honderNameFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $honderNameFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $accountNumberFld->getCaption(); ?>
                                <?php if ($accountNumberFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $accountNumberFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-lg-6 col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $swiftCodeFld->getCaption(); ?>
                                <?php if ($swiftCodeFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $swiftCodeFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $bankAddressFld->getCaption(); ?>
                                <?php if ($bankAddressFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $bankAddressFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $commentFld->getCaption(); ?>
                                <?php if ($commentFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $commentFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($pmethodCodeFld->value == StripeConnect::KEY) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $amountFld->getCaption(); ?>
                                <?php if ($amountFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $stripeConnectField->getHtml(); ?>
                                <?php echo $amountFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $firstNameField->getCaption(); ?>
                                <?php if ($firstNameField->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $firstNameField->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $lastNameField->getCaption(); ?>
                                <?php if ($lastNameField->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $lastNameField->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $emailField->getCaption(); ?>
                                <?php if ($emailField->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $emailField->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $accountNumberField->getCaption(); ?>
                                <?php if ($accountNumberField->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $accountNumberField->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $currencyField->getCaption(); ?>
                                <?php if ($currencyField->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $currencyField->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $routingNumberField->getCaption(); ?>
                                <?php if ($routingNumberField->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $routingNumberField->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label">
                                <?php echo $commentFld->getCaption(); ?>
                                <?php if ($commentFld->requirement->isRequired()) { ?>
                                    <span class="spn_must_field">*</span>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $commentFld->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row form-action-sticky">
            <div class="col-sm-12">
                <div class="field-set margin-bottom-0">
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $cancelBtnFld->getHtml(); ?>
                            <?php echo $submitBtnFld->getHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php echo $frm->getExternalJS(); ?>
    </div>
</div>