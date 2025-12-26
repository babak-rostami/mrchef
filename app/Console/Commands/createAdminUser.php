<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class createAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create An Admin User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Enter admin email');
        // اگر قبلاً با این ایمیل کاربر وجود داشته باشد
        $user = User::where('email', $email)->first();
        if ($user) {
            if ($user->hasRole('admin')) {
                $this->error('User already has admin role.');
                return 1;
            } else {
                $user->assignRole('admin');
                $this->info("Admin Role Added");
                return 0;
            }
        }
        $password = $this->secret('Enter admin password');
        $user = User::factory()
            ->admin()
            ->create([
                'email' => $email,
                'password' => Hash::make($password),
            ]);

        $this->info("Admin user created: {$user->email}");
        return 0;
    }
}
