<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'search(this); return(false);');
$frm->setFormTagAttribute('class', 'form form--small');
$keywordFld = $frm->getField('keyword');
$submitBtn = $frm->getField('btn_submit');
$btnReset = $frm->getField('btn_clear');
$btnReset->addFieldTagAttribute('onclick', 'clearSearch()');
?>
<!-- [ PAGE ========= -->
<!-- <main class="page"> -->
<div class="container container--fixed">
    <div class="page__head">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <h1><?php echo Label::getLabel('LBL_SUBSCRIPTIONS'); ?></h1>
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
                </div>
            </div>
        </div>
        <!-- [ FILTERS ========= -->
        <div class="search-filter slide-target-js">
            <?php echo $frm->getFormTag(); ?>
            <div class="row">
                <div class="col-lg-5 col-sm-12">
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
                                <?php echo $frm->getFieldHtml('btn_submit'); ?>
                                <?php echo $frm->getFieldHtml('btn_clear'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <?php echo $frm->getExternalJS(); ?>
        </div>
        <!-- ] ========= -->
    </div>
    <div class="page__body">
        <!-- [ PAGE PANEL ========= -->
        <div class="page-content" id="listing">
        </div>
        <!-- ] -->
    </div>