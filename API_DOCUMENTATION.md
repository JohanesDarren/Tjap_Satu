# Tjap Satu - API Documentation

Base URL: `http://your-domain.com/api/v1`

## Table of Contents
1. [Authentication](#authentication)
2. [Products](#products)
3. [Cart](#cart)
4. [Orders](#orders)
5. [Profile](#profile)
6. [Banners](#banners)
7. [Blogs](#blogs)
8. [Promos](#promos)
9. [Kurir](#kurir)

---

## Authentication

### Register
**POST** `/register`

Register a new user account.

**Request Body:**
```json
{
  "nama_lengkap": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "no_telp": "08123456789",
  "alamat": "Jl. Example No. 123"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Registration successful",
  "data": {
    "user": {
      "id": 1,
      "nama_lengkap": "John Doe",
      "email": "john@example.com",
      "no_telp": "08123456789",
      "alamat": "Jl. Example No. 123",
      "foto": null
    },
    "token": "1|xxxxxxxxxxxx"
  }
}
```

### Login
**POST** `/login`

Login to existing account.

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "nama_lengkap": "John Doe",
      "email": "john@example.com",
      "no_telp": "08123456789",
      "alamat": "Jl. Example No. 123",
      "foto": "http://domain.com/storage/profiles/profile.jpg"
    },
    "token": "1|xxxxxxxxxxxx"
  }
}
```

### Logout
**POST** `/logout`

Logout from current session.

**Headers:**
- `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "success": true,
  "message": "Logout successful"
}
```

### Get Current User
**GET** `/user`

Get authenticated user information.

**Headers:**
- `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nama_lengkap": "John Doe",
    "email": "john@example.com",
    "no_telp": "08123456789",
    "alamat": "Jl. Example No. 123",
    "foto": "http://domain.com/storage/profiles/profile.jpg"
  }
}
```

---

## Products

### Get All Products
**GET** `/products`

Get list of all products with optional filters.

**Query Parameters:**
- `jenis` (optional): Filter by category (e.g., "Kopi Arabica", "Kopi Robusta")
- `proses` (optional): Filter by process (e.g., "Natural", "Honey", "Washed")
- `search` (optional): Search by product name
- `available` (optional): Filter available products (true/false)
- `sort_by` (optional): Sort field (default: created_at)
- `sort_order` (optional): Sort order (asc/desc, default: desc)
- `per_page` (optional): Items per page (default: 15)
- `page` (optional): Page number

**Example:**
```
GET /products?jenis=Kopi Arabica&available=true&per_page=10&page=1
```

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama_produk": "Kopi Arabica Gayo",
      "deskripsi": "Kopi premium dari Aceh",
      "harga": 85000,
      "stok": 50,
      "jenis": "Kopi Arabica",
      "proses": "Natural",
      "gambar": "http://domain.com/storage/products/arabica.jpg",
      "available": true,
      "created_at": "2025-12-20T10:00:00.000000Z",
      "updated_at": "2025-12-20T10:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 72
  }
}
```

### Get Single Product
**GET** `/products/{id}`

Get detailed information of a specific product.

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nama_produk": "Kopi Arabica Gayo",
    "deskripsi": "Kopi premium dari Aceh dengan cita rasa khas",
    "harga": 85000,
    "stok": 50,
    "jenis": "Kopi Arabica",
    "proses": "Natural",
    "gambar": "http://domain.com/storage/products/arabica.jpg",
    "available": true,
    "created_at": "2025-12-20T10:00:00.000000Z",
    "updated_at": "2025-12-20T10:00:00.000000Z"
  }
}
```

### Get Products by Category
**GET** `/products/category/{jenis}`

Get all products in a specific category.

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama_produk": "Kopi Arabica Gayo",
      "deskripsi": "Kopi premium dari Aceh",
      "harga": 85000,
      "stok": 50,
      "jenis": "Kopi Arabica",
      "proses": "Natural",
      "gambar": "http://domain.com/storage/products/arabica.jpg",
      "available": true
    }
  ],
  "meta": {
    "total": 15,
    "category": "Kopi Arabica"
  }
}
```

---

## Cart

### Get Cart
**GET** `/cart`

Get current user's cart items.

**Headers:**
- `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "items": [
      {
        "id": 1,
        "product": {
          "id": 1,
          "nama_produk": "Kopi Arabica Gayo",
          "harga": 85000,
          "gambar": "http://domain.com/storage/products/arabica.jpg",
          "stok": 50
        },
        "quantity": 2,
        "subtotal": 170000
      }
    ],
    "total": 170000,
    "count": 1
  }
}
```

### Add to Cart
**POST** `/cart`

Add a product to cart.

**Headers:**
- `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "id_product": 1,
  "quantity": 2
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Item added to cart",
  "data": {
    "id": 1,
    "quantity": 2
  }
}
```

### Update Cart Item
**PUT** `/cart/{id}`

Update quantity of a cart item.

**Headers:**
- `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "quantity": 3
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Cart updated",
  "data": {
    "id": 1,
    "quantity": 3
  }
}
```

### Remove from Cart
**DELETE** `/cart/{id}`

Remove an item from cart.

**Headers:**
- `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "success": true,
  "message": "Item removed from cart"
}
```

### Clear Cart
**DELETE** `/cart`

Clear all items from cart.

**Headers:**
- `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "success": true,
  "message": "Cart cleared"
}
```

---

## Orders

### Get All Orders
**GET** `/orders`

Get all orders of current user.

**Headers:**
- `Authorization: Bearer {token}`

**Query Parameters:**
- `status` (optional): Filter by order status (pending, confirmed, processing, shipped, delivered, cancelled)

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "tanggal_order": "2025-12-20 10:30:00",
      "tipe_pesanan": "delivery",
      "status_pesanan": "pending",
      "subtotal_produk": 170000,
      "ongkir": 10000,
      "biaya_layanan": 1700,
      "promo_discount": 0,
      "promo_code": null,
      "total_harga": 181700,
      "catatan": null,
      "kurir": {
        "id": 1,
        "nama": "Budi"
      },
      "items_count": 2,
      "payment_status": "pending",
      "created_at": "2025-12-20T10:30:00.000000Z"
    }
  ]
}
```

### Get Order Details
**GET** `/orders/{id}`

Get detailed information of a specific order.

**Headers:**
- `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "tanggal_order": "2025-12-20 10:30:00",
    "tipe_pesanan": "delivery",
    "status_pesanan": "pending",
    "subtotal_produk": 170000,
    "ongkir": 10000,
    "biaya_layanan": 1700,
    "promo_discount": 0,
    "promo_code": null,
    "total_harga": 181700,
    "catatan": "Tolong antar siang",
    "kurir": {
      "id": 1,
      "nama": "Budi",
      "no_telp": "08123456789"
    },
    "items": [
      {
        "id": 1,
        "product": {
          "id": 1,
          "nama_produk": "Kopi Arabica Gayo",
          "gambar": "http://domain.com/storage/products/arabica.jpg"
        },
        "jumlah": 2,
        "harga_satuan": 85000,
        "subtotal": 170000
      }
    ],
    "payment": {
      "id": 1,
      "metode_payment": "transfer",
      "status_payment": "pending",
      "bukti_pembayaran": null
    },
    "created_at": "2025-12-20T10:30:00.000000Z",
    "updated_at": "2025-12-20T10:30:00.000000Z"
  }
}
```

### Create Order
**POST** `/orders`

Create a new order from current cart.

**Headers:**
- `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "tipe_pesanan": "delivery",
  "id_kurir": 1,
  "promo_code": "DISKON20",
  "catatan": "Tolong antar siang",
  "metode_payment": "transfer"
}
```

**Fields:**
- `tipe_pesanan`: Order type (required) - `dine-in`, `take-away`, or `delivery`
- `id_kurir`: Courier ID (optional, required if delivery)
- `promo_code`: Promo code (optional)
- `catatan`: Order notes (optional)
- `metode_payment`: Payment method (required) - `transfer`, `cash`, or `e-wallet`

**Response (201):**
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id_order": 1,
    "total_harga": 181700,
    "status_pesanan": "pending"
  }
}
```

