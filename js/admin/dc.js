/**
 * @charset: UTF-8
 * jquery.dc.js 让数据决定一切
 * version: v1.4.0
 * 
 * copyright © 2014 kbdsbx
 * date: 2014-06-05
 * 
 * url: https://github.com/kbdsbx/dc;
 */
;(function($){
	"use strict";
	
	// 创建或调用dc实例
	$.fn.dc = function( options ) {
		var instance = $.data(this, 'dc');
		if (typeof options === 'string') {
			var args = Array.prototype.slice.call( arguments, 1 );
			this.each(function() {
				if (!instance) {
					logError( "cannot call methods on dc prior to initialization; " +
							"attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for dc instance" );
					return;
				}
				instance[ options ].apply( instance, args );
			});
		} else {
			this.each(function() {
				if ( instance ) {
					instance._init();
				}
				else {
					instance = $.data( this, 'dc', new $.dc( options, this ) );
				}
			});
		}
		
		return instance;
	}
	
	$.dc = function( options, $el ) {
		this.$el = $($el);
		this._init(options);
	}

	// dc全局默认参数
	$.dc.defaults = {
        /******************** ajax ********************/
			
		/***
		 * @default	: false
		 * @value	: object
		 * @info	: 手动调用ajax参数，优先级最高，无法在嵌套调用中使用
		 */
		ajax_load				:	false,
		/***
		 * @default	: false
		 * @value	: function([ele])
		 * @info	: ajax调用前执行的自定义函数，返回true时停止ajax调用
		 */
		ajax_before				:	false,
		/***
		 * @default	: false
		 * @value	: function([data])
		 * @info	: ajax调用成功执行的自定义函数
		 */
		ajax_after				:	false,
		/***
		 * @default	: false
		 * @value	: boolean
		 * @info	: 是否允许服务端返回url时自动跳转
		 */
		ajax_url_skip			:	false,
		/***
		 * @default	: false
		 * @value	: boolean and /reg/
		 * @info	: 服务器返回url时是否验证，允许使用验证正则表达式，为true时使用正则/^((https?|ftp|file):\/\/)?([\w-]+\.)([\w-]+\.?){1,}(:\d+)?(\/[\w?+%\/.=&#\u4e00-\u9fa5]*)?$/ig
		 */
		ajax_url_reg			:	false,
		/***
		 * @default	: true
		 * @value	: boolean
		 * @info	: 是否自动显示消息（使用mqueue插件）
		 */
		ajax_auto_msg			:	true,
		/***
		 * @default	: 	false
		 * @value	: 	boolean
		 * @info	: 	当ajax数据类型为json时是否开启自动填充功能
		 * 				返回数据中若存在[html]，则将[html]填充至$(target)后再进行数据填充
		 * 				填充规则：
		 * 					input,button,textarea,select[data-json='xxx'].val(response_data.xxx) 例如: <input data-json='name' value='[response_data.name]' />
		 * 					*!input,!button,!textarea,!select[data-json='xxx'].html(response_data.xxx) 例如：<div data-json='name'>[response_data.name]</div>
		 * 					*[data-json-target].attr([data-json-target],response_data.xxx) 例如：<img src='[response_data.img]' data-json='img' data-json-target='src' />
		 */
		ajax_json_filling		:	true,
		/***
		 * @default	: 	true
		 * @value	: 	boolean
		 * 					true	: 使用默认动画'fade'
		 * 					false	: 不使用动画，常用语数据调用刷新
		 * 				'fade'		: 淡入淡出
		 * 				'toggle'	: 隐藏显示
		 * 				'slide'		: 滑动
		 * @info	: 刷新区域动画
		 */
		ajax_animate			:	true,
		/***
		 * @default	: 600
		 * @value	: Interget
		 * @info	: 动画时间，仅ajax_aminate不为false时可用，单位毫秒（ms）
		 */
		ajax_animate_speed		:	600,

        /******************** cascade ********************/
        /***
         * @default : true
         * @value   : boolean
         * @info    : 是否隐藏不包含元素的下拉列表框
         */
        cascade_hide_empty      :   true,

        /***
         * @default : false
         * @value   : boolean
         *                true    : 显示默认选项 "--请选择--"
         *                false   : 不显示默认选项
         *            string      : 设置默认选项字符串
         */
        cascade_show_default    :   true,

	}
	
	// 全局参数
	$.dc.options = {}
	
	// dc方法集
	$.dc.prototype = {
        /******************** init ********************/
		_init : function( options ) {
			var $this			= this;
			$this.options = $.extend({}, $.dc.defaults, options);
		},
        bind : function( data ) {
			var $this	= this;
			$this._ajax_bind( data );
			$this._cascade_bind( data );
			return this;
        },
        /******************** ajax ********************/
		_ajax_load : function( options ) {
			var $this		= this;
			var $item		= $(this);

			var form, form_url, form_target, form_dtype, form_type, form_async, form_data = {};
			var url, target, dtype, type, async, data;
			
			var reg				= new RegExp(/^#[\S]*$/ig);
			options				= options			|| {};
			options.ajax_load 	= options.ajax_load || {};

			// 前置操作，允许用户设置ajax调用前执行方法并允许停止ajax执行
			if ($.isFunction(options.ajax_before) && options.ajax_before($item)) {
				return this;
			}

			// submit按钮则将获取所属表单内容并提交
			if ($item.is("*[type='submit'],*[type='image']") && $item.parents("form").length > 0) {
				form			= $item.parents("form:last");
				// 当使用非编码模式（提交文件）时回归默认提交
				if (form.is("form[enctype='multipart/form-data']")) {
					form.off("submit").submit();
					return this;
				}
				
				form_url		= form.data("url")		|| form.attr("action");
				form_target		= form.data("target");
				form_dtype		= form.data("dtype");
				form_type		= form.data("type")		|| form.attr("method");
				form_async		= form.data("async");
				// form_data		= form.data()			|| {};
				$.each(form.data(), function( i, v ) {
					form_data[i] = v;
				});
				// 将form内部需要提交控件的值获取并提交
				form.find(":text,:password,input:hidden,:radio:checked,:checkbox:checked,select,textarea").each(function(i, self){
					var $this = $(self);
					if ($this.is(":checkbox:checked")) {
						form_data[$this.attr("name") + '[' + i + ']'] = $this.val();
					} else {
						form_data[$this.attr("name")] = $this.val();
					}
				});
				// 将submit按钮的值获取并提交
				form_data[$item.attr('name')] = $item.attr('value');
			}
			
			// form表单则获取当前表单内容并提交
			if ($item.is("form")) {

				if ($item.is("form[enctype='multipart/form-data']")) {
					form.off("submit").submit();
					return this;
				}
				
				form_url		= $item.data("url")		|| $item.attr("action");
				form_target		= $item.data("target");
				form_dtype		= $item.data("dtype");
				form_type		= $item.data("type")	|| $item.attr("method");
				form_async		= $item.data("async");
				// form_data		= $item.data()			|| {};

				$.each($item.data(), function( i, v ) {
					form_data[i] = v;
				});
				// 将form内部需要提交控件的值获取并提交
				$item.find(":text,:password,input:hidden,:radio:checked,:checkbox:checked,select,textarea").each(function(i, self){
					var $this = $(self);
					if ($this.is(":checkbox:checked")) {
						form_data[$this.attr("name") + '[' + i + ']'] = $this.val();
					} else {
						form_data[$this.attr("name")] = $this.val();
					}
				});
				// 将submit按钮的值获取并提交
				// TODO: 无法确定提交者信息（即被点击的按钮是哪个）
				// form_data[$item.attr('name')] = $item.attr('value');
			}
			// 参数优先级：调用传递，触发表单，触发元素属性
			url		= options.ajax_load.url		|| form_url		|| $item.data('url');
			target	= options.ajax_load.target	|| form_target	|| $item.data('target');
			dtype	= options.ajax_load.dtype	|| form_dtype	|| $item.data('dtype')	|| 'HTML';
			type	= options.ajax_load.type	|| form_type	|| $item.data('type')	|| 'GET';
			async	= options.ajax_load.async	|| form_async	|| $item.data('async')	|| true;
			data	= $.extend({}, $item.data(), form_data, options.ajax_load);
			
			data	= $.each(data, function(i) {
				// 清除影响ajax的object对象
				if (typeof(data[i]) === 'object') { data[i] = false; }
			});
			
			// 空链接锚链接不处理
			if (!url || reg.test(url)) { return this; }
			// 空目标不处理
			// if (!target || target === "") { return; }
			
			var _inline_ajax = function() {
				$.ajax({
					async		: async,
					url			: url,
					type		: type,
					dataType	: dtype,
					data		: data,
					cache		: false,
					success		: function(response_data) {
						/**
						 * @if dtype == html
						 * @response_data 对$(target)填充的html
						 * 
						 * @elif dtype == json
						 * 
						 * @response_data.html 对$(target)填充的html
						 * @response_data.url 跳转的url
						 * @response_data.status 自定义状态，默认 status > 0: success; status < 0: error: status == 0: none.
						 * @response_data.text 自定义消息
						 * @response_data.icon 需要显示的图标（IE8及以上适用）
						 * @response_data.title 自定义消息标题
						 * @response_data.img 自定义消息图片
						 */

						dtype = dtype.toUpperCase();
						var url_reg_str = typeof options.ajax_url_reg === 'string' ? options.ajax_url_reg : /^((https?|ftp|file):\/\/)?([\w-]+\.)([\w-]+\.?){1,}(:\d+)?(\/[\w?+%\/.=&#\u4e00-\u9fa5]*)?$/ig;
						var url_reg = new RegExp(url_reg_str);
						
						switch(dtype) {
						case "HTML":
							if (target) {
								$(target).html(response_data);
								// $(target).stop().animate({opacity : 1}, options.ajax_animate_speed);
								_show(target);
								// 嵌套绑定
								options.ajax_load = false;	// ajax_load参数不进行继承（给于target.dc对象）
								$(target).dc(options).ajax_bind(response_data);
							}
							// 当且仅当skip为假，url检测为真（包括字符串）并且测试不通过时不跳转
							if (!options.ajax_url_skip || ( options.ajax_url_reg && !url_reg.test(response_data) ) ) {}
							else { window.location = response_data; }
							break;
						case "JSONP" :	// 服务端请自行支持
						case "JSON":
							if (target) {
								if (response_data.html) {
									$(target).html(response_data.html);		// 当数据类型为JSON时依然允许用户使用关键属性html给予target内容
								}
								// $(target).stop().animate({opacity : 1}, options.ajax_animate_speed);
								_show(target);
								// 嵌套绑定
								options.ajax_load = false;	// ajax_load参数不进行继承（给于target.dc对象）
								$(target).dc(options).ajax_bind(response_data);
								
								// 自动json内容填充
								if (options.ajax_json_filling) {
									var _filling = function(target, data) {
										$.each(data, function(k, v) {
                                            target.find( '*[data-json="' + k + '"]:not([data-json-target])' ).each( function() {
                                                var _self = $( this );
                                                if ( _self.is( 'input, button, textarea, select' ) ) {
                                                    // 自动填充表单的value
                                                    _self.val( v );
                                                } else {
                                                    // 自动填充其他元素的innerHTML
                                                    _self.html( v );
                                                }
                                            } );
                                            target.find( '*[data-json="' + k + '"][data-json-target]' ).each( function() {
                                                var _self = $( this );
                                                // 以属性值的方式自动填充
                                                if ( _self.is( '*[data-json-target]' ) ) {
                                                    _self.attr( _self.attr( 'data-json-target' ), v );
                                                }
                                            } );
										});
										return target;
									}
									if ($.isArray(response_data)) {
										$.each($(target).find('*[data-json-loop]'), function() {
											var _this = $(this);
											$.each(response_data, function(k, v){
												var cl = _this.clone().removeAttr('data-json-loop');
												_filling(cl, v).appendTo(_this.parent());
											});
										}).hide();
									} else {
										_filling($(target), response_data);
									}
								}
							}
							// 当且仅当skip为假，url检测为真（包括字符串）并且测试不通过时不跳转
							if (!options.ajax_url_skip || ( options.ajax_url_reg && !url_reg.test(response_data.url) ) ) { /* do nothing; */ }
							else { window.location = response_data.url; }

							// 若开启自动填充信息，则通过status显示消息，使用mqueue控件
							if ($.isNumeric(response_data.status) && options.ajax_auto_msg) {
								if (response_data.status > 0) {
									$.mqueue.add( { type: "success", title: response_data.title, text: response_data.text, url: response_data.url, icon: response_data.icon, img: response_data.img } );
								} else if (response_data.status < 0) {
									$.mqueue.add( { type: "warning", title: response_data.title, text: response_data.text, url: response_data.url, icon: response_data.icon, img: response_data.img } );
								} else {
									$.mqueue.add( { type: "info", title: response_data.title, text: response_data.text, url: response_data.url, icon: response_data.icon, img: response_data.img } );
								}
							}
							break;
						case "SCRIPT" :	// jQuery已执行，不作处理
						case "TEXT" :	// 文本，不作处理
						case "XML" :	// TODO: 暂不做处理，若存在可复用规则再做处理
						default:
							break;
						}
						// 手动调用的回调函数
						if ($.isFunction(options.ajax_after)) {
							options.ajax_after(response_data);
						}
					},
					error		: function(ex, etype) {
						debugger;
						if (!reg.test(ex.responseText)) {
							$.mqueue.add( { type: "danger", title: etype, text: "A bad news.\nResponse Text: \n" + ex.responseText} );
						}
						if (target) {
							_show(target);
						}
					}
				});
			}
			var _hide = function(target) {
				if (target && !(target instanceof jQuery)) {
					target = $(target);
				}
				if (target && options.ajax_animate) {
					switch(options.ajax_animate) {
					case "fade":
						$(target).stop().fadeOut(options.ajax_animate_speed, _inline_ajax);
						break;
					case "toggle":
						$(target).stop().hide(options.ajax_animate_speed, _inline_ajax);
						break;
					case "slide":
						$(target).stop().slideUp(options.ajax_animate_speed, _inline_ajax);
						break;
					default:
						$(target).stop().fadeOut(options.ajax_animate_speed, _inline_ajax);
						break;
					}
				} else {
					_inline_ajax();
				}
			}
			var _show = function(target) {
				if (target && !(target instanceof jQuery)) {
					target = $(target);
				}
				if (target && options.ajax_animate) {
					switch(options.ajax_animate) {
					case "fade":
						target.stop().fadeIn(options.ajax_animate_speed);
						break;
					case "toggle":
						target.stop().show(options.ajax_animate_speed);
						break;
					case "slide":
						target.stop().slideDown(options.ajax_animate_speed);
						break;
					default:
						target.stop().fadeIn(options.ajax_animate_speed);
						break;
					}
				}
			}
			_hide(target);
			return this;
		},
		_ajax_bind : function( data ) {
			var $this	= this;
			$this.$el.find( '.load-auto' ).each( function() {
				$this._ajax_load.call( this, $this.options );
                $( this ).removeClass( 'load-auto' );
			} );
			$this.$el.find('.load-click' ).off( 'click' ).on( 'click', function() {
				$this._ajax_load.call( this, $this.options );
			} );
			$this.$el.find( '.load-submit' ).off( 'submit' ).on( 'submit', function() {
				$this._ajax_load.call( this, $this.options );
			} );
			return this;
		},
		ajax_bind : function( data ) {
			var $this	= this;
			$this._ajax_bind( data );
			return this;
		},
		ajax_load : function( data ) {
			var $this	= this;
			$this._ajax_load.call($this.$el, data);
			return this;
		},
        /******************** cascade ********************/
        _cascade_load : function( options ) {
			var $this		= this;
			var $item		= $(this);

            var url, target, data;

			options				    = options			    || {};
            options.cascade_load 	= options.cascade_load  || {};

			var reg				= new RegExp(/^#[\S]*$/ig);
			url		= options.cascade_load.url		|| $item.data( 'url' );
			target	= options.cascade_load.target   || $item.data( 'target' );

			data	= $.extend( {}, $item.data(), options.cascade_load );
			data	= $.each(data, function(i) {
				// 清除影响ajax的object对象
				if (typeof(data[i]) === 'object') { data[i] = false; }
			});
			// 空链接锚链接不处理
			if (!url || reg.test(url)) { return this; }

            $.ajax({
                async       : true,
                url         : url,
                type        : 'POST',
                dataType    : 'JSON',
                data        : data,
                cache       : false,
                success     : function( response_data ) {
                    var cascade_select = [];
                    $item.find( '*[data-cascade-layer]' ).each( function( i , self ) {
                        var $self = $( self );
                        cascade_select[ i ] = $self;
                    } );
                    // 第一层级无对象时结束
                    if ( cascade_select.length == 0 ) return;
                    cascade_select.sort( function( a, b ) {
                        if ( a.attr( 'data-cascade-layer' ) > a.attr( 'data-cascade-layer' ) ) { return 1; }
                        if ( a.attr( 'data-cascade-layer' ) < a.attr( 'data-cascade-layer' ) ) { return -1; }
                        return 0;
                    } );
                    var _fill_element = function( layer ) {
                        // 到达最后一层级时结束
                        if ( layer > cascade_select.length - 1 ) return;
                        var el = cascade_select[ layer ], pel, vals;
                        if ( layer == 0 ) {
                            pel     = null;
                            vals    = response_data;
                        } else {
                            pel     = cascade_select[ layer - 1 ];
                            vals    = pel.find( 'option[value=' + pel.val() + ']' ).data( 'children' ) || {};
                        }
                        // 当设置cascade_hide_empty为true时隐藏无内容的下级元素
                        if ( options.cascade_hide_empty && $.isEmptyObject( vals ) ) {
                            el.hide();
                        } else {
                            el.show();
                        }
                        if ( el.is( 'select' ) ) {
                            el.find( 'option' ).remove();
                            var cascade_default = el.attr( 'data-cascade-default' ) || null;
                            if ( options.cascade_show_default ) {
                                var default_name = ( typeof options.cascade_show_default == 'string' ? options.cascade_show_default : '-- 请选择 --' );
                                $( '<option></option>' )
                                    .val( 0 )
                                    .html( default_name )
                                    .appendTo( el );
                            }
                            $.each( vals, function( i, self ) {
                                var option = $( '<option></option>' )
                                    .val( self['id'] )
                                    .html( self['name'] )
                                    .data( 'children', self['children'] );
                                if ( cascade_default && self['id'] == cascade_default ) {
                                    option.attr( 'selected', 'selected' );
                                }
                                option.appendTo( el );
                            } );
                            el.on( 'change', function() {
                                _fill_element( layer + 1 );
                            } );
                        }
                        return el;
                    }
                    _fill_element( 0 ).change();
                },
                error       : function( ex, etype ) {
                    debugger;
                    if ( !reg.test( ex.responseText ) ) {
                        $.mqueue.add( { type: "danger", title: etype, text: "A bad news.\nResponse Text: \n" + ex.responseText } );
                    }
                }
            });
        },
        _cascade_bind : function( ) {
			var $this	= this;
			$this.$el.find( '.cascade-load-auto' ).each( function() {
				$this._cascade_load.call( this, $this.options );
                $( this ).removeClass( 'cascade-load-auto' );
			} );
			return this;
        },
        cascade_load : function( data ) {
			var $this	= this;
			$this._cascade_load.call( $this.$el, data );
			return this;
		},
        cascade_bind : function( data ) {
			var $this	= this;
			$this._cascade_bind( data );
			return this;
        }
	}
	
	$.fn.ajax_load = function( options ) {
		var params = {
			ajax_load : options
		};
		(this.data('dc') || this.dc()).ajax_load(params);
	}
    $.fn.cascade_load = function( options ) {
        var params = options;
        ( this.data( 'dc' ) || this.dc() ).cascade_load( params );
    }
	// OK
    // 自动绑定
    $( 'body.dc-on' ).dc().bind();
})(jQuery);

/**
 * @charset: UTF-8
 * jquery.mqueue jQuery消息列表
 * version: v1.0.1
 * 
 * copyright © 2014 kbdsbx
 * date: 2014-06-13
 * 
 * url: none;
 */

;(function($){
	$.fn.mqueue = function(){
		var mq = new $.mQueue();
		mq._add();
	}
	
	$.mqueue = function( options ) {
		mQueue.add( options );
	}
	
	$.mqueue.add = function( options ) {
		mQueue.add( options );
	}
	$.mqueue.clean = function () {
		mQueue.clean_panel();
	}
	$.mqueue.remove = function ( selector ) {
		mQueue.remove( selector );
	}
	
	var mQueue = {
		types : [
			'default',
			'white',
			'info',
			'danger',
			'warning',
			'success'
		],
		defaults : {
			type		:	'default',	// info success warning danger
			icon		:	false,		// font-awesome
			img			:	false,		// image url
			title		:	false,		// title
			text		:	false,		// text
			url			:	false,		// url
			keeptime	:	8000,		// the item keep to show time
			speed		:	600,		// speed
			position	:	'top',		// top; bottom
			penetrate	:	false		// penetrate
		},
		out_handle : {},
		_create_panel : function( options ) {
			var panel = $("<div></div>").addClass("mqueue-panel");
			if ( options.position === 'bottom' ) {
				panel.addClass("mqueue-panel-bottom");
			}
			$("body").append( panel );
		},
		_clean_panel : function( options ) {
			var panel = $("body > .mqueue-panel");
			if ( panel.length != 0 ) {
				panel.stop().animate( { opacity: 0 }, options.speed / 2, function() {
					panel.remove();
				} );
			}
		},
		_add : function( options ) {
			var panel, item, msg, close, icon, iconClass, title, text, url, img, id, _this = this;
			if ($("body > .mqueue-panel").length == 0) {
				this._create_panel( options );
			}
			
			panel = $("body > .mqueue-panel");
			
			// 添加消息时阻止panel
			panel.stop(true, false);
			panel.css( { opacity : 1 } );
			
			id = parseInt($("body > .mqueue-panel .mqueue-item:last-child").attr("data-mqueue-id"), 10) || 0;
			id += 1;
			item = $("<div></div>")
				.addClass("mqueue-item")
				.attr("data-mqueue-id", id)
				.data("options", options);
			item.on('mouseenter', _this, _this._hover)
		    	.on('mouseleave', _this, _this._leave);
			
			if (options.icon || options.img) { item.addClass("mqueue-richtext"); }
			if (options.penetrate) { item.addClass("mqueue-penetrate"); }
			
			close = $("<div></div>")
				.addClass("mqueue-close")
				.addClass("icon-remove")
				.on("click", function() {
					item.addClass("mqueue-delete");
					_this._remove.apply(_this, [item]);
				});
			
			// 若类型不存在则使用default类型
			if (!_this._find(_this.types, options.type)) {
				options.type = 'default';
			}
			msg = $("<div></div>").addClass("mqueue-" + options.type);
			
			if (options.icon) {
				if (options.icon.substr(0, 5) === 'icon-') {
					iconClass = options.icon;
				} else {
					iconClass = 'icon-' + options.icon;
				}
				icon = $("<span></span>").addClass("mqueue-icon icon-3x " + iconClass);
			}
			
			if (options.img) {
				img = $("<img></img>").addClass("mqueue-img").attr("src", options.img);
			}

			if (options.title) {
				title = $("<span></span>").addClass("mqueue-title");
				if (options.url) {
					url = $("<a></a>").attr("href", options.url).html(options.title);
					url.appendTo(title);
				}
				else {
					title.html(options.title);
				}
			}
			if (options.text) {
				text = $("<p></p>").addClass("mqueue-text");
				if (options.url && !title) {
					url = $("<a></a>").attr("href", options.url).html(options.text);
					url.appendTo(text);
				}
				else {
					text.html(options.text);
				}
			}
			
			close.appendTo(msg);
			if (icon && !img) { icon.appendTo(msg); }
			if (img) { img.appendTo(msg); }
			if (title) { title.appendTo(msg); }
			if (text) { text.appendTo(msg); }
			if (close) {  }
			if (msg) { msg.appendTo(item); }
			
			item.appendTo(panel);
			
			// TODO:
			_this.out_handle = _this.out_handle || {};
			_this.out_handle[id] = setTimeout(function() {
				_this._remove.apply(_this, [item]);
			}, options.keeptime);
		},
		_remove : function( _ele ) {
			var _this = this;
			var _element = $(_ele);
			var id = _element.attr("data-mqueue-id");
			var options = _element.data("options") || _this.defaults;
			var panel = $("body > .mqueue-panel");

			_element.stop().animate( { opacity: 0 }, options.speed ).animate( { height: 0 }, options.speed / 2, function() {
				_element.remove();
				if (panel.find(".mqueue-item").length === 0) {
					_this._clean_panel(options);
				}
			});
			delete _this.out_handle[id];
		},
		/**
		 * 仅用于mousemove/mouseenter/mouseover事件
		 */
		_hover : function( e ) {
			var _this = e.data;
			var _element = $(e.currentTarget);
			var options = _element.data("options");
			if (!_element.hasClass("mqueue-delete")) {
				_element.stop(true, false);
				_element.css( { height: '', opacity: '' } );
				clearTimeout(_this.out_handle[_element.attr("data-mqueue-id")]);
			}
		},
		/**
		 * 仅用于mouseleave事件
		 */
		_leave : function( e ) {
			var _this = e.data;
			var _element = $(e.currentTarget);
			var options = _element.data("options");
			var id = _element.data("mqueue-id");
			
			_this.out_handle[id] = setTimeout(function() {
				_this._remove.apply(_this, [_element]);
			}, options.keeptime);
		},
		_extend : function( options ) {
			return $.extend({}, this.defaults, options);
		},
		_find : function( array, item ) {
			var finded = false;
			if (array instanceof Array) {
				$.each(array, function(i, v) {
					if (v === item) {
						finded = true;
						return false;
					}
				});
			}
			return finded;
		},
		add : function( options ) {
			if ( typeof options === 'string' ) {
				options = this._extend( { title: options } );
			} else {
				options = this._extend( options );
			}
			this._add( options );
		},
		remove : function( element ) {
			var _this = this;
			$.each(element, function() {
				_this._remove( this );
			});
		},
		clean_panel : function() {
			var options = this._extend({});
			this._clean_panel( options );
		}
	}
})(jQuery);































