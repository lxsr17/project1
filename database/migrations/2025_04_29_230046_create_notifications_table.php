<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // الأعمدة الجديدة
            $table->bigInteger('receiver_id')->unsigned()->nullable()->after('id');
            $table->string('receiver_type')->nullable()->after('receiver_id');
            $table->bigInteger('sender_admin_id')->unsigned()->nullable()->after('receiver_type');
            $table->string('link')->nullable()->after('message');
            $table->timestamp('date')->nullable()->after('link');
            $table->enum('type', ['alert', 'announcement', 'warning'])->default('alert')->after('message');
            $table->enum('target', ['all', 'merchant', 'visitor', 'specific'])->default('all')->after('type');
            $table->bigInteger('target_id')->unsigned()->nullable()->after('target');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // إزالة الأعمدة المضافة
            $table->dropColumn('receiver_id');
            $table->dropColumn('receiver_type');
            $table->dropColumn('sender_admin_id');
            $table->dropColumn('link');
            $table->dropColumn('date');
            $table->dropColumn('type');
            $table->dropColumn('target');
            $table->dropColumn('target_id');
        });
    }
};
