<!doctype html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @include('Layout.links')
</head>

<body>

    @include('Layout.header')

    @yield('content')
    
    @include('Layout.footer')
    
    @include('Layout.script')
    
</body>
</html>