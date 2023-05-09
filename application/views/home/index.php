<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($slides) && count($slides)) { ?>
    <section class="section section--slideshow">
        <div class="slideshow slideshow-js">
            <?php
            foreach ($slides as $slide) {
                $desktopUrl = '';
                $tabletUrl = '';
                $mobileUrl = '';
                $haveUrl = ($slide['slide_url'] != '');
                if (empty($slideImages[$slide['slide_id']])) {
                    continue;
                }
                $slideImage = $slideImages[$slide['slide_id']];
                if (!empty($slideImage[Afile::TYPE_HOME_BANNER_DESKTOP])) {
                    $imgUrl = MyUtility::makeUrl('Image', 'show', [Afile::TYPE_HOME_BANNER_DESKTOP, $slide['slide_id'], Afile::SIZE_LARGE]);
                    $desktopUrl = FatCache::getCachedUrl($imgUrl, CONF_IMG_CACHE_TIME, '.jpg');
                }
                if (!empty($slideImage[Afile::TYPE_HOME_BANNER_MOBILE])) {
                    $imgUrl = MyUtility::makeUrl('Image', 'show', [Afile::TYPE_HOME_BANNER_MOBILE, $slide['slide_id'], Afile::SIZE_LARGE]);
                    $mobileUrl = FatCache::getCachedUrl($imgUrl, CONF_IMG_CACHE_TIME, '.jpg');
                }
                $html = '<div><div class="caraousel__item">';
                if (!empty($slideImage[Afile::TYPE_HOME_BANNER_IPAD])) {
                    $imgUrl = MyUtility::makeUrl('Image', 'show', [Afile::TYPE_HOME_BANNER_IPAD, $slide['slide_id'], Afile::SIZE_LARGE]);
                    $tabletUrl = FatCache::getCachedUrl($imgUrl, CONF_IMG_CACHE_TIME, '.jpg');
                }
                if ($haveUrl) {
                    $html .= '<a target="' . $slide['slide_target'] . '" href="' . CommonHelper::processUrlString($slide['slide_url']) . '">';
                }
                $html .= '<div>
                            <div class="slideshow__item">
                               <picture class="hero-img">
                                  <source data-aspect-ratio="4:3" srcset="' . $mobileUrl . '" media="(max-width: 767px)">
                                  <source data-aspect-ratio="4:3" srcset="' . $tabletUrl . '" media="(max-width: 1024px)">
                                  <source data-aspect-ratio="10:3" srcset="' . $desktopUrl . '">
                                  <img data-aspect-ratio="10:3" srcset="' . $desktopUrl . '" alt="' . $slide['slide_identifier'] . '">
                               </picture>
                           </div>
                        </div>';
                if ($haveUrl) {
                    $html .= '</a>';
                }
                $html .= "</div></div>";
                echo $html;
            }
            ?>
        </div>
        <div class="slideshow-content">
            <h1><?php echo Label::getLabel('LBL_SLIDER_TITLE_TEXT'); ?></h1>
            <p><?php echo Label::getLabel('LBL_SLIDER_DESCRIPTION_TEXT'); ?></p>
            <div class="slideshow__form">
                <form method="POST" class="form" action="<?php echo MyUtility::makeFullUrl('Teachers', 'languages'); ?>" name="homeSearchForm" id="homeSearchForm">
                    <div class="slideshow-input">
                        <svg class="icon icon--search">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#search'; ?>"></use>
                        </svg>
                        <input type="text" name="language" placeholder="<?php echo Label::getLabel('LBL_I_AM_LEARNING'); ?>" />
                        <input type="hidden" name="teachLangId" />
                        <input type="hidden" name="teachLangSlug" />
                    </div>
                    <button class="btn btn--secondary btn--large btn--block"><?php echo Label::getLabel('LBL_SEARCH_FOR_TEACHERS'); ?></button>
                </form>
            </div>
            <?php
            if (!empty($popularLanguages)) {
                $lastkey = array_key_last($popularLanguages);
            ?>
                <div class="tags-inline">
                    <b><?php echo Label::getLabel("LBL_POPULAR:") ?></b>
                    <ul>
                        <?php
                        foreach ($popularLanguages as $language) {
                            $language['tlang_name'] = ($lastkey != $language['tlang_id']) ? $language['tlang_name'] . ', ' : $language['tlang_name'];
                        ?>
                            <li class="tags-inline__item"><a href="<?php echo MyUtility::makeUrl('teachers', 'languages', [$language['tlang_slug']]) ?>"><?php echo $language['tlang_name']; ?></a></li>
                        <?php
                        }
                        unset($lastkey);
                        ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </section>
<?php
}
/**
 * This if (!empty($whyUsBlock)) { condition can be removed
 */
?>
<style>

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
    .section-how-it-work{
        background-color: #F2F6E6;
    }
    .section-how-it-work .sub-header{
        margin-bottom: 16px;
    }
    .section-how-it-work h2{
        margin-bottom: 80px;
        font-weight: 700;
        font-size: 42px;
        line-height: 55px;
        color: #000000;
    }
    .section-how-it-work .card{
        padding: 80px 0 48px 0;
    }
    .how-it-works-card-img {
        padding: 0 0 0 0;
    }
    .how-it-works-card-img img {
        width: 100%;
    }
    .section-how-it-work .card h3{
        margin-bottom: 24px;
        font-weight: 700;
        font-size: 38px;
        line-height: 48px;

    }
    .section-how-it-work .card p{
        margin-bottom: 32px;
        min-height: 115px;
    }
    .text-center{
        text-align: center;
    }
    .tutors-thumb img.img-fluid {
        background-position: top;
        background-repeat: no-repeat;
        background-size: 100%;
        height: 100%;
    }
    .tutors-thumb img{
        width: 100%;
    }
    .tutors-card-content {
        padding-top: 24px;
    }
    .tutors-card-content-top {
        padding-bottom: 24px;
    }
    .tutors-card-content-top h4 {
        color: #000000;
        font-weight: 600;
        font-size: 20px;
        line-height: 30px;
        margin-bottom: 10px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        display: inline-block;
        
    }
    .tutors-thumb {
        width: 100%;
        
        
    }
    .tutors-flag {
        display: flex;
        align-items: center;
        font-weight: 400;
        font-size: 18px;
        line-height: 27px;
    }

    .tutors-flag img {
        margin-right: 8px;
        max-width: 28px;
    }   
    .rate{
        font-weight: 600;
        font-size: 38px;
        line-height: 56px;
        color: #000000;
    }
    .rate sup{
        font-weight: 400;
        font-size: 20px;
        line-height: 25px;
        color: #000000;
        align-self: center;
        top: -5px;
    }
    .rate sub{
        font-weight: 400;
        font-size: 12px;
        line-height: 15px;
        color: #000000;
        align-self: end;
        bottom: 15px;
    }
    .card-tag{
        display: flex;
        flex-wrap: wrap;
        min-height: 80px;

    }
    .card-tag span{
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        background: #FDFFF7;
        border-radius: 8px;
        padding: 4px 8px;
        margin-right: 8px;
        white-space: nowrap;
        margin-bottom: 8px;        
        max-height: 32px;
        
    }
    .card-tag span:last-child{
        margin-right: 0;
    }
    .tutors-card-content-bottom{
        padding-top: 24px;
    }
    .rating-count{
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        color: #000000;
    }
    .section-top-tutors,.section-to-learn{
        background-color: #F2F6E6;
    }
    .tutors-card-content-bottom {
        padding-top: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .tutors-card-content-bottom a.btn {
        padding: 10px 40px;
    }
    .section-top-tutors h2,.section-to-learn h2{
        font-weight: 700;
        font-size: 48px;
        line-height: 60px;
        color: #000000;
        margin-bottom: 80px;
    }

    .section-to-learn  .subject-wrap .subject-card{
        padding: 40px 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .section-to-learn  .subject-wrap{
        flex-wrap: wrap;
    }

    .section-to-learn  .subject-wrap .subject-card{
        flex : 0 0 25%;
        max-width: 25%;
        border: 1px solid #858585;
        border-right: none;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .section-to-learn .subject-wrap .subject-card a:after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
        content: "";
    }
    .section-to-learn  .subject-wrap .subject-card:nth-child(4n){
        border-right: 1px solid #858585;
    }
    .section-to-learn  .subject-wrap .subject-card h4{
        font-weight: 700;
        font-size: 30px;
        line-height: 42px;
        margin-bottom: 12px;
        color: #000;
    }
    .section-to-learn  .subject-wrap .subject-card h4 p{
        margin: 0;
    }
    .section-my-online{
        background: #193264;
        padding-top: 100px;
        padding-bottom: 100px;
    }
    .section-my-online iframe{
        border: none;
    }
    .section-my-online h2{
        font-weight: 700;
        font-size: 48px;
        line-height: 58px;
        margin-bottom: 24px;
        color: #fff;
    }
    .section-my-online p{
        color: #fff;
        font-weight: 400;
        /* font-size: 24px;
        line-height: 36px; */
        margin-bottom: 24px;
    }
    .section-my-online h4{
        font-weight: 700;
        font-size: 25px;
        line-height: 30px;
        margin-bottom: 24px;
        color: #fff;
    }
    .my-online-icon-text{
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }
    .my-online-icon-text .my-online-icon{
        width: 24px;
        height: 24px;
        margin-right: 24px;
    }
    .my-online-icon-text .my-online-text{
        color: #FFFFFF;
    }
    a.btn.btn-link {
        background: transparent;
    }
    .button-wrapper{
        margin-top: 40px;
    }
    .see-more-link {
        display: inline-block;
        margin-top: 80px;
        font-weight: 600;
        font-size: 20px;
        color: #000000;
    }
    .see-more-link svg {
        margin-left: 24px;
    }
    .section-testimonial h2{
        font-weight: 700;
        font-size: 48px;
        line-height: 60px;
        margin-bottom: 24px;
    }

    .testimonail-slider{
        margin-top: 80px;
    }

    .testimonail-slider .testimonail-item{
        border: 1px solid #000000;
        padding: 32px;
        margin-right: 32px;
        height: 100%;

    }
    .testimonail-slider .slick-track
    {
        display: flex !important;
    }

    .testimonail-slider .slick-slide
    {
        height: inherit !important;
    }
    .testimonail-slider .slick-slide .testimonail-slider-wrapper,.testimonail-slider .slick-slide .testimonail-slider-wrapper > div,.testimonail-slider .slick-slide>div{
        height: 100%;
    }

    .testimonal-items-rating svg{
        margin-right: 4px;
    }
    .testimonal-items-rating svg:last-child{
        margin-right: 0;
    }
    .testimonal-items-rating{
        margin-bottom: 32px;
    }

    .testimonail-item p{
        font-weight: 400;
        font-size: 18px;
        line-height: 27px;
        color: #000000;
        margin-bottom: 32px;

    }
    .testimonal-user-thumb img{
        max-height: 56px;
        width: auto;
        height: auto;
        border-radius: 50%;
    }

    .testimonal-username h6{
        font-weight: 600;
        font-size: 16px;
        line-height: 24px;
        color: #000000;
    }
    .testimonal-username p{
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        margin: 0;
    }
    .testimonal-user-thumb {
        flex: 0 0 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 56px;
        margin-right: 16px;
    }
    .testimonal-user-thumb img{
        max-width: 56px;
        border-radius: 50%;
    }
    .home.home-index .section-testimonial .slick-arrow{
        display: block;
        width: 56px;
        height: 56px;
        border: 1px solid #000000;
        border-radius: 50px;
        background: #fff url('https://myonlinetutor.co/images/left-arrow-slider.png') no-repeat center;
        background-size: 16px;
        margin: -60px 0 0 0;
    }
    .home.home-index .section-testimonial .slick-arrow:before{
        display: none;
    }
    .section-testimonial .slick-arrow.slick-prev{
        left: -30px;
    }
    .section-testimonial .slick-arrow.slick-next{
        right: 0;
        transform: rotate(180deg);
    }
    .home.home-index .section-testimonial .slick-dots li button{
        width: 8px;
        height: 8px;
        background: #8D8D8D;
        border-radius: 50%;
        padding: 0;
    }
    .home.home-index .section-testimonial .slick-dots{
        margin-top: 60px;
        position: relative;
    }
    .home.home-index .section-testimonial .slick-dots li.slick-active button{
        padding: 0;
        background: #000000;
    }
    .home.home-index .section-testimonial .slick-dots li:last-child{
        margin-right: 0;
    }
    .footer-links {
        padding: 0 20px;
        max-width: 13%;
    }
    .footer-links h5 {
        font-weight: 600;
        font-size: 20px;
        margin-bottom: 24px;
    }
    .footer-links ul li a{
        font-weight: 400;
        font-size: 14px;    
        line-height: 21px;
    }
    .footer-links ul li{
        margin-bottom: 16px;

    }
    .footer-links ul li:last-child{
        margin-bottom: 0;
    }

        .tutors-card-content-top > span {
        flex: 0 0 50%;
        max-width: 50%;
    }
    .tutors-card-content-top > span.rate {
		justify-content: flex-end;
		height: 70px;
	}
	.tutors-card {
		margin-bottom: 30px;
	}
    @media(max-width: 1400px){
        .tutors-card-content-top h4{
            width: 99%;
        }
        .section-how-it-work .card p{
            min-height: 140px;
        }
    }
    @media(max-width: 1200px){
        .img-fluid{
            height: auto;
        }
        .why-us-img{
            margin-bottom: 30px;
        }
        .tutors-thumb{
            width: 100%;
            
            
        }
        .tutors-thumb img.img-fluid{
            width: 100%;
        }
        .section-to-learn  .subject-wrap .subject-card{
            flex : 0 0 50%;
            max-width: 50%;
        }
        .footer-links {
            padding: 0 20px;
            max-width: 30%;
            margin-bottom: 48px;
        }
        
    }
    @media(max-width: 991px){
        .section-why-us h2{
            margin-bottom: 40px;
        }
        .section-why-us h4{
            margin-bottom: 12px;
        }
        .why-us-col{
            margin-bottom: 24px;
        }
        .section-update{
            padding: 30px 0;
        }
        .section-how-it-work h2{
            margin-bottom:0;
        }
        .section-how-it-work .card {
            padding: 0;
            margin-bottom: 20px;
            margin-top: 72px;
        }
        .how-it-works-card-img {
            padding: 0;
        }
        .tutors-thumb {
            width: 100%;
            
            
            height: auto;
            overflow: hidden;
        }
        .tutors-card{
            margin-bottom: 40px;
        }
        .section-top-tutors h2, .section-to-learn h2{
            font-size: 34px;
            line-height: 40px;  
            margin-bottom: 40px;
        }
        .section-to-learn  .subject-wrap .subject-card{
            flex : 0 0 100%;
            max-width: 100%;
            margin-bottom: 20px;
            border: 1px solid #858585;

        }
        .section-to-learn  .subject-wrap .subject-card:last-child{
            margin-bottom: 0;
        }
        .button-wrapper {
            margin-top: 40px;
            margin-bottom: 40px;
            flex-direction: column;
        }
        .button-wrapper .btn{
            width: 100%;
        }     
        .testimonail-slider .testimonail-item{
            padding: 32px;
            margin: 0 16px;
        } 
        .section-how-it-work .card p {
            min-height: 170px;
        }  
    }
    @media(max-width: 767px){
        .testimonail-slider .testimonail-item{
            padding: 15px;
            margin: 0 16px;
        }
        .footer-links-wrapper {
            -webkit-box-pack: flex-start !important;
            -ms-flex-pack: flex-start !important;
            justify-content: flex-start !important;
        }
        .footer-links {
            padding: 0;
            max-width: 100%;
        }
        .section-how-it-work .card p {
            min-height: unset;
        } 
        .section-my-online{
            padding-top: 50px;
            padding-bottom: 50px;
        }
    }
</style>

<section class="section section-why-us section-update">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-xl-6 d-none d-md-flex">
                <img src="/images/why-us-img.png" height="794" width="684" class="img-fluid why-us-img" alt="why us">
            </div>
            <div class="col-lg-12 col-xl-6">
                <h6 class="sub-header text-uppercase">Why Us</h6>
                <h2 class="">We Make Learning Easier & Simpler</h6>
                <div class="row">
                    <div class="col-md-6 why-us-col">
                        <h4>Professional Tutors</h4>
                        <p>Choose from a myriad of professional and experienced Tutors to be proficient in any subject.</p>
                    </div>
                    <div class="col-md-6 why-us-col">
                        <h4>1-on-1 Live sessions</h4>
                        <p>Connect with your Tutors via 1-on-1 live live sessions and build a deeper understanding in your subject of choice.</p>
                    </div>
                    <div class="col-md-6 why-us-col">
                        <h4>Group Classes</h4>
                        <p>Feel motivated, enthusiastic, and improve your social interaction via group lessons.</p>
                    </div>
                    <div class="col-md-6">
                        <h4>Convenience & Flexibility</h4>
                        <p>Schedule lessons according to your availability and learn at your own pace with no time or space constraints.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<section class="section section-how-it-work section-update">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h6 class="sub-header text-uppercase">How It Works</h6>
                <h2 class="">Our world-class tutors can help you <br/> learn online</h2>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <h3>Self-paced learning</h3>
                    <p>Our self-paced courses provide you the flexibility and convenience of learning at your own pace. The courses are meticulously created by qualified professionals and uploaded for your convenience, allowing you to pace your learning and increase the course content retention. </p>
                    <a class="btn btn--secondary btn--large" href="/dashboard/lessons">Upload a Course</a>
                </div>
                <div class="how-it-works-card-img text-center">
                    <img src="/images/BeigeGrey.jpg" height="360" width="764" class="img-fluid" alt="Self paced">
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <h3>1-on-1 Live classes</h3>
                    <p>Live tutoring software enables tutors to teach students in real time utilizing interactive video conferencing features. As a Student or Parent, you can browse through Tutor profiles and their subject expertise, and thereafter book live lesson.</p>
                    <a class="btn btn--secondary btn--large" href="/teachers">Find a tutor</a>
                </div>
                <div class="how-it-works-card-img text-center">
                    <img src="/images/ezgif.com-gif-maker.gif" height="360" width="764" class="img-fluid" alt="1-on-1 Live">
                </div>
            </div>


        </div>
    </div>
</section>
<?php if ($topRatedTeachers) {?>
<section class="section section-top-tutors section-update">
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h2>Top Rated Tutors</h2>
                </div>
				<?php //echo "<pre>";print_r($topRatedTeachers);die; ?>
				<?php foreach ($topRatedTeachers as $teacher) { ?>
                <div class="col-md-6 col-xl-3">
                    <div class="tutors-card">
                        <div class="tutors-thumb">
                            <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('Image', 'show', [Afile::TYPE_USER_PROFILE_IMAGE, $teacher['user_id'], Afile::SIZE_MEDIUM]), CONF_IMG_CACHE_TIME, '.jpg') ?>" alt="<?php echo $teacher['full_name']; ?>">
                        </div>
                        <div class="tutors-card-content">
                            <div class="tutors-card-content-top d-flex justify-content-between">
                                <span>
                                    <h4><?php echo $teacher['user_first_name'].' '.$teacher['user_last_name']; ?> </h4>
                                    <span class="tutors-flag">
                                        <span>
											 <img width="28" height="20" src="<?php echo CONF_WEBROOT_FRONTEND . 'flags/' . strtolower($teacher['country_name']['code']) . '.svg'; ?>" alt="<?php echo $teacher['country_name']['name']; ?>" style="border: 1px solid #000;" />
                                        </span>
                                        <span><?php echo $teacher['country_name']['name'];?></span>
                                    </span>
                                </span>
                                <span class="rate d-flex">
                                    <sup>$</sup>
                                    <span><?php echo $teacher['min_price']['0']['ustelgpr_price']; ?></span>
                                    <sub>/Hour </<sub>
                                </span>
                            </div>
                            <div class="card-tag">
								<?php foreach ($teacher['languages'] as $lng){ ?>
									<span><?php echo $lng['tlang_name']; ?></span>
								<?php } ?>
                            </div>
                            <div class="tutors-card-content-bottom">
                                <div class="tutors-card-rating">
									<?php for($i=0;$i<$teacher['testat_ratings'];$i++){ ?>
										<span>
											<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5.74163 9.66919C5.90052 9.57329 6.09947 9.57329 6.25836 9.66919L9.1055 11.3876C9.48415 11.6162 9.95127 11.2767 9.85079 10.8459L9.09523 7.60715C9.05306 7.42641 9.11448 7.23717 9.25476 7.11565L11.7727 4.93437C12.1067 4.64498 11.9286 4.09627 11.4883 4.0583L8.17307 3.77243C7.98865 3.75653 7.8281 3.64004 7.75578 3.46965L6.46025 0.417549C6.28784 0.0113675 5.71215 0.0113678 5.53974 0.417549L4.24421 3.46965C4.17189 3.64004 4.01134 3.75653 3.82692 3.77243L0.510242 4.05843C0.0701283 4.09638 -0.108152 4.64465 0.22547 4.9342L2.73932 7.11594C2.87918 7.23733 2.9405 7.42609 2.89867 7.6065L2.14714 10.8477C2.04732 11.2783 2.51421 11.6171 2.89259 11.3888L5.74163 9.66919Z" fill="#E77C40"/>
											</svg>
										</span>
									<?php } ?>
									<?php for($i=0;$i<(5-$teacher['testat_ratings']);$i++){ ?>
										<span>
											<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5.74163 9.66919C5.90052 9.57329 6.09947 9.57329 6.25836 9.66919L9.1055 11.3876C9.48415 11.6162 9.95127 11.2767 9.85079 10.8459L9.09523 7.60715C9.05306 7.42641 9.11448 7.23717 9.25476 7.11565L11.7727 4.93437C12.1067 4.64498 11.9286 4.09627 11.4883 4.0583L8.17307 3.77243C7.98865 3.75653 7.8281 3.64004 7.75578 3.46965L6.46025 0.417549C6.28784 0.0113675 5.71215 0.0113678 5.53974 0.417549L4.24421 3.46965C4.17189 3.64004 4.01134 3.75653 3.82692 3.77243L0.510242 4.05843C0.0701283 4.09638 -0.108152 4.64465 0.22547 4.9342L2.73932 7.11594C2.87918 7.23733 2.9405 7.42609 2.89867 7.6065L2.14714 10.8477C2.04732 11.2783 2.51421 11.6171 2.89259 11.3888L5.74163 9.66919Z" fill="#E77C40"/>
											</svg>
										</span>
									<?php } ?>
                                   <span class="rating-count">(<?php echo $teacher['testat_reviewes']; ?>)</span>
                                </div>
                                <div>
                                    <!--a class="btn btn--secondary btn--large" href="javascript:void();">View Profile </a-->
									 <a href="<?php echo MyUtility::makeUrl('Teachers', 'view', [$teacher['user_username']]); ?>" class="btn btn--secondary btn--large"><?php echo Label::getLabel('LBL_VIEW_DETAILS', $siteLangId); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php } ?>
		   </div>
    </div>
</section>

 <?php } ?>

<section class="section section-to-learn section-update">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>What Subject Do You Want To Learn?</h2>

                <div class="subject-wrap d-flex">
                    <div class="subject-card">
                        <a href="teachers/languages/Accounting"><h4>Accounting</h4></a>
                        <p>5 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Business-Analysis"><h4>Business Analysis</h4></a>
                        <p>6 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Computer-Science"><h4>Computer Science</h4></a>
                        <p>9 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Economics"><h4>Economics</h4></a>
                        <p>10 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Entrepreneurship"><h4>Entrepreneurship</h4></a>
                        <p>9  tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Geography"><h4>Geography</h4></a>
                        <p>9 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/hindi"><h4>Hindi</h4></a>
                        <p>2 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Java-Script"><h4>Java Script</h4></a>
                        <p>1 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Maths"><h4>Maths</h4></a>
                        <p>42 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Physics"><h4>Physics</h4></a>
                        <p>18 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Programming"><h4>Programming</h4></a>
                        <p>10 tutors</p>
                    </div>
                    <div class="subject-card">
                        <a href="teachers/languages/Robotics"><h4>Robotics</h4></a>
                        <p>1 tutors</p>
                    </div>
                </div>

                <div class="text-center">
                    <a href="/teachers/" class="see-more-link">See More Subjects <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 0L6.59 1.41L12.17 7H0V9H12.17L6.59 14.59L8 16L16 8L8 0Z" fill="#323232"/>
                        </svg>              
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="section section-my-online section-update">
    <div class="container">
        <div class="row align-items-center">
        <div class="col-12 col-xl-6">
                <h2>Tutor with MyOnlineTutor</h2>
                <p>MyOnlineTutor provides easy-to-use and competitive features that allow you to plan and deliver your lessons easily and conveniently.</p>
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
                    <span class="my-online-text">Access by Students from around the world</span> 
                </div>

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
                    <span class="my-online-text">Grown your business</span> 
                </div>

                <div class="my-online-icon-text">
                    <span class="my-online-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11 19V22H13V19H14C16.2091 19 18 17.2091 18 15C18 12.7909 16.2091 11 14 11H13V7H15V9H17V5H13V2H11V5H10C7.79086 5 6 6.79086 6 9C6 11.2091 7.79086 13 10 13H11V17H9V15H7V19H11ZM13 17H14C15.1046 17 16 16.1046 16 15C16 13.8954 15.1046 13 14 13H13V17ZM11 11V7H10C8.89543 7 8 7.89543 8 9C8 10.1046 8.89543 11 10 11H11Z" fill="white"/>
                        </svg>
                    </span>  
                    <span class="my-online-text">Get paid securely</span> 
                </div>
                <div class="d-flex align-items-center button-wrapper">
                    <a class="btn btn--secondary btn--large" href="/teacher-request">Become a Tutor </a>
                    <a class="btn btn-link" href="javascript:void();">How Our Platform Works</a>
                </div>
            </div>
            <div class="col-12 col-xl-6">
				<iframe width="100%" height="540" border="0" src="https://www.youtube.com/embed/QD1oqhhej7o"></iframe>
                <!--img src="/images/BeigeGrey.jpg" width="748" height="540" alt="Tutor with MyOnlineTutor" class="img-fluid"-->
            </div>
        </div>
    </div>
</section>

<section class="section section-testimonial section-update">
    <div class="container container--narrow">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Student testimonials</h2>
                <p class="text-center">Don't take our word for it,hear from our students.</p>
                <div class="slider multiple-items testimonail-slider">
				<?php if($ratings){ ?>
					<?php foreach ($ratings as $rating) { ?>
						<div class="testimonail-slider-wrapper">
							<div class="testimonail-item">
								<span class="testimonal-items-rating d-flex">
									<svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.57088 0.612343C9.91462 -0.204115 11.0854 -0.204114 11.4291 0.612346L13.4579 5.43123C13.6029 5.77543 13.9306 6.01061 14.3067 6.0404L19.5727 6.45748C20.4649 6.52814 20.8267 7.62813 20.1469 8.2034L16.1348 11.5987C15.8482 11.8412 15.723 12.2218 15.8106 12.5843L17.0363 17.661C17.244 18.5211 16.2969 19.201 15.533 18.7401L11.0245 16.0196C10.7025 15.8252 10.2975 15.8252 9.97548 16.0196L5.46699 18.7401C4.70311 19.201 3.75596 18.5211 3.96363 17.661L5.18942 12.5843C5.27698 12.2218 5.15182 11.8412 4.86526 11.5987L0.853062 8.2034C0.173282 7.62813 0.535068 6.52814 1.42729 6.45748L6.69336 6.0404C7.0695 6.01061 7.39716 5.77543 7.54207 5.43123L9.57088 0.612343Z" fill="#FF5200"/>
									</svg>
									<svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.57088 0.612343C9.91462 -0.204115 11.0854 -0.204114 11.4291 0.612346L13.4579 5.43123C13.6029 5.77543 13.9306 6.01061 14.3067 6.0404L19.5727 6.45748C20.4649 6.52814 20.8267 7.62813 20.1469 8.2034L16.1348 11.5987C15.8482 11.8412 15.723 12.2218 15.8106 12.5843L17.0363 17.661C17.244 18.5211 16.2969 19.201 15.533 18.7401L11.0245 16.0196C10.7025 15.8252 10.2975 15.8252 9.97548 16.0196L5.46699 18.7401C4.70311 19.201 3.75596 18.5211 3.96363 17.661L5.18942 12.5843C5.27698 12.2218 5.15182 11.8412 4.86526 11.5987L0.853062 8.2034C0.173282 7.62813 0.535068 6.52814 1.42729 6.45748L6.69336 6.0404C7.0695 6.01061 7.39716 5.77543 7.54207 5.43123L9.57088 0.612343Z" fill="#FF5200"/>
									</svg>
									<svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.57088 0.612343C9.91462 -0.204115 11.0854 -0.204114 11.4291 0.612346L13.4579 5.43123C13.6029 5.77543 13.9306 6.01061 14.3067 6.0404L19.5727 6.45748C20.4649 6.52814 20.8267 7.62813 20.1469 8.2034L16.1348 11.5987C15.8482 11.8412 15.723 12.2218 15.8106 12.5843L17.0363 17.661C17.244 18.5211 16.2969 19.201 15.533 18.7401L11.0245 16.0196C10.7025 15.8252 10.2975 15.8252 9.97548 16.0196L5.46699 18.7401C4.70311 19.201 3.75596 18.5211 3.96363 17.661L5.18942 12.5843C5.27698 12.2218 5.15182 11.8412 4.86526 11.5987L0.853062 8.2034C0.173282 7.62813 0.535068 6.52814 1.42729 6.45748L6.69336 6.0404C7.0695 6.01061 7.39716 5.77543 7.54207 5.43123L9.57088 0.612343Z" fill="#FF5200"/>
									</svg>
									<svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.57088 0.612343C9.91462 -0.204115 11.0854 -0.204114 11.4291 0.612346L13.4579 5.43123C13.6029 5.77543 13.9306 6.01061 14.3067 6.0404L19.5727 6.45748C20.4649 6.52814 20.8267 7.62813 20.1469 8.2034L16.1348 11.5987C15.8482 11.8412 15.723 12.2218 15.8106 12.5843L17.0363 17.661C17.244 18.5211 16.2969 19.201 15.533 18.7401L11.0245 16.0196C10.7025 15.8252 10.2975 15.8252 9.97548 16.0196L5.46699 18.7401C4.70311 19.201 3.75596 18.5211 3.96363 17.661L5.18942 12.5843C5.27698 12.2218 5.15182 11.8412 4.86526 11.5987L0.853062 8.2034C0.173282 7.62813 0.535068 6.52814 1.42729 6.45748L6.69336 6.0404C7.0695 6.01061 7.39716 5.77543 7.54207 5.43123L9.57088 0.612343Z" fill="#FF5200"/>
									</svg>
									<svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.57088 0.612343C9.91462 -0.204115 11.0854 -0.204114 11.4291 0.612346L13.4579 5.43123C13.6029 5.77543 13.9306 6.01061 14.3067 6.0404L19.5727 6.45748C20.4649 6.52814 20.8267 7.62813 20.1469 8.2034L16.1348 11.5987C15.8482 11.8412 15.723 12.2218 15.8106 12.5843L17.0363 17.661C17.244 18.5211 16.2969 19.201 15.533 18.7401L11.0245 16.0196C10.7025 15.8252 10.2975 15.8252 9.97548 16.0196L5.46699 18.7401C4.70311 19.201 3.75596 18.5211 3.96363 17.661L5.18942 12.5843C5.27698 12.2218 5.15182 11.8412 4.86526 11.5987L0.853062 8.2034C0.173282 7.62813 0.535068 6.52814 1.42729 6.45748L6.69336 6.0404C7.0695 6.01061 7.39716 5.77543 7.54207 5.43123L9.57088 0.612343Z" fill="#FF5200"/>
									</svg>
								</span>
								<p>"<?php echo $rating['ratrev_detail']; ?>"</p>

								<span class="d-flex align-items-center">
									<span class="testimonal-user-thumb d-flex align-items-center">
										<img src="/images/avatar-Image.png" height="56" width="56" class="img-fluid" alt="user thumb"> 
									</span>
									<span class="testimonal-username">
										<h6><?php echo $rating['user_first_name'].' '.$rating['user_last_name']; ?> </h6>
										<p>Student</p>
									</span>
								</span>
							</div>
						</div>
				<?php } } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-footer-links section-update">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-links-wrapper d-flex flex-wrap justify-content-center">
                    <div class="footer-links">
                        <h5>Language Tutor for children</h5>
                        <ul>
                            <li>
                                <a href="teachers/languages/English">English classes for kids</a>
                            </li>
                            <li>
                                <a href="teachers/languages/French">Spanish classes for kids</a>
                            </li>
                            <li>
                                <a href="teachers/languages/French">French classes for kids</a>
                            </li>
                            <li>
                                <a href="teachers/languages/Chinese">Chinese classes for kids</a>
                            </li>
                            <li>
                                <a href="teachers/languages/German">German classes for kids</a>
                            </li>
                        </ul>
                    </div>

                    <div class="footer-links">
                        <h5>Native speaking tutors</h5>
                        <ul>
                            <li>
                                <a href="teachers/languages/Business-English">English native speaking tutors</a>
                            </li>
                            <li>
                                <a href="teachers/languages/Spanish">Spanish native speaking tutors</a>
                            </li>
                            <li>
                                <a href="teachers/languages/French">French native speaking tutors</a>
                            </li>
                            <li>
                                <a href="teachers/languages/Chinese">Chinese native speaking tutors</a>
                            </li>
                            <li>
                                <a href="teachers/languages/German">German native speaking tutors</a>
                            </li>
                        </ul>
                    </div>


                    <div class="footer-links">
                        <h5>Language tutors for conversational classes</h5>
                        <ul>
                            <li>
                                <a href="teachers/languages/Business-English">English conversational classes</a>
                            </li>
                            <li>
                                <a href="teachers/languages/Spanish">Spanish conversational classes</a>
                            </li>
                            <li>
                                <a href="teachers/languages/French">French conversational classes</a>
                            </li>
                            <li>
                                <a href="teachers/languages/Chinese">Chinese conversational classes</a>
                            </li>
                            <li>
                                <a href="teachers/languages/German">German conversational classes</a>
                            </li>
                        </ul>
                    </div>


                    <div class="footer-links">
                        <h5>Language tutors for beginners</h5>
                        <ul>
                            <li>
                                <a href="teachers/languages/English">English tutors for beginners</a>
                            </li>
                            <li>
                                <a href="teachers/languages/Spanish">Spanish tutors for beginners</a>
                            </li>
                            <li>
                                <a href="teachers/languages/French">French tutors for beginners</a>
                            </li>
                            <li>
                                <a href="teachers/languages/Chinese">Chinese tutors for beginners</a>
                            </li>
                            <li>
                                <a href="teachers/languages/German">German tutors for beginners</a>
                            </li>
                        </ul>
                    </div>


                    <div class="footer-links">
                        <h5>Tutors for test preparation</h5>
                        <ul>
                            <li>
                                <a href="javascript:void(0);">IELTS tutors</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">TOEFL tutors</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">CAEL tutors</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">DALF tutors</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">DELE tutors</a>
                            </li>
                        </ul>
                    </div>

                    <div class="footer-links">
                        <h5>Tutors for other specialities</h5>
                        <ul>
                            <li>
                                <a href="javascript:void(0);">English tutors for adults</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">English classes for Spanish speakers</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Business English tutors</a>
                            </li>
                            <li>
                                <a href="teachers/languages/Spanish">Spanish tutors for high school students</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Intensive Spanish tutors</a>
                            </li>
                        </ul>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</section>


<?php
/*
if (!empty($whyUsBlock)) {
    echo html_entity_decode($whyUsBlock);
}
if (!empty($popularLanguages)) {
?>
    <section class="section section--language">
        <div class="container container--narrow">
            <div class="section__head">
                <h2><?php echo Label::getLabel('LBL_WHAT_LANGUAGE_YOU_WANT_TO_LEARN?'); ?></h2>
            </div>
            <div class="section__body">
                <div class="flag-wrapper">
                    <?php foreach ($popularLanguages as $language) { ?>
                        <div class="flag__box">
                            <div class="flag__media">
                                <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('Image', 'show', [Afile::TYPE_FLAG_TEACHING_LANGUAGES, $language['tlang_id'], Afile::SIZE_MEDIUM]), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $language['tlang_name']; ?>">
                            </div>
                            <div class="flag__name">
                                <span><?php echo $language['tlang_name'] ?></span>
                                <div class="lesson-count"></div>
                            </div>
                            <a class="flag__action" href="<?php echo MyUtility::makeUrl('Teachers', 'languages', [$language['tlang_slug']]); ?>"></a>
                        </div>
                    <?php } ?>
                </div>
                <div class="more-info align-center">
                    <p><?php echo Label::getLabel("LBL_DIFFERENT_LANGUAGE_NOTE"); ?> <a href="<?php echo MyUtility::makeUrl('teachers'); ?>"><?php echo Label::getLabel('LBL_BROWSE_THEM_NOW'); ?></a></p>
                </div>
            </div>
        </div>
    </section>
<?php
}
if ($topRatedTeachers) {
?>
    <section class="section padding-bottom-5">
        <div class="container container--narrow">
            <div class="section__head">
                <h2><?php echo Label::getLabel('LBL_TOP_RATED_TEACHERS', $siteLangId); ?></h2>
            </div>
            <div class="section__body">
                <div class="teacher-wrapper">
                    <div class="row">
                        <?php foreach ($topRatedTeachers as $teacher) { ?>
                            <div class="col-auto col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="tile">
                                    <div class="tile__head">
                                        <div class="tile__media ratio ratio--1by1">
                                            <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('Image', 'show', [Afile::TYPE_USER_PROFILE_IMAGE, $teacher['user_id'], Afile::SIZE_MEDIUM]), CONF_IMG_CACHE_TIME, '.jpg') ?>" alt="<?php echo $teacher['full_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="tile__body">
                                        <a class="tile__title" href="<?php echo MyUtility::makeUrl('Teachers', 'view', [$teacher['user_username']]); ?>">
                                            <h4><?php echo $teacher['full_name']; ?></h4>
                                        </a>
                                        <div class="info-wrapper">
                                            <div class="info-tag location">
                                                <svg class="icon icon--location">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#location'; ?>"></use>
                                                </svg>
                                                <span class="lacation__name"><?php echo $teacher['country_name']['name'] ?? ''; ?></span>
                                            </div>
                                            <div class="info-tag ratings">
                                                <svg class="icon icon--rating">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#rating' ?>"></use>
                                                </svg>
                                                <span class="value"><?php echo $teacher['testat_ratings']; ?></span>
                                                <span class="count">(<?php echo $teacher['testat_reviewes']; ?>)</span>
                                            </div>
                                        </div>
                                        <div class="card__row--action ">
                                            <a href="<?php echo MyUtility::makeUrl('Teachers', 'view', [$teacher['user_username']]); ?>" class="btn btn--primary btn--block"><?php echo Label::getLabel('LBL_VIEW_DETAILS', $siteLangId); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }
if (!empty($browseTutorPage)) { ?>
    <?php echo html_entity_decode($browseTutorPage); ?>
<?php }
if (count($classes) > 0) { ?>
    <section class="section section--gray section--upcoming-class">
        <div class="container container--narrow">
            <div class="section__head d-flex justify-content-between align-items-center">
                <h2><?php echo Label::getLabel('LBL_UPCOMING_GROUP_CLASSES'); ?></h2>
                <a class="view-all" href="<?php echo MyUtility::makeUrl('GroupClasses'); ?>"><?php echo Label::getLabel("LBL_VIEW_ALL", $siteLangId); ?></a>
            </div>
            <div class="section__body">
                <div class="slider slider--onethird slider-onethird-js">
                    <?php
                    foreach ($classes as $class) {
                        $classData = ['class' => $class, 'siteUserId' => $siteUserId, 'bookingBefore' => $bookingBefore, 'cardClass' => 'card-class-cover'];
                        $this->includeTemplate('group-classes/card.php', $classData, false);
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php }
if ($testmonialList) { ?>
    <section class="section section--quote">
        <div class="container container--narrow">
            <div class="quote-slider">
                <div class="slider slider--quote slider-quote-js">
                    <?php foreach ($testmonialList as $testmonialDetail) { ?>
                        <div>
                            <div class="slider__item">
                                <div class="quote">
                                    <div class="quote__media">
                                        <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('Image', 'show', [Afile::TYPE_TESTIMONIAL_IMAGE, $testmonialDetail['testimonial_id'], Afile::SIZE_LARGE]), CONF_DEF_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $testmonialDetail['testimonial_user_name']; ?>">
                                        <div class="quote__box">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="30.857" viewBox="0 0 36 30.857">
                                                <g transform="translate(0 -29.235)">
                                                    <path d="M233.882,29.235V44.664h10.286a10.3,10.3,0,0,1-10.286,10.286v5.143a15.445,15.445,0,0,0,15.429-15.429V29.235Z" transform="translate(-213.311)" />
                                                    <path d="M0,44.664H10.286A10.3,10.3,0,0,1,0,54.949v5.143A15.445,15.445,0,0,0,15.429,44.664V29.235H0Z" transform="translate(0 0)" />
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="quote__content">
                                        <p><?php echo $testmonialDetail['testimonial_text']; ?></p>
                                        <div class="quote-info">
                                            <h4><?php echo $testmonialDetail['testimonial_user_name']; ?></h4>
                                        </div>
                                        <div class="quote__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="138" height="118.286" viewBox="0 0 138 118.286">
                                                <g transform="translate(0 -29.235)">
                                                    <path d="M233.882,29.235V88.378H273.31a39.474,39.474,0,0,1-39.429,39.429v19.714a59.208,59.208,0,0,0,59.143-59.143V29.235Z" transform="translate(-155.025 0)" />
                                                    <path class="b" d="M0,88.378H39.429A39.474,39.474,0,0,1,0,127.806v19.714A59.208,59.208,0,0,0,59.143,88.378V29.235H0Z" transform="translate(0 0)" />
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php
}
if (!empty($startLearning)) {
    echo html_entity_decode($startLearning);
}
if ($blogPostsList) {
?>
    <section class="section">
        <div class="container container--narrow">
            <div class="section__head d-flex justify-content-between align-items-center">
                <h2><?php echo Label::getLabel('LBL_Latest_Blogs'); ?></h2>
                <a class="view-all" href="<?php echo MyUtility::makeUrl('Blog') ?>"><?php echo Label::getLabel('LBL_View_Blogs'); ?></a>
            </div>
            <div class="section__body">
                <div class="blog-wrapper">
                    <div class="slider slider--onehalf slider-onehalf-js">
                        <?php foreach ($blogPostsList as $postDetail) { ?>
                            <div>
                                <div class="slider__item">
                                    <div class="blog-card">
                                        <div class="blog__head">
                                            <div class="blog__media ratio ratio--4by3">
                                                <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeFullUrl('Image', 'show', [Afile::TYPE_BLOG_POST_IMAGE, $postDetail['post_id'], Afile::SIZE_MEDIUM]), CONF_DEF_CACHE_TIME, '.jpg') ?>" alt="<?php echo $postDetail['post_title']; ?>">
                                            </div>
                                        </div>
                                        <div class="blog__body">
                                            <div class="blog__detail">
                                                <div class="tags-inline__item"><?php echo $postDetail['bpcategory_name']; ?></div>
                                                <div class="blog__title">
                                                    <h3><?php echo $postDetail['post_title'] ?></h3>
                                                </div>
                                                <div class="blog__date">
                                                    <svg class="icon icon--calendar">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#calendar' ?>"></use>
                                                    </svg>
                                                    <span><?php echo MyDate::formatDate($postDetail['post_published_on']); ?> </span>
                                                </div>
                                                <a href="<?php echo MyUtility::makeUrl('Blog', 'PostDetail', [$postDetail['post_id']]); ?>" class="btn btn--secondary"><?php echo Label::getLabel('LBL_VIEW_BLOG'); ?></a>
                                            </div>
                                        </div>
                                        <a href="<?php echo MyUtility::makeUrl('Blog', 'PostDetail', [$postDetail['post_id']]); ?>" class="blog__action"></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }*/ ?>
<script>
    LANGUAGES = <?php echo json_encode($teachLangs); ?>;
</script>