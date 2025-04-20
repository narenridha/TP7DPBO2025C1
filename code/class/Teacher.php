<?php
require_once 'config/db.php';

class Teacher {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Ambil semua teacher (guru F1)
    public function getAllTeachers($search = null) {
        if ($search) {
            $stmt = $this->db->prepare("SELECT * FROM teachers WHERE name LIKE ? OR expertise LIKE ?");
            $stmt->execute(['%' . $search . '%', '%' . $search . '%']);
        } else {
            $stmt = $this->db->query("SELECT * FROM teachers");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah teacher baru
    public function addTeacher($name, $expertise, $code, $category, $availability) {
        $stmt = $this->db->prepare("INSERT INTO teachers (name, expertise, code, category, availability) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $expertise, $code, $category, $availability]);
    }

    // Update teacher
    public function updateTeacher($id, $name, $expertise, $code, $category, $availability) {
        $stmt = $this->db->prepare("UPDATE teachers SET name = ?, expertise = ?, code = ?, category = ?, availability = ? WHERE id = ?");
        return $stmt->execute([$name, $expertise, $code, $category, $availability, $id]);
    }

    // Hapus teacher
    public function deleteTeacher($id) {
        $stmt = $this->db->prepare("DELETE FROM teachers WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Ambil teacher berdasarkan ID
    public function getTeacherById($id) {
        $stmt = $this->db->prepare("SELECT * FROM teachers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ambil berdasarkan kategori
    public function getTeachersByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM teachers WHERE category = ?");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update ketersediaan
    public function updateAvailability($id, $availability) {
        $stmt = $this->db->prepare("UPDATE teachers SET availability = ? WHERE id = ?");
        return $stmt->execute([$availability, $id]);
    }
}
?>
