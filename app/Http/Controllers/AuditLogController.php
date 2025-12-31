<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:audit-view', ['only' => ['index']]);
    }

    public function index()
    {
        $logs = AuditLog::latest()->paginate(25);
        return view('admin.audit_logs.index', compact('logs'));
    }
}
