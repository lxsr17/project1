<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم النشاط
            $table->string('owner_name'); // اسم المالك
            $table->string('email')->unique(); // البريد الإلكتروني
            $table->string('phone')->nullable(); // رقم الهاتف
            $table->text('description')->nullable(); // وصف النشاط
            $table->string('category'); // الفئة (مطاعم، تقنية، خدمات، إلخ)
            $table->string('location')->nullable(); // الموقع
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};
