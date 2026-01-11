<?php

namespace App\Http\Controllers;

use App\Models\AdminLog;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function index()
    {
        return AdminLog::with('admin:id,name,email')
            ->latest()
            ->paginate(20);
    }
}
