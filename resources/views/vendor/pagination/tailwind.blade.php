{{--
    Override view pagination bawaan Laravel (pagination::tailwind).
    Bawaannya memakai palet abu-abu + kelas dark: yang ikut mode gelap OS;
    di sini diganti gaya terang dengan aksen merah Telkom agar selaras
    dengan halaman lain. Struktur & logika paginator tidak diubah.
--}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman">

        {{-- ── Layar kecil: cukup tombol Sebelumnya / Berikutnya ── --}}
        <div class="flex gap-2 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1.5 h-9 px-4 text-xs font-bold text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center gap-1.5 h-9 px-4 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:border-brand-200 hover:bg-brand-50 hover:text-telkom-red transition-colors">
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center gap-1.5 h-9 px-4 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:border-brand-200 hover:bg-brand-50 hover:text-telkom-red transition-colors">
                    Berikutnya
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 h-9 px-4 text-xs font-bold text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed">
                    Berikutnya
                </span>
            @endif
        </div>

        {{-- ── Layar sedang ke atas: ringkasan + nomor halaman ── --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between sm:gap-4">
            <p class="text-xs text-slate-400">
                Menampilkan
                @if ($paginator->firstItem())
                    <span class="font-bold text-slate-600 tnum">{{ $paginator->firstItem() }}</span>–<span class="font-bold text-slate-600 tnum">{{ $paginator->lastItem() }}</span>
                @else
                    <span class="font-bold text-slate-600 tnum">{{ $paginator->count() }}</span>
                @endif
                dari <span class="font-bold text-slate-600 tnum">{{ $paginator->total() }}</span> data
            </p>

            <span class="inline-flex items-center gap-1">

                {{-- Halaman sebelumnya --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Halaman sebelumnya"
                          class="inline-flex items-center justify-center h-9 w-9 rounded-xl text-slate-300 border border-slate-200 bg-white cursor-not-allowed">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya"
                       class="inline-flex items-center justify-center h-9 w-9 rounded-xl text-slate-500 border border-slate-200 bg-white hover:border-brand-200 hover:bg-brand-50 hover:text-telkom-red transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                {{-- Nomor halaman --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true"
                              class="inline-flex items-center justify-center h-9 min-w-9 px-2 text-xs font-bold text-slate-300 cursor-default">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                      class="inline-flex items-center justify-center h-9 min-w-9 px-3 rounded-xl text-xs font-bold text-white bg-telkom-red border border-telkom-red shadow-brand cursor-default tnum">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}"
                                   class="inline-flex items-center justify-center h-9 min-w-9 px-3 rounded-xl text-xs font-bold text-slate-600 border border-slate-200 bg-white hover:border-brand-200 hover:bg-brand-50 hover:text-telkom-red transition-colors tnum">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Halaman berikutnya --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya"
                       class="inline-flex items-center justify-center h-9 w-9 rounded-xl text-slate-500 border border-slate-200 bg-white hover:border-brand-200 hover:bg-brand-50 hover:text-telkom-red transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="Halaman berikutnya"
                          class="inline-flex items-center justify-center h-9 w-9 rounded-xl text-slate-300 border border-slate-200 bg-white cursor-not-allowed">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </span>
        </div>
    </nav>
@endif
