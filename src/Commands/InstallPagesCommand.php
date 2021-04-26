<?php

namespace Marshmallow\Blogs\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallPagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blogs:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Marshmallow Blog packages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->artisanCall(
            'vendor:publish --provider="Marshmallow\Blogs\BlogsServiceProvider"',
            'Blogs config is published.'
        );

        $this->artisanCall(
            'migrate',
            'Database has been migrated.'
        );

        $this->artisanCall(
            'marshmallow:resource Blog Blogs',
            'Blog Nova resource has been created.'
        );

        $this->artisanCall(
            'marshmallow:resource BlogTag Blogs',
            'Blog Nova resource has been created.'
        );
    }

    protected function artisanCall($command, $info = null)
    {
        Artisan::call($command);

        if ($info) {
            $this->info($info);
        }
    }
}
