
<a class="sr-only-focusable" href="#main-content">
  {{ __('Skip to content', 'gds-a11y') }}
</a>

@include('partials.header')

<div class="container">
  <main class="is-root-container" data-barba="container">
    @yield('content')
  </main>
</div>

@include('partials.footer')
