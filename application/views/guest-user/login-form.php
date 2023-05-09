<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$fldPassword = $frm->getField('password');
$fldPassword->changeCaption('');
$fldPassword->captionWrapper = [
    Label::getLabel('LBL_Password'),
    '<a onClick="toggleLoginPassword(this)" href="javascript:void(0)" class="-link-underline -float-right link-color" data-show-caption="' .
    Label::getLabel('LBL_Show_Password') . '" data-hide-caption="' . Label::getLabel('LBL_Hide_Password') . '">' . Label::getLabel('LBL_Show_Password') . '</a>'
];
$frm->setFormTagAttribute('onsubmit', 'signinSetup(this); return(false);');
?>
<style>
	
.bg-light{
	background-color: #FDFFF7;
}
.h-100{
	height: 100%;
}
.div-Img {
    width: 100%;
    height: 100%;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: top center;
}
.text-center{
	text-align: center;
}
.m-auto {
    margin: 0 auto;
}
.sign-in-wrapper{
	background: #FDFFF7;
	overflow: hidden;
}
.signin-form-wrapper{
	width: 457px;
	margin: 0 auto;
}
.form-logo{
    margin-bottom: 24px;
    display: block;
}
.signin-form-wrapper h3{
    font-weight: 600;
    font-size: 30px;
    line-height: 45px;
    color: #101828;
	margin-bottom: 12px;
}
.signin-form-wrapper h5{
	font-weight: 400;
	font-size: 16px;
	line-height: 24px;
	color: #667085;
}

.signin-form-wrapper form > div:nth-child(1) .field-set,.signin-form-wrapper form > div:nth-child(2) .field-set{
    display: inline-block;
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid #000000;
    position: relative;
    padding: 13px 0;
}
.signin-form-wrapper form > div:nth-child(2) .field-set a.-link-underline {
    display: none;
}
.signin-form-wrapper .form .field-set .field_label{
    font-weight: 400;
    font-size: 16px;
    line-height: 30px;
    min-height: auto;
    position: absolute;
    top: -20px;
    left: 9px;
    background-color: #fff;
    width: auto;
    color: #000000;
    margin: 0;
    padding: 5px 10px;
}
.signin-form-wrapper .field-set  input[type=password],
.signin-form-wrapper .field-set input[type=text],
.signin-form-wrapper .field-set select,
.signin-form-wrapper .field-set textarea{
	border: none;
	background-color: transparent;
}
.signin-form-wrapper .field-set  input[type=password]:focus,
.signin-form-wrapper .field-set input[type=text]:focus{
    -webkit-box-shadow: none;
    box-shadow: none;
}
.show-password{
	display: none;
}
.mb-50,.signin-form-wrapper .form .field-set.mb-50{
	margin-bottom: 50px;
}
.signin-form-wrapper .field-set .input-helper{
	border: 1px solid #D0D5DD;
	border-radius: 4px;
}
.forgot-password,.register-as-a-link{
	color: #2765F1;
	font-weight: 500;
}
.signin-form-wrapper .form input[type="submit"]{
	background-color: var(--color-secondary);
    color: var(--color-secondary-inverse);
	margin-right: 0;
	width: 100%;
	height: 4.3rem;
}
.signin-form-wrapper .form input[type="submit"]:hover{
	background: var(--color-primary);
}
.signin-form-wrapper .group--social {
    flex-wrap: wrap;
}

.signin-form-wrapper .group.group--social a ,.signin-form-wrapper .group.group--social .google-login{
    margin-right: 0;
    width: 100%;
    height: 40px;
    justify-content: center;
    border-radius: 8px;
    margin-bottom: 16px;	
    background-color: #fff;
    color: #344054;
	box-shadow: 0px 1px 2px rgba(16, 24, 40, 0.05);
	border: 1px solid #D0D5DD;
	border-radius: 8px;
}
.signin-form-wrapper .group--social .facebook-login svg{
	fill: #1877F2;
}
.signin-form-wrapper .group--social a span,.signin-form-wrapper .group--social a{
	color: #344054;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
}
.signin-form-wrapper .field-set input[type=text]::-webkit-input-placeholder,
.signin-form-wrapper .field-set input[type=password]::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #757575;
}
.signin-form-wrapper .field-set input[type=text]::-moz-placeholder,
.signin-form-wrapper .field-set input[type=password]::-moz-placeholder { /* Firefox 19+ */
  color: #757575;
}
.signin-form-wrapper .field-set input[type=text]:-ms-input-placeholder ,
.signin-form-wrapper .field-set input[type=password]:-ms-input-placeholder { /* IE 10+ */
  color: #757575;
}
.signin-form-wrapper .field-set input[type=text]:-moz-placeholder,
.signin-form-wrapper .field-set input[type=password]:-moz-placeholder { /* Firefox 18- */
  color: #757575;
}


