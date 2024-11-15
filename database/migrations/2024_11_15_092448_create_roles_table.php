<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Manager, Employee
            $table->timestamps();
        });

        // Seed default roles
        DB::table('roles')->insert([
            ['name' => 'Manager'],
            ['name' => 'Employee'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
