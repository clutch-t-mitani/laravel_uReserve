<html>
  <head>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
  </head>
  <body>
    livewireテスト <span class="text-blue-600">register</span>
    {{-- <livewire:counter /> --}}
    @livewire('register')
    @livewireScripts
  </body>
</html>