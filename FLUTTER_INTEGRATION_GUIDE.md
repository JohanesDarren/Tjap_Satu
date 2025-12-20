# Panduan Integrasi Flutter dengan API Tjap Satu

## 📁 Struktur Folder Flutter yang Disarankan

```
lib/
├── main.dart
├── models/
│   ├── user.dart
│   ├── product.dart
│   ├── cart_item.dart
│   ├── order.dart
│   ├── promo.dart
│   └── banner.dart
├── services/
│   ├── api_service.dart
│   ├── auth_service.dart
│   ├── product_service.dart
│   ├── cart_service.dart
│   └── order_service.dart
├── providers/ (jika pakai Provider/Riverpod)
│   ├── auth_provider.dart
│   ├── cart_provider.dart
│   └── product_provider.dart
├── screens/
│   ├── auth/
│   │   ├── login_screen.dart
│   │   └── register_screen.dart
│   ├── home/
│   │   └── home_screen.dart
│   ├── products/
│   │   ├── product_list_screen.dart
│   │   └── product_detail_screen.dart
│   ├── cart/
│   │   └── cart_screen.dart
│   └── orders/
│       ├── checkout_screen.dart
│       └── order_history_screen.dart
└── utils/
    ├── constants.dart
    └── shared_preferences_helper.dart
```

## 1️⃣ Setup Dependencies

Edit file `pubspec.yaml` di folder Flutter:

```yaml
dependencies:
  flutter:
    sdk: flutter
  
  # HTTP Request
  http: ^1.1.0
  
  # State Management (pilih salah satu)
  provider: ^6.1.1
  # atau
  # riverpod: ^2.4.9
  
  # Shared Preferences untuk menyimpan token
  shared_preferences: ^2.2.2
  
  # Image Picker untuk upload foto
  image_picker: ^1.0.5
  
  # Cached Network Image untuk load gambar dari API
  cached_network_image: ^3.3.0
  
  # Intl untuk format tanggal dan currency
  intl: ^0.18.1
```

Jalankan:
```bash
cd c:\Users\USER\Documents\DPPB\tjap1\Tjap1-Flutter
flutter pub get
```

## 2️⃣ Konfigurasi Base URL

Buat file `lib/utils/constants.dart`:

```dart
class ApiConstants {
  // Ganti dengan IP address komputer Anda
  // Untuk Android Emulator: gunakan 10.0.2.2
  // Untuk iOS Simulator: gunakan localhost
  // Untuk Physical Device: gunakan IP local komputer (e.g., 192.168.1.100)
  
  static const String baseUrl = 'http://192.168.1.100:8000/api/v1';
  
  // Endpoints
  static const String register = '$baseUrl/register';
  static const String login = '$baseUrl/login';
  static const String logout = '$baseUrl/logout';
  static const String user = '$baseUrl/user';
  static const String products = '$baseUrl/products';
  static const String cart = '$baseUrl/cart';
  static const String orders = '$baseUrl/orders';
  static const String profile = '$baseUrl/profile';
  static const String banners = '$baseUrl/banners';
  static const String promos = '$baseUrl/promos';
  static const String kurir = '$baseUrl/kurir';
}
```

**PENTING:** Cara mendapatkan IP Address komputer Anda:
```bash
# Di Windows PowerShell (di komputer yang menjalankan Laravel):
ipconfig

# Cari "IPv4 Address" di adapter yang aktif (biasanya WiFi atau Ethernet)
# Contoh: 192.168.1.100
```

## 3️⃣ Models

### User Model (`lib/models/user.dart`)

```dart
class User {
  final int id;
  final String namaLengkap;
  final String email;
  final String noTelp;
  final String alamat;
  final String? foto;

  User({
    required this.id,
    required this.namaLengkap,
    required this.email,
    required this.noTelp,
    required this.alamat,
    this.foto,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      namaLengkap: json['nama_lengkap'],
      email: json['email'],
      noTelp: json['no_telp'],
      alamat: json['alamat'],
      foto: json['foto'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'nama_lengkap': namaLengkap,
      'email': email,
      'no_telp': noTelp,
      'alamat': alamat,
      'foto': foto,
    };
  }
}
```

### Product Model (`lib/models/product.dart`)

```dart
class Product {
  final int id;
  final String namaProduk;
  final String deskripsi;
  final double harga;
  final int stok;
  final String jenis;
  final String? proses;
  final String? gambar;
  final bool available;

  Product({
    required this.id,
    required this.namaProduk,
    required this.deskripsi,
    required this.harga,
    required this.stok,
    required this.jenis,
    this.proses,
    this.gambar,
    required this.available,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'],
      namaProduk: json['nama_produk'],
      deskripsi: json['deskripsi'],
      harga: (json['harga'] as num).toDouble(),
      stok: json['stok'],
      jenis: json['jenis'],
      proses: json['proses'],
      gambar: json['gambar'],
      available: json['available'],
    );
  }
}
```

### Cart Item Model (`lib/models/cart_item.dart`)

