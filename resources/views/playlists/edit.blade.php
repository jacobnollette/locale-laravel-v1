@extends("layouts.global")

@section("page_title", "Music Locale - Dashboard")

@section("page_content")
    <section id="main">
        <div class="container">
            <h1>{{$playlist->name}}</h1>
            <div class="playlist_index-description">{{$playlist->description}}</div>
            <div class="playlist_index-tracks">
                @foreach ( $playlist->tracks->items as $track )
                    <div class="playlist_index-tracks-track">
                        <div class="playlist_index-tracks-title">
                            {{$track->track->name}}
                        </div>
                        <div class="playlist_index-tracks-artists">
                            <div class="playlist_index-tracks-artists-display">Artists:</div>
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
