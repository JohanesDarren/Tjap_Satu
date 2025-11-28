<h3 class="h5 fw-bold mb-4 text-dark">Alamat Pengiriman</h3>
<div class="card border border-light-subtle rounded-3 p-4">
    <form>
        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary text-uppercase">Nama Penerima</label>
            <input type="text" value="{{ $customer->nama_lengkap }}"
                class="form-control bg-light border-secondary-subtle fs-6" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary text-uppercase">Alamat Lengkap</label>
            <textarea rows="4" class="form-control bg-light border-secondary-subtle fs-6"
                readonly>{{ $customer->alamat }}</textarea>
        </div>
        <div class="text-end">
            <button type="button" onclick="triggerTab('v-pills-edit-tab')"
                class="btn btn-custom-green btn-sm fw-bold px-4">Ubah Alamat</button>
        </div>
    </form>
</div>