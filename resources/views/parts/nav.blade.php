<?php
    use Illuminate\Support\Facades\Auth;

    if(Auth::check()) {
      $admin = Auth::user()->isAdmin();
    } else {
      $admin = false;
    }
  ?>

<navbar admin="{{ $admin }}"></navbar>