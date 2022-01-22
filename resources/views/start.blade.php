@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <form method="POST" action="{{ route('store') }}">
                    @csrf

                    @foreach ($items as $item)
                        <div class="accordion mb-3" id="accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $item->alias }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $item->alias }}" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <h5>
                                            {{ $item->description }}
                                        </h5>
                                    </button>
                                </h2>

                                @foreach ($item->subitems as $subitem)
                                    <div id="collapse{{ $item->alias }}" class="accordion-collapse collapse"
                                        aria-labelledby="{{ $item->alias }}" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">


                                            <div class="row">
                                                <div class="d-flex  justify-content-between">
                                                    <div class="pt-1">
                                                        <h5>
                                                            {{ $subitem->description }}
                                                        </h5>
                                                    </div>
                                                    <div class="ml-auto">
                                                        @if ($subitem->type == 'bool')
                                                            <input id="{{$subitem->alias}}" name="{{$subitem->alias}}"
                                                            type="checkbox" checked data-toggle="toggle">
                                                        @elseif ($subitem->type == 'int')
                                                            <input id="{{$subitem->alias}}" name="{{$subitem->alias}}" type="text" class="form-control" required
                                                                size="4">
                                                        @endif

                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    @endforeach



                    <button type="submit" class="btn btn-primary">
                        {{ __('Next') }}
                    </button>

                </form>


            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> --}}
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>


@endsection
