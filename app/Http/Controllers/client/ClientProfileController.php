<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientProfileController extends Controller // Update the class name
{
    public function show_profile()
    {
        // جلب بيانات المستخدم المُسجل
        $client = Auth::guard('client')->user();

        // عرض صفحة البروفايل مع تمرير البيانات
        return view('client.client_profile', compact('client'));
    }
}
