<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $headerClasses = strtolower($controllerName) . ' ' . strtolower($controllerName) . '-' . strtolower($actionName); ?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" class="<?php echo MyUtility::isDemoUrl() ? 'sticky-demo-header' : ''; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="">
        <meta name="description" content="MyOnlineTutor is a online tutoring platform that provides experienced and world-class tutors that can help you learn online to achieve your goals.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, maximum-scale=1.0,user-scalable=0" />
        <meta name="facebook-domain-verification" content="091gbyrwjerr1mzr56q40r2i77vjc7" />
        <?php echo $this->writeMetaTags(); ?>
        <link rel="shortcut icon" href="<?php echo MyUtility::makeUrl('Image', 'show', [Afile::TYPE_FAVICON, 0, Afile::SIZE_ORIGINAL]); ?>">
        <link rel="apple-touch-icon" href="<?php echo MyUtility::makeUrl('Image', 'show', [Afile::TYPE_APPLE_TOUCH_ICON, 0, Afile::SIZE_LARGE]); ?>">
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-262542082-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-262542082-1');
        </script>
        <?php if (!empty($canonicalUrl)) { ?>
            <link rel="canonical" href="<?php echo $canonicalUrl; ?>" />
        <?php } ?>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <script type="text/javascript">
            var langLbl = <?php echo json_encode(CommonHelper::htmlEntitiesDecode($jsVariables)); ?>;
            var timeZoneOffset = '<?php echo MyDate::getOffset($siteTimezone); ?>';
            var layoutDirection = '<?php echo $siteLanguage['language_direction']; ?>';
            var currencySymbolLeft = '<?php echo $siteCurrency['currency_symbol_left']; ?>';
            var currencySymbolRight = '<?php echo $siteCurrency['currency_symbol_right']; ?>';
            var SslUsed = '<?php echo FatApp::getConfig('CONF_USE_SSL'); ?>';
            var cookieConsent = <?php echo json_encode($cookieConsent); ?>;
            const confWebRootUrl = '<?php echo CONF_WEBROOT_URL; ?>';
            const confFrontEndUrl = '<?php echo CONF_WEBROOT_URL; ?>';
            const confWebDashUrl = '<?php echo CONF_WEBROOT_DASHBOARD; ?>';
            const FTRAIL_TYPE = '<?php echo Lesson::TYPE_FTRAIL; ?>';
            var ALERT_CLOSE_TIME = <?php echo FatApp::getConfig("CONF_AUTO_CLOSE_ALERT_TIME"); ?>;
<?php
/**
 * Note var names of monthNames, weekDayNames and meridiems must not be changed
 */
