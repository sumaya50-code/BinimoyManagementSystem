<?php

namespace App\Http\Controllers;

use App\Models\NotificationLog;
use Illuminate\Http\Request;

class NotificationLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:notification-view', ['only' => ['index']]);
    }

    public function index()
    {
        $logs = NotificationLog::latest()->paginate(25);
        return view('admin.notification_logs.index', compact('logs'));
    }
}
