<?php

namespace App\Models;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;
use Nette\Utils\Paginator;

class BrandsFacade
{
    private Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    public function getBrands(?string $sorting = null): Selection
    {
        if($sorting)
        {
            if($sorting == "ASC")
                return $this->database->table('brands')->order('name ASC');
            else
                return $this->database->table('brands')->order('name DESC');
        }
        else
            return $this->database->table('brands');
    }
}