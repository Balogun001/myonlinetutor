<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Label::getLabel('LBL_ACCOUNT_DETAILS'); ?></h4>
    </div>
    <div class="tabs_nav_container responsive flat">
        <ul class="tabs_nav">
            <li><a class="active" href="javascript:void(0);"><?php echo Label::getLabel('LBL_ACCOUNT_DETAILS'); ?></a></li>
        </ul>
        <div class="tabs_panel_wrap">
            <div class="tabs_panel">
                <?php
                if (isset($arrListing[0]['payout_type']) && $arrListing[0]['payout_type'] == 'Bank') {
                    $arrFlds = [
                        'account_name' => Label::getLabel('LBL_ACCOUNT_NAME'),
                        'account_no' => Label::getLabel('LBL_ACCOUNT_NO'),
                        'account_type' => Label::getLabel('LBL_ACCOUNT_TYPE'),
                        'bank_name' => Label::getLabel('LBL_BANK_NAME'),
                        'branch_code' => Label::getLabel('LBL_BRANCH_CODE'),
                        'routing_number' => Label::getLabel('LBL_ROUNTING_NUMBER'),
                        'swift_code' => Label::getLabel('LBL_SWITFT_CODE')
                    ];
                } else {
                    $arrFlds = [
                        'paypal_id' => Label::getLabel('LBL_PAYPAL_ID')
                    ];
                }
                $tbl = new HtmlElement('table', ['width' => '100%', 'class' => 'table table-responsive fixed-layout']);
                $th = $tbl->appendElement('thead')->appendElement('tr');
                foreach ($arrFlds as $key => $val) {
                    $e = $th->appendElement('th', [], $val, true);
                }
                $srNo = 0;
                foreach ($arrListing as $sn => $row) {
                    $srNo++;
                    $tr = $tbl->appendElement('tr');
                    foreach ($arrFlds as $key => $val) {
                        $td = $tr->appendElement('td');
                        $td->appendElement('plaintext', [], $row[$key], true);
                    }
                }
                if (count($arrListing) == 0) {
                    $tbl->appendElement('tr')->appendElement('td', ['colspan' => count($arrFlds)], Label::getLabel('LBL_NO_RECORDS_FOUND'));
                }
                echo $tbl->getHtml();
                $postedData['page'] = $page;
                echo FatUtility::createHiddenFormFromData($postedData, ['name' => 'transactionPaging']);
                $pagingArr = ['pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'callBackJsFunc' => 'goToTransactionPage'];
                $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
                ?>
            </div>
        </div>
    </div>
</section>
<script>
    var userId = '<?php echo $userId; ?>';
</script>