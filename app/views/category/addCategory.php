<?php 
class CategoryModel 
{ 
    private $conn; 

    public function __construct($db) 
    { 
        $this->conn = $db; 
    } 

    // Lấy danh sách danh mục
    public function getCategories() 
    { 
        $query = "SELECT * FROM categories"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    } 

    // Thêm danh mục mới
    public function addCategory($name) 
    { 
        $query = "INSERT INTO categories (name) VALUES (:name)"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':name', $name); 
        return $stmt->execute(); 
    } 
}
?>
