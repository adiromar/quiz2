
        {{-- <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Bix.com
                </div>

            </div>
        </div> --}}


@extends('layouts.main')

@section('content')
    <div class="col-md-12">
        <div class="row">
        
            <div class="col-md-3 card">
                <h4 class="cat-title">Category 1</h4>
                <div class="box-shade">
                    <p>
                        Some paragraphs here sajkdh asdkjhas kjas 
                        asdha shdas kjdhas 
                         asdashb dhkjasb kjas d
                    </p>
                </div>
            </div>

            <div class="col-md-3 card rounded ml-4">
               <h4 class="cat-title">Category 1</h4>
                    <p>
                        Some paragraphs here sajkdh asdkjhas kjas 
                        asdha shdas kjdhas 
                         asdashb dhkjasb kjas d
                    </p>
            </div>

            <div class="col-md-3 card rounded ml-4">
                <h4 class="cat-title">Category 1</h4>
                    <p>
                        Some paragraphs here sajkdh asdkjhas kjas 
                        asdha shdas kjdhas 
                         asdashb dhkjasb kjas d
                    </p>
            </div>
        </div>

        <div class="row mt-5">
        
            @if(count($category) > 0)
            @foreach($category as $cat)

            <div class="col-md-3 card rounded">
                <h4 class="cat-title">{{ $cat->category_name }}</h4>
                <div class="box-shade">
                    <p>
                        Some paragraphs here sajkdh asdkjhas kjas 
                        asdha shdas kjdhas 
                         asdashb dhkjasb kjas d
                    </p>
                </div>
            </div>
            
            @endforeach
            @else
                <p>No Categories Found</p>
            @endif

        </div>
    </div>


@endsection


