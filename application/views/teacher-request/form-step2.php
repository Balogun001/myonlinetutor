<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'setupStep2(this); return(false);');
$frm->setFormTagAttribute('action', MyUtility::makeUrl('TeacherRequest', 'setupStep2'));
$profileImageField = $frm->getField('user_profile_image');
$profileImageField->setFieldTagAttribute('class', 'btn btn--bordered btn--small color-secondary');
$usrVideoLink = $frm->getField('tereq_video_link');
$usrVideoLink->addFieldTagAttribute('onblur', 'validateVideolink(this);');
$usrVideoLink->requirements()->setRequired();
$usrBio = $frm->getField('tereq_biography');
$usrBio->requirements()->setRequired();
$this->includeTemplate('teacher-request/_partial/leftPanel.php', ['step' => 2]);
?>
<script>
    var useMouseScroll = "<?php echo Label::getLabel('LBL_USE_MOUSE_SCROLL_TO_ADJUST_IMAGE'); ?>";
    $(document).on('click', '.toggle', function(event) {
        event.preventDefault();
        var target = $(this).data('target');
        $('#' + target).toggleClass('hide');
        $('.overLay').toggleClass('overLayShow');
		$('#youtubevideo').trigger('pause');
		
		 $("iframe").attr("src", $("iframe").attr("src"));
    });

    
</script>
<style>
    .overLay{
        background-color: #000;
        z-index: 99;
        opacity: 0.7;
        position: fixed;
        top: 0px;
        left: 0px;
        height: 100%;
        width: 100%;     
        display: none;   
    }
    .overLayShow{
        display: block;
    }


    .with-info-btn svg {
        max-width: 22px;
        height: auto;
        position: relative;
        top: 5px;
    }
            .hide {
            visibility: hidden;
            opacity: 0;
            transform: translateX(-50%) translateY(-50%) scale(0.8) !important;
            -moz-transform: translateX(-50%) translateY(-50%) scale(0.8) !important;
            -o-transform: translateX(-50%) translateY(-50%) scale(0.8) !important;
            -webkit-transform: translateX(-50%) translateY(-50%) scale(0.8) !important;
        }



#myPopup.popup,#myPopupVideo.popup {
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translateX(-50%) translateY(-50%);
    -moz-transform: translateX(-50%) translateY(-50%);
    -o-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    background: #FAFDFF;
    -moz-border-radius: 0;
    -o-border-radius: 0;
    -webkit-border-radius: 0;
    border-radius: 0;
    width: 100%;
   
    /* -moz-transition: all 120ms;
    -webkit-transition: all 120ms;
    -o-transition: all 120ms;
    transition: all 120ms; */
    z-index: 99;
    position: fixed;
    z-index: 999;
    max-width: 767px;
    margin: 0 auto;
  
  
}
  #myPopup.popup .popup-header,#myPopupVideo.popup .popup-header{
        font-size: 1.25rem;
        margin-bottom: 0;
        line-height: 1.5;
        font-family: inherit;
        font-weight: 500;
        padding: var(--padding-10);
       
    }
    .popup-header h5{
        margin-bottom: 0;
    }
    .popup-body{
        padding: 0 var(--padding-10);
    }
    .popup-footer{
        padding: var(--padding-10);
       
    }
    .popup-body ol li {
        padding: 5px 0;
    }
    .close-c {
        width: 35px;
        height: 35px;
        position: absolute;
        top: -40px;
        right: 0;
        -webkit-transform: none;
        -ms-transform: none;
        transform: none;
        font-size: var(--font-size-xxxl);
    line-height: 40px;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    background-color: transparent;
    border: none;
    cursor: pointer;
    }

    .close-c:before {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        content: "+";
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        text-align: center;
        color: #fff;
    }

    .prf-video {
        position: absolute;
        right: 15px;
        top: -15px;
    }

    @media screen and (max-width: 1000px) {
        #myPopup.popup,#myPopupVideo.popup {
            width: 80%;
        }
    }
