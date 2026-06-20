<x-app-layout>

<div class="p-6">

<h1 class="text-2xl font-bold">

Absensi Sholat

</h1>

<form
action="{{route('absensi-sholat.create')}}"
method="GET">

<input
type="date"
name="tanggal"
class="border p-2 mt-4">

<input
type="text"
name="kamar"
placeholder="Nama Kamar"
class="border p-2">

<button
class="bg-blue-500 text-white px-4 py-2">

Tampilkan

</button>

</form>

</div>

</x-app-layout>