```dart
class CartItem {
  final int id;
  final Product product;
  final int quantity;
  final double subtotal;

  CartItem({
    required this.id,
    required this.product,
    required this.quantity,
    required this.subtotal,
  });

  factory CartItem.fromJson(Map<String, dynamic> json) {
    return CartItem(
      id: json['id'],
      product: Product.fromJson(json['product']),
      quantity: json['quantity'],
      subtotal: (json['subtotal'] as num).toDouble(),
    );
  }
}
```

## 4️⃣ Auth Service

Buat `lib/services/auth_service.dart`:

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/user.dart';
import '../utils/constants.dart';

class AuthService {
  static String? _token;

  // Get token dari SharedPreferences saat app start
  static Future<void> loadToken() async {
    final prefs = await SharedPreferences.getInstance();
    _token = prefs.getString('auth_token');
  }

  // Save token ke SharedPreferences
  static Future<void> saveToken(String token) async {
    _token = token;
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
  }

  // Clear token (logout)
  static Future<void> clearToken() async {
    _token = null;
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
  }

  // Check if user logged in
  static bool isLoggedIn() {
    return _token != null && _token!.isNotEmpty;
  }

  // Get token
  static String? getToken() {
    return _token;
  }

  // Register
  static Future<Map<String, dynamic>> register({
    required String namaLengkap,
    required String email,
    required String password,
    required String passwordConfirmation,
    required String noTelp,
    required String alamat,
  }) async {
    try {
      final response = await http.post(
        Uri.parse(ApiConstants.register),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: jsonEncode({
          'nama_lengkap': namaLengkap,
          'email': email,
          'password': password,
          'password_confirmation': passwordConfirmation,
          'no_telp': noTelp,
          'alamat': alamat,
        }),
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 201) {
        // Save token
        await saveToken(data['data']['token']);
        return {
          'success': true,
          'user': User.fromJson(data['data']['user']),
        };
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Registration failed',
          'errors': data['errors'],
        };
      }
    } catch (e) {
      return {
        'success': false,
        'message': 'Network error: $e',
      };
    }
  }

  // Login
  static Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    try {
      final response = await http.post(
        Uri.parse(ApiConstants.login),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: jsonEncode({
          'email': email,
          'password': password,
        }),
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 200) {
        // Save token
        await saveToken(data['data']['token']);
        return {
          'success': true,
          'user': User.fromJson(data['data']['user']),
        };
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Login failed',
        };
      }
    } catch (e) {
      return {
        'success': false,
        'message': 'Network error: $e',
      };
    }
  }

  // Logout
  static Future<Map<String, dynamic>> logout() async {
    try {
      if (_token == null) {
        return {'success': false, 'message': 'Not logged in'};
      }

      final response = await http.post(
        Uri.parse(ApiConstants.logout),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $_token',
        },
      );

      await clearToken();

      if (response.statusCode == 200) {
        return {'success': true};
      } else {
        return {'success': false, 'message': 'Logout failed'};
      }
    } catch (e) {
      await clearToken(); // Clear token anyway
      return {'success': false, 'message': 'Network error: $e'};
    }
  }

  // Get Current User
  static Future<User?> getCurrentUser() async {
    try {
      if (_token == null) return null;

      final response = await http.get(
        Uri.parse(ApiConstants.user),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $_token',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return User.fromJson(data['data']);
      }
      return null;
    } catch (e) {
      return null;
    }
  }
}
```

## 5️⃣ Product Service

Buat `lib/services/product_service.dart`:

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/product.dart';
import '../utils/constants.dart';

class ProductService {
  // Get All Products
  static Future<Map<String, dynamic>> getProducts({
    String? jenis,
    String? search,
    bool? available,
    int page = 1,
    int perPage = 15,
  }) async {
    try {
      var uri = Uri.parse(ApiConstants.products);
      
      Map<String, String> queryParams = {
        'page': page.toString(),
        'per_page': perPage.toString(),
      };
      
      if (jenis != null) queryParams['jenis'] = jenis;
      if (search != null) queryParams['search'] = search;
      if (available != null) queryParams['available'] = available.toString();
      
      uri = uri.replace(queryParameters: queryParams);

      final response = await http.get(
        uri,
        headers: {
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        final products = (data['data'] as List)
            .map((json) => Product.fromJson(json))
            .toList();
        
        return {
          'success': true,
          'products': products,
          'meta': data['meta'],
        };
      } else {
        return {
          'success': false,
          'message': 'Failed to load products',
        };
      }
    } catch (e) {
      return {
        'success': false,
        'message': 'Network error: $e',
      };
    }
  }

  // Get Single Product
  static Future<Product?> getProduct(int id) async {
    try {
      final response = await http.get(
        Uri.parse('${ApiConstants.products}/$id'),
        headers: {
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return Product.fromJson(data['data']);
      }
      return null;
    } catch (e) {
      return null;
    }
  }

  // Get Products by Category
  static Future<List<Product>> getProductsByCategory(String jenis) async {
    try {
      final response = await http.get(
        Uri.parse('${ApiConstants.products}/category/$jenis'),
        headers: {
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return (data['data'] as List)
            .map((json) => Product.fromJson(json))
            .toList();
      }
      return [];
    } catch (e) {
      return [];
    }
  }
}
```

