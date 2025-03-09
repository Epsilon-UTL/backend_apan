

<!-- resources/views/welcome.blade.php -->
@if (Auth::check())
    <script>
        window.location = "{{ url('/desktop') }}";
    </script>
@else
    <a href="{{ route('login') }}">Login</a>
@endif