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
    protected $signature = 'ans:controller {module} {name} {--auth=mail@ans-asia.com}';

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
        $module_alias = $this->module_alias;
        $module_path = $this->module_path;
        $auth = $this->option('auth');

        $module =  ucwords($module);
        $name =  ucwords($name);
        $module_alias =  ucwords($module_alias);

        $viewFolder = strtolower($name);
        $this->createDirectoryIfNotExists("{$module_path}/{$module}",$permissions=null);
        $this->createDirectoryIfNotExists("{$module_path}/{$module}/Views/{$viewFolder}",$permissions=null);

        $moduleController = base_path("{$module_path}/{$module}/Controllers/{$name}Controller.php");
        $moduleControllerTemplate = $this->getTemplate(
            "controller",
            ["{{MODULE}}","{{NAME}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}","{{NAMEFOLDER}}"],
            ["{$module}","{$name}","{$module_alias}","{$this->date}",$auth,$viewFolder]
        );
        $this->createFile($moduleController,$moduleControllerTemplate,false);


        $view = base_path("{$module_path}/{$module}/Views/{$viewFolder}/index.blade.php");
        $viewTemplate = $this->getTemplate(
            "index",
            ["{{MODULE}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}","{{NAMEFOLDER}}"],
            ["{$module}","{$module_alias}","{$this->date}",$auth,$viewFolder]
        );
        $this->createFile($view,$viewTemplate);
    }
}
