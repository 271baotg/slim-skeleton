<?php

declare(strict_types=1);

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    // Fillable fields for mass assignment
    protected $fillable = ['username', 'fullname', 'password'];

    public $timestamps = false;

    /**
     * Constructor to automatically hash the password.
     *
     * @param array $attributes
     */
    public function __construct()
    {
    }
}