### Cancel Order
**PUT** `/orders/{id}/cancel`

Cancel an existing order.

**Headers:**
- `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "success": true,
  "message": "Order cancelled successfully"
}
```

### Upload Payment Proof
**POST** `/orders/{id}/payment`

Upload payment proof for an order.

**Headers:**
- `Authorization: Bearer {token}`
- `Content-Type: multipart/form-data`

**Request Body (form-data):**
- `bukti_pembayaran`: Image file (jpeg, png, jpg, max 2MB)

**Response (200):**
```json
{
  "success": true,
  "message": "Payment proof uploaded successfully",
  "data": {
    "bukti_pembayaran": "http://domain.com/storage/payments/payment_1_123456.jpg"
  }
}
```

---

## Profile

### Get Profile
**GET** `/profile`

Get current user profile.

**Headers:**
- `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nama_lengkap": "John Doe",
    "email": "john@example.com",
    "no_telp": "08123456789",
    "alamat": "Jl. Example No. 123",
    "foto": "http://domain.com/storage/profiles/profile.jpg",
    "created_at": "2025-12-20T10:00:00.000000Z"
  }
}
```

### Update Profile
**PUT** `/profile`

Update user profile information.

**Headers:**
- `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "nama_lengkap": "John Doe Updated",
  "email": "john.new@example.com",
  "no_telp": "08123456789",
  "alamat": "Jl. New Address No. 456"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Profile updated successfully",
  "data": {
    "id": 1,
    "nama_lengkap": "John Doe Updated",
    "email": "john.new@example.com",
    "no_telp": "08123456789",
    "alamat": "Jl. New Address No. 456",
    "foto": "http://domain.com/storage/profiles/profile.jpg"
  }
}
```

