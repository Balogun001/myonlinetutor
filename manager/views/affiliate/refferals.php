<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Label::getLabel('LBL_REFFERALS'); ?></h4>
    </div>
    <div class="tabs_nav_container responsive flat">
        <ul class="tabs_nav">
            <li><a class="active" href="javascript:void(0);"><?php echo Label::getLabel('LBL_REFFERALS'); ?></a></li>
        </ul>
        <div class="tabs_panel_wrap">
            <div class="tabs_panel">
                <?php
                $arrFlds = [
                    'refral_ids' => Label::getLabel('LBL_REFFERAL_ID'),
                    'created_at' => Label::getLabel('LBL_DATE'),
                    'descriptions' => Label::getLabel('LBL_REFFERAL_DESCRIPTION')
                ];
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
                            case 'created_at':
                                $td->appendElement('plaintext', [], MyDate::formatDate($row[$key]));
                                break;
                            case 'descriptions':
                                $td->appendElement('plaintext', [], $row[$key], true);
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