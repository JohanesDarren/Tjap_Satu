# Tjap Satu - Mobile API Backend

API Backend untuk aplikasi mobile Tjap Satu (Toko Kopi). Dibangun dengan Laravel 12 dan Laravel Sanctum untuk authentication.

## 📋 Fitur API

### ✅ Authentication
- Register user baru
- Login/Logout
- Token-based authentication (Sanctum)
- Profile management

### ✅ Products
- List semua produk dengan filter dan pagination
- Detail produk
- Filter berdasarkan kategori (jenis kopi)
- Search produk
- Filter stok tersedia

### ✅ Shopping Cart
- Tambah produk ke cart
- Update quantity
- Hapus item
- Clear cart
- Real-time stock checking

### ✅ Orders
- Create order dari cart
- History order
- Detail order
- Cancel order
- Upload bukti pembayaran
- Apply promo code

### ✅ Promos
- List promo aktif
- Validasi kode promo
- Otomatis hitung diskon

### ✅ Content Management
- Banners untuk home page
- Blog articles
- Kurir/delivery drivers list

## 🚀 Quick Start

### 1. Clone & Install
```bash
cd c:\Users\USER\Documents\PABW\TjapSatu\Tjap_Satu
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
php artisan storage:link
```

### 2. Configure .env
```env
APP_URL=http://127.0.0.1:8000
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:8000
SESSION_DRIVER=cookie
FILESYSTEM_DISK=public
```

### 3. Run Server
```bash
php artisan serve
```

API tersedia di: `http://127.0.0.1:8000/api/v1`

## 📚 Documentation

- **[API Documentation](API_DOCUMENTATION.md)** - Dokumentasi lengkap semua endpoints
- **[Setup Guide](SETUP_API.md)** - Panduan instalasi dan konfigurasi
- **[Postman Collection](Tjap_Satu_API.postman_collection.json)** - Import ke Postman untuk testing

## 🏗️ Struktur API

```
routes/
  └── api.php                          # API Routes

app/Http/Controllers/Api/
  ├── AuthController.php               # Register, Login, Logout
  ├── ProductController.php            # Products management
  ├── CartController.php               # Shopping cart
  ├── OrderController.php              # Orders & payments
  ├── ProfileController.php            # User profile
  ├── BannerController.php             # Home banners
  ├── BlogController.php               # Blog articles
  ├── PromoController.php              # Promo codes
  └── KurirController.php              # Delivery drivers
```

## 🔐 Authentication

API menggunakan Laravel Sanctum untuk token-based authentication.

### Login Flow:
1. POST `/api/v1/login` dengan email & password
2. Simpan token dari response
3. Gunakan token di header: `Authorization: Bearer {token}`
4. Token valid hingga logout

### Example:
```bash
# Login
curl -X POST http://127.0.0.1:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'

# Use token
curl http://127.0.0.1:8000/api/v1/cart \
  -H "Authorization: Bearer 1|xxxxxxxxx" \
  -H "Accept: application/json"
```

## 📦 Main Endpoints

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/register` | ❌ | Register user baru |
| POST | `/login` | ❌ | Login user |
| POST | `/logout` | ✅ | Logout user |
| GET | `/products` | ❌ | List produk |
| GET | `/products/{id}` | ❌ | Detail produk |
| GET | `/cart` | ✅ | Lihat cart |
| POST | `/cart` | ✅ | Tambah ke cart |
| PUT | `/cart/{id}` | ✅ | Update cart item |
| DELETE | `/cart/{id}` | ✅ | Hapus dari cart |
| GET | `/orders` | ✅ | List orders |
| POST | `/orders` | ✅ | Create order |
| GET | `/orders/{id}` | ✅ | Detail order |
| PUT | `/orders/{id}/cancel` | ✅ | Cancel order |
| POST | `/orders/{id}/payment` | ✅ | Upload bukti bayar |
| GET | `/promos/active` | ❌ | Promo aktif |
| POST | `/promos/validate` | ❌ | Validasi promo |
| GET | `/banners` | ❌ | Home banners |
| GET | `/blogs` | ❌ | Blog articles |
| GET | `/profile` | ✅ | User profile |
| PUT | `/profile` | ✅ | Update profile |

## 🧪 Testing dengan Postman

1. Import file `Tjap_Satu_API.postman_collection.json` ke Postman
2. Set variable `base_url` ke `http://127.0.0.1:8000/api/v1`
3. Test login → token otomatis tersimpan
4. Test endpoints lainnya

