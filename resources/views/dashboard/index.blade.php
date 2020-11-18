@extends("layouts.global")

@section("page_title", "Music Locale - Dashboard")

@section("page_content")
    <section id="main">
        <div class="container">
            <h1>Dashboard</h1>
            <p>If you see playlists in your dashboard, your Spotify account is connected!</p>

            <div id="playlists_index">
                @foreach ($playlists as $playlist)
                    <div class="playlist" data-playlist_id="{{$playlist->id}}">
                        <div class="playlist_image"><img src="{{$playlist->images[0]->url}}"/></div>
                        <div class="clear">&nbsp;</div>
                        <div class="playlist_display">
                            <div class="playlist_name">
                                <a href="/playlist/{{$playlist->id}}">{{$playlist->name}}</a>
                            </div>
                        </div>
                        <div class="clear">&nbsp;</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
