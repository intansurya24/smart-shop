@extends('layouts.admin', ['title' => 'Moderasi Ulasan - Admin Smart Shop'])

@section('page_title', 'Moderasi Ulasan Pelanggan')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900">Ulasan & Rating Produk</h2>
            <p class="text-xs text-slate-500">Moderasi testimoni, komentar, dan bintang kepuasan pelanggan.</p>
        </div>
    </div>

    <!-- Filter by Star -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2">
        <a href="{{ route('admin.reviews.index') }}" 
           class="px-3.5 py-1.5 rounded-xl text-xs font-bold {{ !request('rating') ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
            Semua Bintang
        </a>
        @for($s = 5; $s >= 1; $s--)
            <a href="{{ route('admin.reviews.index', ['rating' => $s]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1 {{ request('rating') == $s ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                <span>{{ $s }}</span> <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
            </a>
        @endfor
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Produk</th>
                        <th class="py-3.5 px-6">Rating Bintang</th>
                        <th class="py-3.5 px-6">Komentar Ulasan</th>
                        <th class="py-3.5 px-6">Status Tampil</th>
                        <th class="py-3.5 px-6 text-right">Moderasi / Hapus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reviews as $rev)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-extrabold text-slate-900">{{ $rev->user->name }}</p>
                                <span class="text-[10px] text-slate-400">{{ $rev->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($rev->product)
                                    <a href="{{ route('products.show', $rev->product->slug) }}" target="_blank" class="font-bold text-brand-600 hover:underline line-clamp-1 max-w-xs">
                                        {{ $rev->product->name }}
                                    </a>
                                @else
                                    <span class="text-slate-400">Produk telah dihapus</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $rev->rating ? '' : 'text-slate-200' }}"></i>
                                    @endfor
                                    <span class="font-bold text-slate-700 ml-1.5">({{ $rev->rating }})</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600 max-w-sm">
                                <p class="line-clamp-2 italic">"{{ $rev->comment }}"</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $rev->is_approved ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $rev->is_approved ? 'Ditampilkan' : 'Disembunyikan' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $rev->is_approved ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }} transition-colors">
                                            {{ $rev->is_approved ? 'Sembunyikan' : 'Tampilkan' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition-colors" title="Hapus Ulasan">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada ulasan pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $reviews->links() }}
        </div>
    </div>

</div>
@endsection

