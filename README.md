# TP7DPBO2025C1
**Desain Aplikasi**  
Aplikasi “F1 Garage” ini dibangun sebagai sistem manajemen guru panggilan (“teachers”), anggota tim (“team_members”), dan penugasan (“assignments”). Secara umum desainnya terbagi menjadi tiga lapis:  
1. **Database Layer**  
   - Tiga tabel utama:  
     - `teachers` (id, name, expertise, code, availability, category)  
     - `team_members` (id, name, email, phone, role)  
     - `assignments` (id, teacher_id, member_id, assign_date, complete_date)  
   - Relasi foreign‑key memastikan integritas: `assignments.teacher_id → teachers.id`, `assignments.member_id → team_members.id`.  
2. **Business Logic Layer (Classes PHP)**  
   - **Teacher.php**: operasi CRUD untuk guru (add, getAll, getById, update, delete, updateAvailability).  
   - **TeamMember.php**: operasi CRUD untuk anggota tim (add, getAll, getById, update, delete).  
   - **Assignment.php**: operasi CRUD untuk penugasan (assign, getAll, complete, delete dengan validasi).  
3. **Presentation Layer (Views + Router index.php)**  
   - `index.php` sebagai router sederhana berdasarkan parameter `?page=`  
   - Folder `view/` berisi tiga file: `teachers.php`, `team_members.php`, `assignments.php`  
   - Tiap view meng‑include header/footer (jika ada), menampilkan tabel, form tambah/edit, dan tombol aksi.

---

**Sistem CRUD**  
Pada setiap entitas (Teacher, TeamMember, Assignment) diterapkan pola CRUD:  
- **Create**: form HTML di view mengirimkan data via POST, dikontrol di bagian atas view atau controller, memanggil metode `addXXX(...)`.  
- **Read**: method `getAllXXX()` mengambil seluruh data; method `getXXXById($id)` mengambil satu record untuk keperluan edit.  
- **Update**: form edit memanfaatkan hidden input `id`, method `updateXXX(...)`.  
- **Delete**: link atau tombol “Delete” memanggil via GET `?delete=id`, method `deleteXXX($id)`.  
- **Validasi** pada delete assignment memastikan hanya tugas yang sudah selesai (`complete_date`≠NULL) yang dihapus.

---

**PDO (PHP Data Objects) & Prepared Statements**  
Semua akses ke database menggunakan **PDO** untuk:  
1. **Abstraksi database** — koneksi di‑encapsulate oleh kelas `Database` (file `config/db.php`).  
2. **Keamanan** — setiap query yang memasukkan variabel user memakai **prepared statements**:  
   ```php
   $stmt = $this->db->prepare("INSERT INTO teachers (name, expertise, ...) VALUES (?, ?, ...)");
   $stmt->execute([$name, $expertise, ...]);
   ```
   Ini mencegah SQL injection.  
3. **Error handling** — mode error PDO diatur ke `PDO::ERRMODE_EXCEPTION` sehingga exception bisa ditangkap jika terjadi kegagalan query.

---

**Modularisasi**  
- **Kelas terpisah** untuk setiap entitas (Single Responsibility Principle).  
- **Folder struktur**:  
  ```
  /config
    db.php
  /class
    Teacher.php
    TeamMember.php
    Assignment.php
  /view
    teachers.php
    team_members.php
    assignments.php
  index.php
  style.css
  ```  
- **Routing minimal** di `index.php`—menyederhanakan navigasi tanpa framework:  
  ```php
  switch($_GET['page']) {
    case 'teachers': include 'view/teachers.php'; break;
    case 'team_members': include 'view/team_members.php'; break;
    case 'assignments': include 'view/assignments.php'; break;
  }
  ```

---

**Fitur Pencarian**  
Di masing‑masing halaman, ditambahkan form pencarian yang mengirim parameter via GET, lalu memfilter data pada metode `getAll…($search)`:

1. **teachers.php**  
   - Form:  
     ```html
     <input type="text" name="search" placeholder="Search teacher…" value="<?= $_GET['search'] ?? '' ?>">
     ```  
   - Kelas `Teacher::getAllTeachers($search)` menggunakan `WHERE name LIKE ?` jika `$search` tidak null.

2. **team_members.php**  
   - Form serupa, meneruskan `search`, dipakai dalam `TeamMember::getAllMembers($search)` dengan `WHERE name LIKE ?`.

3. **assignments.php**  
   - Form pencarian berdasarkan nama guru (`teacher_name`) juga meneruskan `search` ke `Assignment::getAllAssignments($search)` yang men‑JOIN `teachers` dan `team_members` serta menambahkan `WHERE teachers.name LIKE ?`.

Dengan pendekatan ini, setiap halaman mampu menampilkan daftar yang terfilter secara dinamis sesuai kata kunci pencarian tanpa merombak struktur utama aplikasi.

---

**Dokum**

https://github.com/user-attachments/assets/7a8b1585-5a49-4b28-b7ad-92c4843f46bb

