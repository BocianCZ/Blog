<?php namespace Modules\Blog\Http\Controllers\Admin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Modules\Blog\Repositories\TagRepository;
use Modules\Bocian\Services\LanguageAuth;

use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Status;
use Modules\Blog\Http\Requests\CreatePostRequest;
use Modules\Blog\Http\Requests\UpdatePostRequest;
use Modules\Blog\Repositories\CategoryRepository;
use Modules\Blog\Repositories\PostRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Repositories\FileRepository;

class PostController extends AdminBaseController
{
    /** @var PostRepository */
    private $post;
    /** @var CategoryRepository */
    private $category;
    /** @var FileRepository */
    private $file;
    /** @var Status */
    private $status;
    /** @var LanguageAuth */
    private $langAuth;
    /** @var TagRepository */
    private $tagRepository;

    public function __construct(
        PostRepository $post,
        CategoryRepository $category,
        FileRepository $file,
        Status $status,
        LanguageAuth $langAuth,
        TagRepository $tagRepository
    ) {
        parent::__construct();

        $this->post = $post;
        $this->category = $category;
        $this->file = $file;
        $this->status = $status;
        $this->langAuth = $langAuth;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = $this->post->allInLanguages($this->langAuth->getAllowedLanguages());

        return view(
            'blog::admin.posts.index',
            ['posts' => $posts]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->assetPipeline->requireJs('ckeditor.js');
        return view('blog::admin.posts.create', [
            'categories' => $this->category->allTranslatedIn(app()->getLocale()),
            'statuses' => $this->status->lists(),
            'allowedLanguages' => $this->langAuth->getAllowedLanguages(),
            'tags' => $this->tagRepository->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePostRequest $request)
    {
        if (!$this->langAuth->hasAccess($request->get('locale'))) {
            app()->abort(403);
        }
        $this->post->create($request->all());

        flash(trans('blog::messages.post created'));

        return redirect()->route('admin.blog.post.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {
        if (!$this->langAuth->hasAccess($post->locale)) {
            app()->abort(403);
        }

        $this->assetPipeline->requireJs('ckeditor.js');

        return view('blog::admin.posts.edit')
            ->with([
                'post' => $post,
                'categories' => $this->category->allTranslatedIn(app()->getLocale()),
                'thumbmail' => $this->file->findFileByZoneForEntity('thumbnail', $post),
                'statuses' => $this->status->lists(),
                'galleryFiles' => $this->file->findMultipleFilesByZoneForEntity('gallery', $post),
                'tags' => $this->tagRepository->all(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Post $post
     * @param UpdatePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Post $post, UpdatePostRequest $request)
    {
        if (!$this->langAuth->hasAccess($request->get('locale'))) {
            app()->abort(403);
        }
        $this->post->update($post, $request->all());

        flash(trans('blog::messages.post updated'));

        return redirect()->route('admin.blog.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        if (!$this->langAuth->hasAccess($post->locale)) {
            app()->abort(403);
        }
        $post->tags()->detach();

        $this->post->destroy($post);

        flash(trans('blog::messages.post deleted'));

        return redirect()->route('admin.blog.post.index');
    }
}
