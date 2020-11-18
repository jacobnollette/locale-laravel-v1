@extends("layouts.global")

@section("page_title", "Music Locale - Welcome")

@section("page_content")
    <section id="main">
        <div class="container">




            <h1>Welcome</h1>
            @auth
                <h2>Explore and find new <a href="/explore">Music</a></h2>
                <h2>Share music from the <a href="/dashboard">Dashboard</a></h2>

            @else
                <h2>Please register my account <br\> (in the upper right)</h2>
                <p>Music Locale requires a Spotify account, and the ability to modify playlists. Playlists which users unlock will be added to their account. Existing playlists will not be modified, only shared per the users request.</p>
            @endif


        </div>
    </section>
@endsection
