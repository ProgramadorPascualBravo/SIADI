<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnrollmentsMoodle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('enrollments_moodle', function (Blueprint $table) {
          $table->id();
          $table->string('code', 100);
          $table->string('email', 200);
          $table->string('rol', 100);
          $table->foreignId('enrollment_id');
          $table->foreign('email')->references('email')->on('students');
          $table->foreign('code')->references('code')->on('groups');
          $table->foreign('enrollment_id')->references('id')->on('enrollments');
          $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('enrollments_moodle');
    }
}
