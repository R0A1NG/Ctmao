<?php
/**
 * 网站美化合集
 * 
 * @package Ctmao
 * @author R0A1NG
 * @version 1.0.0
 * @link https://www.roaing.com
 */
class Ctmao_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('Ctmao_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Ctmao_Plugin', 'footer');
        Typecho_Plugin::factory('Widget_Feedback')->finishComment = array('Ctmao_Plugin', 'send');
        Typecho_Plugin::factory('Widget_Comments_Edit')->finishComment = array('Ctmao_Plugin', 'send');
        Typecho_Plugin::factory('Widget_Contents_Post_Edit')->finishPublish = array('Ctmao_Plugin', 'submit');
        Typecho_Plugin::factory('Widget_Contents_Page_Edit')->finishPublish = array('Ctmao_Plugin', 'submit');
        return _t('插件已启用');
    }
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
        return _t('插件已禁用');
    }
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form) 
    {
        $element = new Typecho_Widget_Helper_Form_Element_Radio('bwsc', array('1'=> '是', '0'=> '否'), 0, _t('是否开启黑白色彩'), _t('配置黑白色彩，默认为否'));
        $form->addInput($element);
        $element = new Typecho_Widget_Helper_Form_Element_Textarea('jnrdate', NULL,
		'04-04
12-13', _t('纪念日日期（当天自动开启黑白色彩）'), _t('填入形如12-13日期，一行一个'));
	    $form->addInput($element);
		$element = new Typecho_Widget_Helper_Form_Element_Radio('qqpush', array('1'=> '开启', '0'=> '关闭'), 0, _t('<hr>是否开启qq评论推送（go-cqhttp）'));
		$form->addInput($element);
		$element = new Typecho_Widget_Helper_Form_Element_Text('qqpush_url', null, '', _t('地址'), _t('使用go-cqhttp<a href="https://docs.go-cqhttp.org/">文档</a>，（只推送非管理员评论），此项填写api地址，例：127.0.0.1:5001，不带http://或https://'));
        $form->addInput($element);
        $element = new Typecho_Widget_Helper_Form_Element_Text('qqpush_qq', null, '', _t('QQ号'), _t('填写接收消息的QQ号，例：123456'));
        $form->addInput($element);
        // $element = new Typecho_Widget_Helper_Form_Element_Text('qqpush_key', null, '', _t('密钥'), _t('填写go-cqhttpApi的密钥，若未配置则不用填写'));
        // $form->addInput($element);
        $element = new Typecho_Widget_Helper_Form_Element_Radio('baidusub', array('1'=> '开启', '0'=> '关闭'), 0, _t('<hr>是否开启百度提交（发布文章自动推送）'));
		$form->addInput($element);
        $element = new Typecho_Widget_Helper_Form_Element_Text('baidusub_dom', null, '', _t('域名'), _t('例：https://www.roaing.com，不带/'));
        $form->addInput($element);
		$element = new Typecho_Widget_Helper_Form_Element_Text('baidusub_token', null, '', _t('Token'), _t('填写接口Token'));
        $form->addInput($element);
		$element = new Typecho_Widget_Helper_Form_Element_Text('baidustatistics', null, '', _t('<hr>百度统计'), _t('只填写?后的内容，例如：https://hm.baidu.com/hm.js?xxxxxxxxx，只填写xxxxxxxxx，不填写不开启'));
        $form->addInput($element);
		
		
		$ctSend = new Typecho_Widget_Helper_Form_Element_Radio('youjian', array('1'=> '开启', '0'=> '关闭'), 0, _t('<hr>禁止右键和开启右键美化'));
		$form->addInput($ctSend);
		$element = new Typecho_Widget_Helper_Form_Element_Text('youjian_dom', null, '', _t('首页地址'), _t('例：https://www.roaing.com/'));
        $form->addInput($element);
        $element = new Typecho_Widget_Helper_Form_Element_Text('youjian_link', null, '', _t('友链地址'), _t('例：https://www.roaing.com/links.html'));
        $form->addInput($element);
		$element = new Typecho_Widget_Helper_Form_Element_Text('youjian_leav', null, '', _t('留言地址'), _t('例：https://www.roaing.com/lam.html'));
        $form->addInput($element);

		$beautico = [
			'ruzhanhuanying'    => '入站欢迎',
			'shubiaotexiao'     => '鼠标特效',
			'lefttopfps'        => '左上角FPS',
			'stopctrlssave'     => '禁止Ctrl+s保存',
			'copymsg'           => '复制提醒',
			'stopdebug'         => '禁用Debug调试',
			'pichuxideng'       => '图片呼吸灯',
			'chunjiedenglong'   => '春节灯笼',
			'Colortagcloud'     => '彩色标签云',
			'bengkuiqipian'     => '崩溃欺骗',
			'stopctrlu'         => '禁用ctrl+u',
	    ];
	    $beautico1 = [
			'ruzhanhuanying',
			'shubiaotexiao',
			'lefttopfps',
			'stopctrlssave',
			'copymsg',
			'stopdebug',
			'stopctrlu',
			'bengkuiqipian',
			'Colortagcloud'
		];
        $BeautificationCollection = new Typecho_Widget_Helper_Form_Element_Checkbox(
            'link_config',
            $beautico,
            $beautico1,
            '<hr>美化合集',
            '美化合集配置'
        );
        $form->addInput($BeautificationCollection);
    }
    
    public static function send($comment)
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('Ctmao');
        $qqpush = $options->qqpush ? true : false;
        $qqpush_url = $options->qqpush_url;
        $qqpush_qq = $options->qqpush_qq;
        // $qqpush_key = $options->qqpush_key;
        if($qqpush == true && $comment->authorId != $comment->ownerId && ($comment->status == "waiting")){
            $title = $comment->title;
            $author = $comment->author;
            $mail = $comment->mail;
            $ip = $comment->ip;
            $text = preg_replace('/\{!\{([^\"]*)\}!\}/', '# 图片回复', $comment->text);
            $time = date('Y年m月d日 H:i:s', $comment->created);
            $link = substr($comment->permalink, 0, strrpos($comment->permalink, "#"));
            $txt = "您收到一条新的评论！\n\n文章：{$title}\n昵称：{$author}\n用户邮箱：{$mail}\n用户IP：{$ip}\n内容：{$text}\n链接：{$link}\n\n{$time}";
            $url = 'http://'.$qqpush_url.'/send_msg';
            $post_data = array(
              'user_id' => $qqpush_qq,
              'message' => $txt
            );
            $postdata = http_build_query($post_data);
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type:application/x-www-form-urlencoded',
                    'content' => $postdata,
                    'timeout' => 1 * 60
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
        }
        
    }
    
    public static function submit($contents, $edit)
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('Ctmao');
        $baidusub = $options->baidusub ? true : false;
        $baidusub_dom = $options->baidusub_dom;
        $baidusub_token = $options->baidusub_token;
        if ($baidusub == true && $contents['visibility'] === 'publish') {
            $link = $edit->permalink;
            $urls = array(
                $link
            );
            $api = 'http://data.zz.baidu.com/urls?site='.$baidusub_dom.'&token='.$baidusub_token;
            $ch = curl_init();
            $options =  array(
                CURLOPT_URL => $api,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => implode("\n", $urls),
                CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
            );
            curl_setopt_array($ch, $options);
            $result = curl_exec($ch);
        }
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    /**
     * 输出头部css
     * 
     * @access public
     * @return void
     */
    public static function header(){
        $options = Typecho_Widget::widget('Widget_Options')->plugin('Ctmao');
        $path = Helper::options()->pluginUrl . '/Ctmao/static/';
        $link_config = $options->link_config;
        $bwsc = $options->bwsc ? true : false;
        if($bwsc == true){
            echo <<<EOF
    <style>
    html {
        filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); 
        filter: grayscale(100%);
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        -ms-filter: grayscale(100%);
        -o-filter: grayscale(100%);
        filter: gray;
        -webkit-filter: grayscale(1);
    }
    </style>
EOF;
        }
        else{
            $jnrdate = $options->jnrdate;
            if (strstr($jnrdate, date('m-d', time()))){
                echo <<<EOF
    <style>
        html {
            filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); 
            filter: grayscale(100%);
            -webkit-filter: grayscale(100%);
            -moz-filter: grayscale(100%);
            -ms-filter: grayscale(100%);
            -o-filter: grayscale(100%);
            filter: gray;
            -webkit-filter: grayscale(1);
        }
    </style>
EOF;
            }
        }
        if(in_array('pichuxideng',$link_config)){
			echo <<<EOF
		<style>
			    img{-webkit-animation:ani 2s linear infinite;}@keyframes ani{0%{box-shadow:0 0 0px #00BCD4;}25%{box-shadow:0 0 10px #00BCD4;}50%{box-shadow:0 0 20px #00BCD4;}75%{box-shadow:0 0 10px #00BCD4;}100%{box-shadow:0 0 0px #00BCD4;}}
		</style>
EOF;
		}
        if(in_array('stopdebug',$link_config)){
		    echo '<script type="text/javascript" src="' . $path . 'jydebug.js"></script>';
		}
		if(in_array('chunjiedenglong',$link_config)){
			echo <<<EOF
<div id="cjdlfbqa"></div>
<script>
    $(function() {
		(function(){
			if (window.innerWidth >= 768){
				document.getElementById("cjdlfbqa").innerHTML = '<!--灯笼开始--><style>.deng-box{position:fixed;top:28px;right:0px;z-index:999;pointer-events:none}.deng-box1{position:fixed;top:28px;right:40px;z-index:999;pointer-events:none}.deng-box2{position:fixed;top:28px;left:40px;z-index:999;pointer-events:none}.deng-box3{position:fixed;top:28px;left:0px;z-index:999;pointer-events:none}.deng-box3 .deng{position:relative;width:120px;height:90px;margin:50px;background:#d8000f;background:rgba(216,0,15,0.8);border-radius:50%50%;-webkit-transform-origin:50%-100px;-webkit-animation:swing 5s infinite ease-in-out;box-shadow:-5px 5px 30px 4px rgba(252,144,61,1)}.deng-box1 .deng{position:relative;width:120px;height:90px;margin:50px;background:#d8000f;background:rgba(216,0,15,0.8);border-radius:50%50%;-webkit-transform-origin:50%-100px;-webkit-animation:swing 5s infinite ease-in-out;box-shadow:-5px 5px 30px 4px rgba(252,144,61,1)}.deng{position:relative;width:120px;height:90px;margin:50px;background:#d8000f;background:rgba(216,0,15,0.8);border-radius:50%50%;-webkit-transform-origin:50%-100px;-webkit-animation:swing 3s infinite ease-in-out;box-shadow:-5px 5px 50px 4px rgba(250,108,0,1)}.deng-a{width:100px;height:90px;background:#d8000f;background:rgba(216,0,15,0.1);margin:12px 8px 8px 8px;border-radius:50%50%;border:2px solid#dc8f03}.deng-b{width:45px;height:90px;background:#d8000f;background:rgba(216,0,15,0.1);margin:-4px 8px 8px 26px;border-radius:50%50%;border:2px solid#dc8f03}.xian{position:absolute;top:-27px;left:60px;width:2px;height:20px;background:#dc8f03}.shui-a{position:relative;width:5px;height:20px;margin:-5px 0 0 59px;-webkit-animation:swing 4s infinite ease-in-out;-webkit-transform-origin:50%-45px;background:#ffa500;border-radius:0 0 5px 5px}.shui-b{position:absolute;top:25px;left:-2px;width:10px;height:10px;background:#dc8f03;border-radius:50%}.shui-c{position:absolute;top:18px;left:-2px;width:10px;height:35px;background:#ffa500;border-radius:0 0 0 5px}.deng:before{position:absolute;top:-7px;left:29px;height:12px;width:60px;content:" ";display:block;z-index:999;border-radius:5px 5px 0 0;border:solid 1px#dc8f03;background:#ffa500;background:linear-gradient(to right,#dc8f03,#ffa500,#dc8f03,#ffa500,#dc8f03)}.deng:after{position:absolute;bottom:-7px;left:10px;height:12px;width:60px;content:" ";display:block;margin-left:20px;border-radius:0 0 5px 5px;border:solid 1px#dc8f03;background:#ffa500;background:linear-gradient(to right,#dc8f03,#ffa500,#dc8f03,#ffa500,#dc8f03)}.deng-t{font-family:华文行楷,Arial,Lucida Grande,Tahoma,sans-serif;font-size:3.2rem;color:#dc8f03;font-weight:bold;line-height:85px;text-align:center}.night.deng-t,.night.deng-box,.night.deng-box1{background:transparent!important}@-moz-keyframes swing{0%{-moz-transform:rotate(-10deg)}50%{-moz-transform:rotate(10deg)}100%{-moz-transform:rotate(-10deg)}}@-webkit-keyframes swing{0%{-webkit-transform:rotate(-10deg)}50%{-webkit-transform:rotate(10deg)}100%{-webkit-transform:rotate(-10deg)}}</style><!--灯笼1--><div class="deng-box"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t">春</div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><!--灯笼2--><div class="deng-box1"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t">新</div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><!--灯笼3--><div class="deng-box2"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t">度</div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><!--灯笼4--><div class="deng-box3"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t">欢</div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><!--灯笼结束-->';
			}
      })();
    });
</script>
EOF;
        }
        if(in_array('copymsg',$link_config)){
		    echo '<script type="text/javascript" src="' . $path . 'fztxa.js"></script>';
		}
		if(in_array('ruzhanhuanying',$link_config)){
		    echo '<script type="text/javascript" src="' . $path . 'fzhyts.js"></script>';
		}
		if(in_array('stopctrlssave',$link_config)){
		    echo '<script type="text/javascript" src="' . $path . 'jzctabc.js"></script>';
		}
		$youjian = $options->youjian ? true : false;
		if($youjian == true){
		    $youjian_dom = $options->youjian_dom;
		    $youjian_link = $options->youjian_link;
		    $youjian_leav = $options->youjian_leav;
		    echo <<<EOF
		    <!-- 自定义右键 -->
		<style>
		    /* 自定义右键 */
            a {text-decoration: none;}
            div.usercm{background-repeat:no-repeat;background-position:center center;background-size:cover;background-color:#fff;font-size:13px!important;width:130px;-moz-box-shadow:1px 1px 3px rgba(0,0,0,.3);box-shadow:0px 0px 15px #333;position:absolute;display:none;z-index:10000;opacity:0.9;border-radius: 5px;}
            div.usercm ul{list-style-type:none;list-style-position:outside;margin:0px;padding:0px;display:block}
            div.usercm ul li{margin:0px;padding:0px;line-height:35px;}
            div.usercm ul li a{color:#666;padding:0 15px;display:block}
            div.usercm ul li a:hover{color:#fff;background:rgba(9,145,113,0.88);border-radius: 5px}
            div.usercm ul li a i{margin-right:10px}
            a.disabled{color:#c8c8c8!important;cursor:not-allowed}
            a.disabled:hover{background-color:rgba(255,11,11,0)!important}
            div.usercm{background:#fff !important;}
        </style>
        <div class="usercm" style="left: 199px; top: 5px; display: none;">
            <ul>
                <li><a href="{$youjian_dom}"><i class="fa fa-home fa-fw"></i><span>首页</span></a></li>
                <li><a href="javascript:void(0);" onclick="getSelect();"><i class="fa fa-file fa-fw"></i><span>复制</span></a></li>
                <li><a href="javascript:void(0);" onclick="baiduSearch();"><i class="fa fa-search fa-fw"></i><span>百度</span></a></li>
                <li><a href="javascript:void(0);" onclick="googleSearch();"><i class="fa fa-google fa-fw"></i><span>谷歌</span></a></li>
                <li><a href="javascript:history.go(1);"><i class="fa fa-arrow-right fa-fw"></i><span>前进</span></a></li>
                <li><a href="javascript:history.go(-1);"><i class="fa fa-arrow-left fa-fw"></i><span>后退</span></a></li>
                <li style="border-bottom:1px solid gray"><a href="javascript:window.location.reload();"><i class="fa fa-refresh fa-fw"></i><span>刷新</span></a></li>
                <li><a href="{$youjian_link}"><i class="fa fa-user fa-fw"></i><span>和我当邻居</span></a></li>  
                <li><a href="{$youjian_leav}"><i class="fa fa-pencil fa-fw"></i><span>给我留言吧</span></a></li>
            </ul>
        </div>
<script src="{$path}youjian.js"></script>
<!-- 禁止右键 -->
EOF;
		}
		if(in_array('lefttopfps',$link_config)){
		    echo '<div id="fps" style="z-index:10000;position:fixed;top:3;left:3;font-weight:bold;"></div>';
    		echo '<script type="text/javascript" src="' .$path . 'xsfpszs.js"></script>';
		}
		if(in_array('shubiaotexiao',$link_config)){
		    echo <<<EOF
		<style>
	        /* 鼠标特效 */
            body { cursor: url({$path}a1.cur), default; }
            a,button,img { cursor: url({$path}a2.cur), pointer !important; }
		</style>
EOF;
		}
		if(in_array('Colortagcloud',$link_config)){
		    echo <<<EOF
	    <script>
            // 彩色标签云
            let tags = document.querySelectorAll("#tag_cloud-2 a");
            let colorArr = ["#428BCA", "#AEDCAE", "#ECA9A7", "#DA99FF", "#FFB380", "#D9B999"];
            tags.forEach(tag => {
                tagsColor = colorArr[Math.floor(Math.random() * colorArr.length)];
                tag.style.backgroundColor = tagsColor;
            });
        </script>
EOF;
		}
		if(in_array('bengkuiqipian',$link_config)){
		    echo <<<EOF
		<script>
            //  崩溃欺骗
            var OriginTitle = document.title;
            var titleTime;
            document.addEventListener('visibilitychange', function () {
             if (document.hidden) {
                 $('[rel="icon"]').attr('href', "/favicon.ico");
                 document.title = '╭(°A°`)╮ 页面崩溃啦 ~';
                 clearTimeout(titleTime);
             }
             else {
                 $('[rel="icon"]').attr('href', "/favicon.ico");
                 document.title = '(ฅ>ω<*ฅ) 噫又好了~' + OriginTitle;
                 titleTime = setTimeout(function () {
                     document.title = OriginTitle;
                 }, 2000);
             }
            });
        </script>
EOF;
        }
        if(in_array('stopctrlu',$link_config)){
            echo <<<EOF
		<script>
            // 禁用ctrl+u
            window.addEventListener('keydown', function (e) {
                if(e.keyCode == 85 && (navigator.platform.match('Mac') ? e.metaKey : e.ctrlKey)){
                    e.preventDefault();
                    $.message({
                        message: "要干啥？",
                        title: "R0A1NG's Blog",
                        type: "warning",
                        autoHide: !1,
                        time: "3000"
                    });
                }
            })
        </script>
EOF;
        }
    }
    
    public static function footer() {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('Ctmao');
        $baidustatistics = $options->baidustatistics;
        if(!empty($baidustatistics)){
            echo <<<EOF
        <script>
            var _hmt = _hmt || [];
            (function() {
              var hm = document.createElement("script");
              hm.src = "https://hm.baidu.com/hm.js?{$baidustatistics}";
              var s = document.getElementsByTagName("script")[0]; 
              s.parentNode.insertBefore(hm, s);
            })();
        </script>
EOF;
        }
        
    }
}
