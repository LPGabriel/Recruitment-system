<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Dashboard extends Controller
{
  public function index()
  {
    $user = Auth()->user()->name;
    $palavras = explode(' ', $user);
    $nome = $palavras[0];

    return view('content.dashboard.dashboard', [
      'nome' => $nome,
    ]);
  }
}