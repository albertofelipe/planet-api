<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter 
{

    protected $safeParams = [];

    protected $operatorMap = [];

    public function transform(Request $request) 
    {
        $filter = [];

        foreach($this->safeParams as $field => $allowedOperators) {

            $queryValues = $request->query($field);

            if($queryValues === null || !is_array($queryValues)){
                continue;
            }

            foreach($queryValues as $operator => $value){
                if(in_array($operator, $allowedOperators)) {
                    $filter[] = [$field, $this->operatorMap[$operator], $value];
                }
            }

        }
        return $filter;
    }

}