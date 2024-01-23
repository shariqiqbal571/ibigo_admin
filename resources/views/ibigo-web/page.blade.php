@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Contact')
@section('content')


    <div class="page-content header-clear-medium">
        <div class="container-fluid">
            <div class="card card-style " style="width: 100%;">
                <div class="content">
                    <h1 class="mt-5 font-weight-normal" style="font-size:70px !important;">{{$page->page_title}}</h1>
                    <div class="mt-5">
                        {!!html_entity_decode($page->page_description)!!}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Page content ends here-->


    @endsection
