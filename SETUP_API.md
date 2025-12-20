# Setup API untuk Mobile App

## Prerequisites
- PHP >= 8.2
- Composer
- Laravel 12.x
- MySQL/PostgreSQL

## Installation Steps

### 1. Install Laravel Sanctum

Jika Sanctum belum terinstall, jalankan:

```bash
composer require laravel/sanctum
```

### 2. Publish Sanctum Configuration

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 3. Run Migration

Sanctum memerlukan tabel `personal_access_tokens`:

```bash
php artisan migrate
```

### 4. Configure Sanctum

Buka file `config/sanctum.php` dan pastikan konfigurasi sesuai:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
    env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
))),
```

### 5. Update CORS Configuration

Edit file `config/cors.php`:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],

'allowed_methods' => ['*'],

'allowed_origins' => ['*'], // Untuk development, ubah ke domain spesifik untuk production

'allowed_origins_patterns' => [],

'allowed_headers' => ['*'],

'exposed_headers' => [],

'max_age' => 0,

'supports_credentials' => true,
```

### 6. Update .env File

Tambahkan atau update konfigurasi berikut di file `.env`:

```env
# API Configuration
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:8000
SESSION_DRIVER=cookie
SESSION_DOMAIN=localhost

# Storage
FILESYSTEM_DISK=public
```

### 7. Create Storage Link

Agar gambar dapat diakses dari frontend:

```bash
php artisan storage:link
```

### 8. Test API

Jalankan development server:

```bash
php artisan serve
```

API akan tersedia di: `http://127.0.0.1:8000/api/v1`

## Testing dengan Postman/Thunder Client

### 1. Register User

**POST** `http://127.0.0.1:8000/api/v1/register`

Headers:
```
Content-Type: application/json
Accept: application/json
```

Body:
```json
{
  "nama_lengkap": "Test User",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "no_telp": "08123456789",
  "alamat": "Jl. Test No. 123"
}
```

### 2. Login

**POST** `http://127.0.0.1:8000/api/v1/login`

Body:
```json
{
  "email": "test@example.com",
  "password": "password123"
}
```

Simpan `token` dari response untuk request selanjutnya.

### 3. Get Products

**GET** `http://127.0.0.1:8000/api/v1/products`

Headers:
```
Accept: application/json
```

### 4. Add to Cart

**POST** `http://127.0.0.1:8000/api/v1/cart`

Headers:
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {YOUR_TOKEN}
```

Body:
```json
{
  "id_product": 1,
  "quantity": 2
}
```

### 5. Create Order

**POST** `http://127.0.0.1:8000/api/v1/orders`

Headers:
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {YOUR_TOKEN}
```

Body:
```json
{
  "tipe_pesanan": "delivery",
  "id_kurir": 1,
  "catatan": "Tolong antar siang",
  "metode_payment": "transfer"
}
```

## Troubleshooting

### Error: Unauthenticated

Pastikan:
1. Token dikirim dengan format yang benar: `Authorization: Bearer {token}`
2. Token masih valid (tidak expired atau dihapus)

### Error: CORS

Pastikan:
1. Header `Accept: application/json` selalu disertakan
2. CORS dikonfigurasi dengan benar di `config/cors.php`

### Error: 404 Not Found

Pastikan:
1. Route API ada di `routes/api.php`
2. Menggunakan prefix `/api/v1` di URL

### Error: Storage file not accessible

Jalankan:
```bash
php artisan storage:link
```

Dan pastikan folder `storage/app/public` memiliki permission yang benar.

## Security Notes untuk Production

1. **CORS**: Ubah `allowed_origins` di `config/cors.php` ke domain spesifik
```php
'allowed_origins' => ['https://yourdomain.com'],
```

2. **Rate Limiting**: Tambahkan rate limiting di routes
```php
Route::middleware(['throttle:60,1'])->group(function () {
    // routes here
});
```

3. **Environment**: Set `APP_ENV=production` dan `APP_DEBUG=false`

4. **HTTPS**: Gunakan HTTPS untuk production

5. **Token Expiration**: Configure token expiration di Sanctum

6. **Database**: Gunakan database production yang aman

7. **File Upload**: Validasi file upload dengan ketat

## Integration dengan Flutter

### 1. Install HTTP Package

Di Flutter project:
```yaml
dependencies:
  http: ^1.1.0
```

### 2. Example API Service (Dart)

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  static const String baseUrl = 'http://YOUR_IP:8000/api/v1';
  static String? token;

  static Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
      body: jsonEncode({'email': email, 'password': password}),
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      token = data['data']['token'];
      return data;
    } else {
      throw Exception('Login failed');
    }
  }

  static Future<Map<String, dynamic>> getProducts() async {
    final response = await http.get(
      Uri.parse('$baseUrl/products'),
      headers: {'Accept': 'application/json'},
    );

    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load products');
    }
  }

  static Future<Map<String, dynamic>> addToCart(int productId, int quantity) async {
    final response = await http.post(
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

    if (response.statusCode == 201) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to add to cart');
    }
  }
}
```

### 3. Update Base URL

Untuk testing di device fisik atau emulator, gunakan IP address komputer Anda:

```dart
// Untuk Android Emulator: 10.0.2.2
// Untuk iOS Simulator: localhost
// Untuk Physical Device: IP Address komputer Anda (e.g., 192.168.1.100)

static const String baseUrl = 'http://192.168.1.100:8000/api/v1';
```

### 4. Allow HTTP di Android

Edit `android/app/src/main/AndroidManifest.xml`:

```xml
<application
    android:usesCleartextTraffic="true"
    ...>
```

## Next Steps

1. ✅ API Routes created
2. ✅ Controllers implemented
3. ✅ Authentication with Sanctum
4. ✅ Documentation created
5. ⏭️ Test all endpoints
6. ⏭️ Integrate with Flutter app
7. ⏭️ Deploy to production server

Untuk dokumentasi lengkap API, lihat file `API_DOCUMENTATION.md`.
