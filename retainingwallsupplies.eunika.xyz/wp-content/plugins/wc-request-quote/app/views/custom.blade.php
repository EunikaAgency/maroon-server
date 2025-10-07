@extends('layouts.app')

@section('content')
    @if (have_posts())
        @while (have_posts())
            @php the_post() @endphp
            @include('partials.page-header')
            @include('partials.content-page')
        @endwhile
    @else
        {{ get_bloginfo('name') }}
        <h1>Hello World</h1>
    @endif
@endsection
