<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdminUser extends Command
{
    /**
     * Examples:
     *   php artisan user:make-admin someone@example.com
     *   php artisan user:make-admin new@example.com --create --password=Secret123
     */
    protected $signature = 'user:make-admin
                            {email : The email of the user to promote}
                            {--create : Create the user if it does not exist}
                            {--password= : Password to use when creating a new user}
                            {--name= : First name when creating a new user}';

    protected $description = 'Promote a user to admin (user_role=admin), optionally creating them.';

    public function handle(): int
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            if (! $this->option('create')) {
                $this->error("No user found with email {$email}. Pass --create to make one.");
                return self::FAILURE;
            }

            $password = $this->option('password') ?: 'Admin@123';
            $user = User::create([
                'first_name' => $this->option('name') ?: 'Admin',
                'last_name'  => 'User',
                'email'      => $email,
                'password'   => Hash::make($password),
                'is_active'  => true,
            ]);
            $this->info("Created new user {$email} with password: {$password}");
        }

        // user_role is intentionally not mass-assignable, so set it explicitly.
        $user->user_role = 'admin';
        $user->is_active = true;
        $user->save();

        $this->info("✓ {$email} is now an admin (user_role=admin).");
        return self::SUCCESS;
    }
}
