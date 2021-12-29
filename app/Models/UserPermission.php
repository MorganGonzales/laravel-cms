<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'route_name',
    ];

    public static function routeNameList(): array
    {
        return [
            'pages',
            'navigation-menus',
            'dashboard',
            'users',
            'user-permissions',
        ];
    }

    public static function isRoleHasRightToAccess(string $userRole, string $routeName): bool
    {
        try {
            $model = static::where('role', $userRole)
                ->where('route_name', $routeName)
                ->first();

            return (bool) $model;
        } catch (\Throwable $throwable) {
            return false;
        }
    }
}
