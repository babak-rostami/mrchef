@extends('layouts.app')

@section('title', 'مدیریت نظرات')

@section('content')

    <x-partials.breadcrumb panel="admin" page="مدیریت نظرات" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44 mb-20">

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">مدیریت نظرات</h3>
        </div>

        @if ($comments->count() == 0)
            <div class="flex flex-col items-center py-10 mb-32">
                <img src="{{ config('images.ftp_path') . '/files/icon/empty-list.png' }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هنوز نظری ثبت نشده</h5>
            </div>
        @else
            <x-partials.table.index id="comments" :columns="[
                    ['key' => 'id', 'label' => 'id', 'sortable' => true],
                    ['key' => 'user', 'label' => 'کاربر', 'view' => 'admin.comment.part.table.user'],
                    ['key' => 'body', 'label' => 'متن', 'searchable' => true, 'view' => 'admin.comment.part.table.body'],
                    ['key' => 'status', 'label' => 'وضعیت', 'view' => 'admin.comment.part.table.status'],
                    ['key' => 'created_at', 'label' => 'تاریخ', 'sortable' => true],
                    ['key' => 'actions', 'label' => '#', 'view' => 'admin.comment.part.table.actions'],
                ]" :rows="$comments" />
        @endif

    </div>

@endsection