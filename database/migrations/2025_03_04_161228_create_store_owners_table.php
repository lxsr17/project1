<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('store_owners', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->date('birthdate');
            $table->string('phone', 20);
            $table->enum('sex', ['Male', 'Female']);
            $table->string('city', 50);
            $table->string('state', 50);
            $table->string('street', 100);
            $table->string('neighborhood', 100);

            // ✅ إضافة عمود الحالة (active, suspended)
            $table->enum('status', ['active', 'suspended'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_owners');
    }
};
