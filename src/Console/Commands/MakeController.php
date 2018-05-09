<?php
namespace Lapcs\Commands\Console\Commands;

use Lapcs\Commands\Console\Commands\Ans;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class MakeController extends Ans
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ans:controller {module} {name} {--namespace=App\Modules} {--auth=mail@ans-asia.com} {--alias=App\Modules}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use: php artisan ans:controller module_name controller_name --auth=auth@mail.com';

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
        
        $name = str_replace(['Controller','controller'], ['',''], $name);
        $namespace = $this->option('namespace');
        $alias = $this->option('alias');
        $auth = $this->option('auth');

        $module =  ucwords($module);
        $name =  ucwords($name);
        $namespace =  ucwords($namespace);
        $alias =  ucwords($alias);

        $viewFolder = strtolower($name);
        $this->createDirectoryIfNotExists("{$alias}/{$module}",$permissions=null);
        $this->createDirectoryIfNotExists("{$alias}/{$module}/Views/{$viewFolder}",$permissions=null);

        $moduleController = base_path("{$alias}/{$module}/Controllers/{$name}Controller.php");
        $moduleControllerTemplate = $this->getTemplate(
            "Controller",
            ["{{MODULE}}","{{NAME}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}","{{NAMEFOLDER}}"],
            ["{$module}","{$name}","{$namespace}","{$this->date}",$auth,$viewFolder]
        );
        $this->createFile($moduleController,$moduleControllerTemplate,false);


        $view = base_path("{$alias}/{$module}/Views/{$viewFolder}/index.blade.php");
        $viewTemplate = $this->getTemplate(
            "index",
            ["{{MODULE}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}","{{NAMEFOLDER}}"],
            ["{$module}","{$namespace}","{$this->date}",$auth,$viewFolder]
        );
        $this->createFile($view,$viewTemplate);
    }
}
