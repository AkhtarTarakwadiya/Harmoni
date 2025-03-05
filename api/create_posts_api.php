<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "create_post") {
        // Collect Input Data
        if (!isset($_POST['user_id']) || !isset($_POST['post_content'])) {
            $response = [
                "status" => "201",
                "message" => "User ID and Post Content are required"
            ];
        } else {
            $user_id = trim($_POST['user_id']);
            $post_content = trim($_POST['post_content']);

            // Validate user ID (should be a valid number)
            if (!ctype_digit($user_id)) {
                $response = [
                    "status" => "201",
                    "message" => "Invalid User ID"
                ];
            } elseif (strlen($post_content) < 5) {
                $response = [
                    "status" => "201",
                    "message" => "Post content must be at least 5 characters long"
                ];
            } else {
                // Insert Post into `posts` table
                $insertPostQuery = "INSERT INTO posts (user_id, post_content) VALUES ('$user_id', '$post_content')";
                if (!mysqli_query($conn, $insertPostQuery)) {
                    $response = [
                        "status" => "201",
                        "message" => "Failed to create post"
                    ];
                } else {
                    $post_id = mysqli_insert_id($conn); // Get the inserted post ID

                    // Check if media files were uploaded
                    if (!empty($_FILES['media']['name'][0])) {
                        $uploadDirectory = "/var/www/html/Harmoni/uploads/posts/";

                        $allowedTypes = ["image/jpeg", "image/png", "image/gif", "video/mp4", "video/mov", "video/avi"];
                        $maxFileSize = 10 * 1024 * 1024; // 10MB max file size
                        $uploadedFiles = [];

                        foreach ($_FILES['media']['name'] as $key => $fileName) {
                            $fileTmp = $_FILES['media']['tmp_name'][$key];
                            $fileSize = $_FILES['media']['size'][$key];
                            $fileType = mime_content_type($fileTmp);

                            // Validate file type
                            if (!in_array($fileType, $allowedTypes)) {
                                $response = [
                                    "status" => "201",
                                    "message" => "Invalid file type. Only images and videos are allowed."
                                ];
                                break;
                            }

                            // Validate file size
                            if ($fileSize > $maxFileSize) {
                                $response = [
                                    "status" => "201",
                                    "message" => "File size should not exceed 10MB"
                                ];
                                break;
                            }

                            // Generate unique filename
                            $newFileName = time() . "_" . basename($fileName);
                            $targetFilePath = $uploadDirectory . $newFileName;

                            // Move uploaded file
                            if (move_uploaded_file($fileTmp, $targetFilePath)) {
                                $uploadedFiles[] = $newFileName;
                            } else {
                                $response = [
                                    "status" => "201",
                                    "message" => "Error uploading media"
                                ];
                                break;
                            }
                        }

                        // Insert media files into `posts_media_master`
                        if (!empty($uploadedFiles)) {
                            foreach ($uploadedFiles as $mediaFile) {
                                $insertMediaQuery = "INSERT INTO posts_media_master (post_id, media) VALUES ('$post_id', '$mediaFile')";
                                mysqli_query($conn, $insertMediaQuery);
                            }
                        }
                    }

                    $response = [
                        "status" => "200",
                        "message" => "Post created successfully",
                        "post_id" => $post_id
                    ];
                }
            }
        }
    } else {
        $response = [
            "status" => "201",
            "message" => "Invalid Request Method"
        ];
    }
} else {
    $response = [
        "status" => "201",
        "message" => "Only POST Method Allowed"
    ];
}

echo json_encode($response);
