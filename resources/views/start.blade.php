@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row pb-3">
                    <h1>Step {{ $_step }}</h1>
                </div>

                <form method="POST" action="{{ route('next') }}">
                    @csrf
                    <input type="hidden" name="_step" value="{{ $_step }}">
                    @foreach ($items as $group)

                        {{-- Se ha genitori li raggruppo in un accordion --}}
                        @if ($group->first()->hasParent())
                            <?php $parent = $group->first()->parent(); ?>

                            <div class="accordion mb-3" id="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="{{ $parent->alias }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $parent->alias }}" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            <h5>
                                                {{ $parent->name }}
                                            </h5>
                                        </button>
                                    </h2>

                                    @foreach ($group as $item)
                                        <div id="collapse{{ $parent->alias }}" class="accordion-collapse collapse"
                                            aria-labelledby="{{ $parent->alias }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="d-flex  justify-content-between">
                                                        <div class="pt-1">
                                                            <h5>
                                                                {{ $item->name }}
                                                            </h5>
                                                            <div style="color: lightgrey">
                                                                <small>
                                                                    {{ $item->rules }}
                                                                </small>    
                                                            </div>                                
                                                        </div>
                                                        <div class="ml-auto">
                                                            @if ($item->type == 'bool')
                                                                <input id="{{ $item->alias }}"
                                                                    name="{{ $item->alias }}"
                                                                    {{ $item->value == 'on' ? 'checked' : '' }}
                                                                    type="checkbox" data-toggle="toggle">
                                                            @elseif ($item->type == 'int')
                                                                <input id="{{ $item->alias }}"
                                                                    name="{{ $item->alias }}" type="text"
                                                                    value="{{ $item->value }}" class="form-control"
                                                                    required size="4">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            @foreach ($group as $item)
                                <div class="row pb-4">
                                    <div class="d-flex  justify-content-between">
                                        <div class="pt-1">
                                            <h5>
                                                {{ $item->name }}
                                            </h5>
                                            <div style="color: lightgrey">
                                                <small>
                                                    {{ $item->rules }}
                                                </small>    
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            @if ($item->type == 'bool')
                                                <input id="{{ $item->alias }}" name="{{ $item->alias }}"
                                                    {{ $item->value == 'on' ? 'checked' : '' }} type="checkbox"
                                                    data-toggle="toggle">
                                            @elseif ($item->type == 'int')
                                                <input id="{{ $item->alias }}" name="{{ $item->alias }}" type="text"
                                                    value="{{ $item->value }}" class="form-control" required size="4">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach

                    <div class="d-flex  justify-content-between">
                        <div>
                            @if ($_step > 1)
                                <a href="{{ route('prev', $_step) }}">
                                    <button type="button" class="btn btn btn-outline-primary btn-lg">Indietro</button>
                                </a>
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="btn btn btn-outline-primary btn-lg">
                                {{ __('Avanti') }}
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> --}}
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>


@endsection
