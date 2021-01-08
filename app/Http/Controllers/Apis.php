<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;
use Validator;

class Apis extends Controller{
    public function register(Request $request){
        //Validate and register
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if($validator -> fails()){
            return response()->json($validator -> errors(), 202);
        }else{
            $input = $request -> all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            $responseArray = [];
            $responseArray['token'] = $user->createToken('MyApp')->accessToken;
            $responseArray['name'] = $user->name;

            return response()->json($responseArray, 200);

        }
    }
    public function login(Request $request){
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $responseArray = [];
            $responseArray['token'] = $user->createToken('MyApp')->accessToken;
            $responseArray['name'] = $user->name;

            return response()->json($responseArray,200);

        }else{

            return response()->json(['error'=>'Unauthenticated'],203);
        }
    }
    public function userlist(){
        $data['users'] = User::all();
        return response()->json( $data, 200);
    }
    public function addtask(Request $request){
        $validator = Validator::make($request->all(),[
            'task_name' => 'required',
            'completed' => 'required'
        ]);
        if($validator -> fails()){
            return response()->json($validator -> errors(), 202);
        }else{
            $task = new Task();
            $task->task_name = $request->task_name;
            $task->completed = $request->completed;
            $task->user_id = Auth::user()->id;
            $task->save();
            return response()->json(['Task' => 'Saved Successfully'], 200);
        }
    }
    public function autherror(){
        return response()->json(['error'=>'Unauthenticated'],203);
    }
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
