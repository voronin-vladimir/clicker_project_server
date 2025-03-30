<?php

namespace App\Services\Items;

use Exception;

class ItemsException extends Exception
{
    private ItemsExceptionCase $case;

    /**
     * @throws Exception
     */
    function __construct(ItemsExceptionCase $case)
    {
        $this->case = $case;
        throw match ($this->case)
        {
            ItemsExceptionCase::InvalidNumber => parent::__construct("Bad Request - Invalid Player", 400),
        };
    }
}