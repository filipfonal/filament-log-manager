<?php

namespace FilipFonal\FilamentLogManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \FilipFonal\FilamentLogManager\FilamentLogManager
 */
class FilamentLogManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \FilipFonal\FilamentLogManager\FilamentLogManager::class;
    }
}
