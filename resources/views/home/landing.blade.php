@extends("layouts.global")

@section("page_title", "Music Locale - Welcome")

@section("page_content")
    <section id="main">
        <div class="container">
            <div id="home_landing">

                <h1>Welcome</h1>
                <div style="text-align: center;">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/WJ5H0yKax10" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @auth
                    <div id="home_landing-display">
                        <div id="home_landing-display_explore">
                            <h2><a href="/explore">Explore and find new Music</a></h2></div>
                        <div id="home_landing-display_plus"><h2>+</h2></div>
                        <div id="home_landing-display_dashboard">
                            <h2><a href="/dashboard">Share music from the Dashboard</a></h2></div>
                    </div>
                @else
                    <h2>Please register my account <br\> (in the upper right)</h2>
                    <p>Music Locale requires a Spotify account, and the ability to modify playlists. Playlists which
                        users unlock will be added to their account. Existing playlists will not be modified, only
                        shared per the users request.</p>
                @endif


            </div>
        </div>
    </section>
@endsection
