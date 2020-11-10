@extends("layouts.global")

@section("page_title", "Music Locale - Welcome")

@section("page_content")
    <section id="main">
        <div class="container">




            <h1>Welcome</h1>
            @auth
                <h2>Your Spotify account is connected</h2>
                <h2>Take me to <a href="/dashboard">Dashboard</a></h2>
            @else
                <h2>Please register my account <br\> (in the upper right)</h2>
            @endif


        </div>
    </section>
@endsection
