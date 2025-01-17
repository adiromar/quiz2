@extends('layouts.main')

@section('content')

	<div class="breadcrumb mb-4"><small>Here, you can take online test.</small></div>

    <div class="col-md-12">
        <div class="row box_wrap">
            
            @if(count($main) > 0)
            @php
                $cat_name = '';
            @endphp
            @foreach($main as $mainc)
            
            <div class="col-md-6 mt-2">
                @php
                    $cat_name = mb_convert_case($mainc->main_category_name, MB_CASE_TITLE);
                @endphp
                <h4 class="cat-title-qz"><medium>{{ $cat_name }}</medium></h4>
                <div class="box-shade">
                    <p>
                    @foreach($category1 as $cat1)
                        @foreach($cat1->category as $cat)
                            @if($cat->featured == true)
                            @if($cat1->id == $mainc->id)
                                <medium><i class="fas fa-chevron-right"></i> {{ $cat->category_name }}</medium>

                                <a href="{{ route('online_test', [$cat->slug, $cat->id]) }}"><i class="fa fa-clock"></i> Time Challenge</a><br>

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

        </div>

    </div>
@endsection