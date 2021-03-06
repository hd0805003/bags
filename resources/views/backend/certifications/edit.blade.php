@extends('backend.layouts.app')

@section('page-title')
编辑认证
@stop

@section('content')
{{ Form::model($certification, ['route' => [env('APP_BACKEND_PREFIX').'.certifications.update', $certification], 'class' => 'form-horizontal', 'method' => 'PATCH', 'id' => 'edit-certification']) }}
    <div class="portlet">            
        <div class="portlet-title">
            <div class="actions btn-set">
                <button type="button" name="back" class="btn btn-secondary-outline" onclick="location.href='{{ route(env('APP_BACKEND_PREFIX').'.certifications.index') }}'">
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
                                    认证需求会员用户名
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {{ Form::select('user_id', [$certification->user_id => $certification->username], $certification->user_id, ['class' => 'form-control', 'readonly' => true]) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    审核认证机构公司名称
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {{ Form::select('company_id', [$certification->company_id => $certification->companyname], $certification->company_id, ['class' => 'form-control', 'readonly' => true]) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    身份证
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
                                            <div id="photos_uploader_filelist" class="col-md-12">
                                                @foreach ($certification->identity_card as $key => $identity_card)
                                                <div class="alert added-files alert-success" id="uploaded_file_{{ $key }}" style="margin:12px 0 0;">
                                                    <a href="{{ $identity_card }}" data-toggle="lightbox">
                                                        <img style="float:left;margin-right:10px;max-width:40px;max-height:32px;" src="{{ $identity_card }}">
                                                    </a>
                                                    <input type="hidden" name="identity_card[]" value="{{ $identity_card }}">
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
                                    公司营业执照
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <div class="form-control height-auto">
                                        <div id="uploader_licenses">
                                            <a id="licenses_uploader_pickfiles" href="javascript:;" class="btn btn-success"> <i class="fa fa-plus"></i>
                                                选择图片
                                            </a>
                                            <a id="licenses_uploader_uploadfiles" href="javascript:;" class="btn btn-primary">
                                                <i class="fa fa-share"></i>
                                                上传图片
                                            </a>
                                        </div>
                                        <div class="row">
                                            <div id="licenses_uploader_filelist" class="col-md-12">
                                                @foreach ($certification->licenses as $key => $license)
                                                <div class="alert added-files alert-success" id="uploaded_file_{{ $key }}" style="margin:12px 0 0;">
                                                    <a href="{{ $license }}" data-toggle="lightbox">
                                                        <img style="float:left;margin-right:10px;max-width:40px;max-height:32px;" src="{{ $license }}">
                                                    </a>
                                                    <input type="hidden" name="licenses[]" value="{{ $license }}">
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
                                    认证状态
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <div class="icheck-inline">
                                            <label>
                                            {{ Form::radio('status', 2, true, ['data-title' => '通过']) }}
                                            通过
                                            </label>
                                            <label>
                                            {{ Form::radio('status', 1, false, ['data-title' => '待审核']) }}
                                            待审核
                                            </label>
                                            <label>
                                            {{ Form::radio('status', 0, false, ['data-title' => '驳回']) }}
                                            驳回
                                            </label>
                                        </div>
                                    </div>
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
    <script src="{{asset('js/vendor/plupload/plupload.full.min.js')}}"></script>
    <script src="{{asset('js/vendor/plupload/i18n/zh_CN.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $('input').iCheck({
                radioClass: 'iradio_flat-green'
            });
        })

        //身份证
        var link = $('a[data-method="delete"]');
        var cancel = (link.attr('data-trans-button-cancel')) ? link.attr('data-trans-button-cancel') : "返回";
        var confirm = (link.attr('data-trans-button-confirm')) ? link.attr('data-trans-button-confirm') : "确定";
        var title = (link.attr('data-trans-title')) ? link.attr('data-trans-title') : "警告";
        var text = (link.attr('data-trans-text')) ? link.attr('data-trans-text') : "你确定要删除图片吗？删除后一定要提交，不然会导致找不到图片！！！";
        var photoer = new plupload.Uploader({
            // add X-CSRF-TOKEN in headers attribute to fix this issue
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : document.getElementById('photos_uploader_pickfiles'), // you can pass in id...
            container: document.getElementById('uploader_photos'), // ... or DOM Element itself
            url : "{{ route('upload.company') }}",
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
                    //$('#photos_uploader_filelist').html("");
         
                    $('#photos_uploader_uploadfiles').click(function() {
                        photoer.start();
                        return false;
                    });

                    $('#photos_uploader_filelist').on('click', '.added-files .remove', function(){
                        var event = $(this);
                        var src = $(this).parents('.added-files').find('img').attr('src');
                        swal({
                            title: title,
                            text: text,
                            type: "warning",
                            showCancelButton: true,
                            cancelButtonText: cancel,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: confirm,
                            closeOnConfirm: true
                        }, function(confirmed) {
                            if (confirmed) {
                                $.post(
                                    "{{ route('upload.company') }}", 
                                    { 
                                        '_method' : 'delete', 
                                        '_token' : '{{ csrf_token() }}', 
                                        'url' : src 
                                    }
                                );
                                licenses.removeFile(event.parents('.added-files').attr("id"));    
                                event.parents('.added-files').remove();
                            }
                        });                   
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
                        $('#uploaded_file_' + file.id).removeClass("alert-warning").addClass("alert-success").prepend('<a href="' + response.result.url + '" data-toggle="lightbox"><img style="float:left;margin-right:10px;max-width:40px;max-height:32px;" src="' + response.result.url + '"></a><input type="hidden" name="identity_card[]" value="' + response.result.url + '"/>') // set successfull upload
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

        //执照
        var licenses = new plupload.Uploader({
            // add X-CSRF-TOKEN in headers attribute to fix this issue
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : document.getElementById('licenses_uploader_pickfiles'), // you can pass in id...
            container: document.getElementById('uploader_licenses'), // ... or DOM Element itself
            url : "{{ route('upload.company') }}",
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
                    //$('#licenses_uploader_filelist').html("");
         
                    $('#licenses_uploader_uploadfiles').click(function() {
                        licenses.start();
                        return false;
                    });

                    $('#licenses_uploader_filelist').on('click', '.added-files .remove', function(){
                        var event = $(this);
                        var src = $(this).parents('.added-files').find('img').attr('src');
                        swal({
                            title: title,
                            text: text,
                            type: "warning",
                            showCancelButton: true,
                            cancelButtonText: cancel,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: confirm,
                            closeOnConfirm: true
                        }, function(confirmed) {
                            if (confirmed) {
                                $.post(
                                    "{{ route('upload.company') }}", 
                                    { 
                                        '_method' : 'delete', 
                                        '_token' : '{{ csrf_token() }}', 
                                        'url' : src 
                                    }
                                );
                                licenses.removeFile(event.parents('.added-files').attr("id"));    
                                event.parents('.added-files').remove();
                            }
                        });                   
                    });
                },
         
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        $('#licenses_uploader_filelist').append('<div class="alert alert-warning added-files" id="uploaded_file_' + file.id + '" style="margin:12px 0 0;"><div class="filename new" style="line-height: 32px;overflow: hidden;">' + file.name + '(' + plupload.formatSize(file.size) + ') <span class="status label label-info"></span>&nbsp;<a href="javascript:;" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> 删除</a></div></div>');
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
                        $('#uploaded_file_' + file.id).removeClass("alert-warning").addClass("alert-success").prepend('<a href="' + response.result.url + '" data-toggle="lightbox"><img style="float:left;margin-right:10px;max-width:40px;max-height:32px;" src="' + response.result.url + '"></a><input type="hidden" name="licenses[]" value="' + response.result.url + '"/>') // set successfull upload
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
        licenses.init();
    </script>
@stop
