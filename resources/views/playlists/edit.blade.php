@extends("layouts.global")

@section("page_title", "Music Locale - Dashboard")

@section("page_content")
    <section id="main">
        <div class="container">
            <h1>{{$playlist->name}}</h1>
            <div class="playlists_edit-description">{{$playlist->description}}</div>
            <div class="playlists_edit-tracks">
                @foreach ( $playlist->tracks->items as $track )
                    <div class="playlists_edit-tracks-track">
                        <div class="playlists_edit-tracks-title">
                            {{$track->track->name}}
                        </div>
                        <div class="playlists_edit-tracks-artists">
                            <div class="playlists_edit-tracks-artists-display">Artists:</div>
                            <ul>
                                @foreach( $track->track->artists as $artist )
                                    <li>{{$artist->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- {{$track->track->album->name}} -->
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
