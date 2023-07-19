<?php
namespace App\Model;

class User
{
    const userRole = 'User';
    const adminRole = 'Admin';

    public string $username;
    public string $role;
}
