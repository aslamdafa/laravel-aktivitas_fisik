@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah / Tautkan Siswa</h2>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div style="color:red">
            <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guru.siswa.store') }}" method="POST">
        @csrf

        <div>
            <label>Nama Siswa</label><br>
            <input type="text" name="nama" value="{{ old('nama') }}" required>
        </div>

        <div>
            <label>Kelas</label><br>
            <input type="text" name="kelas" value="{{ old('kelas') }}" required>
        </div>

        <hr>

        <div>
            <label>Pilih Orang Tua (jika sudah ada)</label><br>
            <select name="parent_id" id="parent_select">
                <option value="">-- Pilih orang tua (atau isi data baru di bawah) --</option>
                @foreach($ortuList as $o)
                    <option value="{{ $o->id }}" {{ old('parent_id') == $o->id ? 'selected' : '' }}>
                        {{ $o->name }} ({{ $o->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <p>Atau isi data orang tua baru:</p>

        <div>
            <label>Nama Orang Tua</label><br>
            <input type="text" name="parent_name" value="{{ old('parent_name') }}">
        </div>

        <div>
            <label>Email Orang Tua</label><br>
            <input type="email" name="parent_email" value="{{ old('parent_email') }}">
        </div>

        <br>
        <button type="submit">Simpan Siswa</button>
    </form>
</div>

<script>
    // kecil: jika select parent dipilih, kosongkan input parent baru (bukan wajib)
    document.getElementById('parent_select').addEventListener('change', function() {
        if (this.value) {
            // clear optional inputs (visual convenience)
            document.querySelector('input[name="parent_name"]').value = '';
            document.querySelector('input[name="parent_email"]').value = '';
        }
    });
</script>
@endsection
