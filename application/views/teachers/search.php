<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$sorting = AppConstant::getSortbyArr();
$hourStringLabel = Label::getLabel('LBL_{hourstring}_HRS');
$offerPriceLabel = Label::getLabel('LBL_{percentages}%_OFF_ON_{duration}_MINUTES_SESSION');
$colorClass = [1 => 'cell-green-40', 2 => 'cell-green-60', 3 => 'cell-green-80', 4 => 'cell-green-100'];
?>
<style>
     .box__primary{
        padding-left: 0;
        padding-top: 0;
        padding-bottom: 0;
        display: flex;
        flex-wrap: wrap;
    }
    .box-wrapper .box.box-list{
        border: 1px solid #D0D5DD;
        border-radius: 10px;
        box-shadow: none;
    }
    .list__head .list__media{
        margin-bottom:0;
    }
    .list__head .list__media .avtar{
        width: 340px;
        height: 100%;
        background: transparent;
    }
    .list__body{
        padding-top: 55px;
    }
    .tutor-name h4 {
        font-weight: 700;
        font-size: 38px;
        line-height: 48px;
        display: flex;
        align-items: center;
    }
    .tutor-name h4 img {
        margin-left: 23px;
    }
    .avtar img.teacher-photo {
        background-position: top center;
        background-repeat: no-repeat;
        background-size: 100%;
        border-radius: 10px 0 0 10px;
    }
    .list__head .list__media .avtar a {
        height: 100%;
        width: 100%;
    }
    .info-wrapper .info-tag .value{
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
    }
    .info-wrapper .info-tag span{
        font-weight: 300;
        font-size: 14px;
        line-height: 22px;
        opacity: 1;
    }
    .list__price {
        font-weight: 300;
        font-size: 16px;
        line-height: 24px;
    }
    .info-tag.location {
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        color: #000000;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .info-tag.location .flag {
        margin-left: 20px;
    }
    .about__detail p{
        display: inline;
    }
    .about__detail a{
        font-weight: 400;
        font-size: 15px;
        line-height: 14px;
        color: #FF5200;
    }
    .about__detail{
        margin-bottom: 20px;
        font-weight: 400;
        font-size: 18px;
        line-height: 28px;
    }
    .list__action {
        display: flex;
        max-width: 100%;        
        margin-bottom: 20px;
    }
    .list__action .list__action-btn {
        display: flex;
    }
    .list__action .list__action-btn a.btn.btn-book-now,
    .list__action .list__action-btn a.btn--trial,
    .list__action .list__action-btn a.btn-contact {
        border-radius: 8px;
        padding: 11px 34px;
        height: auto;
        font-weight: 600;
        font-size: 20px;
        line-height: 26px;
        margin: 0;
        margin-right: 10px;
    }
    .list__action .list__action-btn a.btn.btn-book-now {
        background: #FF5200;
  
    }
    .list__action .list__action-btn a.btn.btn-book-now:hover{
        background-color: var(--color-primary);
    }
    .list__action .list__action-btn a.btn--trial{
        background: #2765F1;
       
    }
    .list__action .list__action-btn a.btn--trial:hover{
        background: #FF5200;
    }
    .list__action .list__action-btn a.btn-contact{
        border: 1px solid #2765F1 !important;
        color: #2765F1 !important;
        margin-right: 0;
    }
    .list__action .list__action-btn a.btn-contact:hover{
        background-color: var(--color-primary) !important;
        border: 1px solid var(--color-primary) !important;
        color: #fff !important;
    }
    .list__head .list__media{
        height: 100%;
    }
    .custom-calendar tbody td .cell-green-100 {
        background-color: #009444;
    }
    .custom-calendar tbody td .cell-green-80 {
        background-color: #009444;
    }
    .custom-calendar tbody td .cell-green-60 {
        background-color: #009444; 
    }
    .custom-calendar tbody td .cell-green-40 {
        background-color: #009444; 
    }
    .panel-box .panel-box__head{
        border-bottom: none;
    }
    .panel-box .panel-box__head ul li .panel-action{
        font-weight: 700;
        font-size: 24px;
        line-height: 30px;
        color: #858585;
        height: auto;
    }
    .panel-box .panel-box__head ul .is--active .panel-action{
        color: #FF5200;
    }
    .panel-box .panel-box__head ul .is--active::before{
        display: none;
    }
    .custom-calendar tbody td:first-child .cal-cell{
        font-weight: 500;
        font-size: 13px;
        line-height: 22px;
        color: #545454;
    }
    .box__secondary {
        padding-top: 65px;
    }
    @media (min-width: 767px){
        .list__head {
            max-width: 340px;
            
        }
        .list__body {
            max-width: calc(100% - 180px);
            min-width: calc(100% - 180px);
        }
        .list__body {
            max-width: calc(100% - 380px);
            min-width: calc(100% - 380px);
            padding-left: 40px;
       }
    }
    @media (min-width: 1550px){
        .box__secondary {
            width: 500px;
            padding-top: 65px;
        }
        .box__primary {
            width: calc(100% - 500px);
        }
    }

    @media(max-width:1700px){
        .list__action .list__action-btn a.btn.btn-book-now, .list__action .list__action-btn a.btn--trial, .list__action .list__action-btn a.btn-contact{
            padding: 10px;
            font-size: 16px;
           
        }
    }

    @media(max-width: 1440px){
        .list__action .list__action-btn a.btn.btn-book-now, .list__action .list__action-btn a.btn--trial, .list__action .list__action-btn a.btn-contact{
            padding: 8px 15px;
            font-size: 14px;  
        }
        .about__detail{
            font-size: 16px;
            line-height: 25px;
        }
        .section-filters h1{
            font-size: 35px;
            line-height: 45px;
        }
        .list__action,.list__action .list__action-btn{
            flex-wrap: wrap;
        }
        .section-filters {
            background-color: #fff;
        }
        .list__action .list__action-btn a.btn.btn-book-now, .list__action .list__action-btn a.btn--trial, .list__action .list__action-btn a.btn-contact{
            margin-right:0;
            margin-bottom: 5px;
        }

    }

    @media(min-width: 991px) and (max-width: 1440px){
        .box__secondary {
            width: 420px;
        }
        .box__primary {
            width: calc(100% - 420px);
        }
    }

    @media(max-width: 1200px){
        .section-filters h1 {
            font-size: 26px;
            line-height: 32px;
        }
        .tutor-name h4{
            font-size: 30px;
            line-height: 40px;
        }
        .filter-item__select{
            white-space: nowrap;
        }
        .box-wrapper .list__action {
            display: none;
        }
        .box-wrapper .list__body .list__action {
            display: block;
        }
    }

    @media(max-width: 767px){
        .tutor-name h4 img{
            max-width: 15px;
            height: auto;
        }
        .list__body{
            padding-left: 15px;
            width: 100%;
        }
        .list__head {
            float: none;
            clear: none;
            margin: 0 auto;
        }
        .list__head .list__media .avtar{
            width: 300px;
        }
        .avtar img.teacher-photo{
            border-radius: 10px;
        }
        .box__primary{
            padding-top: 15px;
        }
        .tutor-name h4{
            width: 100%;
        }
    
    }

