<?php namespace Modules\Blog\Repositories\Eloquent;

use Modules\Blog\Repositories\CategoryRepository;
use Modules\Bocian\Support\EloquentRepositoryHelper;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    use EloquentRepositoryHelper;
}
