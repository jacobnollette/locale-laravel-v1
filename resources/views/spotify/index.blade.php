@extends("layouts.global")

@section("page_title", "Spotify - Login")

@section("page_content")
    <section id="main">
        <div class="container">


            @isset( $user->spotify_access_token )
                <h1>Your Spotify account is connected</h1>
                <h2>Take me to <a href="/dashboard">Dashboard</a></h2>
            @endisset

            <div id="spotify_connect_button"><a href="/spotify/auth">Connect or Reconnect Spotify account!</a></div>

        </div>
    </section>
@endsection
