<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Factory as ValidatorFactory;

class CreateCustomUser extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Create a new custom user';

    public function __construct(protected ValidatorFactory $validator)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $email = $this->ask('Enter email');
        $this->info('Entered Email: ' . $email);
        $password = $this->secret('Enter password');
        $name = $this->ask('Enter name');

        $data = [
            'email'    => $email,
            'password' => $password,
            'name'     => $name,
        ];

        $rules = [
            'email'    => 'required|email',
            'password' => 'required|min:8',
            'name'     => 'required|string|max:255|',
        ];

        $validator = $this->validator->make($data, $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::create([
            'email'    => $email,
            'password' => Hash::make($password),
            'name'     => $name,
        ]);

        $this->info('User created successfully.');

        return self::SUCCESS;
    }
}