## 📱 Integrasi dengan Flutter

### Install HTTP Package
```yaml
dependencies:
  http: ^1.1.0
```

### Basic Usage
```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  static const String baseUrl = 'http://YOUR_IP:8000/api/v1';
  static String? token;

  // Login
  static Future<void> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
      body: jsonEncode({'email': email, 'password': password}),
    );
    
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      token = data['data']['token'];
    }
  }

  // Get Products
  static Future<List> getProducts() async {
    final response = await http.get(
      Uri.parse('$baseUrl/products'),
      headers: {'Accept': 'application/json'},
    );
    
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return data['data'];
    }
    return [];
  }

  // Add to Cart
  static Future<void> addToCart(int productId, int quantity) async {
    await http.post(
      Uri.parse('$baseUrl/cart'),
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: jsonEncode({
        'id_product': productId,
        'quantity': quantity,
      }),
    );
  }
}
```

### IP Address untuk Testing
- **Android Emulator**: `10.0.2.2:8000`
- **iOS Simulator**: `localhost:8000`
- **Physical Device**: `192.168.1.x:8000` (IP komputer Anda)

### Allow HTTP di Android
Edit `android/app/src/main/AndroidManifest.xml`:
```xml
<application
    android:usesCleartextTraffic="true"
    ...>
```

## 🔧 Models & Database

### Tables:
- `customer` - User accounts
- `product` - Coffee products
- `carts` & `cart_items` - Shopping cart
- `order` & `detail_order` - Orders
- `payment` - Payment records
- `promos` - Discount codes
- `banners` - Home banners
- `blogs` - Blog articles
- `kurir` - Delivery drivers

### Relationships:
- Customer → Orders (1:many)
- Order → DetailOrder (1:many)
- Order → Payment (1:1)
- Cart → CartItems (1:many)
- Product → DetailOrder (1:many)

## ⚙️ Configuration Files

### CORS (config/cors.php)
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['*'], // Development
'supports_credentials' => true,
```

### Sanctum (config/sanctum.php)
```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,localhost:3000')),
```

## 🐛 Troubleshooting

### Token tidak valid
- Pastikan format header: `Authorization: Bearer {token}`
- Cek token belum expired/dihapus

### CORS Error
- Tambahkan header `Accept: application/json`
- Cek konfigurasi di `config/cors.php`

### File upload gagal
- Jalankan `php artisan storage:link`
- Cek permission folder storage

### Route not found
- Pastikan menggunakan prefix `/api/v1`
- Clear cache: `php artisan route:clear`

## 📈 Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

## 🔒 Security Notes

### Development
✅ CORS allowed from any origin
✅ HTTP allowed
✅ Debug mode on

### Production
⚠️ Set specific CORS origins
⚠️ HTTPS only
⚠️ Debug mode off
⚠️ Rate limiting
⚠️ Input validation
⚠️ File upload restrictions

## 📝 Changelog

### Version 1.0.0 (December 2025)
- ✅ Authentication API (Register, Login, Logout)
- ✅ Products API with filters & pagination
- ✅ Shopping Cart API
- ✅ Orders & Payment API
- ✅ Profile Management
- ✅ Promo validation
- ✅ Content APIs (Banners, Blogs)
- ✅ Complete documentation

## 👥 API Response Format

### Success Response:
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

### Error Response:
```json
{
  "success": false,
  "message": "Error message",
  "errors": { ... }
}
```

## 🤝 Contributing

Untuk menambah atau mengubah API:
1. Tambah route di `routes/api.php`
2. Buat/update controller di `app/Http/Controllers/Api/`
3. Update dokumentasi di `API_DOCUMENTATION.md`
4. Update Postman collection
5. Test semua endpoints

## 📧 Support

Untuk pertanyaan atau issue:
- Baca dokumentasi lengkap di [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- Cek setup guide di [SETUP_API.md](SETUP_API.md)
- Test dengan Postman collection

## 🎯 Next Steps

- [ ] Install Laravel Sanctum
- [ ] Run migrations
- [ ] Test all endpoints
- [ ] Integrate with Flutter app
- [ ] Add rate limiting
- [ ] Deploy to production

---

**Built with ❤️ using Laravel 12 & Laravel Sanctum**
