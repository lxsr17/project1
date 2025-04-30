@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('الملف الشخصي') }}</div>

                <div class="card-body">
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success" role="alert">
                            {{ __('تم تحديث الملف الشخصي بنجاح.') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row mb-3">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('الاسم الأول') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('الاسم الأخير') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->last_name) }}" required autocomplete="last_name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('البريد الإلكتروني') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('رقم الجوال') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="profile_image" class="col-md-4 col-form-label text-md-right">{{ __('الصورة الشخصية') }}</label>

                            <div class="col-md-6">
                                @if($user->profile_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->full_name }}" class="img-thumbnail" style="max-width: 100px;">
                                    </div>
                                @endif
                                <input id="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image">

                                @error('profile_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('حفظ التغييرات') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('حذف الحساب') }}</div>

                <div class="card-body">
                    <p>{{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائيًا. قبل حذف حسابك، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.') }}</p>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                        {{ __('حذف الحساب') }}
                    </button>

                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('profile.destroy') }}">
                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">{{ __('هل أنت متأكد من حذف حسابك؟') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p>{{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائيًا. الرجاء إدخال كلمة المرور الخاصة بك لتأكيد رغبتك في حذف حسابك نهائيًا.') }}</p>

                                        <div class="form-group">
                                            <label for="password" class="form-label">{{ __('كلمة المرور') }}</label>
                                            <input id="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" name="password" required>

                                            @error('password', 'userDeletion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                        <button type="submit" class="btn btn-danger">{{ __('حذف الحساب') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection