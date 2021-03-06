@extends('templates.master')

@section('contenido')


    <nav class="navbar navbar-expand-lg " color-on-scroll="500">
        <div class="container-fluid">
            <a class="navbar-brand"> Buro de credito </a>
            <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar burger-lines"></span>
                <span class="navbar-toggler-bar burger-lines"></span>
                <span class="navbar-toggler-bar burger-lines"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cerrarsesion">
                            <span class="no-icon">Salir</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <style type="text/css">


        .results tr[visible='false'],
        .no-result {
            display: none;
        }

        .results tr[visible='true'] {
            display: table-row;
        }

        .counter {
            padding: 8px;
            color: #ccc;
        }
    </style>



{{--<form method="post" action="GenerarReporteBuro">--}}
    <div class="card p-7 m-4" style="max-width: 100%;">
        <div class="card-header">
            <h3>Datos Personales</h3>
        </div>

        <input type="text" class="search form-control" placeholder="Buscar persona">
        <table class="table table-hover table-bordered results">
            <thead>
            <tr>
                <th class="col-md-1 col-xs-5">Nombre</th>
                <th class="col-md-2 col-xs-5">Apellido paterno</th>
                <th class="col-md-2 col-xs-5">Apellido materno</th>
                <th class="col-md-2 col-xs-5">Fecha nacimiento</th>
                <th class="col-md-2 col-xs-5">RFC</th>
                <th class="col">CURP</th>
                <th class="col">GENERAR REPORTE</th>

            </tr>
            <tr class="warning no-result">
                <td colspan="4"><i class="fa fa-warning"></i> Sin resultados</td>
            </tr>
            </thead>
            <tbody>
            @csrf
            @foreach($personas as $persona)

                <tr>
                    <input type="hidden" id="" value="{{$persona->id}}" class="id">
                  <th>{{$persona['nombre']}}</th>
                    <td>{{$persona['apellido_p']}}</td>
                    <td>{{$persona['apellido_m']}}</td>
                    <td>{{$persona['fecha_nacimiento']}}</td>
                    <th>{{$persona['rfc']}}</th>
                    <th>{{$persona['curp']}}</th>
                  {{--  <th>{{$persona->direcciones['numero']}}</th>--}}
                    <th>
                        <div class="col offset-5"></div>
                        <div class="col">
                        <button value="{{$persona->id}}"  class="btn btn-primary btn-report font-weight-bold" data-toggle="modal" data-target="#exampleModalReporte" >reporte</button>
                      {{--  <button  class="btn btn-primary btn-report font-weight-bold" >reporte</button>--}}
                        </div>

                    </th>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    {{--        Modal titulo reporte--}}



   <div class="modal fade" id="exampleModalReporte" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar mensaje</h5>
                    <button id="btn-numcliente" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">

                            <div class="form-group">
                                <label for="">Mensaje:</label>
                                <input type="text" class="form-control mensaje">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-generico-cancelar" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button  id="confirmarReporte" class="btn btn-primary btn-generico confirmarReporte">
                                          Confirmar</button>

                </div>
            </div>
        </div>

    </div>








@stop

@section('javascript')
    <script type="text/javascript">

        $(document).ready(function () {
            $(".search").keyup(function () {
                var searchTerm = $(".search").val();
                var listItem = $('.results tbody').children('tr');
                var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

                $.extend($.expr[':'], {
                    'containsi': function (elem, i, match, array) {
                        return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
                    }
                });

                $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function (e) {
                    $(this).attr('visible', 'false');
                });

                $(".results tbody tr:containsi('" + searchSplit + "')").each(function (e) {
                    $(this).attr('visible', 'true');
                });

                var jobCount = $('.results tbody tr[visible="true"]').length;
                $('.counter').text(jobCount + ' item');

                if (jobCount == '0') {
                    $('.no-result').show();
                } else {
                    $('.no-result').hide();
                }
            });


        $('.table').on('click','.btn-report',function () {
                var token = $('input[name=_token]').val();
                var id = $(this).val();

                console.log(id);

                $('body').on('click','#confirmarReporte',function () {
                    var mensaje = $('.mensaje').val();
                    console.log(id, mensaje)
                    $.ajax({
                        url: "/GenerarReporteBuro",
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            id: id,
                            mensaje: mensaje,
                            _token: token
                        },
                        success: function (response) {
                            var pdf= window.open("");
                            pdf.document.write("<iframe width='100%' height='100%'"+
                                " src='data:application/pdf;base64, " + encodeURI(response)+"'></iframe>");
                            location.href='/Burocredito';
                        }
                    });
                })
            });
         });




    </script>






@stop
















