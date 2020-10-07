@extends("layouts.global")

@section("page_title", "Spotify - Login")

@section("page_content")
    <section id="main">
        <div class="container">
            {{ $token }}

            <div id="spotify_connect_button"><a href="https://accounts.spotify.com/authorize?response_type=token&client_id={{ $client_id }}&redirect_uri={{ $redirect_url }}">Link to Spotify</a></div>


        </div>
    </section>
@endsection
