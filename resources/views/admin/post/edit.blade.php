@extends('layouts.Admin')
@section('title', 'ویرایش مقاله')
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
                <h4>ویرایش: {{$post->name}}</h4>
                <a href="{{route('admin.product.index')}}" class="btn btn-sm btn-primary me-auto">بازگشت</a>

            </div>
            <div class="card-body">
                <form action="{{route('admin.post.update', $post->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">عنوان </label>
                            <input type="text" name="name" value="{{$post->name}}" class="form-control" required>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">زیرعنوان </label>
                            <input type="text" name="subtitle" value="{{$post->subtitle}}" class="form-control">
                            @error('subtitle') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-2 mb-2">
                            <label class="form-label">دسته بندی</label>
                            <select name="category_id" class="form-select">
                                <option value="{{null}}">انتخاب دسته محصول</option>
                                @foreach($categories as $category)
                                    <option class="parent-category" value="{{$category->id}}"
                                            @if($post->category_id == $category->id) selected @endif>
                                        {{$category->name}}
                                    </option>
                                    @foreach($category->children as $child)
                                        <option class="child-category" value="{{$child->id}}" @if($post->category_id == $child->id) selected @endif>
                                            -- {{$child->name}}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('category_id') <span class="error">{{ $message }}</span> @enderror
                        </div>


                        <div class="col-md-2 mb-2">
                            <label class="form-label">تصویر (اختیاری)</label>
                            <input type="file" accept="image/png, image/jpg, image/jpeg" class="form-control" name="image">
                            @error('image') <span class="error">{{ $message }}</span> @enderror

                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">توضیحات کوتاه</label>
                            <input  name="meta" value="{{$post->meta}}" class="form-control" minlength="5" maxlength="157">
                            @error('meta') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="col-lg-12">
                                <label class="form-label">توضیحات کامل</label>
                                <textarea id="editor" rows="5" name="description" class="form-control">{!! $post->description !!}</textarea>
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


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote({
                tabsize: 2,
                height: 500,
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImage(files[0]);
                    }
                }
            });

            function uploadImage(file) {
                let data = new FormData();
                data.append("image", file);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('admin.upload_image')}}",
                    type: "POST",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#editor').summernote('insertImage', response.url);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection
