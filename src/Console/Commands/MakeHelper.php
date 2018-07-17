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
    protected $signature = 'ans:helper {name} {--auth=mail@gmail.com}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use: php artisan ans:helper helper_name {--auth=mail@gmail.com}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $name = ucwords($arguments['name']);
        
        $helper_alias = $this->helper_alias;
        $helper_path = $this->helper_path;
        $auth = $this->option('auth');

        $name =  ucwords($name);
        $helper_alias =  ucwords($helper_alias);

        $this->createDirectoryIfNotExists("{$helper_path}",$permissions=null);

        $helper = base_path("{$helper_path}/{$name}.php");
        $helperTemplate = $this->getTemplate(
            "helper",
            ["{{NAME}}","{{NAMESPACE}}","{{NOW}}","{{AUTH}}"],
            ["{$name}","{$helper_alias}","{$this->date}",$auth]
        );
        $this->createFile($helper,$helperTemplate,false);
    }
}
