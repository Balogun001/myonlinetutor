<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$types = Quiz::getTypes();
$status = QuizAttempt::getStatuses();
?>
<div class="facebox-panel">
    <div class="facebox-panel__head padding-bottom-6">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h6><?php echo Label::getLabel('LBL_ATTACHED_QUIZZES'); ?></h6>
            </div>
        </div>
    </div>
    <div class="facebox-panel__body padding-0 overflow-visible">
        <div class="table-scroll">
            <table class="table table--styled table--responsive table--bordered">
                <thead>
                    <tr class="title-row">
                        <th><?php echo Label::getLabel('LBL_ID'); ?></th>
                        <th><?php echo Label::getLabel('LBL_TITLE'); ?></th>
                        <th><?php echo Label::getLabel('LBL_TYPE'); ?></th>
                        <th><?php echo Label::getLabel('LBL_VALID_TILL'); ?></th>
                        <th><?php echo Label::getLabel('LBL_STATUS'); ?></th>
                        <th><?php echo Label::getLabel('LBL_ACTION'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($quizzes) > 0) { ?>
                        <?php foreach ($quizzes as $quiz) {
                            $expired = false;
                            $target = 'target="_blank"';
                            if (strtotime(date('Y-m-d H:i:s')) >= strtotime($quiz['quilin_validity'])) {
                                $expired = true;
                            }
                            $url = MyUtility::makeFullUrl('UserQuiz', 'index', [$quiz['users']['quizat_id']]);
                            if ($quiz['users']['quizat_status'] == QuizAttempt::STATUS_COMPLETED) {
                                $url = MyUtility::makeFullUrl('UserQuiz', 'completed', [$quiz['users']['quizat_id']]);
                            } elseif ($quiz['users']['quizat_status'] == QuizAttempt::STATUS_IN_PROGRESS) {
                                $url = MyUtility::makeFullUrl('UserQuiz', 'questions', [$quiz['users']['quizat_id']]);
                            } elseif ($quiz['users']['quizat_status'] == QuizAttempt::STATUS_CANCELED || $expired == true) {
                                $url = "javascript:void(0);";
                                $target = "";
                            }
                        ?>
                            <tr>
                                <td>
                                    <?php
                                    $label = Label::getLabel('LBL_QZ{quiz-id}');
                                    $str = str_pad($quiz['quilin_quiz_id'], 3, "0", STR_PAD_LEFT) . '-' . $quiz['users']['quizat_id'];
                                    echo str_replace('{quiz-id}', $str, $label);
                                    ?>
                                </td>
                                <td>
                                    <?php echo $quiz['quilin_title'] ?>
                                </td>
                                <td><?php echo $types[$quiz['quilin_type']] ?></td>
                                <td>
                                    <?php
                                    if ($expired == true) {
                                        echo Label::getLabel('LBL_EXPIRED');
                                    } else {
                                        echo MyDate::formatDate($quiz['quilin_validity']);
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $status[$quiz['users']['quizat_status']] ?>
                                </td>
                                <td>
                                    <a <?php echo $target ?> href="<?php echo $url; ?>" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover <?php echo empty($target) ? 'btn--disabled' : '' ?>" style="background:none;border:none;box-shadow: none;">
                                        <!--svg class="icon icon--cancel icon--small">
                                            <use xlink:href="<?php echo CONF_WEBROOT_DASHBOARD ?>images/sprite.svg#view"></use>
                                        </svg>
                                        <div class="tooltip tooltip--top bg-black">
                                            <?php echo Label::getLabel('LBL_VIEW'); ?>
                                        </div-->
										Start a quiz
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6"><?php $this->includeTemplate('_partial/no-record-found.php'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>