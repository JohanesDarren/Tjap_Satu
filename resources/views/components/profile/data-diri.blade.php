{{-- ========================== DATA DIRI ========================== --}}
<div id="dataDiri" class="tab-section active">
    <div class="cover"></div>

    <div class="profile-header">
        <img src="{{ $profile['avatar'] }}" alt="Avatar" class="avatar">
        <div>
            <h4>{{ $profile['first_name'] }} {{ $profile['last_name'] }}</h4>
            <p>Pelanggan Setia TJAP SATU</p>
        </div>
    </div>


    <div class="form-section">
        <form>
            <!-- Form Data Diri -->
            <div class="row">
                <div class="col">
                    <label>Nama Depan</label>
                    <input type="text" value="{{ $profile['first_name'] }}">
                </div>
                <div class="col">
                    <label>Nama Belakang</label>
                    <input type="text" value="{{ $profile['last_name'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Email</label>
                    <input type="email" value="{{ $profile['email'] }}">
                </div>
                <div class="col">
                    <label>No. Telepon</label>
                    <input type="text" value="{{ $profile['phone'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Kota</label>
                    <input type="text" value="{{ $profile['city'] }}">
                </div>
                <div class="col">
                    <label>Provinsi</label>
                    <input type="text" value="{{ $profile['state'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Kode Pos</label>
                    <input type="text" value="{{ $profile['postcode'] }}">
                </div>
                <div class="col">
                    <label>Negara</label>
                    <input type="text" value="{{ $profile['country'] }}">
                </div>
            </div>
            <div class="text-end mt-3">
                <button class="btn-update"><i class="bi bi-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
