<header>
    <div id="header_container" class="container">
        <div id="header_logo"><a href="/">Music Locale</a></div>

        @if (Route::has('login'))
            <div id="header_login">
                <div>
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endif
                </div>
            </div>
        @endif
        <div class="clear">&nbsp;</div>
    </div>
</header>
