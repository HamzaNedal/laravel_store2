<?php

namespace App\Http\Controllers;

use App\Category;
use App\order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


    public function index(){

    $count_products=count(Product::all()->toArray());
    $count_users=count(User::all()->toArray());
    $count_orders=count(order::all()->toArray());
    $count_category=count(Category::all()->toArray());
    $count_messages=count(DB::table('messages')->get());
      return view('admin/Dashboard',compact('count_products','count_users','count_orders','count_category','count_messages'));


    }
}
