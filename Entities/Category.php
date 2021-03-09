<?php namespace Modules\Blog\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @property string $name
 * @property string $slug
 * @property string $description
 */
class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'slug', 'description'];
    protected $fillable = ['name', 'slug', 'description'];
    protected $table = 'blog__categories';

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