@media(max-width: 991px){
	.signin-form-wrapper{
		padding: 50px 0;
	}
}

@media(max-width: 767px){
	.signin-form-wrapper{
		padding: 50px 15px;
		width: 100%;
	}
}

</style>
<section class="section padding-0 sign-in-wrapper">
	<div class="container--fluid">
		<div class="row">
			<div class="col-md-12 col-xl-6 d-none d-lg-block">
				<div class="">
					<img src="/images/0.gif" height="1117" width="864" class="img-fluid div-Img" alt="sign img" style="background-image:url('/images/sign-in-bg.jpg');">
				</div>
			</div>
			<div class="col-md-12 col-xl-6 bg-light align-self-center">
				<div class="signin-form-wrapper">
					<a href="/" title="MYONLINETUTOR" class="text-center form-logo">
						<img src="/images/logo-online-tutor.png" alt="MYONLINETUTOR" width="248" height="80" class="m-auto">
					</a>
					<h3 class="text-center">Welcome Back</h3>
					<h5 class="text-center mb-50">Enter your details to login</h5>
					<?php echo $frm->getFormHtml(); ?>
					<?php /*
					<form name="signinFrmPopUp" method="post" id="signinFrmPopUp" class="form" onsubmit="signinSetup(this); return(false);">
						<div class="row">
							<div class="col-sm-12">
								<div class="field-set custom-field-set mb-50">
									<div class="caption-wraper"><label class="field_label">Email<span
												class="spn_must_field">*</span></label></div>
									<div class="field-wraper">
										<div class="field_cover"><input placeholder="Email Address" data-field-caption="Email"
												data-fatreq="{&quot;required&quot;:true,&quot;email&quot;:true}" type="text" name="username"
												value=""></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="field-set custom-field-set">
									<div class="caption-wraper"><label class="field_label">Password<span class="spn_must_field">*</span><a
												onclick="toggleLoginPassword(this)" href="javascript:void(0)"
												class="-link-underline -float-right link-color show-password" data-show-caption="Show Password"
												data-hide-caption="Hide Password">Show Password</a></label></div>
									<div class="field-wraper">
										<div class="field_cover"><input placeholder="Password" data-field-caption="Password"
												data-fatreq="{&quot;required&quot;:true}" type="password" name="password" value=""></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="field-set">
									<div class="caption-wraper">&nbsp;</div>
									<div class="d-flex justify-content-between">
										<div class="field-wraper">
											<div class="field_cover">
												<label>
													<span class="checkbox">
													<input data-field-caption="Remember Me" data-fatreq="{&quot;required&quot;:false}" type="checkbox" name="remember_me"	value="1">
													<i class="input-helper"></i>
													</span>Remember Me
												</label>
											</div>

										</div>
										<div  class="field-wraper">
											<a href="<?php echo MyUtility::makeUrl('GuestUser', 'forgotPassword'); ?>" class="forgot-password"><?php echo Label::getLabel('LBL_Forgot_Password?'); ?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12"></div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="field-set">
									
									<div class="field-wraper">
										<div class="field_cover"><input data-field-caption="" data-fatreq="{&quot;required&quot;:false}"
												type="submit" name="btn_submit" value="Sign in"></div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<script>
						signinFrmPopUp_validator_formatting={"errordisplay":3,"summaryElementId":""};signinFrmPopUp_validator=$("#signinFrmPopUp").validation(signinFrmPopUp_validator_formatting);
					</script>
					<div class="-align-center">
						
					</div>
					<?php */ ?>
						<?php $this->includeTemplate('guest-user/_partial/learner-social-media-signup.php'); ?>

						<div class="-align-center">
						<p><?php echo Label::getLabel('LBL_DO_NOT_HAVE_AN_ACCOUNT?'); ?> 
						<a href="/sign-up"  class="-link-underline link-color register-as-a-link"><?php echo Label::getLabel('LBL_REGISTER'); ?></a></p>
					</div>


					</div>
				</div>
			</div>
	</div>
    
</section>
<!--section class="section section--gray section--page">
    <div class="container container--fixed">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-lg-7 col-xl-6">
                <div class="box -skin">
                    <div class="box__head -align-center">
                        <h4 class="-border-title"><?php echo Label::getLabel('LBL_LOGIN'); ?></h4>
                    </div>
                    <div class="box__body -padding-40 div-login-form">
                        <?php
                        $this->includeTemplate('guest-user/_partial/learner-social-media-signup.php');
                        echo $frm->getFormHtml();
                        ?>
                        <div class="-align-center">
                            <a href="<?php echo MyUtility::makeUrl('GuestUser', 'forgotPassword'); ?>" class="-link-underline"><?php echo Label::getLabel('LBL_Forgot_Password?'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section-->