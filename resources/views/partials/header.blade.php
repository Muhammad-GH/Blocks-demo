<gds-navigation
  accessible-navigation-label="{{ __('Primary menu', 'gds-a11y') }}"
  accessible-hamburger-label="{{ __('Menu', 'gds-a11y') }}"
>
  <div slot="menu-icon">
    <gds-hamburger data-hamburger>
      <span>{{ __('Menu', 'gds') }}</span>
    </gds-hamburger>
  </div>
  <nav class="brand-navigation">
    @if ($brand_navigation)
      <gds-menu direction="horizontal">
        <a class="logo logo--mobile" slot="item" href="{{ home_url('/') }}" rel="home" aria-label="{{ sprintf(__('%s frontpage', 'gds-a11y'), $siteName) }}">
          <img
            src="{{ get_field('site_logo', 'options') ?: Roots\asset('images/logo.svg')->uri() }}"
            alt=""
            title="{{ __('Go to frontpage', 'gds-a11y') }}"
            width="70"
            height="14"
            loading="eager"
            aria-hidden="true"
          />
        </a>

        @foreach ($brand_navigation as $item)
          @include('partials.menu-item', ['item' => $item])
        @endforeach
      </gds-menu>
    @endif

    @if ($languages)
      <div class="language-menu language-menu--desktop">
        <gds-menu>
          @foreach ($languages as $language)
            @include('partials.menu-item', ['item' => $language, 'class' => 'no-barba'])
          @endforeach
        </gds-menu>
      </div>
    @endif
  </nav>
  <a slot="logo" href="{{ home_url('/') }}" rel="home" aria-label="{{ sprintf(__('%s frontpage', 'gds-a11y'), $siteName) }}">
    <img
      src="{{ get_field('site_logo', 'options') ?: Roots\asset('images/logo.svg')->uri() }}"
      alt=""
      title="{{ __('Go to frontpage', 'gds-a11y') }}"
      width="119"
      height="24"
      loading="eager"
      aria-hidden="true"
    />
  </a>
  <div slot="menu">
    @if ($primary_navigation)
      <gds-menu>
        @foreach ($primary_navigation as $item)
          @include('partials.menu-item', ['item' => $item])
        @endforeach
      </gds-menu>
    @endif
  </div>
  <div slot="desktop-extensions">
    <form
      class="header-search header-search--desktop"
      action="{{ home_url('/') }}"
      method="get"
      role="search"
    >
      <gds-input-wrapper label="Hae sivulla" hide-label-visually>
        <input slot="input" type="search" name="s" placeholder="{{ __('Syötä hakusana', 'gds') }}" autocomplete="off" />
      </gds-input-wrapper>

      <button type="submit" aria-label="{{ __('Hae', 'gds-a11y') }}">
        <i class="fal fa-search" aria-hidden="true"></i>
      </button>
    </form>

    <nav aria-label="{{ __('Toiminnat', 'gds-a11y') }}" class="navigation-actions">
      <gds-menu direction="horizontal">
        <button slot="item" data-search-focus-button>
          <gds-menu-item class="navigation-search-icon--mobile">
            <div class="icon-menu-item">
              <span>{{ __('Haku', 'gds') }}</span>
              <i class="fal fa-search"></i>
            </div>
          </gds-menu-item>
        </button>
            <!--  Shopping basked and Login link ---  For FI Logic To be added later  -->
        @if (get_current_blog_id() !== 1)
                <a slot="item" href="{{ $account_url }}" data-when-logged-out>
          <gds-menu-item>
            <div class="icon-menu-item">
              <span>{{ __('Kirjaudu', 'gds') }}</span>
              <i class="fal fa-lock-alt"></i>
            </div>
          </gds-menu-item>
        </a>
        <a slot="item" href="{{ $account_url }}" data-when-logged-in class="is-hidden">
          <gds-menu-item>
            <div class="icon-menu-item">
              <span data-mobile-label="{{ __('Tili', 'gds') }}">{{ __('Omat sivut', 'gds') }}</span>
              <i class="fal fa-user"></i>
            </div>
          </gds-menu-item>
        </a>
        <a slot="item" href="{{ $cart_url }}">
          <gds-menu-item>
            <div class="icon-menu-item">
              <span data-mobile-label="{{ __('Kori', 'gds') }}">{{ __('Ostoskori', 'gds') }}</span>
              <i class="fal fa-shopping-cart"></i>
              <span class="menu-cart-counter" data-menu-cart-counter></span>
            </div>
          </gds-menu-item>
        </a>
      @endif
      <!--  Shopping basked and Login link --- To be added later  -->

      </gds-menu>
    </nav>
  </div>
  <div slot="mobile-extensions">
    <form
      class="header-search header-search--mobile"
      action="{{ home_url('/') }}"
      method="get"
      role="search"
    >
      <gds-input-wrapper label="Hae sivulla" hide-label-visually>
        <input slot="input" type="search" name="s" placeholder="{{ __('Mitä etsit?', 'gds') }}" autocomplete="off" />
      </gds-input-wrapper>

      <button type="submit" aria-label="{{ __('Hae', 'gds-a11y') }}">
        <i class="fal fa-search" aria-hidden="true"></i>
      </button>
    </form>

    @if ($languages)
      <div class="language-menu language-menu--mobile">
        <gds-menu direction="horizontal">
          @foreach ($languages as $language)
            @include('partials.menu-item', ['item' => $language, 'class' => 'no-barba'])
          @endforeach
        </gds-menu>
      </div>
    @endif
  </div>
</gds-navigation>
