<?php

namespace App\Exceptions;

use Exception;

    class PasswordIncorrectException extends Exception
    {
        protected $message = 'The password is incorrect';

        public function render() 
        {
            return response()->json([
                'message' => $this->message
            ], 401);
        }
    }
