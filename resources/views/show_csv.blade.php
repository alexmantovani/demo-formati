@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <h3>
                        File CSV
                   </h3>
                </div>
                <div>
                    {{ $name }}
                </div>
            </div>

            <div class="col-md-8 pt-4">
                <table class="table table-borderless">
                    <tbody>
                        @foreach ($csv as $rows)
                            <tr>
                                @foreach ($rows as $item)
                                    <td>
                                        <div style="color: rgb(39, 39, 39)">
                                            {{ $item }}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
