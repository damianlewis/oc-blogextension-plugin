<?php

namespace DamianLewis\BlogExtension;

use DamianLewis\BlogExtension\Components\BlogLatestPosts;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

    public function pluginDetails()
    {
        return [
            'name' => 'Blog Extension',
            'description' => 'Extends the functionality of the RainLab.Blog plugin.',
            'author' => 'Damian Lewis',
            'icon' => 'icon-pencil',
            'homepage' => 'https://github.com/damianlewis/blogextension'
        ];
    }

    public function registerComponents()
    {
        return [
            BlogLatestPosts::class => 'blogLatestPosts',
        ];
    }
}
