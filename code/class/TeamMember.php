<?php
require_once 'config/db.php';

class TeamMember {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // CREATE
    public function addMember($name, $email, $phone, $role) {
        $stmt = $this->db->prepare("INSERT INTO team_members (name, email, phone, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $role]);
    }

    // READ
    public function getAllMembers($search = null) {
        if ($search) {
            $stmt = $this->db->prepare("SELECT * FROM team_members WHERE name LIKE ?");
            $stmt->execute(["%" . $search . "%"]);
        } else {
            $stmt = $this->db->query("SELECT * FROM team_members");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function getMemberById($id) {
        $stmt = $this->db->prepare("SELECT * FROM team_members WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function updateMember($id, $name, $email, $phone, $role) {
        $stmt = $this->db->prepare("UPDATE team_members SET name = ?, email = ?, phone = ?, role = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $phone, $role, $id]);
    }

    // DELETE
    public function deleteMember($id) {
        $stmt = $this->db->prepare("DELETE FROM team_members WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
