<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = Contact::orderBy('created_at', 'desc')->get();

        // با باز شدن این صفحه، پیام‌های دیده‌نشده خونده‌شده علامت می‌خورن
        Contact::where('is_read', false)->update(['is_read' => true]);

        return view('admin.contact.index', compact('messages'));
    }

    public function destroy($id)
    {
        $message = Contact::find($id);

        if (!$message) {
            return back()->with('error', 'پیام پیدا نشد');
        }

        $message->delete();

        return back()->with('success', 'پیام با موفقیت حذف شد');
    }
}
