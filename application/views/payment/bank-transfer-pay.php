<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'setup(this);return false;');
$frm->setFormTagAttribute('class', 'form form--normal');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
?>
<div class="payment-page">
    <div class="cc-payment">
        <div class="logo-payment">
            <?php if (MyUtility::isDemoUrl()) { ?>
                <img src="<?php echo CONF_WEBROOT_FRONTEND . 'images/yocoach-logo.svg'; ?>" alt="" />
            <?php } else { ?>
                <img src="<?php echo MyUtility::makeFullUrl('Image', 'show', [Afile::TYPE_FRONT_LOGO, 0, Afile::SIZE_LARGE], CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId); ?>" />
            <?php } ?>
        </div>
        <div class="reff row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <p><?php echo Label::getLabel('LBL_PAYABLE_AMOUNT'); ?> : <strong><?php echo MyUtility::formatMoney($order['order_net_amount']) ?></strong> </p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <p><?php echo Label::getLabel('LBL_ORDER_INVOICE'); ?>: <strong><?php echo Order::formatOrderId($order["order_id"]); ?></strong></p>
            </div>
        </div>
        <div class="payment-from">
            <div class="payable-form__body">
                <h6 class="align--center"><?php echo Label::getLabel('LBL_COMPLETE_BANK_TRANSFER_ORDER_HEADING'); ?></h6>
                <div class="col-xl-12">
                    <div class="-gap-10"></div>
                    <div class="align--center"><?php echo nl2br($accountDetails); ?></div>
                    <hr/>
                </div>
                <div><?php echo $frm->getFormHtml(); ?></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        setup = function (frm) {
            if (!$(frm).validate()) {
                return;
            }
            var data = new FormData(frm);
            var action = fcom.makeUrl('Payment', 'return', [<?php echo $order['order_id']; ?>]);
            fcom.ajaxMultipart(action, data, function (res) {
                if (res.url) {
                    window.location.href = res.url;
                }
            }, {fOutMode: 'json'});
        };
    });
</script>