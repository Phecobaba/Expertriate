<?php

namespace App\Foundation\Bootstrap;

use Illuminate\Foundation\Bootstrap\HandleExceptions as BaseHandleExceptions;

class HandleExceptions extends BaseHandleExceptions
{
    /**
     * Keep PHP 8.x deprecation notices from crashing Laravel 8 bootstrap.
     *
     * @param int $level
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $context
     * @return bool|void
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (in_array($level, [E_DEPRECATED, E_USER_DEPRECATED], true)) {
            return true;
        }

        return parent::handleError($level, $message, $file, $line, $context);
    }
}

