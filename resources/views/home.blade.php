@extends("layouts.global")

@section("page_title", "Spotify - Home")

@section("page_content")
    <section id="main">
        <div class="container">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}





                </div>
            </div>
            <a href="/spotify">Start Spotify process!</a>
        </div>
    </section>
@endsection
