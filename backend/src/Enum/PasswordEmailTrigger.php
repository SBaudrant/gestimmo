<?php

namespace App\Enum;

enum PasswordEmailTrigger
{
    case NEW_USER;
    case RESET_PASSWORD;
}
