<?php 
// Require SessionHelper and other necessary files 
require_once('app/config/database.php'); 
require_once('app/models/ProductModel.php'); 
require_once('app/models/CategoryModel.php'); 

class ProductController 
{ 
    private $productModel; 
    private $db; 
    
    // Kiểm tra quyền admin
    private function checkAdmin() {
        session_start();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /webbanhang/no_permission');
            exit;
        }
    }
    
    // Constructor, kết nối cơ sở dữ liệu
    public function __construct() { 
        $this->db = (new Database())->getConnection(); 
        $this->productModel = new ProductModel($this->db);  
    } 
    
    // Trang danh sách sản phẩm
    public function index() { 
        $products = $this->productModel->getProducts(); 
        include 'app/views/product/list.php'; 
    } 
    
    // Xem chi tiết sản phẩm
    public function show($id) { 
        $product = $this->productModel->getProductById($id); 
        if ($product) { 
            include 'app/views/product/show.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
    } 
    
    // Thêm sản phẩm mới
    public function add() { 
        $this->checkAdmin();
        $categories = (new CategoryModel($this->db))->getCategories(); 
        include_once 'app/views/product/add.php'; 
    } 
    
    // Lưu sản phẩm vào cơ sở dữ liệu
    public function save() { 
       
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name'] ?? ''; 
            $description = $_POST['description'] ?? ''; 
            $price = $_POST['price'] ?? ''; 
            $category_id = $_POST['category_id'] ?? null; 

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                $image = $this->uploadImage($_FILES['image']); 
            } else { 
                $image = ""; 
            }
            
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image); 

            if (is_array($result)) { 
                $errors = $result; 
                $categories = (new CategoryModel($this->db))->getCategories(); 
                include 'app/views/product/add.php'; 
            } else {   
                header('Location: /webbanhang/Product'); 
            } 
        } 
    } 
    
    // Chỉnh sửa sản phẩm
    public function edit($id) { 
        $this->checkAdmin(); // Kiểm tra quyền admin
        $product = $this->productModel->getProductById($id); 
        $categories = (new CategoryModel($this->db))->getCategories(); 
        if ($product) { 
            include 'app/views/product/edit.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $existing_image = $_POST['existing_image']; // Lấy ảnh cũ từ form

            // Biến lưu tên ảnh
            $image = $existing_image; // Nếu không có ảnh mới, giữ nguyên ảnh cũ

            // Kiểm tra nếu có ảnh mới được tải lên
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Xử lý tải ảnh mới lên
                $uploadDir = 'uploads/products/';
                $imageName = time() . '-' . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $imageName;

                // Di chuyển file tới thư mục
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $image = $imageName; // Lưu ảnh mới vào biến image
                } else {
                    die('Lỗi khi tải ảnh lên.');
                }
            }

            // Cập nhật sản phẩm trong cơ sở dữ liệu
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, image = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name, $description, $price, $category_id, $image, $id]);

            // Redirect về trang danh sách sản phẩm
            header('Location: /webbanhang/Product');
            exit();
        }
    } 
    
    // Cập nhật sản phẩm
    public function update() { 
        $this->checkAdmin(); // Kiểm tra quyền admin
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $id = $_POST['id']; 
            $name = $_POST['name']; 
            $description = $_POST['description']; 
            $price = $_POST['price']; 
            $category_id = $_POST['category_id']; 

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                $image = $this->uploadImage($_FILES['image']); 
            } else { 
                $image = $_POST['existing_image']; 
            }
            
            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image); 

            if ($edit) { 
                header('Location: /webbanhang/Product'); 
            } else { 
                echo "Đã xảy ra lỗi khi lưu sản phẩm."; 
            } 
        } 
    } 
    
    // Xóa sản phẩm
    public function delete($id) { 
        $this->checkAdmin(); // Kiểm tra quyền admin
        if ($this->productModel->deleteProduct($id)) {   
            header('Location: /webbanhang/Product'); 
        } else { 
            echo "Đã xảy ra lỗi khi xóa sản phẩm."; 
        } 
    } 
    
    // Hàm tải ảnh lên
    private function uploadImage($file) { 
        $target_dir = "uploads/"; 

        // Kiểm tra và tạo thư mục nếu chưa tồn tại 
        if (!is_dir($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        }

        $target_file = $target_dir . basename($file["name"]); 
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); 

        // Kiểm tra xem file có phải là hình ảnh không 
        $check = getimagesize($file["tmp_name"]); 
        if ($check === false) { 
            throw new Exception("File không phải là hình ảnh."); 
        }

        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes) 
        if ($file["size"] > 10 * 1024 * 1024) { 
            throw new Exception("Hình ảnh có kích thước quá lớn."); 
        }

        // Chỉ cho phép một số định dạng hình ảnh nhất định 
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") { 
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF."); 
        }

        // Lưu file 
        if (!move_uploaded_file($file["tmp_name"], $target_file)) { 
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh."); 
        }

        return $target_file; 
    } 
    
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($id) { 
        $product = $this->productModel->getProductById($id); 
        if (!$product) {  
            echo "Không tìm thấy sản phẩm."; 
            return; 
        }

        if (!isset($_SESSION['cart'])) { 
            $_SESSION['cart'] = []; 
        }

        if (isset($_SESSION['cart'][$id])) { 
            $_SESSION['cart'][$id]['quantity']++; 
        } else { 
            $_SESSION['cart'][$id] = [ 
                'name' => $product->name, 
                'price' => $product->price, 
                'quantity' => 1, 
                'image' => $product->image 
            ]; 
        }

        header('Location: /webbanhang/Product/cart'); 
    }

    // Xem giỏ hàng
    public function cart() { 
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : []; 
        include 'app/views/product/cart.php'; 
    } 
    
    // Xác nhận đặt hàng
    public function checkout() { 
        include 'app/views/product/checkout.php'; 
    } 
    
    // Xử lý thanh toán đơn hàng
    public function processCheckout() { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name']; 
            $address = $_POST['address']; 
            $cart = $_SESSION['cart']; 
            $totalPrice = 0; 

            foreach ($cart as $item) { 
                $totalPrice += $item['price'] * $item['quantity']; 
            }

            // Gửi dữ liệu đơn hàng đến cơ sở dữ liệu hoặc dịch vụ thanh toán
            // Xử lý thanh toán ở đây
            
            // Sau khi hoàn tất thanh toán, xóa giỏ hàng
            unset($_SESSION['cart']); 

            echo "Đơn hàng của bạn đã được xác nhận và thanh toán thành công!"; 
        } 
    }
}
