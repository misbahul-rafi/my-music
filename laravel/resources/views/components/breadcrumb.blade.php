{{-- <nav class="flex p-3" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
      @foreach ($breadcrumbs as $breadcrumb)
        <li class="inline-flex items-center">
          @if (!$loop->last)
            <a href="{{ $breadcrumb['url'] }}" class="ms-1 text-sm font-medium text-text hover:text-title md:ms-2">
              @if ($loop->first)
                <i class="bi bi-house-fill mr-1"></i>
              @endif
              {{ $breadcrumb['title'] }}
            </a>
          @else
            <span class="ms-1 text-sm font-medium text-text md:ms-2">{{ $breadcrumb['title'] }}</span>
          @endif
          @if (!$loop->last)
            <i class="bi bi-chevron-right text-sm text-text"></i>
          @endif
        </li>
      @endforeach
    </ol>
  </nav> --}}
