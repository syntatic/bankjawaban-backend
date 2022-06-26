<?php

namespace App\Models\Sanctum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Laravel\Sanctum\PersonalAccessToken as AccessToken;

class PersonalAccessToken extends AccessToken
{
    use HasFactory;
}
