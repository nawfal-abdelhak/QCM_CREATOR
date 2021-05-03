<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Answer;
use App\Choice;
use Carbon\Carbon;
use App\Events\QuizCreated;
use App\Events\QcmAnswered;
use App\Events\NotifAnswer;
use App\Notifications\InvoicePaid;
use App\Question;
use App\Quiz;
use App\QuizUser;
use App\User;
use Auth;

use Illuminate\Support\Facades\Hash;
use App\Events\UnreadNotifAnswer;

class ApiController extends Controller
{
    public function userauth() {
        return response()->json("test");
    }


    public function fetchQuizUsers($quizId)
    {
        $quizUsers = QuizUser::where('quiz_id', $quizId)->with('user')->get();
        foreach ($quizUsers as $key => $quizUser) {
            $questions = $quizUser->quiz->questions;
            foreach ($questions as $key => $question) {
                foreach ($question->choices as $key => $choice) {
                    $answer = Answer::where('quiz_user_id', $quizUser->id)->where('question_id', $question->id)->where('choice_id', $choice->id)->first();
                    $choice->setAttribute('is_chosen', $answer != null);
                }
            }
        }
        return response()->json($quizUsers);
    }



    public function fetchMyQuizzes()
    {
        $user_id = 1;
        $user = User::find($user_id);
        $quizzes=$user->quizzes()->withTrashed()->get();

        foreach ($quizzes as $key => $quiz) {

        $deleted = $quiz->deleted_at ? true : false;
            $quiz->setAttribute("deleted",$deleted);
        }

        return response()->json($quizzes);
    }

    public function receiveData(Request $request) {
        $quiz = Quiz::create([
            'user_id' => 1,
            'timer' => $request->qcm['timer'],
            'title' => $request->qcm['title'],
            'group' => $request->qcm['group'],
        ]);

        foreach ($request->qcm['question'] as $key => $question) {
            $newQuestion = Question::create([
                'quiz_id' => $quiz->id,
                'text' => $question['questiontitle'],

                'image'=>array_key_exists('image', $question)? $question['image']:null,




            ]);

            foreach ($question['choice'] as $key => $choice) {
                Choice::create([
                    'question_id' => $newQuestion->id,
                    'text' => $choice['choicetext'],
                    'is_correct' => $choice['iscorrect'],
                    'point' => $choice['point'],
                ]);
            }
        }


        return response()->json($request);
    }

// tokens log


    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            //'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'fName' => 'required|string',
            'lName' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);
        $user = new User;
        $user->first_name = $request->fName;
        $user->last_name = $request->lName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

}
