@extends("layouts.global")

@section("page_title", "Music Locale")

@section("page_content")
    <section id="main">
        <div class="container">

            <div id="login_index">



                <div class="clear">&nbsp;</div>



                <div id="login_index-form">
                    <div id="login_index-header"><h1>Welcome</h1></div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="login_index-form">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            <div class="login_index-form_error">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="login_index-form">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password">
                            <div class="login_index-form_error">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="login_index-form_remember" class="login_index-form">
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                        </div>


                        <div id="login_index-form_submit" class="login_index-form">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <div class="clear">&nbsp;</div>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        </div>

                    </form>
                </div>
                <div id="login_index-disclaimer">
                    <h3>Music Locale requires a Spotify account, and the ability to modify playlists. Playlists which users
                        unlock will be added to their account. Existing playlists will not be modified, only shared per the
                        users request.</h3>
                </div>
                <div class="clear">&nbsp;</div>
            </div>
        </div>
    </section>
@endsection
