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
        Schema::create('farming_tools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('farmType');
            $table->string('farmActivity');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2);
            $table->string('costUnit');
            $table->string('vendor_id')->nullable(false)->constrained('vendor_users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farming_tools');
    }
};
