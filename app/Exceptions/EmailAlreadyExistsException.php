<?php

namespace App\Exceptions;

use Exception;

    class EmailAlreadyExistsException extends Exception
    {
        protected $message = 'The email has already been taken.';

        public function render() 
        {
            return response()->json([
                'message' => $this->message
            ], 400);
        }
    }