## 6️⃣ Cart Service

Buat `lib/services/cart_service.dart`:

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/cart_item.dart';
import '../utils/constants.dart';
import 'auth_service.dart';

class CartService {
  // Get Cart
  static Future<Map<String, dynamic>> getCart() async {
    try {
      final token = AuthService.getToken();
      if (token == null) {
        return {'success': false, 'message': 'Not authenticated'};
      }

      final response = await http.get(
        Uri.parse(ApiConstants.cart),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        final items = (data['data']['items'] as List)
            .map((json) => CartItem.fromJson(json))
            .toList();
        
        return {
          'success': true,
          'items': items,
          'total': (data['data']['total'] as num).toDouble(),
          'count': data['data']['count'],
        };
      } else {
        return {'success': false, 'message': 'Failed to load cart'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Network error: $e'};
    }
  }

  // Add to Cart
  static Future<Map<String, dynamic>> addToCart({
    required int productId,
    required int quantity,
  }) async {
    try {
      final token = AuthService.getToken();
      if (token == null) {
        return {'success': false, 'message': 'Not authenticated'};
      }

      final response = await http.post(
        Uri.parse(ApiConstants.cart),
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

      final data = jsonDecode(response.body);

      if (response.statusCode == 201) {
        return {'success': true, 'message': data['message']};
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Failed to add to cart',
        };
      }
    } catch (e) {
      return {'success': false, 'message': 'Network error: $e'};
    }
  }

  // Update Cart Item
  static Future<Map<String, dynamic>> updateCartItem({
    required int itemId,
    required int quantity,
  }) async {
    try {
      final token = AuthService.getToken();
      if (token == null) {
        return {'success': false, 'message': 'Not authenticated'};
      }

      final response = await http.put(
        Uri.parse('${ApiConstants.cart}/$itemId'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode({
          'quantity': quantity,
        }),
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 200) {
        return {'success': true, 'message': data['message']};
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Failed to update cart',
        };
      }
    } catch (e) {
      return {'success': false, 'message': 'Network error: $e'};
    }
  }

  // Remove from Cart
  static Future<Map<String, dynamic>> removeFromCart(int itemId) async {
    try {
      final token = AuthService.getToken();
      if (token == null) {
        return {'success': false, 'message': 'Not authenticated'};
      }

      final response = await http.delete(
        Uri.parse('${ApiConstants.cart}/$itemId'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 200) {
        return {'success': true, 'message': data['message']};
      } else {
        return {'success': false, 'message': 'Failed to remove item'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Network error: $e'};
    }
  }

  // Clear Cart
  static Future<Map<String, dynamic>> clearCart() async {
    try {
      final token = AuthService.getToken();
      if (token == null) {
        return {'success': false, 'message': 'Not authenticated'};
      }

      final response = await http.delete(
        Uri.parse(ApiConstants.cart),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 200) {
        return {'success': true, 'message': data['message']};
      } else {
        return {'success': false, 'message': 'Failed to clear cart'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Network error: $e'};
    }
  }
}
```

## 7️⃣ Example Login Screen

Buat `lib/screens/auth/login_screen.dart`:

```dart
import 'package:flutter/material.dart';
import '../../services/auth_service.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({Key? key}) : super(key: key);

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  bool _isLoading = false;

  Future<void> _handleLogin() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _isLoading = true);

    final result = await AuthService.login(
      email: _emailController.text,
      password: _passwordController.text,
    );

    setState(() => _isLoading = false);

    if (!mounted) return;

    if (result['success']) {
      // Navigate to home screen
      Navigator.pushReplacementNamed(context, '/home');
    } else {
      // Show error
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(result['message'])),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Login')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              TextFormField(
                controller: _emailController,
                decoration: const InputDecoration(
                  labelText: 'Email',
                  border: OutlineInputBorder(),
                ),
                keyboardType: TextInputType.emailAddress,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Please enter email';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _passwordController,
                decoration: const InputDecoration(
                  labelText: 'Password',
                  border: OutlineInputBorder(),
                ),
                obscureText: true,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Please enter password';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 24),
              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: _isLoading ? null : _handleLogin,
                  child: _isLoading
                      ? const CircularProgressIndicator()
                      : const Text('Login'),
                ),
              ),
              TextButton(
                onPressed: () {
                  Navigator.pushNamed(context, '/register');
                },
                child: const Text('Belum punya akun? Daftar'),
              ),
            ],
          ),
        ),
      ),
    );
  }

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }
}
```

## 8️⃣ Example Product List Screen

Buat `lib/screens/products/product_list_screen.dart`:

```dart
import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:intl/intl.dart';
import '../../models/product.dart';
import '../../services/product_service.dart';
import '../../services/cart_service.dart';

class ProductListScreen extends StatefulWidget {
  const ProductListScreen({Key? key}) : super(key: key);