</style>
<div class="page-listing__head">
    <div class="row justify-content-between align-items-center">
        <div class="col-sm-8">
            <h4><?php echo str_replace('{recordcount}', $recordCount, Label::getLabel('LBL_FOUND_THE_BEST_{recordcount}_TEACHERS_FOR_YOU')) ?></h4>
        </div>
        <div class="col-xl-auto col-sm-auto">
            <div class="sorting-options">
                <div class="sorting-options__item">
                    <div class="sorting-action">
                        <div class="sorting-action__trigger sort-trigger-js" onclick="toggleSort();">
                            <svg class="svg-icon" viewBox="0 0 16 12.632">
                                <path d="M7.579 9.263v1.684H0V9.263zm1.684-4.211v1.684H0V5.053zM7.579.842v1.684H0V.842zM13.474 12.632l-2.527-3.789H16z"></path>
                                <path d="M12.632 2.105h1.684v7.579h-1.684z"></path>
                                <path d="M13.473 0L16 3.789h-5.053z"></path>
                            </svg>
                            <span class="sorting-action__label"><?php echo Label::getLabel('LBL_SORT_BY'); ?>:</span>
                            <span class="sorting-action__value"><?php echo $sorting[$post['sorting']]; ?></span>
                        </div>
                        <div class="sorting-action__target sort-target-js" style="display: none;">
                            <div class="filter-dropdown">
                                <div class="select-list select-list--vertical select-list--scroll">
                                    <ul>
                                        <?php foreach ($sorting as $id => $name) { ?>
                                            <li>
                                                <label class="select-option">
                                                    <input class="select-option__input" type="radio" name="sorts" value="<?php echo $id; ?>" <?php echo ($id == $post['sorting']) ? 'checked' : ''; ?> onclick="sortsearch(this.value);" />
                                                    <span class="select-option__item"><?php echo $name; ?></span>
                                                </label>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sorting-options__item">
                    <div class="btn btn--filters" onclick="openFilter()">
                        <span class="svg-icon">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 402.577 402.577" style="enable-background:new 0 0 402.577 402.577;" xml:space="preserve">
                                <g>
                                    <path d="M400.858,11.427c-3.241-7.421-8.85-11.132-16.854-11.136H18.564c-7.993,0-13.61,3.715-16.846,11.136
                                          c-3.234,7.801-1.903,14.467,3.999,19.985l140.757,140.753v138.755c0,4.955,1.809,9.232,5.424,12.854l73.085,73.083
                                          c3.429,3.614,7.71,5.428,12.851,5.428c2.282,0,4.66-0.479,7.135-1.43c7.426-3.238,11.14-8.851,11.14-16.845V172.166L396.861,31.413
                                          C402.765,25.895,404.093,19.231,400.858,11.427z"></path>
                                </g>
                            </svg>
                        </span>
                        <?php echo Label::getLabel('LBL_FILTERS'); ?>
                        <?php
                        $count = 0;
                        foreach ($post as $field) {
                            if (is_array($field)) {
                                $count += count($field);
                            }
                        }
                        if ($count > 0) {
                        ?>
                            <span class="filters-count"><?php echo $count; ?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (count($teachers)) { ?>
    <div class="page-listing__body">
        <div class="box-wrapper">
            <?php foreach ($teachers as $teacher) { ?>
                <div class="box box-list">
                    <div class="box__primary">
                        <div class="list__head">
                            <div class="list__media ">
                                <div class="avtar avtar--centered" data-title="<?php echo CommonHelper::getFirstChar($teacher['user_first_name']); ?>">
                                    <a href="<?php echo MyUtility::makeUrl('teachers', 'view', [$teacher['user_username']]) ?>">
                                        <img src="/images/0.gif" style="background-image: url(<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('Image', 'show', [Afile::TYPE_USER_PROFILE_IMAGE, $teacher['user_id'], Afile::SIZE_MEDIUM]), CONF_DEF_CACHE_TIME, '.' . current(array_reverse(explode(".", $teacher['user_photo'])))); ?>)"  alt="<?php echo $teacher['user_first_name'] . ' ' . $teacher['user_last_name']; ?>" class="teacher-photo" width="340" height="432">
                                    </a>
                                </div>
                            </div>
                           
                        </div>
                        <div class="list__body">
                            <div class="profile-detail">
                                <div class="profile-detail__head">
                                    <a href="<?php echo MyUtility::makeUrl('teachers', 'view', [$teacher['user_username']]) ?>" class="tutor-name">
                                        <h4><?php echo $teacher['user_first_name'] . ' ' . $teacher['user_last_name']; ?> <img src="/images/category-filter.png" width="18" height="22px"> </h4>
                                        
                                    </a>
                                    <?php if (!empty($teacher['offers'])) { ?>
                                        <?php $this->includeTemplate('_partial/offers.php', ['offers' => $teacher['offers'], 'offerPriceLabel' => $offerPriceLabel], false); ?>
                                    <?php } ?>
                                    <div class="follow ">
                                        <a class="<?php echo ($teacher['uft_id']) ? 'is--active' : ''; ?>" onClick="toggleTeacherFavorite(<?php echo $teacher['user_id']; ?>, this)" href="javascript:void(0)">
                                            <svg class="icon icon--heart">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#heart'; ?>"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="profile-detail__body">
                                    <div class="info-wrapper">
                                        <div class="info-tag ratings">
                                            <span class="value"><?php echo FatUtility::convertToType($teacher['testat_ratings'], FatUtility::VAR_FLOAT); ?></span>

                                            <svg class="icon icon--rating">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#rating'; ?>"></use>
                                            </svg>
                                            
                                            <span class="count">(<?php echo $teacher['testat_reviewes']; ?>)</span>
                                        </div>
                                        <div class="list__price">
                                            <?php echo MyUtility::formatMoney($teacher['testat_minprice']) . ' - ' . MyUtility::formatMoney($teacher['testat_maxprice']); ?>
                                        </div>
                                        <!-- <div class="info-tag list-count">
                                            <div class="total-count"><span class="value"><?php //echo $teacher['testat_students']; ?></span><?php //echo Label::getLabel('LBL_Students'); ?></div> -
                                            <div class="total-count"><span class="value"><?php //echo $teacher['testat_lessons'] + $teacher['testat_classes']; ?></span><?php //echo Label::getLabel('LBL_Sessions'); ?></div>
                                        </div> -->
                                    </div>
                                    <div class="info-tag location">
                                            <span class="lacation__name"><?php echo $teacher['user_country_name']; ?></span>
                                            <div class="flag">
                                                <img src="<?php echo CONF_WEBROOT_FRONTEND . 'flags/' . strtolower($teacher['user_country_code']) . '.svg'; ?>" alt="<?php echo $teacher['user_country_name']; ?>" style="height: 22px;border: 1px solid #000;" />
                                            </div>
                                    </div>
                                    <div class="tutor-info">
                                         <!--div class="tutor-info__inner tutor-lang">
                                             <div class="info__title">
                                                <h6><?php echo Label::getLabel('LBL_Teaches'); ?></h6>
                                            </div>
											<?php
                                $arrayteacherTeachLanguageName = explode(',', $teacher['teacherTeachLanguageName']);
                            ?>
                            
											 <?php 
												for($i=0;$i<count($arrayteacherTeachLanguageName);$i++){
													echo "<span>".$arrayteacherTeachLanguageName[$i]."</span>";
												}
											?>
                                            <!--div class="info__language">
                                                <?php echo $teacher['teacherTeachLanguageName']; ?>
                                            </div> 
                                        </div-->
						 <?php $arrayteacherTeachLanguageName = explode(',', $teacher['teacherTeachLanguageName']); ?>
                            
								<div class="tutor-lang"><b><?php echo Label::getLabel('LBL_TEACHES:'); ?></b> <?php //echo $teacher['teacherTeachLanguageName']; ?>
								<div class="flex-wrap-wrapper">
									<?php 
										for($i=0;$i<count($arrayteacherTeachLanguageName);$i++){
											echo "<span>".$arrayteacherTeachLanguageName[$i]."</span>";
										}
									?>
								</div>
								</div>
								<?php $arrayteacherTeachLanguageName = explode(',', $teacher['spoken_language_names']); ?>
								<div class="tutor-lang"><b><?php echo Label::getLabel('LBL_Speaks:'); ?></b> <?php //echo $teacher['teacherTeachLanguageName']; ?>
								<div class="flex-wrap-wrapper">
									<?php 
										for($i=0;$i<count($arrayteacherTeachLanguageName);$i++){
											echo "<span>".$arrayteacherTeachLanguageName[$i]."</span>";
										}
									?>
								</div>
								</div>
                                        <!--div class="tutor-info__inner">
                                            <div class="info__title">
                                                <h6><?php echo Label::getLabel('LBL_Speaks'); ?></h6>
                                            </div>
                                            <div class="info__language">
                                                <?php echo $teacher['spoken_language_names']; ?>
                                            </div>
                                        </div--> 
                                        <div class="tutor-info__inner info--about">
                                            <!-- <div class="info__title">
                                                <h6><?php // echo LABEL::getLabel('LBL_About'); ?></h6>
                                            </div> -->
                                            <div class="about__detail">
											
                                                <!--p><?php echo $teacher['user_biography'] ?></p-->
												<?php if($teacher['user_biography']){ ?>
													<p><?php echo substr($teacher['user_biography'],0,300); ?></p>
													<a href="<?php echo MyUtility::makeUrl('teachers', 'view', [$teacher['user_username']]) ?>">Read More..</a>
												<?php } ?>
                                            </div>
                                        </div>

                                        <div class="list__action">
                                            <div class="list__action-btn">
                                                <!-- <a href="javascript:void(0);" onclick="cart.gradeSelection('<?php echo $teacher['user_id']; ?>', '', '')" class="btn btn--primary btn--block btn-book-now"><?php echo Label::getLabel('LBL_Book_Now'); ?></a> -->
                                                <a href="javascript:void(0);" onclick="cart.gradeSelection_checkbtn('<?php echo $teacher['user_id']; ?>', '', '','book_tutor')" class="btn btn--primary btn--block btn-book-now">Book Tutor</a>
                                                <?php
                                                if ($teacher['free_trial_enabled']) {
                                                    $btnText = "LBL_FREE_TRIAL_AVAILED";
                                                    $onclick = "";
                                                    $btnClass = "btn-secondary";
                                                    $disabledText = "disabled";
                                                    if (!$teacher['free_trial_availed']) {
                                                        $disabledText = "";
                                                        $onclick = "onclick=\"cart.trailCalendar('" . $teacher['user_id'] . "')\"";
                                                        $btnClass = 'btn-primary';
                                                        $btnText = "LBL_BOOK_FREE_TRIAL";
                                                    }
                                                    if ($siteUserId == $teacher['user_id']) {
                                                        $onclick = "";
                                                        $disabledText = "disabled";
                                                    }
                                                ?>
                                                    <!-- <a href="javascript:void(0);" <?php echo $onclick; ?> class="btn btn--primary btn--trial btn--block color-white <?php echo $btnClass . ' ' . $disabledText; ?> " <?php echo $disabledText; ?>>
                                                        <span><?php echo Label::getLabel($btnText); ?></span>
                                                    </a> -->
                                                    <!--a href="javascript:void(0);" <?php echo $onclick; ?> class="btn btn--primary btn--trial btn--block color-white <?php echo $btnClass . ' ' . $disabledText; ?> " <?php echo $disabledText; ?>>
                                                        <span>Book Trial Lesson</span>
                                                    </a-->
													<a href="javascript:void(0);" onclick="cart.gradeSelection_checkbtn('<?php echo $teacher['user_id']; ?>', '', '','book_trial')" class="btn btn--primary btn--trial btn--block color-white <?php echo $btnClass . ' ' . $disabledText; ?> " <?php echo $disabledText; ?>>
                                                        <span>Book Trial Lesson</span>
                                                    </a>
                                                <?php } ?>
                                                <!-- <a href="javascript:void(0);" onclick="generateThread(<?php echo $teacher['user_id']; ?>);" class="btn btn--bordered color-primary btn--block btn-contact">
                                                    <svg class="icon icon--envelope">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#envelope'; ?>"></use>
                                                    </svg>
                                                    <?php echo Label::getLabel('LBL_Contact'); ?>
                                                </a> -->
                                                <a href="javascript:void(0);" onclick="generateThread(<?php echo $teacher['user_id']; ?>);" class="btn btn--bordered color-primary btn--block btn-contact">Contact Tutor</a>
                                            </div>
                                            <a href="javascript:void(0);" onclick="viewCalendar(<?php echo $teacher['user_id']; ?>, 'paid')" class="link-detail"><?php echo Label::getLabel('LBL_View_Full_availability'); ?></a>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list__action">
                            <a href="javascript:void(0);" onclick="viewCalendar(<?php echo $teacher['user_id']; ?>, 'paid')" class="link-detail"><?php echo Label::getLabel('LBL_View_Full_availability'); ?></a>
                        </div>
                    </div>
                    <div class="box__secondary">
                        <div class="panel-box">
                            <div class="panel-box__head">
                                <ul>
                                    <li class="is--active">
                                        <a class="panel-action" content="calender" href="javascript:void(0)"><?php echo Label::getLabel('LBL_Availability'); ?></a>
                                    </li>
                                    <?php if (!empty($teacher['user_video_link'])) { ?>
                                        <li>
                                            <!-- <a class="panel-action" content="video" href="javascript:void(0)"><?php //echo Label::getLabel('LBL_Introduction'); ?></a> -->
                                            <a class="panel-action" content="video" href="javascript:void(0)">Intro Video</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="panel-box__body">
                                <div class="panel-content calender">
                                    <div class="custom-calendar">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th><?php echo Label::getLabel('LBL_Sun'); ?></th>
                                                    <th><?php echo Label::getLabel('LBL_Mon'); ?></th>
                                                    <th><?php echo Label::getLabel('LBL_Tue'); ?></th>
                                                    <th><?php echo Label::getLabel('LBL_Wed'); ?></th>
                                                    <th><?php echo Label::getLabel('LBL_Thu'); ?></th>
                                                    <th><?php echo Label::getLabel('LBL_Fri'); ?></th>
                                                    <th><?php echo Label::getLabel('LBL_Sat'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $timeslots = $teacher['testat_timeslots'] ?? AppConstant::getEmptyDaySlots(); ?>
                                                <?php foreach ($slots as $index => $slot) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="cal-cell"><?php echo $slot; ?></div>
                                                        </td>
                                                        <?php
                                                        foreach ($timeslots as $day => $hours) {
                                                        ?>
                                                            <?php
                                                            if (!empty($hours[$index])) {
                                                                $hourString = MyDate::getHoursMinutes($hours[$index]);
                                                                $hour = str_replace(":", '.', $hourString);
                                                                $hour = (ceil(FatUtility::float($hour)));
                                                                $hour = ($hour == 0) ? 1 : $hour;
                                                                $hourString = str_replace('{hourstring}', $hourString, $hourStringLabel);
                                                            }
                                                            ?>
                                                            <td class="is-hover">
                                                                <?php if (!empty($hours[$index])) { ?>
                                                                    <div class="cal-cell <?php echo $colorClass[$hour]; ?>"></div>
                                                                    <div class="tooltip tooltip--top bg-black"><?php echo $hourString; ?></div>
                                                                <?php } else { ?>
                                                                    <div class="cal-cell"></div>
                                                                <?php } ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <a href="javascript:void(0);" onclick="viewCalendar(<?php echo $teacher['user_id']; ?>, 'paid')" class="link-detail"><?php echo Label::getLabel('LBL_View_Full_availability'); ?></a>
                                    </div>
                                </div>
                                <?php if (!empty($teacher['user_video_link'])) { ?>
                                    <div class="panel-content video" data-src="<?php echo $teacher['user_video_link']; ?>" style="display:none;">
                                        <iframe width="100%" height="100%" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="show-more">
                <?php
                echo FatUtility::createHiddenFormFromData($post, ['name' => 'frmSearchPaging']);
                $pagingArr = ['page' => $post['pageno'], 'pageCount' => $pageCount, 'recordCount' => $recordCount, 'callBackJsFunc' => 'gotoPage'];
                $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
                ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="page-listing__body">
        <div class="box -padding-30" style="margin-bottom: 30px;">
            <div class="message-display">
                <div class="message-display__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 408">
                        <path d="M488.468,408H23.532A23.565,23.565,0,0,1,0,384.455v-16.04a15.537,15.537,0,0,1,15.517-15.524h8.532V31.566A31.592,31.592,0,0,1,55.6,0H456.4a31.592,31.592,0,0,1,31.548,31.565V352.89h8.532A15.539,15.539,0,0,1,512,368.415v16.04A23.565,23.565,0,0,1,488.468,408ZM472.952,31.566A16.571,16.571,0,0,0,456.4,15.008H55.6A16.571,16.571,0,0,0,39.049,31.566V352.891h433.9V31.566ZM497,368.415a0.517,0.517,0,0,0-.517-0.517H287.524c0.012,0.172.026,0.343,0.026,0.517a7.5,7.5,0,0,1-7.5,7.5h-48.1a7.5,7.5,0,0,1-7.5-7.5c0-.175.014-0.346,0.026-0.517H15.517a0.517,0.517,0,0,0-.517.517v16.04a8.543,8.543,0,0,0,8.532,8.537H488.468A8.543,8.543,0,0,0,497,384.455h0v-16.04ZM63.613,32.081H448.387a7.5,7.5,0,0,1,0,15.008H63.613A7.5,7.5,0,0,1,63.613,32.081ZM305.938,216.138l43.334,43.331a16.121,16.121,0,0,1-22.8,22.8l-43.335-43.318a16.186,16.186,0,0,1-4.359-8.086,76.3,76.3,0,1,1,19.079-19.071A16,16,0,0,1,305.938,216.138Zm-30.4-88.16a56.971,56.971,0,1,0,0,80.565A57.044,57.044,0,0,0,275.535,127.978ZM63.613,320.81H448.387a7.5,7.5,0,0,1,0,15.007H63.613A7.5,7.5,0,0,1,63.613,320.81Z"></path>
                    </svg>
                </div>
                <h5><?php echo Label::getLabel('LBL_NO_RESULT_FOUND!'); ?></h5>
            </div>
        </div>
    </div>
<?php } ?>
