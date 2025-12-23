<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Starting debug...\n";

try {
    if (!Schema::hasTable('medical_records')) {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->index(); // Removed constraints to avoid issues
            $table->foreignId('doctor_id')->index();
            $table->date('visit_date');
            $table->text('chief_complaint');
            $table->text('history_of_present_illness');
            $table->text('vital_signs')->nullable();
            $table->text('examination_findings');
            $table->text('diagnosis');
            $table->text('treatment_plan');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
        echo "Table 'medical_records' created successfully.\n";
    } else {
        echo "Table 'medical_records' already exists.\n";
    }

    $migrationName = '2025_12_23_171420_create_medical_records_table';
    $exists = \DB::table('migrations')->where('migration', $migrationName)->exists();
    
    if (!$exists) {
        \DB::table('migrations')->insert([
            'migration' => $migrationName,
            'batch' => 99, // Arbitrary high batch number
        ]);
        echo "Migration record inserted.\n";
    } else {
        echo "Migration record already exists.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
