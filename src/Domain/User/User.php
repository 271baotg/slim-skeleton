<?php

declare(strict_types=1);

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="User",
 *     description="A simple user model."
 * )
 */
class User extends Model
{
    protected $table = 'users';

    // Fillable fields for mass assignment
    protected $fillable = ['username', 'fullname', 'password'];

    public $timestamps = false;

    /**
     * @OA\Property(type="string", example="johndoe", description="Username of the user.")
     */
    private $username;

    /**
     * @OA\Property(type="string", example="John Doe", description="Full name of the user.")
     */
    private $fullname;

    /**
     * @OA\Property(type="string", format="password", example="securepassword", description="User's password.")
     */
    private $password;

    /**
     * Constructor to automatically hash the password.
     *
     * @param array $attributes
     */
    public function __construct()
    {
    }
}
