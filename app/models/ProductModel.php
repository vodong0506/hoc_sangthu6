<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";
    private $upload_dir = __DIR__ . '/../../common/access';
    private $max_file_size = 5242880;

    public function __construct($db)
    {
        $this->conn = $db;
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0755, true);
        }
    }

    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                FROM " . $this->table_name . " p
                LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addProduct($name, $description, $price, $category_id, $image_file = null)
    {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        // Xử lý upload ảnh
        $image_name = null;
        if ($image_file && isset($image_file['name']) && $image_file['name'] != '') {
            $upload_result = $this->uploadImage($image_file);
            if (is_array($upload_result)) {
                return $upload_result;
            }
            $image_name = $upload_result;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, image, category_id) 
                  VALUES (:name, :description, :price, :image, :category_id)";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image_name);
        $stmt->bindParam(':category_id', $category_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateProduct($id, $name, $description, $price, $category_id, $image_file = null)
    {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        // Lấy sản phẩm cũ để kiểm tra ảnh
        $product = $this->getProductById($id);
        $image_name = $product->image;

        // Xử lý upload ảnh mới
        if ($image_file && isset($image_file['name']) && $image_file['name'] != '') {
            $upload_result = $this->uploadImage($image_file);
            if (is_array($upload_result)) {
                return $upload_result;
            }
            // Xóa ảnh cũ nếu có
            if ($product->image) {
                $this->deleteImageFile($product->image);
            }
            $image_name = $upload_result;
        }

        $query = "UPDATE " . $this->table_name . " SET name=:name, description=:description, 
                  price=:price, image=:image, category_id=:category_id WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image_name);
        $stmt->bindParam(':category_id', $category_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteProduct($id)
    {
        // Lấy thông tin sản phẩm để xóa ảnh
        $product = $this->getProductById($id);
        if ($product && $product->image) {
            $this->deleteImageFile($product->image);
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Hàm xử lý upload ảnh
    private function uploadImage($image_file)
    {
        $errors = [];

        if ($image_file['error'] != 0) {
            $errors['image'] = 'Lỗi upload ảnh';
            return $errors;
        }

        if ($image_file['size'] > $this->max_file_size) {
            $errors['image'] = 'Kích thước ảnh không được vượt quá 5MB';
            return $errors;
        }

        // Lấy tên file gốc
        $file_name = basename($image_file['name']);
        $file_path = $this->upload_dir . '/' . $file_name;

        // Di chuyển file upload
        if (move_uploaded_file($image_file['tmp_name'], $file_path)) {
            return $file_name;
        }

        $errors['image'] = 'Không thể lưu ảnh';
        return $errors;
    }

    // Hàm xóa file ảnh
    private function deleteImageFile($image_name)
    {
        $file_path = $this->upload_dir . '/' . $image_name;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}
?>