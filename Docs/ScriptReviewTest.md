# Tổng hợp nội dung tóm tắt các chương

## 1. Chapter 4 & 5

- Tạo module tạo database
- Tạo page
    - http://magenest.b2c.com/movie/index/movielist

## 2. Chapter 6

- Tạo backend configuration ( MAGENEST )
    - etc/system.xml
        - Sử dụng frontend_model để xử lý các logic show input ( Block\Adminhtml\System\Config\MovieCount )
        - Reload page cũng làm tương tự và có dùng `script` bên trong
        - Dữ liệu mặc định ( etc\config.xml )
- Tạo data grid bằng block
    - Block ( Magenest/Movie/Block/Adminhtml/Actor/Grid.php)
    - Block2 ( Magenest/Movie/Block/Adminhtml/Actor.php)
    - Controller
    - Layout (truyền 2 block vào layout)
    - Menu ( không đặt parent sẽ hiển thị bên ngoài)
    - acl

## 3. Chapter 7 ( Event )

- Tạo event
    - Tạo observer ( Magenest/Movie/Observer/ChangeCustomerName.php )
    - Đăng ký vào etc/events.xml
    - Lưu first name ( )
- Tạo plugin
    - Tạo Plugin\<file>
    - Đăng ký trong di.xml và có type bọc ( xác định block để can thiệp)
        - Có 3 loại chính before , after , around
        - Đặt ten theo kiểu và viết hoa chữ đầu của thuộc tính vd: beforeGetEmail()

## 4. Eav

- Tạo attribute avatar trong customer
    - Chạy các Setup hoặc data Patch ( Tạo attribute avatar )
    - Ảnh sẽ được lưu vào pub/media/customer ( Và cần set quyền trong ngĩnx hoặc include trong nginx )
        - Cấu hình qua ui ( Magenest/Movie/view/adminhtml/ui_component/customer_form.xml )

- Tạo My Dashboard
    - Show avatar trong dashboard
    - Tạo Block ( Magenest/Movie/Block/Account/Dashboard/DetailInfo.php )
    - Tạo layout ( Magenest/Movie/view/frontend/layout/movie_customer_index.xml )
    - Tạo template
    - Lưu ý tạo một layout mới và coppy nội dung từ layout default

## 5. Frontend

- Tạo buttons trong block
- Tạo require js ( Magenest/KnockoutJs/view/frontend/web/js/button-actions.js )
- Tạo layout
- Tạo template và cấu hình databidding và script
- Dùng KO để truyền nhận dữ liệu

## 6. Backend

- Tạo sao cho rating
    - Tạo requirejs để add thư viện ui star
    - Tạo js xử lý chuyển đổi và hiển thị sao
    - Dùng các thuộc tính trong ui để add
        -       <item name="component" xsi:type="string">Magenest_Movie/js/grid/columns/star-rating</item>
                        <item name="bodyTmpl" xsi:type="string">Magenest_Movie/ui/grid/cells/star-rating</item>
  