/**
 * @charset = UTF-8
 * jquery.dc.js: v1.0.0
 * 也不知道谁规定的，文件声明必须写
 * 也不知道谁规定的，声明文件必须用英文写
 * 也不知道谁规定的，用英文感觉很高大上
 * 也不知道谁规定的，注释也必须用英文写
 */
;(function($){
	"use strict";
	
	// 手动ajax加载，使用常规参数
	$.fn.ajax_load = function() {
		var $this	= this;
		var $item	= $(this);
		var target	= $item.data("target") || $this;
		var url		= $item.data("url");
		var data	= $item.data();
		var reg		= new RegExp(/^#[\S]*$/ig);
		var type	= 'GET';
		var dtype	= 'HTML';
		var async	= false;
		
		// submit按钮则将获取所属表单内容并提交
		if ($item.is("*[type='submit']") && $item.parents("form:first").length > 0) {
			form	= $item.parents("form:first");
			type	= form.attr("method") ? form.attr("method") : "POST";
			url		= form.attr("action") ? form.attr("action") : url;
			// 将submit按钮的值也回传至服务器端
			data[$item.attr('name')] = $item.attr('value');
			form.find("input[type!='submit'],select,textarea").each(function(i, self){
				var $this = $(self);
				data[$this.attr("name")] = $this.val();
			});
		}
		
		// form表单则获取当前表单内容并提交
		if ($item.is("form")) {
			type	= $item.attr("method") ? $item.attr("method") : "POST";
			url		= $item.attr("action") ? $item.attr("action") : url;
			$item.find("input,select,textarea").each(function(i,self){
				var $this = $(self);
				data[$this.attr("name")] = $this.val();
			});
		}
		// 锚链接不处理
		if (reg.test(url)) { return; }
		// 空目标不处理
		if (!target || target === null || target === "") { return; }
		
		$(target).animate({opacity : 0}, 600, function() {
			$.ajax({
				async		: async,
				url			: url,
				type		: type,
				dataType	: dtype,
				data		: data,
				cache		: false,
				success		: function(response_data) {
					if (dtype.toUpperCase() == "HTML") {
						$(target).html(response_data);
					}
					$(target).animate({opacity : 1}, 600);
					// 嵌套绑定
					$(target).ajax_bind();
				},
				error		: function(ex) {
				}
			});
		});
	}
	// 自动ajax加载，在加载完成时
	$.fn.ajax_bind = function() {
		$(this).find('.load-auto').each($.fn.ajax_load);
		$(this).find('.load-click').click($.fn.ajax_load);
		$(this).find('.load_submit').submit($.fn.ajax_load);
	}
	// OK
	$('body').ajax_bind();
})(jQuery);