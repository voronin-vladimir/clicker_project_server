<?php

namespace App\Services\Wallet;

enum WalletExceptionCase
{
    case InvalidWallet;
    case NotEnoughCoins;
}