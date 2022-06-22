<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php

$arr_flds = [
    'listserial' => Label::getLabel('LBL_SRNO'),
    'testimonial_identifier' => Label::getLabel('LBL_Testimonial_Identifier'),
    'testimonial_text' => Label::getLabel('LBL_Testimonial_Content'),
    'testimonial_active' => Label::getLabel('LBL_Status'),
];
if ($canEdit) {
    $arr_flds['action'] = Label::getLabel('LBL_Action');
}
$tbl = new HtmlElement('table', ['width' => '100%', 'class' => 'table table-responsive table--hovered']);
$th = $tbl->appendElement('thead')->appendElement('tr');
$activeLabel = Label::getLabel('LBL_ACTIVE');
$inactiveLabel = Label::getLabel('LBL_INACTIVE');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', [], $val);
}
$sr_no = 0;
foreach ($arr_listing as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr');
    $tr->setAttribute("id", $row['testimonial_id']);
    if ($row['testimonial_active'] != AppConstant::ACTIVE) {
        /* $tr->setAttribute ("class","fat-inactive"); */
    }
    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', [], $sr_no);
                break;
            case 'testimonial_active':
                $active = "";
                $statusAct = 'activeStatus(this)';
                if ($row['testimonial_active'] == AppConstant::ACTIVE) {
                    $active = 'active';
                    $statusAct = 'inactiveStatus(this)';
                }
                if ($row['testimonial_active'] == AppConstant::INACTIVE) {
                    $statusAct = 'activeStatus(this)';
                }
                $statusClass = '';
                if ($canEdit === false) {
                    $statusClass = "disabled";
                    $statusAct = '';
                }
                $str = '<label id="' . $row['testimonial_id'] . '" class="statustab status_' . $row['testimonial_id'] . ' ' . $active . '" onclick="' . $statusAct . '">
                        <span data-off="' . $activeLabel . '" data-on="' . $inactiveLabel . '" class="switch-labels"></span>
                        <span class="switch-handles ' . $statusClass . '"></span>
                    </label>';
                $td->appendElement('plaintext', [], $str, true);
                break;
            case 'action':
                $ul = $td->appendElement("ul", ["class" => "actions actions centered"]);
                if ($canEdit) {
                    //$li = $ul->appendElement("li");
                    $li = $ul->appendElement("li", ['class' => 'droplink']);
                    $li->appendElement('a', ['href' => 'javascript:void(0)', 'class' => 'button small green', 'title' => Label::getLabel('LBL_Edit')], '<i class="ion-android-more-horizontal icon"></i>', true);
                    $innerDiv = $li->appendElement('div', ['class' => 'dropwrap']);
                    $innerUl = $innerDiv->appendElement('ul', ['class' => 'linksvertical']);
                    $innerLiEdit = $innerUl->appendElement('li');
                    $innerLiEdit->appendElement('a', ['href' => 'javascript:void(0)', 'class' => 'button small green',
                        'title' => Label::getLabel('LBL_Edit'), "onclick" => "editTestimonialFormNew(" . $row['testimonial_id'] . ")"], Label::getLabel('LBL_Edit'),
                            true);
                    $innerLiDelete = $innerUl->appendElement("li");
                    $innerLiDelete->appendElement('a', ['href' => 'javascript:void(0)', 'class' => 'button small green',
                        'title' => Label::getLabel('LBL_Delete'), "onclick" => "deleteRecord(" . $row['testimonial_id'] . ")"], Label::getLabel('LBL_Delete'),
                            true);
                }
                break;
            default:
                $td->appendElement('plaintext', [], $row[$key], true);
                break;
        }
    }
}
if (count($arr_listing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', ['colspan' => count($arr_flds)], Label::getLabel('LBL_No_Records_Found'));
}
echo $tbl->getHtml();
