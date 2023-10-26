<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateEnrollmentTable extends Migration
{
   public function up()
   {
      Schema::create('state_enrollments', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->string('name');
         $table->tinyInteger('state');
         $table->tinyInteger('delete_moodle');
         //
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('state_enrollments');
   }
}