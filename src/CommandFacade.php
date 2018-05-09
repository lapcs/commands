<?php 

namespace Lapcs\Commands;

use Illuminate\Support\Facades\Facade;

class CommandFacade extends Facade
{
    protected static function getFacadeAccessor() { 
        return 'lapcs-commands';
    }
}