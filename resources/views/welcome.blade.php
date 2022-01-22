@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <center>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row pt-5">
                        <a href="{{route('start')}}">
                            <button type="button" class="btn btn-primary">Prova</button>
                        </a>
                    </div>

                </center>
            </div>
        </div>
    </div>
@endsection
