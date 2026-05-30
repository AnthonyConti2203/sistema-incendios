<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo reporte de incendio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        Revisa los campos del formulario.
                    </div>
                @endif

                <form method="POST" action="{{ route('reports.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Descripción</label>
                        <textarea name="description" class="w-full border rounded p-2" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
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
                        <label class="block mb-2 font-medium">Tipo de ubicación</label>
                        <select name="location_type" id="location_type" class="w-full border rounded p-2">
                            <option value="manual" {{ old('location_type') == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="auto" {{ old('location_type') == 'auto' ? 'selected' : '' }}>Automática</option>
                        </select>
                        @error('location_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mb-4">
                        <button type="button" id="btnUbicacionActual"
                                class="px-4 py-2 bg-blue-600 text-white rounded">
                            Usar mi ubicación actual
                        </button>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Selecciona la ubicación en el mapa</label>
                        <p class="text-sm text-gray-500 mb-2">Haz clic en el mapa para marcar el punto exacto del incendio.</p>
                        <div id="mapa" style="height: 350px; border-radius: 8px; border: 1px solid #ccc;"></div>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">
                        Enviar reporte
                    </button>
                </form>
            </div>
        </div>
    </div>

 {{-- Leaflet CSS y JS (mapa gratuito sin API key) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const inputLat  = document.getElementById('latitude');
    const inputLng  = document.getElementById('longitude');
    const inputTipo = document.getElementById('location_type');

    // Centro aproximado de Arequipa
    const defaultLat = -16.409047;
    const defaultLng = -71.537451;

    // Inicializar mapa
    const mapa = L.map('mapa').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapa);

    // Marcador (se crea solo al hacer clic)
    let marcador = null;

    // Si ya hay valores guardados (por old()), colocar marcador
    if (inputLat.value && inputLng.value) {
        const lat = parseFloat(inputLat.value);
        const lng = parseFloat(inputLng.value);
        marcador = L.marker([lat, lng]).addTo(mapa);
        mapa.setView([lat, lng], 15);
    }

    // Clic en el mapa → guardar coordenadas
    mapa.on('click', (e) => {
        const { lat, lng } = e.latlng;

        inputLat.value  = lat.toFixed(7);
        inputLng.value  = lng.toFixed(7);
        inputTipo.value = 'manual';

        if (marcador) {
            marcador.setLatLng([lat, lng]);
        } else {
            marcador = L.marker([lat, lng]).addTo(mapa);
        }

        marcador.bindPopup(`📍 ${lat.toFixed(5)}, ${lng.toFixed(5)}`).openPopup();
    });

    // Botón ubicación actual → centra y marca en el mapa
    document.getElementById('btnUbicacionActual').addEventListener('click', () => {
        if (!navigator.geolocation) {
            alert('Tu navegador no permite geolocalización.');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                inputLat.value  = lat.toFixed(7);
                inputLng.value  = lng.toFixed(7);
                inputTipo.value = 'auto';

                mapa.setView([lat, lng], 16);

                if (marcador) {
                    marcador.setLatLng([lat, lng]);
                } else {
                    marcador = L.marker([lat, lng]).addTo(mapa);
                }

                marcador.bindPopup('📍 Tu ubicación actual').openPopup();
            },
            () => {
                alert('No se pudo obtener la ubicación. Haz clic en el mapa para marcarla.');
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    });
</script>
</x-app-layout>