</style>
<div class="page-block__right">
    <div class="page-block__head">
        <div class="head__title">
            <h4><?php echo Label::getLabel('LBL_Tutor_registration'); ?></h4>
        </div>
    </div>
    <div class="page-block__body">
        <?php echo $frm->getFormTag() ?>
        <div class="row justify-content-center no-gutters">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <div class="block-content">
                    <div class="block-content__head">
                        <div class="info__content">
                            <h5><?php echo Label::getLabel('LBL_PROFILE_MEDIA_TITLE'); ?></h5>
                            <p><?php echo Label::getLabel('LBL_PROFILE_MEDIA_DESC'); ?></p>
                        </div>
                    </div>
                    <div class="block-content__body">
                        <div class="img-upload">
                            <div class="img-upload__media">
                                <div class="avtar avtar--large" id="avtar-js" data-title="<?php echo CommonHelper::getFirstChar($request['tereq_first_name']); ?>">
                                    <?php if (!empty($teacherApprovalImage)) { ?>
                                        <!--img id="user-profile-pic--js" src="<?php echo MyUtility::makeUrl('Image', 'show', [$teacherApprovalImage['file_type'], $userId, Afile::SIZE_LARGE]) . '?t=' . time(); ?>"-->
										
                                        <img id="user-profile-pic--js" src="<?php echo '/user-uploads/'.$teacherApprovalImage['file_path'] ;?> ">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="img-upload__content">
                                <h6><?php echo $profileImageField->getCaption(); ?><span class="spn_must_field">*</span></h6>
                                <span class="btn-with-info">
                                    <span class="btn btn--bordered color-primary btn--small btn--fileupload btn--wide margin-right-2">
                                        <?php
                                        echo $profileImageField->getHTML();
                                        echo Label::getLabel('LBL_Upload');
                                        ?>
                                    </span>
                                    <span class="with-info-btn" >
                                        <button  class="toggle prf-instruction btn btn--primary btn--small " data-target="myPopup">Instructions</button>
                                        <div id="myPopup" class="popup hide">
                                            <div class="popup-header">
                                                <h5>Instructions</h5>
                                                <span class="close-c toggle" data-target="myPopup"></span>
                                            </div>
                                            <div class="popup-body">
                                                    <h6>A guide to a good profile picture</h6>
                                                    <ol>
                                                        <li>
                                                            Look at the Camera.
                                                            <br/><br/>
                                                            <img src="/images/Demo-profile-picture.jpg" height="202" width="206" alt="Demo-profile">
                                                            <br/>
                                                        </li>
                                                        <li>Use a recent photo of your self.</li>
                                                        <li>You should be the only subject in the photo.</li>
                                                        <li>Ensure your face is in focus.</li>
                                                        <li>Wear approproate at clothing.</li>
                                                        <li>Keep your head straight and upright.</li>
                                                        <li>Use a pleasant facial expression.</li>
                                                        <li>Make sure your background is clean and appropriate.</li>
                                                    </ol>
                                            </div>
                                            <div class="popup-footer align-right">
                                                <button class="toggle button btn btn--primary" data-target="myPopup">Close</button>
                                            </div>
                                        </div>
                                        <div class="overLay"></div>
                                    </span>
                                    
                                </span>
                                <?php $fileSize = MyUtility::convertBitesToMb($fileSize) . ' ' . Label::getLabel('LBL_MB'); ?>
                                <small>(<?php echo str_replace(['{size}', '{ext}'], [$fileSize, implode(", ", $imageExt)], Label::getLabel('LBL_IMAGE_MAX_SIZE_{size}_AND_ALLOWED_EXT_{ext}')); ?>)</small>
                            </div>
                        </div>
                   
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-set">
                                    <div class="caption-wraper">
                                            <div class="align-right prf-video">
                                                <div class="-gap-10"></div>
                                                    <button  class="toggle prf-instruction btn btn--primary btn--small " data-target="myPopupVideo">Self Introduction Video</button>
                                                <div class="-gap-10"></div>
                                            </div>
                                                <div id="myPopupVideo" class="popup hide">
                                                    <div class="popup-header">
                                                        <h5>Self Introduction Video</h5>
                                                        <span class="close-c toggle" data-target="myPopupVideo"></span>
                                                    </div>
                                                    <div class="popup-body">
                                                        <iframe id="youtubevideo" width="100%" height="315" src="https://www.youtube.com/embed/bG6ZmwAqmZA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                    </div>
                                                    <div class="popup-footer align-right">
                                                        <button class="toggle button btn btn--primary" data-target="myPopupVideo">Close</button>
                                                    </div>
                                                </div>
                                        <label class="field_label">
                                            <?php echo $usrVideoLink->getCaption(); ?> <?php if ($usrVideoLink->requirement->isRequired()) { ?>
                                                <span class="spn_must_field">*</span>
                                            <?php } ?>
                                            <small><?php echo Label::getLabel('LBL_video_desc'); ?>   </small>
                                          
                                        </label>
                                    </div>
                                   
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <?php echo $usrVideoLink->getHTML(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-set">
                                    <div class="caption-wraper">
                                        <label class="field_label"><?php echo $usrBio->getCaption(); ?>   <?php if ($usrBio->requirement->isRequired()) { ?>
                                                <span class="spn_must_field">*</span>
                                            <?php } ?> <small><?php echo Label::getLabel('LBL_About_self_Fld_Desc'); ?>
                                      
                                    </small>
                                           
                                        </label>
                                    </div>
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <?php echo $usrBio->getHtml(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content__foot">
                        <div class="form__actions">
                            <div class="d-flex align-items-center justify-content-between">
                                <div><input type="button" name="back" onclick="getform(1);" value="<?php echo Label::getLabel('LBL_Back'); ?>"></div>
                                <div>
                                    <input type="submit" name="save" value="<?php echo Label::getLabel('LBL_SAVE'); ?>" />
                                    <input type="button" name="next" onclick="setupStep2(document.frmFormStep2, true)" value="<?php echo Label::getLabel('LBL_NEXT'); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo $frm->getFieldHtml('update_profile_img');
        echo $frm->getFieldHtml('rotate_left');
        echo $frm->getFieldHtml('rotate_right');
        echo $frm->getFieldHtml('img_data');
        echo $frm->getFieldHtml('action');
        ?>
        </form>
        <?php echo $frm->getExternalJs(); ?>
    </div>
</div>
