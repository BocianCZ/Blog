<div class="box-body">
    <div class='form-group{{ $errors->has("$lang.title") ? ' has-error' : '' }}'>
        <?php $oldTitle = isset($post->translate($lang)->title) ? $post->translate($lang)->title : ''; ?>
        {!! Form::label("{$lang}[title]", trans('blog::post.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("$lang.title", $oldTitle), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('blog::post.form.title')]) !!}
        {!! $errors->first("$lang.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("$lang.slug") ? ' has-error' : '' }}'>
        <?php $oldSlug = isset($post->translate($lang)->slug) ? $post->translate($lang)->slug : ''; ?>
       {!! Form::label("{$lang}[slug]", trans('blog::post.form.slug')) !!}
       {!! Form::text("{$lang}[slug]", old("$lang.slug", $oldSlug), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('blog::post.form.slug')]) !!}
       {!! $errors->first("$lang.slug", '<span class="help-block">:message</span>') !!}
    </div>

    <div class='form-group{{ $errors->has("{$lang}.meta_title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[meta_title]", trans('blog::post.form.meta_title')) !!}
        <?php $old = $post->hasTranslation($locale) ? $post->translate($lang)->meta_title : '' ?>
        {!! Form::text("{$lang}[meta_title]", old("{$lang}[meta_title]", $old), ['class' => 'form-control', 'placeholder' => trans('blog::post.form.meta_title')]) !!}
        {!! $errors->first("{$lang}.meta_title", '<span class="help-block">:message</span>') !!}
    </div>

    <div class='form-group{{ $errors->has("{$lang}.meta_description") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[meta_description]", trans('blog::post.form.meta_description')) !!}
        <?php $old = $post->hasTranslation($locale) ? $post->translate($lang)->meta_description : '' ?>
        {!! Form::textarea("{$lang}[meta_description]", old("{$lang}[meta_description]", $old), ['class' => 'form-control']) !!}
        {!! $errors->first("{$lang}.meta_description", '<span class="help-block">:message</span>') !!}
    </div>

    <?php $old = isset($post->translate($lang)->content) ? $post->translate($lang)->content : ''; ?>
    <textarea class="ckeditor" name="{{$lang}}[content]" rows="10" cols="80">
    {!! old("{$lang}.content", $old) !!}
    </textarea>

    <?php if (config('asgard.blog.config.post.partials.translatable.edit') !== []): ?>
        <?php foreach (config('asgard.blog.config.post.partials.translatable.edit') as $partial): ?>
        @include($partial)
        <?php endforeach; ?>
    <?php endif; ?>
</div>
