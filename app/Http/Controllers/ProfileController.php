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
        $auth = Auth::guard('customer');
        $customer = $auth->user();
        if (!$customer) {
            return redirect()->route('home', ['login' => 1]);
        }

        $orders = Order::where('id_cust', $customer->id_cust)
                       ->with('detailOrders.product')
                       ->orderBy('id_order', 'desc')
                       ->get();

        return view('profile.profile', [
            'customer' => $customer,
            'orders' => $orders
        ]);
    }

    public function update(Request $a)
    {
        $auth = Auth::guard('customer');
        $customer = $auth->user();
        if (!$customer) {
            return redirect()->route('home', ['login' => 1]);
        }

        // Update foto jika ada
        if ($a->hasFile('foto')) {
            if ($customer->foto) {
                $path = public_path('uploads/' . $customer->foto);
                if (\Illuminate\Support\Facades\File::exists($path)) {
                    \Illuminate\Support\Facades\File::delete($path);
                }
            }
            $file = $a->file('foto');
            $namaFile = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
            $customer->foto = $namaFile;
        }

        $customer->nama_lengkap = $a->nama_lengkap;
        $customer->email = $a->email;
        $customer->no_telp = $a->no_telp;
        if ($a->filled('alamat')) { $customer->alamat = $a->alamat; }
        $customer->save();

        return redirect('/profile')->with('success', 'Data diri berhasil diperbarui');
    }

    public function detailOrder($id)
    {
        $auth = Auth::guard('customer');
        if (!$auth->check()) { return redirect()->route('home', ['login' => 1]); }

        $order = \App\Models\Order::with('detailOrders.product')
                    ->where('id_order', $id)
                    ->firstOrFail();

        return view('profile.detail_order', compact('order'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed|regex:/[A-Z]/',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar (A-Z).',
        ]);

        $customer = Auth::guard('customer')->user();
        if (!$customer) { return redirect()->route('home', ['login' => 1]); }

        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        $customer->password = $request->password; // akan di-hash via cast
        $customer->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function logout(Request $a)
    {
        Auth::guard('customer')->logout();
        $a->session()->invalidate();
        $a->session()->regenerateToken();

        return redirect('/');
    }
}