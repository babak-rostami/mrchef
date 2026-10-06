@extends('layouts.app')

@section('title', 'ویرایش نظر')

@push('styles')
    @vite(['resources/css/component/ckeditor/index.css'])
@endpush

@section('content')

    <x-partials.breadcrumb panel="admin" page="ویرایش نظر" :parents="[['url' => route('admin.comments.index'), 'title' => 'مدیریت نظرات']]" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">ویرایش نظر</h3>
        </div>

        <div class="bg-gray-50 rounded-2xl p-4 mb-6">
            <span class="font-bold block mb-1">متن اصلی کاربر ({{ $comment->user->name ?? 'کاربر حذف‌شده' }}):</span>
            <p class="whitespace-pre-line text-gray-700">{{ $comment->body }}</p>
        </div>

        <div class="flex justify-center">
            <form id="comment-update-form" action="{{ route('admin.comments.update', $comment->id) }}" method="POST"
                class="w-full space-y-6">
                @csrf
                @method('PUT')

                {{-- content CKEDITOR --}}
                <x-form.edit.ckeditor title="نمایش ویرایش‌شده" name="content" id="content"
                    placeholder="اگه لازمه، متن نظر رو اینجا ویرایش کن (می‌تونی عکس اضافه کنی یا بولدش کنی)"
                    msg="اگه این فیلد خالی بمونه، همون متن اصلی کاربر نمایش داده میشه" :value="$comment->content" />

                {{-- SUBMIT --}}
                <x-form.edit.submit title="ثبت تغییرات نظر" />

            </form>
        </div>

    </div>

@endsection

@push('scripts')
    @vite(['resources/js/comment/edit.js'])
@endpush