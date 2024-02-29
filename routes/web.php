<?php

use App\Events\Hello;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('test',[\App\Http\Controllers\Test::class,'index']);

    /*$request->validate([
        'search' => 'required|string|min:255',
    ]);


    $a =  $request->search;

    \DB::table('sql_inj')->insert(['name'=>$a]);


    echo     \DB::table('sql_inj')->where('id',8)->first()->name;




});*/

Route::get('/', function () {




   // broadcast(new Hello());
    //\DB::table('test')->where('text','farhan')->get();



    /*$batch = [];
    for ($i=1;$i <= 100000;$i++) {


        $batch[] = [
            'title' => 'dummy title of dummy title',
            'text' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
        ];

        if(count($batch)==500){
            \DB::table('test')->insert($batch);
            $batch = [];
        }
    }*/

    //return view('welcome');
});

