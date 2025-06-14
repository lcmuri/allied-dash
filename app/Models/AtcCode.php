<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class AtcCode extends Model
{
    /** @use HasFactory<\Database\Factories\AtcCodeFactory> */
    use HasFactory, HasRecursiveRelationships;
}
