<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';
    //Para gerar o sitemap rode o comando php artisan app:generate-sitemap

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {
            $uri = $route->uri();

            if (strpos($uri, '{') !== false) continue;
            if (strpos($uri, 'admin') !== false) continue;
            if (strpos($uri, 'login') !== false) continue;

            if (in_array('GET', $route->methods())) {
                $sitemap->add(Url::create('/' . ltrim($uri, '/')));
            }
        }
        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap gerado em public/sitemap.xml');
    }
}
