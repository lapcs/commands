<?php

namespace Lapcs\Commands\Console\Commands;

use Lapcs\Commands\Console\Commands\Ans;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class MakeComponent extends Ans
{
    /**
     * The name and signature of the console command.
     * @author tannq@ans-asia.com
     * @var string
     */
    protected $signature = 'ans:component {name} {--folder=categories} {--auth=<quangtaned@gmail.com> }';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use: php artisan ans:component {name} {--folder=categories} {--auth=<quangtaned@gmail.com> }';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $name = ucwords($arguments['name']);
        
        $folder = 'resources\\assets\\js\\'.$this->option('folder');

        $auth = $this->option('auth');

        $name =  ucwords($name);
        $folder =  ucwords($folder);

        $this->createDirectoryIfNotExists("{$folder}",$permissions=null);

        $component = base_path("{$folder}/{$name}.vue");
        $componentTemplate = $this->getTemplate(
            "Component"
        );
        $this->createFile($component,$componentTemplate,false);
    }
}
