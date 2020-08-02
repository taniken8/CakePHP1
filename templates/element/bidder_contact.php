<fieldset>
		<!-- 落札者からの連絡があれば -->
		<?php if ($isContact): ?>
			<p>商品が落札されました。落札者からの連絡をお待ちください。</p>
		<?php endif; ?>

		<!-- 発送ボタンを押していれば -->
		<?php if ($isShipping): ?>
			<p>落札者の連絡先です。商品の発送が完了したら、「発送ボタン」を押してください。</p>
			<table class="vertical-table">
			<tr>
				<th scope="row">落札者の住所</th>
				<td><?= h($bidinfo->bidcontact->address) ?></td>
			</tr>
			<tr>
				<th scope="row">郵便番号</th>
				<td><?= h($bidinfo->bidcontact->zip) ?></td>
			</tr>
			<tr>
				<th scope="row">電話番号</th>
				<td><?= h($bidinfo->bidcontact->phone_number) ?></td>
			</tr>
			<tr>
				<th scope="row">送信日時</th>
				<td><?= h($bidinfo->bidcontact->created) ?></td>
			</tr>
			</table>
			<?php
				echo $this->Form->create($bidcontact,
				['type' => 'post',
				'url' => ['controller' => 'Auction',
				'action' => 'shipping']]);
				echo $this->Form->hidden('id', ['value' => $bidinfo->bidcontact->id]);
				echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->bidcontact->bidinfo_id]);
				echo $this->Form->button('発送', ['type' => 'submit']);
				echo $this->Form->end();
			?>
		<?php endif; ?>

		<!-- 受取ボタンを押していなければ -->
		<?php if ($isReceipt): ?>
			<p>落札者が商品を受け取ったら、落札者の評価をしてください。</p>
		<?php endif; ?>

		<!-- 落札者への評価がまだであれば -->
		<?php if ($isReview): ?>
			<h3>落札者の評価を入力してください</h3>
			<?php
				echo $this->Form->create($bidcontact,
				['type' => 'post',
				'url' => ['controller' => 'Auction',
				'action' => 'review']]);
				echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->id]);
				echo $this->Form->hidden('review_user_id', ['value' => $bidinfo->user_id]);
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