/*!
 * bsCustomFileInput v1.3.4 (https://github.com/Johann-S/bs-custom-file-input)
 * Copyright 2018 - 2020 Johann-S <johann.servoire@gmail.com>
 * Licensed under MIT (https://github.com/Johann-S/bs-custom-file-input/blob/master/LICENSE)
 */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self).bsCustomFileInput=t()}(this,function(){"use strict";var s={CUSTOMFILE:'.custom-file input[type="file"]',CUSTOMFILELABEL:".custom-file-label",FORM:"form",INPUT:"input"},l=function(e){if(0<e.childNodes.length)for(var t=[].slice.call(e.childNodes),n=0;n<t.length;n++){var l=t[n];if(3!==l.nodeType)return l}return e},u=function(e){var t=e.bsCustomFileInput.defaultText,n=e.parentNode.querySelector(s.CUSTOMFILELABEL);n&&(l(n).textContent=t)},n=!!window.File,r=function(e){if(e.hasAttribute("multiple")&&n)return[].slice.call(e.files).map(function(e){return e.name}).join(", ");if(-1===e.value.indexOf("fakepath"))return e.value;var t=e.value.split("\\");return t[t.length-1]};function d(){var e=this.parentNode.querySelector(s.CUSTOMFILELABEL);if(e){var t=l(e),n=r(this);n.length?t.textContent=n:u(this)}}function v(){for(var e=[].slice.call(this.querySelectorAll(s.INPUT)).filter(function(e){return!!e.bsCustomFileInput}),t=0,n=e.length;t<n;t++)u(e[t])}var p="bsCustomFileInput",m="reset",h="change";return{init:function(e,t){void 0===e&&(e=s.CUSTOMFILE),void 0===t&&(t=s.FORM);for(var n,l,r=[].slice.call(document.querySelectorAll(e)),i=[].slice.call(document.querySelectorAll(t)),o=0,u=r.length;o<u;o++){var c=r[o];Object.defineProperty(c,p,{value:{defaultText:(n=void 0,n="",(l=c.parentNode.querySelector(s.CUSTOMFILELABEL))&&(n=l.textContent),n)},writable:!0}),d.call(c),c.addEventListener(h,d)}for(var f=0,a=i.length;f<a;f++)i[f].addEventListener(m,v),Object.defineProperty(i[f],p,{value:!0,writable:!0})},destroy:function(){for(var e=[].slice.call(document.querySelectorAll(s.FORM)).filter(function(e){return!!e.bsCustomFileInput}),t=[].slice.call(document.querySelectorAll(s.INPUT)).filter(function(e){return!!e.bsCustomFileInput}),n=0,l=t.length;n<l;n++){var r=t[n];u(r),r[p]=void 0,r.removeEventListener(h,d)}for(var i=0,o=e.length;i<o;i++)e[i].removeEventListener(m,v),e[i][p]=void 0}}});
