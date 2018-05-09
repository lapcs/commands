<?php

namespace Lapcs\Commands\Console\Commands;

use Lapcs\Commands\Console\Commands\Ans;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;
class MakeModel extends Ans
{
    /**
     * The name and signature of the console command.
     * @author tannq@ans-asia.com
     * @var string
     */
    protected $signature = 'ans:model {name} {--namespace=App} {--table=database_table} {--auth=<quangtaned@gmail.com> } {--alias=App}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use: php artisan ans:model model_name --auth=auth@mail.com';

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
        $table = $this->option('table');
        $alias = $this->option('alias');
        $auth = $this->option('auth');

        $name =  ucwords($name);
        $namespace =  ucwords($namespace);
        $table =  strtolower($table);
        $alias =  ucwords($alias);

        $this->createDirectoryIfNotExists("{$alias}",$permissions=null);

        $model = base_path("{$alias}/{$name}.php");
        $modelTemplate = $this->getTemplate(
            "Model",
            ["{{NAME}}","{{TABLE}}"],
            ["{$name}","{$table}"]
        );
        $this->createFile($model,$modelTemplate,false);
    }
}
