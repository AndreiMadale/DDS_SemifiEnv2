<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use App\Models\UserJob;
use DB;


Class UserController extends Controller {
   use ApiResponse;

 private $request;


 public function __construct(Request $request){
    $this->request = $request;
 }
 public function getUsers(){
    
   $users = DB :: connection('mysql')
   ->select("Select * from users");

   // return response()->json($users,200);
   return $this->successResponse($users);
  }
  public function index() {

   $users = User::all();
       return $this->successResponse($users);

  }
  public function add(Request $request) {

    $rules = [ 
      'username' => 'required|max:255',
      'password' => 'required|max:255',
      'jobid' => 'required|numeric|min:1|not_in:0'
    ];  

    $this->validate($request,$rules);

    $userjob = UserJob::findOrFail($request->jobid);

    $users = User ::create($request -> all());

    return $this->successResponse($users, Response::HTTP_CREATED);

  }

  public function show($id) {

    
     $users = User::where('id',$id) ->first(); 
    if ($users){
    return $this -> successResponse($users);
  }
  {
    return $this ->errorResponse('User ID does not exists', Response::HTTP_NOT_FOUND);
  }
}
public function update(Request $request,$id) {

  $rules = [ 
    'username' => 'max:255',
    'password' => 'max:255',
    'jobid' => 'required|numeric|min:1|not_in:0',
  ];  
  $this->validate($request, $rules);

  $userjob = UserJob::findOrFail($request->jobid);

   $users = User::where('id', $id)->first();
    if($users){
       $users->fill($request->all());

        if ($users->isClean()){
            return $this->errorResponse('Atleast one value must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
      $users->save();
       return $this->successResponse($users);
  }

    {
      return $this->errorResponse('User ID does not Exists', Response::HTTP_NOT_FOUND);
    }

  }
  public function delete($id){
    $users = User::where('id', $id)-> first();
    if($users) {
      $users->delete();
      return $this->successResponse($users);
    }
    {
      return$this->errorResponse('User ID does not Exists', Response::HTTP_NOT_FOUND);
    }
    

  }
}
