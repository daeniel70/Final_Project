<?php
session_start();

// Check if the computer array is set in the session
if (!isset($_SESSION['computers'])) {
    // Initialize the computer array if it's not set
    $_SESSION['computers'] = [];
}

// Function to add a computer to the system
function addComputer($name, $type, $status) {
    $computer = [
        'name' => $name,
        'type' => $type,
        'status' => $status,
    ];

    $_SESSION['computers'][] = $computer;
}

function deleteinput($index){
    if(isset($_SESSION['computers'][$index])){
        unset($_SESSION['computers'][$index]);
        $_SESSION['computers'] = array_values($_SESSION['computers']);
    }
}

// Check if the form is submitted to add a computer
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $status = $_POST['status'];

    // Validate input (you can add more validation)
    if (!empty($name) && !empty($type) && !empty($status)) {
        addComputer($name, $type, $status);
    }
        
    } elseif (isset($_POST['remove'])){
        $index = $_POST['delete'];
        deleteinput($index);
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href = "css/bootstrap.min.css" rel = "stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

        <title>Computer Management System</title>

    <style>

        
        img{
            padding: 5px;
            width: 150px;
        }

        
        body {
            text-align: left;
            margin: 50px;
            background: rgb(218,216,254);
            background: radial-gradient(circle, rgba(218,216,254,1) 0%, rgba(255,34,243,1) 100%, rgba(255,255,255,1) 100%);
        }

        h1 {
            color: #333;
            font-family: 'Kanit', sans-serif;
            text-align:left;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            
        }

        th, .daeniel, #action {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            border: 1px solid;
            border-color: black;
        }

        .daeniel td{
            border: 1px solid;
            border-color: black;
        }

        th {
            background-color: #e4007c;
            color: white;
            text-align:center;
        }

        form {
            margin-top: 20px;
        }

        input, select {
            padding: 5px;
            font-size: 20px;
        }

        button {
            padding: 5px 10px;
            background-color: #3c3c40;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        label{
            font-size: 20px;
        }
        .gozar{
            border-color: white;
        }

        .gozar h1{
            margin-right: 1000px;
        }
        button{
            padding: 0.6em 2em;
            border: none;
            outline: none;
            color: rgb(255, 255, 255);
            background: #111;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 10px;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            }
            button:before {
            content: "";
            background: linear-gradient(
                45deg,
                #ff0000,
                #ff7300,
                #fffb00,
                #48ff00,
                #00ffd5,
                #002bff,
                #7a00ff,
                #ff00c8,
                #ff0000
            );
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 400%;
            z-index: -1;
            filter: blur(5px);
            -webkit-filter: blur(5px);
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            animation: glowing-button-85 20s linear infinite;
            transition: opacity 0.3s ease-in-out;
            border-radius: 10px;
            }
            @keyframes glowing-button-85 {
            0% {
                background-position: 0 0;
            }
            50% {
                background-position: 400% 0;
            }
            100% {
                background-position: 0 0;
            }
            }

            button:after {
            z-index: -1;
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: #222;
            left: 0;
            top: 0;
            border-radius: 10px;
            }
            input[type="text"]
            {
                background: transparent;
            }
            select{
                background: transparent;
            }



    </style>
</head>
<body>
<table class="gozar">
    <tr>
    <td> <img src="dwcc.png"></td>
     <td><h1>Computer Management System</h1></td>
    </tr>
    </table>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Computer Name: </label>
        <input type="text" name="name" id="name" required>
        <label for="type">Computer Type: </label>
        <input type="text" name="type" id="type" required>
        <label for="status">Status: </label>
        <select name="status" id="status" required>
            <option value="Operational">Operational</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Out of Service">Out of Service</option>
        </select> &nbsp
        <button type="submitbtn" name="submit">Add Computer</button>
    </form>

    <table class="daeniel">
        <tr>
            <th>Computer Name</th>
            <th>Computer Type</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($_SESSION['computers'] as $index => $computer) : ?>
            <tr>
                <td><?php echo $computer['name']; ?></td>
                <td><?php echo $computer['type']; ?></td>
                <td><?php echo $computer['status']; ?></td>
                <td>
                    <form class="delete-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="delete" value="<?php echo $index; ?>">
                    <button type="submitbtn" name="remove">DELETE</button>
                    </form>
                </td>                                                
            </tr>
        <?php endforeach; ?>

    </table>
</body>
</html>