<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TodoListResource;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = TodoList::orderBy('id', 'desc')->paginate(9);
        return response()->json($lists, 200);
        // return response([ 'lists' => TodoListResource::collection($lists), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $list = TodoList::create($data);

        return response(['list' => new TodoListResource($list), 'message' => 'Created successfully'], 201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function show($todoList)
    {
        try {
            $list=ToDoList::findOrFail($todoList);
            return response(['list' => new TodoListResource($list), 'message' => 'Retrieved successfully'], 200);
       } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

           $response['status'] = 'error';
           $response['message'] = 'No data found by ID '.$todoList;
           return response()->json($response, 404);
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $todoList = ToDoList::find($id);
        $todoList->update($request->all());

        return response(['list' => new TodoListResource($todoList), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy($todoList)
    {
        try {
            ToDoList::findOrFail($todoList)->delete();
            $response['status'] = 'successfull';
            $response['message'] = 'List deleted successfully';
            return response()->json($response, 200);
       } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

           $response['status'] = 'error';
           $response['message'] = 'No data found by ID '.$todoList;
           return response()->json($response, 404);
       }
    }

    public function search(Request $request){
        $title=$request->search;
        
        $lists=ToDoList::where('title','LIKE','%'.$title.'%')->orderBy('id', 'desc')->paginate(9);
        return response()->json($lists, 200);
    }
}
