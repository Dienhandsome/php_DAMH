<?php
class AccountModel 
{ 
    private $conn; 
    private $table_name = "account"; 

    public function __construct($db) 
    { 
        $this->conn = $db; 
    }

    // Lấy thông tin tài khoản theo username
    public function getAccountByUsername($username) 
    { 
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':username', $username, PDO::PARAM_STR); 
        $stmt->execute(); 
        return $stmt->fetch(PDO::FETCH_OBJ); 
    } 

    // Lưu tài khoản mới
    // Trong AccountModel.php
function save($username, $fullname, $password, $role = "user") {
    // Câu lệnh SQL để thêm dữ liệu
    $query = "INSERT INTO " . $this->table_name . " (username, fullname, password, role) VALUES (:username, :fullname, :password, :role)";

    $stmt = $this->conn->prepare($query);

    // Làm sạch dữ liệu
    $username = htmlspecialchars(strip_tags($username));
    $fullname = htmlspecialchars(strip_tags($fullname));
    $password = htmlspecialchars(strip_tags($password));
    $role = htmlspecialchars(strip_tags($role));

    // Gán dữ liệu vào câu lệnh
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        return true;
    }

    return false;
}

    
    

    // Lấy danh sách tài khoản theo vai trò
    public function getAccountsByRole($role)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE role = :role";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
