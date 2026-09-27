@extends('layouts.app')

@section('title', 'پیام‌های تماس با ما')

@section('content')

    <x-partials.breadcrumb panel="admin" page="پیام‌های تماس با ما" />

    <div class="px-3 md:p-0 md:mx-8 lg:mx-44 mb-20">

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">پیام‌های تماس با ما</h3>
        </div>

        @if ($messages->count() == 0)
            <div class="flex flex-col items-center py-10 mb-32">
                <img src="{{ config('images.ftp_path') . '/files/icon/empty-list.png' }}" class="w-28 mb-3 opacity-70">
                <h5 class="text-gray-500">هنوز پیامی دریافت نشده</h5>
            </div>
        @else
            <x-partials.table.index id="contacts" :columns="[
                    ['key' => 'id', 'label' => 'id', 'sortable' => true],
                    ['key' => 'status', 'label' => 'وضعیت', 'view' => 'admin.contact.part.table.status'],
                    ['key' => 'name', 'label' => 'نام', 'sortable' => true, 'searchable' => true],
                    ['key' => 'body', 'label' => 'متن پیام', 'searchable' => true, 'view' => 'admin.contact.part.table.body'],
                    ['key' => 'created_at', 'label' => 'تاریخ', 'sortable' => true],
                    ['key' => 'actions', 'label' => '#', 'view' => 'admin.contact.part.table.actions'],
                ]" :rows="$messages" />
        @endif

    </div>

@endsection