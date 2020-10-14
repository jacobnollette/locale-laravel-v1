@extends("layouts.global")

@section("page_title", "Spotify - Login")

@section("page_content")
    <section id="main">
        <div class="container">

            <div id="playlists">
                @foreach ($playlists as $playlist)
                    <div class="playlist" data-playlist_id="{{$playlist->id}}">
                        <div class="playlist_image"><img src="{{$playlist->images[0]->url}}"/></div>
                        <div class="playlist_name">{{$playlist->name}}</div>
                        <div class="clear">&nbsp;</div>
                    </div>
                @endforeach
            </div>


        </div>
    </section>
@endsection
