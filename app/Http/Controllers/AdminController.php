<?php

namespace App\Http\Controllers;

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
        return view('admin.orders-management');
    }

    public function inventoryManagement()
    {
        return view('admin.inventory-management');
    }
}
