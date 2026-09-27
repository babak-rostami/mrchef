<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $unreadMessagesCount = Contact::where('is_read', false)->count();

        return view('admin.dashboard.index', compact('unreadMessagesCount'));
    }
}
