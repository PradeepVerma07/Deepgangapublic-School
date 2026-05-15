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
        Schema::create('website_contents', function (Blueprint $table) {
            $table->id();
              $table->string('heading')->nullable();
            $table->text('content')->nullable();

            // ---------- Stats Section ----------
            $table->integer('total_courses')->nullable();
            $table->integer('total_students')->nullable();
            $table->integer('total_skills')->nullable();
            $table->integer('total_awards')->nullable();

            // ---------- Images ----------
            $table->string('background_image')->nullable();      // for header/background
            $table->string('about_image_1')->nullable();
            $table->string('about_image_2')->nullable();
            $table->string('about_image_3')->nullable();

            $table->string('why_choose_image')->nullable();
            $table->string('get_in_touch_image')->nullable();
            $table->string('how_to_apply_image')->nullable();
            $table->string('our_stars_image')->nullable();

            // ---------- Notice Section ----------
            $table->text('notice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_contents');
    }
};
