<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <!--
    Barra de navegación principal del sistema.
    x-data pertenece a Alpine.js y crea una variable llamada "open".
    Esta variable se utiliza para abrir o cerrar el menú móvil.
    -->

    <!-- Menú principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!--Contenedor principal del menú.

        Mantiene los elementos alineados y limita el ancho máximo.-->

        <div class="flex justify-between h-16">

            <div class="flex">

                <!-- Logo del sistema -->
                <div class="shrink-0 flex items-center">

                    <!-- Al hacer clic en el logo se redirige al dashboard.-->

                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>

                </div>

                <!-- Enlaces principales -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <!--Enlace al Dashboard.

                    request()->routeIs() permite resaltar el enlace
                    cuando el usuario se encuentra en esa página-->

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                </div>

            </div>

            <!-- Menú desplegable del usuario -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <!--Menú ubicado en la esquina superior derecha.

                Contiene:
                - Nombre del usuario
                - Perfil
                - Cerrar sesión-->

                <x-dropdown align="right" width="48">

                    <!-- Botón que abre el menú -->
                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">

                            <!--Muestra el nombre del usuario autenticado.

                            Si por alguna razón no existe usuario,
                            muestra la palabra "Usuario"-->

                            <div>{{ Auth::user()->name ?? 'Usuario' }}</div>

                            <!-- Flecha del menú desplegable -->
                            <div class="ms-1">

                                <svg class="fill-current h-4 w-4"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">

                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />

                                </svg>

                            </div>

                        </button>

                    </x-slot>

                    <!-- Contenido del menú desplegable -->
                    <x-slot name="content">

                        <!-- Abre la página de edición del perfil-->

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Cerrar sesión -->
                        <form method="POST" action="{{ route('logout') }}">

                            <!-- Token de seguridad obligatorio para formularios-->

                            @csrf

                            <!-- Cierra la sesión del usuario actual-->

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                         this.closest('form').submit();">

                                {{ __('Log Out') }}

                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- Botón hamburguesa para celulares -->
            <div class="-me-2 flex items-center sm:hidden">

                <!-- Este botón solo aparece en pantallas pequeñas.

                Al hacer clic cambia el valor de "open"
                entre verdadero y falso. -->

                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">

                    <!-- Icono del menú móvil -->

                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">

                        <!-- Tres líneas del menú -->

                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <!-- X para cerrar menú -->

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>

        </div>

    </div>

    <!-- Menú responsive -->
    <div :class="{'block': open, 'hidden': ! open}"
         class="hidden sm:hidden">

        <!-- Este menú aparece únicamente en dispositivos móviles-->

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')"
                                   :active="request()->routeIs('dashboard')">

                {{ __('Dashboard') }}

            </x-responsive-nav-link>

        </div>

        <!-- Información del usuario -->
        <div class="pt-4 pb-1 border-t border-gray-200">

            <div class="px-4">

                <!-- Nombre del usuario -->

                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name ?? 'Usuario' }}
                </div>

                <!-- Correo del usuario -->

                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email ?? 'correo@ejemplo.com' }}
                </div>

            </div>

            <!-- Opciones móviles -->
            <div class="mt-3 space-y-1">

                <!-- Editar perfil -->

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Cerrar sesión -->

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                 this.closest('form').submit();">

                        {{ __('Log Out') }}

                    </x-responsive-nav-link>

                </form>

            </div>

        </div>

    </div>

</nav>