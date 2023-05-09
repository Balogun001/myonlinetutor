<div class="container container--fixed">
    <div class="page__head">
        <h1><?php echo Label::getLabel('LBL_MANAGE_CALENDAR'); ?></h1>
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
    <div class="page__body">
        <!-- [ INFO BAR ========= -->
        <div class="infobar">
            <div class="row justify-content-between align-items-start">
                <div class="col-lg-8 col-sm-8">
                    <div class="d-flex">
                        <div class="infobar__media margin-right-5">
                            <div class="infobar__media-icon infobar__media-icon--alert is-profile-complete-js">!</div>
                        </div>
                        <div class="infobar__content">
                            <h6 class="margin-bottom-1"><?php echo Label::getLabel('LBL_COMPLETE_YOUR_PROFILE'); ?></h6>
                            <p class="margin-0"> <?php echo Label::getLabel('LBL_PROFILE_INFO_HEADING'); ?>
                                <a href="javascript:void(0)" class="color-secondary underline padding-top-3 padding-bottom-3 expand-js"><?php echo Label::getLabel('LBL_LEARN_MORE'); ?></a>
                            </p>
                            <div class="infobar__content-more margin-top-3 expand-target-js" style="display: none;">
                                <?php echo ExtraPage::getBlockContent(ExtraPage::BLOCK_PROFILE_INFO_BAR, $siteLangId); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4">
                    <div class="profile-progress margin-top-2">
                        <div class="profile-progress__meta margin-bottom-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div><span class="small"> <?php echo Label::getLabel('LBL_PROFILE_PROGRESS'); ?></span></div>
                                <div><span class="small bold-700 progress-count-js"></span></div>
                            </div>
                        </div>
                        <div class="profile-progress__bar">
                            <div class="progress progress--small progress--round">
                                <div class="progress-bar">
                                    <div class="progress__step"></div>
                                    <div class="progress__step"></div>
                                    <div class="progress__step"></div>
                                    <div class="progress__step"></div>
                                    <div class="progress__step"></div>
                                    <div class="progress__step"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ] -->
        <!-- [ PAGE PANEL ========= -->
        <div class="page-panel" style="min-height: 400px;" id="availability-calendar-js">
        </div>
        <!-- ] -->
    </div>
    <script>
        generalAvailability();
    </script>