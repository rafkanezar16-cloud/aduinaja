@if ($item->status === 'diajukan')
    <form method="POST" action="{{ route('admin.pengaduan.status', $item) }}">
        @csrf @method('PATCH')
        <input type="hidden" name="status" value="diproses">
        <button class="px-3 py-1.5 rounded-lg border border-blue-200 text-blue-600 text-xs font-semibold hover:bg-blue-50">Terima</button>
    </form>
    <form method="POST" action="{{ route('admin.pengaduan.status', $item) }}"
          onsubmit="var r = prompt('Alasan penolakan (opsional):'); if (r === null) return false; this.catatan_admin.value = r;">
        @csrf @method('PATCH')
        <input type="hidden" name="status" value="ditolak">
        <input type="hidden" name="catatan_admin" value="">
        <button class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 text-xs font-semibold hover:bg-red-50">Tolak</button>
    </form>
@elseif ($item->status === 'diproses')
    <form method="POST" action="{{ route('admin.pengaduan.status', $item) }}">
        @csrf @method('PATCH')
        <input type="hidden" name="status" value="selesai">
        <button class="px-3 py-1.5 rounded-lg border border-green-200 text-green-600 text-xs font-semibold hover:bg-green-50">Selesaikan</button>
    </form>
@endif
<a href="{{ route('admin.pengaduan.show', $item) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Lihat</a>
