<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'questionFrm');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'setupQuestion(this); return false;');
$titleFld = $frm->getField('ques_title');
$typeFld = $frm->getField('ques_type');
$typeFld->setFieldTagAttribute('id', 'ques_type');
$typeFld->setFieldTagAttribute('onchange', 'showOptions(this.value);');
$detailFld = $frm->getField('ques_detail');
$catFld = $frm->getField('ques_cate_id');
$catFld->setFieldTagAttribute('onchange', 'getSubcategories(this.value, "#subCateAddQues");');
$subCatFld = $frm->getField('ques_subcate_id');
$subCatFld->setFieldTagAttribute('id', 'subCateAddQues');
$hintFld = $frm->getField('ques_hint');
$marksFld = $frm->getField('ques_marks');
$marksFld->setFieldTagAttribute('oninput', "this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null");
$optionCount = $frm->getField('ques_options_count');
$optionCount->setFieldTagAttribute('oninput', "this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null");
$addOptionsFld = $frm->getField('add_options');
$addOptionsFld->setFieldTagAttribute('onclick', 'addOptions();');
$submitButton = $frm->getField('submit');
$quesIdFld = $frm->getField('ques_id');

?>

<style>
    .tooltip {
        border-color: var(--color-gray-200);
        color: var(--color-black);
        -webkit-box-shadow: 1px 2px 2px 1px rgb(0 0 0 / 7%);
        box-shadow: 1px 2px 2px 1px rgb(0 0 0 / 7%);
        background-color: var(--color-white);
    }

    .tool-tip-content {
        text-align: left;
    }

    .tool-tip-content p {
        color: #000;
        white-space: normal;
        font-size: 12px;

    }

    .tooltip-width {
        min-width: 320px;
    }

    svg {
        width: 15px !important;
        height: 15px !important;
    }