### Update Password
**PUT** `/profile/password`

Change user password.

**Headers:**
- `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "current_password": "oldpassword",
  "new_password": "newpassword123",
  "new_password_confirmation": "newpassword123"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Password updated successfully. Please login again."
}
```

### Update Profile Photo
**POST** `/profile/photo`

Upload or update profile photo.

**Headers:**
- `Authorization: Bearer {token}`
- `Content-Type: multipart/form-data`

**Request Body (form-data):**
- `foto`: Image file (jpeg, png, jpg, max 2MB)

**Response (200):**
```json
{
  "success": true,
  "message": "Photo updated successfully",
  "data": {
    "foto": "http://domain.com/storage/profiles/profile_1_123456.jpg"
  }
}
```

---

## Banners

### Get All Banners
**GET** `/banners`

Get all active banners.

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Promo Akhir Tahun",
      "image": "http://domain.com/storage/banners/banner1.jpg",
      "link_url": "/products",
      "created_at": "2025-12-20T10:00:00.000000Z"
    }
  ]
}
```

---

## Blogs

### Get All Blogs
**GET** `/blogs`

Get all published blog posts.

**Query Parameters:**
- `per_page` (optional): Items per page (default: 10)
- `page` (optional): Page number

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Sejarah Kopi Indonesia",
      "excerpt": "Indonesia memiliki sejarah panjang dalam industri kopi...",
      "cover": "http://domain.com/storage/blogs/cover1.jpg",
      "published_at": "2025-12-20T10:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 10,
    "total": 25
  }
}
```

### Get Blog Details
**GET** `/blogs/{id}`

Get detailed information of a specific blog post.

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Sejarah Kopi Indonesia",
    "excerpt": "Indonesia memiliki sejarah panjang dalam industri kopi...",
    "content": "<p>Full blog content here...</p>",
    "cover": "http://domain.com/storage/blogs/cover1.jpg",
    "published_at": "2025-12-20T10:00:00.000000Z",
    "created_at": "2025-12-20T09:00:00.000000Z",
    "updated_at": "2025-12-20T09:30:00.000000Z"
  }
}
```

---

## Promos

### Get All Promos
**GET** `/promos`

Get all promo codes.

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "code": "DISKON20",
      "title": "Diskon 20%",
      "description": "Dapatkan diskon 20% untuk pembelian minimal Rp 100.000",
      "discount_type": "percentage",
      "discount_value": 20,
      "min_purchase": 100000,
      "max_discount": 50000,
      "start_date": "2025-12-01",
      "end_date": "2025-12-31",
      "active": true,
      "is_valid": true
    }
  ]
}
```

