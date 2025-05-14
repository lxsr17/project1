<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_owner_id')->constrained('store_owners')->onDelete('cascade');

            // بيانات أساسية
            $table->string('business_name')->nullable();
            $table->string('business_type')->nullable();
    
            // بيانات التواصل
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
    
            // سياسة الاسترجاع
            $table->text('return_policy')->nullable();
            $table->boolean('no_return_allowed')->default(false);
            $table->unsignedInteger('return_days')->default(0);
            $table->unsignedInteger('exchange_days')->default(0);
    
            // روابط تواصل
            $table->string('twitter')->nullable();
            $table->boolean('show_twitter')->default(false);
            $table->string('instagram')->nullable();
            $table->boolean('show_instagram')->default(false);
            $table->string('tiktok')->nullable();
            $table->boolean('show_tiktok')->default(false);
    
            // روابط المنصات
            $table->string('website')->nullable();
            $table->string('android_app')->nullable();
            $table->string('ios_app')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
    
            // معلومات إضافية
            $table->string('business_name_ar')->nullable();
            $table->string('business_name_en')->nullable();
            $table->string('main_category')->nullable();
            $table->string('sub_category')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
    
            // إضافة الحقول الجديدة
            $table->string('commercial_registration_document')->nullable(); // السجل التجاري
            $table->string('freelancer_document')->nullable(); // وثيقة العمل الحر
    
            // الحالة
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
    
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
