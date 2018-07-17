<?php
namespace Lapcs\Commands\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class Ans extends Command
{
    protected $signature = 'ans:help';

    /**
     * @author file system
     * @var object
     */
    protected $file;

    /**
     * @author time carbon now
     * @var void
     */
    protected $date;

    /**
     * @author generate
     * @var MakeModule
     */
    protected $generate;

    /**
     * @author module alias
     */
    protected $module_alias;

    /**
     * @author path to module
     */
    protected $module_path;

    /**
     * @author path to helper
     */
    protected $helper_path;

    /**
     * @author helper alias
     */
    protected $helper_alias;

    /**
     * @author chmod
     */
    protected $permissions = '0644';
    
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
        $this->date = Carbon::now();
        $this->module_alias = config('lapcs-command.module_alias');
        $this->module_path = config('lapcs-command.module_path');
        $this->helper_path = config('lapcs-command.helper_path');
        $this->helper_alias = config('lapcs-command.helper_alias');
    }

    /**
     * if not exists Directory, make Directory with permission
     * @author tannq@ans-asia.com
     * @var null
     */
    public function createDirectoryIfNotExists($params,$permissions=null) 
    {
        // default permission 0644
        $permissions = $permissions ?? '0644';

        // if @params is array or string
        if(is_array($params)) 
        {
            $bar = $this->output->createProgressBar(count($params));
            $bar->setProgress(-0.8);
            foreach($params as $path)
            {
                sleep(0.8);
                $this->line("");
                $this->line("> Check directory [{$path}] exist ...");
                if(!$this->file->exists(base_path().'/'.$path)) 
                {
                    $this->file->makeDirectory(base_path().'/'.$path,$permissions,true,true);
                    
                } 
                $this->line("Ok!");
                $bar->advance();
            }
            $bar->finish();
        } else {
            if(!$this->file->exists(base_path().'/'.$params)) {
                $this->file->makeDirectory(base_path().'/'.$params,$permissions,true,true);
            }
                $this->line("Ok!"); 
        }
        
    }

    /**
     * get templates
     * @author tannq@ans-asia.com
     * @var string
     */
    public function getTemplate($templateFileName,$search=null,$replace=null)
    {
        $template = $this->file->get(__DIR__.'/templates/'.$templateFileName.'.txt');

        return str_replace($search, $replace, $template);
    }

    /**
     * create file
     * @author tannq@ans-asia.com
     * @var string
     */
    public function createFile($file,$template,$replace=true)
    {
        if(!$this->file->exists($file)) 
        {
            $this->line("->Create file [{$file}]...");
            $this->line("Copy template to [{$file}]...");
            $this->file->put($file,$template);
            $this->info("Content file apply change.");
        } else {
            if($replace) {
                if ($this->confirm("->File [{$file}] already exists, replace the file in the destination? [y|N]")) 
                {
                    $this->line("Copy template to [{$file}]...");
                    $this->file->put($file,$template);
                    $this->info("> Content file apply change.");
                } 
            } 
        }
    }

     /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("1. MakeModule : php artisan ans:module module_name --auth=auth@mail.com");
        $this->line("2. MakeController : php artisan ans:controller module_name controller_name --auth=auth@mail.com");
        $this->line("3. MakeRequest : php artisan ans:request module_name request_name --auth=auth@mail.com");
        $this->line("4. MakeHelper : php artisan ans:helper helper_name --auth=auth@mail.com");
        $this->line("5. MakeComponent : php artisan ans:component componentName --folder=categories");
        $this->line("Thanks!!");
    }
}
