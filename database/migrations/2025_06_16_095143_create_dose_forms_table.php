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
        Schema::create('dose_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Tablet", "Syrup"
            $table->text('description')->nullable(); // Optional description field
            // $table->string('route_administration')->nullable(); // e.g., "Oral", "Topical"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dose_forms');
    }
};
