@extends('layouts.sidebar')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}">
          <!-- サブカテゴリー表示 -->
          @foreach ($main_category->subCategories as $sub)
        <optgroup label="{{ $sub->sub_category }}">
          @endforeach
        </optgroup>
        @endforeach
      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <div class="">
        <p class="m-0">メインカテゴリー</p>
        <input type="text" class="w-100" name="main_category_name" form="MainCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="MainCategoryRequest">
      </div>
      <form action="{{ route('main.category.create') }}" method="post" id="MainCategoryRequest">{{ csrf_field() }}</form>
      <div class="">
        @if ($errors->any())
        <div class="card-text text-left alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <form action="{{ route('sub.category.create') }}" method="post" id="SubCategoryRequest">
          {{ csrf_field() }}
          <p class="m-0">サブカテゴリー</p>
          <select class="w-100" name="main_category_id">
            <option value="" hidden>----------</option>
            @foreach($main_categories as $main_category)
            <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
            @endforeach
          </select>
          <input type="text" class="w-100" name="sub_category_name">
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0">
        </form>

      </div>
    </div>
    @endcan
  </div>

  @if(isset($post))
  <div class="post_edit_container d-flex">
    <div class="post_edit_area border w-50 m-5 p-5">
      <form action="{{ route('post.edit', ['post_id' => $post->id]) }}" method="post">
        @csrf
        <div class="">
          <p class="mb-0">タイトル</p>
          <input type="text" class="w-100" name="post_title" value="{{ $post->post_title }}">
        </div>
        <div class="mt-3">
          <p class="mb-0">投稿内容</p>
          <textarea class="w-100" name="post_body">{{ $post->post_body }}</textarea>
        </div>
        <div class="mt-3 text-right">
          <input type="submit" class="btn btn-primary" value="更新">
        </div>
      </form>
    </div>
  </div>
  @endif

  @endsection
