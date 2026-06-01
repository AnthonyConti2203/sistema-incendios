<x-app-layout>
    <!--
    Utiliza la plantilla principal de Laravel Breeze.
    Gracias a esto heredamos automáticamente:
    - Menú de navegación
    - Sesión iniciada
    - Diseño general del sistema
    -->
    <x-slot name="header">
        <!--Define el título que aparecerá en la parte superior de la página.-->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo reporte de incendio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                <!--
                Si el reporte fue guardado correctamente,
                Laravel almacena un mensaje temporal llamado "success".

                Aquí se muestra dicho mensaje al usuario.
                -->
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                <!--fin-->
                <!--si hubo algun error sale en rojo-->
                <!--
                revisa si hay al menos un error
                se muestra el mensaje de revisa los campos 
                -->
                @if($errors->any())
                <!--
                Si alguna validación falla,
                Laravel guarda los errores automáticamente.

                Este bloque muestra un aviso general.
                -->
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        Revisa los campos del formulario.
                    </div>
                @endif
                <!--fin-->
                <!--abre el formulario (envia los datos ingresados
                a la ruta de reposts.store
                -->
                <form method="POST" action="{{ route('reports.store') }}">
                    <!--
                    Al presionar "Enviar reporte",
                    los datos serán enviados al método store()
                    del ReportController.
                    -->
                    @csrf
                    <!--
                    Genera un token de seguridad.

                    Evita que páginas externas envíen formularios
                    maliciosos en nombre del usuario.
                    FIN
                    -->
                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Descripción</label>
                        <!--el old(description) lo que hace si el formulario
                        fallo la validacion y se recargo recupera el texto que el 
                        usuario habia escrito para no perderlo-->
                        <textarea name="description" class="w-full border rounded p-2" rows="4">{{ old('description') }}</textarea>
                        <!--
                        Permite agregar información adicional sobre el incendio.

                        Por ejemplo:
                        - tamaño aproximado
                        - presencia de humo
                        - si hay personas cerca
                        -->
                        <!--fin-->
                        <!--si se detecto un error especifico en el campo de descripcion
                        muestra el mensaje en rojo dentro del campo-->
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <!--fin-->
                    </div>

                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 font-medium">Latitud</label>
                            <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" class="w-full border rounded p-2">
                            @error('latitude')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 font-medium">Longitud</label>
                            <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" class="w-full border rounded p-2">
                            @error('longitude')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">¿Cómo quieres indicar la ubicación?</label>

                        <input type="hidden" name="location_type" id="location_type" value="{{ old('location_type', 'manual') }}">
                        <!--
                        Este campo no es visible para el usuario.

                        Se utiliza para indicar si la ubicación fue obtenida:

                        - automáticamente (GPS)
                        - manualmente (mapa)
                        -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <button type="button" id="btnUsarUbicacionActual"
                                class="px-4 py-3 rounded-lg border border-blue-600 text-blue-700 font-medium hover:bg-blue-50 transition">
                                Usar mi ubicación actual
                            </button>

                            <button type="button" id="btnElegirEnMapa"
                                class="px-4 py-3 rounded-lg border border-green-600 text-green-700 font-medium hover:bg-green-50 transition">
                                Elegir en el mapa
                            </button>
                        </div>

                        @error('location_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="ubicacionAutoInfo" class="mb-4 hidden rounded-lg border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900">
                        Se usará la ubicación actual del dispositivo. Si necesitas ajustarla, puedes cambiar a “Elegir en el mapa”.
                    </div>

                    <div id="mapSection" class="mb-4 hidden">
                        <label class="block mb-2 font-medium">Selecciona la ubicación en el mapa</label>
                        <p class="text-sm text-gray-500 mb-2">Haz clic en el mapa para marcar el punto exacto del incendio.</p>

                        <div id="mapa" style="height: 350px; border-radius: 8px; border: 1px solid #ccc;"></div>
                        <!--
                        Contenedor donde Leaflet dibuja el mapa.

                        Leaflet es una librería gratuita de mapas
                        basada en OpenStreetMap.
                        -->
                    </div>

                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">
                        Enviar reporte
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- 
    Librería externa utilizada:
    Leaflet 1.9.4

    Sitio oficial:
    https://leafletjs.com

    Mapas proporcionados por:
    OpenStreetMap
    https://www.openstreetmap.org
    --}}

    {{-- Leaflet CSS y JS (mapa gratuito sin API key) --}}
    <!--carga los estilos visuales de leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!--fin-->
    <!--libreria de leaflet-->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!--fin-->

