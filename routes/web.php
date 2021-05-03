<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);


Route::middleware('auth')->group(function () {  

  // Route::post('/{any}', 'HomeController@notif')->where('any', '.*');
  
  Route::get('fetchQuizzes', 'HomeController@fetchQuizzes');
  Route::get('fetchQuiz/{quizId}', 'HomeController@fetchQuiz');
  Route::get('fetchMyQuizzes', 'HomeController@fetchMyQuizzes');
  Route::post('callQuiz', 'HomeController@callQuiz');
  Route::get('fetchQuizUsers/{quizId}', 'HomeController@fetchQuizUsers');
  Route::post('createQuiz', 'HomeController@createQuiz');
  Route::post('deleteQuiz', 'HomeController@deleteQuiz');
  Route::post('addstudent', 'HomeController@addstudent');
  Route::post('markasread', 'HomeController@markasread');
  Route::post('sendAnswers', 'HomeController@sendAnswers');
  Route::get('fetchAnswers', 'HomeController@fetchAnswers');
  Route::get('fetchQuiz_res/{answer_rep}', 'HomeController@fetchQuiz_res');
  Route::get('fetchAnswer/{answer_rep}', 'HomeController@fetchAnswer');

  Route::get('fetchQuizz_user', 'HomeController@fetchQuizz_user');
  Route::get('getnote/{quiz_id}', 'HomeController@getnote');

  Route::post('uncallQuiz', 'HomeController@uncallQuiz');


  Route::post('formSubmit', 'HomeController@formSubmit');

});

Route::get('/{any}', 'HomeController@index')->where('any', '.*');

