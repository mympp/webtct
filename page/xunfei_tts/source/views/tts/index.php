<?php

use kartik\helpers\Html;
use kartik\dialog\Dialog;
use kartik\slider\Slider;
use kartik\spinner\Spinner;
use mootensai\components\JsBlock;

/* @var $this yii\web\View */

$this->title = '文本转换语音';
$this->params['breadcrumbs'][] = $this->title;

list(, $assetsBaseUrl) = Yii::$app->assetManager->publish('@app/extensions/xunfei-tts/assets');

$this->registerJsFile($assetsBaseUrl . '/js/fingerprint.js', ['position' => $this::POS_HEAD]);
$this->registerJsFile($assetsBaseUrl . '/js/tts.min.js', ['position' => $this::POS_HEAD]);

echo Dialog::widget([
    'dialogDefaults' => [
        Dialog::DIALOG_ALERT => [
            'type' => Dialog::TYPE_WARNING,
        ],
    ],
]);
?>
<div class="table">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form-group">
        <label class="control-label"></label>
        <?= Html::textarea('content', '', [
            'id'          => 'content',
            'class'       => 'form-control',
            'cols'        => '40',
            'rows'        => '10',
            'style'       => 'resize:vertical',
            'placeholder' => '请输入文字',
        ]) ?>
    </div>

    <div class="form-group">
        <label class="control-label">音色：</label>
        <?= Html::radioButtonGroup('vcn', '', [
            ''            => '默认',
            'xiaoyan'     => '小燕',
            'xiaofeng'    => '小峰',
            'xiaoqi'      => '小琪',
            'vinn'        => '楠楠',
            'vils'        => '老孙',
            'aisjiuxu'    => '许久',
            'aisxping'    => '小萍',
            'aisjying'    => '小筠',
            'aisbabyxu'   => '许小宝',
            'aisjinger'   => '小婧',
            'yefang'      => '叶芳',
            'aisduck'     => '鸭先生',
            'aisxmeng'    => '小梦',
            'aismengchun' => '小春',
            'ziqi'        => '子琪',
            'aisduoxu'    => '许多',
            'xiaoxin'     => '小新',
            'xiaowanzi'   => '小丸子',
            'dalong'      => '粤语-大龙',
            'xiaomei'     => '粤语-小梅',
            'aisxlin'     => '台普-晓琳',
            'xiaoqian'    => '东北话-晓倩',
            'aisxrong'    => '四川话-小蓉',
            'xiaokun'     => '河南话-小坤',
            'aisxqiang'   => '湖南话-小强',
            'aisxying'    => '陕西话-小英',
        ], ['encode' => false]) ?>
    </div>

    <div class="form-group" style="margin-top:30px">
        <label class="control-label">语速 <i>(尚未开放)</i>：</label>
        <?= Slider::widget([
            'name'          => 'spd',
            'value'         => 5,
            'pluginOptions' => [
                'min' => 0,
                'max' => 10,
                //'tooltip' => 'always',
            ],
        ]); ?>
    </div>

    <div class="form-group" style="margin-top:30px">
        <label class="control-label">音量 <i>(尚未开放)</i>：</label>
        <?= Slider::widget([
            'name'          => 'vol',
            'value'         => 5,
            'pluginOptions' => [
                'min' => 0,
                'max' => 10,
                //'tooltip' => 'always',
            ],
        ]); ?>
    </div>

    <div class="form-group">
        <label class="control-label">格式 <i>(尚未开放)</i>：</label>
        <?= Html::radioButtonGroup('gat', '', [
            ''    => '自动',
            'mp3' => 'mp3',
            'wav' => 'wav',
        ]) ?>
    </div>

    <div class="form-group">
        <label class="control-label">背景音乐 <i>(尚未开放)</i>：</label>
        <?= Html::radioButtonGroup('bgs', '0', [
            '0' => '关闭',
            '1' => '开启',
        ]) ?>
    </div>

    <div class="form-group">
        <button class="btn btn-success" id="btn-gen">生成链接</button>
        <button class="btn btn-warning " id="btn-gen-play">
            <span class="glyphicon glyphicon-repeat"></span>生成并播放
        </button>
        <button class="btn btn-info" id="btn-gen-stop"><span class="glyphicon glyphicon-pause"></span>暂停播放</button>
        <button class="btn btn-info" id="btn-gen-start"><span class="glyphicon glyphicon-play"></span>继续播放</button>

        <span>
            <?= Spinner::widget([
                'id'      => 'icon-loading', 'preset' => 'tiny',
                'align'   => 'right',
                'caption' => 'Loading &hellip;',
                'hidden'  => true,
            ]); ?>
        </span>
        <a id="btn-download" target="_blank" href="#" style="display:none;">下载链接</a>
    </div>
