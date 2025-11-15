@extends('layouts.app')

@section('title', 'دسته بندی ها')

@section('content')

    <div class="container">

        <!-- Title + Create Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">مدیریت دسته‌بندی‌ها</h3>
            <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="fa fa-plus ms-1"></i> دسته‌بندی جدید
            </button>
        </div>

        <!-- Modal Create -->
        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-4 shadow">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">ایجاد دسته‌بندی جدید</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">نام دسته‌بندی</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">نام انگلیسی دسته‌بندی</label>
                                    <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}"
                                        required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">توضیحات</label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">دسته‌بندی پدر</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">بدون دسته پدر</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">تصویر</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>

                                <div class="col-12 mt-3 text-end">
                                    <button type="submit" class="btn btn-success px-4">ثبت دسته‌بندی</button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <!-- Categories List -->
        <div class="card rounded-4 shadow-sm mt-4">
            <div class="card-body">

                @if ($categories->count() == 0)

                    <div class="text-center py-5">
                        <img src="{{ asset('files/icon/empty-list.png') }}" class="mb-3">
                        <h5 class="text-muted">هیچ دسته‌بندی‌ای یافت نشد</h5>
                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                            ایجاد اولین دسته‌بندی
                        </button>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach ($categories as $category)
                            <div class="col-md-6 col-lg-4">
                                <div class="border rounded-4 p-3 h-100 d-flex flex-column shadow-sm bg-white">

                                    <!-- Image + title -->
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $category->thumb_url }}" class="rounded"
                                            style="width:60px; height:60px; object-fit:cover;">
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-0">{{ $category->name }}</h6>
                                            <small class="text-muted">{{ $category->name_en }}</small>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="d-flex justify-content-center mt-3">

                                        {{-- <a href="{{ route('category.show', $category->id) }}" --}}
                                        <a href="" class="btn btn-sm btn-primary">
                                            مشاهده
                                        </a>

                                        <a class="btn btn-sm btn-warning mx-2" href="{{ route('category.edit', $category->slug) }}">
                                            ویرایش
                                        </a>

                                        {{-- <form action="{{ route('category.destroy', $category->id) }}" method="POST" --}}
                                        <form action="" method="POST" onsubmit="return confirm('حذف شود؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">حذف</button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                @endif

            </div>
        </div>

    </div>

@endsection
