// ▼ カウントダウンタイマーの設定
function CountdownTimer(elm, tl, mes) {
	this.initialize.apply(this, arguments);
  }
  CountdownTimer.prototype = {
	initialize: function (elm, tl, mes) {
	  this.elem = document.getElementById(elm);
	  this.tl = tl;
	  this.mes = mes;
	},
	countDown: function () {
	  var timer = '';
	  var today = new Date();
	  var day = Math.floor((this.tl - today) / (24 * 60 * 60 * 1000));
	  var hour = Math.floor((day * 24) + ((this.tl - today) % (24 * 60 * 60 * 1000)) / (60 * 60 * 1000));
	  var min = Math.floor(((this.tl - today) % (24 * 60 * 60 * 1000)) / (60 * 1000)) % 60;
	  var sec = Math.floor(((this.tl - today) % (24 * 60 * 60 * 1000)) / 1000) % 60 % 60;
	  var milli = Math.floor(((this.tl - today) % (24 * 60 * 60 * 1000)) / 10) % 100;
	  var me = this;

	  if ((this.tl - today) > 0) {
		if (hour) timer += '<span class="cdt_num">' + hour + '</span><small>時間</small>';
		timer += '<span class="cdt_num">' + this.addZero(min) + '</span><small>分</small><span class="cdt_num">' + this.addZero(sec) + '</span><small>秒</small><span class="cdt_num">' + this.addZero(milli) + '</span>';
		this.elem.innerHTML = timer;
		tid = setTimeout(function () {
		  me.countDown();
		}, 10);
	  } else {
		this.elem.innerHTML = this.mes;
		return;
	  }
	},
	addZero: function (num) {
	  return ('0' + num).slice(-2);
	}
  }


  // ▼ 開始＆終了日時の指定と日付の判別
  function CDT() {
	var end = php.end; //PHPから取得した入札の終了時間を変数に代入

	var myD = Date.now(); // 1970/1/1午前0時から現在までのミリ秒
	var start = new Date(); // 開始日時
	var myS = start.getTime(); // 1970/1/1午前0時からの開始日時までのミリ秒
	var end = new Date(end); // 終了日時
	var myE = end.getTime(); // 1970/1/1午前0時から終了日時までのミリ秒

	// 今日が開始日前か期間中か終了日後かの判別
	if (myS <= myD && myE >= myD) {
	  var text = '<span>終了</span><span>まで</span>';
	  var tl = end;
	} // 期間中
	else if (myS > myD) {
	  var text = '<span>開催</span><span>まで</span>';
	  var tl = start;
	} // 開始日前
	else {
	  var text = "";
	} // 終了日後

	var timer = new CountdownTimer('cdt_date', tl, '<small>終了しました</small>'); // 終了日後のテキスト
	timer.countDown();
	target = document.getElementById("cdt_txt");
	target.innerHTML = text;
  }
  window.onload = function () {
	CDT();
  }