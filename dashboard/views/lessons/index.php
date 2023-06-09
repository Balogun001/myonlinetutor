<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 3;
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'search(this);return false;');
$statusFld = $frm->getField('ordles_status');
$viewFld = $frm->getField('view');
$keywordFld = $frm->getField('keyword');
$keywordFld->addFieldTagAttribute('placeholder', Label::getLabel('LBL_KEYWORD'));
$langFld = $frm->getField('ordles_tlang_id');
$startdateFld = $frm->getField('ordles_lesson_starttime');
$startdateFld->addFieldtagAttribute('id', 'ordles_lesson_starttime');
$startdateFld->addFieldtagAttribute('placeholder', Label::getLabel('LBL_START_DATE'));
$enddateFld = $frm->getField('ordles_lesson_endtime');
$enddateFld->addFieldtagAttribute('id', 'ordles_lesson_endtime');
$enddateFld->addFieldtagAttribute('placeholder', Label::getLabel('LBL_END_TIME'));
$frm->getField('btn_clear')->addFieldTagAttribute('onClick', 'clearSearch();');
?>
<!-- [ PAGE ========= -->
<!-- <main class="page"> -->
<div class="container container--fixed">
    <div class="page__head">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12">
                <h1><?php echo Label::getLabel('LBL_MANAGE_LESSONS'); ?></h1>
                <a href="https://www.thelessonspace.com/demo" target="_blank" class="ml-4 btn btn--primary">Start Practicing</a>
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
                    <a href="javascript:void(0)" class="btn btn--secondary slide-toggle-js  d-flex d-sm-none">
                       
                        <?php echo Label::getLabel('LBL_SEARCH'); ?> <svg class="icon icon--search icon--small margin-right-2"><use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#search'; ?>"></use></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page__body">
        <!-- [ INFO BAR ========= -->
        <div id="upcomingLesson"></div>
        <!-- ] -->
        <!-- [ FILTERS ========= -->
        <div class="page-filter">
            <?php echo $frm->getFormTag(); ?>
            <div class="switch-controls">
                <div class="switch-controls__colum-left">
                    <div class="switch-ui">
                        <ul>
                            <?php foreach ($statusFld->options as $value => $label) { ?>
                                <li>
                                    <label class="switch-ui__item">
                                        <input type="radio" class="switch-ui__input" onchange="search(this.form);" name="<?php echo $statusFld->getName(); ?>" value="<?php echo $value; ?>" <?php echo ($statusFld->value == $value) ? "checked" : ""; ?> />
                                        <span class="switch-ui__label"><?php echo $label; ?></span>
                                    </label>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="switch-controls__colum-right">
                    <div class="switch-ui switch-ui--icons">
                        <ul>
                            <li>
                                <label class="switch-ui__item">
                                    <input type="radio" class="switch-ui__input" onchange="search(this.form);" name="<?php echo $viewFld->getName(); ?>" value="<?php echo AppConstant::VIEW_LISTING; ?>" <?php echo ($viewFld->value == AppConstant::VIEW_LISTING) ? 'checked' : ''; ?> />
                                    <span class="switch-ui__label">
                                        <svg class="icon icon--view icon--small margin-right-2"><use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#lesson-view'; ?>"></use></svg>
                                        <?php echo $viewFld->options[AppConstant::VIEW_LISTING]; ?>
                                    </span>
                                </label>
                            </li>
                            <li>
                                <label class="switch-ui__item">
                                    <input type="radio" class="switch-ui__input" onchange="search(this.form);" name="<?php echo $viewFld->getName(); ?>" value="<?php echo AppConstant::VIEW_CALENDAR; ?>" <?php echo ($viewFld->value == AppConstant::VIEW_CALENDAR) ? 'checked' : ''; ?> />
                                    <span class="switch-ui__label">
                                        <svg class="icon icon--calendar margin-right-1"><use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#calendar'; ?>"></use></svg>
                                        <?php echo $viewFld->options[AppConstant::VIEW_CALENDAR]; ?>
                                    </span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="search-filter slide-target-js">
                <div class="row">
                    <div class="col-lg-3 col-sm-12">
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
                    <div class="col-lg-2 col-sm-12">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php echo $langFld->getCaption(); ?>
                                    <?php if ($langFld->requirement->isRequired()) { ?>
                                        <span class="spn_must_field">*</span>
                                    <?php } ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $langFld->getHtml(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php echo $startdateFld->getCaption(); ?>
                                    <?php if ($startdateFld->requirement->isRequired()) { ?>
                                        <span class="spn_must_field">*</span>
                                    <?php } ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $startdateFld->getHtml(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php echo $enddateFld->getCaption(); ?>
                                    <?php if ($enddateFld->requirement->isRequired()) { ?>
                                        <span class="spn_must_field">*</span>
                                    <?php } ?>
                                </label>
                            </div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $enddateFld->getHtml(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4  form-buttons-group">
                        <div class="field-set">
                            <div class="caption-wraper"><label class="field_label"></label></div>
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('order_id'); ?>
                                    <?php echo $frm->getFieldHtml('pageno'); ?>
                                    <?php echo $frm->getFieldHtml('pagesize'); ?>
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
        const VIEW_CALENDAR = <?php echo AppConstant::VIEW_CALENDAR ?>;
        const VIEW_LISTING = <?php echo AppConstant::VIEW_LISTING ?>;
        $(document).ready(function () {
            search(document.frmLessonSearch);
            upcoming();
        });
    </script>