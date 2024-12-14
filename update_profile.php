<?php
session_start();
include "db.php"; 

if(isset($_POST['update_profile'])) {
    // Get form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

  
    $user_id = $_SESSION['user_id'];

 
    $query = "UPDATE user_table SET firstname=?, lastname=?, email=?, password=?, phone=? WHERE id=?";
    
   
    $stmt = $conn->prepare($query);
    
  
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

   
    $stmt->bind_param("sssssi", $firstname, $lastname, $email, $password, $phone, $user_id);

   
    if($stmt->execute()) {
       
        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: dashboard.php"); 
        exit();
    } else {
       
        $_SESSION['error_message'] = "Error updating profile. Please try again.";
        header("Location: update_profile_form.php");
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: white;
            
        }
        .container {
            padding: 50px;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 50px;
            
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-weight: 700;
            font-size: 1.8rem;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 15px;
            font-family: inherit;
            background-color: rgba(255, 255, 255, 0.8);
            color: #333;
            font-size: 0.9rem;
        }
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #ff5a5f;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .btn-back {
            background-color: #ff5a5f; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Update Profile</h2>
                    <form action="update_profile.php" method="post">
                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" required>
                        
                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" required>
                        
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        
                        <label for="phone">Contact Number:</label>
                        <input type="text" id="phone" name="phone" required>
                        
                        <button type="submit" name="update_profile">Update Profile</button>
                    </form>
                </div>
                <div class="button-container">
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
            </div>

            <!-- Image Section -->
            <div class="col-md-6">
                <img src="https://img.freepik.com/free-vector/update-concept-illustration_114360-1742.jpg?t=st=1726412458~exp=1726416058~hmac=44618a2e78f07fa0604f264377116a0fc75a9d6f938af1f6edac57e89a168bfd&w=740" alt="Update Illustration" class="img-fluid rounded">
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>