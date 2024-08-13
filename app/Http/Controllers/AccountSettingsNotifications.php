<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountSettingsNotifications extends Controller
{
  public function index()
  {
    return view('profile.account-settings-notifications');
  }
}
