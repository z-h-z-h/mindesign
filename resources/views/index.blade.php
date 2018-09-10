@extends('layouts.default')
@section('title', 'Главная страница')

@section ('content')
    <div class="row">
        <div class="col-4">
            <h2>Категории</h2>
            <ul>
                @forelse($categories as $category)
                    <li>
                        <a href="{{ route('category', ['id' => $category->alias]) }}">{{ $category->title }}</a>
                        @if (!empty($category->items))
                            <ul>
                                @foreach($category->items as $subCategory)
                                    <li>
                                        <a href="{{ route('subCategory', [$category->alias, lcfirst($subCategory->alias)]) }}">{{ $subCategory->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @empty
                    Нет категорий
                @endforelse
            </ul>
        </div>
        <div class="col-8">
            <h2>Поиск по названию и описанию</h2>
            <form action="/" method="post">
                @csrf
                <div class="input-group mb-5">
                    <input type="text" name="searchQuery" class="form-control" placeholder="Поиск" value="{{ $searchQuery }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Искать</button>
                    </div>
                </div>
            </form>
            @isset($searchResults)
                <h3>Результаты поиска "{{ $searchQuery }}"</h3>
                <span>Найдено: {{ $searchResults->count() }}</span>
                <div class="card-columns">
                    @foreach($searchResults as $product)
                        <div class="card">
                            <img class="card-img-top" src="{{ $product->image }}">
                            <div class="card-body">
                                <h5 class="card-title"><a
                                            href="{{ route('product', [$product->id]) }}">{{ $product->title }}</a>
                                </h5>
                                <p class="card-text">{{ $product->price }} ₽</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endisset

            <h2>ТОП 20</h2>
            <div class="card-columns">

                @forelse($offers as $offer)
                    <div class="card">
                        <img class="card-img-top" src="{{ $offer->product->image }}">
                        <div class="card-body">
                            <h5 class="card-title"><a
                                        href="{{ route('product', [$offer->product->id]) }}">{{ $offer->product->title }}</a>
                            </h5>
                            <p class="card-text">{{ $offer->price }} ₽</p>
                        </div>
                    </div>
                @empty
                    Нет продуктов
                @endforelse
            </div>
        </div>
    </div>

@endsection