@extends('base')
@section('title','Pekerjaan')
@section('menupekerjaan', 'underline decoration-4 underline-offset-7')
@section('content')
    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Pekerjaan</h1>
        <div class="mx-auto max-w-screen-xl">
            <form action="{{ route('pekerjaan.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="bg-gray-50 border @error('nama') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                    @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="bg-gray-50 border @error('deskripsi') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg block w-full p-2.5" autocomplete="off" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Captcha</label>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="relative bg-gradient-to-r from-gray-100 to-gray-200 border-2 border-gray-300 rounded-lg p-4 min-w-[180px] h-[60px] flex items-center justify-center">
                            <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, #000 10px, #000 11px);"></div>
                            <span id="captcha-text" class="text-2xl font-bold tracking-wider text-gray-800 select-none" style="font-family: 'Courier New', monospace; text-shadow: 2px 2px 4px rgba(0,0,0,0.2); letter-spacing: 8px; transform: skew(-5deg);"></span>
                        </div>
                        <button type="button" onclick="refreshCaptcha()" class="rounded-md bg-gray-600 px-3 py-2 text-sm text-white hover:bg-gray-700 cursor-pointer transition-colors">
                            Refresh
                        </button>
                    </div>
                    <input type="text" name="captcha" value="{{ old('captcha') }}" class="bg-gray-50 border @error('captcha') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg block w-full p-2.5 uppercase" placeholder="Masukkan kode captcha" required autocomplete="off" maxlength="6">
                    @error('captcha')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-2">
                    <button type="reset" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 cursor-pointer">Reset</button>
                    <button type="submit" class="rounded-md bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700 cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('js')
<script>
    // Load captcha on page load
    document.addEventListener('DOMContentLoaded', function() {
        refreshCaptcha();
    });

    function refreshCaptcha() {
        fetch("{{ route('captcha') }}?" + Date.now())
            .then(response => response.json())
            .then(data => {
                document.getElementById('captcha-text').textContent = data.captcha;
            })
            .catch(error => {
                console.error('Error loading captcha:', error);
                document.getElementById('captcha-text').textContent = 'ERROR';
            });
    }
</script>
@endpush
