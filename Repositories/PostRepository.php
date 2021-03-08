<?php namespace Modules\Blog\Repositories;

use Modules\Blog\Entities\Post;
use Modules\Core\Repositories\BaseRepository;

interface PostRepository extends BaseRepository
{
    /**
     * Return the latest x blog posts
     * @param int $amount
     * @return Collection
     */
    public function latest($amount = 5);

    /**
     * Get the previous post of the given post
     * @param object $post
     * @return object
     */
    public function getPreviousOf($post);

    /**
     * Get the next post of the given post
     * @param object $post
     * @return object
     */
    public function getNextOf($post);

    /**
     * @param array $locales
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allInLanguages($locales);

    public function copy(Post $post);
}