  @override
  State<ProductListScreen> createState() => _ProductListScreenState();
}

class _ProductListScreenState extends State<ProductListScreen> {
  List<Product> _products = [];
  bool _isLoading = true;
  final currencyFormatter = NumberFormat.currency(
    locale: 'id_ID',
    symbol: 'Rp ',
    decimalDigits: 0,
  );

  @override
  void initState() {
    super.initState();
    _loadProducts();
  }

  Future<void> _loadProducts() async {
    setState(() => _isLoading = true);
    
    final result = await ProductService.getProducts(available: true);
    
    if (result['success']) {
      setState(() {
        _products = result['products'];
        _isLoading = false;
      });
    } else {
      setState(() => _isLoading = false);
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(result['message'])),
        );
      }
    }
  }

  Future<void> _addToCart(Product product) async {
    final result = await CartService.addToCart(
      productId: product.id,
      quantity: 1,
    );

    if (!mounted) return;

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(result['success'] 
          ? 'Ditambahkan ke keranjang' 
          : result['message']),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Produk Kopi'),
        actions: [
          IconButton(
            icon: const Icon(Icons.shopping_cart),
            onPressed: () {
              Navigator.pushNamed(context, '/cart');
            },
          ),
        ],
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : RefreshIndicator(
              onRefresh: _loadProducts,
              child: ListView.builder(
                itemCount: _products.length,
                itemBuilder: (context, index) {
                  final product = _products[index];
                  return Card(
                    margin: const EdgeInsets.all(8),
                    child: ListTile(
                      leading: product.gambar != null
                          ? CachedNetworkImage(
                              imageUrl: product.gambar!,
                              width: 60,
                              height: 60,
                              fit: BoxFit.cover,
                              placeholder: (context, url) =>
                                  const CircularProgressIndicator(),
                              errorWidget: (context, url, error) =>
                                  const Icon(Icons.error),
                            )
                          : const Icon(Icons.coffee, size: 60),
                      title: Text(product.namaProduk),
                      subtitle: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(product.jenis),
                          Text(
                            currencyFormatter.format(product.harga),
                            style: const TextStyle(
                              fontWeight: FontWeight.bold,
                              color: Colors.green,
                            ),
                          ),
                          Text('Stok: ${product.stok}'),
                        ],
                      ),
                      trailing: IconButton(
                        icon: const Icon(Icons.add_shopping_cart),
                        onPressed: () => _addToCart(product),
                      ),
                      onTap: () {
                        Navigator.pushNamed(
                          context,
                          '/product-detail',
                          arguments: product.id,
                        );
                      },
                    ),
                  );
                },
              ),
            ),
    );
  }
}
```

## 9️⃣ Update main.dart

Edit `lib/main.dart`:

```dart
import 'package:flutter/material.dart';
import 'services/auth_service.dart';
import 'screens/auth/login_screen.dart';
import 'screens/products/product_list_screen.dart';
// Import screens lainnya...

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  
  // Load saved token
  await AuthService.loadToken();
  
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Tjap Satu',
      theme: ThemeData(
        primarySwatch: Colors.brown,
      ),
      initialRoute: AuthService.isLoggedIn() ? '/home' : '/login',
      routes: {
        '/login': (context) => const LoginScreen(),
        '/home': (context) => const ProductListScreen(),
        // Tambahkan routes lainnya...
      },
    );
  }
}
```

## 🔟 Allow HTTP di Android

Edit `android/app/src/main/AndroidManifest.xml`:

```xml
<manifest xmlns:android="http://schemas.android.com/apk/res/android">
    
    <!-- Tambahkan permission -->
    <uses-permission android:name="android.permission.INTERNET"/>
    
    <application
        android:label="tjap1_flutter"
        android:name="${applicationName}"
        android:icon="@mipmap/ic_launcher"
        android:usesCleartextTraffic="true">  <!-- TAMBAHKAN INI -->
        ...
    </application>
</manifest>
```

## 1️⃣1️⃣ Testing

### 1. Jalankan Laravel Server
Di terminal PowerShell (folder Laravel):
```bash
cd C:\Users\USER\Documents\PABW\TjapSatu\Tjap_Satu
php artisan serve
```

### 2. Cek IP Address
```bash
ipconfig
# Cari IPv4 Address, contoh: 192.168.1.100
```

### 3. Update Base URL di Flutter
Edit `lib/utils/constants.dart`:
```dart
static const String baseUrl = 'http://192.168.1.100:8000/api/v1';
```

### 4. Jalankan Flutter App
```bash
cd c:\Users\USER\Documents\DPPB\tjap1\Tjap1-Flutter
flutter run
```

### 5. Test API dengan Postman (Optional)
Sebelum testing di Flutter, test dulu API dengan Postman:

#### A. Register User
```http
POST http://localhost:8000/api/v1/register
Content-Type: application/json

