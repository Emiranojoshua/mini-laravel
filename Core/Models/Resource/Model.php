<?php

namespace Core\Models\Resource;

use ReflectionClass;

abstract class Model
{
    // use ModelHandler;

    protected $table;
    protected $fillable = [];
    protected $primaryKey = 'id';

    public function __construct()
    {
        if(!$this->table){
            $className = strtolower((new ReflectionClass($this)->getShortName()));
            $this->table = $className . 's';
        }
    }
}
