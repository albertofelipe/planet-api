<?php

namespace App\Filters\Planet;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class PlanetFilter extends ApiFilter 
{
    protected $safeParams = [
        'name' => ['eq'],
        'climate' => ['eq', 'ne'],
        'terrain' => ['eq', 'ne']
    ];

    protected $operatorMap = [
        'eq' => '=',
        'ne' => '!='
     ];
}