var utils = {
    trim:function (str) {
        return str.replace(/(^[ \t\n\r]+)|([ \t\n\r]+$)/g, '');
    },
    str2json : function(s){
        if (window.JSON) {
            return JSON.parse(s);
        } else {
            return (new Function("return " + utils.trim(s || '')))();
        }

    },
	att_show:function(attid,data){
		var id = data.aid;
		var src = data.url;
		var ext = data.type;
		var filename = data.title;
		if(id == 0) {
			return false;
		}
		//$.get('index.php?m=attachment&c=attachments&a=swfupload_json&aid='+id+'&src='+src+'&filename='+filename);
		//$('#att-status_'+attid).append('|'+src);
		//$('#att-name_'+attid).append('|'+filename);
		$('#att-status_'+attid).append(src);
		$('#att-name_'+attid).append(filename);
	}

};
jQuery(function() {
    var $ = jQuery;
    $.fn.webupload_fileinput = function (config) {
        $('body').append(renderModal());
        var _modal = $('#' + config['modal_id']),
            chooseObject; // 点击选择图片的按钮
        
        _modal.on("shown.bs.modal", init);

        function init () {
            var $wrap = $('#uploader'),
			
			    // 图片容器
			    $queue = $wrap.find('.filelist'),
			
			    // 状态栏，包括进度和控制按钮
			    $statusBar = $wrap.find('.statusBar'),
			
			    // 文件总体选择信息。
			    $info = $statusBar.find('.info'),
			
			    // 上传按钮
			    $upload = $wrap.find('.uploadBtn'),
				$filePickerBlock = $wrap.find('.filePickerBlock'),
			
			    // 没选择文件之前的内容。
			    $placeHolder = $wrap.find('.placeholder'),
			
			    // 总体进度条
			    $progress = $statusBar.find('.progress').hide(),
			
			    // 添加的文件数量
			    fileCount = 0,
			
			    // 添加的文件总大小
			    fileSize = 0,
			
			    // 优化retina, 在retina下这个值是2
			    ratio = window.devicePixelRatio || 1,
			
			    // 缩略图大小
			    thumbnailWidth = 110 * ratio,
			    thumbnailHeight = 110 * ratio,
			
			    // 可能有pedding, ready, uploading, confirm, done.
			    state = 'pedding',
			
			    // 所有文件的进度信息，key为file id
			    percentages = {},
			
			    supportTransition = (function(){
			        var s = document.createElement('p').style,
			            r = 'transition' in s ||
			                  'WebkitTransition' in s ||
			                  'MozTransition' in s ||
			                  'msTransition' in s ||
			                  'OTransition' in s;
			        s = null;
			        return r;
			    })(),
			
			    // WebUploader实例
			    uploader,
				acceptExtensions = config.acceptExtensions ? config.acceptExtensions : 'gif,jpg,jpeg,png';
			
			if ( !WebUploader.Uploader.support() ) {
			    alert( 'Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
			    throw new Error( 'WebUploader does not support the browser you are using.' );
			}
			
			// 实例化
			uploader = WebUploader.create({
			    pick: {
			        id: '#filePicker',
			        label: '点击选择文件'
			    },
			    dnd: '#uploader .queueList',
			    paste: document.body,
			
			    accept: {
			        title: 'Images',
			        extensions: acceptExtensions.replace(/\|/g, ',').replace(/^[,]/, ''),
			    },
				swf: '../Uploader.swf',
			    disableGlobalDnd: true,
			    chunked: true,
			    server: config.server,
				formData: config.formData||{},
				fileVal: 'upload',
				duplicate: true,
			    fileNumLimit: config.multiple ? config.fileNumLimit : 1,
				fileSizeLimit:config.fileSizeLimit ? config.fileSizeLimit : 200*1024*1024,
			    fileSingleSizeLimit: config.fileSingleSizeLimit * 1024    ,// 50 M
				threads:1,
				compress: {
				    width: 800,
				    height: 800,
				    // 图片质量，只有type为`image/jpeg`的时候才有效。
				    quality: 90,
				    // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
				    allowMagnify: false,
				    // 是否允许裁剪。
				    crop: false,
				    // 是否保留头部meta信息。
				    preserveHeaders: true,
					compressSize:300*1024
				}
			});
			uploader.addButton({
			    id: '#filePickerBlock'
			});
			
			// 当有文件添加进来时执行，负责view的创建
			function addFile( file ) {
			    var $li = $( '<li id="' + file.id + '">' +
			            '<p class="title">' + file.name + '</p>' +
			            '<p class="imgWrap"></p>'+
			            '<p class="progress"><span></span></p>' +
			            '</li>' ),
			
			        $btns = $('<div class="file-panel">' +
			            '<span class="cancel">删除</span>' +
			            '<span class="rotateRight">向右旋转</span>' +
			            '<span class="rotateLeft">向左旋转</span></div>').appendTo( $li ),
			        $prgress = $li.find('p.progress span'),
			        $wrap = $li.find( 'p.imgWrap' ),
			        $info = $('<p class="error"></p>').hide().appendTo($li),
			
			        showError = function( code ) {
			            switch( code ) {
			                case 'exceed_size':
			                    text = '文件大小超出';
			                    break;
			
			                case 'interrupt':
			                    text = '上传暂停';
			                    break;
			
			                default:
			                    text = '上传失败，请重试';
			                    break;
			            }
			
			            $info.text( text ).appendTo( $li );
			        };
			
			    if ( file.getStatus() === 'invalid' ) {
			        showError( file.statusText );
			    } else {
			        // @todo lazyload
			        $wrap.text( '预览中' );
			        uploader.makeThumb( file, function( error, src ) {
			            if ( error ) {
			                $wrap.text( '不能预览' );
			                return;
			            }
			
			            var img = $('<img src="'+src+'">');
			            $wrap.empty().append( img );
			        }, thumbnailWidth, thumbnailHeight );
			
			        percentages[ file.id ] = [ file.size, 0 ];
			        file.rotation = 0;
			    }
			
			    file.on('statuschange', function( cur, prev ) {
			        if ( prev === 'progress' ) {
			            $prgress.hide().width(0);
			        } else if ( prev === 'queued' ) {
			            $li.off( 'mouseenter mouseleave' );
			            $btns.remove();
			        }
			
			        // 成功
			        if ( cur === 'error' || cur === 'invalid' ) {
			            console.log( file.statusText );
			            showError( file.statusText );
			            percentages[ file.id ][ 1 ] = 1;
			        } else if ( cur === 'interrupt' ) {
			            showError( 'interrupt' );
			        } else if ( cur === 'queued' ) {
			            percentages[ file.id ][ 1 ] = 0;
			        } else if ( cur === 'progress' ) {
			            $info.hide();
			            $prgress.css('display', 'block');
			        } else if ( cur === 'complete' ) {
			            //$li.append( '<span class="success"></span>' );
			        }
			
			        $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
			    });
			
			    $li.on( 'mouseenter', function() {
			        $btns.stop().animate({height: 30});
			    });
			
			    $li.on( 'mouseleave', function() {
			        $btns.stop().animate({height: 0});
			    });
			
			    $btns.on( 'click', 'span', function() {
			        var index = $(this).index(),
			            deg;
			
			        switch ( index ) {
			            case 0:
			                uploader.removeFile( file );
			                return;
			
			            case 1:
			                file.rotation += 90;
			                break;
			
			            case 2:
			                file.rotation -= 90;
			                break;
			        }
			
			        if ( supportTransition ) {
			            deg = 'rotate(' + file.rotation + 'deg)';
			            $wrap.css({
			                '-webkit-transform': deg,
			                '-mos-transform': deg,
			                '-o-transform': deg,
			                'transform': deg
			            });
			        } else {
			            $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
			            
			        }
			
			
			    });
				$li.insertBefore($filePickerBlock);
			
			    //$li.appendTo( $queue );
			}
			
			// 负责view的销毁
			function removeFile( file ) {
			    var $li = $('#'+file.id);
			
			    delete percentages[ file.id ];
			    updateTotalProgress();
			    $li.off().find('.file-panel').off().end().remove();
			}
			
			function updateTotalProgress() {
			    var loaded = 0,
			        total = 0,
			        spans = $progress.children(),
			        percent;
			
			    $.each( percentages, function( k, v ) {
			        total += v[ 0 ];
			        loaded += v[ 0 ] * v[ 1 ];
			    } );
			
			    percent = total ? loaded / total : 0;
			
			    spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
			    spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
			    updateStatus();
			}
			
			function updateStatus() {
			    var text = '', stats;
			
			    if ( state === 'ready' ) {
			        text = '选中' + fileCount + '个文件，共' +
			                WebUploader.formatSize( fileSize ) + '。';
			    } else if ( state === 'confirm' ) {
			        stats = uploader.getStats();
			        if ( stats.uploadFailNum ) {
			            text = '已成功上传' + stats.successNum+ '个文件，'+
			                stats.uploadFailNum + '个文件上传失败，<a class="retry" href="#">重新上传</a>'
			        }
			
			    } else {
			        stats = uploader.getStats();
			        text = '共' + fileCount + '个（' +
			                WebUploader.formatSize( fileSize )  +
			                '），已上传' + stats.successNum + '个';
			
			        if ( stats.uploadFailNum ) {
			            text += '，失败' + stats.uploadFailNum + '个';
			        }
			    }
			
			    $info.html( text );
			}
			
			function setState( val ) {
			    var file, stats;
			
			    if ( val === state ) {
			        return;
			    }
			
			    $upload.removeClass( 'state-' + state );
			    $upload.addClass( 'state-' + val );
			    state = val;
			
			    switch ( state ) {
			        case 'pedding':
						$queue.addClass('element-invisible');
			            $placeHolder.removeClass( 'element-invisible' );
			            $queue.parent().removeClass('filled');
			            $queue.hide();
			            $statusBar.addClass( 'element-invisible' );
			            uploader.refresh();
			            break;
			
			        case 'ready':
			            $placeHolder.addClass( 'element-invisible' );
			            $( '#filePickerBtn' ).removeClass( 'element-invisible');
						$queue.removeClass('element-invisible');
			            $queue.parent().addClass('filled');
			            $queue.show();
			            $statusBar.removeClass('element-invisible');
			            uploader.refresh();
			            break;
			
			        case 'uploading':
			            $( '#filePickerBtn' ).addClass( 'element-invisible' );
			            $progress.show();
			            $upload.text( '暂停上传' );
			            break;
			
			        case 'paused':
			            $progress.show();
			            $upload.text( '继续上传' );
			            break;
			
			        case 'confirm':
			            $progress.hide();
			            $upload.text( '开始上传' ).addClass( 'disabled' );
			
			            stats = uploader.getStats();
			            if ( stats.successNum && !stats.uploadFailNum ) {
			                setState( 'finish' );
			                return;
			            }
			            break;
			        case 'finish':
			            stats = uploader.getStats();
			            $progress.hide(); $info.show();
			            if (stats.uploadFailNum) {
			                $upload.text('重试上传');
			            } else {
			                $upload.text('开始上传');
			            }
			            break;
			    }
			
			    updateStatus();
			}
			
			uploader.onUploadProgress = function( file, percentage ) {
			    var $li = $('#'+file.id),
			        $percent = $li.find('.progress span');
			
			    $percent.css( 'width', percentage * 100 + '%' );
			    percentages[ file.id ][ 1 ] = percentage;
			    updateTotalProgress();
			};
			
			uploader.onFileQueued = function( file ) {
			    fileCount++;
			    fileSize += file.size;
			
			    if ( fileCount === 1 ) {
			        $placeHolder.addClass( 'element-invisible' );
			        $statusBar.show();
			    }
			
			    addFile( file );
			    setState( 'ready' );
			    updateTotalProgress();
			};
			
			uploader.onFileDequeued = function( file ) {
			    fileCount--;
			    fileSize -= file.size;
			
			    if ( !fileCount ) {
			        setState( 'pedding' );
			    }
			
			    removeFile( file );
			    updateTotalProgress();
			
			};
			uploader.on('uploadSuccess', function (file, ret) {
			    var $file = $('#' + file.id);
			    try {
			        var responseText = (ret._raw || ret),
			            json = utils.str2json(responseText);
			        if (json.state == 'SUCCESS') {
						utils.att_show(config['modal_id'], json);
			            $file.append('<span class="success"></span>');
			        } else {
			            $file.find('.error').text(json.state).show();
			        }
			    } catch (e) {
			        $file.find('.error').text('服务器返回出错').show();
			    }
			});
			uploader.on( 'all', function( type ) {
			    var stats;
			    switch( type ) {
			        case 'uploadFinished':
			            setState( 'confirm' );
			            break;
			
			        case 'startUpload':
			            setState( 'uploading' );
			            break;
			
			        case 'stopUpload':
			            setState( 'paused' );
			            break;
			
			    }
			});
			
			uploader.onError = function( code ) {
				var msg = code;
				switch (code) {
				    case 'Q_EXCEED_NUM_LIMIT':
				        msg = '添加的文件数量超出了限制';
				        break;
				    case 'Q_EXCEED_SIZE_LIMIT':
				        msg = '添加的文件总大小超出了限制';
				        break;
					case 'F_EXCEED_SIZE':
					    msg = '添加的文件大小超出了限制';
					    break;
				    case 'Q_TYPE_DENIED':
				        msg = '添加的文件类型错误';
				        break;
				    case 'P_DUPLICATE':
				        msg = '添加的文件重复了';
				        break;
				}
				alert( 'Error: ' + msg );
			};
			
			$upload.on('click', function() {
			    if ( $(this).hasClass( 'disabled' ) ) {
			        return false;
			    }
			
			    if ( state === 'ready' ) {
			        uploader.upload();
			    } else if ( state === 'paused' ) {
			        uploader.upload();
			    } else if ( state === 'uploading' ) {
			        uploader.stop();
			    }
			});
			
			$info.on( 'click', '.retry', function() {
			    uploader.retry();
			} );
			
			$info.on( 'click', '.ignore', function() {
			    alert( 'todo' );
			} );
			
			$upload.addClass( 'state-' + state );
			updateTotalProgress();
        }
		

        function buildModalBody () {
            return '<ul class="nav nav-upfile">\
        					<li class="active"><a href="#tab-upfile1" data-toggle="tab" aria-expanded="true">本地上传</a></li>\
        					<li class=""><a href="#tab-upfile2" data-toggle="tab" aria-expanded="false">插入图片</a></li>\
        					<li class=""><a href="#tab-upfile3" data-toggle="tab" aria-expanded="false" onclick="set_frame(\'album_list\',\''+config['albumUrl']+'\');">在线管理</a></li>\
        				</ul>\
        				<div class="tab-content upload-attachment-content">\
        					<div class="tab-pane fade active in" id="tab-upfile1">\
        						<div id="uploader" class="wu-example">' +
        									'<div class="statusBar" style="display:none;">' +
        										'<div class="progress">' +
        											'<span class="text">0%</span>' +
        											'<span class="percentage"></span>' +
        										'</div>' +
        										'<div class="info"></div>' +
        										'<div class="btns">' +
        											'<div id="filePickerBtn"></div>' +
        											'<div class="uploadBtn">开始上传</div>' +
        										'</div>' +
        									'</div>' +
        									'<div class="queueList">' +
        										'<div id="dndArea" class="placeholder">' +
        											'<div class="filePickerContainer"><div id="filePicker"></div></div>' +
        										'</div>' +
        										'<ul class="filelist element-invisible">' +
        											'<li id="filePickerBlock" class="filePickerBlock"></li>' +
        										'</ul>' +
        									'</div>' +
        								'</div>\
        					</div>\
        					<div class="tab-pane fade" id="tab-upfile2">\
        					<div class="m-md"><input type="text" class="form-control" id="netfile" placeholder="输入图片的网络地址"></div>\
        					</div>\
        					<div class="tab-pane fade" id="tab-upfile3">\
        					<iframe name="album-list" src="#" frameborder="false" scrolling="no" style="overflow-x:hidden;border:none" width="100%" height="450" allowtransparency="true" id="album_list"></iframe>\
        					</div>\
        					<div id="att-status_'+config['modal_id']+'" class="hidden"></div>\
        					<div id="att-name_'+config['modal_id']+'" class="hidden"></div>\
        				</div>';
        }

        function renderModal () {
            var modal_id = config['modal_id'];
            if ($('#' + modal_id).length == 0) {
                return '<div id="' + config['modal_id'] + '" class="fade modal modal-c" role="dialog" tabindex="-1">' +
                        '<div class="modal-dialog cus-size">' +
                            '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                                    '<h4 class="modal-title">上传文件</h4>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '</div>' +
								'<div class="modal-footer">'+
									'<button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>'+
								'</div>'+
                            '</div>' +
                        '</div>' +
                    '</div>';
            } else {
                return false;
            }
        }
        // =====================================================================================
        $('.' + config['modal_id']).on('click', function () {
            chooseObject = $(this);
            _modal.modal('show');
            _modal.find('.modal-body').html('');
            _modal.find('.modal-body').html(buildModalBody());
        });
        
        $('#file_'+ config['modal_id']).on('click', '.upload-image-delete', function () {
            $('#upload_btn_' + config['modal_id']).show();
            $('#upload_box_' + config['modal_id']).hide();
            $('#thumb_input_' + config['modal_id']).val('');
        });
		
        $('#file_'+ config['modal_id']).on('click', '.delImage', function () {
            var _this = $(this);
            _this.prev().attr("src", config.defaultImage);
            _this.parent().prev().find("input").val("");
        });
        $('#file_'+ config['modal_id']).on('click', '.delMultiImage', function () {
            $(this).parent().remove();
        });
        // 解决多modal下滚动以及filePicker失效问题
        $('#'+ config['modal_id']).on('hidden.bs.modal', function () {
			var in_content = $("#att-status_"+config['modal_id']).html();
			console.log(in_content);
			if(in_content=='') return false;
			/* if(!IsImg(in_content)) {
				alert('选择的类型必须为图片类型');
				return false;
			} */
			if($('#thumb_preview_' + config['modal_id'])) {
				$('#thumb_preview_' + config['modal_id']).attr('src',in_content);
			}
			$('#thumb_input_' + config['modal_id']).val(in_content);
            $('#upload_btn_' + config['modal_id']).hide();
            $('#upload_box_' + config['modal_id']).show();
			if($('.modal:visible').length) {
			    $(document.body).addClass('modal-open');
			}
			$('.modal-c').find('.modal-body').html('');
        });
		$(document).on('blur', '#netfile',function(){
			var strs = $(this).val() ? $(this).val() :'';
			$("#att-status_"+config['modal_id']).html(strs);
		})
    };
});
