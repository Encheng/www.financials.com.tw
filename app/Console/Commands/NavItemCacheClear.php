<?php

namespace App\Console\Commands;

use App\Services\NavItem\NavItemService;
use Illuminate\Console\Command;

class NavItemCacheClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nav_items:cache_clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete nav_items cache.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var NavItemService $navItemService */
        $navItemService = app(NavItemService::class);
        $row = $navItemService->deleteAllNavItemsCache();
        $this->info($row . ' nav_items cache deleted.');
    }
}
