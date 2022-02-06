@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- Albero degli step --}}
            <div class="col-md-auto">
                @foreach ($tree as $group)
                    <div class="">
                        <h5>
                            <a class="nav-link p-0" href="{{ route('goto', $loop->index + 1) }}">
                                Step {{ $loop->index + 1 }}
                            </a>
                        </h5>
                    </div>
                    @foreach ($group as $item)
                        <?php $sperem = $item->first(); ?>
                        <div class="">
                            &nbsp;&nbsp;&nbsp;
                            {{ $sperem->group_title }}
                        </div>
                    @endforeach
                    <div class="pb-3">
                    </div>
                @endforeach
            </div>


            {{-- Dettagli --}}
            <div class="col">

                <div class="row justify-content-center">
                    <div class="col-md-8">



                        <div class="d-flex  justify-content-between">
                            <div class="row pb-3">
                                <h1>Tree view</h1>
                            </div>
                            <div class="pt-1 d-flex">
                                <div class="">
                                    <a class="nav-link p-0" href="{{route('goto', 1)}}">
                                        Step
                                    </a>
                                </div>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                <div class="">
                                        Tree
                                </div>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                <div class="">
                                    <a class="nav-link p-0" href="{{ route('favorite') }}">
                                        Favorites
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="p-5" style="color: lightgray">
                            
                        </div>


                        <div class="pt-5" style="color: lightgray">
                            <center>
                                <h3>
                                    STILL A SECRET
                                </h3>
                            </center>
                        </div>

                    </div>


                </div>
            </div>
        </div>

    </div>
    </div>

@endsection
