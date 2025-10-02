<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function userList()
    {
        return view('admin.user-list');
    }

    public function userManagement()
    {
        return view('admin.user-management');
    }

    public function customersManagement()
    {
        return view('admin.customers-management');
    }

    public function servicesManagement()
    {
        return view('admin.services-management');
    }

    public function ordersManagement()
    {
        $services = Service::all();
        $customers = Customer::all();
        $items = Item::all();
        return view('admin.orders-management', compact('services', 'customers', 'items'));
    }

    public function itemManagement()
    {
        return view('admin.item-management');
    }

    public function salesReport()
    {
        return view('admin.sales-report');
    }
}
