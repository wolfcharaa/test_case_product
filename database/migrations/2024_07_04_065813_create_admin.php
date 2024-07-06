<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        \Illuminate\Support\Facades\Artisan::call('orchid:admin admin admin@admin.com admin');
        \Illuminate\Support\Facades\Artisan::call('db:seed');
    }

    public function down(): void
    {
        User::query()->where('name', 'admin')->forceDelete();
    }
};