if (isset($setMonthAndWeekNames) && $setMonthAndWeekNames) {
    ?>
                var monthNames = <?php echo json_encode(CommonHelper::htmlEntitiesDecode(MyDate::getAllMonthName(false, $siteLangId))); ?>;
                var weekDayNames = <?php echo json_encode(CommonHelper::htmlEntitiesDecode(MyDate::dayNames(false, $siteLangId))); ?>;
                var meridiems = <?php echo json_encode(CommonHelper::htmlEntitiesDecode(MyDate::meridiems(false, $siteLangId))); ?>;
<?php } ?>
        </script>
        <?php if (!empty($includeEditor)) { ?>
            <script src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/innovaeditor.js"></script>
            <script src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/common/webfont.js"></script>
        <?php } ?>
        <?php if (FatApp::getConfig('CONF_ENABLE_PWA')) { ?>
            <link rel="manifest" href="<?php echo MyUtility::makeUrl('Pwa'); ?>">
            <script>
                if ("serviceWorker" in navigator) {
                    navigator.serviceWorker.register("<?php echo CONF_WEBROOT_FRONTEND; ?>sw.js");
                }
            </script>
        <?php } ?>
        <?php
        echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE);
        echo Common::setThemeColorStyle();
        ?>
        <script>
            $(document).ready(function () {
<?php if ($siteUserId > 0) { ?>
                    setTimeout(getBadgeCount(), 1000);
<?php } if (!empty($messageData['msgs'][0] ?? '')) { ?>
                    fcom.success('<?php echo $messageData['msgs'][0]; ?>');
<?php } if (!empty($messageData['dialog'][0] ?? '')) { ?>
                    fcom.warning('<?php echo $messageData['dialog'][0]; ?>');
<?php } if (!empty($messageData['errs'][0] ?? '')) { ?>
                    fcom.error('<?php echo $messageData['errs'][0]; ?>');
<?php } ?>
            });
        </script>
    <style>
            @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&display=swap');
            @font-face {
            font-family: 'BespokeSerif-Variable';
            src: url('/fonts/BespokeSerif-Variable.woff2') format('woff2'),
                url('/fonts/BespokeSerif-Variable.woff') format('woff'),
                url('/fonts/BespokeSerif-Variable.ttf') format('truetype');
                font-weight: 300 800;
                font-display: swap;
                font-style: normal;
            }


            /**
            * This is a variable font
            * You can controll variable axes as shown below:
            * font-variation-settings: 'wght' 300.0 'wght' 800.0;
            *
            * available axes:

            * 'wght' (range from 300.0 to 800.0)

            * 'wght' (range from 300.0 to 800.0)

            */

            @font-face {
            font-family: 'BespokeSerif-VariableItalic';
            src: url('/fonts/BespokeSerif-VariableItalic.woff2') format('woff2'),
                url('/fonts/BespokeSerif-VariableItalic.woff') format('woff'),
                url('/fonts/BespokeSerif-VariableItalic.ttf') format('truetype');
                font-weight: 300 800;
                font-display: swap;
                font-style: italic;
            }


            @font-face {
            font-family: 'BespokeSerif-Light';
            src: url('/fonts/BespokeSerif-Light.woff2') format('woff2'),
                url('/fonts/BespokeSerif-Light.woff') format('woff'),
                url('/fonts/BespokeSerif-Light.ttf') format('truetype');
                font-weight: 300;
                font-display: swap;
                font-style: normal;
            }


            @font-face {
            font-family: 'BespokeSerif-LightItalic';
            src: url('/fonts/BespokeSerif-LightItalic.woff2') format('woff2'),
                url('/fonts/BespokeSerif-LightItalic.woff') format('woff'),
                url('/fonts/BespokeSerif-LightItalic.ttf') format('truetype');
                font-weight: 300;
                font-display: swap;
                font-style: italic;
            }


            @font-face {
            font-family: 'BespokeSerif-Regular';
            src: url('/fonts/BespokeSerif-Regular.woff2') format('woff2'),
                url('/fonts/BespokeSerif-Regular.woff') format('woff'),
                url('/fonts/BespokeSerif-Regular.ttf') format('truetype');
                font-weight: 400;
                font-display: swap;
                font-style: normal;
            }


            @font-face {
            font-family: 'BespokeSerif-Italic';
            src: url('/fonts/BespokeSerif-Italic.woff2') format('woff2'),
                url('/fonts/BespokeSerif-Italic.woff') format('woff'),
                url('/fonts/BespokeSerif-Italic.ttf') format('truetype');
                font-weight: 400;
                font-display: swap;
                font-style: italic;
            }


            @font-face {
            font-family: 'BespokeSerif-Medium';
            src: url('/fonts/BespokeSerif-Medium.woff2') format('woff2'),
                url('/fonts/BespokeSerif-Medium.woff') format('woff'),
                url('/fonts/BespokeSerif-Medium.ttf') format('truetype');
                font-weight: 500;
                font-display: swap;
                font-style: normal;
            }


            @font-face {
            font-family: 'BespokeSerif-MediumItalic';
            src: url('/fonts/BespokeSerif-MediumItalic.woff2') format('woff2'),
                url('/fonts/BespokeSerif-MediumItalic.woff') format('woff'),
                url('/fonts/BespokeSerif-MediumItalic.ttf') format('truetype');
                font-weight: 500;
                font-display: swap;
                font-style: italic;
            }


            @font-face {
            font-family: 'BespokeSerif-Bold';
            src: url('/fonts/BespokeSerif-Bold.woff2') format('woff2'),
                url('/fonts/BespokeSerif-Bold.woff') format('woff'),
                url('/fonts/BespokeSerif-Bold.ttf') format('truetype');
                font-weight: 700;
                font-display: swap;
                font-style: normal;
            }


            @font-face {
            font-family: 'BespokeSerif-BoldItalic';
            src: url('/fonts/BespokeSerif-BoldItalic.woff2') format('woff2'),
                url('/fonts/BespokeSerif-BoldItalic.woff') format('woff'),
                url('/fonts/BespokeSerif-BoldItalic.ttf') format('truetype');
                font-weight: 700;
                font-display: swap;
                font-style: italic;
            }


            @font-face {
            font-family: 'BespokeSerif-Extrabold';
            src: url('/fonts/BespokeSerif-Extrabold.woff2') format('woff2'),
                url('/fonts/BespokeSerif-Extrabold.woff') format('woff'),
                url('/fonts/BespokeSerif-Extrabold.ttf') format('truetype');
                font-weight: 800;
                font-display: swap;
                font-style: normal;
            }


            @font-face {
            font-family: 'BespokeSerif-ExtraboldItalic';
            src: url('/fonts/BespokeSerif-ExtraboldItalic.woff2') format('woff2'),
                url('/fonts/BespokeSerif-ExtraboldItalic.woff') format('woff'),
                url('/fonts/BespokeSerif-ExtraboldItalic.ttf') format('truetype');
                font-weight: 800;
                font-display: swap;
                font-style: italic;
            }

            h1,h2{
                font-family: 'BespokeSerif-Bold';
            }
            body{
                font-family: 'Lexend', sans-serif;
                font-weight: 400;
            }
            .section-update .sub-header,.section-update h4,h3,h5,h6,.btn{
                font-family: 'Lexend', sans-serif;
            }
            .btn{
                font-weight: 400;
            }
            .section-my-online .btn{
                font-weight: 600;
            }
            .section-update .container{
                width: 100%;
            }
            .section-update ,.section-update.section-how-it-works,.section--listing,.section.section--profile{
                padding: 80px 65px;
            }
            .section-top-tutors{
                padding: 80px 0;
            }
            .section--listing{
                padding-top: 0;
            }

            @media(min-width: 1499px){
                section.section-update .container,.section--profile .container,.section--listing .container {
                    max-width: 1800px;
                    width: 100%;
                }
            }
            @media(max-width: 1270px){
                .section-update, .section-update.section-how-it-works, .section--listing,.section--profile {
                    padding: 80px 0;
                }
            }
            @media(max-width: 991px){
                .section-update,.section-update.section-how-it-works,.section--listing{
                    padding: 30px 0;
                }
            }
    </style>

    </head>
    <?php $isPreviewOn = MyUtility::isDemoUrl() ? 'is-preview-on' : ''; ?>
    <body class="<?php echo $headerClasses . ' ' . $isPreviewOn; ?>" dir="<?php echo $siteLanguage['language_direction']; ?>">
        <!-- Custom Loader -->
        <div id="app-alert" class="alert-position alert-position--top-right">
            <alert role="alert" class="alert">
                <alert-icon class="alert__icon"></alert-icon>
                <alert-message class="alert__message"><p></p></alert-message>
                <alert-close class="alert__close" onclick="$.appalert.close();"></alert-close>
            </alert>
        </div>
        <?php
        if (MyUtility::isDemoUrl()) {
            include(CONF_INSTALLATION_PATH . 'restore/view/header-bar.php');
        }
        if (isset($_SESSION['preview_theme'])) {
            $this->includeTemplate('_partial/preview.php', array(), false);
        }
        $websiteName = FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '');
        if (!isset($exculdeMainHeaderDiv)) {
            ?>
            <header class="header">
                <div class="header-primary">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="header__left">
                                <a href="javascript:void(0)" class="toggle toggle--nav toggle--nav-js">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 515.555 515.555">
                                    <path d="m303.347 18.875c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0" />
                                    <path d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0" />
                                    <path d="m303.347 405.541c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0" />
                                    </svg>
                                </a>
                                <div class="header__logo">
                                    <a href="<?php echo MyUtility::makeUrl(); ?>" title="<?php echo $websiteName; ?>">
                                        <?php if (MyUtility::isDemoUrl()) { ?>
                                            <img src="<?php echo CONF_WEBROOT_FRONTEND . 'images/yocoach-logo.svg'; ?>" alt="<?php echo $websiteName; ?>" />
                                        <?php } else { ?>
                                            <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeFullUrl('Image', 'show', [Afile::TYPE_FRONT_LOGO, 0, Afile::SIZE_LARGE]), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $websiteName; ?>">
                                        <?php } ?>
										
										<!--img src="<?php echo CONF_WEBROOT_FRONTEND . 'images/logo-online-tutor.png'; ?>" alt="<?php echo $websiteName; ?>" /-->
                                    </a>
                                </div>
                                <div class="header-dropdown header-dropdown--explore">
                                    <a class="header-dropdown__trigger trigger-js" href="#explore">
                                        <svg class="icon icon--menu">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#burger-menu'; ?>"></use>
                                        </svg>
                                        <span><?php echo Label::getLabel('LBL_EXPLORE_SUBJECTS'); ?></span>
                                    </a>
									
                                    <div id="explore" class="header-dropdown__target">
                                        <div class="dropdown__cover">
                                            <nav class="menu--inline">
                                                <ul>
                                                    <?php foreach ($teachLangs as $teachLangId => $teachlang) { ?>
                                                        <li class="menu__item">
                                                            <a href="<?php echo MyUtility::makeUrl('Teachers', 'languages', [$teachlang['tlang_slug']], CONF_WEBROOT_FRONTEND); ?>"><?php echo $teachlang['tlang_name']; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header__middle">
                                <?php if (!empty($headerNav)) { ?>
                                    <span class="overlay overlay--nav toggle--nav-js is-active"></span>
                                    <nav class="menu nav--primary-offset">
                                        <ul>
                                            <?php foreach ($headerNav as $nav) { ?>
                                                <?php
                                                if ($nav['pages']) {
                                                    foreach ($nav['pages'] as $link) {
                                                        $navUrl = CommonHelper::getnavigationUrl($link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id']);
                                                        ?>
                                                        <li class="menu__item"><a target="<?php echo $link['nlink_target']; ?>" href="<?php echo $navUrl; ?>"><?php echo $link['nlink_caption']; ?></a></li>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </nav>
                                <?php } ?>
                            </div>
                            <div class="header__right">
                                <div class="header-controls">
                                    <div class="header-controls__item">
                                        <a href="<?php echo MyUtility::makeUrl('', '', [], CONF_WEBROOT_FRONTEND); ?>" class="header-controls__action">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16.076" viewBox="0 0 18 16.076">
                                            <path d="M15.727,17.428H4.273a.818.818,0,0,1-.818-.818V9.246H1L9.449,1.565a.818.818,0,0,1,1.1,0L19,9.246H16.545v7.364A.818.818,0,0,1,15.727,17.428Zm-4.909-1.636h4.091V7.738L10,3.275,5.091,7.738v8.053H9.182V10.882h1.636Z" transform="translate(-1 -1.352)" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="header-controls__item header-dropdown header-dropdown--arrow">
                                        <a class="header-controls__action header-dropdown__trigger trigger-js" href="#languages-nav">
                                            <svg class="icon icon--globe">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#globe'; ?>"></use>
                                            </svg>
                                            <span class="lang"><?php echo $siteLanguage['language_code'] . ' - ' . $siteCurrency['currency_code']; ?></span>
                                            <svg class="icon icon--arrow">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#arrow-black' ?>"></use>
                                            </svg>
                                        </a>
                                        <div id="languages-nav" class="header-dropdown__target">
                                            <div class="dropdown__cover">
                                                <div class="settings-group">
                                                    <?php if (count($siteLanguages) > 1) { ?>
                                                        <div class="settings toggle-group">
                                                            <div class="dropdaown__title"><?php echo Label::getLabel('LBL_SITE_LANGUAGE') ?></div>
                                                            <a class="btn btn--bordered color-black btn--block btn--dropdown settings__trigger settings__trigger-js"><?php echo $siteLanguage['language_name']; ?></a>
                                                            <div class="settings__target settings__target-js" style="display: none;">
                                                                <ul>
                                                                    <?php foreach ($siteLanguages as $language) { ?>
                                                                        <li <?php echo ($siteLangId == $language['language_id']) ? 'class="is--active"' : ''; ?>>
                                                                            <a <?php echo ($siteLangId != $language['language_id']) ? 'onclick="setSiteLanguage(' . $language['language_id'] . ')"' : ''; ?> href="javascript:void(0)"><?php echo $language['language_name']; ?></a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (count($siteCurrencies) > 1) { ?>
                                                        <div class="settings toggle-group">
                                                            <div class="dropdaown__title"><?php echo Label::getLabel('LBL_SITE_CURRENCY'); ?></div>
                                                            <a class="btn btn--bordered color-black btn--block btn--dropdown settings__trigger settings__trigger-js"><?php echo $siteCurrency['currency_name']; ?></a>
                                                            <div class="settings__target settings__target-js" style="display: none;">
                                                                <ul>
                                                                    <?php foreach ($siteCurrencies as $currency) { ?>
                                                                        <li <?php echo ($siteCurrency['currency_id'] == $currency['currency_id']) ? 'class="is--active"' : ''; ?>>
                                                                            <a <?php echo ($siteCurrency['currency_id'] != $currency['currency_id']) ? 'onclick="setSiteCurrency(' . $currency['currency_id'] . ')"' : ''; ?> href="javascript:void(0);"><?php echo $currency['currency_code']; ?></a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($siteUserId > 0) { ?>
                                        <div class="header-controls__item header--notification">
                                            <a href="<?php echo MyUtility::makeUrl('Notifications', '', [], CONF_WEBROOT_DASHBOARD); ?>" class="header-controls__action" title="<?php echo Label::getLabel('LBL_NOTIFICATIONS'); ?>">
                                                <span class="notification-count-js"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16.8" viewBox="0 0 16 16.8">
                                                <path d="M16.4,14H18v1.6H2V14H3.6V8.4a6.4,6.4,0,0,1,12.8,0Zm-1.6,0V8.4a4.8,4.8,0,0,0-9.6,0V14ZM7.6,17.2h4.8v1.6H7.6Z" transform="translate(-2 -2)" />
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="header-controls__item header--message">
                                            <a href="<?php echo MyUtility::makeUrl('Messages', '', [], CONF_WEBROOT_DASHBOARD); ?>" class="header-controls__action" title="<?php echo Label::getLabel('LBL_MESSAGES'); ?>">
                                                <span class="message-count-js"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.4" viewBox="0 0 16 14.4">
                                                <path d="M2.8,3H17.2a.8.8,0,0,1,.8.8V16.6a.8.8,0,0,1-.8.8H2.8a.8.8,0,0,1-.8-.8V3.8A.8.8,0,0,1,2.8,3ZM16.4,6.39l-6.342,5.68L3.6,6.373V15.8H16.4ZM4.009,4.6l6.04,5.33L16,4.6Z" transform="translate(-2 -3)" />
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="header-dropdown header-dropwown--profile">
                                            <a class="header-dropdown__trigger trigger-js" href="#profile-nav">
                                                <div class="teacher-profile">
                                                    <div class="teacher__media">
                                                        <div class="avtar avtar--xsmall" data-title="<?php echo CommonHelper::getFirstChar($siteUser['user_first_name']); ?>">
                                                            <?php echo '<img src="' . MyUtility::makeUrl('Image', 'show', array(Afile::TYPE_USER_PROFILE_IMAGE, $siteUserId, Afile::SIZE_SMALL)) . '?' . time() . '" alt="" />'; ?>
                                                        </div>
                                                    </div>
                                                    <div class="teacher__name"><?php echo $siteUser['user_first_name']; ?></div>
                                                    <svg class="icon icon--arrow">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#arrow-black' ?>"></use>
                                                    </svg>
                                                </div>
                                            </a>
											
                                            <div id="profile-nav" class="header-dropdown__target">
                                                <div class="dropdown__cover">
                                                    <nav class="menu--inline">
                                                        <ul>
                                                            <?php if ($siteUserType == User::TEACHER) { ?>
                                                                <li class="menu__item <?php echo ("Teacher" == $controllerName) ? 'is-active' : ''; ?>"><a href="<?php echo MyUtility::makeUrl('Teacher', '', [], CONF_WEBROOT_DASHBOARD); ?>"><?php echo Label::getLabel('LBL_Dashboard'); ?></a></li>
                                                                <li class="menu__item <?php echo ("Students" == $controllerName) ? 'is-active' : ''; ?>"><a href="<?php echo MyUtility::makeUrl('Students', '', [], CONF_WEBROOT_DASHBOARD); ?>"><?php echo Label::getLabel('LBL_My_Students'); ?></a></li>
                                                                <li class="menu__item <?php echo ("Lessons" == $controllerName) ? 'is-active' : ''; ?>"><a href="<?php echo MyUtility::makeUrl('Lessons', '', [], CONF_WEBROOT_DASHBOARD); ?>"><?php echo Label::getLabel('LBL_Lessons'); ?></a></li>
                                                                <?php
                                                            }
                                                            if ($siteUserType == User::LEARNER) {
                                                                ?>
                                                                <li class="menu__item <?php echo ("Learner" == $controllerName) ? 'is-active' : ''; ?>"><a href="<?php echo MyUtility::makeUrl('Learner', '', [], CONF_WEBROOT_DASHBOARD); ?>"><?php echo Label::getLabel('LBL_Dashboard'); ?></a></li>
                                                                <li class="menu__item <?php echo ("Teachers" == $controllerName) ? 'is-active' : ''; ?>"><a href="<?php echo MyUtility::makeUrl('Teachers', '', [], CONF_WEBROOT_DASHBOARD); ?>"><?php echo Label::getLabel('LBL_My_Teachers'); ?></a></li>
                                                                <li class="menu__item <?php echo ("Lessons" == $controllerName) ? 'is-active' : ''; ?>"><a href="<?php echo MyUtility::makeUrl('Lessons', '', [], CONF_WEBROOT_DASHBOARD); ?>"><?php echo Label::getLabel('LBL_Lessons'); ?></a></li>
                                                            <?php }
                                                            ?>
                                                            <li class="menu__item <?php echo ("Account" == $controllerName && "profileInfo" == $action) ? 'is-active' : ''; ?>"><a href="<?php echo MyUtility::makeUrl('Account', 'ProfileInfo', [], CONF_WEBROOT_DASHBOARD); ?>"><?php echo Label::getLabel('LBL_Settings'); ?></a></li>
                                                            <li class="menu__item">
															<!--a href="<?php echo MyUtility::makeUrl('Account', 'logout', [], CONF_WEBROOT_DASHBOARD); ?>"><?php echo Label::getLabel('LBL_Logout'); ?>
															</a-->
															<a href="javascript:void(0);" class="clear_session_front"><?php echo Label::getLabel('LBL_Logout'); ?>
															</a>
															</li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="header-controls__item header-action">
                                            <div class="header__action">
                                                <!--a href="javascript:void(0)" onClick="signinForm();" class="header-controls__action btn btn--bordered color-primary user-click"><?php echo Label::getLabel('LBL_Login'); ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18.375" viewBox="0 0 18.331 15.331" id="enter">
                                                    <path d="M17.692 0h-11.5a.639.639 0 00-.639.639V5.11a.639.639 0 101.278 0V1.278h10.222v12.775H6.833v-3.832a.639.639 0 00-1.278 0v4.472a.639.639 0 00.639.639h11.5a.639.639 0 00.639-.639V.639A.639.639 0 0017.692 0z"></path>
                                                    <path d="M9.936 9.769a.639.639 0 00.9.9l2.555-2.555q.022-.022.042-.046l.017-.023.02-.027.017-.028.015-.026.014-.029.013-.028c0-.009.007-.019.01-.029l.011-.03c.004-.01.005-.019.007-.029l.008-.032c.002-.011 0-.023.005-.034s0-.018 0-.028a.643.643 0 000-.126v-.028c0-.009 0-.023-.005-.034s-.005-.021-.008-.032 0-.019-.007-.029-.007-.02-.011-.03l-.01-.029c-.003-.01-.009-.018-.013-.028l-.014-.029-.015-.026-.017-.028-.02-.027-.017-.023q-.02-.024-.042-.046L10.84 4.659a.639.639 0 00-.9.9l1.46 1.468H.639A.639.639 0 000 7.666a.639.639 0 00.639.639H11.4z"></path>
                                                    </svg>
                                                </a-->
												<a href="/guest-user/login-form" class="header-controls__action btn btn--bordered color-primary user-click"><?php echo Label::getLabel('LBL_Login'); ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18.375" viewBox="0 0 18.331 15.331" id="enter">
                                                    <path d="M17.692 0h-11.5a.639.639 0 00-.639.639V5.11a.639.639 0 101.278 0V1.278h10.222v12.775H6.833v-3.832a.639.639 0 00-1.278 0v4.472a.639.639 0 00.639.639h11.5a.639.639 0 00.639-.639V.639A.639.639 0 0017.692 0z"></path>
                                                    <path d="M9.936 9.769a.639.639 0 00.9.9l2.555-2.555q.022-.022.042-.046l.017-.023.02-.027.017-.028.015-.026.014-.029.013-.028c0-.009.007-.019.01-.029l.011-.03c.004-.01.005-.019.007-.029l.008-.032c.002-.011 0-.023.005-.034s0-.018 0-.028a.643.643 0 000-.126v-.028c0-.009 0-.023-.005-.034s-.005-.021-.008-.032 0-.019-.007-.029-.007-.02-.011-.03l-.01-.029c-.003-.01-.009-.018-.013-.028l-.014-.029-.015-.026-.017-.028-.02-.027-.017-.023q-.02-.024-.042-.046L10.84 4.659a.639.639 0 00-.9.9l1.46 1.468H.639A.639.639 0 000 7.666a.639.639 0 00.639.639H11.4z"></path>
                                                    </svg>
                                                </a>
												<a href="/sign-up"  class="btn btn--primary user-click"><?php echo Label::getLabel('LBL_SIGN_UP'); ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="18.375" viewBox="0 0 14 18.375">
                                                    <path d="M18,19.375H16.25v-1.75A2.625,2.625,0,0,0,13.625,15H8.375A2.625,2.625,0,0,0,5.75,17.625v1.75H4v-1.75A4.375,4.375,0,0,1,8.375,13.25h5.25A4.375,4.375,0,0,1,18,17.625ZM11,11.5a5.25,5.25,0,1,1,5.25-5.25A5.25,5.25,0,0,1,11,11.5Zm0-1.75a3.5,3.5,0,1,0-3.5-3.5A3.5,3.5,0,0,0,11,9.75Z" transform="translate(-4 -1)" />
                                                    </svg>
                                                </a>
                                                <!--a href="javascript:void(0)" onClick="signupForm();" class="btn btn--primary user-click"><?php echo Label::getLabel('LBL_SIGN_UP'); ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="18.375" viewBox="0 0 14 18.375">
                                                    <path d="M18,19.375H16.25v-1.75A2.625,2.625,0,0,0,13.625,15H8.375A2.625,2.625,0,0,0,5.75,17.625v1.75H4v-1.75A4.375,4.375,0,0,1,8.375,13.25h5.25A4.375,4.375,0,0,1,18,17.625ZM11,11.5a5.25,5.25,0,1,1,5.25-5.25A5.25,5.25,0,0,1,11,11.5Zm0-1.75a3.5,3.5,0,1,0-3.5-3.5A3.5,3.5,0,0,0,11,9.75Z" transform="translate(-4 -1)" />
                                                    </svg>
                                                </a-->
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div id="body" class="body">
            <?php } ?>