<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$applyTeachFrm->developerTags['colClassPrefix'] = 'col-md-';
$applyTeachFrm->developerTags['fld_default_col'] = 12;
$applyTeachFrm->setFormTagAttribute('class', 'form');
$applyTeachFrm->setFormTagAttribute('onsubmit', 'teacherSetup(this); return(false);');
$userEmail = $applyTeachFrm->getField('user_email');
$userEmail->setFieldTagAttribute('placeholder', Label::getLabel('LBL_EMAIL'));
$userPassword = $applyTeachFrm->getField('user_password');
$userPassword->setFieldTagAttribute('placeholder', Label::getLabel('LBL_PASSWORD'));
$submitBtn = $applyTeachFrm->getField('btn_submit');
$submitBtn->setFieldTagAttribute('class', 'btn btn--secondary btn--large btn--block ');
?>
<section class="section padding-0">
    <div class="slideshow full-view-banner">
        <picture class="hero-img">
            <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('image', 'show', [Afile::TYPE_APPLY_TO_TEACH_BANNER, 0, Afile::SIZE_LARGE], CONF_WEBROOT_URL),CONF_DEF_CACHE_TIME, '.jpg'); ?>" alt="">
        </picture>
    </div>
    <div class="slideshow-content">
        <h1><?php echo Label::getLabel('LBL_APPLY_TO_TEACH'); ?></h1>
        <p><?php echo Label::getLabel('LBL_APPLY_TO_TEACH_DESCRITPION'); ?></p>
        <?php if (!empty($siteUserId)) { ?>
            <?php if (empty($siteUser['user_is_teacher'])) { ?>
                <a href="<?php echo MyUtility::makeUrl('TeacherRequest', 'form'); ?>" class="btn btn--secondary btn--large btn--block "><?php echo Label::getLabel('LBL_BECOME_A_TUTOR'); ?></a>
            <?php } ?>
            <div class="row justify-content-center margin-top-4">
                <p><?php echo Label::getLabel('LBL_FAQS_DESCRIPTION'); ?></p>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="#faq-area" class="btn btn--block btn--white scroll">
                        <?php echo Label::getLabel('LBL_FAQS'); ?>
                    </a>
                </div>
                <div class="col-6">
                    <a href="#how-it-works" class="btn btn--block btn--white scroll ">
                        <?php echo Label::getLabel('LBL_HOW_IT_WORKS'); ?>
                    </a>
                </div>
            </div>
        <?php } else { ?>
            <div class="form-register">
                <?php echo $applyTeachFrm->getFormTag(); ?>
                <?php echo $applyTeachFrm->getFieldHTML('agree'); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="field-set">
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $userEmail->getHTML(); ?>
                                    <?php echo $applyTeachFrm->getFieldHTML('user_dashboard'); ?>
                                    <?php echo $applyTeachFrm->getFieldHTML('user_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="field-set">
                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $userPassword->getHTML(); ?>
                                    <a href="javascript:void(0);" class="password-toggle">
                                        <span class="icon" id="hide-password">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16.2" height="17.134" viewBox="0 0 16.2 17.134">
                                                <path id="Path_6420" data-name="Path 6420" d="M13.685,15.853a7.764,7.764,0,0,1-4.4,1.375,8.437,8.437,0,0,1-8.1-7.269,9.083,9.083,0,0,1,2.5-4.9L1.339,2.536,2.4,1.393,17.222,17.384l-1.059,1.142-2.478-2.673ZM4.74,6.2A7.383,7.383,0,0,0,2.71,9.96a7.171,7.171,0,0,0,3.846,5.031,6.307,6.307,0,0,0,6.038-.316l-1.518-1.638A3.187,3.187,0,0,1,6.9,12.532a3.852,3.852,0,0,1-.468-4.507ZM9.965,11.84,7.538,9.222a2.136,2.136,0,0,0,.419,2.166,1.774,1.774,0,0,0,2.008.452Zm5.909,1.829L14.8,12.514A7.509,7.509,0,0,0,15.852,9.96,7.262,7.262,0,0,0,12.72,5.324a6.315,6.315,0,0,0-5.272-.745L6.267,3.3a7.7,7.7,0,0,1,3.014-.614,8.437,8.437,0,0,1,8.1,7.269,9.2,9.2,0,0,1-1.506,3.709Zm-6.8-7.337a3.236,3.236,0,0,1,2.59,1.058,3.8,3.8,0,0,1,.98,2.794L9.073,6.332Z" transform="translate(-1.181 -1.393)" fill="#a2a2a2" />
                                            </svg>
                                        </span>
                                        <span class="icon" id="show-password" style="display: none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16.2" height="14.538" viewBox="0 0 16.2 14.538">
                                                <path id="Path_6422" data-name="Path 6422" d="M9.281,3a8.437,8.437,0,0,1,8.1,7.269,8.436,8.436,0,0,1-8.1,7.269,8.437,8.437,0,0,1-8.1-7.269A8.436,8.436,0,0,1,9.281,3Zm0,12.922a6.873,6.873,0,0,0,6.571-5.652,6.873,6.873,0,0,0-6.57-5.647A6.873,6.873,0,0,0,2.71,10.27a6.874,6.874,0,0,0,6.571,5.653Zm0-2.019a3.509,3.509,0,0,1-3.369-3.634A3.509,3.509,0,0,1,9.281,6.634a3.509,3.509,0,0,1,3.369,3.634A3.509,3.509,0,0,1,9.281,13.9Zm0-1.615a1.95,1.95,0,0,0,1.872-2.019A1.95,1.95,0,0,0,9.281,8.25a1.95,1.95,0,0,0-1.872,2.019A1.95,1.95,0,0,0,9.281,12.288Z" transform="translate(-1.181 -3)" fill="#a2a2a2" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn--secondary btn--large btn--block" name="btn_submit" value="<?php echo $submitBtn->value; ?>"><?php echo $submitBtn->value; ?></button>
                </form>
                <?php echo $applyTeachFrm->getExternalJs(); ?>
                <div class="row justify-content-center">
                    <p>
                        <?php
                        $termsPage = FatApp::getConfig('CONF_TERMS_AND_CONDITIONS_PAGE', FatUtility::VAR_INT, 0);
                        $privacyPage = FatApp::getConfig('CONF_PRIVACY_POLICY_PAGE', FatUtility::VAR_INT, 0);
                        $termsLink = '<a href="' . MyUtility::makeUrl('Cms', 'view', [$termsPage]) . '" class="color-primary">' . Label::getLabel('LBL_Terms_&_Conditions') . '</a>';
                        $privacyLink = '<a href="' . MyUtility::makeUrl('cms', 'view', [$privacyPage]) . '" class="color-primary">' . Label::getLabel('LBL_Privacy_Policy') . '</a>';
                        echo sprintf(Label::getLabel('LBL_BY_SIGNING_UP_YOU_AGREE_TO_TERMS'), $termsLink, $privacyLink);
                        ?>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<style>

    .section-update{
        padding: 80px 0;
    }
    .section-update .sub-header{
        color: #FF5200; 
        letter-spacing: 0.24em;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 22px;
        line-height: 28px;
    }
    .section-update h2{
        font-weight: 700;
        font-size: 48px;
        line-height: 60px;
        color: #000000;
        margin-bottom: 68px;
    }
    .section-update h4{
        font-weight: 700;
        font-size: 30px;
        line-height: 42px;
        color: #0037B4;
    }
    .section-update p{
        color: #000000;
        font-weight: 400;
        font-size: 18px;
        line-height: 28px;
    }
    .why-us-col{
        margin-bottom: 56px;
    }
    .bg-light-green{
        background: #FDFFF7;
    }
    .section-how-it-works h2{
        margin-bottom: 24px;
    }
    .text-center{
        text-align: center;
    }
    .section-join h2{
        font-weight: 700;
        font-size: 48px;
        line-height: 60px;
        margin-bottom: 96px;
    }
    .section-join{
        padding-top: 187px;
        
    }
    .join-card h5{
        font-weight: 700;
        font-size: 24px;
        line-height: 30px;
        margin-bottom: 16px;
    }
    .join-card p{
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        color: #394452;
    }
    .join-card .digit{
        font-weight: 600;
        font-size: 96px;
        line-height: 120px;
        color: #DADEE3;
        position: absolute;
        z-index: -1;
        left: 0;
        top: -50px;        
    }
</style>
<section class="section section-why-us section-update bg-light-green">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-6 d-none d-md-flex justify-content-center">
                <img src="/images/apply-to-teach-why-us.png" height="985" width="684" class="img-fluid why-us-img" alt="why us">
            </div>
            <div class="col-lg-12 col-xl-6">
                <h6 class="sub-header text-uppercase">Why Us</h6>
                <h2 class="">Why Become A Tutor At Our Online Platform?</h2>
                <div class="row">
                    <div class="col-md-6 why-us-col">
                        <h4>Teach on your own schedule</h4>
                        <p>As a Tutor, you have the freedom to choose when you want to tutor students and the number of hours you want to teach. You can teach in the wee hours of the morning, in the evening or late at night.</p>
                    </div>
                    <div class="col-md-6 why-us-col">
                        <h4>Set your hourly rate</h4>
                        <p>Since you’re your own boss, you can set your own rate and maximize your earning potential while providing real value to the students.</p>
                    </div>
                    <div class="col-md-6 why-us-col">
                        <h4>Work Anywhere, Anytime</h4>
                        <p>Flexibility to teach at home without wasting productive time.</p>
                    </div>
                    <div class="col-md-6 why-us-col">
                        <h4>Find More Students</h4>
                        <p>Teach as many or as few students at your convenience.</p>
                    </div>
                    <div class="col-md-6 why-us-col">
                        <h4>Work Anywhere, Anytime</h4>
                        <p>Teach students from across the globe without travelling.</p>
                    </div>
                    <div class="col-md-6">
                        <h4>Safety and Security</h4>
                        <p>Considering all the benefits, you will be professionally satisfied.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


<!--section class="section section-how-it-works section-update" id="how-it-works">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-xl-6">
                <h2 class="">How It Works</h2>
                <p>MyOnlineTutor provides features to facilitate learning and boost your academic performance all in one place.</p>
                <button class="btn btn--secondary ">Apply to Teach</button>
            </div>
			<div class="col-12 col-xl-6">
                <h2>MyOnlineTutor</h2>
                <h4>Set your hourly rate</h4>
                <p>Since you're your own boss, you can set your own rate and maximize your earning potential while providing real value to the students.
However, your earnings will also depend on the number of lessopns you teach. it's advisabl to set fait rates so as to get more students.</p>

<h4>Teach on your own schedule</h4>
<p>As a tutor on our platform, you'll have the freedom to choose when you want to tutor students and the number of hours you want to teach. you can teach in the wee hours of the morning, during the evening, or very late night.</p>

<p>There's no set work schedule that you must follow or minimum time commitment. You simply become your own boss. If you've been looking for a flexible side job with a high earning potential, join our online school today as a tutor and turn your dreams into reality.</p>
                <!-- <p>MyOnlineTutor provides features to facilitate learning and boost your academic performance all in one place.</p>
                <div class="my-online-icon-text">
                    <span class="my-online-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_102_1764)">
                        <path d="M15.5 13.9999H14.71L14.43 13.7299C15.63 12.3299 16.25 10.4199 15.91 8.38989C15.44 5.60989 13.12 3.38989 10.32 3.04989C6.09 2.52989 2.53 6.08989 3.05 10.3199C3.39 13.1199 5.61 15.4399 8.39 15.9099C10.42 16.2499 12.33 15.6299 13.73 14.4299L14 14.7099V15.4999L18.25 19.7499C18.66 20.1599 19.33 20.1599 19.74 19.7499C20.15 19.3399 20.15 18.6699 19.74 18.2599L15.5 13.9999ZM9.5 13.9999C7.01 13.9999 5 11.9899 5 9.49989C5 7.00989 7.01 4.99989 9.5 4.99989C11.99 4.99989 14 7.00989 14 9.49989C14 11.9899 11.99 13.9999 9.5 13.9999Z" fill="white"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_102_1764">
                        <rect width="24" height="24" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                    </span>  
                    <span class="my-online-text">Find New Students</span> 
                </div> -->
<!-- 
                <div class="my-online-icon-text">
                    <span class="my-online-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_102_1768)">
                            <path d="M20 3H19V1H17V3H7V1H5V3H4C2.9 3 2 3.9 2 5V21C2 22.1 2.9 23 4 23H20C21.1 23 22 22.1 22 21V5C22 3.9 21.1 3 20 3ZM20 5V8H4V5H20ZM4 21V10H20V21H4Z" fill="white"/>
                            <path opacity="0.3" d="M4 5.01001H20V8.00001H4V5.01001Z" fill="#323232"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_102_1768">
                            <rect width="24" height="24" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                    </span>  
                    <span class="my-online-text">Grow your business</span> 
                </div> -->

                <!-- <div class="my-online-icon-text">
                    <span class="my-online-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11 19V22H13V19H14C16.2091 19 18 17.2091 18 15C18 12.7909 16.2091 11 14 11H13V7H15V9H17V5H13V2H11V5H10C7.79086 5 6 6.79086 6 9C6 11.2091 7.79086 13 10 13H11V17H9V15H7V19H11ZM13 17H14C15.1046 17 16 16.1046 16 15C16 13.8954 15.1046 13 14 13H13V17ZM11 11V7H10C8.89543 7 8 7.89543 8 9C8 10.1046 8.89543 11 10 11H11Z" fill="white"/>
                        </svg>
                    </span>  
                    <span class="my-online-text">Get Paid Securely</span> 
                </div> -->
                <!-- <div class="d-flex align-items-center button-wrapper">
                    <a class="btn btn--secondary btn--large" href="javascript:void();">Become a Tutors</a>
                    <a class="btn btn-link" href="javascript:void();">How Our Platform Works</a>
                </div> 
            </div>
            <div class="col-lg-12 col-xl-6 text-right">
                <iframe width="100%" height="540" border="0" src="https://www.youtube.com/embed/QD1oqhhej7o"></iframe>
            </div>
        </div>
    </div>
</section-->
<section class="section section-join section-update">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Why You Should Join MYONLINETUTOR</h2>
            </div>
            <div class="col-md-4 join-card">
                <span class="digit">01</span>
                <h5>We provide you with everything you need to teach successfully</h5>
                <p>We provide tutors with easy to use video tools, smart calendar, training webinars, quiz and interactive learning to encourage student participation and a hands-on approach to learning.</p>
            </div>

            <div class="col-md-4 join-card">
                <span class="digit">02</span>
                <h5>Steady stream of students</h5>
                <p>We have thousands of students from over 100 countries around the world. That means you’ll always be booked to offer online lessons to students which will translate to stable income. </p>
            </div>

            <div class="col-md-4 join-card">
                <span class="digit">03</span>
                <h5>Guaranteed payment</h5>
                <p>All our tutors get paid on time through convenient payment systems.</p>
                
            </div>
        </div>
    </div>
</section>

<style>
    .section-apply-now{
        background-color: #F3F3F3;
    }

</style>
<section class="section section-apply-now section-update">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-xl-6">
                <h2>Teach on your own schedule?</h2>
                <p>As a tutor on our platform, you’ll have the freedom to choose when you want to tutor students and the number of hours you want to teach.</p>
                <a href="/teacher-request/form" class="btn btn--secondary" style="color:white;">Apply Now</a>
            </div>
            <div class="col-lg-12 col-xl-6">
                <img src="/images/cta-placeholder.png" width="748" height="540" alt="Tutor with MyOnlineTutor" class="img-fluid">
            </div>
        </div>  
    </div>
</section>

<style>
    .section-faq{
        background: #FDFFF7;
        padding-top: 112px;
    }
    .section-faq h2{
        font-weight: 700;
        font-size: 48px;
        color: #000000;
        line-height: 58px;
        margin-bottom: 24px;
    }
    .section-faq p{
        font-weight: 400;
        font-size: 18px;
        line-height: 27px;
    }
    .faq-wapper .faq-container .faq-row{
        background: #FDFFF7;
        border: 1px solid #000000;
    }
    .faq-wapper .faq-container .faq-row .faq-title {
        padding: 22px 60px 22px 24px;
    }
    .faq-wapper .faq-container .faq-row .faq-title h5{
        font-weight: 700;
        font-size: 18px;
        line-height: 27px;
    }
    .faq-wapper .faq-container .faq-row .faq-title::before{
        border: none;
        height: 18px;
        width: 18px;
        background-image: url('/images/plush-icon.svg');
        background-repeat: no-repeat;
        background-position: center;
        transform: rotate(0deg);
        top: 50%;
        margin-top: -10px;
    }
    .faq-wapper .faq-container .faq-row.is-active .faq-title::before{
        transform: rotate(45deg);
    }
    
    .faq-wapper{
        margin-top: 80px;
    }
    .still-have-a-question{
        margin-top: 80px;
    }
    .still-have-a-question h2{
        font-weight: 700;
        font-size: 32px;
        line-height: 42px;
    }
    .still-have-a-question .btn-outline{
        border: 1px solid #000000;
        background: #FDFFF7;
        color: #000;
        border-radius: 0;
    }
    .still-have-a-question p{
        margin-bottom: 24px;
    }
    .still-have-a-question .btn-outline:hover{
        background: #000000;
        color: #FDFFF7;
    }
</style>

<section  class="section section-faq section-update" id="faq-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Questions? We have Answers!</h2>
            </div>
            <div class="col-md-6">
                <div class="faq-wapper">
                    <div class="faq-cover">
                        <div class="faq-container">
                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>Getting Started (TUTOR)</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>Welcome to MyOnlineTutor! MyOnlineTutor is a platform that provides you the opportunity to provide lessons to students from all around the world. As a Tutor you need to first get registered on our platform. Signing up is a completely free and a one-click process. You can sign up using your personal email, Facebook, or Google account.</p>
                                </div>
                            </div>

                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>Profile Development </h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>The first step after completing the sign-up process, is to enter your basic and biographical data. Once this step has been completed, you will have to set your working hours, add your profile photo, and a self-introductory video to your profile.</p>

									<p>This is mandatory for every tutor. Your profile will then undergo a verification and approval process. Our approval team will thoroughly review and verify your profile details. Close attention is paid to your credentials and the completeness of your profile during the approval phase.</p>
									<p> 
									The approval of your profile will take between 48 and 72 hours, due to the high volume of applications. During this period your profile will not be available on the search results for students.</p>
									 
									<p>You will be notified once your profile has been approved. Your profile will then be shown in the student search results. Please note that sharing any contact information on your profile details (i.e. Full Name, Address, Contact Number, Email, etc.) is strictly prohibited. MyOnlineTutor reserves the right to accept or reject any application without assigning a reason.</p>
                                </div>
                            </div>

                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>The Job Hunt</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>The selection of a tutor completely depends on the student's choice, however, tutors can increase their chance of getting selected by considering the following recommendations:</p>
									<ul type="bullet">
									 <li>Keep your profile information relevant, concise, and to the point</li>

									<li>Choose working hours that are more suitable for the students</li>

									<li>Add maximum specializations to let the students find you promptly</li>

									<li>Increase the completeness level of your profile. Profiles with a high level of completeness are more likely to be selected </li>

									<li>Create and add a professional self-introductory video to your profile (refer to our guidelines for creating a good introductory video)</li>

									<li>Visit the "Find Student” section to check for any "Student Requests” (under this section, the students post their custom requests to find tutors)</li>

									<li>Tutors are required to have at least 100% profile completeness in order to apply against a Student’s Request. The more active you are on the platform the more offers you are allowed to make in this regard.</li></ul>
                                </div>
                            </div>

                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>Operative Mechanism</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>Once the student has selected a suitable tutor, he/she has to make the First Lesson Payment through our platform. The tutor will give his first lesson to the student against this payment, where the tutor would have to convince the student that he has made the right choice. After the First Lesson, if the student is satisfied with the tutor and he has decided to proceed with that particular tutor. The student will book a package offered by the tutor. The available lesson packages range from 5 hours to 20 hours. Choosing bigger packages is usually cost-effective. The students may book a package as per their desire or need. </p>
									<p>The tutor may start giving the lessons as soon as the package payment has been made. The lessons are scheduled in advance and are supposed to take place according to this schedule. In case the tutor wants to cancel or reschedule a lesson, he/she is required to do it 4 hours before the scheduled time otherwise, it will not be rescheduled. </p>
									<p>After the scheduled lesson has taken place, the platform will send the request for the confirmation of the lesson to the student. The tutor will receive the payment for this lesson only after the student has confirmed the lesson. In case a student has turned ON the auto-confirmation option for the confirmation of a lesson, the lesson will automatically be confirmed 72 hours after the lesson time. To report a lesson-based issue, the tutor is required to report it within 72 hours of the completion of the lesson.</p>
                                </div>
                            </div>
                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>Payment Procedures</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>After the first lesson has been conducted, the students are required to purchase a lesson package. Paying for a package does not mean that the payment is made to the tutor. In fact, the said payments are kept with the platform as a guarantee and the tutor is only paid after the submission of the student’s confirmation against each lesson.</p><p>For the sake of withdrawal of the funds from the tutor’s account, the tutors may go to the Withdrawal section. To withdraw your funds, the available options include PayPal, Master, Visa, Skrill, and Payoneer. In case you are facing any issues in this regard, please feel free to contact our support team.</p>
                                </div>
                            </div>
							<div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>Dos and Don'ts</h5>
                                </a>
                               <div class="faq-answer faq__target faq__target-js">
                                     <p><table border="1" cellspacing="0" cellpadding="0"> 
										<tbody style="font-size: 14pt;">
											<tr>  
												<td width="319" valign="top">  
													<p align="center"><span style="font-size: 14pt; font-weight: bold;">Dos</span></p>  </td>  
												<td width="319" valign="top">  
													<p align="center"><span style="font-size: 14pt; font-weight: bold;">Don’ts</span></p>  </td> 
											</tr> 
											<tr>  
												<td width="319" valign="top">  
													<ul>
														<li><span style="font-size: 14pt;">Make payments for lessons in advance to get started with your lesson</span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Take the first lesson as an opportunity to assess if the tutors suit
									  the student or vice versa.</span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Contact information is exchanged between student and tutor
									  automatically by the platform once the first lesson payment is done</span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">While choosing a tutor’s package, keep in mind that bigger packages
									  offer discounted rates</span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Be very careful while selecting a date and time for a lesson to avoid
									  its cancelation or rescheduling </span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Students and Tutors are free to communicate through the private chat
									  system available on the platform</span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Read the Terms of Service before proceeding with any activity on this
									  platform</span></span></li>
													</ul>              </td>  
												<td width="319" valign="top">  
													<ul>
														<li><span style="font-size: 14pt;">Every student and tutor is allowed to register only one account on the
									  platform, registering an additional or fake account may result in profile
									  blocking as well as removal</span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Students and Tutors are not allowed to make any payments outside the
									  platform</span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">It is strictly prohibited to share contact information between the
									  students and tutors before the First Lesson</span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Avoid providing any vague or misleading profile information </span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Tutors should avoid setting very high or unreasonable package prices</span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">Abusive or unethical language for any kind of communication on the
									  platform is prohibited</span></span></li>
														<li><span style="font-size: 14pt;"><span style="font-size: 14pt;">To avoid removal or blocking of your profile, pay attention to the
									  Rules &amp; Regulations of the platform</span></span></li>
													</ul>              </td> 
											</tr>
										</tbody>
									</table></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="faq-wapper">
                    <div class="faq-cover">
                        <div class="faq-container">
                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>The Review System</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>Students are asked to provide their Review for the tutor after 14 days from the payment of the First Lesson, tutors may also remind the students to do so in case they forget to leave the review. Such positive reviews not only help in the improvement of the tutor’s rating on the platform but also help other students in the selection of the right tutors. According to a survey, most of the students don’t go beyond the first three pages of the search results and more than half of the conversions take place from these three pages, therefore the tutor’s positioning on the platform matters. </p>
                                </div>
                            </div>

                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>Cancelation Policy</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>If the tutor wants to cancel a scheduled lesson for any unforeseen reason, he has the choice to do it 4 hours before the scheduled time, please bear in mind that the lesson would not be canceled otherwise and the tutor will have to give that lesson according to the schedule.</p>

									<p>A prescheduled lesson can be canceled by clicking the "Cancel” button under the "My Lessons” menu, where you will have to provide a valid reason for the cancelation. Any fraudulent activity in this regard or violation of any other rules of the platform may result in immediate blockage of the tutor’s profile.</p>
                                </div>
                            </div>

                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>How to create a good Self-introduction video</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>We all know the famous adage "First impressions are lasting impressions”. Your profile video works as your first impression for the students. Therefore, it is very important to create a professional & decent video.</p> 

									<p>We have provided you with some tips for creating a professional self-introduction video. No doubt, your experience, degrees, certificates, and testimonials are important, but you still need a compelling video that introduces you to the students, who ultimately hire you based on your presentation. A good self-recorded introduction video will not only validate your skill set but will also build a strong connection with your prospective students.</p>
									<p>
										 A few things that you should bear in mind while recording the video:
									</p>
									<div>
									<p><span lang="EN-US" style="font-size: 14pt;"></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Wear something smart, simple, and professional&nbsp;</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Try to be unique and different from the other tutors</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">The video should be short and concise</span><span lang="EN-US" style="font-size: 14pt;">&nbsp;(not more than 2 minutes)</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Speak clearly and deliberately</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Write down your speech to ensure that you record it smoothly</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">State your name, nationality, education, and teaching experience</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Use a teleprompter app. It is a good way to stay fluent during the recording</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Choose a quiet place for recording,&nbsp;&nbsp;away from&nbsp;&nbsp;distractions</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Pay attention to your posture and ensure you look directly&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">at the camera</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Remember it’s&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">not just about what you say in the video but</span><span lang="EN-US" style="font-size: 14pt;">&nbsp;"How You Say It”!</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">o&nbsp;&nbsp;&nbsp;</span><span lang="EN-US" style="font-size: 14pt;">Last but not least,&nbsp;<span style="font-weight: bold; font-size: 14pt;">Don’t Forget to Smile during the Recording</span></span><span lang="EN-US" style="font-size: 14pt;"></span></span></p>
									<p><span style="font-size: 14pt;"><span lang="EN-US" style="font-size: 14pt;">Given below sample videos would help you a better understanding</span><span lang="EN-US" style="font-size: 14pt;"></span></span></p></div>
									<iframe width="560" height="315" src="https://www.youtube.com/embed/bG6ZmwAqmZA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
									<iframe width="560" height="315" src="https://www.youtube.com/embed/RtjLoGw4A7o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
									<iframe width="560" height="315" src="https://www.youtube.com/embed/_0g7lVvB8-s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
									<iframe width="560" height="315" src="https://www.youtube.com/embed/pUGGAYGq8D8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                                </div>
                            </div>

                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>Profile Optimization</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>The appearance of your profile in the search results is vital as only a portion of the tutor profile is displayed on the first page of the search results. As a result, it is critical to optimize your profile to make it visible and attractive to students looking for your services.

									o   Profile Information

									Your basic profile information should be complete as it portrays the quality of your profile on the platform i.e.

									 

									Your profile photo must be decent and captivating
									Adding an introductory video is a mandatory part of your profile. A good video helps in developing a good connection with the students (Refer to our guide on How To Create a Good Video)
									The headline and intro of your profile should compelling and properly describe your expertise
									Completeness is the key to success, don’t leave any field vacant
									Set reasonable and fair charges. The price you select should neither be so high that students believe it is excessively expensive nor should it be so low that students are misled.
									 

									o   Collect Student Reviews

									Most students prefer tutors with a higher number of reviews on their profile since it develops trust. As a result, gathering favorable evaluations on your profile will undoubtedly help you rank higher on the platform.

									The platform prompts students to leave a review 14 days after the first class; however, as a tutor, you may remind your students to leave a review if they have not.

									o   Respond To Messages

									Improving your response time is a key factor in getting more students. You need to be as prompt as possible. It also depends upon your communication skills and how you convince a student to select you because the student must have a reason for choosing you among the other tutors. You also need to be aware of the platform rules because sometimes students may also ask you about how Tutors online works.

									o   Increase Your Tutoring Hours

									Selling more works for the growth of any business. On Tutors Online you sell your lesson hours, therefore the lesson hours you have conducted will definitely result in the ranking of your profile on the platform. You should convince your students to buy bigger packages, as this will not only increase your Tutor Hour base but the students will also get discounted prices for their purchase. It is also recommended to set reasonable prices for your package plans because if your prices will be higher than the student’s budget, the student will obviously search for the other tutors matching their budget range.</p>
                                </div>
                            </div>
                            <div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>Commission Norms</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>Commission is charged at 18% from the first paid lesson of every new student. However, as shown in the table below, the commission percentage decreases as the number of lesson hours delivered by a tutor increases. This mechanism encourages tutors to spend as much time as possible on the platform to gain maximum benefit. Upon confirmation of each completed lesson, the payment is transferred to the Tutor’s account after the deduction of the above commission, and can be withdrawn immediately.</p><p>

									Our algorithms automatically rank up those tutors who conduct more lessons with the students, and the more lessons they conduct the less commission they have to pay.</p>
									<div align="center">
										<table border="1" cellspacing="0" cellpadding="0"> 
											<tbody>
												<tr>  
													<td width="196">  
														<p align="center"><span style="font-weight: bold;"><span style="font-size: 14pt; text-decoration: underline;">Number of
									  Hours</span></span></p>  </td>  
													<td width="260">  
														<p align="center"><span style="font-weight: bold;"><span style="font-size: 14pt; text-decoration: underline;">Commission
									  Percentage</span></span></p>  </td> 
												</tr> 
												<tr>  
													<td width="196">  
														<p align="center"><span style="font-size: 14pt;">0 – 20</span></p>  </td>  
													<td width="260">  
														<p align="center"><span style="font-size: 14pt;">18 %</span></p>  </td> 
												</tr> 
												<tr>  
													<td width="196">  
														<p align="center"><span style="font-size: 14pt;">21 – 50 </span></p>  </td>  
													<td width="260">  
														<p align="center"><span style="font-size: 14pt;">17 %</span></p>  </td> 
												</tr> 
												<tr>  
													<td width="196">  
														<p align="center"><span style="font-size: 14pt;">51 – 200 </span></p>  </td>  
													<td width="260">  
														<p align="center"><span style="font-size: 14pt;">16 %</span></p>  </td> 
												</tr> 
												<tr>  
													<td width="196">  
														<p align="center"><span style="font-size: 14pt;">201 – 400 </span></p>  </td>  
													<td width="260">  
														<p align="center"><span style="font-size: 14pt;">14 %</span></p>  </td> 
												</tr> 
												<tr>  
													<td width="196">  
														<p align="center"><span style="font-size: 14pt;">400+</span></p>  </td>  
													<td width="260">  
														<p align="center"><span style="font-size: 14pt;">12 %</span></p>  </td> 
												</tr>
											</tbody>
										</table></div>
                                </div>
                            </div>
							<div class="faq-row faq-group-js">
                                <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                    <h5>How to setup group classes walkthrough video</h5>
                                </a>
                                <div class="faq-answer faq__target faq__target-js">
                                    <p>How to setup group classes walkthrough video</p>

								<p>First create your group lesson banner on canva or any other design website, I prefer to use Canva because it doesn’t require special techniques and it’s free. You can use a picture if you wish. </p>

								<p>Step 1) Click Add on the upper right corner.</p>
								<p>Clicking the button will open a form related to the group class details. </p>

								<p>Step 2) Fill in the required information such as title, description, language, fees, date, time, class title, and duration. When you are done, click Save to save the entered information.</p>

								<p>The group class will then be added to the list on the Home </p>
								<iframe width="560" height="315" src="https://www.youtube.com/embed/rq2nlIZ9Z4M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="still-have-a-question text-center">
                    <h2 class="text-center">Still have a question?</h2>
                    <p  class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                    <button class="btn btn-outline">Contact</button>
                </div>
            </div>


        </div>
    </div>
