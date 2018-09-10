@extends('layouts.default')
@section('title', $category->title)

@section ('content')
    <a href="/">На главную</a>
    <h1>
        @isset($parentCategory)
            {{ $parentCategory->title }} /
        @endif
        {{ $category->title }}
    </h1>
    <div class="col-8">
        <div class="card-columns">
            @forelse ($products as $product)
                <div class="card">
                    <img class="card-img-top" src="{{ $product->image }}">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('product', $product->id) }}">{{ $product->title }}</a>
                        </h5>
                        <p class="card-text">{{ $product->price }} ₽</p>
                    </div>
                </div>
                <br>
            @empty
                Нет продуктов
            @endforelse
        </div>
    </div>
@endsection