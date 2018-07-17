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
    protected $signature = 'ans:module {name} {--auth=mail@gmail.com}';

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
        $arguments   = $this->arguments();
        $module_path = $this->module_path;
        $auth        = $this->option('auth');
        $permissions = $this->permissions;
        $module_alias   = $this->module_alias;

        // convert first character to uppercase
        $module      = ucwords($arguments['name']);
        // $module_path = ucwords($module_path);
        $module_alias   = ucwords($module_alias);
        if(!$this->file->exists(base_path($module_path))) 
        {
            $this->error("> Error: Directory [{$module_path}] don't exists!");
            $this->error("Please run: php artisan ans:setup");
            return ;
        }
        $this->line('1. Make default directory');
        $this->createDirectoryIfNotExists([
                    "{$module_path}/{$module}",
                   // "{$module_path}/Layouts",
                   // "{$module_path}/Layouts/Views",
                    "{$module_path}/{$module}/Controllers",
                    "{$module_path}/{$module}/Views",
                ],$permissions) ;

        // create controller
        $this->line("\n______________________________^^_______________________________\n");
        $moduleController = base_path("{$module_path}/{$module}/Controllers/{$module}Controller.php");
        $moduleControllerTemplate = $this->getTemplate(
            "controller",
            ["{{MODULE}}","{{NAME}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
            ["{$module}","{$module}","{$module_alias}","{$this->date}",$auth]
        );
        $this->createFile($moduleController,$moduleControllerTemplate);

        // create web router
        $this->line("\n______________________________^^_______________________________\n");
        
        $moduleRoutes = base_path("{$module_path}/{$module}/web.php");
        $moduleRoutesTemplate = $this->getTemplate(
                "web",
                ["{{MODULE}}","{{NAMESPACE}}","{{PREFIX}}","{{NOW}}","{{AUTH}}"],
                ["{$module}","{$module_alias}",strtolower($module),"{$this->date}",$auth]
        );
        $this->createFile($moduleRoutes,$moduleRoutesTemplate);

        // create api router
        $this->line("\n______________________________^^_______________________________\n");
        
        $moduleRoutes = base_path("{$module_path}/{$module}/api.php");
        $moduleRoutesTemplate = $this->getTemplate(
                "api",
                ["{{MODULE}}","{{NAMESPACE}}","{{PREFIX}}","{{NOW}}","{{AUTH}}"],
                ["{$module}","{$module_alias}",strtolower($module),"{$this->date}",$auth]
        );
        $this->createFile($moduleRoutes,$moduleRoutesTemplate);
        
        $this->line("Default render [App\Modules\ModuleServiceProvider::class,] to : app\\Modules ");
        $this->line("Please Add [{$module_alias}\ModuleServiceProvider::class,] to providers: configs\\app ");
        $this->line("You can change path [app\\Modules] to other path, Please add alias to composer autoload psr-4 and run [composer dump-autoload]");
    }
    
}
