<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add product example</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://image.winudf.com/v2/image/Y29tLm13Zy50aGVnaW9pZGlkb25nX2ljb25fdDB4d29jMGI/icon.png?w=170&fakeurl=1" alt="" width="72" height="72">
        <h2>Add Product</h2>
      </div>

      <div class="row">
        <div class="col-md order-md-1">
          <form action="processformproduct.php" method="POST" enctype="multipart/form-data">
			<?php
			$id = "";
			$name = "";
			$price = "";
			$category = "";
			$description = "";
			
			if (isset($_GET["id"])) {
				$id = $_GET["id"];
				require "connection.php";
				$sql = "SELECT * FROM product WHERE id=$id";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$name = $row["name"];
				$price = $row["price"];
				$category = $row["category"];
				$description = $row["description"];
			}
			?>
            <input type="hidden" name="id" value="<?php echo $id ?>">
			<div class="mb-3">
              <label for="name">Name</label>
              <div class="input-group">
                <input value="<?php echo $name ?>" type="text" class="form-control" id="name" name="name" required>
              </div>
            </div>
			
			<div class="mb-3">
              <label for="name">Category</label>
              <div class="input-group">
                <select class="input-group" name="category">
					<option value="apple" <?php echo $category=="apple" ? "selected" : "" ?>>Apple</option>
					<option value="samsung" <?php echo $category=="samsung" ? "selected" : "" ?>>Samsung</option>
					<option value="oppo" <?php echo $category=="oppo" ? "selected" : "" ?>>Oppo</option>
					<option value="nokia" <?php echo $category=="nokia" ? "selected" : "" ?>>Nokia</option>
				</select>
              </div>
            </div>
			
			<div class="mb-3">
              <label for="price">Price</label>
              <div class="input-group">
                <input value="<?php echo $price ?>" type="text" class="form-control" id="price" name="price" required>
              </div>
            </div>
			
			<div class="mb-3">
              <label for="description">Description</label>
              <div class="input-group">
                <textarea class="form-control" id="description" name="description" required><?php echo $description ?></textarea>
              </div>
            </div>
			
			<div class="mb-3">
              <label for="fileToUpload">Image</label>
              <div class="input-group">
                <input type="file" id="fileToUpload" name="fileToUpload" required>
              </div>
            </div>
			
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Add</button>
          </form>
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2020 MOBILE WORLD</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacy</a></li>
          <li class="list-inline-item"><a href="#">Terms</a></li>
          <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
      </footer>
    </div>

  </body>
</html>