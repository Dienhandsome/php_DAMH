<?php include 'app/views/shares/header.php'; ?> 

<h1>Chỉnh sửa sản phẩm</h1> 

<form action="/webbanhang/Product/update" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $product->id; ?>">

    <div class="form-group">
        <label for="name">Tên sản phẩm</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Mô tả sản phẩm</label>
        <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>

    <div class="form-group">
        <label for="price">Giá</label>
        <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div class="form-group"> 
        <label for="category_id">Danh mục:</label> 
        <select id="category_id" name="category_id" class="form-control" required> 
            <?php if (!empty($categories) && is_array($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $product->category_id == $category['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="" disabled>Không có danh mục</option>
            <?php endif; ?>
        </select> 
    </div> 

    <div class="form-group">
        <label for="image">Hình ảnh sản phẩm</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
        <img id="preview" src="/path/to/current/image/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" alt="Hình ảnh sản phẩm" style="max-width: 200px; margin-top: 10px;">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </div>
</form>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>