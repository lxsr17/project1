<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authentication', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade');
            $table->foreignId('store_owner_id')->nullable()->constrained('store_owners')->onDelete('cascade');
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('auth_id', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authentication');
    }
};
