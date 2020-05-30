<h2>「<?=$biditem->name ?>」の情報</h2>
<table class="vertical-table">
<tr>
	<th class="small" scope="row">出品者</th>
	<td><?= $biditem->has('user') ? $biditem->user->username : '' ?></td>
</tr>
<tr>
	<th scope="row">商品名</th>
	<td><?= h($biditem->name) ?></td>
</tr>
<tr>
	<th scope="row">商品ID</th>
	<td><?= $this->Number->format($biditem->id) ?></td>
</tr>
<!--↓↓↓↓↓↓ 【機能追加】商品詳細の表示 ↓↓↓↓↓↓-->
<tr>
	<th scope="row">詳細情報</th>
	<td><?= h($biditem->detail) ?></td>
</tr>
<!--↓↓↓↓↓↓ 【機能追加】商品画像の表示↓↓↓↓↓↓-->
<tr>
	<th scope="row">商品画像</th>
	<td><?= $this->Html->image($biditem->image) ?></td>
</tr>
<tr>
	<th scope="row">終了時間</th>
	<td><?= h($biditem->endtime) ?></td>
</tr>
<tr>
	<th scope="row">投稿時間</th>
	<td><?= h($biditem->created) ?></td>
</tr>
<tr>
	<th scope="row"><?= __('終了した？') ?></th>
	<td><?= $biditem->finished ? __('Yes') : __('No'); ?></td>
</tr>
<!-- 【機能追加】カウントダウンタイマー -->
<tr>
	<th class="cdt">残り時間</th>
	<td>    <span class="cdt_txt" id="cdt_txt"></span>
    <span class="cdt_date" id="cdt_date"></span>
</td>
</tr>

</table>
<div class="related">
	<h4><?= __('落札情報') ?></h4>
	<?php if (!empty($biditem->bidinfo)): ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th scope="col">落札者</th>
		<th scope="col">落札金額</th>
		<th scope="col">落札日時</th>
	</tr>
	<tr>
		<td><?= h($biditem->bidinfo->user->username) ?></td>
		<td><?= h($biditem->bidinfo->price) ?></td>
		<td><?= h($biditem->endtime) ?></td>
	</tr>
	</table>
	<?php endif; ?>
</div>
<div class="related">
	<h4><?= __('入札情報') ?></h4>
	<?php if (!$biditem->finished): ?>
	<h6><a href="<?=$this->Url->build(['action'=>'bid', $biditem->id]) ?>"><入札する！></a></h6>
	<?php if (!empty($bidrequests)): ?>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th scope="col">入札者</th>
		<th scope="col">金額</th>
		<th scope="col">入札日時</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($bidrequests as $bidrequest): ?>
	<tr>
		<td><?= h($bidrequest->user->username) ?></td>
		<td><?= h($bidrequest->price) ?></td>
		<td><?= $bidrequest->created ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php else: ?>
	<p><?='※入札はまだありません。' ?></p>
	<?php endif; ?>
	<?php else: ?>
	<p><?='※入札は終了しました。' ?></p>
	<?php endif; ?>

</div>


<!----【機能追加】カウントダウンタイマーの記述----------->
<!-----------JavaScriptを読み込み--------------->
<?=$this->Html->script('countdown.js') ?>

<!--入札終了時間の値をDBからPHPに取得してJavaScriptに渡す-->
<?php $end = $biditem->endtime; ?>
<script>
	var php = {
		'end' : '<?php echo $end ?>'
	};
</script>