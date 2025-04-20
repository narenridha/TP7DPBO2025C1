<?php
require_once 'config/db.php';
require_once 'Teacher.php';

class Assignment {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Ambil semua assignment (pengajaran)
    public function getAllAssignments($search = null) {
        if ($search) {
            $stmt = $this->db->prepare("SELECT assignments.*, teachers.name AS teacher_name, team_members.name AS member_name 
                                        FROM assignments 
                                        JOIN teachers ON assignments.teacher_id = teachers.id 
                                        JOIN team_members ON assignments.member_id = team_members.id 
                                        WHERE teachers.name LIKE ?");
            $stmt->execute(['%' . $search . '%']);
        } else {
            $stmt = $this->db->query("SELECT assignments.*, teachers.name AS teacher_name, team_members.name AS member_name 
                                      FROM assignments 
                                      JOIN teachers ON assignments.teacher_id = teachers.id 
                                      JOIN team_members ON assignments.member_id = team_members.id");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Assign teacher ke member
    public function assignTeacher($teacher_id, $member_id) {
        $teacher = new Teacher();
        $stmtTeacher = $this->db->prepare("SELECT availability FROM teachers WHERE id = ?");
        $stmtTeacher->execute([$teacher_id]);
        $teacherData = $stmtTeacher->fetch();

        if ($teacherData && $teacherData['availability'] > 0) {
            $stmt = $this->db->prepare("INSERT INTO assignments (teacher_id, member_id, assignment_date) VALUES (?, ?, CURDATE())");
            $teacher->updateAvailability($teacher_id, $teacherData['availability'] - 1);
            return $stmt->execute([$teacher_id, $member_id]);
        }

        return false;
    }

    // Tandai assignment selesai
    public function completeAssignment($assignment_id) {
        $stmtAssign = $this->db->prepare("SELECT teacher_id FROM assignments WHERE id = ?");
        $stmtAssign->execute([$assignment_id]);
        $assignment = $stmtAssign->fetch();

        if ($assignment) {
            $stmtTeacher = $this->db->prepare("SELECT availability FROM teachers WHERE id = ?");
            $stmtTeacher->execute([$assignment['teacher_id']]);
            $teacherData = $stmtTeacher->fetch();

            if ($teacherData) {
                $teacher = new Teacher();
                $teacher->updateAvailability($assignment['teacher_id'], $teacherData['availability'] + 1);
                $stmt = $this->db->prepare("UPDATE assignments SET completion_date = CURDATE() WHERE id = ?");
                return $stmt->execute([$assignment_id]);
            }
        }

        return false;
    }

    // Hapus assignment (hanya jika sudah selesai)
    public function deleteAssignment($id) {
        $stmtCheck = $this->db->prepare("SELECT completion_date FROM assignments WHERE id = ?");
        $stmtCheck->execute([$id]);
        $data = $stmtCheck->fetch();

        if ($data && $data['completion_date'] === null) {
            echo "<script>alert('Selesaikan dulu tugasnya, bro!');</script>";
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM assignments WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
