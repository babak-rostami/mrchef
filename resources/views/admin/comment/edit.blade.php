@extends('layouts.app')

@section('title', 'ویرایش نظر')

@push('styles')
    @vite(['resources/css/component/ckeditor/index.css'])
@endpush

@section('content')

    <x-partials.breadcrumb panel="admin" page="ویرایش {{ $comment->isReply() ? 'پاسخ' : 'نظر' }}" :parents="[['url' => route('admin.comments.index'), 'title' => 'مدیریت نظرات']]" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش {{ $comment->isReply() ? 'پاسخ' : 'نظر' }}</h3>
        </div>

        <div class="flex justify-center">
            <form id="comment-update-form" action="{{ route('admin.comments.update', $comment->id) }}" method="POST"
                class="w-full space-y-6">
                @csrf
                @method('PUT')

                {{-- متن ساده — همیشه قابل ویرایشه، هم برای نظر اصلی هم پاسخ --}}
                <x-form.edit.textarea title="متن ساده" name="body" id="body" placeholder="متن نظر یا پاسخ" :required="true"
                    :roles="['min-len' => 1]" :value="$comment->body" />

                @unless ($comment->isReply())
                    {{-- محتوای ادیتور — فقط برای نظر اصلی؛ پاسخ‌ها اصلاً ادیتور ندارن --}}
                    <x-form.edit.ckeditor title="نمایش ویرایش‌شده (اختیاری)" name="content" id="content"
                        placeholder="اگه لازمه، نسخه‌ی خاصی از این نظر رو اینجا بساز (می‌تونی عکس اضافه کنی یا بولدش کنی)"
                        msg="اگه این فیلد خالی بمونه، همون متن ساده‌ی بالا نمایش داده میشه" :value="$comment->content" />
                @endunless

                {{-- SUBMIT --}}
                <x-form.edit.submit title="ثبت تغییرات" />

            </form>
        </div>

    </div>

@endsection

@push('scripts')
    @vite(['resources/js/comment/edit.js'])
@endpush