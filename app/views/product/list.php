<?php include 'app/views/shares/header.php'; ?> 

<h1>Danh sách sản phẩm</h1> 
<a href="/webbanhang/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a> 

<div class="row"> <!-- Sử dụng row để tạo lưới -->
    <?php foreach ($products as $product): ?> 
        <div class="col-md-4 mb-4"> <!-- Mỗi sản phẩm sẽ chiếm 4 cột (tương đương 1/3 chiều rộng) -->
            <div class="card"> <!-- Thẻ card cho mỗi sản phẩm -->
                <?php if ($product->image): ?> 
                    <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product Image" class="card-img-top">
                <?php endif; ?> 
                <div class="card-body">
                    <h5 class="card-title"><a href="/webbanhang/Product/show/<?php echo $product->id; ?>"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a></h5>
                    <p class="card-text"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="card-text">Giá: <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VND</p>
                    <p class="card-text">Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                    <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">Sửa</a>
                    <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                    <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary">Thêm vào giỏ hàng</a> 
                </div>
            </div>
        </div>
    <?php endforeach; ?> 
</div>

<?php include 'app/views/shares/footer.php'; ?> 
