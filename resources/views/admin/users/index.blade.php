@extends('layouts.admin', ['title' => 'Kelola Data Pengguna - Admin Smart Shop'])

@section('page_title', 'Kelola Pengguna')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900">Data Pengguna & Peran (Role)</h2>
            <p class="text-xs text-slate-500">Kelola hak akses administrator dan akun customer pembeli.</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="flex-1 w-full relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email pengguna..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:border-brand-600 outline-none">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
            </div>

            <select name="role" class="w-full sm:w-48 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 outline-none">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
            </select>

            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-brand-600 transition-colors">
                Filter
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Pengguna</th>
                        <th class="py-3.5 px-6">Kontak & Alamat</th>
                        <th class="py-3.5 px-6">Role Akses</th>
                        <th class="py-3.5 px-6">Pesanan</th>
                        <th class="py-3.5 px-6">Terdaftar Pada</th>
                        <th class="py-3.5 px-6 text-right">Ubah Role / Hapus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-brand-600 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-extrabold text-slate-900 truncate">{{ $user->name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-slate-800 font-semibold">{{ $user->phone ?: '-' }}</p>
                                <p class="text-[10px] text-slate-400 truncate max-w-xs">{{ $user->city ? $user->city . ', Aceh' : '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-emerald-100 text-emerald-700 border border-emerald-200' }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold text-[11px]">
                                    {{ $user->orders_count }} Pesanan
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($user->id !== Auth::id())
                                    <div class="inline-flex items-center gap-2">
                                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'customer' : 'admin' }}">
                                            <button type="submit" class="px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $user->role === 'admin' ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' }} transition-colors" title="Ubah Role">
                                                Jadikan {{ $user->role === 'admin' ? 'Customer' : 'Admin' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user {{ $user->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition-colors" title="Hapus User">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-400 font-semibold italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection

