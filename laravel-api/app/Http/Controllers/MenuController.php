<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\cr_menu;

class MenuController extends Controller
{
    public function index()
    {
        $menu = cr_menu::orderBy('hirarki', 'asc')->get();
        return ['status' => true, 'data' => $menu];
    }
}
