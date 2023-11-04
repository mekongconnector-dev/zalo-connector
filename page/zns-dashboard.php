<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <style>
        .dashboard{
            background-color: #eeeff5;
            /* height: 100vh; */
            font-size: 16px;
            padding: 20px 40px;
            @media (max-width: 576px) {
                padding: 0px 10px;
                height: 100%;
                font-size: 16px !important;
            }
        }
        .content{
            @media (min-width: 851px) and (max-width: 1200px){
                flex-direction: column !important;
                gap: 10px
            }
        }
        .content-left{
            padding: 0px 40px;
            @media (max-width: 850px) {
                padding: 0px;
            }
            @media (min-width: 850px) and (max-width: 1200px) {
                padding: 0px;
                width: 100%;
            }
        }
        .content-right{
            @media (max-width: 1200px) {
                width: 100%;
            }
            @media (max-width: 576px) {
                background-color: #EEEFF5 !important;
                padding: 20px !important;
                margin-top: 0px !important;
            }
            @media (min-width: 1200px) {
                margin-top: 0px !important;
            }
        }
        .title-page{
            font-size: 20px;
            font-weight: 500;
        }
        .more-info{
            background-color: white;
            border-radius: 100%;
            padding: 0px 10px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        .top-dashboard-left{
            @media (max-width: 576px) {
                margin: 10px;
                padding: 0px !important;
            }
            @media (min-width: 577px) and (max-width: 1200px) {
                margin: -10px;
                padding: 0px !important;
            }
        }
        .top-dashboard-right{
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            display: flex;
            align-items: center;
            @media (max-width: 576px) {
                margin-right: 10px;
                justify-content: end;
            }
        }
        .statistical{
            gap: 30px;
            justify-content: space-between;
            flex-wrap: nowrap;
            padding: 30px 40px;
            @media (max-width: 576px) {
                flex-wrap: wrap;
                padding: 20px 20px;
                margin: 0px 20px;
                gap: 30px;
            }
            @media (min-width: 577px) and (max-width: 1300px) {
                gap: 10px !important;
            }
        }
        .statistical-item{
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 31%;
            padding: 50px 40px;
            border-radius: 10px;
            min-height: 250px;
            @media (max-width: 576px) {
                width: 100%;
            }
            @media (max-width: 1300px){
                padding: 50px 40px;
            }

        }
        .ZNS{
            @media (max-width: 576px) {
                background-color: white;
                border-radius: 7px;
                
            }
            @media (max-width: 1300px) {
                padding: 10px !important;
            }
            
        }
        .top-ZNS{
            @media (max-width: 576px) {
                flex-direction: column !important;
                padding: 20px 40px !important;
            }

        }
        .top-ZNS-right{
            @media (max-width: 1300px) {
                /*padding: 0px !important;*/
                flex-wrap: wrap !important;
            }
        }
        .statistical-item-box{
            color: white;
            font-weight: 500;
            font-size: 14px;
        }
        .statistical-item-icon{
            background-color: rgba(24, 74, 155, 0.8);
            padding: 9px;
        }
        .chart{
            margin-top: 40px;
            @media (max-width: 576px) {
                margin: 20px;
            }
        }
        .chart-top{
            flex-wrap: wrap;
            padding: 30px 40px;
            @media (max-width: 576px) {
                flex-direction: column !important;
            }
        }
        .chart-top-left{
            /* background-color: white; */
            padding: 5px 10px;
            border-radius: 10px;
            @media (max-width: 576px) {
                padding-left: 0px !important;
            }
            @media (max-width: 1100px) {
                padding: 5px 0px !important;
            }
            /* box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.08); */
        }
        .chart-content{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .chart-item{
            width: 80%;
            height: 50%;
        }
        .ZNS-item{
            width: 100%;
        }
        .list-ZNS-stt{
            font-size: 16px;   
            display: flex;
            align-items: center;
        }
        .list-ZNS-stt-item{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 25px;
            height: 25px;
        }
        .ZNS{
            @media(max-width: 576px) {
                padding: 0px !important;
            }
        }
        .custom-tooltip {
        --bs-tooltip-bg: var(--bs-primary);
        --bs-tooltip-color: var(--bs-white);
        }
        :focus {
            outline: none;
          }
        .qs{
            @media (max-width: 576px) {
                display: none;
            }
        }
        .top-dashboard{
            @media (max-width: 576px){
                flex-direction: column !important;
            }
            @media (min-width: 1200px) and (max-width: 1400px){
                flex-direction: column !important;
            }
            
        }
        .number{
            font-weight: 500;
        }
        .number span, label{
            font-size: 18px
        }
        .titleCard{
            font-weight: 800;
            display: flex;
            justify-content: start;
            width: 100%;
        }
        .zns-detail{
            padding: 80px 20px;
            @media (max-width: 576px) {
                padding: 20px 0px !important;
            }
        }
        .zns-detail p {
            font-size: 20px !important;
            @media (max-width: 576px) {
                font-size: 16px !important;
            }
        }
        .statistical-table{
            font-weight: 600;
        }
        .title-tab{
            @media (max-width: 576px) {
                font-size: 20px !important;
            }
        }
        .btn-view{
            height: 100% !important;
            display: flex;
            align-items: center;
        }
        .btn-view button{
            font-size: 14px !important;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="top-dashboard d-flex flex-row justify-content-between">
            <div class="top-dashboard-left d-flex flex-row gap-2 align-middle px-4">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio1">Zalo</label>
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio2" key="advertisement">Quảng cáo</label>
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio3" key="article">Bài viết</label>
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="btnradio4" key="zns">ZNS</label>
                </div>
                <div class="more-info d-flex fw-medium rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Dashboard Quản lý bài viết">
                    <i class="fa-solid fa-question"></i>
                </div>
            </div>
        </div>
        
    </div>
    <div id="zalo-connector-up-to-pro-version">
    </div>
</body>
<script>
    // Lắng nghe sự kiện click trên các nút radio
    document.getElementById("btnradio1").addEventListener("click", function() {
        // Chuyển hướng đến liên kết tương ứng
        window.location.href = "<?php echo admin_url();?>admin.php?page=main-menu";
    });

    document.getElementById("btnradio2").addEventListener("click", function() {
        // Chuyển hướng đến liên kết tương ứng
        window.location.href = "<?php echo admin_url();?>admin.php?page=marketing-dashboard";
    });

    document.getElementById("btnradio3").addEventListener("click", function() {
        // Chuyển hướng đến liên kết tương ứng
        window.location.href = "<?php echo admin_url();?>admin.php?page=article-dashboard";
    });
    document.getElementById("btnradio4").addEventListener("click", function() {
        // Chuyển hướng đến liên kết tương ứng
        window.location.href = "<?php echo admin_url();?>admin.php?page=zns-dashboard";
    });
</script>
<script>
    document.getElementById("selectOption").addEventListener("change", function() {
        // Lấy giá trị đã chọn
        var selectedValue = this.value;
        
        // Chuyển hướng đến URL tương ứng
        window.location.href = selectedValue;
    });
</script>
<script>
    var options = {
        series: [{
            name: 'số tin',
            data: []
            },{
                name: 'gửi lỗi',
                data: []
            }],
            chart: {
                type: 'bar',
                id: 'chartZNS',
                height: 430
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    dataLabels: {
                    position: 'top',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                offsetX: 0,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            tooltip: {
                shared: true,
                intersect: false
            },
            xaxis: {
                categories: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4']
            },
            yaxis: {
                axisBorder: {
                  show: false
                },
                axisTicks: {
                  show: false,
                },
                labels: {
                  show: false,
                  formatter: function (val) {
                    return val + " tin";
                  }
                }
              
            },
        };
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
<script>
    function calculatorPrice (amount ,type){
        let price
        if (type == 'mess'){
            if (amount <= 1000) {
                price = amount * 200
            }
            if (amount> 1000 && amount <= 2000){
                price = 1000 * 200 + (amount-1000)*190
            }
            if (amount > 2000){
                price = 1000 * 200 + (1000)*190 + (amount-2000)*170
            }
        } else {
            if (amount <= 1000) {
                price = amount * 500
            }
            if (amount> 1000 && amount <= 2000){
                price = 1000 * 500 + (amount-1000)*450
            }
            if (amount> 2000 && amount <= 5000){
                price = 1000 * 500 + 1000*450 + (amount-2000)*380
            }
            if (amount > 5000){
                price = 1000 * 500 + 1000*450 + 3000*380 + (amount-5000)*300
            }
        }
        return price
    }
    calculatorPrice(2520, 'aaaa')
    var url = '<?php echo rest_url('zns/get_data_zns') ?>'
    fetch(url).then(response => response.json()).then(data => {
        ApexCharts.exec('chartZNS', 'updateOptions', {
            series: [{
                name: 'Tin ZNS',
                data: data.arr_total_zns_week
                },{
                    name: 'Gửi lỗi',
                    data: data.arr_total_err_zns_week
                }],
            xaxis: {
                categories: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật']
            },

        }, true); 
        let selectTable = document.getElementById('selectTable')
        
        let totalZNS = document.getElementById('totalZNS')
        let errZNS = document.getElementById('errZNS')
        let priceZNS = document.getElementById('priceZNS')
    
        let totalGD = document.getElementById('totalGD')
        let errGD = document.getElementById('errGD')
        let priceGD = document.getElementById('priceGD')
        
        let totalChatbot = document.getElementById('totalChatbot')
        let errChatbot = document.getElementById('errChatbot')
        let priceChatbot = document.getElementById('priceChatbot')
        
        
        totalZNS.innerHTML = data['totalZNS'];
        errZNS.innerHTML = data['totalErr_ZNS'];
        let SuccessMessZNS = data['totalZNS'] - data['totalErr_ZNS'];
        let totalPriceZns = calculatorPrice(SuccessMessZNS, 'mess')
        priceZNS.innerHTML = totalPriceZns.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) ;

        totalGD.innerHTML = data['totalGD'];
        errGD.innerHTML = data['totalErr_GD'];
        let SuccessMessGD = data['totalGD'] - data['totalErr_GD'];
        let totalPriceGD = calculatorPrice(SuccessMessGD, 'mess')
        priceGD.innerHTML = totalPriceGD.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        
        totalChatbot.innerHTML = data['totalChatbot'];
        errChatbot.innerHTML = data['totalErrChatbot'];
        let SuccessMessChatbot = data['totalChatbot'] - data['totalErrChatbot'];
        let totalPriceChatbot = calculatorPrice(SuccessMessChatbot, 'chatbot')
        priceChatbot.innerHTML = totalPriceChatbot.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        
        selectTable.onchange = function() {
            const selectedValue = selectTable.value;
            switch (selectedValue) {
                case "day":
                    totalZNS.innerHTML = data['totalZNS_day'];
                    errZNS.innerHTML = data['totalErr_ZNS_day'];
                    priceZNS.innerHTML = (data['totalZNS_day']*250).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    
                    totalGD.innerHTML = data['totalGD_day'];
                    errGD.innerHTML = data['totalZNS_day'];
                    priceGD.innerHTML = (data['totalGD_day']*250).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    
                    totalChatbot.innerHTML = data['totalChatbot_day'];
                    errChatbot.innerHTML = data['totalErr_Chatbot_day'];
                    priceChatbot.innerHTML = (data['totalChatbot_day']*10).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    break;
                case "week":
                    totalZNS.innerHTML = data['totalZNS_week'];
                    errZNS.innerHTML = data['totalErr_ZNS_week'];
                    priceZNS.innerHTML = (data['totalZNS_week']*250).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) ;
    
                    totalGD.innerHTML = data['totalGD_week'];
                    errGD.innerHTML = data['totalErr_GD_week'];
                    priceGD.innerHTML = (data['totalGD_week']*250).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    
                    totalChatbot.innerHTML = data['totalChatbot_week'];
                    errChatbot.innerHTML = data['totalErr_Chatbot_week'];
                    priceChatbot.innerHTML = (data['totalChatbot_week']*10).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    break;
                case "month":
                    totalZNS.innerHTML = data['totalZNS_month'];
                    errZNS.innerHTML = data['totalErr_ZNS_month'];
                    priceZNS.innerHTML = (data['totalZNS_week']*250).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) ;
    
                    totalGD.innerHTML = data['totalGD_month'];
                    errGD.innerHTML = data['totalErr_GD_month'];
                    priceGD.innerHTML = (data['totalGD_month']*250).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    
                    totalChatbot.innerHTML = data['totalChatbot_month'];
                    errChatbot.innerHTML = data['totalErr_Chatbot_month'];
                    priceChatbot.innerHTML = (data['totalChatbot_month']*10).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    break;

            }
        };
        
        
    })
    function handleViewChart() {
        var url = '<?php echo rest_url('zns/get_data_zns') ?>'
        let a = document.getElementById('data_chart');

        let b = document.getElementById('type_chart');

        fetch(url).then(response => response.json()).then(data => {
            if(a.value === 'week' && b.value === 'ZNS'){    
                ApexCharts.exec('chartZNS', 'updateOptions', {
                    series: [{
                        name: 'Tin ZNS',
                        data: data.arr_total_zns_week
                        },{
                            name: 'Gửi lỗi',
                            data: data.arr_total_err_zns_week
                        }],
                    xaxis: {
                        categories: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật']
                    },
                }, true);
            
            } else if (a.value === 'week' && b.value === 'GD'){
                ApexCharts.exec('chartZNS', 'updateOptions', {
                    series: [{
                        name: 'Tin giao dịch',
                        data: data.arr_total_gd_week
                        },{
                            name: 'Gửi lỗi',
                            data: data.arr_total_err_gd_week
                        }],
                    xaxis: {
                        categories: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật']
                    },
                }, true);
            }else if (a.value === 'week' && b.value === 'Chatbot'){
                ApexCharts.exec('chartZNS', 'updateOptions', {
                    series: [{
                        name: 'Tin giao dịch',
                        data: data.arr_total_chatbot_week
                        },{
                            name: 'Gửi lỗi',
                            data: data.arr_total_err_chatbot_week
                        }],
                    xaxis: {
                        categories: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật']
                    },
                }, true);
            } else if (a.value === 'month' && b.value === 'ZNS') {
                ApexCharts.exec('chartZNS', 'updateOptions', {
                    series: [{
                        name: 'Tin ZNS',
                        data: data.arr_total_suc_zns
                        },{
                            name: 'Gửi lỗi',
                            data: data.arr_total_err_zns
                        }],
                    xaxis: {
                        categories: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4']
                    },
                }, true);
            } else if (a.value === 'month' && b.value === 'GD'){
                ApexCharts.exec('chartZNS', 'updateOptions', {
                    series: [{
                        name: 'Tin giao dịch',
                        data: data.arr_total_suc
                        },{
                            name: 'Gửi lỗi',
                            data: data.arr_total_err
                        }],
                    xaxis: {
                        categories: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4']
                    },
                }, true);
            } else if (a.value === 'month' && b.value === 'Chatbot'){
                ApexCharts.exec('chartZNS', 'updateOptions', {
                    series: [{
                        name: 'Tin giao dịch',
                        data: data.arr_total_suc_chatbot
                        },{
                            name: 'Gửi lỗi',
                            data: data.arr_total_err_chatbot
                        }],
                    xaxis: {
                        categories: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4']
                    },
                }, true);
            }
        })
    }
    
    
</script>

</html>