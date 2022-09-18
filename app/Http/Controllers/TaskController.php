<?php

namespace App\Http\Controllers;

use App\Models\Task;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Validator;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $task = Task::orderBy('created_at','desc')->get();
        $task = DB::select('select * from tasks ORDER BY created_at DESC');

        return $this->successResponse(TaskResource::collection($task));
        // return $this->successResponse($task);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = [
            'todo' => 'string|required',
            'isCompleted' => 'required'
        ];

        $validate = Validator::make($request->all(), $validator);

        if ($validate->fails()) {
            return $this->errorResponse(null);
        }

        Task::create([
            'todo' => $request->todo,
            'isCompleted' => $request->isCompleted
        ]);

        return $this->successResponse("Created Successfully");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        $task->todo = $request->task;
        $task->isCompleted = $request->isCompleted;
        $task->save();
        
        return $this->successResponse("Update Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return $this->successResponse("Delete Successfully");
    }

    public function search($keyword){
        if($keyword != null){
            $searchTask = Task::query()->where('todo','LIKE',"{$keyword}")->get();

            return $this->successResponse(TaskResource::collection($searchTask));
        }
        
        return $this->errorResponse(null);
    }
}
