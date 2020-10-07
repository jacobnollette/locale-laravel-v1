<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SpotifyController extends Controller
{
  public function index()
  {
    return view('spotify/index');
  }
  public function response()
  {
      return view( 'spotify/response');
  }
}
