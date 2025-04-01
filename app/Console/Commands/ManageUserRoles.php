<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class ManageUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or remove roles from a user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = (string) $this->ask('enter the user email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found.');

            return;
        }

        $action = $this->choice('What action would you like to perform?', ['Add Role', 'Remove Role']);

        if ($action === 'Add Role') {
            $this->addRoleToUser($user);
        } else {
            $this->removeRoleFromUser($user);
        }
    }

    private function addRoleToUser(User $user): void
    {
        $roles = Role::pluck('name')->toArray();
        $role = $this->choice('select a role to add', $roles);

        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            $this->info("Role '{$role}'assigned to user '{$user->name}'.");
        } else {
            $this->info("User '{$user->name}' already has the role '{$role}'.");
        }
    }

    private function removeRoleFromUser(User $user): void
    {
        $roles = $user->roles()->pluck('name')->toArray();

        if (empty($roles)) {
            $this->info("User '{$user->name}' does not have any roles.");

            return;
        }

        $role = $this->choice('select a role to remove', $roles);

        if ($user->hasRole($role)) {
            $user->removeRole($role);
            $this->info("Role '{$role}'removed from user '{$user->name}'.");
        } else {
            $this->info("User '{$user->name}'does't have the role'{$role}'.");
        }
    }
}
