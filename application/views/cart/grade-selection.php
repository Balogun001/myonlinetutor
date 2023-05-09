<?php defined('SYSTEM_INIT') or die('INVALID USAGE.'); ?>
<?php $steps = Cart::getSteps(); ?>
<script>
    cart.selectLanguage(parseInt('<?php echo $tlangId; ?>'));
    cart.selectDuration(parseInt('<?php echo $duration; ?>'));
</script>
<div class="box box--checkout">
    <div class="box__head">
        <h4><?php echo Label::getLabel('LBL_STUDENT_INFORMATION'); ?></h4>
        <div class="step-nav">
            <ul>
                <?php foreach ($steps as $key => $step) { ?>
                    <li class="step-nav_item <?php echo in_array($key, $stepProcessing) ? 'is-process' : ''; ?> <?php echo in_array($key, $stepCompleted) ? 'is-completed' : ''; ?> ">
                        <a href="javascript:void(0);"><?php echo $step; ?></a>
                        <?php if (in_array($key, $stepCompleted)) { ?><span class="step-icon"></span><?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="box__body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="mb-2">What grade/level are you in?</h4>
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label"> Teaches Level</label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <ul class="list-onethird list-onethird--bg"><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="138" data-fat-arr-index="0" data-fatreq="{&quot;required&quot;:false}"><i class="input-helper"></i></span>Grade 4</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="139" data-fat-arr-index="1"><i class="input-helper"></i></span>Grade 5</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="140" data-fat-arr-index="2"><i class="input-helper"></i></span>Grade 6</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="141" data-fat-arr-index="3"><i class="input-helper"></i></span>Grade 7</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="142" data-fat-arr-index="4"><i class="input-helper"></i></span>Grade 8</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="143" data-fat-arr-index="5"><i class="input-helper"></i></span>Grade 9</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="144" data-fat-arr-index="6"><i class="input-helper"></i></span>Grade 10</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="145" data-fat-arr-index="7"><i class="input-helper"></i></span>Grade 11</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="146" data-fat-arr-index="8"><i class="input-helper"></i></span>Grade 12</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="147" data-fat-arr-index="9"><i class="input-helper"></i></span>Grade 13</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="148" data-fat-arr-index="10"><i class="input-helper"></i></span>O Level</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="149" data-fat-arr-index="11"><i class="input-helper"></i></span>A Level</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="150" data-fat-arr-index="12"><i class="input-helper"></i></span>Graduate Level</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="151" data-fat-arr-index="13"><i class="input-helper"></i></span>Post-graduate Level</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="152" data-fat-arr-index="14"><i class="input-helper"></i></span>Masters Level</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="153" data-fat-arr-index="15"><i class="input-helper"></i></span>Doctoral Level</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="156" data-fat-arr-index="16"><i class="input-helper"></i></span>Pre-school</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="41" data-fat-arr-index="17"><i class="input-helper"></i></span>(A1) Beginner</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="42" data-fat-arr-index="18"><i class="input-helper"></i></span>(A2) Upper Beginner</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="43" data-fat-arr-index="19"><i class="input-helper"></i></span>(B1) Intermediate</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="44" data-fat-arr-index="20"><i class="input-helper"></i></span>(B2) Upper Intermediate</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="45" data-fat-arr-index="21"><i class="input-helper"></i></span>(C1) Advanced</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_2[]" value="46" data-fat-arr-index="22"><i class="input-helper"></i></span>(C2) Upper Advanced </label></li></ul>                            </div>
                    </div>
                </div>
                
                <!--<div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label"> Learner Ages</label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <ul class="list-onethird list-onethird--bg"><li><label><span class="checkbox"><input type="checkbox" name="pref_3[]" value="47" data-fat-arr-index="0" data-fatreq="{&quot;required&quot;:false}"><i class="input-helper"></i></span>4 Years to 11 Years</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_3[]" value="48" data-fat-arr-index="1"><i class="input-helper"></i></span>12 Years to 18 Years</label></li><li><label><span class="checkbox"><input type="checkbox" name="pref_3[]" value="49" data-fat-arr-index="2"><i class="input-helper"></i></span>18+ Years</label></li></ul>                            </div>
                    </div>
                </div>-->
                <hr>
              
                <h4 class="mb-2">What is the main reason for your learning?</h4>
                <div class="field-set">
                    <!--<div class="caption-wraper">
                        <label class="field_label">Language</label>
                    </div>-->
                    <div class="field-wraper">
                        <select data-field-caption="Site Language" data-fatreq="{&quot;required&quot;:true}" name="user_lang_id" >
                            <option>Self-development (Acquisition of another language)</option>
                            <option>Work/career related</option>
                            <option>Coursework and exams</option>
                            <option>Travel and leisure</option>
                            <option>Cultural appreciation</option>
                            <option>Improve accent</option>
                            <option>Learning for kids</option>
                             <option>Help with coursework and exams</option>
                            <option>Understanding concepts</option>
                            <option>Critical thinking and Problem solving</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>
              
                <!--<div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label">Academic</label>
                    </div>
                    <div class="field-wraper">
                        <select data-field-caption="Site Language" data-fatreq="{&quot;required&quot;:true}" name="user_lang_id" >
                            <option>Help with coursework and exams</option>
                            <option>Understanding concepts</option>
                            <option>Critical thinking and Problem solving</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>-->
            </div>
        </div> 
    </div>
    <div class="box-foot">
        <div class="teacher-profile">
            <div class="teacher__media">
                <div class="avtar avtar-md">
                    <img src="<?php echo MyUtility::makeUrl('Image', 'show', [Afile::TYPE_USER_PROFILE_IMAGE, $teacher['user_id'], Afile::SIZE_SMALL]) . '?' . time(); ?>" alt="<?php echo $teacher['user_first_name'] . ' ' . $teacher['user_last_name'] ?>">
                </div>
            </div>
            <div class="teacher__name"><?php echo $teacher['user_first_name'] . ' ' . $teacher['user_last_name']; ?></div>
        </div>
        <a href="javascript:void(0);" class="btn btn--primary color-white" onclick="cart.langSlots('<?php echo $teacher['user_id']; ?>', cart.prop.ordles_tlang_id, cart.prop.ordles_duration, cart.prop.ordles_quantity, cart.prop.ordles_type);"><?php echo Label::getLabel('LBL_NEXT'); ?></a>
    </div>
</div>

