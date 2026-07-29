<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 500)->index();
            $table->text('full_url')->nullable();
            $table->string('method', 10)->default('GET');
            $table->string('ip', 45)->nullable()->index();
            $table->string('session_id', 100)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->text('referer')->nullable();
            $table->string('referer_host', 255)->nullable()->index();
            $table->string('device', 20)->nullable()->index();
            $table->string('browser', 50)->nullable()->index();
            $table->string('platform', 50)->nullable()->index();
            $table->string('locale', 10)->nullable()->index();
            $table->string('utm_source', 100)->nullable()->index();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 150)->nullable();
            $table->boolean('is_bot')->default(false)->index();
            $table->timestamp('created_at')->useCurrent()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
