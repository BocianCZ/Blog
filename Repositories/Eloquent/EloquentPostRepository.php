<?php namespace Modules\Blog\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Status;
use Modules\Blog\Events\PostWasCreated;
use Modules\Blog\Events\PostWasDeleted;
use Modules\Blog\Events\PostWasUpdated;
use Modules\Blog\Repositories\PostRepository;
use Modules\Bocian\Events\EntityWasCreatedOrUpdated;
use Modules\Bocian\Events\EntityWasDeleted;
use Modules\Bocian\Support\EloquentRepositoryHelper;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentPostRepository extends EloquentBaseRepository implements PostRepository
{
    use EloquentRepositoryHelper;

    /**
     * @param  int    $id
     * @return object
     */
    public function find($id)
    {
        return $this->model->with('translations', 'tags')->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->with('translations', 'tags')->orderBy('post_date', 'DESC')->get();
    }

    /**
     * @param array $locales
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allInLanguages($locales)
    {
        return $this->model->with('translations', 'tags')
            ->whereIn('locale', $locales)
            ->orderBy('post_date', 'DESC')
            ->get();
    }

    /**
     * Update a resource
     * @param $post
     * @param  array $data
     * @return mixed
     */
    public function update($post, $data)
    {
        $post->update($data);

        $post->tags()->sync(array_get($data, 'tags', []));

        event(new PostWasUpdated($post->id, $data));
        event(new EntityWasCreatedOrUpdated($post, $data));

        return $post;
    }

    /**
     * Create a blog post
     * @param  array $data
     * @return Post
     */
    public function create($data)
    {
        $post = $this->model->create($data);

        $post->tags()->sync(array_get($data, 'tags', []));

        event(new PostWasCreated($post, $data));
        event(new EntityWasCreatedOrUpdated($post, $data));

        return $post;
    }

    public function destroy($model)
    {
        event(new PostWasDeleted($model->id, get_class($model)));
        event(new EntityWasDeleted($model->id, get_class($model)));

        return $model->delete();
    }

    /**
     * Return all resources in the given language
     *
     * @param  string                                   $lang
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allTranslatedIn($lang)
    {
        return $this->model->whereHas('translations', function (Builder $q) use ($lang) {
            $q->where('locale', "$lang");
            $q->where('title', '!=', '');
        })
            ->with('translations')
            ->with('tags')
            ->with('tags.translations')
            ->whereStatus(Status::PUBLISHED)
            ->where('locale', '=', $lang)
            ->orderBy('post_date', 'DESC')
            ->get();
    }

    /**
     * Return the latest x blog posts
     * @param int $amount
     * @return Collection
     */
    public function latest($amount = 5)
    {
        return $this->model->whereStatus(Status::PUBLISHED)->orderBy('post_date', 'desc')->take($amount)->get();
    }

    /**
     * Return the latest x blog posts
     * @param int $amount
     * @param string $locale
     * @return Collection
     */
    public function latestInLanguage($amount = 5, $locale)
    {
        return  $this->model->whereStatus(Status::PUBLISHED)
            ->where('locale', '=', $locale)
            ->orderBy('post_date', 'desc')
            ->take($amount)
            ->get();
    }

    /**
     * Get the previous post of the given post
     * @param object $post
     * @return object
     */
    public function getPreviousOf($post)
    {
        return $this->model->where('post_date', '<', $post->post_date)
            ->whereStatus(Status::PUBLISHED)->orderBy('post_date', 'desc')->first();
    }

    /**
     * Get the next post of the given post
     * @param object $post
     * @return object
     */
    public function getNextOf($post)
    {
        return $this->model->where('post_date', '>', $post->post_date)
            ->whereStatus(Status::PUBLISHED)->first();
    }

    /**
     * Find a resource by the given slug
     *
     * @param  string $slug
     * @return object
     */
    public function findBySlug($slug)
    {
        return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
            $q->where('slug', "$slug");
        })->with('translations')->whereStatus(Status::PUBLISHED)->firstOrFail();
    }
}
