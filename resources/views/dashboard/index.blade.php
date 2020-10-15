@extends("layouts.global")

@section("page_title", "Music Locale - Dashboard")

@section("page_content")
    <section id="main">
        <div class="container">
            <h1>Dashboard</h1>

            <div id="playlists_index">
                @foreach ($playlists as $playlist)
                    <div class="playlist" data-playlist_id="{{$playlist->id}}">
                        <div class="playlist_image"><img src="{{$playlist->images[0]->url}}"/></div>
                        <div class="playlist_display">
                            <div class="playlist_name">{{$playlist->name}}</div>
                            <div class="controls">
                                <a class="playlist_add @if ( $playlist->inCrate == "yes" )
                                    in_crate
@endif
                                    " href="#">Share Playlist</a>
                            </div>
                        </div>
                        <div class="clear">&nbsp;</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
