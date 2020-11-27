<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends Controller
{
    public function all()
    {
        $category = Category::orderBy('id','DESC')->get();

        return response()->json($category);
    }

    public function save(Request $request)
    {
        //return response()->json($request);
        $validate = Validator::make($request->all(),[
            'name' => 'required|max:50',
            'type' => 'required',
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->messages()]);
        }
        $category = new Category();
        $category->name = $request->name;
        $category->type = $request->type;
        $category->save();

        return response()->json(['success'=>'Saved']);
    }

    public function update(Request $request)
    {
        //return response()->json($request);
        $validate = Validator::make($request->all(),[
            'name' => 'required|max:50',
            'type' => 'required',
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->messages()]);
        }
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->type = $request->type;
        $category->save();

        return response()->json(['success'=>'Updated']);
    }

    public function get(Request $request)
    {
    	$category = Category::find($request->id);
    	

    	return response()->json($category);
    }

    public function getGain(Request $request)
    {
    	$category = Category::where('type','=','gain')->orderBy('name')->get();

        return response()->json($category);
    }

    public function getCost(Request $request)
    {
        $category = Category::where('type','=','cost')->orderBy('name')->get();

        return response()->json($category);
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();

        return response()->json(['success'=>'Deleted!']);
    }
}
