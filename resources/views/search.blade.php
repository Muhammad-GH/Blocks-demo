@extends('layouts.app')

@section('content')
  <div class="archive archive__page search alignwide">
    <div class="archive__breadcrumb">
      @include('partials.breadcrumb')
    </div>

    <div class="archive__main">
      @include('partials.page-header')

      @if (! have_posts())
        <x-alert type="warning">
          {!! __('Sorry, no results were found.', 'sage') !!}
        </x-alert>
      @endif

      <div>
        @php $query = $GLOBALS['wp_query']; @endphp

        <div class="grid" id="listing">
          @while ($query->have_posts()) @php $query->the_post() @endphp
            <div class="cell">
              @includeFirst(['teasers.search-result', 'teasers.teaser'], ['post' => get_post()])
            </div>
          @endwhile
          @php wp_reset_postdata() @endphp
        </div>

        @include('partials.pagination', ['query' => $query, 'fragment' => 'listing'])
      </div>
    </div>

    <div class="archive__sidebar">
    </div>
  </div>
@endsection
