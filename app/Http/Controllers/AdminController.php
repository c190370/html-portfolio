<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('admin');
  }

  public function index(Request $request)
  {
    $input = $request->input;
    $customers = DB::table('customers')
    ->join('users', 'customers.user_id', '=', 'users.id')
    ->orderBy('customers.id')
    ->get();

    $data = [
      'customers'=>$customers,
    ];
    return view('admin.index', ['data'=>$data, 'input'=>$input]);
  }
}
