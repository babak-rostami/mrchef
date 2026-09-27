<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\contact\StoreRequest;
use App\Models\Contact;
use App\Support\Schema\PageSchema;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        $contactSchema = PageSchema::build('ContactPage', 'تماس با ما', route('contact.show'));

        return view('frontend.contact.show', compact('contactSchema'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        Contact::create([
            'name' => $data['name'],
            'body' => $data['body'],
        ]);

        return back()->with('success', 'پیام شما ارسال شد، به‌زودی بررسی می‌کنیم. ممنون از تماستون 🌹');
    }
}
