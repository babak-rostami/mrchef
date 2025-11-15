@extends('layouts.app')

@section('title', 'ویرایش دسته بندی')

@section('content')

    <div class="container">

        <!-- Title + Create Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">ویرایش دسته‌بندی {{ $category->name }}</h3>
        </div>


        <!-- Categories List -->
        <div class="card rounded-4 shadow-sm mt-4">
            <div class="card-body">

                <div class="row justify-content-center">
                    <div class="col-md-10 col-12">
                        <form action="{{ route('category.update', $category->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="row g-3">
                                <div class="col-12 text-center">
                                    <img src="{{ $category->thumb_url }}" alt="{{ $category->name }}"
                                        style="width: 100px; max-height: 100px;border-radius: 8px">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">نام دسته‌بندی</label>
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">نام انگلیسی دسته‌بندی</label>
                                    <input type="text" name="name_en" class="form-control"
                                        value="{{ $category->name_en }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">توضیحات</label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ $category->description }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">دسته‌بندی پدر</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">بدون دسته پدر</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">تصویر</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <div class="col-12 mt-3 text-end">
                                    <button type="submit" class="btn btn-success mt-4 w-100">ثبت تغییرات</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
