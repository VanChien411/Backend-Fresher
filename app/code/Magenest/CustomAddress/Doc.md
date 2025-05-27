### **Tóm tắt**

Để tạo trường "vn_region" từ đầu trong Magento 2:

1. Tạo source model (`VNRegion.php`) để cung cấp tùy chọn cho dropdown.
2. Tạo patch script (`AddVNRegionAttribute.php`) để thêm thuộc tính vào `customer_address`.
3. Định nghĩa extension attribute trong `extension_attributes.xml`.
4. Tạo plugin (`LayoutProcessor.php`) để hiển thị trường trong checkout.
5. Tạo mixin (`set-shipping-information-mixin.js`) để xử lý dữ liệu gửi đi.

Thoi chuyển qua dùng plugin lưu trực tiếp cho nhàn
