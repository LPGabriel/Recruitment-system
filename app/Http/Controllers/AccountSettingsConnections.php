<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountSettingsConnections extends Controller
{
  public function index()
  {
    return view('profile.account-settings-connections');
  }
}
