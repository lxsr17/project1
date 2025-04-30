<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'fullName' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^05[0-9]{8}$/',
            'email' => 'required|email',
            'reason' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            Mail::send([], [], function ($message) use ($data) {
                $message->to('raadal2000@gmail.com') // ← غيّرها لبريدك الفعلي
                    ->subject('رسالة جديدة من صفحة تواصل معنا')
                    ->setBody("
الاسم: {$data['fullName']}
البريد الإلكتروني: {$data['email']}
رقم الجوال: {$data['phone']}
سبب التواصل: {$data['reason']}

الرسالة:
{$data['message']}
                    ", 'text/plain');
            });

            return response()->json(['message' => 'تم إرسال الرسالة بنجاح'], 200);

        } catch (\Exception $e) {
            Log::error('فشل إرسال البريد: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء الإرسال.'], 500);
        }
    }
}
