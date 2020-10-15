@extends("layouts.global")

@section("page_title", "Music Locale - Explorer")

@section("page_content")
    <section id="main">
        <div class="container">
            <div id="explorer_index">
                @foreach ($playlists as $playlist)
                    <div class="playlist" data-playlist_id="{{$playlist->id}}">
                        <div class="playlist_image"><img src="{{$playlist->images[0]->url}}"/></div>
                        <div class="playlist_display">
                            <div class="playlist_name">{{$playlist->name}}</div>
                            <div class="controls">
                                <a class="playlist_add @if ( $playlist->inCrate == "yes" )
                                    in_library
@endif
                                    " href="#">Follow Playlist</a>
                            </div>
                        </div>
                        <div class="clear">&nbsp;</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