{
  "nama": "Test User",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "alamat": "Jl. Test No. 123"
}
```

#### B. Login
```http
POST http://localhost:8000/api/v1/login
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "password123"
}
```
Copy token dari response!

#### C. Get Products
```http
GET http://localhost:8000/api/v1/products
Authorization: Bearer {token}
```

#### D. Add to Cart
```http
POST http://localhost:8000/api/v1/cart/add
Authorization: Bearer {token}
Content-Type: application/json

{
  "id_product": 1,
  "jumlah": 2
}
```

#### E. Get Cart
```http
GET http://localhost:8000/api/v1/cart
Authorization: Bearer {token}
```

## 🧪 Testing Real-Time Cart Updates

### Test Scenario 1: Add to Cart
1. Buka Product List Screen
2. Klik tombol add to cart pada produk
3. ✅ Badge counter di cart icon harus langsung update
4. ✅ SnackBar muncul dengan opsi "LIHAT KERANJANG"
5. Buka Cart Screen
6. ✅ Item sudah muncul di keranjang tanpa perlu refresh

### Test Scenario 2: Update Quantity
1. Di Cart Screen, klik tombol + atau - pada item
2. ✅ Quantity langsung berubah
3. ✅ Total price langsung update
4. ✅ Badge counter di AppBar langsung update

### Test Scenario 3: Remove Item
1. Di Cart Screen, klik tombol "Hapus" pada item
2. Konfirmasi hapus
3. ✅ Item langsung hilang dari list
4. ✅ Total price langsung update
5. ✅ Badge counter langsung berkurang

### Test Scenario 4: Multiple Screens
1. Buka Cart Screen di tab 1
2. Buka Product List dan add item di tab 2
3. Kembali ke Cart Screen di tab 1
4. ✅ Cart otomatis refresh saat screen muncul lagi

### Test Scenario 5: Clear Cart
1. Di Cart Screen dengan beberapa item
2. Klik icon delete_sweep di AppBar
3. Konfirmasi clear
4. ✅ Semua item langsung hilang
5. ✅ Muncul tampilan "Keranjang Kosong"

## 🐛 Troubleshooting

### Error: Connection refused
- ✅ Pastikan Laravel server berjalan (`php artisan serve`)
- ✅ Pastikan IP address benar
- ✅ Pastikan komputer dan device dalam jaringan yang sama
- ✅ Disable firewall atau allow port 8000

### Error: Unauthenticated
- ✅ Pastikan token tersimpan dengan benar
- ✅ Cek header `Authorization: Bearer {token}`
- ✅ Login ulang jika token expired

### Cart tidak update real-time
- ✅ Pastikan sudah wrap app dengan `MultiProvider` di main.dart
- ✅ Pastikan sudah `import 'package:provider/provider.dart'`
- ✅ Cek apakah `notifyListeners()` dipanggil setelah update state
- ✅ Gunakan `Consumer<CartProvider>` atau `context.watch<CartProvider>()`
- ✅ Debug dengan `print()` di CartProvider untuk cek apakah method dipanggil

### Badge counter tidak muncul
- ✅ Pastikan menggunakan `Consumer<CartProvider>` untuk badge
- ✅ Cek apakah `itemCount` getter di CartProvider benar
- ✅ Reload cart saat ProductListScreen dibuka

### Gambar tidak muncul
- ✅ Jalankan `php artisan storage:link` di Laravel
- ✅ Pastikan URL gambar lengkap (termasuk domain)
- ✅ Cek permission folder storage

### Android Emulator tidak bisa connect
- ✅ Gunakan `10.0.2.2` bukan `127.0.0.1` atau `localhost`
- ✅ Contoh: `http://10.0.2.2:8000/api/v1`

## 1️⃣1️⃣ Real-Time Cart Updates dengan Provider

Untuk membuat keranjang update secara real-time, kita akan menggunakan **Provider** untuk state management.

### Step 1: Buat Cart Provider

Buat file `lib/providers/cart_provider.dart`:

```dart
import 'package:flutter/material.dart';
import '../models/cart_item.dart';
import '../services/cart_service.dart';

class CartProvider with ChangeNotifier {
  List<CartItem> _items = [];
  bool _isLoading = false;
  String _errorMessage = '';

  // Getters
  List<CartItem> get items => _items;
  bool get isLoading => _isLoading;
  String get errorMessage => _errorMessage;
  
  int get itemCount => _items.fold(0, (sum, item) => sum + item.jumlah);
  
  double get totalPrice => _items.fold(
    0.0, 
    (sum, item) => sum + (item.product.harga * item.jumlah),
  );

  // Load cart dari API
  Future<void> loadCart() async {
    _isLoading = true;
    _errorMessage = '';
    notifyListeners();

    try {
      final result = await CartService.getCart();
      
      if (result['success']) {
        _items = result['items'];
      } else {
        _errorMessage = result['message'];
      }
    } catch (e) {
      _errorMessage = 'Error loading cart: $e';
    }

    _isLoading = false;
    notifyListeners();
  }

  // Tambah produk ke cart
  Future<bool> addToCart(int productId, int quantity) async {
    try {
      final result = await CartService.addToCart(
        productId: productId,
        quantity: quantity,
      );

      if (result['success']) {
        // Refresh cart setelah add
        await loadCart();
        return true;
      } else {
        _errorMessage = result['message'];
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Error adding to cart: $e';
      notifyListeners();
      return false;
    }
  }

  // Update quantity item
  Future<bool> updateQuantity(int cartItemId, int newQuantity) async {
    try {
      final result = await CartService.updateCartItem(
        cartItemId: cartItemId,
        quantity: newQuantity,
      );

      if (result['success']) {
        // Update local state
        final index = _items.indexWhere((item) => item.id == cartItemId);
        if (index != -1) {
          _items[index].jumlah = newQuantity;
          notifyListeners();
        }
        return true;
      } else {
        _errorMessage = result['message'];
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Error updating quantity: $e';
      notifyListeners();
      return false;
    }
  }

  // Remove item dari cart
  Future<bool> removeItem(int cartItemId) async {
    try {
      final result = await CartService.removeCartItem(cartItemId);

      if (result['success']) {
        // Remove dari local state
        _items.removeWhere((item) => item.id == cartItemId);
        notifyListeners();
        return true;
      } else {
        _errorMessage = result['message'];
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Error removing item: $e';
      notifyListeners();
      return false;
    }
  }

  // Clear cart
  Future<bool> clearCart() async {
    try {
      final result = await CartService.clearCart();

      if (result['success']) {
        _items.clear();
        notifyListeners();
        return true;
      } else {
        _errorMessage = result['message'];
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Error clearing cart: $e';
      notifyListeners();
      return false;
    }
  }
}
```

### Step 2: Update main.dart dengan Provider

Edit `lib/main.dart`:

```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart'; // TAMBAHKAN
import 'services/auth_service.dart';
import 'providers/cart_provider.dart'; // TAMBAHKAN
import 'screens/auth/login_screen.dart';
import 'screens/products/product_list_screen.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  
  // Load saved token
  await AuthService.loadToken();
  
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    // Wrap dengan MultiProvider
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => CartProvider()),
        // Tambahkan provider lain di sini jika perlu
      ],
      child: MaterialApp(
        title: 'Tjap Satu',
        theme: ThemeData(
          primarySwatch: Colors.brown,
        ),
        initialRoute: AuthService.isLoggedIn() ? '/home' : '/login',
        routes: {
          '/login': (context) => const LoginScreen(),
          '/home': (context) => const ProductListScreen(),
          '/cart': (context) => const CartScreen(),
          // Tambahkan routes lainnya...
        },
      ),
    );
  }
}
```

### Step 3: Update Product List Screen dengan Provider

Edit `lib/screens/products/product_list_screen.dart`:

```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart'; // TAMBAHKAN
import 'package:cached_network_image/cached_network_image.dart';
import 'package:intl/intl.dart';
import '../../models/product.dart';
import '../../services/product_service.dart';
import '../../providers/cart_provider.dart'; // TAMBAHKAN

class ProductListScreen extends StatefulWidget {
  const ProductListScreen({Key? key}) : super(key: key);

  @override
  State<ProductListScreen> createState() => _ProductListScreenState();
}

class _ProductListScreenState extends State<ProductListScreen> {
  List<Product> _products = [];
  bool _isLoading = true;
  final currencyFormatter = NumberFormat.currency(
    locale: 'id_ID',
    symbol: 'Rp ',
    decimalDigits: 0,
  );

  @override
  void initState() {
    super.initState();
    _loadProducts();
    _loadCart(); // Load cart saat screen dibuka
  }

  Future<void> _loadProducts() async {
    setState(() => _isLoading = true);
    
    final result = await ProductService.getProducts(available: true);
    
    if (result['success']) {
      setState(() {
        _products = result['products'];
        _isLoading = false;
      });
    } else {
      setState(() => _isLoading = false);
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(result['message'])),
        );
      }
    }
  }

  Future<void> _loadCart() async {
    // Load cart menggunakan Provider
    final cartProvider = Provider.of<CartProvider>(context, listen: false);
    await cartProvider.loadCart();
  }

  Future<void> _addToCart(Product product) async {
    // Gunakan Provider untuk add to cart
    final cartProvider = Provider.of<CartProvider>(context, listen: false);
    final success = await cartProvider.addToCart(product.id, 1);

    if (!mounted) return;

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(success 
          ? '${product.namaProduk} ditambahkan ke keranjang' 
          : cartProvider.errorMessage),
        action: SnackBarAction(
          label: 'LIHAT KERANJANG',
          onPressed: () {
            Navigator.pushNamed(context, '/cart');
          },
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Produk Kopi'),
        actions: [
          // Cart icon dengan badge counter
          Stack(
            children: [
              IconButton(
                icon: const Icon(Icons.shopping_cart),
                onPressed: () {
                  Navigator.pushNamed(context, '/cart');
                },
              ),
              // Badge counter menggunakan Consumer
              Consumer<CartProvider>(
                builder: (context, cart, child) {
                  if (cart.itemCount == 0) return const SizedBox();
                  
                  return Positioned(
                    right: 8,
                    top: 8,
                    child: Container(
                      padding: const EdgeInsets.all(2),
                      decoration: BoxDecoration(
                        color: Colors.red,
                        borderRadius: BorderRadius.circular(10),
                      ),
                      constraints: const BoxConstraints(
                        minWidth: 16,
                        minHeight: 16,
                      ),
                      child: Text(
                        '${cart.itemCount}',
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 10,
                          fontWeight: FontWeight.bold,
                        ),
                        textAlign: TextAlign.center,
                      ),
                    ),
                  );
                },
              ),
            ],
          ),
        ],
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : RefreshIndicator(
              onRefresh: () async {
                await _loadProducts();
                await _loadCart();
              },
              child: ListView.builder(
                itemCount: _products.length,
                itemBuilder: (context, index) {
                  final product = _products[index];
                  return Card(
                    margin: const EdgeInsets.all(8),
                    child: ListTile(
                      leading: product.gambar != null
                          ? CachedNetworkImage(
                              imageUrl: product.gambar!,
                              width: 60,
                              height: 60,
                              fit: BoxFit.cover,
                              placeholder: (context, url) =>
                                  const CircularProgressIndicator(),
                              errorWidget: (context, url, error) =>
                                  const Icon(Icons.error),
                            )
                          : const Icon(Icons.coffee, size: 60),
                      title: Text(product.namaProduk),
                      subtitle: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(product.jenis),
                          Text(
                            currencyFormatter.format(product.harga),
                            style: const TextStyle(
                              fontWeight: FontWeight.bold,
                              color: Colors.green,
                            ),
                          ),
                          Text('Stok: ${product.stok}'),
                        ],
                      ),
                      trailing: IconButton(
                        icon: const Icon(Icons.add_shopping_cart),
                        onPressed: () => _addToCart(product),
                      ),
                      onTap: () {
                        Navigator.pushNamed(
                          context,
                          '/product-detail',
                          arguments: product.id,
                        );
                      },
                    ),
                  );
                },
              ),
            ),
    );
  }
}
```

