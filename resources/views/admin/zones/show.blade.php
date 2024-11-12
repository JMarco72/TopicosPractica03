@extends('adminlte::page')

@section('title', 'ReciclaUSAT')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-success float-right" id="btnNuevo" data-id={{ $zone->id }}><i class="fas fa-plus"></i>
                Agregar coordenada</button>
            <h3>Perímetro de la Zona</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <label for="">Zona:</label>
                            <p>{{ $zone->name }}</p>
                            <label for="">Sector:</label>
                            <p>{{ $zone->sector }}</p>
                            <label for="">Área:</label>
                            <p>{{ $zone->area }} metros</p>
                            <label for="">Descripción:</label>
                            <p>{{ $zone->description }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>LATITUD</th>
                                        <th>LONGITUD</th>
                                        <th></th>
                                    </tr>

                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Coordenadas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $("#btnNuevo").click(function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('admin.zonecoords.edit', '_id') }}".replace('_id', id),
                type: "GET",
                success: function(response) {
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");
                }
            })
        })
    </script>
@endsection



@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
