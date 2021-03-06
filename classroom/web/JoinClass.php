<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join class</title>
    <link rel="stylesheet" href="css/joinclass.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <button class="btn"><i class="fa fa-bars"></i></button>
        <h4>Join class</h4>
        <form class="form-inline">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Join</button>
        </form>
    </nav>
    <div class="container">
        <div class="account">
            <div><p>You're currently signed in as</p></div>
            <div class="row">
                <div class="col-1">
                    <img class="avt" src="image/avt1.jpg" alt="">
                </div>
                <div class="col-7 ml-4">
                    <p>Nguyễn Thị Huyền Trang</p>
                    <p>trangnguyen9b2013@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="class-code">
            <h5>Class code</h5>
            <p>Ask your teacher for the class code, then enter it here.</p>
            <input type="text" id="fname" name="fname">
        </div>
        <div class="describe">
            <h6>To sign in with a class code</h6>
            <ul>
                <li>Use an authorized account</li>
                <li>Use a class code with 5 - 7 letters or numbers, and no spaces or symbols</li>
            </ul>
            <p>If you have trouble joining the class, go to the Help Center articles</p>
        </div>
    </div>

</body>

</html>