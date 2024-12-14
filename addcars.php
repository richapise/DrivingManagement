<?php
session_start();
include "db.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login_form.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carCompany = $conn->real_escape_string($_POST['car_company']);
    $carName = $conn->real_escape_string($_POST['car_name_select']);
    $learnerId = $conn->real_escape_string($_SESSION['user_id']);
    $username = $conn->real_escape_string($_SESSION['username']);

    // Insert query
    $sql = "INSERT INTO user_add_car (user_id, username, car_company, car_name) VALUES ('$learnerId', '$username', '$carCompany', '$carName')";

    if ($conn->query($sql) === TRUE) {
        $success = true;
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cars</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: white;
            margin: 0;
            padding-top: 80px;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: -60px;
            display: flex;
        }

        .form-section {
            flex: 2;
            padding-left: 80px;
        }

        .image-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-section img {
            max-width: 160%;
            height: auto;
        }

        h1 {
            color: #ff5a5f;
        }

        label {
            color: #ff5a5f;
        }

        .form-control {
            width: 80%;
        }

        .btn-primary {
            background-color: #ff5a5f;
            border: none;
            color: white;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #e14d52;
        }

        .alert {
            position: fixed;
            top: -100px;
            right: 20px;
            z-index: 1000;
            display: none;
            opacity: 0;
            transition: top 0.5s ease, opacity 0.5s ease;
        }

        .alert.show {
            display: block;
            top: 20px;
            opacity: 1;
        }
        .btn-back {
            background-color: #ff5a5f; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="image-section">
            <img src="https://img.freepik.com/premium-vector/white-electric-car_1308-21048.jpg" alt="Car Image">
        </div>
        <div class="form-section">
            <h1>Add Cars</h1><br>
            <?php if (isset($success) && $success): ?>
                <div class="alert alert-success alert-dismissible show" role="alert">
                    Car added successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form id="carForm" action="" method="POST">
                <div class="form-group">
                    <label for="car_company">Car Company</label>
                    <select class="form-control" id="car_company" name="car_company" required>
                        <option value="">-- Select a Car Company --</option>
                        <option value="Honda">Honda</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Mahindra">Mahindra</option>
                        <option value="Ford">Ford</option>
                        <option value="Hyundai">Hyundai</option>
                        <option value="Maruti Suzuki">Maruti Suzuki</option>
                        <option value="Tata">Tata</option>
                        <option value="Renault">Renault</option>
                        <option value="Skoda">Skoda</option>
                        <option value="Volkswagen">Volkswagen</option>
                    </select><br>
                </div>
                <div class="form-group">
                    <label for="car_name_select">Select a Car</label>
                    <select class="form-control" id="car_name_select" name="car_name_select" required>
                        <option value="">-- Select a Car --</option>
                    </select><br>
                </div>
                <button type="submit" class="btn btn-primary">Add Car</button>
            </form>
            <div class="button-container">
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>  
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        const carModels = {
            "Honda": ["Civic", "Accord", "CR-V"],
            "Toyota": ["Corolla", "Camry", "RAV4"],
            "Mahindra": ["Verito", "XUV500", "Thar"],
            "Ford": ["Figo", "EcoSport", "Fiesta"],
            "Hyundai": ["Elantra", "i20", "Creta"],
            "Maruti Suzuki": ["Swift", "Baleno", "Vitara Brezza"],
            "Tata": ["Indica", "Nexon", "Harrier"],
            "Renault": ["Duster", "Kwid", "Triber"],
            "Skoda": ["Rapid", "Octavia", "Superb"],
            "Volkswagen": ["Polo", "Vento", "Tiguan"]
        };

        document.getElementById('car_company').addEventListener('change', function() {
            const company = this.value;
            const carSelect = document.getElementById('car_name_select');
            carSelect.innerHTML = '<option value="">-- Select a Car --</option>';
            if (company && carModels[company]) {
                carModels[company].forEach(car => {
                    const option = document.createElement('option');
                    option.value = car;
                    option.textContent = car;
                    carSelect.appendChild(option);
                });
            }
        });
    </script>
</body>
</html>