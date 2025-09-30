<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Service;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard()
    {
        return view('staff.dashboard');
    }

    public function customersManagement()
    {
        return view('staff.customers-management');
    }

    public function ordersManagement()
    {
        $services = Service::all();
        $customers = Customer::all();
        $items = Item::all();
        return view('staff.orders-management', compact('services', 'customers', 'items'));
    }
}
