<h2>商品を出品する</h2>
<?=$this->Form->create($biditem, ['type' => 'file']) ?>
<fieldset>
	<legend>※商品名と終了日時を入力：</legend>
	<?php
		echo $this->Form->hidden('user_id', ['value' => $authuser['id']]);
		echo '<p><strong>USER: ' . $authuser['username'] . '</strong></p>';
		echo $this->Form->control('name');
		echo $this->Form->control('detail'); //【機能追加】商品詳細フォーム
		echo $this->Form->control('image_file', ['type'=>'file']); //【機能追加】商品画像のアップローダー
		echo $this->Form->hidden('finished', ['value' => 0]);
		echo $this->Form->control('endtime');
	?>
</fieldset>
<?=$this->Form->submit(__('商品を出品する')) ?>
<?=$this->Form->end() ?>