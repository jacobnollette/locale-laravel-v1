@extends("layouts.global")

@section("page_title", "Music Locale - Explorer")

@section("page_content")
    <section id="main">
        <div class="container">
            <div id="explorer_index">
                <div id="explorer_map"></div>
                <div id="explorer_map_location"></div>
                <div class="clear">&nbsp;</div>
                <div id="explorer_map_no_location">Please allow location to explore; <br/>loading...</div>
                <div class="clear">&nbsp;</div>
            </div>
        </div>
    </section>
@endsection
