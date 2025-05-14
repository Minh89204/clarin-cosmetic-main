document.addEventListener("DOMContentLoaded", function () {
    console.log("Admin dashboard loaded.");

    // Thêm xác nhận khi xóa sản phẩm (gắn class 'btn-delete' cho nút xóa trong bảng)
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            const confirmDelete = confirm("Bạn có chắc chắn muốn xóa sản phẩm này?");
            if (!confirmDelete) {
                e.preventDefault();
            }
        });
    });

    // Tùy chọn: toggle sidebar nếu cần
    const toggleBtn = document.getElementById("sidebar-toggle");
    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            document.querySelector(".sidebar").classList.toggle("collapsed");
        });
    }
});
