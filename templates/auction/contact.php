	<h2>取引をする</h2>
<fieldset>
	<!-- 落札者であれば -->
   	<?php if ($bidinfo->user_id === $authuser['id'] ): ?>
		<!-- 連絡先を送信していれば -->
		<?php if ($bidinfo->bidcontact): ?>
			<!-- 発送ボタンが押されていたら -->
			<?php if ($bidinfo->bidcontact->send): ?>
				<!-- 受取ボタンを押していたら -->
				<?php if ($bidinfo->bidcontact->receipt): ?>
					<!-- 出品者への評価がまだであれば -->
					<?php if (empty($bidinfo->bidreview)): ?>
						<h3>出品者の評価を入力してください</h3>
						<?php
							echo $this->Form->create($bidreview);
							echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->id]);
							echo $this->Form->hidden('review_user_id', ['value' => $bidinfo->biditem->user_id]);
							echo $this->Form->hidden('user_id', ['value' => $authuser['id']]);
							echo $this->Form->control('rate', ['label' => '落札者の数値評価']);
							echo $this->Form->control('comment', ['label' => '落札者の評価']);
							echo $this->Form->button('送信', ['type' => 'submit', 'name' => 'review']);
							echo $this->Form->end();
						?>
					<?php else: ?>
						<p>お取引ありがとうございました。引き続きオークションをお楽しみください。</p>
					<?php endif; ?>
				<?php else: ?>
					<p>商品の受取が完了したら、「受取ボタン」を押してください。</p>
					<?php
						echo $this->Form->create($bidcontact);
						echo $this->Form->hidden('id', ['value' => $bidinfo->bidcontact->id]);
						echo $this->Form->button('受取', ['type' => 'submit', 'name' => 'receipt']);
						echo $this->Form->end();
					?>
				<?php endif; ?>
			<?php else: ?>
				<p>商品が発送されるまでお待ちください。</p>
			<?php endif; ?>
		<?php else: ?>
			<legend>※郵便番号・住所・電話番号を入力してください</legend>
			<?php
				echo $this->Form->create($bidcontact);
				echo $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->id]);
				echo $this->Form->hidden('user_id', ['value' => $authuser['id']]);
				echo $this->Form->control('zip', ['label' => '郵便番号']);
				echo $this->Form->control('address', ['label' => '住所']);
				echo $this->Form->error('phone_number');
				echo $this->Form->control('phone_number', ['label' => '電話番号']);
				echo $this->Form->hidden('send', ['value' => 0]);
				echo $this->Form->hidden('receipt', ['value' => 0]);
				echo $this->Form->submit('連絡先を送る', ['name' => 'contact']);
				echo $this->Form->end()
			?>
		<?php endif; ?>
	<?php endif; ?>

	<!-- 出品者であれば -->
	<?php if ($bidinfo->user_id !== $authuser['id']): ?>
		<!-- 落札者からの連絡があれば -->
		<?php if ($bidinfo->bidcontact): ?>
			<!-- 発送ボタンを押していれば -->
			<?php if ($bidinfo->bidcontact->send): ?>
				<!-- 落札者への評価がまだであれば -->
				<?php if (empty($bidinfo->bidreview)): ?>
					<h3>落札者の評価を入力してください</h3>
					<?php
						echo $this->Form->create($bidreview);
						echo $this->Form->hidden('review_user_id', ['value' => $bidinfo->user_id]);
						echo $this->Form->hidden('user_id', ['value' => $authuser['id']]);
						echo $this->Form->control('rate', ['label' => '落札者の数値評価']);
						echo $this->Form->control('comment', ['label' => '落札者の評価']);
						echo $this->Form->button('送信', ['type' => 'submit', 'name' => 'review']);
						echo $this->Form->end();
					?>
				<?php else: ?>
					<p>お取引ありがとうございました。引き続きオークションをお楽しみください。</p>
				<?php endif; ?>
			<?php else: ?>
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
					echo $this->Form->create($bidcontact);
					echo $this->Form->hidden('id', ['value' => $bidinfo->bidcontact->id]);
					echo $this->Form->button('発送', ['type' => 'submit', 'name' => 'send']);
					echo $this->Form->end();
				?>
			<?php endif; ?>
		<?php else: ?>
			<p>落札者からの連絡はありません。もうしばらくお待ちください。</p>
		<?php endif; ?>
	<?php endif; ?>
</fieldset>