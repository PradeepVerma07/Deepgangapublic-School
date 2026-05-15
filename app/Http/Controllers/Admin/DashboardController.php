<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use Illuminate\Http\Request;

class DashboardController extends MainController
{
    public function index()
    {
        $page='admin.dashboard';
        $title='Admin Dashboard';
        return $this->template($page,compact('title'));
    }
}
