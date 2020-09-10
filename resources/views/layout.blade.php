<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  @include('parts.head')

  <body>
    @include('parts.nav')

    <div class="container mx-auto mt-20 p-2" id="app">
      @yield('content')
    </div>

    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
  </body>
</html>