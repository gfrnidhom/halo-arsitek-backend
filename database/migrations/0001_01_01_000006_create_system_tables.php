<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key', 100)->unique();
            $table->text('value');
            $table->enum('type', ['STRING', 'NUMBER', 'JSON', 'BOOLEAN'])->default('STRING');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 50)->nullable();
            $table->text('message');
            $table->string('budget', 100)->nullable();
            $table->enum('status', ['UNREAD', 'READ', 'REPLIED', 'ARCHIVED'])->default('UNREAD');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('status');
            $table->index('created_at');
        });

        Schema::create('page_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('path', 255);
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('referrer', 500)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('created_at');
            $table->index('path');
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('action', 100);
            $table->text('details')->nullable();
            $table->string('admin_name', 255);
            $table->string('admin_role', 50);
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('action');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('page_views');
        Schema::dropIfExists('contact_submissions');
        Schema::dropIfExists('site_settings');
    }
};
