<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Choice;
use App\Events\QuizCreated;
use App\Events\QcmAnswered;
use App\Events\NotifAnswer;
use App\Notifications\InvoicePaid;
use App\Question;
use App\Quiz;
use App\QuizUser;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Events\UnreadNotifAnswer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (Auth::check()) {

            return view('home');

        } else {
            return view('welcome');
        }

    }

    public function fetchQuizzes()
    {
        //$quizzes = Quiz::with('questions.choices')->get();
        $authId = Auth::id();
        $group = Auth::user()->group;
        $quizzes = Quiz::where('group', $group)->get();
        foreach ($quizzes as $key => $quiz) {
            $quizUser = QuizUser::where([
                'quiz_id' => $quiz->id,
                'user_id' => $authId,

            ])->first();
            $note = $quizUser ? $quizUser->note : null;
            $quiz->setAttribute("note",$note);
        }
        return response()->json($quizzes);
    }

    public function fetchQuizz_user()
    {
        //$quizzes = Quiz::with('questions.choices')->get();

        $id = Auth::id();
        $quiz_user = QuizUser::where('user_id', $id)->pluck('quiz_id');
        return response()->json($quiz_user);

    }

    public function fetchQuiz($quizId)
    {
        $questions = Question::where('quiz_id', $quizId)->with('choices')->withCount(['choices as correct_choices_count' => function ($query) {
            $query->where('is_correct', 1);

        }])->get();
        return response()->json($questions);
    }


   
    public function createQuiz(Request $request)
    {
        $quiz = Quiz::create([
            'user_id' => Auth::id(),
            'timer' => $request->timer,
            'title' => $request->quizTitle,
            'group' => $request->group,
        ]);

        foreach ($request->questions as $key => $question) {
            $newQuestion = Question::create([
                'quiz_id' => $quiz->id,
                'text' => $question['text'],  
                
                'image'=>array_key_exists('image', $question)? $question['image']:null,
                             
            ]);

            foreach ($question['choices'] as $key => $choice) {
                Choice::create([
                    'question_id' => $newQuestion->id,
                    'text' => $choice['text'],
                    'is_correct' => $choice['isCorrect'],
                    'point' => $choice['point'],
                ]);
            }
        }
        $quiz->delete();
             
        foreach ($quiz->questions as $key => $question) {
            $question->choices;
        }

        event(new QuizCreated($quiz));

        
        return response()->json("quiz created");
    }

    public function fetchMyQuizzes()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $quizzes=$user->quizzes()->withTrashed()->get();

        foreach ($quizzes as $key => $quiz) {

        $deleted = $quiz->deleted_at ? true : false;
            $quiz->setAttribute("deleted",$deleted);
        }

        return response()->json($quizzes);
    }
    public function callQuiz(Request $request)
    {
        Quiz::where('id', $request->quizId)->restore();
        $quiz = Quiz::find($request->quizId );
        
        

        event(new QuizCreated($quiz));
        event(new QcmAnswered());

        $users = User::where('group', $request->group)->get();
        foreach ($users as $key => $user) {
            $user->notify(new InvoicePaid($quiz->user->name,$quiz->title));
        }

        event(new NotifAnswer($user->readnotifications,$user->unreadnotifications));



        return response()->json("nice");
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

    public function deleteQuiz(Request $request)
    {
        $quiz = Quiz::find($request->Quiz_Id);
        $quiz->forceDelete();

        return response()->json("Quiz deleted");
    }

    public function addstudent(Request $request)
    {
        // this is called mass assign
        $user = User::create([
            'name' => $request->name,
            'group' => $request->group,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // $user = new User();
        // $user->name =$request->name;
        // $user->group =$request->group;
        // $user->email =$request->email;
        // $user->password =Hash::make($request->password);
        // $user->save();

        return response()->json($user);
    }

    public function sendAnswers(Request $request)
    {
        $quizUser = QuizUser::create([
            'quiz_id' => $request->quiz_id,
            'user_id' => Auth::id(),
            'note' => $request->note,
        ]);

        foreach ($request->questions as $key => $question) {
            foreach ($question['choices'] as $key => $choice) {
                if (array_key_exists('isChosen', $choice)) {
                    if ($choice['isChosen']) {
                        Answer::create([
                            'question_id' => $question['id'],
                            'quiz_user_id' => $quizUser->id,
                            'choice_id' => $choice['id'],
                        ]);
                    }

                }
            }
        }

        

        $user_name = User::where('id', Auth::id())->first()->name;

        $user_id = Quiz::where('id', $request->quiz_id)->first()->user_id;
        $user = User::find($user_id);
        $qcm_name = Quiz::where('id', $request->quiz_id)->first()->title;

        $user->notify(new InvoicePaid($user_name,$qcm_name ));
        
        
        
        event(new NotifAnswer($user->readnotifications,$user->unreadnotifications));

        return response()->json("answer Created");
    }

    public function fetchAnswers()
    {
        //$quizzes = Quiz::with('questions.choices')->get();
        // $user_id=Auth::id();

        $answers = Answer::select('user_name', 'group')->get();
        // $data = collect($answers->toArray())->flatten()->all(); ?

        return response()->json($answers);
    }

    public function fetchQuiz_res($answer_rep)
    {
        $quiz_id = Answer::where('user_name', $answer_rep)->first()->quiz_id;
        $questions = Questiona::where('quiz_id', $quiz_id)->with('answers')->get();
        return response()->json($questions);
    }

    // public function fetchAnswer($answer_rep)
    // {
    //   $answers= Answer::where('user_name', $answer_rep)->get();

    //     return response()->json($answers);
    // }

    public function markasread(Request $request)
    {
        $notification = auth()->user()->notifications()->find($request->notif_id);
        if ($notification) {
            $notification->markAsRead();
            
  
        }
        $user_id = Auth::id();
        $user = User::find($user_id);

        //  event(new NotifAnswer($user->readnotifications,$user->unreadnotifications));
        


        return response()->json(" nice");
    }

    public function formSubmit(Request $request)
    {
        // $request->validate([
        //     'image' => 'required|file|max:1024',
        // ]);

        // $filenametft=  $request->image->getClientOriginalName();
        // $fileName = pathinfo( $filenametft, PATHINFO_FILENAME);
        // $extension =  $request->image->getClientOriginalExtension();
        // $filenametostore= $fileName.'_'.time().'.'.$extension;
        // $path =  $request->image->storeAs('',$filenametostore,'public');
        // return response()->json( url('storage/'.$path));
 
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->storeAs('public/questions', $imageName);
        return response()->json(['realPath' => url('/storage/questions/'.$imageName), 'image' => '/storage/questions/'.$imageName]);
        
        
     }

     public function uncallQuiz(Request $request)
    {
        
        $quiz = Quiz::find($request->quizId );
        
        event(new QuizCreated($quiz));
        event(new QcmAnswered());
        Quiz::where('id', $request->quizId)->delete();

        return response()->json("nice");
    }

   

}
