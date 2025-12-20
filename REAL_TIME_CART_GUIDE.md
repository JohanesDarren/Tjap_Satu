# 🛒 Panduan Real-Time Cart Updates

Panduan ini menjelaskan cara implementasi keranjang belanja yang update secara **real-time** di Flutter menggunakan **Provider** untuk state management.

## 📋 Overview

Ketika user menambahkan produk ke keranjang:
1. ✅ Badge counter di cart icon **langsung update**
2. ✅ Cart screen **otomatis refresh** tanpa perlu pull-to-refresh
3. ✅ Total price **langsung berubah** saat quantity diubah
4. ✅ Semua screen yang menampilkan cart **sinkron real-time**

## 🏗️ Arsitektur

```
┌─────────────────────┐
│   CartProvider      │ ← State Management (ChangeNotifier)
│   - items           │
│   - itemCount       │
│   - totalPrice      │
│   - addToCart()     │
│   - updateQuantity()│
│   - removeItem()    │
└─────────────────────┘
          │
          │ notifyListeners()
          ▼
┌─────────────────────┐
│   Consumer Widget   │ ← Auto rebuild ketika state berubah
│   - ProductList     │
│   - CartScreen      │
│   - Badge Counter   │
└─────────────────────┘
```

## 🔧 Implementasi

### 1. Cart Provider

File: `lib/providers/cart_provider.dart`

```dart
class CartProvider with ChangeNotifier {
  List<CartItem> _items = [];
  
  // Getter untuk jumlah total item
  int get itemCount => _items.fold(0, (sum, item) => sum + item.jumlah);
  
  // Add item dan trigger update
  Future<bool> addToCart(int productId, int quantity) async {
    final result = await CartService.addToCart(...);
    if (result['success']) {
      await loadCart();
      notifyListeners(); // 👈 Trigger UI update
      return true;
    }
    return false;
  }
  
  // Update quantity dan trigger update
  Future<bool> updateQuantity(int cartItemId, int newQuantity) async {
    final result = await CartService.updateCartItem(...);
    if (result['success']) {
      // Update local state
      final index = _items.indexWhere((item) => item.id == cartItemId);
      if (index != -1) {
        _items[index].jumlah = newQuantity;
        notifyListeners(); // 👈 Trigger UI update
      }
      return true;
    }
    return false;
  }
}
```

**Key Points:**
- Extend `ChangeNotifier` untuk bisa notify UI
- Panggil `notifyListeners()` setelah update state
- Gunakan getter untuk computed values (itemCount, totalPrice)

### 2. Setup Provider di main.dart

```dart
void main() {
  runApp(
    MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => CartProvider()),
      ],
      child: MyApp(),
    ),
  );
}
```

**Key Points:**
- Wrap app dengan `MultiProvider`
- Create CartProvider instance
- Provider tersedia di semua screen

### 3. Consumer untuk Auto-Rebuild

**Badge Counter di AppBar:**

```dart
Consumer<CartProvider>(
  builder: (context, cart, child) {
    return Badge(
      label: Text('${cart.itemCount}'),
      child: Icon(Icons.shopping_cart),
    );
  },
)
```

**Cart Screen:**

```dart
Consumer<CartProvider>(
  builder: (context, cart, child) {
    if (cart.isLoading) return CircularProgressIndicator();
    if (cart.items.isEmpty) return EmptyCartWidget();
    
    return ListView.builder(
      itemCount: cart.items.length,
      itemBuilder: (context, index) {
        final item = cart.items[index];
        return CartItemWidget(item: item);
      },
    );
  },
)
```

**Key Points:**
- `Consumer` auto-rebuild ketika Provider state berubah
- Tidak perlu `setState()`
- Hanya widget di dalam `Consumer` yang rebuild

### 4. Add to Cart di Product List

```dart
Future<void> _addToCart(Product product) async {
  // Ambil CartProvider tanpa listen (listen: false)
  final cartProvider = Provider.of<CartProvider>(context, listen: false);
  
  // Add to cart
  final success = await cartProvider.addToCart(product.id, 1);
  
  // Show feedback
  if (success) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text('${product.namaProduk} ditambahkan'),
        action: SnackBarAction(
          label: 'LIHAT KERANJANG',
          onPressed: () => Navigator.pushNamed(context, '/cart'),
        ),
      ),
    );
  }
}
```

**Key Points:**
- Gunakan `listen: false` saat memanggil method (tidak perlu rebuild)
- Provider akan trigger rebuild via `notifyListeners()`
- Badge counter otomatis update karena menggunakan `Consumer`

## 🔄 Flow Diagram

```
User tap "Add to Cart"
    │
    ▼
cartProvider.addToCart(productId, quantity)
    │
    ├─► Call CartService.addToCart() [API Call]
    │
    ├─► loadCart() [Refresh data dari API]
    │
    └─► notifyListeners() [Trigger UI update]
            │
            ▼
        Consumer widgets rebuild automatically
            │
            ├─► Badge counter update
            │
            ├─► Cart screen update
            │
            └─► Total price update
```

