<?php

use App\Models\Appoinment;
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
        Schema::create('appointments_family', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // allows null user_id
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // ensure doctor exists
            $table->foreignId('available_timeslot_id')->constrained('available_timeslots')->onDelete('cascade'); // timeslot FK
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->text('notes')->nullable(); // optional notes
            $table->string('status_appoinment')->default(Appoinment::CHO_XAC_NHAN);
            $table->string('status_payment_method')->default(Appoinment::CHUA_THANH_TOAN);
            $table->enum('gender', ['Nam', 'Nữ', 'Khác'])->nullable();
            $table->year('year_of_birth'); // year field for birth year
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments_family');
    }
};
