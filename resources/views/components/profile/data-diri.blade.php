<div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="h5 fw-bold text-dark mb-0">Edit Data Diri</h3>
                            <button onclick="triggerTab('v-pills-history-tab')" class="btn btn-link text-secondary text-decoration-none small">Batal</button>
                        </div>

                        <div class="card border border-light-subtle rounded-3 p-4 position-relative overflow-hidden">

                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="position-relative z-1">
                                @csrf
                                @method('PUT')

                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="rounded-circle overflow-hidden bg-secondary" style="width: 64px; height: 64px;">
                                        @if($customer->foto)
                                            <img src="{{ asset('uploads/' . $customer->foto) }}" alt="Avatar" class="avatar-img" id="avatarPreview">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->nama_lengkap) }}&background=374151&color=fff&size=128" alt="Avatar" class="avatar-img" id="avatarPreview">
                                        @endif
                                    </div>
                                    <div>
                                        <label for="fotoInput" class="btn btn-link text-primary text-decoration-none fw-medium small p-0" style="cursor: pointer;">Ganti Foto</label>
                                        <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                                    </div>
                                </div>

                                <div class="vstack gap-3">
                                    <div>
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" value="{{ $customer->nama_lengkap }}" class="form-control bg-light border-secondary-subtle">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Email</label>
                                        <input type="email" name="email" value="{{ $customer->email }}" class="form-control bg-light border-secondary-subtle">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Nomor Telepon</label>
                                        <input type="text" name="no_telp" value="{{ $customer->no_telp }}" class="form-control bg-light border-secondary-subtle">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Alamat</label>
                                        <textarea name="alamat" rows="3" class="form-control bg-light border-secondary-subtle">{{ $customer->alamat }}</textarea>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-custom-green w-100 w-md-auto fw-bold shadow-sm">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>