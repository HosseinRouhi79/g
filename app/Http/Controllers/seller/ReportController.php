<?php

namespace App\Http\Controllers\seller;

use App\Enums\OrderStatus;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $restaurant = Restaurant::where('user_id',$user->id)->first();
        $orders = Order::where([['status','=',OrderStatus::DONE]
        ,['restaurant_id','=',$restaurant->id]])->get();

        return view('seller.sellerReport',compact('orders','user'));
    }

    public function export()
    {
        return Excel::download(new OrdersExport(), 'orders.xlsx');
    }
}
