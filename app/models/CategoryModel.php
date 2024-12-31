<?php
class CategoryModel
{
    private $db;
    private $table = 'category'; // Đảm bảo bảng của bạn là 'categories'

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCategories()
    {
        // Truy vấn SQL để lấy danh mục
        $query = 'SELECT id, name, description FROM ' . $this->table;
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Kiểm tra xem có dữ liệu không
        if ($stmt->rowCount() > 0) {
            // Trả về kết quả dưới dạng mảng
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Trả về mảng rỗng nếu không có dữ liệu
        }
    }
}

?>