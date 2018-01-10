define(function(require) {
	'use strict';
   	var $ = require("../lib/jquery.js");

    require("../amazing-app/lib/swiper.min.css");
    require("../amazing-app/lib/swiper.min.js");
      var mySwiper = new Swiper ('.swiper-container', {
        autoplay : 3000,
        loop: true,
        speed: 2000,
        effect : 'fade',
        simulateTouch : false,
        paginationClickable :true,
        pagination: '.swiper-pagination',
        autoplayDisableOnInteraction : false,
        preloadImages: false,
        lazyLoading : true,
        lazyLoadingInPrevNext : true
    }) 

   	// 多行截取
   	function moreLineOverflow(fatherObj,lineNum,toogelClass) {
   		var toggleClassName =  toogelClass ? toogelClass : 'desc-show';
   		var lineHeight = parseInt(fatherObj.children('p').css('line-height'));
   		for (var i = 0; i < fatherObj.length; i++) {
	   		if (fatherObj.eq(i).find('span').height() > (lineHeight*lineNum)) {
	   			fatherObj.eq(i).addClass(toggleClassName);
	   		}
   		}
   	}
   	moreLineOverflow($('.case-desc-overflow'),2,'desc-show');

    var bbSendLock = true;
    var bbDoms = { // bb: bottomBanner
        'reservationAll': $('#bottom-banner'), // allBottomBanner
        'reservationShow': $('.bottom-banner-top'), // 底部弹层点击区域
        'reservationForm': $('.bottom-banner-form'), // 底部表单
        'reservationName': $('#bb-name'), // 姓名
        'reservationTel': $('#bb-tel'), // 手机
        'formPoint': $('.bb-form-point'), // 表单提示信息
        'reservationSubmit': $('#bb-submit'), // 提交
        'userData': {
            'name': '',
            'phone': '',
            'url': window.location.href,
            'url_referrer': sessionStorage.getItem('land')
        }, // 用户提交数据
        init: function() {
            this.bindMethod(); // 返回顶部
        }
    }
    bbDoms.bindMethod = function() {
         bbDoms.Method.showRes();
         bbDoms.Method.inputStatus();
         bbDoms.Method.submitBtn();
    }

    bbDoms.Method = {
         'showRes': function() {
            setTimeout(function() {
                bbDoms.reservationAll.addClass('bottom-banner-delay');
            }, 1000);
            bbDoms.reservationShow.on('click',function() {
            })
         },
         'inputStatus': function() {
            bbDoms.reservationForm.find('input').on('focus',function() {
                $('.input-box-cell').removeClass('active-focus');
                $(this).parent().addClass('active-focus');
            });
            bbDoms.reservationForm.find('input').on('blur',function() {
                $(this).parent().removeClass('active-focus');
            })
         },
         'submitBtn': function() {
            bbDoms.reservationSubmit.on('click',function() {
                $('.bb-input-box-cell').removeClass('errorInfo');

                bbDoms.userData.name = bbDoms.reservationName.val();
                bbDoms.userData.phone = bbDoms.reservationTel.val();
                if (bbDoms.userData.name == '' || !/^([\u4e00-\u9fa5]{1,20}|[a-zA-Z\.\s]{1,20})$/.test(bbDoms.userData.name)) {
                    bbDoms.reservationName.val('')
                    bbDoms.reservationName.parent().addClass('errorInfo');
                    return;
                }else if (bbDoms.userData.phone == '' || !/^0?1[3|4|5|7|8][0-9]\d{8}$/.test(bbDoms.userData.phone)) {
                    bbDoms.reservationTel.val('');
                    bbDoms.reservationTel.parent().addClass('errorInfo');
                    return;
                }
                bbDoms.Method.fetch(bbDoms.userData);
            })
         },
         'clearData': function() {
            bbDoms.reservationForm.find('input').val('');
         },
         'tips': function(text) {
            bbDoms.formPoint.html(text);
         },
         'fetch': function(parmas) {
            if (!bbSendLock) {
                return
            }
            bbSendLock = false;
            bbDoms.reservationSubmit.html('申请中...');
            $.post('/businesschance',parmas, function(data) {
                setTimeout(function() {
                    if (data.code == 201) {
                        bbDoms.reservationTel.parent().addClass('errorInfo');
                        bbDoms.reservationTel.val('');
                            bbDoms.reservationSubmit.html('免费回电');
                            bbSendLock = true; // 重置sendLock
                    }else if (data.code == 200) {
                        bbDoms.reservationSubmit.css('background-color','#52CC38');
                        bbDoms.reservationSubmit.html('申请成功');
                        setTimeout(function() {
                            bbDoms.Method.clearData();
                            bbDoms.reservationSubmit.html('免费回电');
                            bbDoms.reservationSubmit.css('background-color','#FB515A');
                            bbSendLock = true; // 重置sendLock
                        }, 3000);
                    }
                }, 500)
            })
        }
    }

    bbDoms.init();
})