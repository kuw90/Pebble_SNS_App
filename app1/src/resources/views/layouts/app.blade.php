<x-layouts::app.sidebar :title="$title ?? null">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('js/like.js') }}"></script>

    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>