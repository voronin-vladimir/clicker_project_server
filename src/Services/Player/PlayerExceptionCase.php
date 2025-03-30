<?php

namespace App\Services\Player;

enum PlayerExceptionCase
{
    case InvalidPlayer;
    case PlayerAlreadyExists;
}