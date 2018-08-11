<?php 
namespace Lapcs\Commands\Console\Commands;

use Lapcs\Commands\Console\Commands\Ans;
class ModuleGenerate extends Ans
{
    /**
     * The name and signature of the console command.
     * @author tannq@ans-asia.com
     * @var string
     */
    protected $signature = 'ans:setup {--auth=mail@ans-asia.com}';

    /**
     * The console command description.
     * @author tannq@ans-asia.com
     * @var string
     */
    protected $description = 'Setup project...';

    /**
     * Execute the console command.
     * @author tannq@ans-asia.com
     * @return mixed
     */
    public function handle()
    {
        $auth         = $this->option('auth');
        $module_alias = $this->module_alias;
        $dir          =  $this->module_path;
        $dir          =  str_replace('\\', '/', $dir);
        $module_alias = ucwords($module_alias);
        sleep(1);
        $this->line('1. Make default directory');
        // $dir = explode('\\', $dir); // ['app','Modules']
        $this->createDirectoryIfNotExists($dir,$permissions=0755) ;

        // setup ModuleServiceProvider
        $this->line("");
        sleep(1);
        $this->line("2. Create file ModuleServiceProvider...");

        $moduleServiceProvider = base_path("{$dir}/ModuleServiceProvider.php");

        $this->line("> Copy template to {$dir}/ModuleServiceProvider.php...");
        $moduleServiceProviderTemplate = $this->getTemplate(
                    "ModuleServiceProvider",
                    ["{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
                    ["{$module_alias}","{$this->date}",$auth]
        );
        // $this->file->chmod($moduleServiceProvider,0755);
        $this->file->put($moduleServiceProvider,$moduleServiceProviderTemplate);
        $this->line("Ok!");

        // setup composer
        $this->line("");
        // sleep(1);
        // $this->line("3. Create file composer.json...");
        // $composer = base_path("{$module}/composer.json");
        
        // $this->line("> Copy template to {$module}/composer.json...");
        // $composerTemplate = $this->getTemplate("composer","{{PATH}}","{$module}");

        // $this->file->put($composer,$composerTemplate);
        // sleep(1);
        $this->info("Setup modules success!");
    }
}
