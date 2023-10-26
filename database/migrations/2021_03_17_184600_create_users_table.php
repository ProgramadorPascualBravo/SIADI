<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('document')->unique();
            $table->string('username')->unique();
            $table->string('password', 250);
            $table->string('confirmation_code', 250);
            $table->string('verified', 1)->default(0);
            $table->timestamp('email_verified_at')->nullable(true);
            $table->smallInteger('state')->default(1);
            $table->foreignId('department_id');
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
