<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
if (count($quizzes) == 0) {
    $this->includeTemplate('_partial/no-record-found.php');
    return;
}
?>
<div class="table-scroll">
    <table class="table table--styled table--responsive table--aligned-middle">
        <tr class="title-row">
            <th><?php echo $titleLbl = Label::getLabel('LBL_TITLE'); ?></th>
            <th><?php echo $typeLbl = Label::getLabel('LBL_TYPE'); ?></th>
            <th><?php echo $questionsLbl = Label::getLabel('LBL_NO._OF_QUESTIONS'); ?></th>
            <th><?php echo $durationLbl = Label::getLabel('LBL_DURATION'); ?></th>
            <th><?php echo $attemptsLbl = Label::getLabel('LBL_ATTEMPTS'); ?></th>
            <th><?php echo $passLbl = Label::getLabel('LBL_PASS_PERCENT'); ?></th>
            <th><?php echo $statusLbl = Label::getLabel('LBL_STATUS'); ?></th>
            <th><?php echo $activeLbl = Label::getLabel('LBL_ACTIVE'); ?></th>
            <th><?php echo $dateLbl = Label::getLabel('LBL_DATE'); ?></th>
            <th><?php echo $actionLbl = Label::getLabel('LBL_ACTIONS'); ?></th>
        </tr>
        <?php
        $naLabel = Label::getLabel('LBL_N/A');
        $statuses = Question::getStatuses();
        foreach ($quizzes as $quiz) {
        ?>
            <tr>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $titleLbl; ?></div>
                        <div class="flex-cell__content">
                            <?php echo $quiz['quiz_title']; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $typeLbl; ?></div>
                        <div class="flex-cell__content">
                            <?php echo $types[$quiz['quiz_type']]; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $questionsLbl; ?></div>
                        <div class="flex-cell__content">
                            <?php echo $quiz['quiz_questions']; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $durationLbl; ?></div>
                        <div class="flex-cell__content">
                            <?php echo ($quiz['quiz_duration']) ? MyUtility::convertDuration($quiz['quiz_duration']) : '-'; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $attemptsLbl; ?></div>
                        <div class="flex-cell__content">
                            <?php echo ($quiz['quiz_attempts']) ? $quiz['quiz_attempts'] : '-'; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $passLbl; ?></div>
                        <div class="flex-cell__content">
                            <?php echo ($quiz['quiz_passmark']) ? MyUtility::formatPercent($quiz['quiz_passmark']) : '-'; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $statusLbl; ?></div>
                        <div class="flex-cell__content">
                            <?php echo $status[$quiz['quiz_status']]; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $activeLbl; ?></div>
                        <div class="flex-cell__content">
                            <label class="switch switch--small">
                                <input class="switch__label" data-field-caption="" type="checkbox" name="quiz_active" value="<?php echo $quiz['quiz_active']; ?>" <?php echo ($quiz['quiz_active'] == AppConstant::ACTIVE) ? 'checked="checked"' : '' ?> onchange="updateStatus('<?php echo $quiz['quiz_id']; ?>', this)"> <i class="switch__handle bg-green"></i>
                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $dateLbl; ?></div>
                        <div class="flex-cell__content">
                            <?php echo MyDate::formatDate($quiz['quiz_created']); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex-cell">
                        <div class="flex-cell__label"><?php echo $actionLbl; ?></div>
                        <div class="flex-cell__content">
                            <a href="<?php echo MyUtility::generateUrl('Quizzes', 'form', [$quiz['quiz_id']]) ?>" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon icon--edit icon--small">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#edit'; ?>"></use>
                                </svg>
                                <div class="tooltip tooltip--top bg-black"><?php echo Label::getLabel('LBL_EDIT'); ?></div>
                            </a>
                            <a href="javascript:void(0);" onclick="remove('<?php echo $quiz['quiz_id']; ?>');" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon icon--issue icon--small">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#trash'; ?>"></use>
                                </svg>
                                <div class="tooltip tooltip--top bg-black"><?php echo Label::getLabel('LBL_REMOVE'); ?></div>
                            </a>
                            <a href="javascript:void(0);"  onclick="copyUrl('<?php echo $quiz['quiz_id']; ?>');" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                            <svg class="icon icon--lesson margin-right-2">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#lessons'; ?>"></use>
                            </svg>
                                <div class="tooltip tooltip--top bg-black"><?php echo Label::getLabel('LBL_COPY_URL'); ?></div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<form name="frmQuizLink" method="post" id="frm_fat_id_frmQuizLink" style="display:none;">
    <input type="hidden" name="quilin_record_id" value="401">
    <input type="hidden" name="quilin_user_id" value="<?php echo $siteUserId; ?>">
    <input type="hidden" name="quilin_record_type" value="1">
    <input type="hidden" name="quilin_quiz_id[]" id="quiz_input_id" value="">
</form>
<?php
$pagingArr = [
    'pageSize' => $post['pagesize'],
    'page' => $post['pageno'],
    'recordCount' => $recordCount,
    'pageCount' => ceil($recordCount / $post['pagesize'])
];
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
echo FatUtility::createHiddenFormFromData($post, ['name' => 'frmPaging']);
?>