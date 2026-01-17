<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RssService;

class FetchAllNews extends Command
{
    protected $signature = 'news:fetch-all';
    protected $description = 'Fetch all RSS news';

    public function handle(RssService $rss)
    {
        $rss->fetchAll();
        $this->info('All news updated successfully');
    }
}
