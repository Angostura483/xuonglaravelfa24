<?php

use App\Models\Department;
use App\Models\Manager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150)->unique();
            $table->string('phone', 15);
            $table->date('date_of_birth');
            $table->dateTime('hire_date');
            $table->decimal('salary', 10, 2);
            $table->boolean('is_active');
            $table->foreignIdFor(Department::class)->constrained();
            $table->foreignIdFor(Manager::class)->constrained();
            $table->text('address');
            $table->binary('profile_picture');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
