<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student')->index();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('level');
            $table->string('summary', 500);
            $table->text('description');
            $table->json('subjects')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('faculty', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('department');
            $table->text('biography');
            $table->string('image_url')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('excerpt', 500);
            $table->longText('body');
            $table->string('image_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('venue');
            $table->text('description');
            $table->timestamp('starts_at')->index();
            $table->timestamp('ends_at')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('caption');
            $table->string('category');
            $table->string('image_url');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category')->index();
            $table->string('title');
            $table->text('body');
            $table->string('status')->default('pending')->index();
            $table->boolean('is_anonymous')->default(true);
            $table->timestamps();
        });

        Schema::create('post_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('body');
            $table->string('status')->default('pending')->index();
            $table->timestamps();
        });

        Schema::create('post_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reason');
            $table->string('status')->default('pending')->index();
            $table->timestamps();
        });

        Schema::create('concern_reports', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('category')->index();
            $table->text('what_happened');
            $table->string('where_happened')->nullable();
            $table->dateTime('happened_at')->nullable();
            $table->text('people_involved')->nullable();
            $table->text('additional_details')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('submitted')->index();
            $table->boolean('is_anonymous')->default(true);
            $table->timestamps();
        });

        Schema::create('report_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concern_report_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
            $table->string('public_message')->nullable();
            $table->timestamps();
        });

        Schema::create('report_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concern_report_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_notes');
        Schema::dropIfExists('report_updates');
        Schema::dropIfExists('concern_reports');
        Schema::dropIfExists('post_reports');
        Schema::dropIfExists('post_replies');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('events');
        Schema::dropIfExists('news');
        Schema::dropIfExists('faculty');
        Schema::dropIfExists('programs');

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropColumn('role');
        });
    }
};