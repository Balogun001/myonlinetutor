<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<style>
	.btn-write-review {
		border: 1px solid #2765F1;
		border-radius: 6px;
		padding: 10px 20px;
		font-weight: 700;
		font-size: 24px;
		line-height: 30px;
		color: #2765F1;
		background-color: transparent;
		cursor: pointer;
		position: absolute;
		right: 40px;
		top: 45px;
	}
	.btn-write-review:hover{
		background-color: #2765F1;
		color: #fff;
	}
	.review-rating-head{
		margin-top: 40px;
	}
	.review-rating-head-left h4{
		font-weight: 700;
		font-size: 128px;
		line-height: 135px;
		margin-bottom: 12px;
	}
	.review-rating-head-left h5 {
		margin-top: 16px;
		font-weight: 500;
		font-size: 24px;
		line-height: 30px;
	}
	.review-star {
		font-weight: 400;
		font-size: 20px;
		line-height: 25px;
		white-space: nowrap;
	}
	.progress {
		background: #FF5200;
		border-radius: 16px;
		width: calc(100% - 115px);
		margin-left: 20px;
		margin-right: 20px;
	}
	.review-count {
		font-weight: 400;
		font-size: 20px;
		line-height: 25px;
	}
	.review-rating-wrapper-progress {
		display: flex;
		margin-bottom: 45px;
	}
	.review-rating-middle .review-rating {
		margin-bottom: 16px;
	}
	.review-rating-middle-content p {
		font-weight: 400;
		font-size: 18px;
		line-height: 28px;
		margin:0 0 16px 0;

	}
	.review-rating-middle-content .by span{
		color: #A7B6E9;
	}
	.review-rating-middle {
		padding-bottom: 24px;
		border-bottom: 1px solid #A7B6E9;
		margin-bottom: 30px;
	}
	.see-more-btn {
		font-weight: 400;
		font-size: 20px;
		line-height: 30px;
		background-image: url('/images/review-down-Icon.png');
		background-repeat: no-repeat;
		background-position: right center;
		padding-right: 50px;
		margin-bottom: 30px;
		display: inline-block;
	}
	.see-more-content{
		display: none;
	}
	.no-progress {
		background: transparent;
		border: 1px solid #ddd;
	} 
	@media(max-width: 767px){
		.review-rating-head-left h4{
                font-size: 70px;
                line-height: 52px;
            }
            .review-star{
                font-size: 14px;
            }
            .review-rating-head-left h5{
                margin-bottom: 10px;
            }
            .review-rating-wrapper-progress{
                margin-bottom: 10px;
            }
            .profile-primary{
                padding: 15px 15px 0 15px;
            }
	}
</style>
<?php /*foreach ($reviews as $review) { ?>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-sm-4">
            <div class="review-profile">
                <div class="avatar avatar-md" data-title="<?php echo $review['user_first_name']; ?>">
                    <img src="<?php echo MyUtility::makeUrl('Image', 'show', [Afile::TYPE_USER_PROFILE_IMAGE, $review['ratrev_user_id'], Afile::SIZE_SMALL]); ?>" alt="<?php echo $review['user_first_name']; ?>" />
                </div>
                <div class="user-info"><b><?php echo $review['user_first_name'] . ' ' . $review['user_last_name']; ?></b>
                    <p><?php MyDate::formatDate($review['ratrev_created']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-sm-8">
            <div class="review-content">
                <div class="review-content__head">
                    <h6><?php echo $review['ratrev_title']; ?></span></h6>
                    <div class="info-wrapper">
                        <div class="info-tag ratings">
                            <svg class="icon icon--rating"><use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#rating'; ?>"></use></svg>
                            <span class="value"><?php echo FatUtility::convertToType($review['ratrev_overall'], FatUtility::VAR_FLOAT); ?></span>
                        </div>
                    </div>
                </div>
                <div class="review-content__body">
                    <p><?php echo $review['ratrev_detail']; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($postedData['pageno'] < $pageCount) { ?>
    <?php $nextPage = $postedData['pageno'] + 1; ?>
    <div class="reviews-wrapper__foot show-more-container">
        <div class="show-more">
            <a href="javascript:void(0);" class="btn btn--show" onclick="loadReviews(<?php echo $postedData['teacher_id']; ?>,<?php echo $nextPage; ?>)"><?php echo Label::getLabel('Lbl_SHOW_MORE'); ?></a>
        </div>
    </div>
<?php } */ ?>

