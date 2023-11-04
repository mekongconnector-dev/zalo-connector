var linkElement = document.createElement('link');
    linkElement.rel = 'stylesheet';
    linkElement.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css';
    document.head.appendChild(linkElement);
    const arrTag = document.querySelectorAll('.woocommerce-MyAccount-navigation li');
    var links = document.querySelectorAll(".woocommerce-MyAccount-navigation li a");
    links.forEach(function(link) {
        link.style.textDecoration = "none";
    });
    arrTag.forEach(function (liTag, index) {
        const iconElement = document.createElement('i');
        if(liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard-cus' || liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard' || liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard-cus is-active' || liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard is-active'){
            iconElement.className = 'bi bi-house';
            iconElement.style.marginRight = '10px'
            iconElement.style.color = 'white'
            iconElement.style.fontWeight = 'bold'
             liTag.prepend(iconElement);
        }
        if(liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--history-eye' || liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--history-eye is-active'){
            iconElement.className = 'bi bi-calendar';
            iconElement.style.marginRight = '10px'
            iconElement.style.color = 'white'
            iconElement.style.fontWeight = 'bold'
             liTag.prepend(iconElement);
        }
        if(liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders' || liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders is-active'){
            iconElement.className = 'bi bi-box';
            iconElement.style.marginRight = '10px'
            iconElement.style.color = 'white'
            iconElement.style.fontWeight = 'bold'
             liTag.prepend(iconElement);
        }
        if(liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address' || liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address is-active'){
            iconElement.className = 'bi bi-geo-alt-fill';
            iconElement.style.marginRight = '10px'
            iconElement.style.color = 'white'
            iconElement.style.fontWeight = 'bold'
             liTag.prepend(iconElement);
        }
        if(liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout' || liTag.className ==='woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout is-active'){
            iconElement.className = 'bi bi-box-arrow-right';
            iconElement.style.marginRight = '10px'
            iconElement.style.color = 'white'
            iconElement.style.fontWeight = 'bold'
             liTag.prepend(iconElement);
        }
       
        var link = document.querySelector("a");
        link.style.textDecoration = "none";
        link.style.color = 'white'
        if(!liTag.classList.contains('is-active')){
            iconElement.style.color = '#0A58CA'
            liTag.style.color = 'transparent !important';
            liTag.style.backgroundColor = '#e5e5e5';
            liTag.style.marginTop = '10px';
            liTag.style.borderRadius = '10px';
            liTag.style.padding = '5px';
            liTag.style.display = 'flex'
            liTag.style.alignItems = 'center'
            liTag.style.fontWeight = '500';
        }
    });

// Tệp custom-script.js
document.addEventListener("DOMContentLoaded", function () {
    // var dashboardLinks = document.querySelectorAll('.woocommerce-MyAccount-navigation-link--dashboard');
    // dashboardLinks.forEach(function(link) {
    //     link.style.display = 'none';
    // });
    
});

document.addEventListener("DOMContentLoaded", function () {
    // Lấy danh sách menu
    var menu = document.querySelector('.woocommerce-MyAccount-navigation ul');
    
    // Lấy các mục menu cần di chuyển lên đầu
    var dashboardCusItem = document.querySelector('.woocommerce-MyAccount-navigation-link--dashboard-cus');
    var historyEyeItem = document.querySelector('.woocommerce-MyAccount-navigation-link--history-eye');
    
    // Di chuyển các mục menu lên đầu
    if (dashboardCusItem && historyEyeItem) {
        menu.removeChild(dashboardCusItem);
        menu.removeChild(historyEyeItem);
        menu.insertBefore(historyEyeItem, menu.firstElementChild);
        menu.insertBefore(dashboardCusItem, menu.firstElementChild);
        
        dashboardCusItem.style.display = "block";
        historyEyeItem.style.display = "block";
    }
    // Tìm tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--downloads"
    var downloadLinks = document.getElementsByClassName('woocommerce-MyAccount-navigation-link--downloads');
    // Ẩn tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--downloads"
    for (var i = 0; i < downloadLinks.length; i++) {
        downloadLinks[i].style.display = 'none';
    }
    
    // Tìm tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--edit-account"
    var editAccountLinks = document.getElementsByClassName('woocommerce-MyAccount-navigation-link--edit-account');
    // Ẩn tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--edit-account"
    for (var i = 0; i < editAccountLinks.length; i++) {
        editAccountLinks[i].style.display = 'none';
    }
    
    // Tìm tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--edit-account"
    var dbLinks = document.getElementsByClassName('woocommerce-MyAccount-navigation-link--dashboard');
    // Ẩn tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--edit-account"
    for (var i = 0; i < dbLinks.length; i++) {
        dbLinks[i].style.display = 'none';
    }
    
    // Tìm tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--wishlist"
    var wishLinks = document.getElementsByClassName('woocommerce-MyAccount-navigation-link--wishlist');
    // Ẩn tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--edit-account"
    for (var i = 0; i < wishLinks.length; i++) {
        wishLinks[i].style.display = 'none';
    }
    
    // Tìm tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--compare"
    var compareLinks = document.getElementsByClassName('woocommerce-MyAccount-navigation-link--compare');
    // Ẩn tất cả các phần tử có class "woocommerce-MyAccount-navigation-link--edit-account"
    for (var i = 0; i < compareLinks.length; i++) {
        compareLinks[i].style.display = 'none';
    }
    
});

