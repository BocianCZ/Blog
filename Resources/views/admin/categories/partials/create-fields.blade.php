<div class="box-body">
    <div class='form-group{{ $errors->has("{$lang}.name") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[name]", trans('blog::category.form.name')) !!}
        {!! Form::text("{$lang}[name]", old("{$lang}[name]"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('blog::category.form.name')]) !!}
        {!! $errors->first("{$lang}.name", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}.slug") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[slug]", trans('blog::category.form.slug')) !!}
        {!! Form::text("{$lang}[slug]", old("{$lang}[slug]"), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('blog::category.form.slug')]) !!}
        {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}.meta_title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[meta_title]", trans('blog::category.form.meta_title')) !!}
        {!! Form::text("{$lang}[meta_title]", old("{$lang}[meta_title]"), ['class' => 'form-control', 'placeholder' => trans('blog::category.form.meta_title')]) !!}
        {!! $errors->first("{$lang}.meta_title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}.meta_description") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[meta_description]", trans('blog::category.form.meta_description')) !!}
        {!! Form::textarea("{$lang}[meta_description]", old("{$lang}[meta_description]"), ['class' => 'form-control']) !!}
        {!! $errors->first("{$lang}.meta_description", '<span class="help-block">:message</span>') !!}
    </div>
</div>
