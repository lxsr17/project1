<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Facades\Session;
use App\Models\Store;

class BusinessController extends Controller
{
    public function storeStep1(Request $request)
    {
        $storeOwner = Auth::guard('store_owner')->user();

        if (!$storeOwner) {
            return redirect()->route('store_owner.login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $existingCount = Business::where('store_owner_id', $storeOwner->id)->count();
        if ($existingCount >= 4) {
            return redirect()->route('my-businesses')->with('error', 'لا يمكنك إضافة أكثر من 4 أعمال.');
        }

        $request->validate([
            'businessNameAr' => 'required|string|max:255',
            'businessNameEn' => 'required|string|max:255',
            'mainCategory' => 'required|string|max:100',
            'subCategory' => 'nullable|string|max:100',
            'customSubCategory' => 'nullable|string|max:100',
            'businessDescription' => 'required|string',
            'businessLogo' => 'nullable|image|max:2048',
            'linkType' => 'required|in:commercial,freelance,later',
            'commercialRegistry' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'freelanceDoc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $finalSubCategory = $request->subCategory === 'other' ? $request->customSubCategory : $request->subCategory;

        $logoPath = null;
        if ($request->hasFile('businessLogo')) {
            $logoPath = $request->file('businessLogo')->store('business_logos', 'public');
        }

        $freelancerDocument = null;
        $commercialDocument = null;

        if ($request->hasFile('commercialRegistry')) {
            $commercialDocument = $request->file('commercialRegistry')->store('commercial_docs', 'public');
        }

        if ($request->hasFile('freelanceDoc')) {
            $freelancerDocument = $request->file('freelanceDoc')->store('freelance_docs', 'public');
        }

        $business = Business::create([
            'store_owner_id' => $storeOwner->id,
            'business_name' => $request->businessNameAr . ' / ' . $request->businessNameEn,
            'business_type' => $request->mainCategory . ' - ' . $finalSubCategory,
            'description' => $request->businessDescription,
            'status' => 'draft',
            'logo' => $logoPath,
            'freelancer_document' => $freelancerDocument,
            'commercial_registration_document' => $commercialDocument,
            'link_type' => $request->linkType,
        ]);

        Session::put('business_id', $business->id);

        return redirect()->route('business-contact')->with('success', 'تم حفظ بيانات العمل بنجاح.');
    }

    public function storeContact(Request $request)
{
    $request->validate([
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:10',
        'city' => 'required|string|max:255',
        'customerServicePhone' => 'nullable|string|max:10',
        'showPhone' => 'nullable|boolean',
    ]);

    $businessId = session('business_id');

    if (!$businessId) {
        return redirect()->route('business-contact')->with('error', 'لم يتم بدء عملية إضافة العمل');
    }

    $business = Business::findOrFail($businessId);

    $business->email = $request->input('email');
    $business->phone1 = $request->input('phone'); // حفظ رقم الجوال الأساسي في phone1
    $business->phone2 = $request->input('customerServicePhone'); // حفظ رقم خدمة العملاء في phone2
    $business->city = $request->input('city');
    $business->address = ''; // لو تبي تضيفه لاحقًا
    $business->save();

    return redirect()->route('business-policies')->with('success', 'تم حفظ بيانات التواصل بنجاح.');
}


    // باقي الميثودات بدون تغيير
    public function storePolicies(Request $request)
    {
        $request->validate([
            'returnPolicy' => 'required_if:noReturn,false|string|nullable',
            'noReturn' => 'nullable|boolean',
            'returnDays' => 'required_if:noReturn,false|integer|min:0',
            'exchangeDays' => 'required_if:noReturn,false|integer|min:0',
        ], [
            'returnPolicy.required_if' => 'يرجى إدخال سياسة الاسترجاع أو تحديد "لا يمكن الاسترجاع".',
            'returnDays.required_if' => 'يرجى تحديد عدد أيام الاسترجاع.',
            'exchangeDays.required_if' => 'يرجى تحديد عدد أيام الاستبدال.',
        ]);

        $businessId = session('business_id');
        if (!$businessId) {
            return redirect()->route('business-additional')->with('error', 'لم يتم بدء عملية إضافة العمل');
        }

        $business = Business::findOrFail($businessId);

        $business->update([
            'return_policy' => $request->noReturn ? 'لا يمكن الاستبدال والاسترجاع وفقاً لطبيعة المنتج أو الخدمة المقدمة' : $request->returnPolicy,
            'no_return_allowed' => $request->has('noReturn'),
            'return_days' => $request->returnDays ?? 0,
            'exchange_days' => $request->exchangeDays ?? 0,
        ]);

        return redirect()->route('business-additional')->with('success', 'تم حفظ سياسة الاسترجاع بنجاح');
    }

    public function storeAdditional(Request $request)
    {
        $request->validate([
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'website' => 'required|url',
            'androidApp' => 'nullable|url',
            'iosApp' => 'nullable|url',
            'whatsapp' => 'required|url',
            'telegram' => 'nullable|url',
            'showTwitter' => 'nullable|boolean',
            'showInstagram' => 'nullable|boolean',
            'showTiktok' => 'nullable|boolean',
        ]);

        $businessId = session('business_id');
        if (!$businessId) {
            return redirect()->route('business-additional')->with('error', 'لم يتم بدء عملية إضافة العمل');
        }

        $business = Business::findOrFail($businessId);

        $business->update([
            'twitter' => $request->twitter,
            'show_twitter' => $request->has('showTwitter'),
            'instagram' => $request->instagram,
            'show_instagram' => $request->has('showInstagram'),
            'tiktok' => $request->tiktok,
            'show_tiktok' => $request->has('showTiktok'),
            'website' => $request->website,
            'android_app' => $request->androidApp,
            'ios_app' => $request->iosApp,
            'whatsapp' => $request->whatsapp,
            'telegram' => $request->telegram,
        ]);

        return redirect()->route('business-review')->with('success', 'تم حفظ البيانات الإضافية بنجاح');
    }

    public function review()
    {
        $businessId = session('business_id');

        if (!$businessId) {
            return redirect()->route('business-additional')->with('error', 'لم يتم بدء عملية إضافة العمل');
        }

        $business = Business::with('storeOwner')->findOrFail($businessId);

        $names = explode(' / ', $business->business_name);
        $business->name_ar = $names[0] ?? '';
        $business->name_en = $names[1] ?? '';

        $types = explode(' - ', $business->business_type);
        $business->main_category = $types[0] ?? '';
        $business->sub_category = $types[1] ?? '';

        return view('main.business-review', compact('business'));
    }

    public function storeContactInfo(Request $request)
    {
        $request->validate([
            'phone1' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
        ]);

        $businessId = session('business_id');

        if (!$businessId) {
            return redirect()->route('business-additional')->with('error', 'لم يتم بدء عملية إضافة العمل');
        }

        $business = Business::findOrFail($businessId);

        $business->update([
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'email' => $request->email,
            'city' => $request->city,
            'address' => $request->address,
        ]);

        return redirect()->route('business-policies')->with('success', 'تم حفظ بيانات التواصل بنجاح');
    }

    public function submit()
    {
        $businessId = session('business_id');

        if (!$businessId) {
            return redirect()->route('business-success');
        }

        $business = Business::findOrFail($businessId);

        $business->update([
            'status' => 'pending'
        ]);

        session()->forget('business_id');

        return redirect()->route('business-success')->with('success', 'تم تقديم العمل بنجاح!');
    }

    public function index(Request $request)
    {
        $stores = Store::latest()->paginate(12);

        if ($request->has('q')) {
            $searchQuery = $request->input('q');
            $stores = Store::where('business_name', 'LIKE', "%$searchQuery%")
                ->orWhere('store_number', 'LIKE', "%$searchQuery%")
                ->latest()
                ->paginate(12);
        }

        $stores_page = view('main.stores', compact('stores'));
        $stores_login_marchent_page = view('main.stores_login_Marchent', compact('stores'));

        return $stores_page->with('stores', $stores)->render() . $stores_login_marchent_page->with('stores', $stores)->render();
    }

    public function myBusinesses()
    {
        $storeOwner = Auth::guard('store_owner')->user();

        if (!$storeOwner) {
            return redirect()->route('merchant.login')->with('error', 'يجب تسجيل الدخول');
        }

        $businesses = Business::where('store_owner_id', $storeOwner->id)->get();

        return view('main.my-businesses', compact('businesses'));
    }

    public function edit($id)
    {
        $storeOwner = auth('store_owner')->user();
        $business = Business::findOrFail($id);

        if ($business->store_owner_id !== $storeOwner->id) {
            abort(403, 'غير مصرح لك');
        }

        $names = explode(' / ', $business->business_name);
        $types = explode(' - ', $business->business_type);

        $business->name_ar = $names[0] ?? '';
        $business->name_en = $names[1] ?? '';
        $business->main_category = $types[0] ?? '';
        $business->sub_category = $types[1] ?? '';

        return view('main.edit-business', compact('business'));
    }

    public function update(Request $request, $id)
    {
        $storeOwner = auth('store_owner')->user();
        $business = Business::findOrFail($id);

        if ($business->store_owner_id !== $storeOwner->id) {
            abort(403);
        }

        $request->validate([
            'businessNameAr' => 'required|string|max:255',
            'businessNameEn' => 'required|string|max:255',
            'mainCategory' => 'required|string|max:100',
            'subCategory' => 'nullable|string|max:100',
            'customSubCategory' => 'nullable|string|max:100',
            'businessDescription' => 'required|string',
            'businessLogo' => 'nullable|image|max:2048',
        ]);

        $finalSubCategory = $request->subCategory === 'other'
            ? $request->customSubCategory
            : $request->subCategory;

        $logoPath = $business->logo;
        if ($request->hasFile('businessLogo')) {
            $logoPath = $request->file('businessLogo')->store('business_logos', 'public');
        }

        $business->update([
            'business_name' => $request->businessNameAr . ' / ' . $request->businessNameEn,
            'business_type' => $request->mainCategory . ' - ' . $finalSubCategory,
            'description' => $request->businessDescription,
            'logo' => $logoPath,
        ]);

        return redirect()->route('my-businesses')->with('success', 'تم تحديث بيانات العمل بنجاح.');
    }

    public function destroy($id)
    {
        $storeOwner = auth('store_owner')->user();
        $business = Business::findOrFail($id);

        if ($business->store_owner_id !== $storeOwner->id) {
            abort(403, 'غير مصرح لك بحذف هذا المتجر.');
        }

        $business->delete();

        return redirect()->route('my-businesses')->with('success', 'تم حذف المتجر بنجاح.');
    }
}
