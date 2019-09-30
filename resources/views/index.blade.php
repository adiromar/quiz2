@extends('layouts.main')

@section('styles')

<style>
    .sets{
        padding: 20px 15px;text-align: center;background-color: #17a2b8;border-radius: 5px;
        margin-top: 10px;height: 80px;
    }
    .sets:hover{
        background-color: #dd3333;

    }
    .sets:after{
        position: absolute;
        display: block;
        content: "";
        width: 160px;
        height: 8px;
        background: #dd3333;
        bottom: -8px;
        left: 20%;
        margin: auto;
    }
    .sets:hover:after{
        background-color: #17a2b8;
    }
    .sets a{
        font-weight: 600;font-size: 15px;color:#fff;
    }
    .sets a:hover{
        color: wheat
    }
</style>

@endsection

@section('content')

    <div class="breadcrumb mb-4"><small>Here, you can read the aptitude questions and answers for your interview and entrance exams preparation.</small></div>

    <div class="col-md-12">
        @if( $sets->count() > 0 )

        <div class="row box_wrap p-3">
        <!-- LOOP Sets HERE -->
        @foreach( $sets as $set )
            <div class="col-md-3">
                
                <div class="sets">
                   <a href="{{ route('set.view', [$set->slug, 1]) }}">{{ $set->setname }}</a>
                </div>

            </div>
        @endforeach
        </div>
        
        @else
        
        <div class="row box_wrap p-3">
        <!-- Show categories -->
            @if(count($main) > 0)
                @php $cat_name = ''; @endphp
                @foreach($main as $mainc)

                <div class="col-md-3 ml-4 mt-2">
                    @php
                        $cat_name = mb_convert_case($mainc->main_category_name, MB_CASE_TITLE);
                    @endphp
                    <h4 class="cat-title"><a href="{{ url(''.$mainc->slug.'/'.$mainc->id.' ') }}">{{ $cat_name }}</a></h4>

                    <div class="box-shade">
                    <p>
                    @foreach($category1 as $cat1)

                    @foreach($cat1->category as $cat)
                        @if($cat->featured == true)
                        @if($cat1->id == $mainc->id)
                            <a class="cat-link" href="{{ route('cat', [$mainc->slug, $cat->slug, $cat->id, 1]) }}"><i class="fas fa-chevron-right"></i> {{ $cat->category_name }} 
                                <small>{{ '('. $cat->posts()->count() . ')' }}</small>
                            </a><br>
                        @endif
                        @endif
                    @endforeach

                    @endforeach
                    </p>
                    </div>

                </div>
        
                @endforeach
            @else
                <p>No Categories Found</p>
            @endif
        <!-- Show categories -->

        @endif
        </div>

    </div>

@endsection


