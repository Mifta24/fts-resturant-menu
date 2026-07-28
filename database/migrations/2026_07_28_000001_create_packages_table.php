<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->decimal('monthly_price', 12, 2)->default(0);
            $table->decimal('yearly_price', 12, 2)->nullable();
            $table->unsignedInteger('menu_limit')->nullable();
            $table->unsignedInteger('category_limit')->nullable();
            $table->unsignedInteger('storage_limit_mb')->default(50);
            $table->unsignedInteger('team_limit')->default(1);
            $table->boolean('has_statistics')->default(false);
            $table->boolean('has_custom_theme')->default(false);
            $table->boolean('remove_branding')->default(false);
            $table->unsignedInteger('language_limit')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
