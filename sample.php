<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxf8f2f3917d846a7a", "6f19eb8dd339063917490cbdc80cd0a0");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <title></title>
  <link rel="stylesheet" href="sample.css">
    </head>
<body>
     <!-- <img id="previewImage" src="muwu.jpg" width="100%" alt=""> -->
    <img id="previewImage" src="muwu.jpg">
<textarea id="ids" style="width:100%">未开始</textarea>
<textarea id="serviceIds" style="width:100%">未开始</textarea>
   <ul>
     <li id="scanQRCode1">
       扫一扫
       </li>
     <li id="translateVoice">
       识别音频并返回识别结果
       </li>
     <li id="startRecord">
       开始录音
       </li>
     <li id="stopRecord">
       停止录音
       </li>
     <li id="playVoice">
       播放音频
       </li>
     <li id="pauseVoice">
       暂停播放音频
       </li>
     <li id="stopVoice">
       停止播放音频
       </li>
     <li id="uploadVoice">
       上传语音
       </li>
     <li id="downloadVoice">
       下载语音
       </li>
     <li id="getLocation">
       获取现在的地理定位
       </li>
    </ul>
   
    </body>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>  
var audioAll = new Array();
var serverAll = new Array();
var playIndex=0;
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
   
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onVoiceRecordEnd',
        'playVoice',
        'onVoicePlayEnd',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard',
      'translateVoice'
    ]
  });