</style>
<div class="facebox-panel">
    <div class="facebox-panel__head">
        <h4><?php echo Label::getLabel('LBL_ADD_QUESTION'); ?></h4>
    </div>
    <div class="facebox-panel__body">
        <?php echo $frm->getFormTag(); ?>
        <?php echo $quesIdFld->getHTML(); ?>
        <div class="row">
            <div class="col-md-8">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">
                            <?php echo $titleFld->getCaption(); ?>
                            <?php if ($titleFld->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                    <g>
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </g>
                                </svg>
                                <div class="tooltip tooltip--top bg-white">
                                    <div class="tool-tip-content">
                                        <div>
                                            Title
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $titleFld->getHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">
                            <?php echo $typeFld->getCaption(); ?>
                            <?php if ($typeFld->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                    <g>
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </g>
                                </svg>
                                <div class="tooltip tooltip--top bg-white">
                                    <div class="tool-tip-content">
                                        <div>
                                            Question Type
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $typeFld->getHtml(); ?>

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
                            <?php echo $detailFld->getCaption(); ?>
                            <?php if ($detailFld->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                    <g>
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </g>
                                </svg>
                                <div class="tooltip tooltip--top bg-white">
                                    <div class="tool-tip-content">
                                        <div>
                                            <strong>Description</strong>
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $detailFld->getHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row" style="display:none;">
            <div class="col-md-6">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">
                            <?php echo $catFld->getCaption(); ?>
                            <?php if ($catFld->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                    <g>
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </g>
                                </svg>
                                <div class="tooltip tooltip--top bg-white">
                                    <div class="tool-tip-content">
                                        <div>
                                            Category
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <select onchange="getSubcategories(this.value, '#subCateAddQues');" data-field-caption="Category" data-fatreq="{'required':true}" name="ques_cate_id">
                                <option selected value="1">Sample Category</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">
                            <?php echo $subCatFld->getCaption(); ?>
                            <?php if ($subCatFld->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                    <g>
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </g>
                                </svg>
                                <div class="tooltip tooltip--top bg-white">
                                    <div class="tool-tip-content">
                                        <div>
                                            Subcategory
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $subCatFld->getHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">
                            <?php echo $marksFld->getCaption(); ?>
                            <?php if ($marksFld->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                    <g>
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </g>
                                </svg>
                                <div class="tooltip tooltip--top bg-white">
                                    <div class="tool-tip-content">
                                        <div>
                                            <p><strong>Marks</strong>
                                            <p>
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo str_replace('type="text"', 'type="number"', $marksFld->getHtml()); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">
                            <?php echo $hintFld->getCaption(); ?>
                            <?php if ($hintFld->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                    <g>
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </g>
                                </svg>
                                <div class="tooltip tooltip--top bg-white">
                                    <div class="tool-tip-content">
                                        <div>
                                            <p><strong>Hint</strong>
                                            <p>
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $hintFld->getHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="recorderJs" style="display:<?php echo isset($file) ? 'block' : 'none' ?>;">
            <div class="source-view margin-top-5">
                <?php
                $class = $src = '';
                $autoplay = 'autoplay=0';
                if (isset($file)) {
                    $class = 'hasFile';
                    $src = 'src="' . $file . '"';
                    $autoplay = '';
                }
                ?>
                <div class="source recordrtc <?php echo $class; ?>">
                    <div class="source__field audioRecorderJs">
                        <audio style="" <?php echo $src; ?> controls playsinline noplaybackrate volume=1 <?php echo $autoplay; ?>></audio>
                    </div>
                    <div class="source__field audioRecordingJs" style="display:none;"></div>
                    <div class="source__actions">
                        <a href="javascript:void(0)" class="btn btn--equal btn--transparent color-black is-hover btnRecordJs" data-status="<?php echo Label::getLabel('LBL_START_RECORDING'); ?>">
                            <svg class="icon icon--recording btnStartJs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 1a5 5 0 0 1 5 5v4a5 5 0 0 1-10 0V6a5 5 0 0 1 5-5zM3.055 11H5.07a7.002 7.002 0 0 0 13.858 0h2.016A9.004 9.004 0 0 1 13 18.945V23h-2v-4.055A9.004 9.004 0 0 1 3.055 11z" />
                            </svg>
                            <div class="tooltip tooltip--top bg-black labelStartJs"><?php echo Label::getLabel('LBL_START_RECORDING'); ?></div>
                            <svg class="icon icon--stop btnStopJs" style="display:none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M16.425 17.839A8.941 8.941 0 0 1 13 18.945V23h-2v-4.055A9.004 9.004 0 0 1 3.055 11H5.07a7.002 7.002 0 0 0 9.87 5.354l-1.551-1.55A5 5 0 0 1 7 10V8.414L1.393 2.808l1.415-1.415 19.799 19.8-1.415 1.414-4.767-4.768zm2.95-2.679l-1.443-1.442c.509-.81.856-1.73.997-2.718h2.016a8.95 8.95 0 0 1-1.57 4.16zm-2.91-2.909l-8.78-8.78A5 5 0 0 1 17 6l.001 4a4.98 4.98 0 0 1-.534 2.251z" />
                            </svg>
                            <div class="tooltip tooltip--top bg-black labelStopJs" style="display:none"><?php echo Label::getLabel('LBL_STOP_RECORDING'); ?></div>
                        </a>
                        <a href="javascript:void(0)" onclick="removeRecording('<?php echo $quesIdFld->value; ?>');" class="btn btn--equal btn--transparent color-black is-hover btnRemoveJs">
                            <svg class="icon icon--sorting" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-11.414L9.172 7.757 7.757 9.172 10.586 12l-2.829 2.828 1.415 1.415L12 13.414l2.828 2.829 1.415-1.415L13.414 12l2.829-2.828-1.415-1.415L12 10.586z" />
                            </svg>
                            <div class="tooltip tooltip--top bg-black"><?php echo Label::getLabel('LBL_REMOVE_RECORDING'); ?></div>
                        </a>
                        <?php echo $frm->getFieldHtml('audio_filename'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row options-container" style="<?php echo (empty($typeFld->value) || $typeFld->value == Question::TYPE_TEXT) ? 'display: none;' : ''; ?>">
            <div class="col-md-6">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">
                            <?php echo $optionCount->getCaption(); ?>
                            <?php if ($optionCount->requirement->isRequired()) { ?>
                                <span class="spn_must_field">*</span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="btn btn--bordered btn--shadow btn--equal margin-1 is-hover">
                                <svg class="icon" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                    <g>
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </g>
                                </svg>
                                <div class="tooltip tooltip--top bg-white">
                                    <div class="tool-tip-content">
                                        <div>
                                            Option Count
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $optionCount->getHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">&nbsp;</label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $addOptionsFld->getHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="more-container-js">
            <?php
            if (count($options) > 0) {
                $this->includeTemplate(
                    'questions/option-form.php',
                    array(
                        'type' => $typeFld->value, 'count' => $optionCount->value, 'frm' => $optionsFrm,
                        'options' => $options, 'answers' => $answers
                    ),
                    false
                );
            }
            ?>
        </div>
        <div class="form-action-sticky">
            <div class="col-sm-12">
                <div class="field-set margin-bottom-0">
                    <div class="field-wraper">
                        <div class="field_cover">
                            <div>
                                <?php
                                if ($quizType > 0) {
                                    $btn = $frm->getField('btn_back');
                                    $btn->addFieldTagAttribute('onclick', "$('.addQuesJs').click();");
                                    echo $btn->getHtml();
                                }
                                ?>
                            </div>
                            <div>
                                <?php echo $submitButton->getHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php echo $frm->getExternalJS(); ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        getSubcategories('<?php echo $catFld->value ?? 0; ?>', '#subCateAddQues', '<?php echo $subCatFld->value ?? 0; ?>');
        addOptions();
    });
</script>