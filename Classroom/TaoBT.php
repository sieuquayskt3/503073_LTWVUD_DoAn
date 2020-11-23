<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Bài Tập GV</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>
<link rel="stylesheet" href="css/TaoBT.css">
</head>

<body>
<form action="ProccessTaoBT.php" method="post">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <button class="btn"><i class="fa fa-close"></i></button>
        <a class="navbar-brand">Bài tập</a>
        <form class="form-inline">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Giao bài</button>
        </form>
    </nav>
    <div class="row work">
        
            <div class="col-1">
            </div>
            <div class="col-7">
                <div class="form-group">
                    <input id="title" type="text" class="form-control form-control-lg" placeholder="Tiêu đề" name="text3">
                </div>
                <div class="form-group">
                    <label for="content">Hướng dẫn (nếu có):</label>
                    <textarea class="form-control" rows="5" id="content" name="text"></textarea>
                </div>

                <button type="button" class="btn btn-primary"><i class="fas fa-paperclip"></i> Thêm</button>

            </div>
            <div class="col-4 select">
                <p>Ngày đến hạn</p> <br>
                <input type="date" id="deadline" name="deadline">
            </div>
        
    </div>
    
</form>
</body>

</html>