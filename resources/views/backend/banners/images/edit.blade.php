@extends('backend.layouts.app')

@section('content')
{{ Form::model($image, ['route' => [env('APP_BACKEND_PREFIX').'.banners.image.update', $image], 'class' => 'form-horizontal', 'method' => 'PATCH', 'id' => 'edit-image' ,'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8']) }}
    <div class="portlet">
        <div class="note note-danger no-margin margin-bottom-10">广告图的名字一定不要重名！！！ 文件名最好已时间来命名 （例：2016-10-27-20-10.jpg）图片尺寸建议(640x320)</div>            
        <div class="portlet-title">
            <div class="actions btn-set">
                <button type="button" name="back" class="btn btn-secondary-outline" onclick="location.href='{{ route(env('APP_BACKEND_PREFIX').'.banners.image.index') }}'">
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
                                    所属广告位
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {{ Form::select('banner_id', $banners, null, ['class' => 'form-control select2']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    广告标题
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    {{ Form::text('title', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'title']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    广告图
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    @if ($image->image_url)
                                    {!! $image->image_large_src !!}
                                    @endif
                                    <div class="form-control height-auto">
                                        {{ Form::file('new_image') }}
                                    </div>
                                    <span class="help-block"><span class="required">* 需要更换图片时才选择本栏目</span> </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    广告链接
                                </label>
                                <div class="col-md-10">
                                    {{ Form::text('link', null, ['class' => 'form-control', 'autocomplete' => 'true']) }}
                                    <span class="help-block">例：{{ env('APP_URL') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    广告打开方式
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <div class="icheck-inline">
                                            <label>
                                            {{ Form::radio('target', '_blank', true) }}
                                            新页面
                                            </label>
                                            <label>
                                            {{ Form::radio('target', '_self', false) }}
                                            当前页面
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    广告时间
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                        {{ Form::text('published_from', $image->published_from->format('Y-m-d'), ['class' => 'form-control']) }}
                                        <span class="input-group-addon"> 到 </span>
                                        {{ Form::text('published_to', $image->published_to->format('Y-m-d'), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    排序
                                </label>
                                <div class="col-md-10">
                                    {{ Form::text('order', null, ['class' => 'form-control', 'autocomplete' => 'true']) }}
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
    <script type="text/javascript">
        $(function(){
            //icheck
            $('input').iCheck({
                radioClass: 'iradio_flat-green'
            });
            
            $(document).on('click', '[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox({
                });
            });
        })
    </script>
@stop
