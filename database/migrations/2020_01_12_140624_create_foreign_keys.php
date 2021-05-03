<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('quiz_id')->references('id')->on('quizzes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('choices', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('quiz_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('quiz_user', function (Blueprint $table) {
            $table->foreign('quiz_id')->references('id')->on('quizzes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->foreign('quiz_user_id')->references('id')->on('quiz_user')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quizzes', function(Blueprint $table) {
			$table->dropForeign('quizzes_user_id_foreign');
        });
        
        Schema::table('questions', function(Blueprint $table) {
			$table->dropForeign('questions_quiz_id_foreign');
        });
        
        Schema::table('choices', function(Blueprint $table) {
			$table->dropForeign('choices_question_id_foreign');
        });
        
        Schema::table('quiz_user', function(Blueprint $table) {
			$table->dropForeign('quiz_user_user_id_foreign');
        });
        
        Schema::table('quiz_user', function(Blueprint $table) {
			$table->dropForeign('quiz_user_quiz_id_foreign');
        });
        
        Schema::table('answers', function(Blueprint $table) {
			$table->dropForeign('answers_quiz_user_id_foreign');
		});
    }
}
