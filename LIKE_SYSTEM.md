# Sistem Like Artikel - Magazine

## Fitur Like System
- **Toggle Like**: User bisa like/unlike artikel
- **Real-time Update**: Jumlah like update tanpa refresh
- **Visual Feedback**: Icon berubah warna saat dilike
- **Like Page**: Halaman khusus artikel yang disukai user

## Database Structure
```sql
CREATE TABLE likes (
  id_like bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_artikel bigint(20) UNSIGNED NOT NULL,
  id_user bigint(20) UNSIGNED NOT NULL,
  created_at timestamp NULL,
  updated_at timestamp NULL,
  FOREIGN KEY (id_artikel) REFERENCES artikel(id_artikel) ON DELETE CASCADE,
  FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);
```

## API Endpoint
- **POST** `/like/toggle` - Toggle like/unlike artikel
- **GET** `/like` - Halaman artikel yang disukai

## Frontend Features
- **Interactive Button**: Tombol like dengan hover effect
- **Icon States**: 
  - `bi-heart` (outline) - Belum dilike
  - `bi-heart-fill text-danger` - Sudah dilike
- **Real-time Count**: Update jumlah like tanpa refresh
- **Auth Check**: Hanya user login yang bisa like

## UI Components
- **Card Like Button**: Di halaman artikel list
- **Detail Like Button**: Di halaman detail artikel
- **Like Page**: Daftar artikel yang disukai user

## JavaScript Functionality
```javascript
// Toggle like dengan AJAX
fetch('/like/toggle', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf_token
    },
    body: JSON.stringify({ artikel_id: id })
})
```

## Security
- **CSRF Protection**: Token CSRF untuk semua request
- **Auth Middleware**: Hanya user login yang bisa like
- **Foreign Key**: Constraint database untuk data integrity

## User Experience
- **Guest Users**: Melihat jumlah like tanpa bisa interact
- **Logged Users**: Bisa like/unlike dengan visual feedback
- **Like Page**: Koleksi artikel favorit user

## Files Structure
- `LikeController.php` - Logic toggle dan halaman like
- `like.php` - Model untuk tabel likes
- `pages/like.blade.php` - Halaman artikel yang disukai
- `LikeSeeder.php` - Data sample untuk testing

## Testing
1. Login sebagai user
2. Buka halaman artikel
3. Klik tombol like (icon berubah merah)
4. Klik lagi untuk unlike (icon kembali outline)
5. Buka halaman "Like" untuk melihat artikel favorit

Sistem like sudah terintegrasi dengan authentication dan memberikan feedback real-time!