## ✅ Testing Checklist

### Test 1: Add to Cart
- [ ] Buka Product List
- [ ] Klik add to cart
- [ ] Badge counter langsung bertambah
- [ ] Buka Cart Screen
- [ ] Item sudah ada di cart (tanpa refresh)

### Test 2: Update Quantity
- [ ] Di Cart Screen, klik + atau -
- [ ] Quantity langsung berubah
- [ ] Total price langsung update
- [ ] Badge counter langsung update

### Test 3: Remove Item
- [ ] Klik tombol Hapus
- [ ] Item langsung hilang
- [ ] Total price langsung update
- [ ] Badge counter langsung berkurang

### Test 4: Multiple Screens
- [ ] Buka Cart Screen
- [ ] Kembali ke Product List
- [ ] Add item lagi
- [ ] Buka Cart Screen
- [ ] Item yang baru ditambah sudah muncul

### Test 5: Empty Cart
- [ ] Clear all items
- [ ] Badge counter hilang
- [ ] Tampil "Keranjang Kosong"

## 🐛 Troubleshooting

### Badge tidak update
**Problem:** Badge counter tidak berubah setelah add to cart

**Solution:**
```dart
// ❌ WRONG - Tidak akan update
Icon(Icons.shopping_cart)

// ✅ CORRECT - Gunakan Consumer
Consumer<CartProvider>(
  builder: (context, cart, child) {
    return Badge(
      label: Text('${cart.itemCount}'),
      child: Icon(Icons.shopping_cart),
    );
  },
)
```

### Cart Screen tidak update
**Problem:** Cart screen tidak refresh setelah add item

**Solution:**
```dart
@override
void initState() {
  super.initState();
  // Load cart saat screen dibuka
  WidgetsBinding.instance.addPostFrameCallback((_) {
    Provider.of<CartProvider>(context, listen: false).loadCart();
  });
}
```

### Total price tidak update
**Problem:** Total price tidak berubah saat quantity diubah

**Solution:**
Pastikan menggunakan `Consumer` atau `context.watch()`:

```dart
// ❌ WRONG
Text('Total: ${cartProvider.totalPrice}')

// ✅ CORRECT
Consumer<CartProvider>(
  builder: (context, cart, child) {
    return Text('Total: ${cart.totalPrice}');
  },
)
```

### Listen vs No Listen
**Problem:** Kapan pakai `listen: true` vs `listen: false`?

**Solution:**
```dart
// listen: false - Untuk memanggil method (tidak perlu rebuild)
final cart = Provider.of<CartProvider>(context, listen: false);
await cart.addToCart(productId, 1);

// listen: true (default) - Untuk baca state (perlu rebuild)
final cart = Provider.of<CartProvider>(context);
print(cart.itemCount);

// ATAU gunakan Consumer (lebih recommended)
Consumer<CartProvider>(
  builder: (context, cart, child) {
    return Text('${cart.itemCount}');
  },
)
```

## 📊 Performance Tips

### 1. Gunakan `const` Constructor
```dart
const Icon(Icons.shopping_cart) // Tidak rebuild
```

### 2. Gunakan `child` di Consumer
```dart
Consumer<CartProvider>(
  child: const Icon(Icons.shopping_cart), // Tidak rebuild
  builder: (context, cart, child) {
    return Badge(
      label: Text('${cart.itemCount}'),
      child: child, // Reuse const child
    );
  },
)
```

### 3. Split Widget untuk Optimize Rebuild
```dart
// ❌ Seluruh screen rebuild
Consumer<CartProvider>(
  builder: (context, cart, child) {
    return Scaffold(...); // Seluruh scaffold rebuild!
  },
)

// ✅ Hanya widget yang perlu rebuild
Scaffold(
  appBar: AppBar(
    actions: [
      Consumer<CartProvider>( // Hanya badge yang rebuild
        builder: (context, cart, child) {
          return Badge(...);
        },
      ),
    ],
  ),
)
```

## 📚 Resources

- [Provider Package Documentation](https://pub.dev/packages/provider)
- [Flutter State Management Guide](https://docs.flutter.dev/development/data-and-backend/state-mgmt/intro)
- [API_DOCUMENTATION.md](./API_DOCUMENTATION.md) - Backend API reference
- [FLUTTER_INTEGRATION_GUIDE.md](./FLUTTER_INTEGRATION_GUIDE.md) - Full integration guide

## 🎯 Summary

**Real-time cart updates menggunakan:**
1. **CartProvider** dengan `ChangeNotifier` untuk state management
2. **notifyListeners()** untuk trigger UI update setelah state berubah
3. **Consumer widget** untuk auto-rebuild ketika state berubah
4. **listen: false** saat memanggil method Provider
5. **Computed getters** untuk itemCount dan totalPrice

**Benefits:**
- ✅ No manual `setState()`
- ✅ Automatic UI synchronization
- ✅ Better separation of concerns
- ✅ Easier to test
- ✅ Scalable architecture

---

**Happy Coding! 🚀**
