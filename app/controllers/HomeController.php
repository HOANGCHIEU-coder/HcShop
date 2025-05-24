<?php
require_once __DIR__ . '/../core/Database.php';

class HomeController {
    public function index() {
        
        $db = new Database();
        $conn = $db->getConnection();  

        $search = '';
        $filter = '';
        $conditions = [];

        if (isset($_GET['search']) && trim($_GET['search']) !== '') {
            $search = trim($_GET['search']);
            $search_safe = mysqli_real_escape_string($conn, $search);
            $conditions[] = "LOWER(name) LIKE LOWER('%$search_safe%')";
        }

        if (isset($_GET['filter']) && in_array($_GET['filter'], ['women', 'men'])) {
            $filter = $_GET['filter'];
            $conditions[] = "LOWER(category) = '$filter'";
        }

        $where = '';
        if (!empty($conditions)) {
            $where = 'WHERE ' . implode(' AND ', $conditions);
        }

        $sql = "SELECT * FROM products $where";
        $result = $conn->query($sql);

        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        require_once __DIR__ . '/../views/home.php';
    }
}
