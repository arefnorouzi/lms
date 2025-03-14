@extends('layouts.Admin')
@section('title', 'افزودن برند')
@section('content')

    <section class="my-5">
        @if(session()->has('message') || session()->has('error'))
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        @endif

        <div class="card shadow">
            <div class="card-header d-flex">
                <h4>ثبت دسته جدید</h4>
                <a href="{{route('admin.category.index')}}" class="btn btn-sm btn-primary me-auto">بازگشت</a>

            </div>
            <div class="card-body">
                <form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8 mb-2">
                            <label class="form-label">نام دسته </label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-control" required>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">دسته والد</label>
                            <select name="parent_id" class="form-select">
                                <option value="{{null}}">انتخاب دسته والد</option>
                                @foreach($categories as $cat)
                                    <option class="parent-category" value="{{$cat->id}}">
                                        {{$cat->name}}
                                    </option>
                                    @foreach($cat->children as $child)
                                        <option class="child-category" value="{{$child->id}}">
                                            -- {{$child->name}}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('parent_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">تصویر (اختیاری)</label>
                            <input type="file" accept="image/png, image/jpg, image/jpeg" class="form-control" name="image" value="{{old('image')}}">
                            @error('image') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">نمایش در صفحه اصلی</label>
                            <select name="home_page" class="form-select">
                                <option value="0">عدم نمایش</option>
                                <option value="1">نمایش در صفحه اصلی</option>
                            </select>
                            @error('home_page') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">توضیحات کوتاه</label>
                            <input  name="meta" value="{{old('meta')}}" class="form-control" minlength="5" maxlength="157">
                            @error('meta') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="col-lg-12">
                                <label class="form-label">توضیحات کامل</label>
                                <textarea id="editor" rows="5" name="description" class="form-control">{{old('description')}}</textarea>
                                @error('description') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-12 text-center my-3">
                            <button class="btn btn-primary" type="submit">ثبت اطلاعات</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>


@endsection

@section('script')


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote({

                height: 400,
            });
        });
    </script>
@endsection
