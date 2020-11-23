<?php 
   // Kiểm tra nếu CHƯA đăng nhập thì không vào home.php
   session_start();

   if (!isset($_SESSION["username"])){
      header("location: login.php");
      exit();
   }

   //----- 0:51 delete

   // chọn thư mục htdocs/users/admin làm thư mục root
   // user chỉ được phép đọc ghi trong phạm vi thư mục
   // nếu thư mục chưa tồn tại sẽ được tạo
 
   
   $root = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $_SESSION['username'];

   if (!file_exists($root)){
      mkdir($root);
   }

   // create folder
   if (isset($_POST['action'])){
       $action = $_POST['action'];
       if ($action == 'create-folder' 
        && isset($_POST['path'])
        && isset($_POST['folder-name'])){
            $path = $_POST['path'];
            $name = $_POST['folder-name'];
            $newFolder = "$root/$path/$name";
            mkdir($newFolder);
       } else if ($action == 'delete-file' 
         && isset($_POST['path'])
         && isset($_POST['file-name'])){
            $path = $_POST['path'];
            $file = $_POST['file-name'];
            $fullPath = "$root/$path/$file";
            if (file_exists($fullPath) && is_file($fullPath)){
               unlink($fullPath);
            } else {
               // xóa thư mục phải đệ quy xóa file trước
               //rmdir($fullPath)
            }
         }
   }

   // scandir trả về danh sách tập tin và thư mục con của tham số truyền vào, '.' đại diện thư mục con, '..' đại diện thư mục cha
   $listFiles = scandir($root);
   
   //-- load thư mục con
   if (isset($_GET['dir'])){
    
      $dir = $_GET['dir']; // ví dụ users/admin/video nếu $_GET['dir']=video
      $path = "$root/$dir";
      if (!file_exists($path) || !is_dir($path)){
         die('Thư mục không hợp lệ, ngưng thực thi');
      }
   } else {
      $dir = ''; // thư mục users/admin
   }
   if (empty($dir)){
      $path = "$root";
   } else {
      $path = "$root/$dir";
   }

   $listFiles = sortFolder(scandir($path), $path);
   // $listFiles = scandir($path);
   
   // Sort a->z 
   function sortFolder($list, $path){
      
      $dirs = [];
      $files = [];

      foreach($list as $i){
         
         if ($i == '.' || $i == '..'){
            continue;
         }
         $p = "$path/$i";
         if (is_dir($p)){
            $dirs[] = $i;
         } else {
            $files[] = $i;
         }
      }
      
      natcasesort($files);
      return array_merge($dirs, $files);
   }

   
   $ext_icons = [
      'zip' => '<i class="fas fa-file-archive"></i>',
      'rar' => '<i class="fas fa-file-archive"></i>',
      'gz' => '<i class="fas fa-file-archive"></i>',
      '7z' => '<i class="fas fa-file-archive"></i>',
      'jpg' => '<i class="fas fa-file-image"></i>',
      'png' => '<i class="fas fa-file-image"></i>',
      'bmp' => '<i class="fas fa-file-image"></i>',
      'mp3' => '<i class="fas fa-file-audio"></i>',
      'wav' => '<i class="fas fa-file-audio"></i>',
      'mp4' => '<i class="fas fa-file-video"></i>',
      'mkv' => '<i class="fas fa-file-video"></i>',
      'mov' => '<i class="fas fa-file-video"></i>',
      'doc' => '<i class="fas fa-file-word"></i>',
      'docx' => '<i class="fas fa-file-word"></i>',
      'pdf' => '<i class="fas fa-file-pdf"></i>',
      'html' => '<i class="fas fa-file-code"></i>',
      'php' => '<i class="fas fa-file-code"></i>',
      'css' => '<i class="fas fa-file-code"></i>',
   ];
   $file_type = [
      'zip' => 'Compressed File',
      'rar' => 'Compressed File',
      'gz' => 'Compressed File',
      '7z' => 'Compressed File',
      'jpg' => 'Compressed File',
      'png' => 'Image',
      'bmp' => 'Image',
      'mp3' => 'Audio',
      'wav' => 'Audio',
      'mp4' => 'Video',
      'mkv' => 'Video',
      'mov' => 'Video',
      'doc' => 'Microsoft Word 2003',
      'docx' => 'Microsoft Word 2010',
      'pdf' => 'PDF Document',
      'html' => 'HTML Document',
      'php' => 'PHP Code',
      'css' => 'Stylesheet',
   ];
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Bootstrap Example</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link 
         rel="stylesheet"
         href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
         integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <style>
         .fa, .fas {
         color: #858585;
         }
         .fa-folder {
         color: rgb(74, 158, 255);
         }
         i.fa, table i.fas {
         font-size: 16px;
         margin-right: 6px;
         }
         i.action {
         cursor: pointer;
         }
         a {
         color: black;
         }
      </style>
      <script>
         function updateDeleteFileDialog(filename){
            let label = $('#file-to-delete');
            let param = $('#file-to-delete-input');

            label.html(filename);
            param.val(filename);
         }
      </script>
   </head>
   <body>
      <div class="container">
         <div class="row align-items-center py-5">
            <div class="col-6">
               <h3>
               File Manager</h2>
            </div>
            <div class="col-6">
               <h5 class="text-right">Xin chào <?= $_SESSION["username"]?>, <a class="text-primary" href="logout.php">Logout</a></h5>
            </div>
         </div>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <?php 
               $items = explode('/', $dir);
               $url = '?dir=';
               for ($i=0; $i<count($items); $i++){
                  $item = $items[$i];

                  if ($i==0){
                     $url = $url . $item;
                  } else {
                     $url = $url . "/" . $item;
                  }
                  
                  $active = ($i == count($items) - 1) ? ' active' : '';

                  ?> 
                     <li class="breadcrumb-item <?= $active ?>"><a href="<?= $url ?>"><?= $item?></a></li>
                  <?php
               }
            ?>
            
         </ol>
         <div class="input-group mb-3">
            <div class="input-group-prepend">
               <span class="input-group-text">
               <span class="fa fa-search"></span>         
               </span>
            </div>
            <input type="text" class="form-control" placeholder="Search">
         </div>
         <div class="btn-group my-3">
            <button type="button" class="btn btn-light border" data-toggle="modal" data-target="#new-folder-dialog">
               <i class="fas fa-folder-plus"></i> Tạo thư mục
            </button>   
            <button type="button" class="btn btn-light border">
               <i class="fas fa-file"></i> Create text file
            </button>  
         </div>
         <table class="table table-hover border">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Size</th>
                  <th>Last modified</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
            <?php 
               foreach($listFiles as $f){
                  $filePath = "$path/$f";
                  
                  // kích thước file
                  $size =  (int) (filesize($filePath)/(1000));
                  if ($size!=0) {
                     $size .= ' kb';
                  }

                  // thời gian
                  $time = date("d-m-Y",filemtime($filePath));

                  if (is_dir($filePath)){
                     $icon = '<i class="fas fa-folder"></i>';
                     $type = 'Folder';
                     $url = "?dir=" . str_replace($root.'/', '', $filePath);
                  } else {

                     $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                     $url = $filePath;

                     if (array_key_exists($ext, $ext_icons)){
                        $icon = $ext_icons[$ext];
                     } else {
                        $icon = '<i class="fas fa-file"></i>';
                     }

                     if (array_key_exists($ext, $file_type)){
                        $type = $file_type[$ext];
                     } else {
                        $type = 'File';
                     }
                  }
                  ?> 
                     <tr>
                        <td>
                           <?= $icon?>
                           <a href="<?= $url?>"><?= $f?></a>
                        </td>
                        <td><?= $type?></td>
                        <td><?= $size?></td>
                        <td><?= $time?></td>
                        <td>
                           <i class="fa fa-download action"></i>
                           <i class="fa fa-edit action"></i>
                           <i onclick="updateDeleteFileDialog('<?= $f?>')" class="fa fa-trash action" data-toggle="modal" data-target="#confirm-delete"></i>
                        </td>
                     </tr>
                  <?php
               }
            ?>
               
            </tbody>
         </table>
         <div class="border rounded mb-3 mt-5 p-3">
            <h4>File upload</h4>
            <form>
               <div class="form-group">
                  <div class="custom-file">
                     <input type="file" class="custom-file-input" id="customFile">
                     <label class="custom-file-label" for="customFile">Choose file</label>            
                  </div>
               </div>
               <p>Người dùng chỉ được upload tập tin có kích thước tối đa là 20 MB.</p>
               <p>Các tập tin thực thi (*.exe, *.msi, *.sh) không được phép upload.</p>
               <p><strong>Yêu cầu nâng cao</strong>: hiển thị progress bar trong quá trình upload.</p>
               <button class="btn btn-success px-5">Upload</button>
            </form>
         </div>

         <div class="modal-example my-5">
            <h4>Một số dialog mẫu</h4>
            <p>Nhấn vào để xem kết quả</p>
             <ul>
                 <li><a href="#" data-toggle="modal" data-target="#confirm-delete">Confirm delete</a></li>
                 <li><a href="#" data-toggle="modal" data-target="#confirm-rename">Confirm rename</a></li>
                 <li><a href="#" data-toggle="modal" data-target="#new-file-dialog">New file dialog</a></li>
                 <li><a href="#" data-toggle="modal" data-target="#new-folder-dialog">New folder dialog</a></li>
                 <li><a href="#" data-toggle="modal" data-target="#message-dialog">Message Dialog</a></li>
             </ul>
         </div>

      </div>


      <!-- Delete dialog -->
      <div class="modal fade" id="confirm-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post">
            <div class="modal-header">
              <h4 class="modal-title">Xóa tập tin</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
              Bạn có chắc rằng muốn xóa tập tin <strong id="file-to-delete">image.jpg</strong>
            </div>
        
            <div class="modal-footer">
               <input type="hidden" name="action" value="delete-file">
               <input type="hidden" name="path" value="<?= $dir?>">
               <input type="hidden" name="file-name" value="image.jpg" id="file-to-delete-input">
               <button type="submit" class="btn btn-danger">Xóa</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
            </div> 
            </form>           
            </div>
        </div>
        </div>


    <!-- Rename dialog -->
    <div class="modal fade" id="confirm-rename">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
            <h4 class="modal-title">Đổi tên</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <p>Nhập tên mới cho tập tin <strong>Document.txt</strong></p>
                <input type="text" placeholder="Nhập tên mới" value="Document.txt" class="form-control"/>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Lưu</button>
            </div>            
            </div>
        </div>
        </div>

        <!-- New file dialog -->
        <div class="modal fade" id="new-file-dialog">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
            <h4 class="modal-title">Tạo tập tin mới</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="name">File Name</label>
                    <input type="text" placeholder="File name" class="form-control" id="name"/>
                </div>
                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea rows="10" id="content" class="form-control" placeholder="Nội dung"></textarea>

                </div>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Lưu</button>
            </div>            
            </div>
        </div>
        </div>

        <!-- New folder dialog -->
        <div class="modal fade" id="new-folder-dialog">
        <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Tạo thư mục mới</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Tên thư mục</label>
                        <input name="folder-name" type="text" class="form-control" id="folder-name"/>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <input type="hidden" name="action" value="create-folder">
                    <input type="hidden" name="path" value="<?= $dir?>">
                    <button type="submit" class="btn btn-success">Lưu</button>
                </div>
            </form>     
            </div>
        </div>
        </div>

        <!-- message dialog -->
        <div class="modal fade" id="message-dialog">
            <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                <h4 class="modal-title">Xóa file</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
    
                <div class="modal-body">
                    <p>Bạn không được cấp quyền để xóa tập tin/thư mục này</p>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                </div>            
                </div>
            </div>
            </div>
   </body>
</html>