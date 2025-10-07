<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')

<body @php body_class() @endphp>

    @php get_header() @endphp

    <div class="wrap" role="document">
        <div class="content">
            <main class="main">
                @yield('content')
            </main>

            @php get_sidebar() @endphp
        </div>
    </div>

    @php get_footer() @endphp

    @php wp_footer() @endphp
</body>

</html>
