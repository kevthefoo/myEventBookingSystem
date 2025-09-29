<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('event_category', 'category_event');
    }

    public function down(): void
    {
        Schema::rename('category_event', 'event_category');
    }
};