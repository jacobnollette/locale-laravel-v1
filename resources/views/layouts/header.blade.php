<header>
    <div id="header_container" class="container header_desktop">
        <div id="header_logo"><a href="/">Music Locale</a></div>

        @if (Route::has('login'))
            <div id="header_login">
                <div>
                    <ul>
                    @auth
                            <li><a href="{{ url('/spotify') }}">Settings</a></li>
                    @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @if (Route::has('register'))
                                <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endif
                    </ul>
                </div>
            </div>
        @endif
        <div class="clear">&nbsp;</div>
        <div id="header_nav">
            <ul>


                @auth
                    <li><a href="/explore">Explore</a></li>
                    <li><a href="/dashboard">Dashboard</a></li>
                @else

                @endif
            </ul>
        </div>
    </div>
    <div class="clear">&nbsp;</div>
    <div class="header_mobile">
        <div class="header_mobile_header"><a href="/">Music Locale</a></div>
        <div class="header_mobile_hamburger">
            <a href="#"><img src="/images/hamburger.svg"/></a>
        </div>
        <div class="clear">&nbsp;</div>
        <div class="header_mobile_nav hidden">
            <div class="header_mobile_nav_actual">
                <ul>

                    @auth
                        <li><a href="/explore">Explore</a></li>
                        <li><a href="/dashboard">Dashboard</a></li>
                        <li><a href="{{ url('/spotify') }}">Settings</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="clear">&nbsp;</div>
</header>
