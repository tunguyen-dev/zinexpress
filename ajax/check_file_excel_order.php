<?php 

include '../config.php';
include '../Classes/PHPExcel.php';
//place this before any script you want to calculate time

foreach($_POST as $key => $value) {
    $$key = Library_Validation::antiSql($value);
}

if(!is_object($adminuser)) {
    echo json_encode(array('code' => 1,'status' => false, 'msg' => 'Bạn chưa đăng nhập!'));
    exit();
}
if ($_FILES['file']['tmp_name']) {
    $file = $_FILES['file']['tmp_name'];
    $extendFile = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);
    if (!in_array($extendFile, array('xls', 'xlsx'))) {
        echo json_encode(array('code' => 1,'status' => false, 'msg' => 'Chỉ được upload các định dạng xls, xlsx!'));
        exit();
    }
    //Tiến hành xác thực file
    $objFile = PHPExcel_IOFactory::identify($file);
    $objData = PHPExcel_IOFactory::createReader($objFile);

    //Chỉ đọc dữ liệu
    $objData->setReadDataOnly(true);

    // Load dữ liệu sang dạng đối tượng
    $objPHPExcel = $objData->load($file);

    //Lấy ra số trang sử dụng phương thức getSheetCount();
    // Lấy Ra tên trang sử dụng getSheetNames();

    //Chọn trang cần truy xuất
    $sheet = $objPHPExcel->setActiveSheetIndex(0);

    //Lấy ra số dòng cuối cùng
    $Totalrow = $sheet->getHighestRow();
    //Lấy ra tên cột cuối cùng
    $LastColumn = $sheet->getHighestColumn();
    //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
    $TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);
    //Tạo mảng chứa dữ liệu
    $data = [];
    
    //Tiến hành lặp qua từng ô dữ liệu
    //----Lặp dòng, Vì 4 dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 5
    for ($i = 6; $i <= $Totalrow; $i++) {
        //----Lặp cột
        for ($j = 0; $j < $TotalCol; $j++) {
            // Tiến hành lấy giá trị của từng ô đổ vào mảng
            $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
        }
    }
    var_dump($data);
    exit;
    // $obj_file = $model_fileds->getObjectByCondition("",array("files" => $_FILES["file"]["name"]));
    // if (is_object($obj_file)) {
    //     echo json_encode(array('code' => 1, 'msg' => 'File excel này đã được uploads trước đó!'));
    //     exit();
    // }
    
    if ($sheet->getCellByColumnAndRow(0, 4)->getValue()!= 'STT'
    || $sheet->getCellByColumnAndRow(1, 4)->getValue()!= 'Mã đơn shop'
    || $sheet->getCellByColumnAndRow(2, 4)->getValue()!= 'Tên người nhận (*)'
    || $sheet->getCellByColumnAndRow(3, 4)->getValue()!= 'Số ĐT người nhận (*)'
    || $sheet->getCellByColumnAndRow(4, 4)->getValue()!= 'Địa chỉ nhận (*)'
    || $sheet->getCellByColumnAndRow(5, 4)->getValue()!= 'Tên hàng hóa (*)'
    || $sheet->getCellByColumnAndRow(6, 4)->getValue()!= 'Trọng lượng (gram)  (*)'
    || $sheet->getCellByColumnAndRow(7, 4)->getValue()!= 'Giá trị hàng (VND) (*)'
    || $sheet->getCellByColumnAndRow(8, 4)->getValue()!= 'Tiền thu hộ COD (VND)'
    || $sheet->getCellByColumnAndRow(9, 4)->getValue()!= 'Dài (cm)'
    || $sheet->getCellByColumnAndRow(10, 4)->getValue()!= 'Rộng (cm)'
    || $sheet->getCellByColumnAndRow(11, 4)->getValue()!= 'Cao (cm)'
    || $sheet->getCellByColumnAndRow(12, 4)->getValue()!= 'Người trả cước'
    || $sheet->getCellByColumnAndRow(13, 4)->getValue()!= 'Ghi chú'
    || $sheet->getCellByColumnAndRow(14, 4)->getValue()!= 'Yêu cầu khác'){
        echo json_encode(array('code' => 1,'status' => false,'msg' => 'FILE EXCEL tải lên không đúng định dạng file mẫu!'));
        exit();
    }
    foreach ($data as $excel) {


    }
}else{
    echo json_encode(array('code' => 1,'status' => false,'msg' => 'Hãy chọn file tải lên!'));
}    

?>
 