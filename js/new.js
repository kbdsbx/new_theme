/*
 * Copyright (c) 23/04/2014 zhaoyi
 * Author: MyPassion 
 * This file is made for new telmplates
 * Power by jQuery
*/

jQuery(document).ready(function(){
	jQuery("*[data-hover]").mousemove(function(){
		var $this	= $(this);
		var target	= $this.data('target');
		
		if (jQuery(target).length == 0) return;
		
		jQuery(target).show(200);
	});
	jQuery("*[data-hover]").mouseleave(function(){
		var $this	= $(this);
		var target	= $this.data('target');
		
		if (jQuery(target).length == 0) return;
		
		jQuery(target).hide(200);
	});
	jQuery("input[id='send']").click(function(){
		var $this		= $(this);
		var url			= $this.data('url');
		var target		= $this.data('target');
		var data		= $this.data();
		var type		= 'get';
		var form		= false;
		// 如果提交者类型为submit，那么获取其对应表单的所有数据并提交
		if ($this.is("*[type='submit']")) {
			form = $this.parents('form:first');
			url = form.attr('action') ? form.attr('action') : url;
			type = form.attr('method') ? form.attr('method') : 'get';
			form.find('input,select,textarea').each(function(i, self){
				var my = $(self);
				data[my.attr('name')] = my.val();
			});
		}
		if (url == '' || url == '#' || url =='javascript:void(0)') return;
		if ($(target).length == 0) return;
		jQuery.ajax({
			url: url,
			type: type,
			data: data,
			cache: false,
			success: function(data) {
				if (data.status < 0) {
					jQuery('.comments-new').html('<font color="red">加载错误，请稍后再试</font>');
					return;
				}
				jQuery('.comments-new').html(data);
				jQuery('.comments').each(load_module);
			},
			error: function(data) {
				debugger;
			}
		});
	});
	jQuery('.comments').each(load_module);
	jQuery('.z_top_right').each(load_module);
	function load_module(i, self){
		var $this	= $(self);
		var url		= $this.data('url');
		var target	= $this.data('target') ? $this.data('target') : '.comments-content';
		var data	= $this.data();
		var type	= 'get';
		if (url == '' || url == '#' || url =='javascript:void(0)') return;
		if (jQuery(target).length == 0) return;

		jQuery.ajax({
			url: url,
			type: type,
			data: data,
			cache: false,
			success: function(data) {
				if (data == '')
				{
					return;
				}
				jQuery(target).html(data);
			},
			error: function(data) {
				debugger;
			}
		});
	}
});






