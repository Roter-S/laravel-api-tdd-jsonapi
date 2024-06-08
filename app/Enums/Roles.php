<?php

namespace App\Enums;

enum Roles: string
{
    case Musician = 'musician';
    case GroupAdministrator = 'group_administrator';
    case SuperAdministrator = 'super_administrator';
}
