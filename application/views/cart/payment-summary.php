<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$checkoutForm->addFormTagAttribute('onsubmit', 'cart.confirmOrder(this.form); return false;');
$orderType = $checkoutForm->getField('order_type');
$orderType->addFieldTagAttribute('class', 'd-none');
$pmethodField = $checkoutForm->getField('order_pmethod_id');
$couponField = $checkoutForm->getField('coupon_code');
$couponField->addFieldTagAttribute('id', 'coupon_code');
$couponField->addFieldTagAttribute('onkeypress', 'cart.disableEnter(event)');
$couponField->addFieldTagAttribute('placeholder', Label::getLabel('LBL_ENTER_COUPON_CODE'));
$submitField = $checkoutForm->getField('submit');
$submitField->addFieldTagAttribute('onclick', 'cart.confirmOrder(this.form);');
$submitField->addFieldTagAttribute('class', 'btn btn--primary btn--large btn--block color-white');
$cartNetAmount = $cartTotal - $cartDiscount;

$steps = Cart::getSteps();
?>
<div class="box box--checkout">
	<div class="box__head">
		<?php if (!empty($cartItems[Cart::LESSON]) || !empty($cartItems[Cart::SUBSCR])) { ?>
			<a href="javascript:void(0);" class="btn btn--bordered color-black btn--back" onclick="cart.viewCalendar(cart.prop.ordles_teacher_id, cart.prop.ordles_tlang_id, cart.prop.ordles_duration, cart.prop.ordles_quantity, cart.prop.ordles_type);">
				<svg class="icon icon--back">
					<use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#back'; ?>"></use>
				</svg>
				<?php echo Label::getLabel('LBL_BACK'); ?>
			</a>
		<?php } ?>
		<h4><?php echo Label::getLabel('LBL_SELECT_PAYMENT_METHOD'); ?></h4>
		<?php if (!empty($cartItems[Cart::LESSON]) || !empty($cartItems[Cart::SUBSCR])) { ?>
			<div class="step-nav">
				<ul>
					<?php foreach ($steps as $key => $step) { ?>
						<li class="step-nav_item <?php echo in_array($key, $stepProcessing) ? 'is-process' : ''; ?> <?php echo in_array($key, $stepCompleted) ? 'is-completed' : ''; ?> ">
							<a href="javascript:void(0);"><?php echo $step; ?></a><?php if (in_array($key, $stepCompleted)) { ?><span class="step-icon"></span><?php } ?>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
	</div>
	<style>
		.checkout-left {
			border: 1px solid #DDDDDD;
			border-radius: 16px;
			padding: 40px 20px;
		}

		.checkout-wrapper {
			width: 100%;
		}

		.checkout-left-top .checkout-left-thumb {
			flex: 0 0 110px;
			max-width: 110px;
			margin-right: 12px;
		}

		.checkout-left-top .checkout-left-thumb img {
			border-radius: 16px;
		}

		.checkout-right-thumb h4 {
			font-family: 'Lexend';
			font-style: normal;
			font-weight: 400;
			font-size: 18px;
			line-height: 28px;
		}

		.checkout-right-thumb .tutor-name h4 {
			font-family: 'Lexend';
			font-style: normal;
			font-weight: 700;
			font-size: 24px;
			line-height: 30px;
			margin-bottom: 12px;
		}

		.timebased,
		.your-order-wrapper {
			margin-top: 20px;
		}

		.timebased p {
			font-weight: 300;
			font-size: 14px;
			line-height: 22px;
		}

		.your-order-wrapper h5 {
			font-family: 'Lexend';
			font-style: normal;
			font-weight: 700;
			font-size: 24px;
			line-height: 30px;
			margin-bottom: 30px;
		}

		.yourorder-table-td {
			font-family: 'Lexend';
			font-style: normal;
			font-weight: 300;
			font-size: 16px;
			line-height: 24px;
		}

		.yourorder-table-tr {
			display: flex;
			justify-content: space-between;
			padding: 7px 0;
		}

		.sub-total-tr {
			border-top: 1px solid #B3B3B3;
		}

		.promo-code-control {
			height: 32px;
			border: 1px solid #DDDDDD;
			padding: 5px;
			margin-bottom: 5px;
			max-width: 132px;
		}

		.promo-code-label {
			font-weight: 300;
			font-size: 11px;
			line-height: 14px;
			display: block;
		}

		.free-refund {
			background: #D9F2DC;
			border-radius: 16px;
			padding: 16px 24px;
			margin-top: 20px;
		}

		.free-refund p {
			margin-top: 10px;
			margin-bottom: 0;
			font-weight: 300;
			font-size: 14px;
			line-height: 22px;
		}

		.free-refund span {
			color: #009444;
			font-weight: 300;
			font-size: 16px;
			line-height: 24px;
			display: inline-block;
			vertical-align: middle;
		}

		.radio-button-set {
			display: flex;
		}

		.radio-button-control {
			width: 100%;
			margin-bottom: 20px;
		}

		.radio-button-control label {
			background: #DDDDDD;
			width: 100%;
			height: 68px;
			padding: 20px 11px;
			text-align: center;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.radio-button-control input[type=radio] {
			display: none;
		}

		.radio-button-control input[type=radio]:checked+label {
			background: #2765F1;
			color: #fff;
		}

		.form-group {
			margin-bottom: 20px;
		}

		.form-group label {
			font-family: 'Lexend';
			font-style: normal;
			font-weight: 400;
			font-size: 18px;
			line-height: 28px;
		}

		.half-controls {
			margin: 0 -15px;
			display: flex;
		}

		.half-controls .form-group {
			padding: 0 15px;
			width: 50%;
		}

		.review-and-placeorder {
			margin-top: 20px;
			margin-bottom: 20px;
		}

		.review-and-placeorder h5 {
			margin-bottom: 8px;
		}

		.radio-button-control label:before {
			content: "";
			height: 20px;
			width: 20px;
			border: 2px solid #545454;
			border-radius: 50%;
			margin-right: 13px;
		}

		.radio-button-control input[type=radio]:checked+label:before {
			border: none;
			background-image: url('/images/check-mark-icon.png');
			background-repeat: no-repeat;
			background-position: center center;
			background-size: contain;
		}
	</style>
	<div class="box__body">
		<div class="selection-tabs selection--checkout selection--payment" style="height:100%;">
			<form name="paymenrform" method="post" id="payment-form" data-stripe-publishable-key="pk_live_51KlBYRBHOKvtnZNpQydMxT9DcsZbYGuX4wXxUptDWTLmYOPotx2r9OEu3gidCFFiz2IIttG2oNZnVfR1D6Uw9OtF00FjzITule" onsubmit="cart.stripe(this); return(false);">
				<div class="row checkout-wrapper">
					<div class="col-md-5">
						<div class="checkout-left">
							<div class="checkout-left-top">
								<div class="d-flex">
									<div class="checkout-left-thumb">
										<!--img src="https://beta.myonlinetutor.co/image/show/4/816/MEDIUM" width="110" height="130" alt=""-->
										<img src="<?php echo MyUtility::makeUrl('Image', 'show', [Afile::TYPE_USER_PROFILE_IMAGE, $teacher['user_id'], Afile::SIZE_SMALL]) . '?' . time(); ?>" width="110" height="130" alt="">

									</div>
									<div class="checkout-right-thumb">
										<?php foreach ($cartItems[Cart::LESSON] as $key => $value) { ?>
											<h4><?php echo $value['ordles_tlang']; ?></h4>
										<?php } ?>
										<div class="tutor-name">
											<h4><?php echo $teacher['user_first_name'] . ' ' . $teacher['user_last_name']; ?></h4>
											<img src="/images/ic_baseline-verified-user.png" height="40" width="40" alt="Verified">
										</div>
										<div class="info-tag ratings">
											<div class="ratings-inner">

												<span class="value"><?php echo $rating[0]['testat_ratings']; ?></span>
												<svg class="icon icon--rating">
													<use xlink:href="/images/sprite.svg#rating"></use>
												</svg>
											</div>
											<div class="teachers-view-rate">
												<span class="count"><?php echo " ( " . $rating[0]['testat_reviewes'] . ' Review(s) )'; ?></span>

											</div>
										</div>
									</div>
								</div>
								<div class="timebased">
									<h5>Tuesday, November 8, 01:30</h5>
									<?php //$date=date_create($starttime[0]);
									//echo date_format($date,"D F"); 
									?>
									<p>Time is based on your live location</p>
								</div>

								<div class="your-order-wrapper">
									<h5>Your Order</h5>
									<div class="yourorder-table">
										<div class="yourorder-table-tr">
											<div class="yourorder-table-td">
												<?php foreach ($cartItems[Cart::LESSON] as $key => $value) { ?>
													<?php echo $value['ordles_duration'] . ' Mins X ' . $value['ordles_quantity'] . ' Lesson(s)'; ?>
												<?php } ?>
											</div>
											<div class="yourorder-table-td">
												<?php $sub_total = $value['ordles_quantity'] * $value['ordles_amount'];
												echo MyUtility::formatMoney($sub_total); ?>
											</div>
										</div>

										<div class="yourorder-table-tr">
											<div class="yourorder-table-td">
												Processing Fee
											</div>
											<div class="yourorder-table-td">
												$<?php echo FatApp::getConfig('PROCESSING_FEES') ?>
											</div>
										</div>


										<div class="yourorder-table-tr sub-total-tr">
											<div class="yourorder-table-td">
												<b>Sub Total</b>
											</div>
											<div class="yourorder-table-td">
												<b><?php echo MyUtility::formatMoney($sub_total + FatApp::getConfig('PROCESSING_FEES')); ?></b>
											</div>
										</div>


										<div class="yourorder-table-tr">
											<div class="yourorder-table-td">
												<form>
													<input type="text" class="promo-code-control" name="coupon_code" id="promo_code_input" value="<?php echo isset($appliedCoupon['coupon_code']) ? $appliedCoupon['coupon_code'] : ''; ?>">
													<span class="promo-code-label">Coupon Code</span>
													<a href="javascript:void(0);" onclick="cart.applyCoupon($('#promo_code_input').val());" class="btn btn--secondary btn--small color-white"><?php echo Label::getLabel('LBL_APPLY'); ?></a>
												</form>
											</div>
											<div class="yourorder-table-td">
												<?php if (isset($appliedCoupon['coupon_discount'])) {
													echo '-' . MyUtility::formatMoney($appliedCoupon['coupon_discount']);
												} else {
													echo '-' . MyUtility::formatMoney(0.00);
												}
												?>
											</div>
										</div>

										<div class="yourorder-table-tr">
											<div class="yourorder-table-td">
												<b>Total</b>
											</div>
											<div class="yourorder-table-td">
												<b><span><?php echo MyUtility::formatMoney($cartNetAmount + FatApp::getConfig('PROCESSING_FEES')); ?></span></b>
												<input type="hidden" class="subtotal" name="total" value="<?php echo $cartNetAmount + FatApp::getConfig('PROCESSING_FEES'); ?>" />
											</div>
										</div>
										<input type="hidden" value="" name="is_trail" class="is_trail" />
										<div class="free-refund" style="display:none;">
											<span>
												<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M22 11L19.56 8.21L19.9 4.52L16.29 3.7L14.4 0.5L11 1.96L7.6 0.5L5.71 3.69L2.1 4.5L2.44 8.2L0 11L2.44 13.79L2.1 17.49L5.71 18.31L7.6 21.5L11 20.03L14.4 21.49L16.29 18.3L19.9 17.48L19.56 13.79L22 11ZM9.09 15.72L5.29 11.91L6.77 10.43L9.09 12.76L14.94 6.89L16.42 8.37L9.09 15.72Z" fill="#009444" />
												</svg>
											</span>
											<span>Free replacement or refund</span>

											<p>Try another tutor for free or get refund of your unused balance</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="checkout-right">
							<div class="radio-button-set">
								<div class="radio-button-control">
									<input type="radio" id="paypal" name="payment-radio" value="paypal">
									<label for="paypal">Paypal</label>
								</div>
								<div class="radio-button-control">
									<input type="radio" id="card" name="payment-radio" value="Card" checked>
									<label for="card">Card</label>
								</div>
							</div>
							<div class="full-controls">
								<div class="form-group">
									<label>Card Number</label>
									<input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="">
								</div>
							</div>
							<div class="half-controls">
								<div class="form-group">
									<label>MM/YY</label>
									<input type="text" class="form-control" id="cardMonth" name="cardMonth" placeholder="MM/YY" name="" onkeyup="modifyInput(this)">

								</div>
								<div class="form-group">
									<label>CVC</label>
									<input type="number" class="form-control" id="cardCVV" name="cardCVV">
								</div>
							</div>
							<div class="checkmark">
								<input type="checkbox" id="savecard">
								<label for="savecard">Save this Card for future payments</label>
							</div>
							<div class="review-and-placeorder">
								<h5>Review & Place Order</h5>
								<p>Please review the order details and payment details before proceeding to confirm your order </p>

								<div class="checkmark-review-and-placeorder">
									<input type="checkbox" id="agree" required>
									<label for="agree">I agree to the Terms & conditions, Privacy policy & Return policy</label>
								</div>
							</div>
							<div class="form-btn">
								<input type='hidden' id="stripeToken" name='stripeToken' value="" />
								<button type="button" class="subscribe btn btn--secondary color-white" id="payFormButton">Place Order</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<?php //echo $checkoutForm->getFormTag(); 
			?>
			<?php //echo $orderType->getHTML(); 
			?>
			<form id="checkoutForm" name="checkoutForm" method="post" onsubmit="cart.confirmOrder(this); return false;" style="display:none;">
				<div class="row">
					<div class="col-md-6 col-xl-6">
						<div class="selection-title">
							<p><?php echo Label::getLabel('LBL_SELECT_A_PAYMENT_METHOD'); ?></p>
							<input type="hidden" name="ordles_teacher_id" value="<?php echo $teacher['user_id']; ?>" />
						</div>
						<div class="payment-wrapper">
							<?php if ($walletBalance > 0 && $walletBalance < $cartNetAmount) { ?>
								<label class="selection-tabs__label payment-method-js">
									<input type="checkbox" name="add_and_pay" class="selection-tabs__input" value="1" <?php echo ($addAndPay == 1) ? 'checked="checked"' : ''; ?> onclick="cart.selectWallet(this.checked)" />
									<div class="selection-tabs__title">
										<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
											<g>
												<path d="M12,22A10,10,0,1,1,22,12,10,10,0,0,1,12,22Zm-1-6,7.07-7.071L16.659,7.515,11,13.172,8.174,10.343,6.76,11.757Z" transform="translate(-2 -2)" />
											</g>
										</svg>
										<div class="payment-type">
											<p><?php echo str_replace(['{remaining}'], [MyUtility::formatMoney($walletBalance)], Label::getLabel('LBL_PAY_{remaining}_FROM_WALLET_BALANCE')); ?></p>
										</div>
									</div>
								</label>
							<?php } ?>
							<?php foreach ($pmethodField->options as $id => $name) { ?>
								<label class="selection-tabs__label payment-method-js">
									<input type="radio" class="selection-tabs__input" value="<?php echo $id; ?>" <?php echo ($pmethodField->value == $id) ? 'checked' : ''; ?> name="order_pmethod_id" />
									<div class="selection-tabs__title">
										<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
											<g>
												<path d="M12,22A10,10,0,1,1,22,12,10,10,0,0,1,12,22Zm-1-6,7.07-7.071L16.659,7.515,11,13.172,8.174,10.343,6.76,11.757Z" transform="translate(-2 -2)" />
											</g>
										</svg>
										<div class="payment-type">
											<p><?php echo ($id != $walletPayId) ? $name : str_replace(['{balance}'], [MyUtility::formatMoney($walletBalance)], Label::getLabel('LBL_WALLET_BALANCE_({balance})')); ?></p>
										</div>
									</div>
								</label>
							<?php } ?>
						</div>
					</div>
					<div class="col-md-6  col-xl-6">
						<div class="selection-title">
							<p><?php echo Label::getLabel('LBL_HAVE_A_COUPON?'); ?></p>
							<?php if (count($availableCoupons) > 0) { ?>
								<a href="javascript:void(0);" class="color-primary btn--link slide-toggle-coupon-js"><?php echo Label::getLabel('LBL_VIEW_COUPONS'); ?></a>
							<?php } ?>
						</div>
						<div class="apply-coupon">
							<svg class="icon icon--price-tag">
								<use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#price-tag'; ?>"></use>
							</svg>
							<?php echo $couponField->getHTML(); ?>
							<a href="javascript:void(0);" onclick="cart.applyCoupon();" class="btn btn--secondary btn--small color-white"><?php echo Label::getLabel('LBL_APPLY'); ?></a>
						</div>
						<?php if (!empty($appliedCoupon['coupon_id'])) { ?>
							<div class="coupon-applied">
								<div class="coupon-type">
									<span class="bold-600 coupon-code"><?php echo $appliedCoupon['coupon_code']; ?></span>
									<p><?php echo Label::getLabel('LBL_COUPON_APPLIED'); ?></p>
								</div>
								<a href="javascript:void(0);" onclick="cart.removeCoupon();" class="btn btn--coupon btn--small"><?php echo Label::getLabel('LBL_REMOVE'); ?></a>
							</div>
						<?php } ?>
						<div class="selection-title">
							<p><?php echo Label::getLabel('LBL_SUMMARY'); ?></p>
						</div>
						<div class="payment-summary">
							<?php foreach ($cartItems[Cart::LESSON] as $key => $value) { ?>
								<div class="payment__row">
									<div>
										<p><?php echo str_replace(['{quantity}', '{duration}'], [$value['ordles_quantity'], $value['ordles_duration']], Label::getLabel('LBL_Lesson_Count:_{quantity}_Lesson(s)_Duration:_{duration}_Mins/lesson')); ?></p>
										<p><?php echo str_replace('{itemprice}', MyUtility::formatMoney($value['ordles_amount']), Label::getLabel('LBL_Item_Price:_{itemprice}/lesson')); ?></p>
										<p><?php echo str_replace('{teachlang}', $value['ordles_tlang'], Label::getLabel('LBL_TEACH_LANGUAGE_:_{teachlang}')); ?></p>
									</div>
									<div><b><?php echo MyUtility::formatMoney($value['ordles_quantity'] * $value['ordles_amount']); ?></b></div>
								</div>
							<?php } ?>
							<?php if (!empty($cartItems[Cart::SUBSCR])) { ?>
								<div class="payment__row">
									<div>
										<p><?php echo str_replace(['{quantity}', '{duration}'], [$cartItems[Cart::SUBSCR]['ordles_quantity'], $cartItems[Cart::SUBSCR]['ordles_duration']], Label::getLabel('LBL_Lesson_Count:_{quantity}_Lesson(s)_Duration:_{duration}_Mins/lesson')); ?></p>
										<p><?php echo str_replace('{itemprice}', MyUtility::formatMoney($cartItems[Cart::SUBSCR]['ordles_amount']), Label::getLabel('LBL_Item_Price:_{itemprice}/lesson')); ?></p>
										<p><?php echo str_replace('{teachlang}', $cartItems[Cart::SUBSCR]['ordles_tlang'], Label::getLabel('LBL_TEACH_LANGUAGE_:_{teachlang}')); ?></p>
									</div>
									<div><b><?php echo MyUtility::formatMoney($cartItems[Cart::SUBSCR]['ordles_quantity'] * $cartItems[Cart::SUBSCR]['ordles_amount']); ?></b></div>
								</div>
							<?php } ?>
							<?php foreach ($cartItems[Cart::GCLASS] as $key => $class) { ?>
								<div class="payment__row">
									<div>
										<b><?php echo $class['grpcls_title']; ?></b>
										<p><?php echo str_replace('{itemprice}', MyUtility::formatMoney($class['ordcls_amount']), Label::getLabel('LBL_ITEM_PRICE:_{itemprice}/CLASS')); ?></p>
										<p><?php echo Label::getLabel('LBL_START_TIME') . ' : ' . MyDate::formatDate($class['grpcls_start_datetime']); ?> </p>
										<p><?php echo Label::getLabel('LBL_END_TIME') . ' : ' . MyDate::formatDate($class['grpcls_end_datetime']); ?> </p>
									</div>
									<div><b><?php echo MyUtility::formatMoney($class['ordcls_amount']); ?></b></div>
								</div>
							<?php } ?>
							<?php foreach ($cartItems[Cart::PACKGE] as $key => $package) { ?>
								<div class="payment__row">
									<div>
										<b><?php echo $package['grpcls_title']; ?></b>
										<p><?php echo str_replace('{itemprice}', MyUtility::formatMoney($package['grpcls_amount']), Label::getLabel('LBL_ITEM_PRICE:_{itemprice}/PACKAGE')); ?></p>
										<p><?php echo Label::getLabel('LBL_START_TIME') . ' : ' . MyDate::formatDate($package['grpcls_start_datetime']); ?> </p>
										<p><?php echo Label::getLabel('LBL_END_TIME') . ' : ' . MyDate::formatDate($package['grpcls_end_datetime']); ?> </p>
										<p><?php echo Label::getLabel('LBL_TOTAL_CLASSES') . ' : ' . count($package['classes']); ?> </p>
									</div>
									<div><b><?php echo MyUtility::formatMoney($package['grpcls_amount']); ?></b></div>
								</div>
							<?php } ?>
							<?php if (!empty($appliedCoupon['coupon_id'])) { ?>
								<div class="payment__row">
									<div><b><?php echo Label::getLabel('LBL_COUPON_DISCOUNT'); ?></b></div>
									<div><b><?php echo '-' . MyUtility::formatMoney($appliedCoupon['coupon_discount']); ?></b></div>
								</div>
							<?php } ?>
							<?php if ($addAndPay == AppConstant::YES && $walletBalance > 0 && $walletBalance < $cartNetAmount) { ?>
								<div class="payment__row">
									<div><b><?php echo Label::getLabel('LBL_WALLET_DETUCTION'); ?></b></div>
									<div><b><?php echo '-' . MyUtility::formatMoney($walletBalance); ?></b></div>
								</div>
								<div class="payment__row">
									<div><b class="color-primary"><?php echo Label::getLabel('LBL_TOTAL'); ?></b></div>
									<div><b class="color-primary"><?php echo MyUtility::formatMoney($cartNetAmount - $walletBalance); ?></b></div>
								</div>
							<?php } else { ?>
								<div class="payment__row">
									<div><b class="color-primary"><?php echo Label::getLabel('LBL_TOTAL'); ?></b></div>
									<div><b class="color-primary"><?php echo MyUtility::formatMoney($cartNetAmount); ?></b></div>
								</div>
							<?php } ?>
						</div>
						<?php if (count($availableCoupons) > 0) { ?>
							<div class="coupon-box slide-target-coupon-js">
								<div class="coupon-box__head">
									<p><?php echo Label::getLabel('LBL_AVAILABLE_COUPONS'); ?></p>
									<a href="javascript:void(0);" class="btn btn--bordered color-black btn--close">
										<svg class="icon icon--close">
											<use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#close'; ?>"></use>
										</svg>
									</a>
								</div>
								<div class="coupon-box__body">
									<?php foreach ($availableCoupons as $key => $coupon) { ?>
										<div class="coupon-list">
											<div class="coupon-list__head">
												<span class="badge color-secondary"><?php echo $coupon['coupon_code']; ?></span>
												<a href="javascript:void(0);" onclick="cart.applyCoupon('<?php echo $coupon['coupon_code']; ?>');" class="btn btn--coupon btn--small color-primary"><?php echo Label::getLabel('LBL_APPLY'); ?></a>
											</div>
											<div class="coupon-list__content">
												<p class="bold-600"><?php echo $coupon['coupon_title']; ?></p>
												<?php if (!empty($coupon['coupon_description'])) { ?>
													<p><?php echo $coupon['coupon_description']; ?> </p>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
						<?php echo $submitField->getHTML(); ?>
						<p class="payment-note color-secondary"> *
							<?php echo str_replace("{currencycode}", $currencyData['currency_code'], Label::getLabel('LBL_ALL_PURCHASES_ARE_IN_{currencycode}')); ?>
							<?php echo Label::getLabel('LBL_FOREIGN_TRANSACTION_FEES_MIGHT_APPLY_ACCORDING_TO_YOUR_BANK_POLICIES'); ?>
						</p>
					</div>
				</div>
				<input type="hidden" name="order_type" value="1" />
				<input type="hidden" value="" name="is_trail" class="is_trail" />
				<input type="hidden" value="" name="total" class="paypal_total" />
			</form>
			<?php //echo $checkoutForm->getExternalJS(); 
			?>
		</div>
	</div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> -->
<script type="text/javascript">
	$(function() {
		var btn = sessionStorage.getItem('btn');
		if (btn == "book_trial") {
			$(".is_trail").val(1);
			$(".free-refund").show();
		} else {
			$(".is_trail").val(0);
			$(".free-refund").hide();
		}
		$("#payFormButton").click(function() {
			if ($('#agree').is(':checked')) {
				fcom.process();
				$(this).prop('disabled', true);
				$('#accept_error').remove()
				//$("#payment-form").valid();
				//if($("#payment-form").valid()){
				var data = ($('#cardMonth').val()).split("/");
				Stripe.setPublishableKey($("#payment-form").data('stripe-publishable-key'));
				Stripe.createToken({
					number: $('#cardNumber').val(),
					cvc: $('#cardCVV').val(),
					exp_month: data[0],
					exp_year: data[1]
				}, stripeResponseHandler);
			}else{
				$('#accept_error').remove()
				$('.checkmark-review-and-placeorder').append('<p style="color:red" id="accept_error">Please accept terms & conditions to continue.');
			}
			//}
		});

		function stripeResponseHandler(status, response) {
			if (response.error) {
				$("#payFormButton").prop('disabled', false);
				/*$('.error')
				    .removeClass('hide')
				    .find('.alert')
				    .text(response.error.message);*/
				alert(response.error.message);
			} else {
				/* token contains id, last4, and card type */
				var token = response['id'];
				$("#stripeToken").val(token);
				$("#payment-form").submit();
			}
		}
	});
</script>
<script>
	$('.slide-toggle-coupon-js').click(function(e) {
		e.preventDefault();
		$(this).parent('.toggle-dropdown').toggleClass("is-active");
	});
	$(".slide-toggle-coupon-js").click(function() {
		$(".slide-target-coupon-js").slideToggle();
	});
	$('.btn--close').click(function() {
		$('.slide-target-coupon-js').slideUp("slow");
	});
	// $(document).on("blur", '#promo_code_input', function() {

	// 	let couponCode = $(this).val();
	// 	console.log(couponCode)
	// 	cart.applyCoupon(couponCode);
	// })
	$('.apply-coupon-js').click(function() {
		let couponCode = $('#coupon_code').val();
		cart.applyPromoCode(couponCode);
	});
	$('input[type=radio][name=order_pmethod_id]').on('change', function() {
		if ($(this).val() == <?php echo $walletPayId; ?>) {
			$('.renew-payment').show();
		} else {
			$('.renew-payment').hide();
		}
	});
	$('input[type=radio][name=payment-radio]').on('change', function() {

		if ($(this).val() == "paypal") {
			$(".paypal_total").val($(".subtotal").val());
			$("#checkoutForm").closest("form").submit();
			//$("#payment-form").submit();
		}
	});

	function modifyInput(ele) {

		if (ele.value.length === 2)
			ele.value = ele.value + '/'
		else
		if (ele.value.length === 3 && ele.value.charAt(2) === '/')
			ele.value = ele.value.replace('/', '');
	}
</script>