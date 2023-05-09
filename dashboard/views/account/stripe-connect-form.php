<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'frmStripeInfo');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'setupStripeConnectInfo(this); return(false);');
$ub_user_id = $frm->getField('user_id');
$ub_first_name = $frm->getField('user_first_name');
$ub_last_name = $frm->getField('user_last_name');
$ub_user_email = $frm->getField('user_email');
$ub_account_number = $frm->getField('account_number');
$ub_user_country_id = $frm->getField('user_country_code');
$ub_user_currency = $frm->getField('user_currency');
$routing_number = $frm->getField('routing_number');
// $stripeConnectField = $frm->getField('stripe_connect_id');
// $frm->getField('stripe_connect_id')->addFieldtagAttribute('disabled', 'disabled');
$btnBack = $frm->getField('btn_back');
$btnBack->addFieldTagAttribute('onclick', 'paypalEmailAddressForm();');
?>
<div class="content-panel__head">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h5><?php echo Label::getLabel('LBL_Manage_Payments'); ?></h5>
        </div>
        <div>
            <p class="color-secondary margin-bottom-0"><?php echo Label::getLabel('LBL_MANAGE_PAYMENT_INFO_TEXT'); ?></p>
        </div>
    </div>
</div>
<div class="content-panel__body">
    <div class="form">
        <?php echo $frm->getFormTag(); ?>
        <div class="form__body padding-0">
            <nav class="tabs tabs--line padding-left-6 padding-right-6">
                <ul>
                    <li><a href="javascript:void(0);" onclick="bankInfoForm();"><?php echo Label::getLabel('LBL_BANK_ACCOUNT'); ?></a></li>
                    <li><a href="javascript:void(0);" onclick="paypalEmailAddressForm();"><?php echo Label::getLabel('LBL_PAYPAL_EMAIL'); ?></a></li>
                    <li class="is-active"><a href="javascript:void(0);">Stripe Connect</a></li>
                </ul>
            </nav>
            <div class="tabs-data">
                <div class="padding-6 padding-bottom-0" id="paymentInfoDiv">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label"><?php echo $ub_first_name->getCaption(); ?>
                                        <?php if ($ub_first_name->requirement->isRequired()) { ?><span class="spn_must_field">*</span><?php } ?>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover"><?php echo $ub_user_id->getHtml(); ?><?php echo $ub_first_name->getHtml(); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label"><?php echo $ub_last_name->getCaption(); ?>
                                        <?php if ($ub_last_name->requirement->isRequired()) { ?><span class="spn_must_field">*</span><?php } ?>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover"><?php echo $ub_last_name->getHtml(); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label"><?php echo $ub_user_email->getCaption(); ?>
                                        <?php if ($ub_user_email->requirement->isRequired()) { ?><span class="spn_must_field">*</span><?php } ?>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover"><?php echo $ub_user_email->getHtml(); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label"><?php echo $ub_account_number->getCaption(); ?>
                                        <?php if ($ub_account_number->requirement->isRequired()) { ?><span class="spn_must_field">*</span><?php } ?>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover"><?php echo $ub_account_number->getHtml(); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label"><?php echo $ub_user_country_id->getCaption(); ?>
                                        <?php if ($ub_user_country_id->requirement->isRequired()) { ?><span class="spn_must_field">*</span><?php } ?>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <select data-field-caption="Country" data-fatreq="{" required":true}" name="user_country_code" id="user_country_code">
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'AU'){ echo 'selected';} ?> value="AU">Australia (AU)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'AT'){ echo 'selected';} ?> value="AT">Austria (AT)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'BE'){ echo 'selected';} ?> value="BE">Belgium (BE)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'BG'){ echo 'selected';} ?> value="BG">Bulgaria (BG)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'CA'){ echo 'selected';} ?> value="CA">Canada (CA)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'HR'){ echo 'selected';} ?> value="HR">Croatia (HR)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'CY'){ echo 'selected';} ?> value="CY">Cyprus (CY)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'CZ'){ echo 'selected';} ?> value="CZ">Czech Republic (CZ)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'DK'){ echo 'selected';} ?> value="DK">Denmark (DK)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'EE'){ echo 'selected';} ?> value="EE">Estonia (EE)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'FI'){ echo 'selected';} ?> value="FI">Finland (FI)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'FR'){ echo 'selected';} ?> value="FR">France (FR)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'DE'){ echo 'selected';} ?> value="DE">Germany (DE)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'GI'){ echo 'selected';} ?> value="GI">Gibraltar (GI)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'GR'){ echo 'selected';} ?> value="GR">Greece (GR)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'HK'){ echo 'selected';} ?> value="HK">Hong Kong (HK)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'HU'){ echo 'selected';} ?> value="HU">Hungary (HU)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'IE'){ echo 'selected';} ?> value="IE">Ireland (IE)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'IT'){ echo 'selected';} ?> value="IT">Italy (IT)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'JP'){ echo 'selected';} ?> value="JP">Japan (JP)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'LV'){ echo 'selected';} ?> value="LV">Latvia (LV)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'LI'){ echo 'selected';} ?> value="LI">Liechtenstein (LI)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'LT'){ echo 'selected';} ?> value="LT">Lithuania (LT)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'LU'){ echo 'selected';} ?> value="LU">Luxembourg (LU)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'MT'){ echo 'selected';} ?> value="MT">Malta (MT)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'MX'){ echo 'selected';} ?> value="MX">Mexico (MX)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'NL'){ echo 'selected';} ?> value="NL">Netherlands (NL)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'NZ'){ echo 'selected';} ?> value="NZ">New Zealand (NZ)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'NO'){ echo 'selected';} ?> value="NO">Norway (NO)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'PL'){ echo 'selected';} ?> value="PL">Poland (PL)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'PT'){ echo 'selected';} ?> value="PT">Portugal (PT)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'RO'){ echo 'selected';} ?> value="RO">Romania (RO)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'SG'){ echo 'selected';} ?> value="SG">Singapore (SG)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'SK'){ echo 'selected';} ?> value="SK">Slovakia (SK)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'SI'){ echo 'selected';} ?> value="SI">Slovenia (SI)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'ES'){ echo 'selected';} ?> value="ES">Spain (ES)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'SE'){ echo 'selected';} ?> value="SE">Sweden (SE)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'CH'){ echo 'selected';} ?> value="CH">Switzerland (CH)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'TH'){ echo 'selected';} ?> value="TH">Thailand (TH)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'AE'){ echo 'selected';} ?> value="AE">United Arab Emirates (AE)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'GB'){ echo 'selected';} ?> value="GB">United Kingdom (GB)</option>
                                            <option <?php if(isset($ub_user_country_id->value) && $ub_user_country_id->value == 'US'){ echo 'selected';} ?> value="US">United States (US)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label"><?php echo $ub_user_currency->getCaption(); ?>
                                        <?php if ($ub_user_currency->requirement->isRequired()) { ?><span class="spn_must_field">*</span><?php } ?>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $ub_user_currency->getHtml(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="routing_number_div" <?php if(!isset($ub_user_country_id->value) || $ub_user_country_id->value == ''){ ?> style="display:none;" <?php } ?>>
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label">Routing Number
                                        <span class="spn_must_field">*</span>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $routing_number->getHtml(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form__actions">
            <div class="d-flex align-items-center justify-content-between">
                <?php if ($siteUserType == User::TEACHER) { ?>
                    <div><?php echo $btnBack->getHtml(); ?></div>
                <?php } else { ?>
                    <div></div>
                <?php } ?>
                <div><?php echo $frm->getFieldHTML('btn_submit'); ?></div>
            </div>
        </div>
        </form>
        <?php echo $frm->getExternalJS(); ?>
        <script>
            $(document).on('change','#user_country_code',function(){
                if($(this).val() == 'US'){
                    $('#routing_number_div').show();
                    $('#routing_number').attr('required', true);
                }else{
                    $('#routing_number_div').hide();
                    $('#routing_number').attr('required', false);
                }
            })
        </script>
    </div>
</div>