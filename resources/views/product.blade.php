@extends('layouts.default')
@section('title', $product->title)

@section ('content')
    <a href="/">На главную</a>
    <br><br>

    <strong>Главные категории товара:</strong><br>
    @foreach ($product->category as $category)
        <a href="{{ route('category', $category->alias) }}">{{$category->title}}</a> <br>
    @endforeach
    <br>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <img class="card-img-top" src="{{ $product->image }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text">{{ $product->price }} ₽</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <strong>Описание:</strong><br>
            {{ $product->description }}
        </div>
        <div class="col-4">
            <strong>Артикулы:</strong>
            <ul>
            @foreach($product->offers as $offer)
                <li>Артикул {{ $offer->article }}<br> Цена {{ $offer->price }} ₽</li>
            @endforeach
            </ul>
        </div>

    </div>

@endsection