<script>
    const inputLat = document.getElementById('latitude');
    const inputLng = document.getElementById('longitude');
    const inputTipo = document.getElementById('location_type');

    const btnAuto = document.getElementById('btnUsarUbicacionActual');
    const btnMapa = document.getElementById('btnElegirEnMapa');
    const mapSection = document.getElementById('mapSection');
    const ubicacionAutoInfo = document.getElementById('ubicacionAutoInfo');

    // Obtiene una referencia a los campos para poder modificar su contenido mediante JavaScript.

    // Centro aproximado de Arequipa, el mapa se abrirá inicialmente en esta ubicación.
    const defaultLat = -16.409047;
    const defaultLng = -71.537451;

    // Inicializar mapa
    const mapa = L.map('mapa').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapa);
    // Carga las imágenes del mapa desde OpenStreetMap.
        // OpenStreetMap es un proyecto colaborativo
        // de mapas libres y gratuitos.

    let marcador = null;
// Variable que almacenará el marcador del incendio.
            // Al inicio es null porque todavía no existe
            // ningún punto seleccionado.

    function ponerMarcador(lat, lng, textoPopup = null) {
        /* Esta función se encarga de:

        1. Crear un marcador si no existe.
        2. Moverlo si ya existe.
        3. Mostrar un mensaje emergente opcional.

        Se utiliza para evitar repetir código.*/
        if (marcador) {
            marcador.setLatLng([lat, lng]);
        } else {
            marcador = L.marker([lat, lng]).addTo(mapa);
        }

        if (textoPopup) {
            marcador.bindPopup(textoPopup).openPopup();
        }
    }

    function activarModoManual() {
        /* Activa el modo de selección manual.

            Acciones:
            - muestra el mapa
            - oculta el mensaje de GPS
            - cambia location_type a "manual"*/
        inputTipo.value = 'manual';
        mapSection.classList.remove('hidden');
        ubicacionAutoInfo.classList.add('hidden');

        setTimeout(() => {
            mapa.invalidateSize();
        }, 100);
    }

    function activarModoAutomatico() {
        /* Activa el modo GPS.

        Acciones:
        - oculta el mapa
        - muestra información del GPS
        - cambia location_type a "auto"*/
        inputTipo.value = 'auto';
        mapSection.classList.add('hidden');
        ubicacionAutoInfo.classList.remove('hidden');
    }

    // Si ya había valores guardados por old()
    if (inputLat.value && inputLng.value) {
        const lat = parseFloat(inputLat.value);
        const lng = parseFloat(inputLng.value);

        mapa.setView([lat, lng], 15);
        ponerMarcador(lat, lng, `📍 ${lat.toFixed(5)}, ${lng.toFixed(5)}`);

        // Si ya había ubicación, mostramos el mapa
        mapSection.classList.remove('hidden');

        if (inputTipo.value === 'auto') {
            ubicacionAutoInfo.classList.remove('hidden');
        }
    }

    // Elegir ubicación manualmente en el mapa
    btnMapa.addEventListener('click', () => {
        activarModoManual();
        mapSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    mapa.on('click', (e) => {
        /* Cuando el usuario hace clic:

        1. Obtiene las coordenadas.
        2. Las guarda en el formulario.
        3. Coloca un marcador.
        4. Marca la ubicación como manual.*/
        const { lat, lng } = e.latlng;

        inputLat.value = lat.toFixed(7);
        inputLng.value = lng.toFixed(7);
        inputTipo.value = 'manual';

        ponerMarcador(lat, lng, `📍 ${lat.toFixed(5)}, ${lng.toFixed(5)}`);
    });

    // Usar ubicación actual del dispositivo
    btnAuto.addEventListener('click', () => {
        if (!navigator.geolocation) {
            alert('Tu navegador no permite geolocalización.');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            /*Solicita al navegador la ubicación actual.

            El usuario debe otorgar permiso.

            Si acepta:
            - se obtiene latitud
            - se obtiene longitud
            - se coloca un marcador
            - se guardan las coordenadas

            Si rechaza:
            - se muestra un mensaje de error*/
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                inputLat.value = lat.toFixed(7);
                inputLng.value = lng.toFixed(7);

                activarModoAutomatico();
                mapa.setView([lat, lng], 16);
                ponerMarcador(lat, lng, '📍 Tu ubicación actual');
            },
            () => {
                alert('No se pudo obtener la ubicación. Puedes elegirla en el mapa.');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
                /* Configuración de precisión:

                enableHighAccuracy:
                Solicita la mayor precisión posible.

                timeout:
                Espera máximo 10 segundos.

                maximumAge:
                No utiliza ubicaciones antiguas almacenadas.*/
            }
        );
    });
</script>
</x-app-layout>