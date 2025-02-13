@extends('layouts.Admin')
@section('title', 'ویرایش محصول')
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
                <h4>ویرایش: {{$product->name}}</h4>
                <a href="{{route('admin.product.index')}}" class="btn btn-sm btn-primary me-auto">بازگشت</a>

            </div>
            <div class="card-body">
                <form action="{{route('admin.product.update', $product->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">عنوان </label>
                            <input type="text" name="name" value="{{$product->name}}" class="form-control" required>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">زیرعنوان </label>
                            <input type="text" name="subtitle" value="{{$product->subtitle}}" class="form-control">
                            @error('subtitle') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">قیمت </label>
                            <input type="number" name="price" value="{{$product->price}}" class="form-control"  required>
                            @error('price') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">موجودی </label>
                            <input type="number" name="stock" value="{{$product->stock}}" class="form-control" required>
                            @error('stock') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">دسته بندی</label>
                            <select name="category_id" class="form-select">
                                <option value="{{null}}">انتخاب دسته محصول</option>
                                @foreach($categories as $category)
                                    <option class="parent-category" value="{{$category->id}}"
                                            @if($product->category_id == $category->id) selected @endif>
                                        {{$category->name}}
                                    </option>
                                    @foreach($category->children as $child)
                                        <option class="child-category" value="{{$child->id}}" @if($product->category_id == $child->id) selected @endif>
                                            -- {{$child->name}}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('category_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">قیمت تخفیفی (اختیاری)</label>
                            <input type="number" min="0" class="form-control" name="offer_price" value="{{$product->offer_price}}">
                            @error('offer_price') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">انقضای قیمت تخفیف (اختیاری)</label>
                            <input type="date" id="offer_date" class="form-control" name="offer_end_date" value="{{$product->offer_end_date}}">
                            @error('offer_end_date') <span class="error">{{ $message }}</span> @enderror

                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">تصویر (اختیاری)</label>
                            <input type="file" accept="image/png, image/jpg, image/jpeg" class="form-control" name="image">
                            @error('image') <span class="error">{{ $message }}</span> @enderror

                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">توضیحات کوتاه</label>
                            <input  name="meta" value="{{$product->meta}}" class="form-control" minlength="5" maxlength="157">
                            @error('meta') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="col-lg-12">
                                <label class="form-label">توضیحات کامل</label>
                                <textarea id="editor" rows="5" name="description" class="form-control">{!! $product->description !!}</textarea>
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
                tabsize: 2,
                height: 400,
            });
        });
    </script>
@endsection
