@extends('layouts.main')

@section('content')

<div class="breadcrumb mb-4"><small>Here, you can read the aptitude questions and answers for your interview and entrance exams preparation.</small></div>



    <div class="col-md-12">
        <div class="row box_wrap">
            
            @if(count($main) > 0)
            @php
                $cat_name = '';
            @endphp
            @foreach($main as $mainc)
            
            <div class="col-md-3 ml-4 mt-2">
                @php
                            $cat_name = mb_convert_case($mainc->main_category_name, MB_CASE_TITLE);
                            // $cat_name = ucwords($cat->category_name);
                            // dd($category1);die;
                @endphp
                <h4 class="cat-title"><a href="{{ url(''.$mainc->slug.'/'.$mainc->id.' ') }}">{{ $cat_name }}</a></h4>
                <div class="box-shade">
                    <p>
                    @foreach($category1 as $cat1)
                        @php
                        // echo '<pre>';
                        // print_r($cat1->category);
                        // echo $cat1->main_category_name;die;
                        @endphp
                        @foreach($cat1->category as $cat)
                            @if($cat->featured == true)
                            @if($cat1->id == $mainc->id)
                                <a class="cat-link" href="{{ $mainc->slug }}/{{ $cat->slug }}/{{ $cat->id }}" ><i class="fas fa-chevron-right"></i> {{ $cat->category_name }} 
                                    <small>{{ '('. $cat->posts()->count() . ')' }}</small>
                                </a><br>
                            @endif
                            @endif
                        @endforeach
                    @endforeach
                    </p>
                </div>
            
            @endforeach
            @else
                <p>No Categories Found</p>
            @endif

        </div>

    </div>
@endsection


