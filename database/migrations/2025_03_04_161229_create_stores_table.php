<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('store_owners')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('store_name', 100);
            $table->text('description');
            $table->enum('verification_status', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->float('rating')->default(0);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->string('image_url', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
