<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'search(this);return false;');
$keywordFld = $frm->getField('keyword');
$keywordFld->addFieldTagAttribute('placeholder', Label::getLabel('LBL_KEYWORD'));
$statusFld = $frm->getField('grpcls_status');
$durationFld = $frm->getField('grpcls_duration');
$frm->getField('btn_clear')->addFieldTagAttribute('onClick', 'clearSearch();');
$labels = [
    'START_TIME' => Label::getLabel('LBL_START_TIME'),
    'CLASS_TITLE' => Label::getLabel('LBL_CLASS_TITLE'),
    'REMOVE_CLASS' => Label::getLabel('LBL_REMOVE_CLASS')
];
?>
<script>
    labels = <?php echo json_encode($labels); ?>
</script>
<!-- [ PAGE ========= -->
<div class="container container--fixed">
    <div class="page__head">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <h1><?php echo Label::getLabel('LBL_MANAGE_CLASS_PACKAGES'); ?></h1>
				     <?php 
	 if($siteUserType==1)
	 {
	 	//for student
	 ?>
      <div style="flex-grow: 1">
    <a href="<?= $siteUser['user_is_teacher'] ? MyUtility::makeUrl('Teacher') : MyUtility::makeUrl('TeacherRequest', '', [], CONF_WEBROOT_FRONT_URL); ?>" style="float: right" class="ml-4 btn btn--primary">
        <?php echo $siteUser['user_is_teacher'] ? label::getLabel('LBL_Switch_to_Teacher') : Label::getLabel('LBL_BECOME_A_TUTOR'); ?>
    </a>
</div>

	<?php
	}
	?>
    
    <?php 
	 if($siteUserType==2)
	 {
	 	//for teacher
	 ?>
      <div style="flex-grow: 1">
                <a href="<?php echo MyUtility::makeUrl('Learner'); ?>" style="float: right" class="ml-4 btn btn--primary"><?php echo label::getLabel('LBL_Switch_to_Learner'); ?></a>
            </div>

	<?php
	}
	?>
    
            </div>
            <div class="col-sm-auto">
                <div class="buttons-group d-flex align-items-center">
                    <a href="javascript:void(0)" class="btn btn--secondary slide-toggle-js">
                        <svg class="icon icon--search icon--small margin-right-2"><use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#search'; ?>"></use></svg>
                        <?php echo Label::getLabel('LBL_SEARCH'); ?>
                    </a>
                    <?php if ($siteUserType == User::TEACHER) { ?>
                        <a href="javascript:void(0);" onclick="form(0);" class="btn color-secondary btn--bordered margin-left-4">
                            <svg class="icon icon--add icon--small margin-right-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path>
                            </svg>
                            <?php echo Label::getLabel('LBL_ADD_PACKAGE'); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="page__body">
        <!-- [ FILTERS ========= -->
        <div class="page-filter">
            <?php echo $frm->getFormTag(); ?>
            <div class="search-filter slide-target-js" style="display: none;">
                <div class="row">
                    <div class="col-lg-6 col-sm-8">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php echo $keywordFld->getCaption(); ?>
                                    <?php if ($keywordFld->requirement->isRequired()) { ?>
                                        <span class="spn_must_field">*</span>
                                    <?php } ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $keywordFld->getHtml(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4  form-buttons-group">
                        <div class="field-set">
                            <div class="caption-wraper"><label class="field_label"></label></div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('pageno'); ?>
                                    <?php echo $frm->getFieldHtml('pagesize'); ?>
                                    <?php echo $frm->getFieldHtml('grpcls_id'); ?>
                                    <?php echo $frm->getFieldHtml('order_id'); ?>
                                    <?php echo $frm->getFieldHtml('btn_submit'); ?>
                                    <?php echo $frm->getFieldHtml('btn_clear'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <?php echo $frm->getExternalJS(); ?>
        </div>
        <!-- ] ========= -->
        <!-- [ PAGE PANEL ========= -->
        <div class="page-content" id="listing"></div>
        <!-- ] -->
    </div>
    <script>
        $(document).ready(function() {
            search(document.frmClassSearch);
        });
    </script>