### Step 4: Buat Cart Screen dengan Real-time Updates

Buat file `lib/screens/cart/cart_screen.dart`:

```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:intl/intl.dart';
import '../../providers/cart_provider.dart';
import '../../models/cart_item.dart';

class CartScreen extends StatefulWidget {
  const CartScreen({Key? key}) : super(key: key);

  @override
  State<CartScreen> createState() => _CartScreenState();
}

class _CartScreenState extends State<CartScreen> {
  final currencyFormatter = NumberFormat.currency(
    locale: 'id_ID',
    symbol: 'Rp ',
    decimalDigits: 0,
  );

  @override
  void initState() {
    super.initState();
    // Load cart saat screen dibuka
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<CartProvider>(context, listen: false).loadCart();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Keranjang Belanja'),
        actions: [
          // Tombol Clear Cart
          Consumer<CartProvider>(
            builder: (context, cart, child) {
              if (cart.items.isEmpty) return const SizedBox();
              
              return IconButton(
                icon: const Icon(Icons.delete_sweep),
                onPressed: () async {
                  final confirm = await showDialog<bool>(
                    context: context,
                    builder: (context) => AlertDialog(
                      title: const Text('Kosongkan Keranjang?'),
                      content: const Text('Semua item akan dihapus dari keranjang.'),
                      actions: [
                        TextButton(
                          onPressed: () => Navigator.pop(context, false),
                          child: const Text('BATAL'),
                        ),
                        TextButton(
                          onPressed: () => Navigator.pop(context, true),
                          child: const Text('HAPUS'),
                        ),
                      ],
                    ),
                  );

                  if (confirm == true) {
                    await cart.clearCart();
                    if (mounted) {
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('Keranjang dikosongkan')),
                      );
                    }
                  }
                },
              );
            },
          ),
        ],
      ),
      body: Consumer<CartProvider>(
        builder: (context, cart, child) {
          // Loading state
          if (cart.isLoading) {
            return const Center(child: CircularProgressIndicator());
          }

          // Empty cart
          if (cart.items.isEmpty) {
            return Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  const Icon(
                    Icons.shopping_cart_outlined,
                    size: 100,
                    color: Colors.grey,
                  ),
                  const SizedBox(height: 16),
                  const Text(
                    'Keranjang Kosong',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 8),
                  const Text('Yuk belanja kopi favoritmu!'),
                  const SizedBox(height: 24),
                  ElevatedButton(
                    onPressed: () => Navigator.pop(context),
                    child: const Text('Mulai Belanja'),
                  ),
                ],
              ),
            );
          }

          // Cart items
          return Column(
            children: [
              Expanded(
                child: ListView.builder(
                  itemCount: cart.items.length,
                  itemBuilder: (context, index) {
                    final item = cart.items[index];
                    return CartItemWidget(
                      item: item,
                      currencyFormatter: currencyFormatter,
                    );
                  },
                ),
              ),
              // Bottom summary
              Container(
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: Colors.white,
                  boxShadow: [
                    BoxShadow(
                      color: Colors.grey.withOpacity(0.3),
                      blurRadius: 5,
                      offset: const Offset(0, -2),
                    ),
                  ],
                ),
                child: Column(
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Text(
                          'Total (${cart.itemCount} item)',
                          style: const TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        Text(
                          currencyFormatter.format(cart.totalPrice),
                          style: const TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                            color: Colors.green,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 12),
                    SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        onPressed: () {
                          Navigator.pushNamed(context, '/checkout');
                        },
                        style: ElevatedButton.styleFrom(
                          padding: const EdgeInsets.symmetric(vertical: 16),
                        ),
                        child: const Text(
                          'CHECKOUT',
                          style: TextStyle(fontSize: 16),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ],
          );
        },
      ),
    );
  }
}

class CartItemWidget extends StatelessWidget {
  final CartItem item;
  final NumberFormat currencyFormatter;

  const CartItemWidget({
    Key? key,
    required this.item,
    required this.currencyFormatter,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final cart = Provider.of<CartProvider>(context, listen: false);

    return Card(
      margin: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      child: Padding(
        padding: const EdgeInsets.all(8),
        child: Row(
          children: [
            // Product image
            if (item.product.gambar != null)
              CachedNetworkImage(
                imageUrl: item.product.gambar!,
                width: 80,
                height: 80,
                fit: BoxFit.cover,
                placeholder: (context, url) => const CircularProgressIndicator(),
                errorWidget: (context, url, error) => const Icon(Icons.error),
              )
            else
              const Icon(Icons.coffee, size: 80),
            const SizedBox(width: 12),
            // Product info
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    item.product.namaProduk,
                    style: const TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 16,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(item.product.jenis),
                  const SizedBox(height: 4),
                  Text(
                    currencyFormatter.format(item.product.harga),
                    style: const TextStyle(
                      color: Colors.green,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ],
              ),
            ),
            // Quantity controls
            Column(
              children: [
                Row(
                  children: [
                    // Decrease button
                    IconButton(
                      icon: const Icon(Icons.remove_circle_outline),
                      onPressed: () async {
                        if (item.jumlah > 1) {
                          await cart.updateQuantity(item.id, item.jumlah - 1);
                        } else {
                          // Confirm delete if quantity is 1
                          final confirm = await showDialog<bool>(
                            context: context,
                            builder: (context) => AlertDialog(
                              title: const Text('Hapus Item?'),
                              content: Text('Hapus ${item.product.namaProduk} dari keranjang?'),
                              actions: [
                                TextButton(
                                  onPressed: () => Navigator.pop(context, false),
                                  child: const Text('BATAL'),
                                ),
                                TextButton(
                                  onPressed: () => Navigator.pop(context, true),
                                  child: const Text('HAPUS'),
                                ),
                              ],
                            ),
                          );

                          if (confirm == true) {
                            await cart.removeItem(item.id);
                          }
                        }
                      },
                    ),
                    // Quantity
                    Text(
                      '${item.jumlah}',
                      style: const TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    // Increase button
                    IconButton(
                      icon: const Icon(Icons.add_circle_outline),
                      onPressed: () async {
                        if (item.jumlah < item.product.stok) {
                          await cart.updateQuantity(item.id, item.jumlah + 1);
                        } else {
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(
                              content: Text('Stok tidak mencukupi'),
                            ),
                          );
                        }
                      },
                    ),
                  ],
                ),
                // Delete button
                TextButton.icon(
                  onPressed: () async {
                    final confirm = await showDialog<bool>(
                      context: context,
                      builder: (context) => AlertDialog(
                        title: const Text('Hapus Item?'),
                        content: Text('Hapus ${item.product.namaProduk} dari keranjang?'),
                        actions: [
                          TextButton(
                            onPressed: () => Navigator.pop(context, false),
                            child: const Text('BATAL'),
                          ),
                          TextButton(
                            onPressed: () => Navigator.pop(context, true),
                            child: const Text('HAPUS'),
                          ),
                        ],
                      ),
                    );

                    if (confirm == true) {
                      await cart.removeItem(item.id);
                    }
                  },
                  icon: const Icon(Icons.delete, size: 16),
                  label: const Text('Hapus'),
                  style: TextButton.styleFrom(
                    foregroundColor: Colors.red,
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
```

## 📚 Next Steps

1. ✅ Setup dependencies
2. ✅ Buat models
3. ✅ Buat services (Auth, Product, Cart)
4. ✅ Buat UI screens
5. ✅ Add state management dengan Provider
6. ✅ Real-time cart updates
7. ⏭️ Implement order creation
8. ⏭️ Implement payment upload
9. ⏭️ Add error handling
10. ⏭️ Test semua fitur

## 📞 Support

Jika ada masalah:
1. Cek dokumentasi API: `API_DOCUMENTATION.md`
2. Cek setup guide: `SETUP_API.md`
3. Test API dengan Postman dulu untuk memastikan API berjalan
4. Debug dengan `print()` untuk lihat response dari API

---

**Happy Coding! ☕**
