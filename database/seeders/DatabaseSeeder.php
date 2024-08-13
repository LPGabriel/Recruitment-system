<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use function Sentry\captureException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleSuper = Role::create(['name' => 'super-admin']);
        $roleCompany = Role::create(['name' => 'company']);
        $roleCandidate = Role::create(['name' => 'candidate']);
        $roleRecruiter = Role::create(['name' => 'recruiter']);

        $roles = Role::all();

        try {
            foreach ($roles as $role) {
                $type = 'undefined';

                switch ($role->name) {
                    case 'admin':
                    case 'super-admin':
                    case 'recruiter':
                        $type = 'internal';
                        break;
                    case 'candidate':
                        $type = 'candidate';
                        break;
                    case 'company':
                        $type = 'company';
                        break;
                }

                $user = User::factory()->create([
                    'name' => $role->name,
                    'type' => $type,
                    'email' => $role->name . '@rhcontratapa.com.br',
                    'email_verified_at' => date(now()),
                ]);

                $user->assignRole($role);

                if ($type == 'candidate') {
                    $this->createCandidate($user, $type);
                }
            }
        } catch (\Exception $e) {
            echo "Error: {$e->getMessage()}";
            captureException($e);
        }
    }

    public function createCandidate($user, $type)
    {
        try {
            if ($type == 'candidate') {
                $candidate = $user->candidate()->create([
                    'display_name' => $user->name,
                ]);

                $candidate->update([
                    'slug' => Str::slug($user->name . " " . $candidate->id),
                ]);
            }
        } catch (Exception $e) {
            dd($e);
            captureException($e);
        }
        return $user->candidate;
    }
}
