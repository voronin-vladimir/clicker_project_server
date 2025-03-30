<?php

namespace App\Services\Player;

use Exception;

class PlayerException extends Exception
{
    private PlayerExceptionCase $case;

    function __construct(PlayerExceptionCase $case)
    {
        $this->case = $case;
        throw match ($this->case)
        {
            PlayerExceptionCase::InvalidPlayer => parent::__construct("Bad Request - Invalid Player", 406),
            PlayerExceptionCase::PlayerAlreadyExists => parent::__construct("Bad Request - Player Already Exists", 409),
        };
    }
}