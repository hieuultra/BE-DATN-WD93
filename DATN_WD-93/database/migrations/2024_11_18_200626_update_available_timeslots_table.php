<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAvailableTimeslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('available_timeslots', function (Blueprint $table) {
            // Make doctor_id column nullable
            $table->unsignedBigInteger('doctor_id')->nullable()->change();
            
            // Add new nullable package_id column and set foreign key constraint
            $table->unsignedBigInteger('package_id')->nullable()->after('doctor_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('available_timeslots', function (Blueprint $table) {
            // Revert doctor_id to be non-nullable (if you need to)
            $table->unsignedBigInteger('doctor_id')->nullable(false)->change();
            
            // Drop the package_id column and foreign key constraint
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
}
