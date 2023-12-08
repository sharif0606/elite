<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock\Requisition;

class DashboardController extends Controller
{
    /*
    * admin dashboard
    */
    public function index(){
        return view('dashboard.superadmin');
    }
    /*
    * admin dashboard
    */
    public function adminDashboard(){
        return view('dashboard.admin');
    }

    /*
    * owner dashboard
    */
    public function userDashboard(){
        return view('dashboard.user');
    }

    /*
    * sales manager dashboard
    */
    public function salesexecutiveDashboard (){
        return view('dashboard.salesexecutive');
    }

    /*
    * sales man dashboard
    */
    public function salesmanDashboard(){
        return view('dasbhoard.salesman');
    }
}
