<?php

namespace App\Services;


use App\Models\User;

class UserService
{

    /**
     * Create user
     * @param array $data
     */
    public function createUser(array $data)
    {
        return User::create($data);
    }
    /** Update user
     * @param User $user, array $data
     */
    public function updateUser(User $user, array $data)
    {
        // $movie = Movie::findOrFail($movie->i/d); // Find the movie or fail with a 404 error

        $user->update($data);
        return $user;
    }
    /** delete user
     * @param User $user
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        User::resetAutoIncrement();
        return $user;
    }
}
