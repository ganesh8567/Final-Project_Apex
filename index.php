<?php  $conn = new mysqli('localhost', 'username', 'password', 'database');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search variable
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query
$sql = "SELECT * FROM posts WHERE title LIKE ? OR content LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $search . "%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Fetch posts
$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}
$stmt->close();
$conn->close();