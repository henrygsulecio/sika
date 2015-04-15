<div id="main-menu" class="navbar navbar-inverse navbar-fixed-top navbar-main" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/" title="{{ Config::get('site.company') }}">{{ Config::get('site.company') }}</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-list navbar-right">
        @if (Session::get('userLogged', 0) == 0)
          <li><a href="{{ URL::route('login') }}">Login</a></li>
        @else

          <li><a href="{{ URL::route('info') }}">Info</a></li>
         <li><a href="{{ URL::route('cliente') }}">Add Cliente</a></li>
          <li><a href="{{ URL::route('dologout') }}">Logout</a></li>
        @endif
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>