</section>

<?php //echo FatUtility::decodeHtmlEntities($sectionAfterBanner); ?>
<?php //echo FatUtility::decodeHtmlEntities($featuresSection); ?>
<?php //echo FatUtility::decodeHtmlEntities($becometutorSection); ?>
<?php //echo FatUtility::decodeHtmlEntities($staticBannerSection); ?>
<?php if (!empty($faqs)) { ?>
    <section class="section section--faq" style="display: none;">
        <div class="container container--narrow">
            <div class="section__head">
                <h2><?php echo Label::getLabel('LBL_faq_title_second'); ?></h2>
            </div>
            <div class="faq-cover">
                <div class="faq-container">
                    <?php foreach ($faqs as $ques) { ?>
                        <div class="faq-row faq-group-js">
                            <a href="javascript:void(0)" class="faq-title faq__trigger faq__trigger-js">
                                <h5><?php echo CommonHelper::renderHtml($ques['faq_title']); ?></h5>
                            </a>
                            <div class="faq-answer faq__target faq__target-js">
                                <p><?php echo CommonHelper::renderHtml($ques['faq_description']); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php $this->includeTemplate('_partial/contact-us-section.php', ['siteLangId' => $siteLangId]); ?>
<?php } ?>
<script>
    $(".faq__trigger-js").click(function(e) {
        e.preventDefault();
        if ($(this).parents('.faq-group-js').hasClass('is-active')) {
            $(this).siblings('.faq__target-js').slideUp();
            $('.faq-group-js').removeClass('is-active');
        } else {
            $('.faq-group-js').removeClass('is-active');
            $(this).parents('.faq-group-js').addClass('is-active');
            $('.faq__target-js').slideUp();
            $(this).siblings('.faq__target-js').slideDown();
        }
    });
</script>