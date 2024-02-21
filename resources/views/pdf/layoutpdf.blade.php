<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title> {{ $titulo_ventana }}</title>
    <link rel="stylesheet" href="{{ asset('css/materialicons.css') }}" media="all" />
    <link rel="stylesheet" href="{{ asset('css/wkhtml.css') }}" media="all" />

</head>

<body>
    <div class="page-break">
    <table class="w-100 m-b-15">
        <tr>
            <th class="w-15 text-left no-padding no-margins align-middle">
                <div class="text-center">
                    <img src="{{ asset('img/logo.jpg') }}" class="w-75">
                </div>
            </th>
            <th>
                <span class="font-semibold uppercase leading-tight text-md" >
                    UNIVERSIDAD MAYOR DE SAN ANDRÉS <br>
                    FACULTAD DE MEDICINA, ENFERMERIA, NUTRICIÓN Y TECNOLOGÍA MÉDICA <br>
                    GABINETE DE FISIOTERAPIA Y KINESIOLOGÍA <br>
                </span>
                <span class="font-light leading-tight text-md h6">
                    Av. Saavedra N°. 2248 - Miraflores, Telf. 2222502 - 2812359<br>
                    La Paz - Bolivia
                </span>
            </th>
            <th class="w-15 text-left no-padding no-margins align-middle">
                <div class="text-center">
                    <img src="{{ asset('img/logo2.png') }}" class="w-75">
                </div>
            </th>
        </tr>
        <tr><td colspan="3"><hr></td></tr>
        {{-- <tr><td colspan="3" class="text-right">{{ $fecha_impresion }}</td></tr> --}}
    </table>
    <div class="block">
        @yield('content')
    </div>
    <footer>
        <div class="text-right">
            {{ $fecha_impresion }}
        </div>
    </footer>
    </div>
</body>
</html>