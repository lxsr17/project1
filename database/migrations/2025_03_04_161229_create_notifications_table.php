<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receiver_id');
            $table->enum('receiver_type', ['User', 'StoreOwner']);
            $table->foreignId('sender_admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->text('message');
            $table->timestamp('date')->useCurrent();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
