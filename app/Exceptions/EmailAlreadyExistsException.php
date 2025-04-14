<?php

namespace App\Exceptions;

use Exception;

    class EmailAlreadyExistsException extends Exception
    {
        protected $message = 'Email address already exists';

        public function render() 
        {
            return response()->json([
                'message' => $this->message
            ], 404);
        }
    }
