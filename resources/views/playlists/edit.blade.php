@extends("layouts.global")

@section("page_title", "Music Locale - Dashboard")

@section("page_content")
    <section id="main">
        <div id="playlists_edit" class="container">
            <div id="playlist_edit-meta">
                <div id="playlists_edit-header">
                    <h1>{{$playlist->name}}</h1>
                    <div id="playlists_edit-header_share"><a href="#">{{$crate_message}}</a></div>
                </div>
                <div class="playlists_edit-description">{{$playlist->description}}</div>

            </div>



            <div class="playlists_edit-tracks">
                <ul id="playlists_edit-tracks-list">
                    @foreach ( $playlist->tracks->items as $track )
                        <li class="playlists_edit-tracks-track" data-id="{{$track->track->id}}">
                            <div class="playlists_edit-tracks-title">
                                {{$track->track->name}}
                            </div>
                            <div class="playlists_edit-artist_break">&mdash;</div>
                            <div class="playlists_edit-tracks-artists">
                                <div class="playlists_edit-tracks-artists-display">Artists:</div>
                                <ul>
                                    @foreach( $track->track->artists as $artist )
                                        <li>
                                            <a href="https://open.spotify.com/artist/{{$artist->id}}">{{$artist->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        <!-- {{$track->track->album->name}} -->
                        </li>
                    @endforeach
                </ul>
            </div>




            <div id="playlsits_edit-map">
                <div id="playlist_location" data-lat="{{$location[0]}}" data-long="{{$location[1]}}">&nbsp;</div>

                {{--            <div class="clear">&nbsp;</div>--}}

                <div id="playlists_edit-location">
                    <form id="playlists_edit-location_form">
                        <h3>Provide location below</h3>
                        <input id="playlist_edit-location_field" type="text">
                        <input id="playlist_edit-location_submit" type="submit" value="Search">
                    </form>
                    <div id="playlist_edit-location_list">
                        <ul>

                        </ul>
                    </div>
                </div>
                <div id="playlists_edit-map"></div>
            </div>
            <div class="clear">&nbsp;</div>
        </div>
    </section>
@endsection
