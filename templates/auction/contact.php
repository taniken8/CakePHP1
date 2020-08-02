<h2>取引をする</h2>
<!-- ログインユーザーが落札者であれば -->
<?php if ($bidinfo->user_id === $authuser['id']): ?>
	<?=$this->element('successfulbidder_contact', ['bidcontact' => $bidcontact, 'bidinfo' => $bidinfo, 'isContact' => $isContact, 'isShippig' => $isShipping, 'isReceipt' => $isReceipt, 'isReview' => $isReview, 'isFinish' => $isFinish]) ?>
<?php endif; ?>

<!-- ログインユーザーが出品者であれば -->
<?php if ($bidinfo->biditem->user_id === $authuser['id']): ?>
	<?=$this->element('bidder_contact', ['bidcontact' => $bidcontact, 'bidinfo' => $bidinfo, 'isContact' => $isContact, 'isSend' => $isShipping, 'isReceipt' => $isReceipt, 'isReview' => $isReview, 'isFinish' => $isFinish]) ?>
<?php endif; ?>