<?php

namespace App\Services\Wallet;


use Exception;

class WalletException extends Exception
{
    private WalletExceptionCase $case;

    function __construct(WalletExceptionCase $case)
    {
        $this->case = $case;
        throw match ($this->case)
        {
            WalletExceptionCase::InvalidWallet => parent::__construct("Bad Request - Invalid Wallet", 400),
            WalletExceptionCase::NotEnoughCoins => parent::__construct("Bad Request - Not Enough Coins", 400),
        };
    }
}
