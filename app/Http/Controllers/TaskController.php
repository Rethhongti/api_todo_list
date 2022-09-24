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
        $task = Task::orderBy('created_at','desc')->get();

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
            'todo' => 'string|required|unique:tasks,todo',
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

        $task = Task::orderBy('created_at','desc')->get();

        return $this->successResponse($task);
    }

    public function update(Request $request)
    {
        $task = Task::find($request->id);

        $task->todo = $request->task;
        $task->isCompleted = $request->isCompleted;
        $task->save();

        $result = Task::orderBy('created_at','desc')->get();
        
        return $this->successResponse($result);
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

        $result = Task::orderBy('created_at','desc')->get();

        return $this->successResponse($result);
    }

    public function show($keyword = null){
        // dd($keyword);
        if($keyword != null || $keyword != ''){
            $searchTask = Task::query()->where('todo','LIKE',"{$keyword}%")->orderBy('created_at','desc')->get();

            return $this->successResponse(TaskResource::collection($searchTask));
        }else{
            $result = Task::orderBy('created_at','desc')->get();
            return $this->successResponse(TaskResource::collection($result));
        }
        
        return $this->errorResponse(null);
    }
}
