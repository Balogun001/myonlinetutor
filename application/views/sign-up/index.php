<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$privacyPolicyLink = empty($privacyPolicyLink) ? 'javascript:void();' : $privacyPolicyLink;
$termsConditionsLink = empty($termsConditionsLink) ? 'javascript:void();' : $termsConditionsLink;
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'signupSetup(this); return(false);');
$fldFirstName = $frm->getField('user_first_name');
$fldFirstName->developerTags['col'] = 6;
$fldLastName = $frm->getField('user_last_name');
$fldLastName->developerTags['col'] = 6;
$fldPassword = $frm->getField('user_password');

$fldPassword->captionWrapper = (array(Label::getLabel('LBL_Password') . '<span class="spn_must_field">*</span><a onClick="togglePassword(this)" href="javascript:void(0)" class="-link-underline -float-right link-color" data-show-caption="' . Label::getLabel('LBL_Show_Password') . '" data-hide-caption="' . Label::getLabel('LBL_Hide_Password') . '">' . Label::getLabel('LBL_Show_Password'), '</a>'));
$termLink = ' <a target="_blank" class = "-link-underline link-color" href="' . $termsConditionsLink . '">' . Label::getLabel('LBL_TERMS_AND_CONDITION') . '</a> and <a href="' . $privacyPolicyLink . '" target="_blank" class = "-link-underline link-color" >' . Label::getLabel('LBL_Privacy_Policy') . '</a>';
$terms_caption = '<span>' . $termLink . '</span>';
$frm->getField('agree')->addWrapperAttribute('class', 'terms_wrap');
$frm->getField('agree')->htmlAfterField = $terms_caption;
?>
<style>
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
	overflow: hidden;
}
.signin-form-wrapper{
	width: 580px;
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
.signin-form-wrapper .custom-field-set.field-set {
    display: inline-block;
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid #000000;
    position: relative;
    padding: 13px 0;
}
.signin-form-wrapper .form .custom-field-set .field_label{
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
.signin-form-wrapper .custom-field-set  input[type=password],
.signin-form-wrapper .custom-field-set input[type=text],
.signin-form-wrapper .custom-field-set select,
.signin-form-wrapper .custom-field-set textarea{
	border: none;
	background-color: transparent;
}
.signin-form-wrapper .custom-field-set  input[type=password]:focus,
.signin-form-wrapper .custom-field-set input[type=text]:focus{
    -webkit-box-shadow: none;
    box-shadow: none;
}
.show-password{
	display: none;
}
.mb-50,.signin-form-wrapper .form .custom-field-set.mb-50{
	margin-bottom: 50px;
}
.signin-form-wrapper .field-set .input-helper{
	border: 1px solid #D0D5DD;
	border-radius: 4px;
}
.forgot-password,.register-as-a-link,.sign-inlink{
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
.register-button-group{
	margin-bottom: 40px;
}

.register-custom-btn span.custom-radio {
    width: 20px;
    height: 20px;
    border: 1px solid #545454;
    display: inline-block;
    border-radius: 50%;
    vertical-align: -4px;
    margin-right: 10px;
	position: relative;
}

.register-custom-btn {
    border: 1px solid #B3B3B3;
    border-radius: 8px;
    padding: 16px 20px;
    width: 100%;
    display: block;
	font-weight: 400;
	font-size: 20px;
	line-height: 30px;
}
.custom-radio-checked span.custom-radio:after{
	width: 13.33px;
    height: 13.33px;
    background: #2765F1;
    content: "";
    position: absolute;
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

}
.custom-radio-checked{
	color: #2765F1;
	border-color: #2765F1;

}
.register-custom-btn.custom-radio-checked span.custom-radio{
	border-color: #2765F1;
}
.signin-form-wrapper .custom-field-set input[type=text]::-webkit-input-placeholder,
.signin-form-wrapper .custom-field-set input[type=password]::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #757575;
}
.signin-form-wrapper .custom-field-set input[type=text]::-moz-placeholder,
.signin-form-wrapper .custom-field-set input[type=password]::-moz-placeholder { /* Firefox 19+ */
  color: #757575;
}
.signin-form-wrapper .custom-field-set input[type=text]:-ms-input-placeholder ,
.signin-form-wrapper .custom-field-set input[type=password]:-ms-input-placeholder { /* IE 10+ */
  color: #757575;
}
.signin-form-wrapper .custom-field-set input[type=text]:-moz-placeholder,
.signin-form-wrapper .custom-field-set input[type=password]:-moz-placeholder { /* Firefox 18- */
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
	.register-custom-btn{
		margin-bottom: 10px;
	}
}

</style>
<section class="section padding-0 sign-in-wrapper">
	<div class="container--fluid">
		<div class="row">
			<div class="col-md-12 col-xl-6 d-none d-lg-block">
				<div class="">
					<img src="/images/0.gif" height="1117" width="864" class="img-fluid div-Img" alt="sign img" style="background-image:url('/images/register.png');">
				</div>
			</div>
			<div class="col-md-12 col-xl-6 text-center bg-light align-self-center">
			<div class="signin-form-wrapper">
    <a href="/" title="MYONLINETUTOR" class="text-center form-logo">
	<img src="/images/logo-online-tutor.png" alt="MYONLINETUTOR" width="248" height="80" class="m-auto">
    </a>

	<div class="row register-button-group">
		<div class="col-md-6">
			<a href="javascript:void(0);" class="register-custom-btn custom-radio-checked"><span class="custom-radio"></span>Register as Student</a>
		</div>
		<div class="col-md-6">
			<a href="/teacher-request" class="register-custom-btn"><span class="custom-radio"></span>Register as Tutor</a>
		</div>
	</div>
    <form name="signupFrm" method="post" id="frm_fat_id_signupFrm" class="form"
        onsubmit="signupSetup(this); return(false);">
		
        <div class="row">
            <div class="col-sm-6">
                <div class="field-set custom-field-set mb-50">
                    <div class="caption-wraper"><label class="field_label">First Name<span
                                class="spn_must_field">*</span></label></div>
                    <div class="field-wraper">
                        <div class="field_cover"><input data-field-caption="First Name"
                                data-fatreq="{&quot;required&quot;:true}" type="text" name="user_first_name" value="" placeholder="eg. john">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="field-set custom-field-set mb-50">
                    <div class="caption-wraper"><label class="field_label">Last Name</label></div>
                    <div class="field-wraper">
                        <div class="field_cover"><input data-field-caption="Last Name"
                                data-fatreq="{&quot;required&quot;:false}" type="text" name="user_last_name" value="" placeholder="eg. doe">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="field-set custom-field-set mb-50">
                    <div class="caption-wraper"><label class="field_label">Email ID<span
                                class="spn_must_field">*</span></label></div>
                    <div class="field-wraper">
                        <div class="field_cover"><input 0="autocomplete=&quot;off&quot;" data-field-caption="Email ID"
                                onchange="checkUnique($(this), 'tbl_users', 'user_email', 'user_id', $('#user_id'), []); "
                                data-mbsunichk="1" data-fatreq="{&quot;required&quot;:true,&quot;email&quot;:true}"
                                type="text" name="user_email" value="" placeholder="eg. mail@email.com"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="field-set custom-field-set mb-50">
                    <div class="caption-wraper"><label class="field_label">Password<span
                                class="spn_must_field">*</span><a onclick="togglePassword(this)"
                                href="javascript:void(0)" class="-link-underline -float-right link-color show-password"
                                data-show-caption="Show Password" data-hide-caption="Hide Password">Show
                                PasswordPassword</a></label></div>
                    <div class="field-wraper">
                        <div class="field_cover"><input data-field-caption="Password"
                                data-fatreq="{&quot;required&quot;:true,&quot;user_regex&quot;:&quot;^(?=.*[A-Za-z])(?=.*\\d)(?=.*[@$!%*#?&amp;_-])[A-Za-z\\d@$!%*#?&amp;_-]{8,20}$&quot;,&quot;customMessage&quot;:&quot;Minimum 8 digit alphanumeric password including a special character e.g. Welcome@2022&quot;}"
                                type="password" name="user_password" value="" placeholder="Set your password here"></div>
                    </div>
                </div>
            </div>
        </div>

		<div class="row">
            <div class="col-sm-12">
                <div class="field-set custom-field-set">
                    <div class="caption-wraper"><label class="field_label">Confirm Password<span
                                class="spn_must_field">*</span><a onclick="togglePassword(this)"
                                href="javascript:void(0)" class="-link-underline -float-right link-color show-password"
                                data-show-caption="Show Password" data-hide-caption="Hide Password">Show
                                PasswordPassword</a></label>
					</div>
					 <div class="field-wraper">
                        <div class="field_cover"><input data-field-caption="Password"
                                data-fatreq="{&quot;required&quot;:true,&quot;user_regex&quot;:&quot;^(?=.*[A-Za-z])(?=.*\\d)(?=.*[@$!%*#?&amp;_-])[A-Za-z\\d@$!%*#?&amp;_-]{8,20}$&quot;,&quot;customMessage&quot;:&quot;Minimum 8 digit alphanumeric password including a special character e.g. Welcome@2022&quot;}"
                                type="password" name="user_password" value="" placeholder="Rewrite the password here"></div>
                    </div>
                   
                </div>
            </div>
        </div>
		<div class="row"><div class="terms_wrap col-sm-12"><div class="field-set"><div class="caption-wraper">&nbsp;</div><div class="field-wraper" style="text-align:left;"><div class="field_cover"><label><span class="checkbox"><input data-field-caption="I accept to the" data-fatreq="{&quot;required&quot;:true,&quot;customMessage&quot;:&quot;Terms and Conditions are mandatory&quot;}" type="checkbox" name="agree"><i class="input-helper"></i></span>I accept to the</label><span> <a target="_blank" class="-link-underline link-color" href="/terms-and-conditions">Terms And Conditions</a> and <a href="/privacy-policy" target="_blank" class="-link-underline link-color">Privacy Policy</a></span></div></div></div></div></div>
        <div class="row">
            <div class="col-sm-12">
                <div class="field-set">
                    <div class="caption-wraper"><label class="field_label"></label></div>
                    <div class="field-wraper">
                        <div class="field_cover"><input data-field-caption="" data-fatreq="{&quot;required&quot;:false}"
                                type="submit" name="btn_submit" value="Register as a Student"></div>
                    </div>
                </div>
            </div>
        </div><input id="user_id" data-field-caption="" data-fatreq="{&quot;required&quot;:false}" type="hidden"
            name="user_id">
    </form>

	<div class="group group--social">
        <a class="facebook-login" href="/guest-user/facebook-login">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1"
                x="0px" y="0px" viewBox="0 0 60.734 60.733" style="enable-background:new 0 0 60.734 60.733;"
                xml:space="preserve">
                <g>
                    <path
                        d="M57.378,0.001H3.352C1.502,0.001,0,1.5,0,3.353v54.026c0,1.853,1.502,3.354,3.352,3.354h29.086V37.214h-7.914v-9.167h7.914   v-6.76c0-7.843,4.789-12.116,11.787-12.116c3.355,0,6.232,0.251,7.071,0.36v8.198l-4.854,0.002c-3.805,0-4.539,1.809-4.539,4.462   v5.851h9.078l-1.187,9.166h-7.892v23.52h15.475c1.852,0,3.355-1.503,3.355-3.351V3.351C60.731,1.5,59.23,0.001,57.378,0.001z">
                    </path>
                </g>
            </svg>
            <span>Sign In With Facebook</span>
        </a>
        <a class="google-login" href="/guest-user/google-login">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                xml:space="preserve">
                <path style="fill:#FBBB00;"
                    d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256  c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456  C103.821,274.792,107.225,292.797,113.47,309.408z">
                </path>
                <path style="fill:#518EF8;"
                    d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451  c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535  c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z">
                </path>
                <path style="fill:#28B446;"
                    d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512  c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771  c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z">
                </path>
                <path style="fill:#F14336;"
                    d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012  c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0  C318.115,0,375.068,22.126,419.404,58.936z">
                </path>
                <g>
                </g>
            </svg>
            <span>Sign In With Google</span>
        </a>
    </div>


    <script>
        signupFrm_validator_formatting = { "errordisplay": 3, "summaryElementId": "" }; signupFrm_validator = $("#frm_fat_id_signupFrm").validation(signupFrm_validator_formatting);
    </script>
    <div class="-align-center">
        <p>Already Have An Account? <a href="/guest-user/login-form" class="link-color sign-inlink">Sign In</a></p>
    </div>
</div>
		</div>
	</div>
    
</section>



<script>
    $(document).ready(function () {
        $('#termLabelWrapper label').addClass('field_resp_block');
        $('#termLabelWrapper label').append('<?php echo $termLink; ?>');
    })
</script>