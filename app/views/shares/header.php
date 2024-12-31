<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản lý sản phẩm</title>
<link
href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
rel="stylesheet">


</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#">Quản lý sản phẩm</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" datatarget="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" href="/webbanhang/Product">Danh sách sản phẩm</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/webbanhang/Product/add">Thêm sản phẩm</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/webbanhang/Product/cart">Giỏ hàng</a>
</li>
<?php 
                                        if(SessionHelper::isLoggedIn()){ 
                                            echo "<a class='navlink'>".$_SESSION['username']."</a>"; 
                                        } 
                                        else{ 
                                            echo  "<a class='nav-link' href='/webbanhang/account/login'>Login</a>"; 
                                        } 
                                    ?> 
 
                </li> 
                <li class="nav-item"> 
                    </a> 
                    <?php 
                                        if(SessionHelper::isLoggedIn()){ 
                                            echo  "<a class='nav-link' href='/webbanhang/account/logout'>Logout</a>"; 
                                        } 
                                    ?> 
 
                </li> 

</ul>
</div>
</nav>
<div class="container mt-4">
  

<style>
    .product-image { 
        max-width: 100px; 
        height: auto;
}
 /* Container chứa tất cả các sản phẩm */
.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* Căn giữa các sản phẩm */
    gap: 20px; /* Khoảng cách giữa các thẻ */
    align-items: stretch; /* Đảm bảo các item có chiều cao bằng nhau */
}

/* Mỗi thẻ sản phẩm */
.product-item {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 30%; /* Mỗi thẻ chiếm 30% chiều rộng */
    min-height: 350px; /* Đảm bảo chiều cao tối thiểu */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease; /* Thêm hiệu ứng khi hover */
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Cân bằng nội dung trong thẻ */
    align-items: center; /* Căn giữa nội dung trong mỗi thẻ */
}

.product-item:hover {
    transform: translateY(-5px); /* Di chuyển nhẹ khi hover */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
}

/* Hình ảnh sản phẩm */
.product-image {
    width: 100%; /* Chiếm toàn bộ chiều rộng của thẻ */
    height: 200px; /* Đặt chiều cao cố định */
    overflow: hidden; /* Ẩn phần ảnh thừa */
    border-radius: 5px;
    margin-bottom: 15px;
    display: flex;
    justify-content: center; /* Căn giữa ảnh trong khung */
    align-items: center; /* Căn giữa ảnh trong khung */
}

.product-image img {
    width: 100%; /* Đảm bảo ảnh chiếm hết chiều rộng */
    height: 100%; /* Đảm bảo ảnh có chiều cao đủ */
    object-fit: cover; /* Cắt ảnh sao cho tỷ lệ hình ảnh giữ nguyên mà không bị méo */
}

/* Tên sản phẩm */
.product-name {
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0;
}

/* Mô tả sản phẩm */
.product-description {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
}

/* Giá sản phẩm */
.product-price {
    font-size: 16px;
    color: #e74c3c;
    font-weight: bold;
    margin: 10px 0;
}

/* Danh mục sản phẩm */
.product-category {
    font-size: 14px;
    color: #3498db;
}

/* Các nút hành động */
.product-actions {
    margin-top: 15px;
}

.product-actions .btn {
    margin: 5px;
}

/* Responsive: Điều chỉnh cho thiết bị di động */
@media (max-width: 768px) {
    .product-item {
        width: 100%; /* Trên màn hình nhỏ, mỗi thẻ chiếm full chiều rộng */
    }
}


/* Cải thiện giao diện list */
/* Cải tiến thiết kế thẻ card đồng đều về chiều cao */
.card {
    display: flex;
    flex-direction: column; /* Xếp các phần tử theo chiều dọc */
    height: 100%; /* Thẻ card chiếm toàn bộ chiều cao có sẵn */
    min-height: 300px; /* Đặt chiều cao tối thiểu cho card */
    margin-bottom: 15px; /* Khoảng cách giữa các thẻ */
    padding: 15px; /* Padding nhỏ gọn */
    border-radius: 8px; /* Bo góc nhẹ */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08); /* Bóng đổ nhẹ */
    background-color: #fff; /* Màu nền trắng */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Thêm hiệu ứng hover */
    max-width: 320px; /* Đặt chiều rộng tối đa */
    margin-left: auto; /* Căn giữa thẻ */
    margin-right: auto; /* Căn giữa thẻ */
    display: flex;
    flex-direction: column; /* Chắc chắn rằng các phần tử xếp theo chiều dọc */
    justify-content: space-between; /* Đảm bảo các phần tử bên trong card được phân bố đều */
}

/* Hiệu ứng hover khi người dùng rê chuột */
.card:hover {
    transform: translateY(-3px); /* Đẩy thẻ lên khi hover */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.12); /* Tăng bóng đổ */
}

/* Đảm bảo phần card-body có chiều cao linh hoạt */
.card-body {
    flex-grow: 1; /* Cho phép card-body mở rộng */
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Phân bố đều các phần tử */
    padding: 8px; /* Padding hợp lý */
    font-size: 14px; /* Kích thước chữ vừa phải */
    color: #333; /* Màu chữ tối */
    overflow: hidden; /* Tránh việc tràn nội dung */
}

/* Tùy chỉnh phần footer của card */
.card-footer a {
    margin-top: 12px; /* Khoảng cách giữa các nút */
    font-size: 14px; /* Kích thước chữ vừa phải */
    color: #007bff; /* Màu chữ nút */
    text-decoration: none; /* Bỏ gạch chân */
    transition: color 0.3s ease; /* Hiệu ứng chuyển màu */
}

/* Hiệu ứng hover cho các liên kết */
.card-footer a:hover {
    color: #0056b3; /* Màu khi hover */
}

/* Đảm bảo các phần tử trong lưới card đều cách nhau */
.row {
    margin-left: -5px;
    margin-right: -5px;
}

.col-md-4 {
    padding-left: 5px;
    padding-right: 5px;
}

/* Cải tiến văn bản trong card */
.card-text {
    line-height: 1.5; /* Tăng khoảng cách dòng cho dễ đọc */
    text-align: justify; /* Căn đều văn bản */
    color: #555; /* Màu chữ nhẹ nhàng */
}

</style>


  