var App = function () {
	return {
		ajax:function(settings){
			var settings = settings || {};
			let option = $.extend({}, {
				dataType:'json',
				type:'get',
				data:{},
				success: function(data){}
			}, settings);
			let csrfToken = {'_csrf-token':$('meta[name="csrf-token"]').attr("content")};
			if (option.type == 'post') {
				option.data = $.extend({}, option.data, csrfToken);
			}
			$.ajax({
			    url: option.url,
			    dataType: option.dataType,
			    type: option.type,
			    data: option.data,
			    beforeSend: function () {
			        layer.load(2);
			    },
			    success: function (data) {
			        layer.closeAll('loading');
					option.success(data);
			    },
			    error: function (jqXHR, textStatus, errorThrown) {
			        if( jqXHR.hasOwnProperty("responseJSON") ){
			            layer.alert(jqXHR.responseJSON.message, {icon: 2})
			        }else{
			            layer.alert(jqXHR.responseText, {icon: 2})
			        }
			    },
			    complete: function () {
			        layer.closeAll('loading');
			    }
			});
		}
	};
}();
$(function() {
	$(window).on('load', function () {
		$('#preloader').delay(0).fadeOut();
	});
	var $offset = 0;
	$('#homeheader').on('click', '.nav-link', function(event) {
		var _href = $(this).attr('href');
		var pos = _href.indexOf('#');
		var $position = $(_href.substr(pos)).offset().top;
		$('html, body').stop().animate({
			scrollTop: $position - $offset
		}, 600);
		event.preventDefault();
	});
	$(window).scroll(function() {
		if ($(window).scrollTop() > 60) {
			$('.header').addClass('header-fixed');
		} else {
			$('.header').removeClass('header-fixed');
		}
	});
	$(window).scroll(function() {
		$('.navbar-collapse.show').collapse('hide');
	});
	var m = $(".bg-img, .footer, section, div");
	m.each(function(t) {
		if ($(this).attr("data-background")) {
			$(this).css("background-image", "url(" + $(this).data("background") + ")")
		}
	});
	$(".home-banner").owlCarousel({
		loop: true,
		margin: 0,
		nav: false,
		dots: true,
		animateOut: "fadeOut",
		animateIn: "fadeIn",
		active: true,
		autoplay: true,
		smartSpeed: 1000,
		autoplayTimeout: 5000,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		items: 1,
	});
	$(".client-items").owlCarousel({
		loop: true,
		margin: 30,
		autoplay: true,
		autoplayTimeout: 3000,
		nav: false,
		dots: false,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			425: {
				items: 2
			},
			768: {
				items: 3
			},
			1024: {
				items: 4
			},
			1440: {
				items: 5
			}
		}
	});
	$(".counter").counterUp({
		delay: 10,
		time: 1000
	});
	if ($(".wow").length) {
		var s = new WOW({
			boxClass: "wow",
			animateClass: "animated",
			offset: 0,
			mobile: false,
			live: true
		});
		s.init()
	}
	$("#login-form").validate({
		rules:{
			'LoginForm[username]':{required:true},
			'LoginForm[password]':{required:true,rangelength:[5,20]},
		},
		messages:{
			'LoginForm[username]':{required:'请输入手机号码或邮箱'},
			'LoginForm[password]':{required:'请输入密码',rangelength:'密码应该为6-20位之间'},
		},
		submitHandler:function(form){
			$(form).find(":submit").attr("disabled", true);
			layer.load(2);
			form.submit();
		}
	});
	$("#form-signup").validate({
		/* rules:{
			'SignupForm[mobile]':{required:true,mobile:true,maxlength:11},
			'SignupForm[email]':{required:true,email:true},
			'SignupForm[password]':{required:true,rangelength:[6,20]},
			'SignupForm[verifyCode]':{required:true},
		},
		messages:{
			'SignupForm[mobile]':{required:'请输入手机号码',mobile:'手机号码格式不正确',maxlength:'手机号码长度不能超过11位数',},
			'SignupForm[email]':{required:'请输入邮箱地址',email:'邮箱地址格式不正确',},
			'SignupForm[password]':{required:'请输入密码',rangelength:'密码应该为6-20位之间'},
			'SignupForm[verifyCode]':{required:'请输入图形码',},
		}, */
		submitHandler:function(form){
			$(form).find(":submit").attr("disabled", true);
			layer.load(2);
			$.post($(form).attr("action"),$(form).serialize(),function(data){
				$(form).find(":submit").removeAttr("disabled"); 
				layer.closeAll('loading');
				if(data.status == 200){
					swal({text:data.msg,icon:'success',buttons: false,timer: 2000,}).then((value) => {
						window.location.replace(data.url);
					});
				}else{
					swal({text:data.msg,icon:'error',buttons: false,timer: 2000,});
				}
			},'json');
			
		}
	});
	$("#form-changepwd").validate({
		rules:{
			'ChangePasswordForm[password]':{required:true,rangelength:[6,20]},
			'ChangePasswordForm[password_new]':{required:true,rangelength:[6,20]},
			'ChangePasswordForm[password_repeat]':{required:true,rangelength:[6,20]},
		},
		messages:{
			'ChangePasswordForm[password]':{required:'请输入原密码',rangelength:'密码应该为6-20位之间'},
			'ChangePasswordForm[password_new]':{required:'请输入新密码',rangelength:'密码应该为6-20位之间'},
			'ChangePasswordForm[password_repeat]':{required:'请输入确认密码',rangelength:'密码应该为6-20位之间'},
		},
		submitHandler:function(form){
			$(form).find(":submit").attr("disabled", true);
			layer.load(2);
			$.post($(form).attr('action'),$(form).serialize(),function(res){
				$(form).find(":submit").attr("disabled", false);
				layer.closeAll('loading');
				if(res.status == 1){
					swal({text:res.msg,icon:'success',buttons: false,timer: 2000,}).then((value) => {
						location.reload();
					});
				}else{
					swal({text:res.msg,icon:'error',buttons: false,timer: 2000,});
				}
				
			},'json');
		}
	});
	$(document).on('click', '.logout', function(event) {
		var _href = $(this).attr('href');
		App.ajax({
			url: _href,
			type: 'post',
			success: function (data) {
				swal({text:'账号成功退出！',icon:'success',buttons: false,timer: 2000,}).then((value) => {
					location.reload();
				});
			}
		});
		event.preventDefault();
	});
	$(document).on('click', '.message-operation', function(event) {
		event.preventDefault();
		var _href = $(this).attr('href');
		var confirm = $(this).attr("data-confirm");
		var id = $(this).attr("data-id");
		if(confirm){
			swal({
				text: confirm,
				icon: 'warning',
				buttons: {
					cancel: {
						text: '取消',
						value: null,
						visible: true
					},
					confirm: {
						text: '确定',
						value: true,
						visible: true
					}
				}
			}).then((value) => {
				if(value){
					App.ajax({
						url: _href,
						type: 'post',
						data:{id:id},
						success: function (data) {
							location.reload();
						}
					});
				}
			});
			return false;
		}
		App.ajax({
			url: _href,
			type: 'post',
			data:{id:id},
			success: function (data) {
				location.reload();
			}
		});
	});
	$("#citySelect").citySelect({
		nodata:"none",
		required:false
	});
	bsCustomFileInput.init();

});

