<?php

namespace Davion153808\MiniCRUDGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Davion153808\MiniCRUDGenerator\Skeleton\SkeletonClass
 */
class MiniCRUDGeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mini-curd-generator';
    }
}
