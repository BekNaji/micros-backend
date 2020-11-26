<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Action;
use App\Http\Controllers\Controller;
use Validator;

class ActionController extends Controller
{
	// get all actions data
    public function all(Request $request)
    {
    	$actions = Action::orderBy('id','DESC')->get();

        //dd(date('d.m.Y H:i:s',strtotime($actions[0]->created_date)));
    	$datas = [];

    	foreach ($actions as $action) {
    		$data = [
    			'id' => $action->id,
    			'name' => $action->category->name,
    			'comment' => $action->comment,
    			'type' => $action->category->type,
    			'date' => date('d.m.Y H:i:s',strtotime($action->created_date)),
    			'sum' => $action->sum,
    		];

    		array_push($datas,$data);
    	}
    	
    	return response()->json($datas);

    }

    // Income and Expense
    public function ie()
    {
        $actions = Action::orderBy('id','DESC')->get();

        $totalIncome = 0;

        $totalExpense = 0;

        foreach ($actions as $value) 
        {   
            $trim =  str_replace(' ','',$value->sum);

            // calculat total Income
            if($value->type == 'gain')
            {
                $totalIncome += $trim;
            }

            // calculate total Expense
            if($value->type == 'cost')
            {
                $totalExpense += $trim;
            }
            
        }

        return response()->json(['gain' => $totalIncome,'cost' => $totalExpense]);
        

        
    }

    // get category where type == gain
    public function gain(Request $request)
    {
    	$actions = Action::where('type','=','gain')->orderBy('id','DESC')->get();

    	$datas = [];

    	foreach ($actions as $action) {
    		$data = [
    			'id' => $action->id,
    			'name' => $action->category->name,
    			'comment' => $action->comment,
    			'type' => $action->category->type,
    			'date' => date('d.m.Y H:i:s',strtotime($action->created_date)),
    			'sum' => $action->sum,
    		];

    		array_push($datas,$data);
    	}
    	
    	return response()->json($datas);
    }

    // save action
    public function save(Request $request)
    {

        $validate = Validator::make($request->all(),
            [
            'category' => 'required',
            'comment' => 'max:255',
            'dateNow' => 'required',
            'sum' => 'required',
            'type' => 'required'
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->messages()]);
        }

        $action = new Action();
        $action->category_id = $request->category;
        $action->comment = $request->comment;
        $action->sum = $request->sum;
        $action->type = $request->type;
        $action->created_date = $request->dateNow;
        $action->save();

        return ['success'=>'Saved'];

    }

    // update action according to id
    public function update(Request $request)
    {
        //return $request->comment;
        
        $validate = Validator::make($request->all(),
            [
            'category' => 'required',
            'comment' => 'max:255',
            'dateNow' => 'required',
            'sum' => 'required',
            'type' => 'required'
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->messages()]);
        }

        $action = Action::find($request->id);
        $action->category_id = $request->category;
        $action->comment = $request->comment;
        $action->sum = $request->sum;
        $action->type = $request->type;
        $action->created_date = $request->dateNow;
        $action->save();

        return ['success'=>'Saved'];

    }

    // get one action 
    public function get(Request $request)
    {
        $action = Action::find($request->id);

        $data = [
            'id'        => $action->id,
            'category'  =>$action->category_id,
            'comment'   =>$action->comment,
            'sum'       =>$action->sum,
            'type'      =>$action->type,
            'dateNow'   =>$action->created_date,
        ];

        return response()->json($data);
    }

    public function delete(Request $request)
    {
        $action = Action::find($request->id);

        $action->delete();

        return response()->json(['message'=>'Deleted!']);
    }
}