wx.ready(function () {
  // // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
  // document.querySelector('#checkJsApi').onclick = function () {
  //   wx.checkJsApi({
  //     jsApiList: [
  //       'getNetworkType',
  //       'previewImage'
  //     ],
  //     success: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  // };

  // 2. 分享接口
  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
  // document.querySelector('#onMenuShareAppMessage').onclick = function () {
  //   wx.onMenuShareAppMessage({
  //     title: '互联网之子',
  //     desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
  //     link: 'http://movie.douban.com/subject/25785114/',
  //     imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
  //     trigger: function (res) {
  //       // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
  //       alert('用户点击发送给朋友');
  //     },
  //     success: function (res) {
  //       alert('已分享');
  //     },
  //     cancel: function (res) {
  //       alert('已取消');
  //     },
  //     fail: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  //   alert('已注册获取“发送给朋友”状态事件');
  // };

  // // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
  // document.querySelector('#onMenuShareTimeline').onclick = function () {
  //   wx.onMenuShareTimeline({
  //     title: '互联网之子',
  //     link: 'http://movie.douban.com/subject/25785114/',
  //     imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
  //     trigger: function (res) {
  //       // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
  //       alert('用户点击分享到朋友圈');
  //     },
  //     success: function (res) {
  //       alert('已分享');
  //     },
  //     cancel: function (res) {
  //       alert('已取消');
  //     },
  //     fail: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  //   alert('已注册获取“分享到朋友圈”状态事件');
  // };

  // // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口
  // document.querySelector('#onMenuShareQQ').onclick = function () {
  //   wx.onMenuShareQQ({
  //     title: '互联网之子',
  //     desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
  //     link: 'http://movie.douban.com/subject/25785114/',
  //     imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
  //     trigger: function (res) {
  //       alert('用户点击分享到QQ');
  //     },
  //     complete: function (res) {
  //       alert(JSON.stringify(res));
  //     },
  //     success: function (res) {
  //       alert('已分享');
  //     },
  //     cancel: function (res) {
  //       alert('已取消');
  //     },
  //     fail: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  //   alert('已注册获取“分享到 QQ”状态事件');
  // };
  
  // // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
  // document.querySelector('#onMenuShareWeibo').onclick = function () {
  //   wx.onMenuShareWeibo({
  //     title: '互联网之子',
  //     desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
  //     link: 'http://movie.douban.com/subject/25785114/',
  //     imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
  //     trigger: function (res) {
  //       alert('用户点击分享到微博');
  //     },
  //     complete: function (res) {
  //       alert(JSON.stringify(res));
  //     },
  //     success: function (res) {
  //       alert('已分享');
  //     },
  //     cancel: function (res) {
  //       alert('已取消');
  //     },
  //     fail: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  //   alert('已注册获取“分享到微博”状态事件');
  // };

  // // 2.5 监听“分享到QZone”按钮点击、自定义分享内容及分享接口
  // document.querySelector('#onMenuShareQZone').onclick = function () {
  //   wx.onMenuShareQZone({
  //     title: '互联网之子',
  //     desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
  //     link: 'http://movie.douban.com/subject/25785114/',
  //     imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
  //     trigger: function (res) {
  //       alert('用户点击分享到QZone');
  //     },
  //     complete: function (res) {
  //       alert(JSON.stringify(res));
  //     },
  //     success: function (res) {
  //       alert('已分享');
  //     },
  //     cancel: function (res) {
  //       alert('已取消');
  //     },
  //     fail: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  //   alert('已注册获取“分享到QZone”状态事件');
  // };


  // 3 智能接口
  var voice = {
    localId: '',
    serverId: ''
  };
  // 3.1 识别音频并返回识别结果
  document.querySelector('#translateVoice').onclick = function () {
    if (voice.localId == '') {
      alert('请先使用 startRecord 接口录制一段声音');
      return;
    }
    wx.translateVoice({
      localId: voice.localId,
      complete: function (res) {
        if (res.hasOwnProperty('translateResult')) {
          alert('识别结果：' + res.translateResult);
        } else {
          alert('无法识别');
        }
      }
    });
  };

  // 4 音频接口
  // 4.2 开始录音
  document.querySelector('#startRecord').onclick = function () {
    wx.startRecord({
      cancel: function () {
        alert('用户拒绝授权录音');
      }
    });
    document.getElementById('ids').innerHTML=audioAll.toString();
    //alert(audioAll.toString());
  };

  // 4.3 停止录音
  document.querySelector('#stopRecord').onclick = function () {
    wx.stopRecord({
      success: function (res) {
        voice.localId = res.localId;
        audioAll.push(voice.localId);
        document.getElementById('ids').innerHTML=audioAll.toString();
        //alert(audioAll.toString());
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
  };

  // 4.4 监听录音自动停止
  wx.onVoiceRecordEnd({
    complete: function (res) {
      voice.localId = res.localId;
	  audioAll.push(voice.localId);
      document.getElementById('ids').innerHTML=audioAll.toString();
	  //alert(audioAll.toString());
      //alert('录音时间已超过一分钟');
	   wx.startRecord({
		  cancel: function () {
			alert('用户拒绝授权录音');
          }
           
    });   	   
    }
  });

  // 4.5 播放音频
  document.querySelector('#playVoice').onclick = function () {
    if (voice.localId == '') {
      alert('请先使用 startRecord 接口录制一段声音');
      return;
    }
	playIndex=0;
	voice.localId=audioAll[playIndex++];
    wx.playVoice({
      localId: voice.localId
    });
  };

  // 4.6 暂停播放音频
  document.querySelector('#pauseVoice').onclick = function () {
	  
    wx.pauseVoice({
      localId: voice.localId
    });
  };

  // 4.7 停止播放音频
  document.querySelector('#stopVoice').onclick = function () {
    wx.stopVoice({
      localId: voice.localId
    });
  };

  // 4.8 监听录音播放停止
  wx.onVoicePlayEnd({
    complete: function (res) {
		if(playIndex<audioAll.length){
			voice.localId=audioAll[playIndex++];
			wx.playVoice({
			  localId: voice.localId
			});
		}
      //alert('录音（' + res.localId + '）播放结束');
    }
  });

  // 4.8 上传语音
  document.querySelector('#uploadVoice').onclick = function () {
    if (audioAll.length<=0){//(voice.localId == '') {
      alert('请先使用 startRecord 接口录制一段声音');
      return;
    }
    setTimeout(function(){uploadVoice(0);},500);
    document.getElementById('serviceIds').innerHTML=serverAll.toString();
  };
  function uploadVoice(i){
    //alert(i);
    var localId=audioAll[i++];
    wx.uploadVoice({
      localId: localId,//voice.localId,
      isShowProgressTips: 1,
      success: function (res) {
        //alert(voice.localId);
        alert('上传语音成功，serverId 为' + res.serverId);
        //voice.serverId = res.serverId;
        serverAll.push(res.serverId);
        document.getElementById('serviceIds').innerHTML=serverAll.toString();
        if(i<audioAll.length){
            setTimeout(function(){uploadVoice(i);},500);
        }
      }
    });
  }

  // 4.9 下载语音
  document.querySelector('#downloadVoice').onclick = function () {
    //alert("http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$ACCESS_TOKEN&media_id=$media_id")
    if (voice.serverId == '') {
      alert('请先使用 uploadVoice 上传声音');
      return;
    }
    wx.downloadVoice({
      serverId: voice.serverId,
      success: function (res) {
        alert('下载语音成功，localId 为' + res.localId);
        voice.localId = res.localId;
      }
    });
  };

  // 5 图片接口
  // 5.1 拍照、本地选图
  // var images = {
  //   localId: [],
  //   serverId: []
  // };
  // document.querySelector('#chooseImage').onclick = function () {
  //   wx.chooseImage({
  //     success: function (res) {
  //       images.localId = res.localIds;
  //       alert('已选择 ' + res.localIds.length + ' 张图片');
  //     }
  //   });
  // };

  // 5.2 图片预览
  document.querySelector('#previewImage').onclick = function () {
    wx.previewImage({
      current: 'http://jchongyang.applinzi.com/muwu.jpg',
      urls: [
        'http://jchongyang.applinzi.com/muwu.jpg',
      ]
    });
  };

  // // 5.3 上传图片
  // document.querySelector('#uploadImage').onclick = function () {
  //   if (images.localId.length == 0) {
  //     alert('请先使用 chooseImage 接口选择图片');
  //     return;
  //   }
  //   var i = 0, length = images.localId.length;
  //   images.serverId = [];
  //   function upload() {
  //     wx.uploadImage({
  //       localId: images.localId[i],
  //       success: function (res) {
  //         i++;
  //         //alert('已上传：' + i + '/' + length);
  //         images.serverId.push(res.serverId);
  //         if (i < length) {
  //           upload();
  //         }
  //       },
  //       fail: function (res) {
  //         alert(JSON.stringify(res));
  //       }
  //     });
  //   }
  //   upload();
  // };

  // // 5.4 下载图片
  // document.querySelector('#downloadImage').onclick = function () {
  //   if (images.serverId.length === 0) {
  //     alert('请先使用 uploadImage 上传图片');
  //     return;
  //   }
  //   var i = 0, length = images.serverId.length;
  //   images.localId = [];
  //   function download() {
  //     wx.downloadImage({
  //       serverId: images.serverId[i],
  //       success: function (res) {
  //         i++;
  //         alert('已下载：' + i + '/' + length);
  //         images.localId.push(res.localId);
  //         if (i < length) {
  //           download();
  //         }
  //       }
  //     });
  //   }
  //   download();
  // };

  // // 6 设备信息接口
  // // 6.1 获取当前网络状态
  // document.querySelector('#getNetworkType').onclick = function () {
  //   wx.getNetworkType({
  //     success: function (res) {
  //       alert(res.networkType);
  //     },
  //     fail: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  // };

  // 7 地理位置接口
  // 7.1 查看地理位置
  // document.querySelector('#openLocation').onclick = function () {
  //   wx.openLocation({
  //     latitude: 23.099994,
  //     longitude: 113.324520,
  //     name: 'TIT 创意园',
  //     address: '广州市海珠区新港中路 397 号',
  //     scale: 14,
  //     infoUrl: 'http://weixin.qq.com'
  //   });
  // };

  // 7.2 获取当前地理位置
  document.querySelector('#getLocation').onclick = function () {
    wx.getLocation({
      success: function (res) {
        alert(JSON.stringify(res));
      },
      cancel: function (res) {
        alert('用户拒绝授权获取地理位置');
      }
    });
  };

  // 8 界面操作接口
  // 8.1 隐藏右上角菜单
  // document.querySelector('#hideOptionMenu').onclick = function () {
  //   wx.hideOptionMenu();
  // };

  // // 8.2 显示右上角菜单
  // document.querySelector('#showOptionMenu').onclick = function () {
  //   wx.showOptionMenu();
  // };

  // // 8.3 批量隐藏菜单项
  // document.querySelector('#hideMenuItems').onclick = function () {
  //   wx.hideMenuItems({
  //     menuList: [
  //       'menuItem:readMode', // 阅读模式
  //       'menuItem:share:timeline', // 分享到朋友圈
  //       'menuItem:copyUrl' // 复制链接
  //     ],
  //     success: function (res) {
  //       alert('已隐藏“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
  //     },
  //     fail: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  // };

  // // 8.4 批量显示菜单项
  // document.querySelector('#showMenuItems').onclick = function () {
  //   wx.showMenuItems({
  //     menuList: [
  //       'menuItem:readMode', // 阅读模式
  //       'menuItem:share:timeline', // 分享到朋友圈
  //       'menuItem:copyUrl' // 复制链接
  //     ],
  //     success: function (res) {
  //       alert('已显示“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
  //     },
  //     fail: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   });
  // };

  // // 8.5 隐藏所有非基本菜单项
  // document.querySelector('#hideAllNonBaseMenuItem').onclick = function () {
  //   wx.hideAllNonBaseMenuItem({
  //     success: function () {
  //       alert('已隐藏所有非基本菜单项');
  //     }
  //   });
  // };

  // // 8.6 显示所有被隐藏的非基本菜单项
  // document.querySelector('#showAllNonBaseMenuItem').onclick = function () {
  //   wx.showAllNonBaseMenuItem({
  //     success: function () {
  //       alert('已显示所有非基本菜单项');
  //     }
  //   });
  // };

  // // 8.7 关闭当前窗口
  // document.querySelector('#closeWindow').onclick = function () {
  //   wx.closeWindow();
  // };

  // // 9 微信原生接口
  // // 9.1.1 扫描二维码并返回结果
  // document.querySelector('#scanQRCode0').onclick = function () {
  //   wx.scanQRCode();
  // };
  // 9.1.2 扫描二维码并返回结果
  document.querySelector('#scanQRCode1').onclick = function () {
    wx.scanQRCode({
      needResult: 1,
      desc: 'scanQRCode desc',
      success: function (res) {
        alert(JSON.stringify(res));
      }
    });
  };

  // 10 微信支付接口
  // 10.1 发起一个支付请求
  // document.querySelector('#chooseWXPay').onclick = function () {
  //   // 注意：此 Demo 使用 2.7 版本支付接口实现，建议使用此接口时参考微信支付相关最新文档。
  //   wx.chooseWXPay({
  //     timestamp: 1414723227,
  //     nonceStr: 'noncestr',
  //     package: 'addition=action_id%3dgaby1234%26limit_pay%3d&bank_type=WX&body=innertest&fee_type=1&input_charset=GBK&notify_url=http%3A%2F%2F120.204.206.246%2Fcgi-bin%2Fmmsupport-bin%2Fnotifypay&out_trade_no=1414723227818375338&partner=1900000109&spbill_create_ip=127.0.0.1&total_fee=1&sign=432B647FE95C7BF73BCD177CEECBEF8D',
  //     signType: 'SHA1', // 注意：新版支付接口使用 MD5 加密
  //     paySign: 'bd5b1933cda6e9548862944836a9b52e8c9a2b69'
  //   });
  // };

  // // 11.3  跳转微信商品页
  // document.querySelector('#openProductSpecificView').onclick = function () {
  //   wx.openProductSpecificView({
  //     productId: 'pDF3iY_m2M7EQ5EKKKWd95kAxfNw',
  //     extInfo: '123'
  //   });
  // };

  // // 12 微信卡券接口
  // // 12.1 添加卡券
  // document.querySelector('#addCard').onclick = function () {
  //   wx.addCard({
  //     cardList: [
  //       {
  //         cardId: 'pDF3iY9tv9zCGCj4jTXFOo1DxHdo',
  //         cardExt: '{"code": "", "openid": "", "timestamp": "1418301401", "signature":"f6628bf94d8e56d56bfa6598e798d5bad54892e5"}'
  //       },
  //       {
  //         cardId: 'pDF3iY9tv9zCGCj4jTXFOo1DxHdo',
  //         cardExt: '{"code": "", "openid": "", "timestamp": "1418301401", "signature":"f6628bf94d8e56d56bfa6598e798d5bad54892e5"}'
  //       }
  //     ],
  //     success: function (res) {
  //       alert('已添加卡券：' + JSON.stringify(res.cardList));
  //     },
  //     cancel: function (res) {
  //       alert(JSON.stringify(res))
  //     }
  //   });
  // };

  // var codes = [];
  // // 12.2 选择卡券
  // document.querySelector('#chooseCard').onclick = function () {
  //   wx.chooseCard({
  //     cardSign: '1fdb2640c60e41f8823e9f762e70c531d161ae76',
  //     timestamp: 1437997723,
  //     nonceStr: 'k0hGdSXKZEj3Min5',
  //     success: function (res) {
  //       res.cardList = JSON.parse(res.cardList);
  //       encrypt_code = res.cardList[0]['encrypt_code'];
  //       alert('已选择卡券：' + JSON.stringify(res.cardList));
  //       decryptCode(encrypt_code, function (code) {
  //         codes.push(code);
  //       });
  //     },
  //     cancel: function (res) {
  //       alert(JSON.stringify(res))
  //     }
  //   });
  // };

  // // 12.3 查看卡券
  // document.querySelector('#openCard').onclick = function () {
  //   if (codes.length < 1) {
  //     alert('请先使用 chooseCard 接口选择卡券。');
  //     return false;
  //   }
  //   var cardList = [];
  //   for (var i = 0; i < codes.length; i++) {
  //     cardList.push({
  //       cardId: 'pDF3iY9tv9zCGCj4jTXFOo1DxHdo',
  //       code: codes[i]
  //     });
  //   }
  //   wx.openCard({
  //     cardList: cardList,
  //     cancel: function (res) {
  //       alert(JSON.stringify(res))
  //     }
  //   });
  // };

  // var shareData = {
  //   title: '微信JS-SDK Demo',
  //   desc: '微信JS-SDK,帮助第三方为用户提供更优质的移动web服务',
  //   link: 'http://demo.open.weixin.qq.com/jssdk/',
  //   imgUrl: 'http://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRt8Qia4lv7k3M9J1SKqKCImxJCt7j9rHYicKDI45jRPBxdzdyREWnk0ia0N5TMnMfth7SdxtzMvVgXg/0'
  // };
  // wx.onMenuShareAppMessage(shareData);
  // wx.onMenuShareTimeline(shareData);

  // function decryptCode(code, callback) {
  //   $.getJSON('/jssdk/decrypt_code.php?code=' + encodeURI(code), function (res) {
  //     if (res.errcode == 0) {
  //       codes.push(res.code);
  //     }
  //   });
  // }
});

wx.error(function (res) {
  alert(res.errMsg);
});


    </script>
</html>
