<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>PHP Exercises 3</title>

    
</head>
<body>
    <div class="container">

        <div class="row">
            <div class="col-md-6 my-5 mx-auto border rounded px-3 py-3">
                <h6 class="text-center mb-3">Gợi ý tên quốc gia</h6>
                <input oninput="suggest(this.value)" type="text" class="form-control" placeholder="Nhập ít nhất 2 ký tự">
                <ul id="suggestions" class="list-group my-2">
                    <!-- <li class="list-group-item">Singapore</li> -->
                </ul>
            </div>
        </div>
    </div>
    <script>
        function suggest(value){
            value = value.trim(); // xóa khoảng trắng đầu và cuối chuỗi
            if (value.length < 2){
                return;
            }

            $.post('countries.php', {keyword: value}, (data, status) => {
                if (status==='success'){
                    if (data.success === true){
                        let list = $('#suggestions');
                        list.empty();  // clear all
                        /*
                            Virtual DOM (document object model)
                            là một định dạng dữ liệu JavaScript nhẹ 
                            được dùng để thể hiện nội dung của DOM 
                            tại một thời điểm nhất định nào đó. 
                            Nó có tất cả các thuộc tính giống như DOM 
                            nhưng không có khả năng tương tác lên màn hình như DOM.
                        */
                        let virtualDom = document.createDocumentFragment();
                        data.country.forEach(c=>{
                            $(`<li class="list-group-item">${c}</li>`).appendTo(virtualDom);
                        });
                        list.append(virtualDom);
                    }
                };
            });
        }
    </script>
</body>
</html>