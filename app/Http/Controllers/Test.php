<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test as TModel;
class Test extends Controller
{
    public function index(Request $request)
    {

        $route = \Route::current();

        $permission = $route->getAction('permission');

        print_r($permission);


        // return view('test');
        /*$this->validate($request,[
                'search' => 'required|string',
        ]);

        $a =  $request->search;

        TModel::create(['name'=>$a]);*/

        /*$search = $request->validate(['name' => 'required|string']);

        TModel::create(htmlspecialchars($search));

         echo \DB::table('sql_inj')->where('id',43)->first()->name;*/
    }
}
