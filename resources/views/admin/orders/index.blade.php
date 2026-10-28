@extends('layouts.admin', ['title' => 'Manajemen Pesanan & Resi - Admin Smart Shop'])

@section('page_title', 'Pesanan & Resi Pengiriman')

@section('content')
<div class="space-y-6" x-data="{
    trackingModalOpen: false,
    statusModalOpen: false,
    selectedOrder: { id: '', order_number: '', tracking_number: '', shipping_courier: 'JNE Express', order_status: 'processing', payment_status: 'paid' },
    
    openTrackingModal(order) {
        this.selectedOrder = {
            id: order.id,
            order_number: order.order_number,
            tracking_number: order.tracking_number || '',
            shipping_courier: order.shipping_courier || 'JNE Express',
            order_status: order.order_status,
            payment_status: order.payment_status
        };
        this.trackingModalOpen = true;
    },

    openStatusModal(order) {
        this.selectedOrder = {
            id: order.id,
            order_number: order.order_number,
            tracking_number: order.tracking_number || '',
            shipping_courier: order.shipping_courier || 'JNE Express',
            order_status: order.order_status,
            payment_status: order.payment_status
        };
        this.statusModalOpen = true;
    }
}">

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-3xl border border-slate-200 p-4 sm:p-6 shadow-sm">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <div class="sm:col-span-6 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari No. Pesanan, Nama Penerima, atau Resi..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:border-brand-600 outline-none">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
            </div>

            <div class="sm:col-span-4">
                <select name="status" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 outline-none">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status Pesanan</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses Penjual</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dalam Pengiriman</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Pesanan Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <button type="submit" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Pesanan</th>
                        <th class="py-3.5 px-6">Penerima & Alamat Aceh</th>
                        <th class="py-3.5 px-6">Total Tagihan</th>
                        <th class="py-3.5 px-6">Status Bayar</th>
                        <th class="py-3.5 px-6">Status Kirim & Resi</th>
                        <th class="py-3.5 px-6 text-right">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $ord)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-mono font-black text-slate-900 text-sm">#{{ $ord->order_number }}</p>
                                <span class="text-[10px] text-slate-400">{{ $ord->created_at->format('d M Y, H:i') }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ $ord->items->count() }} item</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ $ord->recipient_name }}</p>
                                <p class="text-[11px] text-slate-500 font-medium">{{ $ord->shipping_city }}</p>
                                <p class="text-[10px] text-slate-400 truncate max-w-xs">{{ $ord->shipping_address }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-black text-brand-700 text-sm">{{ $ord->formatted_total }}</span>
                                <span class="text-[10px] text-slate-400 block">Ongkir: {{ $ord->formatted_shipping_cost }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $ord->payment_status_badge_class }}">
                                    {{ strtoupper($ord->payment_status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold border {{ $ord->status_badge_class }} mb-1 inline-block">
                                    {{ $ord->status_label }}
                                </span>
                                @if($ord->tracking_number)
                                    <p class="text-[11px] font-mono font-bold text-slate-800">
                                        <i class="fa-solid fa-barcode text-brand-500 mr-1"></i>{{ $ord->tracking_number }}
                                    </p>
                                    <span class="text-[10px] text-slate-400">({{ $ord->shipping_courier }})</span>
                                @else
                                    <span class="text-[10px] text-amber-600 block font-medium">Belum ada resi</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Input Resi Button -->
                                    <button type="button" @click="openTrackingModal({{ json_encode($ord) }})"
                                            class="px-2.5 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-[11px] flex items-center gap-1" title="Input Resi">
                                        <i class="fa-solid fa-truck"></i> Resi
                                    </button>

                                    <!-- Status Button -->
                                    <button type="button" @click="openStatusModal({{ json_encode($ord) }})"
                                            class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] flex items-center gap-1" title="Ubah Status">
                                        <i class="fa-solid fa-sliders"></i> Status
                                    </button>

                                    <!-- Invoice Detail -->
                                    <a href="{{ route('admin.orders.show', $ord->id) }}" 
                                       class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors" title="Lihat Invoice">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada pesanan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Modal Input Resi & Kurir -->
    <div x-show="trackingModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div @click.outside="trackingModalOpen = false" class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-6 shadow-2xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Input Nomor Resi Pengiriman</h3>
                    <p class="text-xs text-slate-400">Pesanan <span class="font-mono font-bold text-slate-800" x-text="'#' + selectedOrder.order_number"></span></p>
                </div>
                <button type="button" @click="trackingModalOpen = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form :action="'{{ url('admin/orders') }}/' + selectedOrder.id + '/tracking'" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Kurir / Ekspedisi</label>
                    <select name="shipping_courier" x-model="selectedOrder.shipping_courier" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 outline-none">
                        <option value="JNE Express">JNE Express</option>
                        <option value="SiCepat REG">SiCepat REG</option>
                        <option value="J&T Express">J&T Express</option>
                        <option value="POS Indonesia">POS Indonesia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor Resi Resmi</label>
                    <input type="text" name="tracking_number" x-model="selectedOrder.tracking_number" required placeholder="Contoh: JNE-BND-9988220011"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono font-bold text-slate-900 focus:bg-white focus:border-brand-600 outline-none">
                    <p class="text-[11px] text-slate-400 mt-1">Status pesanan akan otomatis berubah ke <strong>'Dalam Pengiriman'</strong>.</p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" @click="trackingModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-brand-600 text-white font-bold text-xs hover:bg-brand-700 shadow-md">Simpan Resi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ubah Status Pesanan -->
    <div x-show="statusModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div @click.outside="statusModalOpen = false" class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-6 shadow-2xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Ubah Status Pesanan</h3>
                    <p class="text-xs text-slate-400">Pesanan <span class="font-mono font-bold text-slate-800" x-text="'#' + selectedOrder.order_number"></span></p>
                </div>
                <button type="button" @click="statusModalOpen = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form :action="'{{ url('admin/orders') }}/' + selectedOrder.id + '/status'" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Pembayaran</label>
                    <select name="payment_status" x-model="selectedOrder.payment_status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 outline-none">
                        <option value="unpaid">UNPAID (Belum Bayar)</option>
                        <option value="paid">PAID (Lunas)</option>
                        <option value="failed">FAILED (Gagal)</option>
                        <option value="expired">EXPIRED (Kadaluarsa)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Pesanan</label>
                    <select name="order_status" x-model="selectedOrder.order_status" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 outline-none">
                        <option value="pending">Menunggu Pembayaran</option>
                        <option value="processing">Diproses Penjual</option>
                        <option value="shipped">Dalam Pengiriman</option>
                        <option value="completed">Pesanan Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" @click="statusModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-brand-600 text-white font-bold text-xs hover:bg-brand-700 shadow-md">Perbarui Status</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