<?php //echo "<pre>";print_r($reviews);die; ?>
<div class="">

	<!--a href="javascript:void(0);" class="btn btn-write-review">Write a Review</a--> 
	<?php $r1=$r2=$r3=$r4=$r5=0; ?>
	<?php foreach($reviews as $review){ 
		if($review['ratrev_overall']==5){
			$r5++;
		}elseif($review['ratrev_overall']==4){
			$r4++;
		}elseif($review['ratrev_overall']==3){
			$r3++;
		}elseif($review['ratrev_overall']==2){
			$r2++;
		}else{
			$r1++;
		}			
	} ?>
	<div class="row review-rating-head">
		<div class="col-xl-6 col-md-12 review-rating-head-left">
		<?php 
		/*if($cntreview!=0){ 
			$overall=(($r5*5)+($r4*4)+($r3*3)+($r2*2)+($r1*1))/$cntreview; 
		}else{
			$overall=0;
		}*/
		?>
		<?php $overvalue=round(5, 2);?>
			<h4><?php echo $overvalue;?></h4>
			<div class="review-rating">
				<?php for($i=1;$i<=$overvalue;$i++){ ?>
					<span>
						<svg width="27" height="25" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#FF5200"/>
						</svg>
					</span>
				<?php } ?>
				<?php for($i=0;$i<(5-$overvalue);$i++){ ?>
					<span>
						<svg width="26" height="24" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#fff" stroke="#FF5200"></path>
						</svg>
					</span>
				<?php } ?>
				<!--span>
					<svg width="27" height="25" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.7414 17.6793C13.5915 17.5887 13.4998 17.4264 13.4998 17.2512V7.59183C13.4998 7.04711 14.2473 6.89508 14.4601 7.39653L15.6621 10.2292C15.7345 10.3999 15.8955 10.5165 16.0803 10.5321L20.4423 10.9006C20.8826 10.9378 21.0618 11.4859 20.7285 11.776L17.4197 14.6562C17.2803 14.7776 17.2192 14.9659 17.2609 15.146L18.2468 19.4084C18.3464 19.8389 17.8795 20.1775 17.5012 19.9491L13.7414 17.6793ZM25.9375 10.096C26.2718 9.80642 26.0931 9.25729 25.6524 9.2199L17.5469 8.53224C17.3621 8.51656 17.2012 8.39989 17.1288 8.22914L13.9602 0.752934C13.7879 0.34642 13.2118 0.346419 13.0395 0.752933L9.87083 8.22914C9.79846 8.39989 9.63753 8.51656 9.45274 8.53224L1.34583 9.22003C0.90533 9.2574 0.726493 9.80609 1.06036 10.0959L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9375 10.096Z" fill="#E77C40"/>
					</svg>
				</span-->
			</div>
			<!--h5><?php echo $cntreview; ?> review</h5-->
			<h5>1 review</h5>
		</div>
		<div class="col-xl-6 col-md-12">
			<div class="review-rating-wrapper-progress align-items-center">
				<span class="review-star">5 Stars</span>
				<span class="progress <?php if($r5==0) echo "no-progress"; ?>"></span>
				<span class="review-count"><?php echo $r5; ?></span>
			</div>

			<div class="review-rating-wrapper-progress align-items-center">
				<span class="review-star">4 Stars</span>
				<span class="progress <?php if($r4==0) echo "no-progress"; ?>"></span>
				<span class="review-count"><?php echo $r4; ?></span>
			</div>

			<div class="review-rating-wrapper-progress align-items-center">
				<span class="review-star">3 Stars</span>
				<span class="progress <?php if($r3==0) echo "no-progress"; ?>"></span>
				<span class="review-count"><?php echo $r3; ?></span>
			</div>

			<div class="review-rating-wrapper-progress align-items-center">
				<span class="review-star">2 Stars</span>
				<span class="progress <?php if($r2==0) echo "no-progress"; ?>"></span>
				<span class="review-count"><?php echo $r2; ?></span>
			</div>

			<div class="review-rating-wrapper-progress align-items-center">
				<span class="review-star">1 Stars</span>
				<span class="progress <?php if($r1==0) echo "no-progress"; ?>"></span>
				<span class="review-count"><?php echo $r1; ?></span>
			</div>

			
		</div>
	</div>
	<?php foreach($reviews as $review){ ?>
	<div class="row review-rating-middle">
		<div class="col-12">
		<div class="review-rating">
				<?php for($i=1;$i<=$review['ratrev_overall'];$i++){ ?>
					<span>
						<svg width="27" height="25" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#FF5200"/>
						</svg>
					</span>
				<?php } ?>
				<?php for($i=0;$i<(5-$review['ratrev_overall']);$i++){ ?>
					<span>
						<svg width="26" height="24" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#fff" stroke="#FF5200"></path>
						</svg>
					</span>
				<?php } ?>
			</div>
			
			<div class="review-rating-middle-content">
			<?php $date = strtotime($review['ratrev_created']);?>
				<p><?php echo $review['ratrev_detail']; ?></p>
				<p class="by"><span>by</span> <?php echo $review['user_first_name'].' '.$review['user_last_name']; ?><span> on <?php echo date('d M Y', $date);?></span></p>
			</div>
			</div>
	</div> 
	<?php } ?>
<?php /*if ($postedData['pageno'] <= $pageCount) { ?>
    <?php $nextPage = $postedData['pageno'] + 1; ?>
    <div class="reviews-wrapper__foot show-more-container">
        <div class="show-more">
            <a href="javascript:void(0);" class="btn btn--show" onclick="loadReviews(<?php echo $postedData['teacher_id']; ?>,<?php echo $nextPage; ?>)"><?php echo Label::getLabel('Lbl_SHOW_MORE'); ?></a>
        </div>
    </div>
<?php }*/ ?>

	<div class="see-more">
	<?php if ($postedData['pageno'] < $pageCount) { ?>
    <?php $nextPage = $postedData['pageno'] + 1; ?>
		<div class="row">
			<div class="col-12">
				<a href="javscript:void(0);" onclick="loadReviews(<?php echo $postedData['teacher_id']; ?>,<?php echo $nextPage; ?>)" class="see-more-btn">See More</a>
			</div>
		</div>
	<?php } ?>
	<div class="see-more-content">
		<div class="row review-rating-middle">
		<div class="review-rating">
				<span>
					<svg width="25" height="24" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#FF5200"/>
					</svg>
				</span>
				<span>
					<svg width="25" height="24" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#FF5200"/>
					</svg>
				</span>
				<span>
					<svg width="25" height="24" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#FF5200"/>
					</svg>
				</span>
				<span>
					<svg width="25" height="24" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#FF5200"/>
					</svg>
				</span>
				<span>
					<svg width="25" height="24" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.2415 20.1827C13.4004 20.0868 13.5993 20.0868 13.7582 20.1827L20.7253 24.3878C21.104 24.6163 21.5711 24.2768 21.4706 23.8461L19.6217 15.9207C19.5796 15.7399 19.641 15.5507 19.7813 15.4291L25.9392 10.0945C26.2732 9.80515 26.0951 9.25644 25.6548 9.21847L17.5462 8.51926C17.3618 8.50336 17.2013 8.38687 17.129 8.21647L13.9601 0.751045C13.7877 0.344864 13.212 0.344864 13.0396 0.751045L9.87072 8.21647C9.7984 8.38687 9.63785 8.50336 9.45343 8.51926L1.34342 9.2186C0.903303 9.25655 0.725024 9.80482 1.05865 10.0944L7.20583 15.4294C7.34569 15.5508 7.40701 15.7396 7.36518 15.92L5.52698 23.8479C5.42716 24.2785 5.89405 24.6173 6.27243 24.3889L13.2415 20.1827Z" fill="#FF5200"/>
					</svg>
				</span>                                    
			</div>
			<div class="review-rating-middle-content">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
				<p class="by"><span>by</span> Syed Najmul Hasan <span>on 16 Nov 2020</span></p>
			</div>
	</div> 

	</div>
</div>