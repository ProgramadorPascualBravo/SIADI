<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('email', 200);
            $table->string('rol', 100);
            $table->smallInteger('state')->default(1);
            $table->string('period', 10);
            $table->foreign('email')->references('email')->on('students');
            $table->foreign('code')->references('code')->on('groups');
            $table->unique(['code', 'email', 'period']);
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
        Schema::dropIfExists('enrollment');
    }
}
