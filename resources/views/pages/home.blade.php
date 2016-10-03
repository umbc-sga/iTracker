@extends('templates.base')

@section('title')
    Test!
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.header')
            
            <div class="col-xs-12">
                <div class="someDirective"></div>
            </div>
        </div>
    </div>
@endsection