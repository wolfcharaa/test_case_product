<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create((new \App\Models\Category())->getTable(), static function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
        });

        Schema::create((new \App\Models\Picture())->getTable(), static function(Blueprint $table): void {
            $table->id();
            $table->text('base64_image');
        });

        Schema::create((new \App\Models\Product())->getTable(), static function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->uuid('sku')->index();
            $table->string('name')->index();
            $table->unsignedSmallInteger('count');
            $table->foreignId('picture_id')
                ->nullable()
                ->constrained((new \App\Models\Picture())->getTable());
            $table->foreignId('type_product')
                ->nullable()
                ->constrained((new \App\Models\Category())->getTable())
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists((new \App\Models\Product())->getTable());
        Schema::dropIfExists((new \App\Models\Category())->getTable());
    }
};
