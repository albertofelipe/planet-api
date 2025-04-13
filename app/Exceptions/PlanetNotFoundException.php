<?php

namespace App\Exceptions;

use Exception;

    class PlanetNotFoundException extends Exception
    {
        protected $message = 'Planet not found';

        public function render() 
        {
            return response()->json([
                'message' => $this->message
            ], 404);
        }
    }
