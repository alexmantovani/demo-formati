@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <center>
                    {{ session('status') }}

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="pt-5">
                        <h3>
                            Complimenti !
                        </h3>
                    </div>

                    <div class="">
                        <h5>
                            Hai creato il formato.
                        </h5>
                    </div>

                    <div class="row pt-5 pb-5">
                        <a href="{{ route('start') }}">
                            <button type="button" class="btn btn-primary btn-lg"> Ricominciamo </button>
                        </a>
                    </div>

                </center>
            </div>

            <div class="row col-md-8 pt-3">
                <h4>
                    Report formato:
                </h4>
            </div>
            <div class="col-md-7 pt-3">
                <table class="table table-borderless">
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->alias }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
