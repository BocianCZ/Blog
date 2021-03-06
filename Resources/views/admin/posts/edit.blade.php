@extends('layouts.master')

@section('styles')
<link href="{{{ Module::asset('blog:css/selectize.css') }}}" rel="stylesheet" type="text/css" />
{!! Theme::style('vendor/jquery-ui/themes/base/datepicker.css') !!}
{!! Theme::style('vendor/jquery-ui/themes/smoothness/theme.css') !!}
@stop

@section('content-header')
<h1>
    {{ trans('blog::post.title.edit post') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('admin.blog.post.index') }}">{{ trans('blog::post.title.post') }}</a></li>
    <li class="active">{{ trans('blog::post.title.edit post') }}</li>
</ol>
@stop

@section('content')
{!! Form::open(['route' => ['admin.blog.post.update', $post->id], 'method' => 'put']) !!}

<div class="row">
    <div class="col-md-10">
        <div class="nav-tabs-custom">

            <div class="tab-content">
                <?php $i = 0; ?>
                    <?php $i++; ?>
                    <div class="tab-pane active" id="tab_{{ $i }}">
                        @include('blog::admin.posts.partials.edit-fields', ['lang' => 'default'])
                    </div>
                <?php if (config('asgard.blog.config.post.partials.normal.edit') !== []): ?>
                    <?php foreach (config('asgard.blog.config.post.partials.normal.edit') as $partial): ?>
                        @include($partial)
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="">
                    @include('media::admin.fields.file-link-multiple', [
                        'entityClass' => 'Modules\\\\Blog\\\\Entities\\\\Post',
                        'entityId' => $post->id,
                        'zone' => 'gallery'
                    ])
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.blog.post.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>
        </div> {{-- end nav-tabs-custom --}}
    </div>
    <div class="col-md-2">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label("category", trans('blog::blog.category:') ) !!}
                    <select name="category_id" id="category" class="form-control">
                        <?php foreach ($categories as $category): ?>
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label("status", trans('blog::blog.post status:')) !!}
                    <select name="status" id="status" class="form-control">
                        <?php foreach ($statuses as $id => $status): ?>
                        <option value="{{ $id }}" {{ old('status', $post->status) == $id ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class='form-group{{ $errors->has("tags") ? ' has-error' : '' }}'>
                    {!! Form::label("tags", trans('blog::blog.tags:')) !!}
                    <select name="tags[]" id="tags" class="input-tags" multiple>
                        <?php foreach ($post->tags()->get() as $tag): ?>
                            <?php $tagName = $tag->hasTranslation(locale()) === true ? $tag->translate(locale())->name : 'Not translated';  ?>
                            <option value="{{ $tag->id }}" selected>{{ $tagName }}</option>
                        <?php endforeach; ?>
                    </select>
                    {!! $errors->first("tags", '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label("locale", trans('blog::blog.post language:')) !!}
                    <select name="locale" id="locale" class="form-control">
                        <?php foreach (AllowedLanguages::getFullAllowedLanguages() as $locale => $language): ?>
                            <option value="{{ $locale }}" {{ old('locale', $post->locale) == $locale ? 'selected' : '' }}>
                                {{ $language['native'] }}
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class='form-group{{ $errors->has("post_date") ? ' has-error' : '' }}'>
                    <?php $oldPostDate = isset($post->post_date) ? date('Y-m-d', strToTime($post->post_date)) : date('Y-m-d'); ?>
                    {!! Form::label("post_date", trans('blog::post.form.post date:')) !!}
                    {!! Form::text("post_date", old("post_date", $oldPostDate), ['class' => 'form-control datepicker', 'placeholder' => trans('blog::post.form.post date:')]) !!}
                    {!! $errors->first("post_date", '<span class="help-block">:message</span>') !!}
                </div>
                @include('media::admin.fields.file-link', [
                    'entityClass' => 'Modules\\\\Blog\\\\Entities\\\\Post',
                    'entityId' => $post->id,
                    'zone' => 'thumbnail'
                ])
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index', ['name' => 'posts']) }}</dd>
    </dl>
@stop

@section('scripts')
<script src="{{ Module::asset('blog:js/selectize.min.js') }}" type="text/javascript"></script>
<script src="{{ Module::asset('blog:js/MySelectize.js') }}" type="text/javascript"></script>

{!! Theme::script('vendor/jquery-ui/ui/datepicker.js') !!}

<script type="text/javascript">
    $(function() {
        //CKEDITOR.replaceAll(function( textarea, config ) {
//            console.log(textarea);
//            config.language = '<?= App::getLocale() ?>';
//        } );
    });
    $( document ).ready(function() {
        $(document).keypressAction({
            actions: [
                { key: 'b', route: "<?= route('admin.blog.post.index') ?>" }
            ]
        });

        $('.input-tags').MySelectize({
            'findUri' : '<?= route('api.tag.findByName') ?>/',
            'createUri' : '<?= route('api.tag.store') ?>',
            'token': '<?= csrf_token() ?>'
        });

        $('.datepicker').datepicker({
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd",
            prevText: '',
            nextText: ''
        });
    });
</script>
@stop
