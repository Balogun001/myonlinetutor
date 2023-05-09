<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'questionFrm');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'setup(); return false;');
$title = $frm->getField('quiz_title');
$title->addFieldTagAttribute('placeholder','English Grammar - Rules of English Grammar');
$type = $frm->getField('quiz_type');
$type->addFieldTagAttribute('id', 'quizTypeJs');
$typeId = $frm->getField('quiz_type_id');
if ($quizId > 0) {
    $typeId->addFieldTagAttribute('disabled', 'disabled');
} else {
    $typeId->addFieldTagAttribute('onchange', 'setType(this.value)');
}
$detail = $frm->getField('quiz_detail');
$submit = $frm->getField('btn_submit');
?>
<?php echo $frm->getFormTag(); ?>
<style>
.tooltip{
	border-color: var(--color-gray-200);
    color: var(--color-black);
    -webkit-box-shadow: 1px 2px 2px 1px rgb(0 0 0 / 7%);
    box-shadow: 1px 2px 2px 1px rgb(0 0 0 / 7%);
    background-color: var(--color-white);
}
.tool-tip-content {
    text-align: left;
}
	.tool-tip-content p{
		color:#000;
		    white-space: normal;
			font-size: 12px;
			
	}
	.tooltip-width{
		min-width: 320px;		
	}
</style>
<div class="page-layout">
    <div class="page-layout__small">
        <?php
        echo $this->includeTemplate('quizzes/navigation.php', [
            'quizId' => $quizId, 'active' => 1, 'frm' => $frm
        ])
        ?>
    </div>
    <div class="page-layout__large">
        <div class="box-panel">
            <div class="box-panel__head  border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4><?php echo Label::getLabel('LBL_ADD_QUIZ'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="box-panel__body">
                <div class="box-panel__container">
                    <?php echo $frm->getFieldHTML('quiz_id'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label">
                                        <?php echo $title->getCaption(); ?>
                                        <?php if ($title->requirement->isRequired()) { ?>
                                            <span class="spn_must_field">*</span>
                                        <?php } ?>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $title->getHtml(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label">
                                        <?php echo $typeId->getCaption(); ?>
                                        <?php if ($typeId->requirement->isRequired()) { ?>
                                            <span class="spn_must_field">*</span>
                                        <?php } ?>
											<a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
												<svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
														 width="800px" height="800px" viewBox="0 0 416.979 416.979"
														 xml:space="preserve">
														<g>
														<path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z"/>
														</g>
													</svg>
												<div class="tooltip tooltip--top bg-white tooltip-width">
												<div class="tool-tip-content">
													<div>
														<p><strong>Auto-graded Quiz?</strong></p>
														<p>Explor.To create a graded quiz most often means to create an effective assessment on how users learned the material correctly. Graded quizzes have an element of challenge and help learners to prove their competence and knowledge by achieving good results.</p>
													</div>
													<div>
														<p><strong>Non-Graded Quiz?</strong></p>
														<p>:not assigned a grade :not graded.a nongraded course/assignment.:having no grade levels.</p>
													</div>
												</div>
												</div></a>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $typeId->getHtml(); ?>
                                        <?php echo $type->getHtml(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="field-set">
                                <div class="caption-wraper">
                                    <label class="field_label">
                                        <?php echo $detail->getCaption(); ?>
                                        <?php if ($detail->requirement->isRequired()) { ?>
                                            <span class="spn_must_field">*</span>
                                        <?php } ?>
                                    </label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $detail->getHtml(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php echo $frm->getExternalJS(); ?>