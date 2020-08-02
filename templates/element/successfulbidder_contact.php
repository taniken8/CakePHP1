<fieldset>
	<!-- 連絡先を表示 -->
	<?php if ($isContact): ?>
		<legend>※郵便番号・住所・電話番号を入力してください</legend>
		<?php
			echo $this->Form->create($bidcontact);
			echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->id]);
			echo $this->Form->hidden('user_id', ['value' => $authuser['id']]);
			echo $this->Form->control('zip', ['placeholder' => '〒○○○-○○○○', 'label' => '郵便番号']);
			echo $this->Form->control('address', ['label' => '住所']);
			echo $this->Form->error('phone_number');
			echo $this->Form->control('phone_number', ['placeholder' => '○○○-○○○-○○○○', 'label' => '電話番号']);
			echo $this->Form->hidden('send', ['value' => 0]);
			echo $this->Form->hidden('receipt', ['value' => 0]);
			echo $this->Form->submit('連絡先を送る');
			echo $this->Form->end()
		?>
	<?php endif; ?>

	<!-- 発送ボタンをおしていなければ -->
	<?php if ($isShipping): ?>
		<p>商品が発送されるまでお待ちください。</p>
	<?php endif; ?>

	<!-- 受取ボタンを押していなければ -->
	<?php if ($isReceipt): ?>
		<p>商品の受取が完了したら、「受取ボタン」を押してください。</p>
		<?php
			echo $this->Form->create($bidcontact,
				['type' => 'post',
				'url' => ['controller' => 'Auction',
				'action' => 'receipt']]);
			echo $this->Form->hidden('id', ['value' => $bidinfo->bidcontact->id]);
			echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->bidcontact->bidinfo_id]);
			echo $this->Form->button('受取', ['type' => 'submit']);
			echo $this->Form->end();
		?>
	<?php endif; ?>

	<!-- 出品者への評価をしていなければ -->
	<?php if ($isReview): ?>
		<h3>出品者の評価を入力してください</h3>
		<?php
			echo $this->Form->create($bidcontact,
			['type' => 'post',
			'url' => ['controller' => 'Auction',
			'action' => 'review']]);
			echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->id]);
			echo $this->Form->hidden('review_user_id', ['value' => $bidinfo->biditem->user_id]);
			echo $this->Form->hidden('user_id', ['value' => $authuser['id']]);
			echo $this->Form->control('rate', ['type' => 'number', 'label' => '落札者の評価（５段階で評価してください）',  'min' => 1, 'max' => 5]);
			echo $this->Form->control('comment', ['label' => '落札者の評価']);
			echo $this->Form->button('送信', ['type' => 'submit']);
			echo $this->Form->end();
		?>
	<?php endif; ?>

	<?php if ($isFinish): ?>
		<p>お取引ありがとうございました。引き続きオークションをお楽しみください。</p>
	<?php endif; ?>
</fieldset>