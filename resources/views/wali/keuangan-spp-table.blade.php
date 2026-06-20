<thead>
    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-tighter border-b border-gray-50">
        <th class="px-6 py-4">Periode Bulan</th>
        <th class="px-6 py-4">Tanggal Bayar</th>
        <th class="px-6 py-4">Jumlah</th>
        <th class="px-6 py-4 text-center">Status</th>
    </tr>
</thead>
<tbody class="divide-y divide-gray-50">
    @foreach($riwayatSpp as $item)
    <tr class="hover:bg-gray-50/50 transition">
        <td class="px-6 py-4 font-bold text-gray-700">
            {{ \Carbon\Carbon::parse($item->bulan)->translatedFormat('F Y') }}
        </td>
        <td class="px-6 py-4 text-[10px] text-gray-500 font-medium">
            {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '—' }}
        </td>
        <td class="px-6 py-4 font-bold text-gray-800 text-sm">
            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
        </td>
        <td class="px-6 py-4 text-center">
            @if($item->status == 'lunas')
                <span class="bg-emerald-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Lunas</span>
            @else
                <span class="bg-red-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Belum Bayar</span>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>