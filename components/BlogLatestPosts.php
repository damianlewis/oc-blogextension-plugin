<?php

namespace DamianLewis\BlogExtension\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use October\Rain\Database\Collection;
use RainLab\Blog\Models\Post;

class BlogLatestPosts extends ComponentBase
{
    public $latestPosts;

    public function componentDetails()
    {
        return [
            'name' => 'Latest Posts',
            'description' => 'Display a list of latest posts.'
        ];
    }

    public function defineProperties()
    {
        return [
            'numberOfPosts' => [
                'title' => 'Number of posts',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Invalid format for number of posts value',
                'default' => '5'
            ],
            'postPage' => [
                'title' => 'Post page',
                'description' => 'Name of the blog post page file.',
                'type' => 'dropdown',
                'default' => 'blog/post'
            ],
            'exceptPost' => [
                'title' => 'Except post',
                'description' => 'Enter ID/URL or variable with post ID/URL you want to exclude',
                'type' => 'string',
                'default' => ''
            ],
        ];
    }

    public function onRun()
    {
        $this->latestPosts = $this->page['latestPosts'] = $this->getLatestPosts();
    }

    /**
     * Returns a list of CMS pages for the 'postPage' property dropdown options.
     *
     * @return array
     */
    public function getPostPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * Returns a limited number of published posts ordered by the published date.
     *
     * @return Collection
     */
    protected function getLatestPosts()
    {
        $query = Post::isPublished();

        if ($exceptPost = $this->property('exceptPost')) {
            if (is_numeric($exceptPost)) {
                $query->where('id', '<>', $exceptPost);
            } else {
                $query->where('slug', '<>', $exceptPost);
            }
        }

        $query->orderBy('published_at', 'desc');

        $query->take($this->property('numberOfPosts'));

        $posts = $query->get();

        $this->setUrlForPostPage($posts);

        return $posts;
    }

    /**
     * Sets the url to the blog post page for a collection of posts.
     *
     * @param Collection $posts
     * @return void
     */
    protected function setUrlForPostPage(Collection $posts)
    {
        $posts->each(function (Post $post) {
            $post->setUrl($this->property('eventPage'), $this->controller);
        });
    }
}
