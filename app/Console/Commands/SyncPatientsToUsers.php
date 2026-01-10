<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncPatientsToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-patients-to-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create User accounts for existing Patients that do not have one';

    public function handle()
    {
        $patients = \App\Models\Patient::whereNull('user_id')->get();
        $count = 0;

        $this->info("Found {$patients->count()} patients without user accounts.");

        foreach ($patients as $patient) {
            $dduc_id = 'DDUC' . strtoupper($patient->card_number);
            
            // Check if user already exists with this DDUC ID to avoid duplicates
            $existingUser = \App\Models\User::where('dduc_id', $dduc_id)->first();
            
            if ($existingUser) {
                // Link to existing user
                $patient->user_id = $existingUser->id;
                $patient->save();
                $this->info("Linked Patient {$patient->full_name} to existing User {$dduc_id}");
            } else {
                // Create new user
                try {
                    $user = \App\Models\User::create([
                        'name' => $patient->full_name,
                        'dduc_id' => $dduc_id,
                        'password' => \Illuminate\Support\Facades\Hash::make('password'),
                        'role' => 'Patient',
                        'is_active' => true,
                    ]);

                    $patient->user_id = $user->id;
                    $patient->save();
                    $count++;
                    $this->info("Created User for Patient {$patient->full_name} ({$dduc_id})");
                } catch (\Exception $e) {
                    $this->error("Failed to create user for {$patient->full_name}: " . $e->getMessage());
                }
            }
        }

        $this->info("Sync complete. Created {$count} new user accounts.");
    }
}
