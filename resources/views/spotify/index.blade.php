@extends("layouts.global")

@section("page_title", "Music Locale - Settings")

@section("page_content")
    <section id="main">
        <div class="container">


            @isset( $user->spotify_access_token )
                <h1>Your Spotify account is connected</h1>
                <h2>Take me to <a href="/dashboard">Dashboard</a></h2>
            @endisset

            <h1>Spotify Configuration</h1>
                <p>If you're having trouble with your spotify account, please connect or reconnect below</p>
            <div id="spotify_connect_button"><a href="/spotify/auth">Connect or Reconnect Spotify account!</a></div>

        </div>
    </section>
@endsection
