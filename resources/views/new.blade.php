@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (count($items))
                    <div class="card mb-5">
                        <div class="card-header">{{ __('Archivio CSV') }}</div>
                        {{-- <div class="row pt-4 pb-2">
                        <h3>
                            Archivio CSV
                        </h3> 
                    </div> --}}

                        <div class="card-body mt-3">

                            {{-- <div class="row pb-4"> --}}
                            <table class="table table-borderless">
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>
                                                <h5>{{ $item->name }}</h5>
                                            </td>
                                            <td style="width: 90px">
                                                <a href="{{ route('attiva', $item->id) }}">
                                                    <button type="button" class="btn btn-outline-primary">Attiva</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif


                <div class="card">
                    <div class="card-header">{{ __('Upload nuovo file CSV') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="upload" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row mb-3 offset-md-2">
                                <input class="col-md-8  col-form-label" type="file" name="file" required><br><br>
                            </div>

                            <div class="row mb-4">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Breve descrizione') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                        placeholder="Facoltativo">
                                </div>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary btn-lg pt-2">{{ __('Upload') }}</button>
                            </center>
                        </form>

                        <div class="pt-4">
                            <h5>
                                Struttura del CSV
                            </h5>
                        </div>

                        <div class="pt-1">
                            - I campi devo essere separati col carattere ","<br>
                            - Non ci devono essere spazi prima o dopo i separatori<br>
                            - La prima riga del CSV deve essere questa:<br>
                            &nbsp;&nbsp;&nbsp;alias,parent_alias,name,type,rules,group_title
                        </div>

                        <div class="pt-4">
                            <h5>
                                Esempio:
                            </h5>
                        </div>
                        <div class="">
                            <strong>
                                alias,parent_alias,name,type,rules,group_title<br>
                            </strong>
                            Velocita,,Velocità,int,,<br>
                            GruppoColla,,Gruppo Colla,bool,,<br>
                            GruppoProspetto,,Gruppo Prospetto,bool,,<br>
                            N_Tratti,GruppoColla,Numero Tratti,int,,Nome Gruppo<br>
                            TipoTratto,GruppoColla,Tipo di tratto,list,,Nome Gruppo<br>
                            TipoGuk,GruppoProspetto,Gruppo Guk,bool,,Nome Gruppo<br>
                            Tratto_1,N_Tratti,Primo tratto,int,N_Tratti>0,<br>
                            Tratto_2,N_Tratti,Secondo tratto,int,N_Tratti>1,<br>
                            Tratto_3,N_Tratti,Terzo tratto,int,N_Tratti>2,<br>
                            Tratto_4,N_Tratti,Quarto tratto,int,N_Tratti>3,<br>
                            Lista_1,TipoTratto,Tratto intermittente,bool,TipoTratto=Lungo,<br>
                            ComboGuk,GruppoProspetto,Combo GUK!!!,bool,GruppoColla=on&GruppoProspetto=on,<br>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
