<?php

namespace App\Exceptions;

use Exception;

    class EmailNotFoundException extends Exception
    {
        protected $message = 'Email address not found';

        public function render() 
        {
            return response()->json([
                'message' => $this->message
            ], 404);
        }
    }
