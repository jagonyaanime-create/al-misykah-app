<x-app-layout>

<div class="p-6">

<h1 class="text-xl font-bold">

Input Absensi Sholat

</h1>

<form
method="POST"
action="{{route('absensi-sholat.store')}}">

@csrf

<input
type="hidden"
name="tanggal"
value="{{request('tanggal')}}">

<table class="table-auto w-full mt-4">

<thead>

<tr>

<th>Nama</th>
<th>Subuh</th>
<th>Dzuhur</th>
<th>Ashar</th>
<th>Maghrib</th>
<th>Isya</th>

</tr>

</thead>

<tbody>

@foreach($santri as $s)

<tr>

<td>

{{$s->nama}}

</td>

@foreach([
'subuh',
'dzuhur',
'ashar',
'maghrib',
'isya'
] as $waktu)

<td>

<select
name="santri[{{$s->id}}][{{$waktu}}]"
class="border">

<option value="hadir">
Hadir
</option>

<option value="izin">
Izin
</option>

<option value="sakit">
Sakit
</option>

<option value="alfa">
Alfa
</option>

</select>

</td>

@endforeach

</tr>

@endforeach

</tbody>

</table>

<button
class="bg-green-500 text-white px-5 py-2 mt-5">

Simpan

</button>

</form>

</div>

</x-app-layout>