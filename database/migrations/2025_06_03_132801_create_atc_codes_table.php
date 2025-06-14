<?php

use App\Enums\ActiveStatus;
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
        Schema::create('atc_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable(); // For hierarchical structure
            $table->string('name');
            $table->string('code')->unique(); // e.g., "A02BC02"
            $table->tinyInteger('level'); // 1 (Anatomical) to 5 (Chemical)
            $table->string('slug')->unique(); // Unique slug for URL usage
            $table->string('status')->default(ActiveStatus::Active->value);

            // Additional fields can be added as needed
            $table->text('description')->nullable(); // Optional description field            
            $table->string('created_by')->nullable(); // Track who created the record
            $table->string('updated_by')->nullable(); // Track who last updated the record
            $table->string('deleted_by')->nullable(); // Track who deleted the record, if applicable
            $table->softDeletes(); // Soft delete support
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atc_codes');
    }
};
