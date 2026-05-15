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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->string('title')->nullable();
            $table->text('message');
            $table->enum('type', ['info', 'success', 'warning', 'danger'])->default('info');
            $table->boolean('dismissible')->default(true);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('seq')->default(0);
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['school_id', 'active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
