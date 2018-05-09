<?php 
namespace Lapcs\Commands\Console\Commands;

use Lapcs\Commands\Console\Commands\Ans;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class MakeModule extends Ans
{
    /**
     * The name and signature of the console command.
     * @author tannq@ans-asia.com
     * @var string
     */
    protected $signature = 'ans:module {name} {--auth=mail@gmail.com} {--path=App\Modules} {--permissions=0644} {--namespace=App\Modules}';

    /**
     * The console command description.
     * @author tannq@ans-asia.com
     * @var string
     */
    protected $description = 'Use: php artisan ans:module module_name --auth=auth@mail.com';

    /**
     * @author tannq@ans-asia.com
     * @var void
     */
    protected $file;

    /**
     * Execute the console command.
     * @author tannq@ans-asia.com
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $path = $this->option('path');
        $auth = $this->option('auth');
        $permissions = $this->option('permissions');
        $namespace = $this->option('namespace');

        // convert first character to uppercase
        $module = ucwords($arguments['name']);
        $path =  ucwords($path);
        $namespace =  ucwords($namespace);
        if(!$this->file->exists(base_path($path))) 
        {
            $this->error("> Error: Directory [{$path}] don't exists!");
            $this->error("Please run: php artisan ans:setup");
            return ;
        }
        $this->line('1. Make default directory');
        $this->createDirectoryIfNotExists([
                    "{$path}/{$module}",
                   // "{$path}/Layouts",
                   // "{$path}/Layouts/Views",
                    "{$path}/{$module}/Controllers",
                    "{$path}/{$module}/Views",
                ],$permissions) ;

        // create master layout
        // $master = base_path("{$path}/Layouts/Views/master.blade.php");
        // $masterTemplate = $this->getTemplate(
        //     "master",
        //     ["{{MODULE}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
        //     ["{$module}","{$namespace}","{$this->date}",$auth]
        // );
        // $this->createFile($master,$masterTemplate,false);
        

        // create controller
        $this->line("");
        $moduleController = base_path("{$path}/{$module}/Controllers/{$module}Controller.php");
        $moduleControllerTemplate = $this->getTemplate(
            "Controller",
            ["{{MODULE}}","{{NAME}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
            ["{$module}","{$module}","{$namespace}","{$this->date}",$auth]
        );
        $this->createFile($moduleController,$moduleControllerTemplate);

        // create routes
        $this->line("");
        
        $moduleRoutes = base_path("{$path}/{$module}/routes.php");
        $moduleRoutesTemplate = $this->getTemplate(
                "routes",
                ["{{MODULE}}","{{NAMESPACE}}","{{PREFIX}}","{{NOW}}","{{AUTH}}"],
                ["{$module}","{$namespace}",strtolower($module),"{$this->date}",$auth]
        );
        $this->createFile($moduleRoutes,$moduleRoutesTemplate);
        
        // create test file
        // $this->line("");
        // $index = base_path("{$path}/{$module}/Views/index.blade.php");
        // $indexTemplate = $this->getTemplate(
        //     "index",
        //     ["{{MODULE}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
        //     ["{$module}","{$namespace}","{$this->date}",$auth]
        // );
        // $this->createFile($index,$indexTemplate);

        $this->line("Please Add [App\Modules\ModuleServiceProvider::class,] to providers: configs\\app ");
    }
    
}