//
document.addEventListener("DOMContentLoaded", function () {
    // Lấy đoạn pathname từ URL
    var pathname = window.location.pathname;
    
    // Sử dụng biểu thức chính quy để tìm số cuối cùng trong đoạn pathname
    var matches = pathname.match(/\/(\d+)\/$/);
    
    if (matches) {
        var orderId = matches[1];
        var apiUrl = "/wp-json/zalo-management/v1/get-thumbnail-order?orderId=" + orderId;
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                // console.log("Dữ liệu từ API: ", data);
                if (data.order_status === "pending" && data.imgLink) {
                    // Tạo một phần tử hình ảnh
                    var image = document.createElement("img");
                    image.src = data.imgLink;
                    image.style.width = "100%"; // Đặt chiều rộng là 100%
                    image.style.marginBottom = "20px"; 
                    image.style.height = "auto"; // Tự động tính toán chiều cao
                    var div = document.querySelector(".my-account-content");
                    var firstChild = div.firstChild;
                    div.insertBefore(image, firstChild);
                    
                    //thêm 2 nút đặt và hủy hàng
                    // Lấy tham chiếu đến div có class woocommerce-order-details
                    var orderDetailsDiv = document.querySelector(".woocommerce-order-details");
                    var placeOrderButton = document.createElement("button");
                    placeOrderButton.style.backgroundColor = "#4CAF50"; 
                    placeOrderButton.style.color = "white"; 
                    placeOrderButton.style.padding = "10px 20px"; 
                    placeOrderButton.style.border = "none"; 
                    placeOrderButton.style.cursor = "pointer";
                    placeOrderButton.style.marginRight = "10px"; 
                    placeOrderButton.style.marginTop = "10px"; 
                    placeOrderButton.style.marginBottom = "10px"; 
                    placeOrderButton.style.width = "48%";
                    placeOrderButton.textContent = "Đặt hàng ngay";
                    placeOrderButton.addEventListener("click", function() {
                      window.location.href = data.payment_link;
                    });
                    var cancelOrderButton = document.createElement("button");
                    cancelOrderButton.textContent = "Hủy đơn hàng";
                    cancelOrderButton.style.backgroundColor = "#f44336";
                    cancelOrderButton.style.color = "white"; 
                    cancelOrderButton.style.padding = "10px 20px"; 
                    cancelOrderButton.style.marginTop = "10px"; 
                    cancelOrderButton.style.marginBottom = "10px"; 
                    cancelOrderButton.style.width = "48%";
                    cancelOrderButton.style.border = "none"; 
                    cancelOrderButton.style.cursor = "pointer";
                    cancelOrderButton.addEventListener("click", function() {
                      window.location.href = data.cancel_link;
                    });
                    // Thêm nút "Đặt hàng ngay" và "Hủy đơn hàng" vào sau div có class woocommerce-order-details
                    div.insertBefore(cancelOrderButton, orderDetailsDiv.nextSibling);
                    div.insertBefore(placeOrderButton, orderDetailsDiv.nextSibling);
                }
            })
            .catch(error => {
              console.error("Lỗi khi gọi API: ", error);
            });
    } else {
      
    }



});
    
