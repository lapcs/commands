<?php 
namespace Lapcs\Commands\Console\Commands;

use Lapcs\Commands\Console\Commands\Ans;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class ModuleGenerate extends Ans
{
    /**
     * The name and signature of the console command.
     * @author tannq@ans-asia.com
     * @var string
     */
    protected $signature = 'ans:setup {--auth=mail@ans-asia.com} {--name=App\Modules} {--namespace=App\Modules}';

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
        $name = $this->option('name');
        $auth = $this->option('auth');
        $namespace = $this->option('namespace');

        // convert first character to uppercase
        $module = ucwords($name);
        $namespace = ucwords($namespace);
        sleep(1);
        $this->line('1. Make default directory');

        $this->createDirectoryIfNotExists("{$module}",$permissions=null) ;

        // setup ModuleServiceProvider
        $this->line("");
        sleep(1);
        $this->line("2. Create file ModuleServiceProvider...");

        $moduleServiceProvider = base_path("{$module}/ModuleServiceProvider.php");

        $this->line("> Copy template to {$module}/ModuleServiceProvider.php...");
        $moduleServiceProviderTemplate = $this->getTemplate(
                    "ModuleServiceProvider",
                    ["{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
                    ["{$namespace}","{$this->date}",$auth]
        );

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
