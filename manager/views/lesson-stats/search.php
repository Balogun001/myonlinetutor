<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');
$flds = array(
    'user_full_name' => Label::getLabel('LBL_USER_DETAILS'),
    'user_type' => Label::getLabel('LBL_USER_TYPE'),
    'rescheduledCount' => Label::getLabel('LBL_RESCHEDULED'),
    'cancelledCount' => Label::getLabel('LBL_CANCELLED'),
    'action' => Label::getLabel('LBL_ACTION')
);
$tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-responsive table--hovered'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}
foreach ($logs as $sn => $row) {
    $tr = $tbl->appendElement('tr');
    foreach ($flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'user_full_name':
                $td->appendElement('plaintext', array(), 'N: ' . $row['user_first_name'] . ' ' . $row['user_last_name'] . '<br> E: ' . $row['user_email'], true);
                break;
            case 'user_type':
                $str = Label::getLabel('LBL_LEARNER');
                if ($row['user_is_teacher']) {
                    $str .= "<br>" . Label::getLabel('LBL_TEACHER');
                }
                $td->appendElement('plaintext', array(), $str, true);
                break;
            case 'action':
                $ul = $td->appendElement("ul", array("class" => "actions actions--centered"));
                $li = $ul->appendElement("li", array('class' => 'droplink'));
                $li->appendElement(
                    'a',
                    array(
                        'href' => 'javascript:void(0)', 'class' => 'button small green',
                        'title' => Label::getLabel('LBL_STATS')
                    ),
                    '<i class="ion-android-more-horizontal icon"></i>',
                    true
                );
                $innerDiv = $li->appendElement('div', array('class' => 'dropwrap'));
                $innerUl = $innerDiv->appendElement('ul', array('class' => 'linksvertical'));
                $innerLiCancelled = $innerUl->appendElement('li');
                $innerLiCancelled->appendElement(
                    'a',
                    array(
                        'href' => "javascript:void(0)", 'class' => 'button small green',
                        'title' => Label::getLabel('LBL_VIEW_RESCHEDULED_REPORT'),
                        "onclick" => "viewLogs(" . $row['user_id'] . ", " . SessionLog::LESSON_RESCHEDULED_LOG . ",1)"
                    ),
                    Label::getLabel('LBL_VIEW_RESCHEDULED_REPORT'),
                    true
                );
                $innerLiCancelled = $innerUl->appendElement('li');
                $innerLiCancelled->appendElement(
                    'a',
                    array(
                        'href' => "javascript:void(0)", 'class' => 'button small green',
                        'title' => Label::getLabel('LBL_VIEW_CANCELLED_REPORT'),
                        "onclick" => "viewLogs(" . $row['user_id'] . ", " . SessionLog::LESSON_CANCELLED_LOG . ",1)"
                    ),
                    Label::getLabel('LBL_VIEW_CANCELLED_REPORT'),
                    true
                );
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
if (count($logs) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($flds)), Label::getLabel('LBL_No_Records_Found'));
}
echo $tbl->getHtml();
echo FatUtility::createHiddenFormFromData($post, array('name' => 'logPaging'));
$pagingArr = array('pageCount' => $pageCount, 'page' => $post['pageno'], 'recordCount' => $recordCount);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
