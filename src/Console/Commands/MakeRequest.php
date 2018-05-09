<?php

namespace Lapcs\Commands\Console\Commands;

use Lapcs\Commands\Console\Commands\Ans;

use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class MakeRequest extends Ans
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ans:request {module} {name} {--namespace=App\Modules} {--auth=mail@ans-asia.com} {--alias=App\Modules}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use: php artisan ans:request module_name request_name --auth=auth@mail.com';

    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $module = ucwords($arguments['module']);
        $name = ucwords($arguments['name']);
        
        $namespace = $this->option('namespace');
        $alias = $this->option('alias');
        $auth = $this->option('auth');

        $module =  ucwords($module);
        $name =  ucwords($name);
        $namespace =  ucwords($namespace);
        $alias =  ucwords($alias);

        $this->createDirectoryIfNotExists("{$alias}/{$module}/Requests",$permissions=null);

        $moduleRequest = base_path("{$alias}/{$module}/Requests/{$name}.php");
        $moduleRequestTemplate = $this->getTemplate(
            "Request",
            ["{{MODULE}}","{{NAME}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
            ["{$module}","{$name}","{$namespace}","{$this->date}",$auth]
        );
        $this->createFile($moduleRequest,$moduleRequestTemplate,false);
    }
}
