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

            <center>
                <div class="row col-md-8 pt-3">
                    <h4>
                        Resoconto dei dati inseriti
                    </h4>
                </div>    
            </center>
            <div class="col-md-8 pt-4">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                                <th scope="col">Parent</th>
                                <th scope="col">Alias</th>
                                <th scope="col">Name</th>
                                <th scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    <div style="color: lightgray">
                                        {{ $item->parent_alias }}
                                    </div>
                                </td>
                                <td>
                                    {{ $item->alias }}
                                </td>
                                <td>
                                    <strong>
                                        {{ $item->name }}
                                    </strong>
                                </td>
                                <td>{{ $item->value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
