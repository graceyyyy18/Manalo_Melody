<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class StudentsModel extends Model {
    protected $table = 'students';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    /** 
     * Count active (non-deleted) user records.
     * Excludes admin accounts.
     */
    public function count_all_records($search = null) {
        $sql = "SELECT COUNT(id) AS total FROM {$this->table}
                WHERE {$this->soft_delete_column} IS NULL
                  AND role <> 'admin'";
        $params = [];
        if ($search) {
            $sql .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
            $params = ["%{$search}%", "%{$search}%", "%{$search}%"];
        }
        $row = $this->db->raw($sql, $params)->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }

    /** 
     * Get active (non-deleted) user records with pagination.
     * Excludes admin accounts.
     */
    public function get_records_with_pagination($limit_clause, $search = null) {
        $sql = "SELECT * FROM {$this->table}
                WHERE {$this->soft_delete_column} IS NULL
                  AND role <> 'admin'";
        $params = [];
        if ($search) {
            $sql .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
            $params = ["%{$search}%", "%{$search}%", "%{$search}%"];
        }
        $sql .= " ORDER BY id ASC {$limit_clause}";
        return $this->db->raw($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 
     * Count deleted records (soft deleted).
     * Excludes admin accounts.
     */
    public function count_deleted_records($search = null) {
        $sql = "SELECT COUNT(id) AS total FROM {$this->table}
                WHERE {$this->soft_delete_column} IS NOT NULL
                  AND role <> 'admin'";
        $params = [];
        if ($search) {
            $sql .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
            $params = ["%{$search}%", "%{$search}%", "%{$search}%"];
        }
        $row = $this->db->raw($sql, $params)->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }

    /** 
     * Get deleted with pagination.
     * Excludes admin accounts.
     */
    public function get_deleted_with_pagination($limit_clause, $search = null) {
        $sql = "SELECT * FROM {$this->table}
                WHERE {$this->soft_delete_column} IS NOT NULL
                  AND role <> 'admin'";
        $params = [];
        if ($search) {
            $sql .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
            $params = ["%{$search}%", "%{$search}%", "%{$search}%"];
        }
        $sql .= " ORDER BY id DESC {$limit_clause}";
        return $this->db->raw($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Soft delete */
    public function soft_delete($id): ?bool {
        if (empty($id)) return null;
        $sql = "UPDATE {$this->table} SET {$this->soft_delete_column} = NOW() WHERE {$this->primary_key} = ?";
        $stmt = $this->db->raw($sql, [$id]);
        return $stmt->rowCount() > 0 ? true : null;
    }

    /** Restore */
    public function restore($id): ?bool {
        if (empty($id)) return null;
        $sql = "UPDATE {$this->table} SET {$this->soft_delete_column} = NULL WHERE {$this->primary_key} = ?";
        $stmt = $this->db->raw($sql, [$id]);
        return $stmt->rowCount() > 0 ? true : null;
    }

    /** Hard delete */
    public function hard_delete($id): ?bool {
        if (empty($id)) return null;
        $sql = "DELETE FROM {$this->table} WHERE {$this->primary_key} = ?";
        $stmt = $this->db->raw($sql, [$id]);
        return $stmt->rowCount() > 0 ? true : null;
    }

    /** 
     * Find by email (used for login).
     * Includes admin accounts (admins must login).
     */
    public function find_by_email($email) {
        $account = $this->db->table($this->table)->where('email', trim($email))->get();
        if (!$account) return null;
        return is_object($account) ? (array)$account : $account;
    }

    /** Create new account (auto-hash password) */
    public function create_account($data) {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $this->db->table($this->table)->insert($data);
    }

    /** Insert (auto-hash password if needed) */
    public function insert($data) {
        if (!empty($data['password']) && strlen($data['password']) < 60) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $this->db->table($this->table)->insert($data);
    }

    /** Update (auto-hash password if plain) */
    public function update($id, $data) {
        if (!empty($data['password']) && strlen($data['password']) < 60) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $this->db->table($this->table)->where($this->primary_key, $id)->update($data);
    }
}
