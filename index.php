<?php
session_start();

$database = new PDO('mysql:host=devkinsta_db;dbname=authexe','root','WSC2rkMYbGqpj0v7');

// var_dump($database);

$query = $database->prepare('SELECT * FROM students');
$query->execute();

$students = $query->fetchAll();

if(
    $_SERVER['REQUEST_METHOD'] === 'POST' 
) {
    // var_dump($_POST['action']);
    if ( $_POST['action'] === 'add' ) {
        $statement = $database->prepare(
            'INSERT INTO students (`name`) 
            VALUES (:name)'
        );
        $statement->execute([
            'name' => $_POST['students']
        ]);
    
        header('Location: /');
        exit;
    }
    
    if ( $_POST['action'] === 'delete') {
        // var_dump($_POST['action']);
        $statement = $database->prepare(
            'DELETE FROM students WHERE id = :id'
        );
        $statement->execute([
            'id' => $_POST['student_id']
        ]);
        header('Location: /');
        exit;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Simple Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
    <style type="text/css">
    body {
        background: #f1f1f1;
    }
    </style>
</head>

<body>
    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="card-title">My Classroom</h3>
            <div class="d-flex justify-content-center">

                <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php" class="btn btn-link" id="logout">Logout</a>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST"
                    class="d-flex justify-content-between align-items-center">
                    <input type="text" class="form-control" name="students" placeholder="Add new student..." required />
                    <input type="hidden" name="action" value="add" />
                    <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
                </form>
                <?php else : ?>
                <a href="login.php" class="btn btn-link" id="login">Login</a>
                <a href="signup.php" class="btn btn-link" id="signup">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="card-title mb-3 gap-3">Student</h3>
            <div class="mt-4">
                <!-- delete -->
                <?php foreach($students as $student): ?>
                <div class="d-flex justify-content-between mb-3">
                    <?php echo $student['id']; ?>
                    <?php echo $student['name']; ?>
                    <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>" />
                        <input type="hidden" name="action" value="delete" />
                        <?php if(isset($_SESSION['user'])):?>
                        <button class="btn btn-danger">Delete</button>
                        <?php endif; ?>
                    </form>
                </div>
                <?php endforeach; ?>
            </div><!-- d-flex -->
        </div><!-- card-body -->
    </div><!-- card -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>