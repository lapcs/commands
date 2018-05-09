<?php

namespace Lapcs\Commands\Console\Commands;

use Lapcs\Commands\Console\Commands\Ans;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class MakeHelper extends Ans
{
    /**
     * The name and signature of the console command.
     * @author tannq@ans-asia.com
     * @var string
     */
    protected $signature = 'ans:helper {name} {--namespace=App\Helpers} {--auth=mail@ans-asia.com} {--alias=App\Helpers}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use: php artisan ans:helper helper_name --auth=auth@mail.com';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $name = ucwords($arguments['name']);
        
        $namespace = $this->option('namespace');
        $alias = $this->option('alias');
        $auth = $this->option('auth');

        $name =  ucwords($name);
        $namespace =  ucwords($namespace);
        $alias =  ucwords($alias);

        $this->createDirectoryIfNotExists("{$alias}",$permissions=null);

        $helper = base_path("{$alias}/{$name}.php");
        $helperTemplate = $this->getTemplate(
            "Helper",
            ["{{NAME}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
            ["{$name}","{$namespace}","{$this->date}",$auth]
        );
        $this->createFile($helper,$helperTemplate,false);
    }
}
