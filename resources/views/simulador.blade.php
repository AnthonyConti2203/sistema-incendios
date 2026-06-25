<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Simulador de WhatsApp') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            
            <div class="celular">

                <div class="header-wasap">
                    <div class="perfil">BA</div>
                    <div class="header-info">
                        <p class="nombre">Bomberos Arequipa</p>
                        <p class="estado">en línea</p>
                    </div>
                    <div class="iconos-wasap">
                        <span>&#128249;</span>
                        <span>&#128222;</span>
                        <span>&#8942;</span>
                    </div>
                </div>
                <!--
                    el if (request y toda la linea)
                    revisa si se envio un parametro  que 
                    se llame text con imformacion
                -->
                <div class="cuerpo-principal">
                    @if(request()->query('text'))
                        <div class="globo-whatsapp">
                            {!! nl2br(e(request()->query('text'))) !!}
                            {{--
                                esta linea de codigo es
                                -request()-. query(text) agarra el texto 
                                -e es una funcion que impia el texto, evita que se meta codigo dañino como el caso de XSS
                                -nl2br encargada de convertir los saltos en linea normales en etiquetas, para que no queden pegadas
                                -"{!!...!!}" le dice al motor de vistas de laravel que muestre el resultado inteprendando los br
                            --}}
                        </div>
                    @endif
                    @for($i = 1; $i <= 3; $i++)
                    <!--
                    esto lo que hace es recorrer
                -->
                        @if(request()->query("image$i"))
                        <!--
                    lo que se hace aca es que imagen se mostrara, osea de acuerdo al for
                -->
                            <div class="globo-whatsapp" style="padding: 4px; max-width: 75%; background-color: #d9fdd3; margin-top: 5px; border-radius: 8px; box-shadow: 0 1px 0.5px rgba(0,0,0,0.13); margin-left: auto;">
                                <img src="{{ request()->query("image$i") }}" alt="Foto Incendio" style="width: 100%; height: auto; max-height: 250px; object-fit: cover; border-radius: 6px; display: block;">
                            </div>
                        @endif
                    @endfor
                </div>

                <div class="contenedor-mensaje">
                    <div class="mensaje-falso">Mensaje</div>
                    <div class="btn-microfono">&#127908;</div>
                </div>

            </div>

        </div>
    </div>

    <style>
        .celular {
            width: 380px;
            height: 680px;
            background: #d1fc45;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            font-family: Helvetica, Arial, sans-serif;
        }

        .header-wasap {
            background: #075E54;
            color: #fff;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /*el globito del wasap, al menos una simulacion jeje*/
        .globo-whatsapp {
            background: #DCF8C6;
            color: #303030;
            padding: 10px 14px;
            border-radius: 8px 0px 8px 8px;
            max-width: 85%;
            align-self: flex-end;
            font-size: 14px;
            line-height: 1.4;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            word-wrap: break-word;
            text-align: left;
            margin-top: 5px;
        }

        /* Estilo para que donde estar la foto se adapte la burbuja*/
        .globo-whatsapp.globo-imagen {
            padding: 3px; 
            max-width: 75%;
        }

        .globo-whatsapp.globo-imagen img {
            width: 100%;
            height: auto;
            max-height: 250px;
            object-fit: cover;
            border-radius: 6px;
            display: block;
        }

        .perfil {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #b0731d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            color: #fff;
            flex-shrink: 0;
        }

        .header-info {
            flex: 1;
            min-width: 0;
        }

        .header-info .nombre {
            font-weight: 500;
            font-size: 15px;
            margin: 0;
        }

        .header-info .estado {
            font-size: 12px;
            margin: 0;
            color: rgba(255,255,255,0.8);
        }

        .iconos-wasap {
            display: flex;
            gap: 16px;
            font-size: 18px;
        }
        /*este es el cuerpo principal donde estara todo*/
        .cuerpo-principal {
            flex: 1;
            background: #ECE5DD;
            background-image: 
            url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5YSIRmnGhV-rXmXlglkBmxFmjQY4xSEXV--mapgn-ZQ&s=10);
            background-size: 200px;
            background-position: center;
            background-repeat: repeat;
            padding: 16px 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;

        }

        .contenedor-mensaje {
            background: #F0F0F0;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mensaje-falso {
            flex: 1;
            background: #fff;
            border-radius: 20px;
            padding: 8px 14px;
            font-size: 14px;
            color: #8a8a8a;
        }

        .btn-microfono {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #075E54;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #fff;
            font-size: 16px;
        }
    </style>
</x-app-layout>