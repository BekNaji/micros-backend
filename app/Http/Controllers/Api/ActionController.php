<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Action;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Carbon;

class ActionController extends Controller
{

	// get all actions data
    public function all(Request $request)
    {
        
    	$actions = Action::orderBy('created_date','DESC')->get();

    	$datas = [];

    	foreach ($actions as $action) {
    		$data = [
    			'id'         => $action->id,
    			'name'       => $action->category->name,
    			'comment'    => $action->comment,
    			'type'       => $action->category->type,
    			'date'       => date('d.m.Y H:i:s',strtotime($action->created_date)),
    			'sum'        => $action->sum,
    		];

    		array_push($datas,$data);
    	}

        // get total expense and income
        $total = $this->ie($actions);
    	
    	return response()->json(['actions'=>$datas,'total'=>$total]);

    }

    // Income and Expense
    public function ie($query)
    {
        $actions = $query;

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
        $datas = ['gain' => $totalIncome,'cost' => $totalExpense];

        return $datas;
        
    }

    // save action
    public function save(Request $request)
    {

        $validate = Validator::make($request->all(),
            [
            'category'  => 'required',
            'comment'   => 'max:255',
            'dateNow'   => 'required',
            'sum'       => 'required',
            'type'      => 'required'
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->messages()]);
        }

        $action                 = new Action();
        $action->category_id    = $request->category;
        $action->comment        = $request->comment;
        $action->sum            = $request->sum;
        $action->type           = $request->type;

                                  // 20-11-29 T07:43:00 to  20-11-29 07:43:00
        $action->created_date   = Carbon::parse($request->dateNow)->format('Y-m-d h:i:s');
        $action->save();

        return ['success'=>'Saved'];

    }

    // update action according to id
    public function update(Request $request)
    {
        
        $validate = Validator::make($request->all(),
            [
            'category'      => 'required',
            'comment'       => 'max:255',
            'dateNow'       => 'required',
            'sum'           => 'required',
            'type'          => 'required'
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->messages()]);
        }

        $action = Action::find($request->id);
        $action->category_id    = $request->category;
        $action->comment        = $request->comment;
        $action->sum            = $request->sum;
        $action->type           = $request->type;

                                 // 20-11-29 T07:43:00 to  20-11-29 07:43:00
        $action->created_date   = Carbon::parse($request->dateNow)->format('Y-m-d h:i:s');
        $action->save();

        return ['success'=>'Saved'];

    }

    // get one action 
    public function get(Request $request)
    {
        $action = Action::find($request->id);

        $data = [
            'id'                => $action->id,
            'category'          => $action->category_id,
            'category_name'     => $action->category->name,
            'comment'           => $action->comment,
            'sum'               => $action->sum,
            'type'              => $action->type,
            'dateNow'           => Carbon::parse($action->created_date)->format('Y-m-d\Th:i'),
        ];

        return response()->json($data);
    }

    // make filter
    public function filter(Request $request)
    {

        // convert to special date type
        $to   = Carbon::parse($request->to.' 23:59:59')->format('Y-m-d H:i:s');

        // query 
        $actions = Action::orderBy('created_date','DESC')->where('created_date','<=',$to);

        if($request->from != '')
        {
            // convert to special date type 
            $from = Carbon::parse($request->from.' 00:00:00')->format('Y-m-d H:i:s');
            $actions->where('created_date','>=',$from);

        }
                        
        if($request->type != 'All')
        {   
            $actions->where('type','=',$request->type);
        }

        if($request->status != 'All')
        {   
            $actions->where('category_id','=',$request->status);
        }

        $actions = $actions->get();


        $datas = [];

        foreach ($actions as $action) {
            $data = [
                'id'         => $action->id,
                'name'       => $action->category->name,
                'comment'    => $action->comment,
                'type'       => $action->type,
                'date'       => date('d.m.Y H:i:s',strtotime($action->created_date)),
                'sum'        => $action->sum,
            ];

            array_push($datas,$data);
        }

        // get total expense and income
        $total = $this->ie($actions);

        return response()->json(['actions'=>$datas,'total'=>$total]);
    }

    // delete
    public function delete(Request $request)
    {
        $action = Action::find($request->id);

        $action->delete();

        return response()->json(['message'=>'Deleted!']);
    }
}
