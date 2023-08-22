<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  @include('parts.head')

  <body class="bg-gray-100 text-gray-900 dark:text-gray-200 dark:bg-gray-900 h-full top-0 overflow-x-hidden">
    <div id="app">
      <div class="container mx-auto py-20 p-2 h-full">
        @yield('content')
      </div>
    </div>

    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
  </body>
</html>