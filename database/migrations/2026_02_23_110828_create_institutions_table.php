<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['school', 'kindergarten', 'agency', 'prep_center']);
            $table->string('name');
            $table->string('slug')->unique();

            $table->string('city')->index();
            $table->string('address')->nullable();
            $table->string('work_hours')->nullable();

            $table->enum('format', ['offline', 'online', 'hybrid'])->default('offline');

            $table->integer('price_month')->nullable();

            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            $table->json('languages')->nullable();
            $table->json('photos')->nullable();

            $table->boolean('status')->default(true)->index();
            $table->boolean('featured')->default(false)->index();

            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website')->nullable();

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
