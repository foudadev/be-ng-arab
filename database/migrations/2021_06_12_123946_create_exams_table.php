<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('exams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignUuid('question_category_id');
            $table->foreign('question_category_id')->references('id')->on('question_categories')->onDelete('cascade');
            $table->enum('level', ['junior', 'mid-senior', 'senior', 'expert'])->default('junior');
            $table->enum('status', ['in_progress', 'done'])->default('in_progress');
            $table->time('answering_time')->nullable();
            $table->double('degree')->nullable();
            $table->integer('used_hint_count')->nullable();
            $table->integer('skipped_count')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('exams');
    }

}
