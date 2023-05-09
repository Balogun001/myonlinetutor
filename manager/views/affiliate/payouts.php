<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Label::getLabel('LBL_PAYOUTS'); ?></h4>
    </div>
    <div class="tabs_nav_container responsive flat">
        <ul class="tabs_nav">
            <li><a class="active" href="javascript:void(0);"><?php echo Label::getLabel('LBL_PAYOUTS'); ?></a></li>
        </ul>
        <div class="tabs_panel_wrap">
            <div class="tabs_panel">
                <?php
                $arrFlds = [
                    'rfr_id' => Label::getLabel('LBL_REFFERAL_ID'),
                    'amount' => Label::getLabel('LBL_AMOUNT'),
                    'created_at' => Label::getLabel('LBL_DATE'),
                    'status' => Label::getLabel('LBL_STATUS')
                ];

                $activeLabel = Label::getLabel('LBL_ACTIVE');
                $inactiveLabel = Label::getLabel('LBL_INACTIVE');
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
                        switch ($key) {
                            case 'rfr_id':
                                $td->appendElement('plaintext', [], $row[$key]);
                                break;
                            case 'amount':
                                $td->appendElement('plaintext', [], MyUtility::formatMoney($row[$key]), true);
                                break;
                            case 'created_at':
                                $td->appendElement('plaintext', [], MyDate::formatDate($row[$key]));
                                break;
                            case 'status':
                                $active = "";
                                $statusAct = 'payoutUpdate(this,1)';
                                if ($row['status'] == 'Paid') {
                                    $active = 'active';
                                    $statusAct = 'payoutUpdate(this,0)';
                                }
                                $statusClass = '';
                                if ($canEdit === false) {
                                    $statusClass = "disabled";
                                    $statusAct = '';
                                }
                                $str = '<label id="' . $row['id'] . '" class="statustab status_' . $row['id'] . ' ' . $active . '" onclick="' . $statusAct . '">
				  <span data-off="' . $activeLabel . '" data-on="' . $inactiveLabel . '" class="switch-labels"></span>
				  <span class="switch-handles ' . $statusClass . '"></span>
				</label>';
                                $td->appendElement('plaintext', [], $str, true);
                                break;
                            default:
                                $td->appendElement('plaintext', [], $row[$key], true);
                                break;
                        }
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