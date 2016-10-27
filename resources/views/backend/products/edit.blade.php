@extends('backend.layouts.app')

@section('page-title')
编辑产品
@stop

@section('content')
{{ Form::model($product, ['route' => [env('APP_BACKEND_PREFIX').'.products.update', $product], 'class' => 'form-horizontal', 'method' => 'PATCH', 'id' => 'edit-product']) }}
    <div class="portlet">            
        <div class="portlet-title">
            <div class="actions btn-set">
                <button type="button" name="back" class="btn btn-secondary-outline" onclick="location.href='{{ route(env('APP_BACKEND_PREFIX').'.products.index') }}'">
                    <i class="fa fa-angle-left"></i>
                    返回
                </button>
                <button class="btn btn-secondary-outline" type="reset">
                    <i class="fa fa-rotate-left"></i>
                    重置
                </button>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-check"></i>
                    保存
                </button>
            </div>
        </div>
        <div class="portlet-body">
            <div class="tabbable-bordered">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    会员用户名
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {{ Form::text('username', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'username', 'readonly' => true]) }}
                                    <span class="help-block"><a href="javascript:;" class="user-info" style="display:none">会员资料</a></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    产品标题
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {{ Form::text('title', null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    产品价格
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-3">
                                    <div class="input-group" id="price">
                                        {{ Form::text('price', null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
                                        {{ Form::select('unit', ['1'=>'个', '2'=>'袋', '3'=>'箱'], null, ['class' => 'form-control select2', 'id' => 'unit']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    产品图片
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <div class="form-control height-auto">
                                        <div id="uploader_photos">
                                            <a id="photos_uploader_pickfiles" href="javascript:;" class="btn btn-success"> <i class="fa fa-plus"></i>
                                                选择图片
                                            </a>
                                            <a id="photos_uploader_uploadfiles" href="javascript:;" class="btn btn-primary">
                                                <i class="fa fa-share"></i>
                                                上传图片
                                            </a>
                                        </div>
                                        <div class="row">
                                            <div id="licenses_uploader_filelist" class="col-md-12">
                                                @foreach ($product->images as $key => $image)
                                                <div class="alert added-files alert-success" id="uploaded_file_{{ $key }}" style="margin:12px 0 0;">
                                                    <a href="{{ $image }}" data-toggle="lightbox">
                                                        <img style="float:left;margin-right:10px;max-width:40px;max-height:32px;" src="{{ $image }}">
                                                    </a>
                                                    <input type="hidden" name="images[]" value="{{ $image }}">
                                                    <div class="filename new" style="line-height: 32px;overflow: hidden;">
                                                        <a href="javascript:;" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> 删除</a>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    产品简介
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {{ Form::textarea('content', null, ['class' => 'form-control editor', 'autocomplete' => 'true', 'id' => 'editor']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
@stop

@section('js')
    @include('UEditor::head')
    <script src="{{asset('js/vendor/plupload/plupload.full.min.js')}}"></script>
    <script src="{{asset('js/vendor/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            //用户资料
            $(document).on('change', '#username', function(){
                if ($('#username').val()){
                    $('.user-info').show();
                } else {
                    $('.user-info').hide();
                }
            })
            $(document).on('click', '.user-info', function(){
                var newWindow = window.open("","_blank");
                if ($('#username').val()){
                    $.get("{{ route(env('APP_BACKEND_PREFIX').'.users.ajax.info') }}", {username: $('#username').val()}, function(data){
                        newWindow.location.href = "/"+"{{ env('APP_BACKEND_PREFIX') }}"+"/users/"+data.id+"/edit";
                    });
                }
            })
            //灯箱插件
            $(document).on('click', '[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox({
                });
            });

        //照片
        var photoer = new plupload.Uploader({
            // add X-CSRF-TOKEN in headers attribute to fix this issue
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : document.getElementById('photos_uploader_pickfiles'), // you can pass in id...
            container: document.getElementById('uploader_photos'), // ... or DOM Element itself
            url : "{{ route('upload.product') }}",
            filters : {
                max_file_size : '10mb',
                mime_types: [
                    {title : "图片文件", extensions : "jpg,jpeg,gif,png"}
                ]
            },
            flash_swf_url : "{{ asset("js/vendor/plupload/Moxie.swf") }}",
            silverlight_xap_url : '{{ asset("js/vendor/plupload/Moxie.xap") }}',          
         
            init: {
                PostInit: function() {
                    $('#photos_uploader_filelist').html("");
         
                    $('#photos_uploader_uploadfiles').click(function() {
                        photoer.start();
                        return false;
                    });

                    $('#photos_uploader_filelist').on('click', '.added-files .remove', function(){
                        var src = $(this).parents('.added-files').find('img').attr('src');
                        $.post(
                            "{{ route('upload.product') }}", 
                            { 
                                '_method' : 'delete', 
                                '_token' : '{{ csrf_token() }}', 
                                'url' : src 
                            }
                        );
                        photoer.removeFile($(this).parents('.added-files').attr("id"));    
                        $(this).parents('.added-files').remove();                     
                    });
                },
         
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        $('#photos_uploader_filelist').append('<div class="alert alert-warning added-files" id="uploaded_file_' + file.id + '" style="margin:12px 0 0;"><div class="filename new" style="line-height: 32px;overflow: hidden;">' + file.name + '(' + plupload.formatSize(file.size) + ') <span class="status label label-info"></span>&nbsp;<a href="javascript:;" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> 删除</a></div></div>');
                    });
                },
         
                UploadProgress: function(up, file) {
                    $('#uploaded_file_' + file.id + ' > .status').html(file.percent + '%');
                },

                FileUploaded: function(up, file, response) {
                    var response = $.parseJSON(response.response);

                    if (response.result && response.result.message == 'OK') {
                        var id = response.id; // uploaded file's unique name. Here you can collect uploaded file names and submit an jax request to your server side script to process the uploaded files and update the images tabke

                        $('#uploaded_file_' + file.id + ' .status').removeClass("label-info").addClass("label-success").html('<i class="fa fa-check"></i> 完成');
                        $('#uploaded_file_' + file.id).removeClass("alert-warning").addClass("alert-success").prepend('<a href="' + response.result.url + '" data-toggle="lightbox"><img style="float:left;margin-right:10px;max-width:40px;max-height:32px;" src="' + response.result.url + '"></a><input type="hidden" name="images[]" value="' + response.result.url + '"/>') // set successfull upload
                    } else {
                        $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-danger").html('<i class="fa fa-warning"></i> Failed'); // set failed upload
                        Theme.alert({type: 'danger', message: '其中一个上传失败。 请重试。', closeInSeconds: 10, icon: 'warning'});
                    }
                },
         
                Error: function(up, err) {
                    Theme.alert({type: 'danger', message: err.message, closeInSeconds: 10, icon: 'warning'});
                }
            }
        });
        photoer.init();
        })

        /**
         * 百度编辑器
         */
        UE.delEditor('editor');
        var ue = UE.getEditor('editor',{
            initialFrameHeight:350,//设置编辑器高度
            scaleEnabled:true
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        })
    </script>
@stop
