@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- Albero degli step --}}
            @include('layouts.treeview')


            {{-- Dettagli --}}
            <div class="col">

                <div class="row justify-content-center">
                    <div class="col-md-9">

                        <div class="d-flex  justify-content-between">
                            <div class="row pb-3">
                                <h1>Step {{ $_step }}</h1>
                            </div>
                            <div class="pt-1 d-flex">
                                <div class="">
                                    Step
                                </div>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                <div class="">
                                    <a class="nav-link p-0" href="{{route('goto_tree', 1)}}">
                                        Tree
                                    </a>
                                </div>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                <div class="">
                                    <a class="nav-link p-0" href="{{ route('favorite') }}">
                                        Favorites
                                    </a>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('next') }}">
                            @csrf
                            <input type="hidden" name="_step" value="{{ $_step }}">
                            <input type="hidden" name="_view_mode" value="step">
                            @foreach ($items as $group)

                                {{-- Se ha genitori li raggruppo in un accordion --}}
                                {{-- @if ($group->first()->hasParent()) --}}
                                <?php $parent = $group->first(); ?>

{{--
                                OPEN <button class="accordion-button"           type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"  aria-controls="collapseOne">
                                CLOS <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

    OPEN <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
    CLOS <div id="collapseTwo" class="accordion-collapse collapse     " aria-labelledby="headingTwo" data-bs-parent="#accordionExample">

                                    --}}

                                <div class="accordion mb-3" id="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="{{ $parent->alias }}">
                                            <button class="accordion-button {{ $group->first()->group_title==$group->first()->group_title? '':'collapsed'}}" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $parent->alias }}" aria-expanded="{{ $group->first()->group_title==$group->first()->group_title ? 'true':'false'}}"
                                                aria-controls="collapseTwo">
                                                <h5>
                                                    {{ $group->first()->group_title }}
                                                </h5>
                                            </button>
                                        </h2>

                                        @foreach ($group as $item)
                                            <div id="collapse{{ $parent->alias }}"
                                                class="accordion-collapse collapse {{ $group->first()->group_title==$group->first()->group_title ? 'show':''}}"
                                                aria-labelledby="{{ $parent->alias }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="pt-1 flex-grow-1">
                                                                <h5>
                                                                    {{ $item->name }}
                                                                </h5>
                                                                <div style="color: lightgrey">
                                                                    <small>
                                                                        {{ $item->parent_alias }}
                                                                        @if (strlen($item->rules))
                                                                            &#xb7; {{ $item->rules }}
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="ml-auto">
                                                                @if ($item->type == 'bool')
                                                                    <input id="{{ $item->alias }}" style="width: 80px"
                                                                        name="{{ $item->alias }}"
                                                                        {{ $item->value == 'on' ? 'checked' : '' }}
                                                                        type="checkbox" data-toggle="toggle">

                                                                @elseif ($item->type == 'int')
                                                                    <input class="form-control text-right"
                                                                        id="{{ $item->alias }}" style="width: 80px"
                                                                        name="{{ $item->alias }}" type="text"
                                                                        value="{{ $item->value }}" class="form-control"
                                                                        required size="4">

                                                                @elseif ($item->type == 'list')

                                                                    <select class="form-control" style="width: 80px"
                                                                        name="{{ $item->alias }}">
                                                                        <option value="{{ $item->value }}">
                                                                            {{ $item->value }}</option>
                                                                        @foreach (['Lungo', 'Medio', 'Corto'] as $value)
                                                                            <option value="{{ $value }}"
                                                                                @isset($item->value)
                                                                                    {{ $item->value == $value ? 'selected' : '' }}
                                                                                @endisset>
                                                                                {{ $value }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                @endif
                                                            </div>


                                                            <div class="p-1">
                                                                <favorite-button alias="{{ $item->alias }}"
                                                                    favorite="{{ (bool) $item->favorite }}">
                                                                </favorite-button>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-flex  justify-content-between">
                                <div>
                                    @if ($_step > 1)
                                        <a href="{{ route('goto', $_step - 1) }}">
                                            <button type="button"
                                                class="btn btn btn-outline-primary btn-lg">Indietro</button>
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
        </div>

    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> --}}
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>

@endsection
