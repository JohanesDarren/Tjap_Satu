<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil customer pertama (Sesuaikan logic ini jika sudah ada fitur login)
        $data_customer = Customer::first();
        
        // Ambil data order untuk history
        $data_order = Order::where('id_cust', $data_customer->id_cust)
                           ->orderBy('created_at', 'desc')
                           ->get();

        // Kirim data ke view profile
        return view('profile.profile', [
            'customer' => $data_customer,
            'orders' => $data_order
        ]);
    }

    // Method ini menggabungkan logic upload foto & update data diri
    // Gayanya mengikuti method update() di DosenController kamu
    public function update(Request $a)
    {
        // Cari data customer berdasarkan ID (disini kita ambil yang first dulu)
        $data_customer = Customer::first();

        // 1. UPDATE FOTO JIKA ADA FILE BARU
        if ($a->hasFile('foto')) {
            
            // Hapus foto lama jika ada
            if ($data_customer->foto) {
                $path = public_path('uploads/' . $data_customer->foto);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // Upload foto baru ke folder public/uploads
            $file = $a->file('foto');
            // Nama file: waktu + nama asli file agar unik
            $namaFile = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            // Simpan nama file ke database
            $data_customer->foto = $namaFile;
        }

        // 2. UPDATE FIELD LAIN
        $data_customer->nama_lengkap = $a->nama_lengkap;
        $data_customer->email = $a->email;
        $data_customer->no_telp = $a->no_telp;
        
        // Alamat (Optional, jika di form ada input name="alamat")
        if($a->filled('alamat')) {
            $data_customer->alamat = $a->alamat;
        }

        $data_customer->save();

        return redirect('/profile')->with('success', 'Data diri berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            // ATURAN BARU DISINI:
            'password' => 'required|min:8|confirmed|regex:/[A-Z]/', 
        ], [
            // PESAN ERROR BAHASA INDONESIA:
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar (A-Z).',
        ]);

        $customer = \App\Models\Customer::first(); // Sesuaikan dengan Auth nanti

        // Cek password lama
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // Update password
        $customer->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $customer->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function logout(Request $a)
    {
        Auth::logout();
        $a->session()->invalidate();
        $a->session()->regenerateToken();

        return redirect('/');
    }
}