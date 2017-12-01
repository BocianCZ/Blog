<div class="box-body">
    <div class='form-group{{ $errors->has("$lang.title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('blog::post.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("$lang.title"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('blog::post.form.title')]) !!}
        {!! $errors->first("$lang.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("$lang.slug") ? ' has-error' : '' }}'>
       {!! Form::label("{$lang}[slug]", trans('blog::post.form.slug')) !!}
       {!! Form::text("{$lang}[slug]", old("$lang.slug"), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('blog::post.form.slug')]) !!}
       {!! $errors->first("$lang.slug", '<span class="help-block">:message</span>') !!}
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

    @editor('content', trans('blog::post.form.content'), old("{$lang}.content"), $lang)

    <?php if (config('asgard.blog.config.post.partials.translatable.create') !== []): ?>
        <?php foreach (config('asgard.blog.config.post.partials.translatable.create') as $partial): ?>
        @include($partial)
        <?php endforeach; ?>
    <?php endif; ?>
</div>
