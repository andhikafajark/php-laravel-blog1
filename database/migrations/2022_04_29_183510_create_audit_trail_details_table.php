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
    public function up(): void
    {
        Schema::create('audit_trail_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_trail_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('category')->nullable();
            $table->string('action')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trail_details');
    }
};
