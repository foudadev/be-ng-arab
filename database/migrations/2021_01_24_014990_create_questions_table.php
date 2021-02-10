<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('question');
            $table->enum('level',['junior','mid-senior','senior', 'expert'])->default('junior');
            $table->enum('status',['active', 'inactive'])->default('active');
            $table->foreignUuid('user_id')->nullable();
            $table->foreignUuid('question_category_id');
            $table->text('resource_link')->nullable();
            $table->text('hint')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_category_id')->references('id')->on('question_categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('questions');
        Schema::enableForeignKeyConstraints();
    }
}