### Get Active Promos
**GET** `/promos/active`

Get only currently active and valid promos.

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "code": "DISKON20",
      "title": "Diskon 20%",
      "description": "Dapatkan diskon 20% untuk pembelian minimal Rp 100.000",
      "discount_type": "percentage",
      "discount_value": 20,
      "min_purchase": 100000,
      "max_discount": 50000,
      "start_date": "2025-12-01",
      "end_date": "2025-12-31"
    }
  ]
}
```

### Validate Promo Code
**POST** `/promos/validate`

Validate a promo code and calculate discount.

**Request Body:**
```json
{
  "code": "DISKON20",
  "total_belanja": 150000
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Promo code is valid",
  "data": {
    "code": "DISKON20",
    "title": "Diskon 20%",
    "discount_type": "percentage",
    "discount_value": 20,
    "calculated_discount": 30000,
    "final_total": 120000
  }
}
```

**Error Response (400):**
```json
{
  "success": false,
  "message": "Promo code is not valid",
  "reasons": [
    "Minimum purchase of Rp 100,000 required"
  ]
}
```

---

## Kurir

### Get All Kurir
**GET** `/kurir`

Get all available delivery drivers/couriers.

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama": "Budi Santoso",
      "no_telp": "08123456789"
    },
    {
      "id": 2,
      "nama": "Andi Wijaya",
      "no_telp": "08198765432"
    }
  ]
}
```

---

## Error Responses

### Validation Error (422)
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "email": [
      "The email field is required."
    ],
    "password": [
      "The password must be at least 6 characters."
    ]
  }
}
```

### Unauthorized (401)
```json
{
  "success": false,
  "message": "Unauthenticated."
}
```

### Not Found (404)
```json
{
  "success": false,
  "message": "Resource not found"
}
```

### Server Error (500)
```json
{
  "success": false,
  "message": "Internal server error",
  "error": "Error details here"
}
```

---

## Order Status Flow

1. **pending** - Order created, waiting for payment
2. **confirmed** - Payment confirmed by admin
3. **processing** - Order is being prepared
4. **shipped** - Order has been shipped (for delivery)
5. **delivered** - Order completed
6. **cancelled** - Order cancelled

## Payment Status Flow

1. **pending** - Waiting for payment
2. **waiting_confirmation** - Payment proof uploaded, waiting admin confirmation
3. **confirmed** - Payment confirmed
4. **cancelled** - Payment cancelled

## Response Format

All API responses follow this consistent format:

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": { ... }
}
```

## HTTP Status Codes

- `200` - OK (Success)
- `201` - Created (Resource created successfully)
- `400` - Bad Request (Invalid request data)
- `401` - Unauthorized (Authentication required or invalid token)
- `404` - Not Found (Resource not found)
- `422` - Unprocessable Entity (Validation error)
- `500` - Internal Server Error (Server error)

## Authentication

All protected endpoints require Bearer token authentication:

```
Authorization: Bearer {your_token_here}
```

Get the token from `/login` or `/register` endpoints and include it in the Authorization header for subsequent requests.

## Pagination

Endpoints that return lists (products, blogs, orders) support pagination with these parameters:
- `page`: Page number (default: 1)
- `per_page`: Items per page (default varies by endpoint)

Pagination metadata is returned in the `meta` object:
```json
{
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 72
  }
}
```

## File Uploads

For file upload endpoints (profile photo, payment proof):
- Use `Content-Type: multipart/form-data`
- Maximum file size: 2MB
- Allowed formats: jpeg, png, jpg
- Files are stored in `storage/app/public` directory
- URLs returned use `storage/` path

## Rate Limiting

API requests may be rate-limited. If you exceed the limit, you'll receive a `429 Too Many Requests` response.

## CORS

The API supports Cross-Origin Resource Sharing (CORS) for requests from web and mobile applications. Ensure you include the `Accept: application/json` header in all requests.

---

**API Version:** 1.0.0  
**Last Updated:** December 20, 2025