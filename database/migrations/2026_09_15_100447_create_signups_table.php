<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signups', function (Blueprint $table) {
            $table->id();
            $table->string("First_name");
            $table->string("Last_name"); 
            $table->string("email")->unique();
            $table->string("password"); 
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signups');
    }
};
