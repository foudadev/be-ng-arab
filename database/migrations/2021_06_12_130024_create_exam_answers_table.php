<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamAnswersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('exam_id')->nullable();
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreignUuid('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreignUuid('answer_id')->nullable();
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->integer('points')->default(0);
            $table->boolean('used_hint')->default(0);
            $table->boolean('skipped')->default(0);
            $table->boolean('skipped_replacment')->default(0);
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
        Schema::dropIfExists('exam_answers');
    }

}