</div>

<?php JsBlock::begin(['pos' => $this::POS_READY]) ?>
<script type="text/javascript">
    $('#btn-gen').on('click', function () {
        genAudio(false);
    });

    $('#btn-gen-play').on('click', function () {
        genAudio(true);
    });

    $('#btn-gen-stop').on('click', function () {
        stop();
    });

    $('#btn-gen-start').on('click', function () {
        start();
    });

    $('#btn-download').on('click', function () {
        $(this).attr('href', window.iaudio.src);
    });

    function genAudio(playNow) {
        var downloadBtn = $('#btn-download');
        var loadingBtn = $('#icon-loading');
        downloadBtn.attr('href', '#');
        downloadBtn.hide();
        loadingBtn.show();

        var content = $('#content').val();
        var gat = $("input[name='gat']:checked").val();
        var vcn = $("input[name='vcn']:checked").val();
        var spd = $("input[name='spd']").val();
        var vol = $("input[name='vol']").val();
        var bgs = $("input[name='bgs']:checked").val();

        ﻿if (content === '') {
            krajeeDialog.alert('请输入文字');
            return false;
        }
    ﻿
        play(content, gat, vcn, spd, vol, bgs, playNow);
    }

    var audioPalyUrl = "http://h5.xf-yun.com/audioStream/";

    var ttsSession = new IFlyTtsSession({
        'url': 'ws://h5.xf-yun.com/tts.do',
        'reconnection': true,
        'reconnectionDelay': 30000
    });
    /* 音频播放对象 */
    window.iaudio = null;
    /* 音频播放状态 0:未播放且等待音频数据状态，1:正播放且等待音频数据状态，2：未播放且不等待音频数据*/
    var audio_state = 0;

    function play(content, gat, vcn, spd, vol, bgs, playNow) {
        reset();

        var params = 'gat=wav,ent=aisound,aue=lame';

        if (gat) {
            params += ',gat=' + gat;
        }

        if (vcn) {
            params += ',vcn=' + vcn;
        }

        if (spd) {
            params += ',spd=' + spd;
        }

        if (vol) {
            params += ',vol=' + vol;
        }

        if (bgs) {
            params += ',bgs=' + bgs;
        }


        ssb_param = {
            'appid': '58dc7d2b',
            'appkey': '9421628390927a6a',
            'synid': '12345',
            'params': params
        };

        ttsSession.start(ssb_param, content, function (err, obj) {
            var audio_url = audioPalyUrl + obj.audio_url;
            if (audio_url != null && audio_url != undefined) {
                window.iaudio.src = audio_url;
                if (playNow) {
                    window.iaudio.play();
                }
                $('#icon-loading').hide();
                $('#btn-download').show();
            }
        });
    };

    /**
     * 重置音频缓存队列和播放对象
     * 若音频正在播放，则暂停当前播放对象，创建并使用新的播放对象.
     */
    function reset() {
        audio_array = [];
        audio_state = 0;
        if (window.iaudio != null) {
            window.iaudio.pause();
        }
        window.iaudio = new Audio();
        window.iaudio.src = '';
    };

    /**
     * 停止播放音频
     */
    function stop() {
        audio_state = 2;
        window.iaudio.pause();
    }

    function start() {
        audio_state = 1;
        window.iaudio.play();
    }
</script>
<?php JsBlock::end() ?>

