<?php
/**
 * Plugin Name: Zalo Connector
 * Description: Plugin to manage Zalo follow, link Customers and customers' Zalo
 * Version: 1.0
 * Author: <a href="https://mekong-connector.com/" target="_blank">Mekong Connector</a>
 */
// active plugin hook  
add_action('activated_plugin', 'function_after_plugin_zalo_marketing');

function function_after_plugin_zalo_marketing(){
    global $wpdb;   
   
    $table_name_tag = $wpdb->prefix . 'tags'; 
    $table_name_customertag = $wpdb->prefix . 'customer_tag';
    $table_name_marketingcampaign = $wpdb->prefix . 'marketingcampaign';
    $table_name_schedulesendingv2 = $wpdb->prefix . 'schedulesendingv2';
    $table_name_customertoken = $wpdb->prefix. 'customer_token';
    $table_name_define_templates_zns = $wpdb->prefix . 'define_templates_zns';
    $table_name_sent_zns_history = $wpdb->prefix . 'sent_zns_history';
    //Khai báo bảng - datnc
    $table_name_tagging = $wpdb->prefix . 'tagging';
    $table_name_tagging_option = $wpdb->prefix . 'tagging_option';
    $table_name_zalo_followers = $wpdb->prefix . 'zalo_followers';
    $table_name_message_zalo = $wpdb->prefix ."message_zalo";
    $table_name_link_customer_log = $wpdb->prefix ."link_customer_log";
    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_zalo_followers'") != $table_name_zalo_followers) {
        // Nếu bảng chưa tồn tại, thực hiện tạo bảng
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "
            CREATE TABLE $table_name_zalo_followers (
                id INT NOT NULL AUTO_INCREMENT,
                Zalo_ID VARCHAR(255) NOT NULL,
                Zalo_Name VARCHAR(255),
                Zalo_URL_Img TEXT,
                Zalo_ID_By_App VARCHAR(255),
                Follow_Status INT,
                Follow_Start_Date DATE,
                Unfollow_Date DATE,
                fk_wc_customer_id INT,
                PRIMARY KEY (id)
            ) $charset_collate;
        ";
        dbDelta($sql);
    }

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_message_zalo'") != $table_name_message_zalo ){
        $sql = "
        CREATE TABLE $table_name_message_zalo (
            Id INT NOT NULL AUTO_INCREMENT,
            SendTo VARCHAR(100) NOT NULL,
            User_id_zalo VARCHAR(100) DEFAULT NULL,
            User_id_by_app VARCHAR(100) DEFAULT NULL,
            message_type TEXT DEFAULT NULL,
            Content TEXT DEFAULT NULL,
            URL VARCHAR(100) DEFAULT NULL,
            create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            User_type varchar(100) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);
    }

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_link_customer_log'") != $table_name_link_customer_log ){
        $sql = "CREATE TABLE IF NOT EXISTS $table_name_link_customer_log (
            id INT NOT NULL AUTO_INCREMENT,
            link_date DATE NOT NULL,
            canceled_customer_id INT,
            canceled_user_id INT,
            linked_customer_id INT,
            old_user_id INT,
            new_user_id INT,
            linked_zalo_id VARCHAR(255),
            PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);
    }

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_customertag'") != $table_name_customertag){
        $sql = "
        CREATE TABLE $table_name_customertag (
        id INT NOT NULL AUTO_INCREMENT,
        fkCustomer INT(11),
        fkTag INT(11) NOT NULL,
        zalo_user_id varchar(50),
        zalo_user_id_by_app	varchar(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        ) $charset_collate;";
        // echo $sql;
        dbDelta($sql);
    }
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_marketingcampaign'") != $table_name_marketingcampaign ){
        $sql = "
            CREATE TABLE $table_name_marketingcampaign (
            `PrimaryKey` int(10) NOT NULL COMMENT 'Unique identifier of each record in this table' AUTO_INCREMENT,
            `CreationTimestamp` timestamp NULL DEFAULT NULL COMMENT 'Date and time each record was created',
            `CreatedBy` int(10) DEFAULT NULL COMMENT 'Account name of the user who created each record',
            `ModificationTimestamp` timestamp NULL DEFAULT NULL,
            `ModifiedBy` int(10) DEFAULT NULL COMMENT 'Account name of the user who last modified each record',
            `fkCustomer` int(10) DEFAULT NULL,
            `Name` varchar(200) DEFAULT NULL,
            `Code` varchar(200) DEFAULT NULL,
            `isActive` int(10) DEFAULT NULL,
            `fkSampleOrder` int(10) DEFAULT NULL,
            `fkBranch` int(10) DEFAULT NULL,
            `fkEmployee` int(10) DEFAULT NULL,
            `SalesTarget` int(10) DEFAULT NULL COMMENT 'Mục tiêu chiến dịch',
            `StartDate` timestamp NULL DEFAULT NULL,
            `EndDate` timestamp NULL DEFAULT NULL,
            `SendType` int(10) DEFAULT NULL COMMENT '0: Zalo OA, 1: Zalo ZNS, 2: SMS',
            `CurrentRevenue` int(10) DEFAULT NULL COMMENT 'Doanh thu hiện tại từ chiến dịch',
            `Poster` varchar(255) DEFAULT NULL,
            `Files` varchar(255) DEFAULT NULL,
            `RepeatType` int(10) DEFAULT NULL,
            `RepeatOn` text DEFAULT NULL COMMENT 'gửi vào thứ mấy trong tuần ',
            `RepeatDate` timestamp NULL DEFAULT NULL COMMENT 'Nếu là hằng tháng hoặc hằng năm thì gửi vào ngày giờ này',
            `Content` text DEFAULT NULL,
            `Parameter` text DEFAULT NULL,
            `Status` int(10) DEFAULT NULL,
            `fkDeclareTemplate` int(10) DEFAULT NULL,
            `RepeatTime` time DEFAULT NULL,
            `RepeatDay` int(10) DEFAULT NULL,
            `RepeatMonth` int(10) DEFAULT NULL,
            `fkRegion` int(10) DEFAULT NULL,
            `arrRegion` text DEFAULT NULL,
            `arrBranch` text DEFAULT NULL,
            `arrCustomer` text DEFAULT NULL,
            `Description` text DEFAULT NULL,
            `Budget` int(10) DEFAULT NULL,
            `UUID` varchar(200) DEFAULT NULL,
            `fkPromotion` int(10) DEFAULT NULL,
            `Title` varchar(200) DEFAULT NULL,
            `JsonResult` text DEFAULT NULL,
            `PosterUrl` text DEFAULT NULL,
            `CountSending` int(10) DEFAULT NULL,
            `fkTag` int(10) DEFAULT NULL,
            `isShowClient` int(10) DEFAULT NULL,
            `arrTag` text DEFAULT NULL,
            `SendTime` time DEFAULT NULL,
            `SendDate` date DEFAULT NULL,
            `SearchField` text DEFAULT NULL,
            `TemplateId` varchar(255) DEFAULT NULL,
            `ZnsParam` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`PrimaryKey`)
        ) $charset_collate;";
        dbDelta($sql);
    }
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_tag'") != $table_name_tag){
        $sql = "
            CREATE TABLE `wp_tags` (
                id INT NOT NULL AUTO_INCREMENT,
                Name VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) $charset_collate;";
         dbDelta($sql);
    }
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_schedulesendingv2'") != $table_name_schedulesendingv2){
        $sql = "
            CREATE TABLE `wp_schedulesendingv2` (
                `PrimaryKey` int(10) NOT NULL AUTO_INCREMENT,
                `CreationTimestamp` timestamp NULL DEFAULT NULL,
                `CreatedBy` int(10) DEFAULT NULL,
                `ModificationTimestamp` timestamp NULL DEFAULT NULL,
                `ModifiedBy` int(10) DEFAULT NULL,
                `Status` int(10) DEFAULT NULL,
                `isActive` int(10) DEFAULT NULL,
                `Link` varchar(255) DEFAULT NULL,
                `SendDate` date DEFAULT NULL,
                `SendTime` time DEFAULT NULL,
                `Content` text DEFAULT NULL,
                `fkSampleOrder` int(10) DEFAULT NULL,
                `fkMarketingCampaign` int(10) DEFAULT NULL,
                `fkCustomer` int(10) DEFAULT NULL,
                `Code` varchar(200) DEFAULT NULL,
                `SampleOrderLink` varchar(255) DEFAULT NULL,
                `UUID` varchar(200) DEFAULT NULL,
                `Title` varchar(200) DEFAULT NULL,
                `PosterUrl` varchar(255) DEFAULT NULL,
                `JsonResultPromotion` varchar(200) DEFAULT NULL,
                `isShowClient` int(10) DEFAULT NULL,
                `SearchField` text DEFAULT NULL,
                PRIMARY KEY (`PrimaryKey`)
                ) $charset_collate;";
            dbDelta($sql);
    }
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_customertoken'") != $table_name_customertoken){
        $sql = "
        CREATE TABLE $table_name_customertoken (
            `PrimaryKey` int(10) NOT NULL AUTO_INCREMENT,
            `CreationTimestamp` timestamp NULL DEFAULT NULL,
            `CreatedBy` int(10) DEFAULT NULL,
            `ModificationTimestamp` timestamp NULL DEFAULT NULL,
            `ModifiedBy` int(10) DEFAULT NULL,
            `fkCustomer` int(10) DEFAULT NULL,
            `token` varchar(200) DEFAULT NULL,
            `expireEpoch` int(10) DEFAULT NULL,
            `sendLink` varchar(200) DEFAULT NULL,
            `activityHistory` text DEFAULT NULL,
            `isActive` int(10) DEFAULT NULL,
            PRIMARY KEY (`PrimaryKey`)
            ) $charset_collate;";
        dbDelta($sql);
    }
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $charset_collate = $wpdb->get_charset_collate();
    $table_id_order = $wpdb->prefix . 'id_order'; 
    if($wpdb->get_var("SHOW TABLES LIKE '$table_id_order'") != $table_id_order){
        $sql = "
        CREATE TABLE $table_id_order (
            `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `order_id` INT(10) DEFAULT NULL,
            `netsuite_user_id` INT(10) DEFAULT NULL,
            `netsuite_order_id` INT(10) DEFAULT NULL
          ) $charset_collate;";

        dbDelta($sql);
    }
    // table chat_bot
    $table_name = $wpdb->prefix . 'zalo_chatbot_log';

    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
        $sql = "
        CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            fkCustomer INT(11) DEFAULT NULL,
            question text NOT NULL,
            answer text NOT NULL,
            token INT(11) DEFAULT NULL,
            function_call varchar(200) DEFAULT NULL,
            type_error varchar(200) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            duration varchar(200) DEFAULT NULL
            PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);
    }
    $table_id_product = $wpdb->prefix . 'id_product'; 

    if($wpdb->get_var("SHOW TABLES LIKE '$table_id_product'") != $table_id_product){
        $sql = "
        CREATE TABLE $table_id_product (
            `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `product_id` INT(10) DEFAULT NULL,
            `netsuite_product_id` INT(10) DEFAULT NULL;
            UNIQUE KEY `unique_netsuite_product_id` (`netsuite_product_id`)
        ) $charset_collate;";
        dbDelta($sql);
    }
    $table_sync_log = $wpdb->prefix  . 'sync_log';
    if($wpdb->get_var("SHOW TABLES LIKE '$tab$wpdb->prefixle_sync_log'") != $table_sync_log){
        $sql = "
        CREATE TABLE $table_sync_log (
            `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `Table_name` VARCHAR(255) DEFAULT NULL,
            `TotalRecord` INT(10) DEFAULT NULL,
            `LastSync` DATETIME DEFAULT NULL,
            `url` VARCHAR(255) DEFAULT NULL,
            UNIQUE KEY `unique_url` (`Table_name`, `url`)
          ) $charset_collate;";
        // echo $sql;
        dbDelta($sql);
    }
    $table_name = $wpdb->prefix . 'wc_customer_lookup'; // Lấy tên bảng posts với tiền tố của WordPress
    $column_name = 'netsuite_user_id'; // Tên cột cần kiểm tra
    $sql = "SHOW COLUMNS FROM $table_name LIKE '$column_name'";
    $results = $wpdb->get_results($sql);
    if (empty($results)) {
        // Cột không tồn tại
        $sql= "ALTER TABLE $table_name ADD COLUMN $column_name INT(10)
        UNIQUE KEY `unique_$column_name` ($column_name)
        ";
        $wpdb->query($sql);
    }
    $table_name = $wpdb->prefix . 'usermeta'; // Lấy tên bảng posts với tiền tố của WordPress
    $column_name = 'netsuite_user_id'; // Tên cột cần kiểm tra
    $sql = "SHOW COLUMNS FROM $table_name LIKE '$column_name'";
    $results = $wpdb->get_results($sql);
    if (empty($results)) {
        // Cột không tồn tại
        $sql= "ALTER TABLE $table_name ADD COLUMN $column_name INT(10)
        UNIQUE KEY `unique_$column_name` ($column_name)
        ";
        $wpdb->query($sql);
    }

    $charset_collate = $wpdb->get_charset_collate();
    $table_id_order = $wpdb->prefix . 'id_order'; 
    if($wpdb->get_var("SHOW TABLES LIKE '$table_id_order'") != $table_id_order){
        $sql = "
        CREATE TABLE $table_id_order (
            `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `order_id` INT(10) DEFAULT NULL,
            `netsuite_user_id` INT(10) DEFAULT NULL,
            `netsuite_order_id` INT(10) DEFAULT NULL
          ) $charset_collate;";

        dbDelta($sql);
    }

    $table_id_product = $wpdb->prefix . 'id_product'; 

    if($wpdb->get_var("SHOW TABLES LIKE '$table_id_product'") != $table_id_product){
        $sql = "
        CREATE TABLE $table_id_product (
            `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `product_id` INT(10) DEFAULT NULL,
            `netsuite_product_id` INT(10) DEFAULT NULL;
            UNIQUE KEY `unique_netsuite_product_id` (`netsuite_product_id`)
        ) $charset_collate;";
        dbDelta($sql);
    }


    $table_name = $wpdb->prefix . 'wc_customer_lookup'; // Lấy tên bảng posts với tiền tố của WordPress
    $column_name = 'netsuite_user_id'; // Tên cột cần kiểm tra
    $sql = "SHOW COLUMNS FROM $table_name LIKE '$column_name'";
    $results = $wpdb->get_results($sql);
    if (empty($results)) {
        // Cột không tồn tại
        $sql= "ALTER TABLE $table_name ADD COLUMN $column_name INT(10)
        UNIQUE KEY `unique_$column_name` ($column_name)
        ";
        $wpdb->query($sql);
    }
    $table_name = $wpdb->prefix . 'usermeta'; // Lấy tên bảng posts với tiền tố của WordPress
    $column_name = 'netsuite_user_id'; // Tên cột cần kiểm tra
    $sql = "SHOW COLUMNS FROM $table_name LIKE '$column_name'";
    $results = $wpdb->get_results($sql);
    if (empty($results)) {
        // Cột không tồn tại
        $sql= "ALTER TABLE $table_name ADD COLUMN $column_name INT(10)
        UNIQUE KEY `unique_$column_name` ($column_name)
        ";
        $wpdb->query($sql);
    }
    //Tao bang -datnc
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_tagging'") != $table_name_tagging){
        $sql = "
        CREATE TABLE $table_name_tagging (
        id INT NOT NULL AUTO_INCREMENT,
        fkTag INT(11) NOT NULL,
        Name VARCHAR(100) NOT NULL,
        Setting VARCHAR(200) NOT NULL,
        FromDay INT(11) NOT NULL,
        RepeatDay INT(11) NOT NULL,
        LastTimeRun DATE,
        fkTagCurrent INT(11) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        ) $charset_collate;";
        // echo $sql;
        dbDelta($sql);
        $sql2 = "ALTER TABLE $table_name_tagging
        ADD CONSTRAINT fkTag
        FOREIGN KEY (id) REFERENCES wp_tags(id) ON DELETE CASCADE ON UPDATE CASCADE $charset_collate;";
        dbDelta($sql2);
        
    }
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_tagging_option'") != $table_name_tagging_option){
        $sql = "
        CREATE TABLE $table_name_tagging_option (
        id INT NOT NULL AUTO_INCREMENT,
        Name VARCHAR(100) NOT NULL,
        Description VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        ) $charset_collate;";
        // echo $sql;
        dbDelta($sql);
         $data = array(
        array('Name' => 'totalPayment', 'Description' => 'Tổng giá trị số hàng hóa đã mua'),
        array('Name' => 'totalSaleOrder', 'Description' => 'Tổng số đơn hàng'),
        array('Name' => 'customerTag', 'Description' => 'Tag khách hàng đang có'),
        array('Name' => 'nextBirthDay', 'Description' => 'Số ngày cách sinh nhật tới'),
        array('Name' => 'lastBuy', 'Description' => 'Lần cuối mua sản phẩm')
        );
    
        foreach ($data as $item) {
            $wpdb->insert($table_name_tagging_option, $item);
        }
    }
    
    //tạo bảng khai báo template zns
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_define_templates_zns'") != $table_name_define_templates_zns){
        $sql = "
        CREATE TABLE $table_name_define_templates_zns (
        id INT AUTO_INCREMENT,
        type VARCHAR(255),
        created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        original_json TEXT,
        custom_variables_json TEXT,
        active BOOLEAN,
        template_id VARCHAR(255),
        auto_send_transaction_message BOOLEAN,
        PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);
    }
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_sent_zns_history'") != $table_name_sent_zns_history){
        $sql = "
        CREATE TABLE $table_name_sent_zns_history (
        id INT AUTO_INCREMENT,
        type VARCHAR(255),
        sent_date DATETIME,
        tracking_id VARCHAR(255),
        customer_id INT,
        customer_name VARCHAR(255),
        customer_phone VARCHAR(255),
        order_id  VARCHAR(255),
        status BOOLEAN,
        error_details TEXT,
        PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);
    }
    
    $table_quotation = $wpdb->prefix . "quotation";
    
    if($wpdb->get_var("SHOW TABLES LIKE '$table_quotation'") != $table_quotation){
        $sql = "
        CREATE TABLE $table_quotation (
        id INT AUTO_INCREMENT PRIMARY KEY,
        quotationName VARCHAR(255),
        creationDate DATE,
        quotationStatus VARCHAR(255),
        quotationTitle VARCHAR(255),
        imgLink VARCHAR(255),
        quotationContent TEXT,
        Fk_Product_ID_List VARCHAR(255),
        Fk_WC_UserID_List VARCHAR(255),
        Product_Name_List TEXT,
        Fk_WC_CustomerID_List VARCHAR(255),
        totalAmount DECIMAL(10, 2)
        ) $charset_collate;";
        dbDelta($sql);
    }
    
    $table_CustomerQuotationDetails  = $wpdb->prefix . "customer_quotation_details" ;
    
    if($wpdb->get_var("SHOW TABLES LIKE '$table_CustomerQuotationDetails'") != $table_CustomerQuotationDetails){
        $sql = "
        CREATE TABLE $table_CustomerQuotationDetails (
        id INT AUTO_INCREMENT PRIMARY KEY,
        Fk_quotation_id INT,
        Fk_User_ID INT
        ) $charset_collate;";
        dbDelta($sql);
    }
    
    $table_ProductQuotationDetails = $wpdb->prefix . "product_quotation_details"  ;
    
    if($wpdb->get_var("SHOW TABLES LIKE '$table_ProductQuotationDetails'") != $table_ProductQuotationDetails){
        $sql = "
        CREATE TABLE $table_ProductQuotationDetails (
            id INT AUTO_INCREMENT PRIMARY KEY,
            FK_quotation_id INT,
            Fk_Product_ID INT,
            quantity INT
        ); $charset_collate;";
        dbDelta($sql);
    }
    
    $table_QuotationSendingSchedule = $wpdb->prefix . 'quotation_sending_schedule'   ;
    
    if($wpdb->get_var("SHOW TABLES LIKE '$table_QuotationSendingSchedule'") != $table_QuotationSendingSchedule){
        $sql = "
        CREATE TABLE $table_QuotationSendingSchedule (
            id INT AUTO_INCREMENT PRIMARY KEY,
            Fk_WC_Order_ID INT,
            Fk_WC_Customer_ID INT,
            Fk_User_ID INT,
            sendStatus VARCHAR(255),
            Fk_Quotation_ID INT,
            sendDate DATETIME
        ); $charset_collate;";
        dbDelta($sql);
    }
    
    $data = array(
        array('order-confirm', current_time('mysql'), current_time('mysql')),
        array('payment-confirm', current_time('mysql'), current_time('mysql')),
        array('order-status', current_time('mysql'), current_time('mysql')),
        array('order-review', current_time('mysql'), current_time('mysql')),
        array('campaign', current_time('mysql'), current_time('mysql')),
        array('bonus-points', current_time('mysql'), current_time('mysql')),
    );
    
    
    foreach ($data as $item) {
        $type = $item[0];
        $created_date = $item[1];
        $updated_date = $item[2];
    
        global $wpdb;
        $table_name_define_templates_zns = $wpdb->prefix . 'define_templates_zns';
    
        // Kiểm tra xem giá trị 'type' đã tồn tại trong bảng chưa
        $existing_type = $wpdb->get_var($wpdb->prepare("SELECT type FROM $table_name_define_templates_zns WHERE type = %s", $type));
    
        if (empty($existing_type)) {
            $wpdb->insert(
                $table_name_define_templates_zns,
                array(
                    'type' => $type,
                    'created_date' => $created_date,
                    'updated_date' => $updated_date,
                ),
                array('%s', '%s', '%s')
            );
        }
    }
    
}
// Hàm được gọi khi plugin được kích hoạt
function follower_management_activate() {
    // Thêm các tác vụ cần thiết khi kích hoạt plugin
}
register_activation_hook(__FILE__, 'follower_management_activate');

// Hàm được gọi khi plugin được vô hiệu hóa
function follower_management_deactivate() {
    // Thêm các tác vụ cần thiết khi vô hiệu hóa plugin
}
register_deactivation_hook(__FILE__, 'follower_management_deactivate');

// Đăng ký endpoint API
function register_link_zalo_api_endpoint() {
    register_rest_route('zalo-management/v1', '/link-zalo', array(
        'methods' => 'GET',
        'callback' => 'link_zalo_customer_api',
    ));
}
// đăng kí api liên kết khách hàng
add_action('rest_api_init', 'register_link_zalo_api_endpoint');
function link_zalo_customer_api($request) {
    global $wpdb;
    $customer_id = $_GET['customerId']; // Lấy giá trị customerId
    $zalo_id = $_GET['id']; // Lấy giá trị id
    // Thực hiện cập nhật bảng zalo_followers với customer_id
    $table_name = $wpdb->prefix . 'zalo_followers';
    $updated = $wpdb->update(
        $table_name,
        array('fk_wc_customer_id' => $customer_id),
        array('Zalo_ID_By_App' => $zalo_id),
        array('%d'),
        array('%s')
    );
    // //tìm thông tin user đăng nhập wordpress bằng zalo_id
    // $table_name = $wpdb->prefix . 'users';
    // $query = $wpdb->prepare("
    //     SELECT ID, user_login
    //     FROM $table_name
    //     WHERE user_login = %s
    // ", $zalo_id);
    // $user = $wpdb->get_row($query);
    // $user_id = $user->ID;
    // $user_login = $user->user_login;
    // //tiến hành quỳ trình cập nhật
    // // User ID và User Login bạn muốn kiểm tra
    // $lookup_table_name = $wpdb->prefix . 'wc_customer_lookup';
    // // Kiểm tra xem có bản ghi nào có user_id = $user_id không
    // $user_check_query = $wpdb->prepare("
    //     SELECT *
    //     FROM $lookup_table_name
    //     WHERE user_id = %d
    // ", $user_id);
    // $user_exists = $wpdb->get_row($user_check_query);
    // if ($user_exists) {
    //     // Nếu có bản ghi, thực hiện cập nhật trường user_id và username thành rỗng
    //     $wpdb->update(
    //         $lookup_table_name,
    //         array(
    //             'user_id' => null,
    //             'username' => '',
    //         ),
    //         array('user_id' => $user_id)
    //     );
    // }
    // // Kiểm tra xem có bản ghi nào có customer_id = $customer_id không
    // $customer_check_query = $wpdb->prepare("
    //     SELECT *
    //     FROM $lookup_table_name
    //     WHERE customer_id = %d
    // ", $customer_id);
    // $customer_exists = $wpdb->get_row($customer_check_query);
    // if ($customer_exists) {
    //     // Nếu có bản ghi, thực hiện cập nhật trường user_id và username
    //     $wpdb->update(
    //         $lookup_table_name,
    //         array(
    //             'user_id' => $user_id,
    //             'username' => $user_login,
    //         ),
    //         array('customer_id' => $customer_id)
    //     );
    //     //thực hiện liên kết đơn hàng
    //     $url = 'https://cvbt0dfnwh.execute-api.ap-southeast-1.amazonaws.com/mk_antai/update-customer-id-order';
    //     $data = array(
    //         'user-id' => $user_id,
    //     );
    //     $request_args = array(
    //         'body' => json_encode($data), 
    //         'headers' => array(
    //             'Content-Type' => 'application/json',
    //         ),
    //     );
    //     $response = wp_safe_remote_post($url, $request_args);
        
    // }
    //kết thúc quy trình
    if ($updated) {
        return new WP_REST_Response(array('message' => 'Liên kết thành công'), 200);
    } else {
        return new WP_REST_Response(array('message' => 'Liên kết thất bại'), 400);
    }
}
// đăng kí api get profile
function get_profile_zalo_callback($request) {
    $id = $_GET['id'];
    // Lấy access token từ cài đặt hoặc nơi khác
    $access_token = get_option('zalo_follow_management_zalo_access_token'); // Thay thế bằng tên option của bạn
    $url = "https://openapi.zalo.me/v2.0/oa/getprofile?data={\"user_id\":\"$id\"}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'access_token: ' . $access_token,
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response);
        if (isset($data->data)) {
            return rest_ensure_response($data->data);
        }
    }

    return rest_ensure_response(array()); // Trả về dữ liệu rỗng nếu không lấy được thông tin
}

add_action('rest_api_init', function () {
    register_rest_route('zalo-management/v1', '/profile-zalo', array(
        'methods' => 'GET',
        'callback' => 'get_profile_zalo_callback',
    ));
});

//đăng kí api lấy thông tin lịch sử chat
function get_history_chat_callback($request) {
    $id = $_GET['id'];
    // Lấy access token từ cài đặt hoặc nơi khác
    $access_token = get_option('zalo_follow_management_zalo_access_token'); // Thay thế bằng tên option của bạn
    $url = "https://openapi.zalo.me/v2.0/oa/conversation?data={\"user_id\":\"$id\",\"offset\":0,\"count\":10}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'access_token: ' . $access_token,
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response);
        if (isset($data->data)) {
            return rest_ensure_response($data->data);
        }
    }

    return rest_ensure_response(array()); // Trả về dữ liệu rỗng nếu không lấy được lịch sử chat
}

add_action('rest_api_init', function () {
    register_rest_route('zalo-management/v1', '/history-chat', array(
        'methods' => 'GET',
        'callback' => 'get_history_chat_callback',
    ));
});
//đăng kí api webhook khi follow và unfollow
// API WhenUserFollow
function when_user_follow_callback($request) {
    $params = $request->get_params();
    
    // Lấy thông tin từ params
    $zaloID = $params['Zalo_ID'];
    $zaloName = $params['Zalo_Name'];
    $zaloImgURL = $params['Zalo_URL_Img'];
    $zaloIDByApp = $params['Zalo_ID_By_App'];
    $followStartDate = date('Y-m-d');
    $zaloFLStatus=1;
    global $wpdb;
    $table_name = $wpdb->prefix . 'zalo_followers';

    // Kiểm tra xem Zalo_ID_By_App đã tồn tại trong CSDL hay chưa
    $existing_row = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE Zalo_ID_By_App = %s", $zaloIDByApp)
    );

    if ($existing_row) {
        // Nếu đã tồn tại, thực hiện cập nhật dữ liệu
        $update_data = array(
            'Zalo_Name' => $zaloName,
            'Zalo_URL_Img' => $zaloImgURL,
            'Zalo_ID' => $zaloID,
            'Follow_Status' => $zaloFLStatus,
            'Follow_Start_Date' => $followStartDate,
        );
        $where = array('Zalo_ID_By_App' => $zaloIDByApp);
        $wpdb->update($table_name, $update_data, $where);
        //tiến hành tạo tài khoản đăng nhập
        $user_obj = get_user_by('login', $zaloIDByApp);
        if(!$user_obj){
            $user_pass = "12345678Wp@";
            $user_login = $zaloIDByApp;
            $user_email = $user_login.'@zalo.me';
            $display_name = $zaloName;
            $role = 'customer';
            $show_admin_bar_front = "false";
            $userdata = compact( 'user_login', 'user_email', 'user_pass', 'display_name', 'show_admin_bar_front', 'role' );
            $wp_user_id = wp_insert_user( $userdata );
        }
        $message = 'User information updated successfully.';
    } else {
        // Nếu chưa tồn tại, thực hiện thêm mới
        $new_data = array(
            'Zalo_ID' => $zaloID,
            'Zalo_Name' => $zaloName,
            'Zalo_URL_Img' => $zaloImgURL,
            'Zalo_ID_By_App' => $zaloIDByApp,
            'Follow_Status' => $zaloFLStatus,
            'Follow_Start_Date' => $followStartDate,
        );
        $wpdb->insert($table_name, $new_data);
        //tiến hành tạo tài khoản đăng nhập
        $user_obj = get_user_by('login', $zaloIDByApp);
        if(!$user_obj){
            $user_pass = "12345678Wp@";
            $user_login = $zaloIDByApp;
            $user_email = $user_login.'@zalo.me';
            $display_name = $zaloName;
            $role = 'customer';
            $show_admin_bar_front = "false";
            $userdata = compact( 'user_login', 'user_email', 'user_pass', 'display_name', 'show_admin_bar_front', 'role' );
            $wp_user_id = wp_insert_user( $userdata );
        }
        $message = 'User followed and added successfully.';
    }
    
    return rest_ensure_response(array('message' => $message));
}

add_action('rest_api_init', function () {
    register_rest_route('zalo-management/v1', '/WhenUserFollow', array(
        'methods' => 'POST',
        'callback' => 'when_user_follow_callback',
    ));
});

// API WhenUserUnfollow
function when_user_unfollow_callback($request) {
    global $wpdb;

    $params = $request->get_params();
    $zaloID = $params['Zalo_ID'];
    $unfollowDate = date('Y-m-d');

    // Kiểm tra nếu Zalo ID By App đã tồn tại trong bảng zalo_followers
    $follower_table = $wpdb->prefix . 'zalo_followers';
    $existing_follower = $wpdb->get_row($wpdb->prepare("SELECT * FROM $follower_table WHERE Zalo_ID = %s", $zaloID));

    if ($existing_follower) {
        // Cập nhật trạng thái theo dõi
        $wpdb->update(
            $follower_table,
            array('Follow_Status' => 0, 'Unfollow_Date' => $unfollowDate),
            array('Zalo_ID' => $zaloID)
        );

        return rest_ensure_response(array('message' => 'User unfollowed successfully and status updated.'.$zaloIDByApp));
    } else {
        return rest_ensure_response(array('message' => 'User not found in database.'));
    }
}

add_action('rest_api_init', function () {
    register_rest_route('zalo-management/v1', '/WhenUserUnfollow', array(
        'methods' => 'POST',
        'callback' => 'when_user_unfollow_callback',
    ));
});
// Hook into WordPress to lấy userID của khách hàng
add_action('rest_api_init', 'register_username_to_userid_api');

function register_username_to_userid_api() {
    // Đăng ký một route /get-userid với phương thức POST
    register_rest_route('zalo-management/v1', '/get-userid', array(
        'methods' => 'POST',
        'callback' => 'get_user_id_by_username',
    ));
}

// Hàm callback để xử lý yêu cầu API
function get_user_id_by_username($request) {
    // Lấy dữ liệu gửi lên qua API
    $request_body = $request->get_body();
    $data = json_decode($request_body, true);
    // Kiểm tra xem có username trong dữ liệu gửi lên không
    if (isset($data['user-id-by-app'])) {
        // Lấy user ID dựa trên username
        $user = get_user_by('login', $data['user-id-by-app']);
        if ($user) {
            $user_id = $user->ID;
            return new WP_REST_Response(array('user_id' => $user_id), 200);
        } else {
            return new WP_REST_Response(array('error' => 'User not found'), 404);
        }
    } else {
        return new WP_REST_Response(array('error' => 'Username is missing'), 400);
    }
}
//api GetDashBoardByWeek
function get_dashboard_by_week_callback($request) {
    global $wpdb;
    $current_date = date('Y-m-d');
    // Ngày bắt đầu tuần này (ngày hiện tại là ngày kết thúc)
    $start_of_this_week = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
    $end_of_this_week = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));
    // Ngày bắt đầu tuần trước và kết thúc tuần trước
    $start_of_last_week = date('Y-m-d', strtotime('monday last week', strtotime($current_date)));
    $end_of_last_week = date('Y-m-d', strtotime('sunday last week', strtotime($current_date)));
    $apikey= get_option('zalo_follow_management_license_apikey');
    $zalo_app_id_from_setting=get_option('zalo_follow_management_zalo_app_id');
    // $api_url = "https://cvbt0dfnwh.execute-api.ap-southeast-1.amazonaws.com/mk_antai/dashboard_zalo_tong_hop";
    $api_url = "https://webhook.mekong-connector.com/dashboard-zalo-tong-hop";
    // Define the request data
    $request_data = array(
        "startDate" => $start_of_this_week,
        "endDate" => $end_of_this_week,
        "startCompareDate" => $start_of_last_week,
        "endCompareDate" => $end_of_last_week,
        "app_id"=> $zalo_app_id_from_setting
    );
    // Initialize cURL session
    $ch = curl_init($api_url);
    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Use POST method
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data)); // Send JSON data
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-header: value','x-api-key:'.$apikey.''));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    // Execute cURL session and store the response
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        $data = json_decode($response, true);
        curl_close($ch);
        return $data;
    }
}

add_action('rest_api_init', function () {
    register_rest_route('zalo-management/v1', '/GetDashBoardByWeek', array(
        'methods' => 'GET',
        'callback' => 'get_dashboard_by_week_callback',
    ));
});

//api GetDashBoardByMonth
function get_dashboard_by_month_callback($request) {
    global $wpdb;
    $current_date = date('Y-m-d');
    $start_of_this_month = date('Y-m-d', strtotime('first day of this month', strtotime($current_date)));
    $end_of_this_month = date('Y-m-d', strtotime('last day of this month', strtotime($current_date)));
    $start_of_last_month = date('Y-m-d', strtotime('first day of last month', strtotime($current_date)));
    $end_of_last_month = date('Y-m-d', strtotime('last day of last month', strtotime($current_date)));
    $apikey= get_option('zalo_follow_management_license_apikey');
    $zalo_app_id_from_setting=get_option('zalo_follow_management_zalo_app_id');
    $api_url = "https://webhook.mekong-connector.com/dashboard-zalo-tong-hop";
    // Define the request data
    $request_data = array(
        "startDate" => $start_of_this_month,
        "endDate" => $end_of_this_month,
        "startCompareDate" => $start_of_last_month,
        "endCompareDate" => $end_of_last_month,
        "app_id"=> $zalo_app_id_from_setting
    );
    // Initialize cURL session
    $ch = curl_init($api_url);
    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Use POST method
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data)); // Send JSON data
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    // Execute cURL session and store the response
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        $data = json_decode($response, true);
        curl_close($ch);
        return $data;
    }
}

add_action('rest_api_init', function () {
    register_rest_route('zalo-management/v1', '/GetDashBoardByMonth', array(
        'methods' => 'GET',
        'callback' => 'get_dashboard_by_month_callback',
    ));
});

//api Get Chart
function get_dashboard_chart_callback($request) {
    global $wpdb;
    $current_date = date('Y-m-d');
    $type=$_GET['type'];
    $chartType=$_GET['chartType'];
    // Ngày bắt đầu tuần này (ngày hiện tại là ngày kết thúc)
    $start_of_this_week = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
    $end_of_this_week = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));
    $start_of_this_month = date('Y-m-d', strtotime('first day of this month', strtotime($current_date)));
    $end_of_this_month = date('Y-m-d', strtotime('last day of this month', strtotime($current_date)));
    // $api_url = "https://cvbt0dfnwh.execute-api.ap-southeast-1.amazonaws.com/mk_antai/dashboard_zalo"; cũ
    $apikey= get_option('zalo_follow_management_license_apikey');
    $zalo_app_id_from_setting=get_option('zalo_follow_management_zalo_app_id');
    $api_url = "https://webhook.mekong-connector.com/dashboard-zalo";
    // Define the request data
    if($type=="week"){
        $request_data = array(
            "startDate" => $start_of_this_week,
            "endDate" => $end_of_this_week,
            "type" => $type,
            "chartType" => $chartType,
            "app_id"=> $zalo_app_id_from_setting
        );
    }
    else{
        $request_data = array(
            "startDate" => $start_of_this_month,
            "endDate" => $end_of_this_month,
            "type" => $type,
            "chartType" => $chartType,
            "app_id"=> $zalo_app_id_from_setting
        );
    }
    // Initialize cURL session
    $ch = curl_init($api_url);
    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Use POST method
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data)); // Send JSON data
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    // Execute cURL session and store the response
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        // $data = json_decode($response, true);
        // curl_close($ch);
        // $newJsonData = [
        //     "label" => [],
        //     "value" => [],
        // ];
        // foreach ($data['data'] as $item) {
        //     $newJsonData['label'][] = $item['label'];
        //     $newJsonData['value'][] = $item['value'];
        // }
        // $newJson = json_encode($newJsonData);
        // return json_decode($newJson,true);
        $data = json_decode($response, true);
        curl_close($ch);
        $dayOrder = ['Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy', 'Chủ nhật', 'Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'];
        $newJsonData = [
            "label" => [],
            "value" => [],
        ];
        foreach ($dayOrder as $day) {
            $index = array_search($day, array_column($data['data'], 'label'));
            if ($index !== false) {
                $newJsonData['label'][] = $data['data'][$index]['label'];
                $newJsonData['value'][] = $data['data'][$index]['value'];
            }
        }
        $newJson = json_encode($newJsonData);
        return json_decode($newJson, true);

    }
}

add_action('rest_api_init', function () {
    register_rest_route('zalo-management/v1', '/GetDashBoardChart', array(
        'methods' => 'GET',
        'callback' => 'get_dashboard_chart_callback',
    ));
});

//xử lý đăng nhập ở đây
// Add Zalo login button to checkout
function add_zalo_login_button() {
    // echo '<p>Hoặc login bằng Zalo:</p>';
    $zalo_app_id = get_option('zalo_follow_management_zalo_app_id');
    $call_back_url = get_option('zalo_follow_management_zalo_callback_url');
    $ZALO_APP_ID = $zalo_app_id;
    $CALLBACK_URL = $call_back_url;
    $button= "
        <a style='color:white;font-size:15px;background-color: blue;padding: 15px;border: 1px solid blue;border-radius: 25px;text-decoration: none;display: flex;width: fit-content;justify-items: center;align-items: center;' href='https://oauth.zaloapp.com/v4/permission?app_id=$ZALO_APP_ID&redirect_uri=$CALLBACK_URL&state=100'>
            <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Icon_of_Zalo.svg/2048px-Icon_of_Zalo.svg.png' width='25px' style='margin-right: 8px;'></img> Đăng nhập bằng ZALO
        </a>";
    if(!is_user_logged_in())
        return $button;
    else
        return "";
}
add_shortcode('login_zalo', 'add_zalo_login_button');

//thêm shortcode vào trang woocommerce_login_form
function add_login_zalo_to_woocommerce_login_form() {
    echo do_shortcode('[login_zalo]');
}
add_action('woocommerce_login_form', 'add_login_zalo_to_woocommerce_login_form');


// Hook để đăng ký route API
add_action('rest_api_init', 'register_api_routes');

function register_api_routes() {
    // Đăng ký một route với đường dẫn /api/recent-posts
    register_rest_route('myplugin/v1', '/login-zalo', array(
        'methods' => 'GET',
        'callback' => 'login_zalo_handler',
    ));
}
function login_zalo_handler($request) {
    //Xử lý data Zalo trả về tại đây
    if(isset($_GET["code"])){
        $zalo_app_id = get_option('zalo_follow_management_zalo_app_id');
        $zalo_app_secret = get_option('zalo_follow_management_zalo_app_secret');
        $redirect_url = get_option('zalo_follow_management_zalo_redirect_url');
        
        $ZALO_APP_ID = $zalo_app_id;
        $ZALO_APP_SECRET = $zalo_app_secret; 
        $data = http_build_query(array(
            "app_id" => $ZALO_APP_ID,
            "code" => $_GET["code"],
            "grant_type" => "authorization_code"
        ));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://oauth.zaloapp.com/v4/access_token',
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "secret_key: " . $ZALO_APP_SECRET
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_FAILONERROR => true,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $auth = json_decode( $response, true );
        $token = $auth['access_token'];
        $refresh_token = $auth['refresh_token'];
        $expires_in = $auth['expires_in'];
        if($token){
            $profile = file_get_contents('https://graph.zalo.me/v2.0/me?access_token='.$token.'&fields=id,birthday,name,gender,picture');
            $arr_profile = json_decode( $profile, true );
            // var_dump($arr_profile);
            // die();
            if($arr_profile){
                $id = $arr_profile['id'];
                $name = $arr_profile['name'];
                $user_obj = get_user_by('login', $id);
                if($user_obj->ID){
                    $wp_user_id = $user_obj->ID;
                }
                else
                {
                    $user_pass = wp_generate_password( 8, true, true );
                    $user_login = $id;
                    $user_email = $user_login.'@zalo.me';
                    $display_name = $name;
                    $role = 'customer';
                    $show_admin_bar_front = "false";
                    $userdata = compact( 'user_login', 'user_email', 'user_pass', 'display_name', 'show_admin_bar_front', 'role' );
                    $wp_user_id = wp_insert_user( $userdata );
                    if ( is_wp_error( $wp_user_id ) ) {
                        $err = 1;
                        echo 'Có lỗi xảy ra Zalo 503';
                    }
                    //thêm user vào bảng zalo follower
                    $zaloID = '';
                    $zaloName = $name;
                    $zaloImgURL = $arr_profile['picture']['data']['url'];
                    $zaloIDByApp = $id;
                    $followStatus=1;
                    $newFollowerID = add_zalo_follower_to_db($zaloID, $zaloName, $zaloImgURL, $zaloIDByApp, $followStatus);
                }
                //auto login
                //login to ecomerce
                $user = get_user_by( 'login', $id );
                $user_id = $user->ID;
                $user_login = $user->user_login;
                wp_set_current_user( $user_id, $user_login );
                wp_set_auth_cookie( $user_id );
                do_action( 'wp_login', $user_login, $user );
                wp_redirect($redirect_url);
            }
            else{
                echo 'Có lỗi xảy ra Zalo 502';
            }
        }
        else{
            echo 'Có lỗi xảy ra Zalo 501';
            var_dump($token);
            echo $token;
        }
    }
}

function add_zalo_follower_to_db($zaloID, $zaloName, $zaloImgURL, $zaloIDByApp, $followStatus) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'zalo_followers';
    $followStartDate = date('Y-m-d');
    $data = array(
        'Zalo_ID' => $zaloID,
        'Zalo_Name' => $zaloName,
        'Zalo_URL_Img' => $zaloImgURL,
        'Zalo_ID_By_App' => $zaloIDByApp,
        'Follow_Status' => $followStatus,
        'Follow_Start_Date' => $followStartDate,
    );
    $wpdb->insert($table_name, $data);
    return $wpdb->insert_id; // Trả về ID của bản ghi vừa thêm
}

//kết thúc xử lý đăng nhập ở đây

// Đặt tên plugin là "Zalo Connect" (nếu plugin có một file chú thích)
// function set_plugin_name($plugin_name) {
//     $plugin_name['Name'] = 'Zalo Connect';
//     return $plugin_name;
// }
// add_filter('plugin_row_meta', 'set_plugin_name');

// Thêm menu "Quản lý Người theo dõi" và "Setup"
function follower_management_menu() {

    $icon_url = plugin_dir_url(__FILE__) . 'assets/simple-icons_zalo.svg'; // Đường dẫn tới biểu tượng

    add_menu_page(
        'Zalo Connector',
        'Zalo Connector',
        'manage_options',
        'main-menu',
        'follower_zalo_dashboard_page',
        $icon_url,
        56
    );
    //follower-zalo-dashboard
    add_submenu_page(
        'main-menu',
        'Dashboard',
        'Dashboard',
        'manage_options',
        'main-menu',
        'follower_zalo_dashboard_page'
    );

    add_submenu_page(
        'main-menu',
        'Customers Integration',
        'Customers Integration',
        'manage_options',
        'follower-management',
        'follower_management_page'
    );

    add_submenu_page(
        'main-menu',
        'Campaigns',
        'Campaigns',
        'manage_options',
        'marketing-management',
        'marketing_management_page'
    );
    
    add_submenu_page(
        'main-menu',
        'Quotation',         
        'Quotation',         
        'manage_options',        
        'quota-management',         
        'quota_management_page'
    );
    
   
    add_submenu_page(
        'main-menu',
        'Articles',
        'Articles',
        'manage_options',
        'article-management',
        'article_management_page'
    );
    
    
    add_submenu_page(
        "main-menu",
        'Chat bot',
        'Chat bot',
        'manage_options',
        'Chat_bot_management',
        'Chat_bot_management_page'
    );   
    
    
    add_submenu_page(
        'main-menu',
        'Notification Centers',
        'Notification Centers',
        'manage_options',
        'notification-management',
        'notification_management_page'
    );
    //Them menu datnc
    add_submenu_page(
        'main-menu', // Tiêu đề trang
        'Tags',
        'Tags',      // Tên trên menu
        'manage_options',     // Quyền truy cập cần thiết để thấy liên kết
        'tags', // Slug của trang (URL)
        'tags_plugin_page_content' // Callback function để hiển thị nội dung trang
    );
    
    add_submenu_page(
        'main-menu',
        'Setting',
        'Setting',
        'manage_options',
        'follower-setup',
        'follower_setup_page'
    );
    
    add_submenu_page(
        null,
        'Chat',
        'Chat',
        'manage_options',
        'follower-chat',
        'follower_chat_page'
    );
    
    
    
    // menu marketing_canlender
    add_submenu_page(
        null,
        'Chiến dịch quảng cáo dashboard',
        'Chiến dịch quảng cáo dashboard',
        'manage_options',
        'marketing-dashboard',
        'marketing_dashboard_page'
    );
    add_submenu_page(
        null,
        'Thiết lập zns',
        'Thiết lập zns',
        'manage_options',
        'marketing-setup',
        'marketing_setup_page'
    );
    
    
    // chat_bot
    
    //Nhân
    
    add_submenu_page(
        null,
        'Dashboard Bài viết',
        'Dashboard Bài viết',
        'manage_options',
        'article-dashboard',
        'article_dashboard_page'
    );
    //nhân
    add_submenu_page(
        null,
        'Dashboard ZNS',
        'Dashboard ZNS',
        'manage_options',
        'zns-dashboard',
        'zns_dashboard_page'
    );


    
    // Thêm trang chi tiết khách hàng (Detail)
    add_submenu_page(
        null,
        // 'article-management', 
        'Chi tiết khách hàng',
        'Chi tiết khách hàng',
        'manage_options',
        'customer-detail',
        'customer_detail_page'
    );
    
    // Thêm trang chi tiết đơn hàng khách hàng (Order List)
    add_submenu_page(
        null,
        // 'article-management', 
        'Danh sách đơn hàng',
        'Danh sách đơn hàng',
        'manage_options',
        'customer-order-list',
        'customer_order_list_page'
    );
    
    // Thêm trang lịch sử chat
    add_submenu_page(
        null,
        // 'article-management', 
        'Lịch sử chat',
        'Lịch sử chat',
        'manage_options',
        'customer-chat-history',
        'customer_chat_history_page'
    );
    
    add_submenu_page(
        null,
        'Campaigns',
        'Campaigns',
        'manage_options',
        'campaign-management',
        'campaign_management_page'
    );
    

    //Them menu -datnc
    

}
add_action('admin_menu', 'follower_management_menu');
//nhân
function quota_create_page() {
    require_once('page/quota/create.php');
}
function quota_management_page(){
    require_once('page/quota/index.php');
}

function zns_dashboard_page() {
    require_once('page/zns-dashboard.php');
}
//trang nitification
function notification_management_page() {
    require_once('page/notification/notification.php');
}
function campaign_management_page() {
    require_once('page/notification/campaigns.php');
}
// chat bot
function Chat_bot_management_page(){
    require_once('page/chatbot.php');
}

// Trang quản lý Người theo dõi
function follower_management_page() {
    require_once('page/index.php');
}

// Trang quản lý chat
function follower_chat_page() {
    require_once('page/chat.php');
}

// Trang quản lý chi tiết khách hàng
function customer_detail_page() {
    require_once('page/customer-profile/customer-profile.php');
}

// Trang quản lý danh sách đơn hàng
function customer_order_list_page() {
    require_once('page/customer-profile/customer-order.php');
}

// Trang quản lý lịch sử chat
function customer_chat_history_page() {
    require_once('page/customer-profile/customer-chat.php');
}

// Trang quản lý zalo-dashboard
function follower_zalo_dashboard_page() {
    require_once('page/zalo-dashboard.php');
}
// Trang thiết lập
function follower_setup_page() {
    
    global $wpdb;
    // kết thúc thiết lập csdl liên kết
    $img_url = plugins_url('assets/', __FILE__);
    $logo = $img_url . 'logomkc.png';
    ?>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <style>
        .wpbody-content{
            padding-bottom:0px;
        }
        .card-cus{
            width: 98%;
            height: auto;
            padding: 30px;
            background-color: white;
            border: solid 1px whitesmoke;
            border-radius: 20px;
        }
        body{
            background-color: #F5F6F8;
        }
        /* CSS cho tabs và nội dung */
        .custom-tabs {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            background-color: white;
        }

        .custom-tab {
            cursor: pointer;
            padding: 10px 20px;
            border: 1px solid #ccc;
            background-color: white;
            margin-right: 0px;
        }

        .custom-tab.active {
            background-color: #F2F4F7;
            border-bottom: none;
        }

        .tab-content {
            display: none;
        }
        label{
            color: black;
            /*font-weight: bold;*/
        }
        .tab-content.active {
            display: block;
            background-color: #F2F4F7;
            padding: 30px;
            margin-bottom: 10px;
            border-bottom-left-radius: 10px; 
            border-bottom-right-radius:10px;
        }
        .cus_modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cus_modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 50vw;
            max-width: 50vw;
        }

        .cus_form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .cus_form-group label {
            display: block;
            font-weight: bold;
        }

        .cus_form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .cus_form-group button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <nav class="navbar navbar-light bg-light">
        <!--<div class="container-fluid">-->
        <!--    <a class="navbar-brand" href="#">Thiết lập plugin</a>-->
        <!--</div>-->
    </nav>
    <div class="card-cus">
        <div class="">
            <div class="row">
                
                <div class="col-sm-12" >
                    <div class="" style="background-color: aliceblue;  border-top-left-radius: 10px; border-top-right-radius: 10px;  padding: 15px;">
                        <h5 class="col-12"><img src="<?php echo $logo;?>" width="45px">&nbsp;&nbsp;Zalo connector setting</h5>
                    </div>
                    <!-- Modal -->
                    <div id="cus_registrationModal" class="cus_modal">
                        <div class="cus_modal-content">
                            <h5 key="register">Đăng ký nhận key bản quyền</h5>
                            <form>
                                <div class="cus_form-group">
                                    <label for="cus_fullName" key="user_name">Họ và tên:</label>
                                    <input type="text" id="cus_fullName" required>
                                </div>
                                <div class="cus_form-group">
                                    <label for="cus_companyName" key="company">Tên công ty hoặc tổ chức:</label>
                                    <input type="text" id="cus_companyName">
                                </div>
                                <div class="cus_form-group">
                                    <label for="cus_phoneNumber" key="phone">Số điện thoại đăng ký:</label>
                                    <input type="tel" id="cus_phoneNumber" required>
                                </div>
                                <div class="cus_form-group">
                                    <label for="cus_email">Email:</label>
                                    <input type="email" id="cus_email" required>
                                </div>
                                <button class="btn btn-primary" type="button" onclick="register()" key="subscribe">Đăng ký</button>
                                <button class="btn btn-danger" type="button" onclick="closeModal()" key="close">Đóng</button>
                            </form>
                        </div>
                    </div>
                    <ul class="custom-tabs" id="myTabs">
                        <li class="custom-tab active" style="margin-bottom: 0px !important; "><i class="fa-solid fa-wrench"></i> Zalo setup</li>
                        <!--<li class="custom-tab" style="margin-bottom: 0px !important;">-->
                        <!--    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="20px" height="20px">    <path d="M 3 4 C 1.346 4 0 5.346 0 7 L 0 15 C 0 16.654 1.346 18 3 18 L 10.625 18 L 17 20 L 16.529297 18 L 21 18 C 22.654 18 24 16.654 24 15 L 24 7 C 24 5.346 22.654 4 21 4 L 3 4 z M 3 6 L 21 6 C 21.551 6 22 6.449 22 7 L 22 15 C 22 15.551 21.551 16 21 16 L 16.529297 16 L 14.005859 16 L 14.25 17.041016 L 11.224609 16.091797 L 10.931641 16 L 10.625 16 L 3 16 C 2.449 16 2 15.551 2 15 L 2 7 C 2 6.449 2.449 6 3 6 z M 10.248047 7 C 9.9566719 7.0012656 9.6758906 7.1748906 9.5566406 7.4628906 C 9.1176406 8.5178906 8.8095781 9.8495313 8.6425781 11.394531 C 8.1405781 9.9835312 7.864375 8.6255156 7.859375 8.6035156 C 7.794375 8.2785156 7.5242656 8.0349063 7.1972656 8.0039062 C 6.8632656 7.9669062 6.5576406 8.1617969 6.4316406 8.4667969 L 5.0625 11.814453 C 4.8125 10.616453 4.559 9.10575 4.5 7.71875 C 4.484 7.30475 4.1197031 6.9679531 3.7207031 7.0019531 C 3.3067031 7.0179531 2.9839531 7.36725 3.0019531 7.78125 C 3.1289531 10.83525 4.1122969 14.309078 4.1542969 14.455078 C 4.2412969 14.763078 4.5169375 14.980047 4.8359375 14.998047 C 5.1499375 15.017047 5.4493125 14.829203 5.5703125 14.533203 L 6.9707031 11.111328 C 7.3497031 12.322328 7.9151562 13.764891 8.6601562 14.712891 C 8.8061562 14.896891 9.024 15 9.25 15 C 9.332 15 9.4141406 14.985984 9.4941406 14.958984 C 9.7961406 14.853984 10 14.569 10 14.25 C 10 11.703 10.335406 9.4961094 10.941406 8.0371094 C 11.100406 7.6561094 10.920109 7.2175937 10.537109 7.0585938 C 10.442859 7.0188438 10.345172 6.9995781 10.248047 7 z M 13.75 8 C 12.656 8.004 11.638984 9.0634062 11.333984 10.566406 C 11.140984 11.522406 11.286609 12.484578 11.724609 13.142578 C 12.021609 13.587578 12.427391 13.872797 12.900391 13.966797 C 13.012391 13.988797 13.125328 14 13.236328 14 C 14.331328 14 15.360016 12.944547 15.666016 11.435547 C 15.859016 10.479547 15.713391 9.517375 15.275391 8.859375 C 14.978391 8.414375 14.571656 8.1291562 14.097656 8.0351562 C 13.980656 8.0111562 13.865 8 13.75 8 z M 19 8 C 17.907 8.004 16.889984 9.0634062 16.583984 10.566406 C 16.390984 11.522406 16.536609 12.484578 16.974609 13.142578 C 17.271609 13.587578 17.677391 13.872797 18.150391 13.966797 C 18.262391 13.988797 18.375328 14 18.486328 14 C 19.581328 14 20.610016 12.944547 20.916016 11.435547 C 21.109016 10.479547 20.963391 9.517375 20.525391 8.859375 C 20.228391 8.414375 19.821656 8.1291562 19.347656 8.0351562 C 19.230656 8.0111562 19.115 8 19 8 z M 13.767578 9.5019531 C 13.779578 9.5019531 13.792687 9.5038594 13.804688 9.5058594 C 13.898688 9.5248594 13.978344 9.6164531 14.027344 9.6894531 C 14.190344 9.9354531 14.333312 10.461672 14.195312 11.138672 C 14.008312 12.066672 13.456312 12.542094 13.195312 12.496094 C 13.101312 12.477094 13.023609 12.3855 12.974609 12.3125 C 12.811609 12.0665 12.668641 11.540281 12.806641 10.863281 C 12.985641 9.9762812 13.506578 9.5019531 13.767578 9.5019531 z M 19.017578 9.5019531 C 19.029578 9.5019531 19.042688 9.5038594 19.054688 9.5058594 C 19.148688 9.5248594 19.228344 9.6164531 19.277344 9.6894531 C 19.440344 9.9354531 19.583313 10.461672 19.445312 11.138672 C 19.258313 12.066672 18.699313 12.542094 18.445312 12.496094 C 18.351312 12.477094 18.273609 12.3855 18.224609 12.3125 C 18.061609 12.0665 17.918641 11.540281 18.056641 10.863281 C 18.235641 9.9762812 18.756578 9.5019531 19.017578 9.5019531 z"/></svg>-->
                        <!--     Woocommerce</li>-->
                        <!--<li class="custom-tab" style="margin-bottom: 0px !important;"><i class="fa-solid fa-circle-nodes"></i> Webhook</li>-->
                        <!--<li class="custom-tab" style="margin-bottom: 0px !important;"><i class="fa-solid fa-robot"></i> Chatbot</li>-->
                        <li class="custom-tab" style="margin-bottom: 0px !important;"><i class="fa-solid fa-key"></i> License</li>
                        <!--<li class="custom-tab" style="margin-bottom: 0px !important;"><i class="fa-solid fa-bell"></i></i> ZNS</li>-->
                        <li class="custom-tab" style="margin-bottom: 0px !important;"><i class="fa-solid fa-rotate"></i> Sync follower</li>
                        <li class="custom-tab" style="margin-bottom: 0px !important;"><i class="fa-solid fa-language"></i> Language</li>
                    </ul>
                    <div class="tab-content active">
                        <div class="tab-pane show active" id="zalo">
                            <form action="<?php echo esc_url(admin_url('options.php')); ?>" method="post">
                                <?php settings_fields('zalo-follow-management-settings-group'); ?>
                                <?php do_settings_sections('zalo-follow-management-settings-group'); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zalo_app_id">Zalo app ID</label>
                                            <input type="text" autocomplete="off" class="form-control" name="zalo_follow_management_zalo_app_id" id="zalo_app_id" placeholder="Enter Zalo app ID" value="<?php echo esc_attr(get_option('zalo_follow_management_zalo_app_id')); ?>" required>
                                            <small class="form-text text-muted"><span key="View_instructions_app_ID">Xem hướng dẫn lấy ID ứng dụng trên Zalo</span> <a class="text-primary" href="https://developers.zalo.me/apps" key="Here">Tại đây</a></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zalo_app_secret">Zalo app secret</label>
                                            <input type="password" autocomplete="new-password" class="form-control" name="zalo_follow_management_zalo_app_secret" id="zalo_app_secret" placeholder="Enter Zalo app secret" value="<?php echo esc_attr(get_option('zalo_follow_management_zalo_app_secret')); ?>" required>
                                            <small class="form-text text-muted"><span key="View_instructions_secret_key">Xem hướng dẫn lấy khóa bí mật của ứng dụng trên Zalo</span> <a class="text-primary" href="https://developers.zalo.me/apps" key="Here">Tại đây</a></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zalo_access_token">Access token</label>
                                            <input type="password" autocomplete="off" class="form-control" name="zalo_follow_management_zalo_access_token" id="zalo_access_token" placeholder="Enter Access token" value="<?php echo esc_attr(get_option('zalo_follow_management_zalo_access_token')); ?>" required>
                                            <small class="form-text text-muted"><span key="Get_Refresh_token">Lấy mã Access token của bạn</span> <a class="text-primary" href="https://developers.zalo.me/tools/explorer" key="Here">Tại đây</a></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zalo_refresh_token">Refresh token</label>
                                            <input type="password" autocomplete="off" class="form-control" name="zalo_follow_management_zalo_refresh_token" id="zalo_refresh_token" placeholder="Enter Refresh token" value="<?php echo esc_attr(get_option('zalo_follow_management_zalo_refresh_token')); ?>" required>
                                            <small class="form-text text-muted"><span key="Get_Refresh_token">Lấy mã Refresh token của bạn</span> <a class="text-primary" href="https://developers.zalo.me/tools/explorer" key="Here">Tại đây</a></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zalo_callback_url">Callback URL</label>
                                            <input type="text" autocomplete="off" class="form-control" name="zalo_follow_management_zalo_callback_url" id="zalo_callback_url" value="<?php echo esc_attr(home_url().'/wp-json/myplugin/v1/login-zalo'); ?>" readonly>
                                            <small class="form-text text-muted"><span key="Callback_URL">Callback URL là gì ?. Nó được sử dụng như thế nào ?</span> <a class="text-primary" href="#" key="Learn_more">Tìm hiểu thêm</a></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zalo_redirect_url">Redirect URL</label>
                                            <input type="text" autocomplete="off" class="form-control" name="zalo_follow_management_zalo_redirect_url" id="zalo_redirect_url" value="<?php echo esc_attr(home_url().'/shop/'); ?>" readonly>
                                            <small class="form-text text-muted"><span key="Redirect_URL">Redirect URL là gì ?</span> <a class="text-primary" href="#" key="Learn_more">Tìm hiểu thêm</a></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="padding-top: 15px;">
                                        <!--<span>SHORTCODE nút login => [login_zalo] <= Copy SHORTCODE và dán vào bất cứ đâu bạn muốn hiển thị nút Login Zalo</span>-->
                                        <input type="hidden" name="custom_action" value="call_curl_after_save">
                                        <!--<a href="#" class="btn btn-sm btn-secondary" id="check-connect-zalo">Kiểm tra kết nối</a>-->
                                    </div>
                                </div>
                        </div>
                        <!-- Thêm các tab khác tương tự ở đây -->
                    </div>
                   
                    
                    
                    <div class="tab-content" id="content4">
                        <div>
                            <div>
                                <div class="form-group pt-2">
                                    <label for="username">Username:</label>
                                    <input type="password" class="form-control" id="license_username" name="zalo_follow_management_license_username" placeholder="Enter username" value="<?php echo esc_attr(get_option('zalo_follow_management_license_username')); ?>">
                                    <small class="form-text text-muted"><span key="Username">Username là gì ? Lấy nó ở đâu ?</span> <a class="text-primary" href="#" key="Learn_more">Tìm hiểu thêm</a></small>
                                </div>
                                <div class="form-group pt-2 pb-2">
                                    <label for="apikey">API Key:</label>
                                    <input type="password" class="form-control" id="license_apikey" name="zalo_follow_management_license_apikey" placeholder="Enter API Key" value="<?php echo esc_attr(get_option('zalo_follow_management_license_apikey')); ?>">
                                    <small class="form-text text-muted"><span key="API_Key">API Key là gì ? Lấy nó ở đâu ?</span> <a class="text-primary" href="https://zaloconnector.com/pricing/" target="_blank" key="Learn_more">Tìm hiểu thêm</a> | <a class="text-primary" href="#" onclick="openModal()" key="get_free_key">Đăng kí nhận API Key miễn phí</a></small>
                                </div>
                                <!--<input type="hidden" name="custom_action" value="call_curl_after_save">-->
                            </div>
                        </div> 
                        
                    </div>
                    <button type="button" id="save-settings-button" class="btn btn-primary">Save Changes</button>
                    </form>
                     <?php
                        global $wpdb;
                        $total_follower_synchronized = $wpdb->get_results("SELECT COUNT(*) as total FROM `wp_zalo_followers` WHERE wp_zalo_followers.`Follow_Status` = 1 ")[0]->total;
                        
                        $curl = curl_init();
    
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => 'https://openapi.zalo.me/v2.0/oa/getfollowers?data=%20{%22offset%22%3A%200%2C%20%22count%22%3A%205}',
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => '',
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 0,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => 'GET',
                          CURLOPT_HTTPHEADER => array(
                            'access_token: '.get_option('zalo_follow_management_zalo_access_token').''
                          ),
                        ));
                        
                        $response = curl_exec($curl);
                        $result = json_decode($response);
                    function secondsToHMS($seconds) {
                        $hours = floor($seconds / 3600);
                        $minutes = floor(($seconds % 3600) / 60);
                        $seconds = $seconds % 60;
                    
                        return sprintf('%02d h %02d m %02d s', $hours, $minutes, $seconds);
                    }
                    ?>
                    <div class="tab-content" id="content5">
                        <div class="row">
                            <div class="w-75 bg-light" style="padding: 3% !important;">
                                <div class="d-flex flex-row justify-content-between gap-2">
                                    <div class="d-flex flex-row gap-2">
                                        <span class="fs-4 fw-medium d-flex align-items-center" key="Status">Trạng thái:</span>
                                        <div class="d-flex flex-row bg-primary gap-2 py-1 px-2 rounded align-items-center d-none" id="statusSyncFollower">
                                            <div class="spinner-border text-light" role="status">
                                                <span class="visually-hidden"></span>
                                            </div>
                                            <span class="fw-medium text-light" key="syncing">Đang đồng bộ</span>
                                        </div>
                                        <div class="" id="statusNormalFollower">
                                            <div class="bg-secondary rounded text-white d-flex flex-row align-items-center gap-2 px-2">
                                                <div class="fs-4">
                                                    <i class="fa-solid fa-minus"></i>
                                                </div>
                                                <span class="fw-medium text-light" key="waiting">Đang chờ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div><h5 id="total-request" style="color: red">0/3</h5></div>
                                </div>
                                <div class="mt-4">
                                    <span class="text-body-secondary"><span key="synced">Đã đồng bộ</span> <a id='follower_synchronized'></a>/<?php echo $result->data->total ?> follower... (<span key="estimated_sync_time">Thời gian đồng bộ tất cả người theo dõi ước tính:</span> <?php echo secondsToHMS($result->data->total*5) ?>)</span>
                                </div>
                                <div class="d-flex flex-row gap-1 mt-4 p-2" id="progress-follower">
                                    <div id="1" class="bg-secondary p-2 p-2" style='width: 10%; height: 10px'></div>
                                    <div id="2" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                    <div id="3" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                    <div id="4" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                    <div id="5" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                    <div id="6" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                    <div id="7" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                    <div id="8" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                    <div id="9" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                    <div id="10" class="bg-secondary p-2" style='width: 10%; height: 10px'></div>
                                </div>
                                <div class="mt-1 fs-5 d-flex flex-row justify-content-between fw-medium px-2">
                                    <span class="text-body-secondary">0</span>
                                    <span class="text-body-secondary"><?php echo $result->data->total ?></span>
                                </div>
                                <div class="mt-4" style="width: 140px" id="startFollower" onclick="handleStart('startFollower', 'stopFollower', 'statusSyncFollower', 'statusNormalFollower')">
                                    <div class="btn bg-success py-2 px-4 text-light fw-medium rounded">
                                        <i class="fa-solid fa-circle-play"></i>
                                        <span key="begin">BẮT ĐẦU</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-4 gap-4 d-none" id="stopFollower">
                                    <div class="bg-warning py-2 px-4 text-light fw-medium rounded" onclick="handleStop('stopFollower', 'startFollower', 'statusSyncFollower', 'statusNormalFollower')">
                                        <i class="fa-regular fa-circle-stop"></i>
                                        <span key="stop">DỪNG</span>
                                    </div>
                                    <div class="text-danger fw-medium px-3 py-2 rounded align-items-center" style="background-color: #eeeff5;">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <span key="do_not_close_tab_during_sync">Vui lòng không tắt tab khi đang đồng bộ dữ liệu</span>
                                    </div>
                                </div>
                       
                            </div>
                            <div class="w-25 bg-light p-4">
                                <span class="fs-1">?</span>
                                <div class="mt-4">
                                    <p key="sync_data_duration">Quá trình đồng bộ hóa dữ liệu sẽ tốn thời gian và ảnh hưởng đến việc truy cập dữ liệu. Thời gian đồng bộ phụ thuộc vào lượng dữ liệu đồng bộ từ Zalo. Đề xuất quá trình đồng bộ dữ liệu nên được thực hiện vào khoảng thời gian 0:00AM - 4:00AM.</p>
                                    <!--<p>Bật giới hạn đơn vị đồng bộ để thiết lập giới hạn cho mỗi lần sync dữ liệu từ NetSuite. </p>-->
                                    <!--<p>Bật thiết lập hẹn giờ tự động đồng bộ để tự động sync dữ liệu từ NetSuite theo giờ được đặt sẵn.</p>-->
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-content" id="content6">
                        <div>
                            <div>
                                <label key="Select_language">Chọn ngôn ngữ: </label><br>
                                <input type="radio" id="vi" name="fav_language" value="Vi">
                                <label for="vi"><img width="30" height="30" src="https://img.icons8.com/color/30/vietnam.png" alt="vietnam"/> VIETNAM</label><br>
                                <input type="radio" id="en" name="fav_language" value="En">
                                <label for="en"><img width="30" height="30" src="https://img.icons8.com/color/30/usa.png" alt="usa"/> ENGLISH</label><br>
                            </div>
                        </div>      
                    </div>
                    
                    
                </div>
                <script>
                    document.getElementById('vi').addEventListener('change',(e)=>{
                          localStorage.setItem('lang', 'vi');
                          alert("Cập nhật thành công!");
                          location.reload(true);
                    })
                     document.getElementById('en').addEventListener('change',(e)=>{
                          localStorage.setItem('lang', 'en');
                          alert("Update successful!");
                          location.reload(true);
                    })
                    let api_stop = false;
                    let total_follower = <?php if(!empty($result->data->total)) echo $result->data->total; else echo 0;  ?>;
                    let total_follower_synchronized = <?php echo $total_follower_synchronized ?>;
                    let ratio_follower = total_follower/10;
                    document.addEventListener('DOMContentLoaded', () => {
                        if (localStorage.getItem('lang') == 'en'){
                            document.getElementById('en').checked = true
                        }else
                            document.getElementById('vi').checked = true
                        document.getElementById('follower_synchronized').innerHTML = total_follower_synchronized;
                        let lisstChild = document.getElementById('progress-follower');
                        let childDivs = lisstChild.querySelectorAll('div'); 
                        let childDivArray = Array.from(childDivs);
                        for(let i=0; i< total_follower_synchronized/ratio_follower; i++)
                            if(childDivArray[i].classList.contains('bg-secondary') ){
                                childDivArray[i].classList.remove('bg-secondary')
                                childDivArray[i].classList.add('bg-success')
                            }
                    });
                    function handleStartTimer(t){
                        if (!api_stop){
                            document.getElementById('timer-sync').innerHTML = t+'s'
                            setTimeout(function () {
                              handleStartTimer(t + 1);
                            }, 1000);
                        }else
                        {
                            return null
                        }
                    }

                    async function handleStart (id1, id2, id3, id4){
                        
                        api_stop = false;
                        // handleStartTimer(0)
                        let divClickStart = document.getElementById(id1);
                        divClickStart.classList.add("d-none")
                        let divClickStop = document.getElementById(id2);
                        divClickStop.classList.remove('d-none')
                        let statusSync = document.getElementById(id3)
                        statusSync.classList.remove('d-none')
                        let statusNormal = document.getElementById(id4)
                        statusNormal.classList.add('d-none')
                        let lisstChild = '';
                        
                        try {
                            if(id1==='startFollower'){
                                lisstChild = document.getElementById('progress-follower')
                    
                                const url = '../wp-json/zalo-management/v1/sync-Follower';
                                let childDivs = lisstChild.querySelectorAll('div');
                                let childDivArray = Array.from(childDivs);
                
                                while (total_follower_synchronized<total_follower){
                                    if(api_stop)
                                        break;
                                    const response = await fetch(url,{"method": "POST", headers: {"Content-Type": "application/json"}}).then(res => res.json())
                                    total_follower_synchronized = response.count
                                    document.getElementById('follower_synchronized').innerHTML = total_follower_synchronized;
                                    console.log(total_follower_synchronized)
                                    for(let i=0; i< total_follower_synchronized/ratio_follower; i++)
                                        if(childDivArray[i].classList.contains('bg-secondary') ){
                                        childDivArray[i].classList.remove('bg-secondary')
                                        childDivArray[i].classList.add('bg-success')
                                        }
                                }
                                handleStop('stopFollower', 'startFollower', 'statusSyncFollower', 'statusNormalFollower')
                            }
                           
                        } catch (error) {
                            console.log(error);
                            handleStop('stopFollower', 'startFollower', 'statusSyncFollower', 'statusNormalFollower')
                        }
                    }
                    function handleStop (id1, id2, id3, id4){
                        api_stop = true;
                        let divClickStart = document.getElementById(id1);
                        divClickStart.classList.add("d-none")
                        let divClickStop = document.getElementById(id2);
                        divClickStop.classList.remove('d-none')
                        let statusSync = document.getElementById(id3)
                        statusSync.classList.add('d-none')
                        let statusNormal = document.getElementById(id4)
                        statusNormal.classList.remove('d-none')
                    }
                
                    
                    function progress(){
                        let lisstChild = document.getElementById('progress-follower')
                        var childDivs = lisstChild.querySelectorAll('div'); 
                        let childDivArray = Array.from(childDivs);
                        childDivArray.forEach(function(childDiv){
                            if(childDiv.classList.contains('bg-success')){
                                childDiv.classList.remove('bg-success')
                                childDiv.classList.add('bg-secondary')
                            }
                        })
                    }
                
                </script>
                
                
                
            </div> <!-- end row-->
        </div>
    </div> <!-- end card-box-->
    <div class="row">
        <footer class="content-footer footer bg-footer-theme">
            <div class="d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made by
                  <a href="https://mekong-connector.com/" target="_blank" class="footer-link fw-medium">Mekong Connector</a>
                </div>
                <div class="d-none d-lg-inline-block">
                  <a href="https://zaloconnector.com/pricing/" class="footer-link me-4" target="_blank">License</a>
                  <!--<a href="#" target="_blank" class="footer-link me-4">More Themes</a>-->
        
                  <a
                    href="https://zaloconnector.com/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >
        
                  <a
                    href="https://zaloconnector.com/contact"
                    target="_blank"
                    class="footer-link me-5"
                    >Support</a
                  >
                </div>
            </div>
        </footer>
    </div>
    <script>
        <?php $apikey02= get_option('zalo_follow_management_license_username'); ?>
        var apiUrl = "/wp-json/zalo-management/v1/check_license_key";
        var licenseKey = "<?php if(!empty($apikey02)) echo $apikey02; else echo "null"; ?>";
        var totalRequestElement = $("#total-request");
        jQuery.ajax({
            type: "GET",
            url: apiUrl + "?license_key=" + licenseKey,
            success: function (response) {
                console.log(response);
                if (response.statusCode === 200) {
                    if (response.remaining === 0) {
                        totalRequestElement.text(response.message);
                    } else {
                        totalRequestElement.text(response.requested + "/" + response.total);
                    }
                } else if (response.statusCode === 400) {
                    totalRequestElement.text(response.message);
                } else {
                    totalRequestElement.text("Unknown error");
                }
            },
            error: function (error) {
                
            }
        });
    </script>
    <script>
        // JavaScript để hiển thị và điều khiển modal
        function openModal() {
            var modal = document.getElementById('cus_registrationModal');
            modal.style.display = 'flex';
        }
        
        function closeModal() {
            var modal = document.getElementById('cus_registrationModal');
            modal.style.display = 'none';
        }
        
        // JavaScript để xử lý đăng ký
        function register() {
            var fullName = document.getElementById('cus_fullName').value;
            var companyName = document.getElementById('cus_companyName').value;
            var phoneNumber = document.getElementById('cus_phoneNumber').value;
            var email = document.getElementById('cus_email').value;
    
            var api_url = '/wp-json/zalo-management/v1/submit-register-from';
            var data = {
                email: email,
                fullname: fullName,
                company: companyName,
                phone: phoneNumber
            };
        
            jQuery.ajax({
                url: api_url,
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function(response) {
                    var register_from_response_object = JSON.parse(response);
                    if (register_from_response_object.statusCode === 200) {
                       alert("Registration successful. Please check your email. If you don't see the email in your inbox, please check your spam folder.");
                    } else {
                        alert("Erro: " + register_from_response_object.message +". Please check and try again");
                    }
                },
                error: function(error) {
                    console.error(error);
                    // alert("Erro: " + error +". Please check and try again");
                }
            });
            
            closeModal();
        }
        window.addEventListener('click', function (event) {
            var modal = document.getElementById('cus_registrationModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
        // Ẩn modal khi trang tải lên
        var modal = document.getElementById('cus_registrationModal');
        modal.style.display = 'none';
    </script>
    <script>
        // Lấy danh sách tabs và nội dung
        var tabs = document.querySelectorAll('.custom-tab');
        var tabContents = document.querySelectorAll('.tab-content');

        // Bắt sự kiện khi người dùng click vào tab
        tabs.forEach(function(tab, index) {
            tab.addEventListener('click', function() {
                // Loại bỏ lớp active từ tất cả các tab và nội dung
                tabs.forEach(function(item) {
                    item.classList.remove('active');
                });
                tabContents.forEach(function(content) {
                    content.classList.remove('active');
                });

                // Thêm lớp active vào tab và nội dung tương ứng
                tab.classList.add('active');
                tabContents[index].classList.add('active');
                const saveButton = document.getElementById('save-settings-button');
                if (tab.textContent.includes('ZNS') || tab.textContent.includes('Sync follower') || tab.textContent.includes('Language')) {
                    // Ẩn nút "Save Settings"
                    saveButton.style.display = 'none';
                } else {
                    // Hiện nút "Save Settings"
                    saveButton.style.display = 'block';
                }
                
                
            });
        });
    </script>
    <script>
        jQuery(document).ready(function($) {
            $('#check-connect-zalo').on('click', function(e) {
                e.preventDefault();
    
                // Lấy các giá trị từ các trường input
                var secretKey = $('#zalo_app_secret').val();
                var refreshKey = $('#zalo_refresh_token').val();
                var appId = $('#zalo_app_id').val();
    
                // Gửi yêu cầu AJAX đến máy chủ
                $.ajax({
                    type: 'POST',
                    url: '#', 
                    data: {
                        action: 'check_zalo_connection', // Tên action mà bạn đã đăng kí với add_action
                        secret_key: secretKey,
                        refresh_token: refreshKey,
                        app_id: appId,
                    },
                    success: function(response) {
                        console.log(response.data);
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        // Chọn nút lưu cài đặt
        const saveButton = document.getElementById("save-settings-button");
        
        if (saveButton) {
            saveButton.addEventListener("click", function () {
                // Lấy các giá trị từ form
                // const zaloAppId = document.getElementById("zalo_app_id").value;
                // const zaloAppSecret = document.getElementById("zalo_app_secret").value;
                // const zaloAccessToken = document.getElementById("zalo_access_token").value;
                // const zaloRefreshToken = document.getElementById("zalo_refresh_token").value;
                // const callback_url = document.getElementById("zalo_callback_url").value;
                // const redirect_url = document.getElementById("zalo_redirect_url").value;
                // const license_user_name = document.getElementById("license_username").value;
                // const license_api_key = document.getElementById("license_apikey").value;
                // const webhook_api_key = document.getElementById("zalo_follow_management_webhook_apikey").value;
                // const webhook_user_name = document.getElementById("zalo_follow_management_webhook_username").value;
                // const _wc_consumer_key = document.getElementById("zalo_follow_management_woocommerce_consumer_key").value;
                // const _wc_consumer_secret = document.getElementById("zalo_follow_management_woocommerce_consumer_secret").value;
                // const _user_name_chatbot = document.getElementById("zalo_follow_management_user_name_chatbot_ai").value;
                // const _key_chatbot = document.getElementById("zalo_follow_management_key_chatbot_ai").value;
                let zaloAppId = document.getElementById("zalo_app_id") ? document.getElementById("zalo_app_id").value : "default";
                const zaloAppSecret = document.getElementById("zalo_app_secret") ? document.getElementById("zalo_app_secret").value : "default";
                const zaloAccessToken = document.getElementById("zalo_access_token") ? document.getElementById("zalo_access_token").value : "default";
                const zaloRefreshToken = document.getElementById("zalo_refresh_token") ? document.getElementById("zalo_refresh_token").value : "default";
                const callback_url = document.getElementById("zalo_callback_url") ? document.getElementById("zalo_callback_url").value : "default";
                const redirect_url = document.getElementById("zalo_redirect_url") ? document.getElementById("zalo_redirect_url").value : "default";
                const license_user_name = document.getElementById("license_username") ? document.getElementById("license_username").value : "default";
                const license_api_key = document.getElementById("license_apikey") ? document.getElementById("license_apikey").value : "default";
                const webhook_api_key = document.getElementById("zalo_follow_management_webhook_apikey") ? document.getElementById("zalo_follow_management_webhook_apikey").value : "default";
                const webhook_user_name = document.getElementById("zalo_follow_management_webhook_username") ? document.getElementById("zalo_follow_management_webhook_username").value : "default";
                const _wc_consumer_key = document.getElementById("zalo_follow_management_woocommerce_consumer_key") ? document.getElementById("zalo_follow_management_woocommerce_consumer_key").value : "default";
                const _wc_consumer_secret = document.getElementById("zalo_follow_management_woocommerce_consumer_secret") ? document.getElementById("zalo_follow_management_woocommerce_consumer_secret").value : "default";
                const _user_name_chatbot = document.getElementById("zalo_follow_management_user_name_chatbot_ai") ? document.getElementById("zalo_follow_management_user_name_chatbot_ai").value : "default";
                const _key_chatbot = document.getElementById("zalo_follow_management_key_chatbot_ai") ? document.getElementById("zalo_follow_management_key_chatbot_ai").value : "default";
                if (zaloAppId === "") {
                    zaloAppId = "default";
                }
                // Tạo đối tượng dữ liệu để gửi lên server
                const data = {
                    zaloappid: zaloAppId,
                    zaloappsecret: zaloAppSecret,
                    accesstoken: zaloAccessToken,
                    refreshtoken: zaloRefreshToken,
                    callbackurl: callback_url,
                    redirecturl: redirect_url,
                    license_username: license_user_name,
                    license_apikey: license_api_key,
                    webhook_apikey: webhook_api_key,
                    webhook_username: webhook_user_name,
                    wc_consumer_key: _wc_consumer_key,
                    wc_consumer_secret: _wc_consumer_secret,
                    chatbot_username: _user_name_chatbot,
                    chatbot_key: _key_chatbot
                };
                // Sử dụng Fetch API để gọi API
                fetch("/wp-json/zalo-management/v1/save-settings", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                })
                    .then((response) => response.json())
                    .then((apiResult) => {
                        // Xử lý kết quả trả về từ API (ví dụ: hiển thị thông báo)
                        alert("Lưu cài đặt thành công!");
                    })
                    .catch((error) => {
                        console.error("Lỗi khi gọi API: " + error);
                    });
                });
            }
        });
    </script>
    <?php
}
function register_save_setting_rest_endpoint() {
    register_rest_route('zalo-management/v1', '/save-settings', array(
        'methods' => 'POST',
        'callback' => 'save_setting_to_aws',
    ));
    register_rest_route('zalo-management/v1', '/sync-follower', array(
        'methods' => 'POST',
        'callback' => 'sync_folower_zalo',
    ));
}
add_action('rest_api_init', 'register_save_setting_rest_endpoint');

function sync_folower_zalo() {

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://webhook.mekong-connector.com/sync-zalo-follower',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{"app_id":"'.get_option('zalo_follow_management_zalo_app_id').'"}',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'x-api-key: '.get_option('zalo_follow_management_license_apikey').''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    return json_decode($response);
}

function save_setting_to_aws($request) {
    // Thực hiện cuộc gọi cURL ở đây
    $api_url = 'https://webhook.mekong-connector.com/zalo-connect-settings';
    $hostname=get_site_url();
    $data = json_decode($request->get_body(), true);
    // Nếu đã có một ID trước đó (lần đầu không có), hãy thêm ID vào dữ liệu
    $previous_id = esc_attr(get_option('zalo_follow_management_tracking_id'));
    if ($previous_id) {
        $data['trackingid'] = $previous_id;
    }
    $data['hostname'] = $hostname;
    $data['iphost'] = $_SERVER['SERVER_ADDR'];
    $data['databasename'] = DB_NAME;
    $data['usernamedb'] = DB_USER;
    $data['passworddb'] = DB_PASSWORD;
    // Chuyển đổi dữ liệu thành chuỗi JSON
    $json_data = json_encode($data);
    // Tạo một đối tượng cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    // Thêm tiêu đề HTTP cho yêu cầu
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    // Thực hiện cuộc gọi API và lấy kết quả
    $response = curl_exec($ch);
    // die();
    // Kiểm tra lỗi cURL
    if (curl_errno($ch)) {
        echo 'Lỗi cURL: ' . curl_error($ch);
    }
    curl_close($ch);
    // Xử lý kết quả từ API (ví dụ: lưu ID trả về từ API)
    $api_result = json_decode($response, true);
    // return $api_result;
    // Kiểm tra và lưu ID nếu nó đã được trả về từ API
    if (isset($api_result['item']['trackingid'])) {
        $tracking_id=$api_result['item']['trackingid'];
        update_option('zalo_follow_management_tracking_id',$tracking_id );
        // Cập nhật giá trị của mỗi setting từ dữ liệu data
        if($data["zaloappid"]=="default")
            update_option('zalo_follow_management_zalo_app_id', "");
        else 
            update_option('zalo_follow_management_zalo_app_id', $data["zaloappid"]);
        update_option('zalo_follow_management_zalo_app_secret', $data['zaloappsecret']);
        update_option('zalo_follow_management_zalo_access_token', $data['accesstoken']);
        update_option('zalo_follow_management_zalo_refresh_token', $data['refreshtoken']);
        update_option('zalo_follow_management_zalo_callback_url', $data['callbackurl']);
        update_option('zalo_follow_management_zalo_redirect_url', $data['redirecturl']);
        update_option('zalo_follow_management_webhook_url', $data['webhook_url']);
        update_option('zalo_follow_management_webhook_username', $data['webhook_username']);
        update_option('zalo_follow_management_webhook_apikey', $data['webhook_apikey']);
        update_option('zalo_follow_management_license_username', $data['license_username']);
        update_option('zalo_follow_management_license_apikey', $data['license_apikey']);
        update_option('zalo_follow_management_woocommerce_consumer_key', $data['wc_consumer_key']);
        update_option('zalo_follow_management_woocommerce_consumer_secret', $data['wc_consumer_secret']);
        update_option('zalo_follow_management_user_name_chatbot_ai', $data['chatbot_username']);
        update_option('zalo_follow_management_key_chatbot_ai', $data['chatbot_key']);
        return 1;
    }
}


// bắt đầu các trang chiến dịch quảng cáo
// Trang thiết lập zns
function marketing_setup_page() {
    global $wpdb;   
   
    $table_name_tag = $wpdb->prefix . 'tags'; 
    $table_name_customertag = $wpdb->prefix . 'customer_tag';
    $table_name_marketingcampaign = $wpdb->prefix . 'marketingcampaign';
    $table_name_schedulesendingv2 = $wpdb->prefix . 'schedulesendingv2';
    $table_name_customertoken = $wpdb->prefix. 'customer_token';

    $charset_collate = $wpdb->get_charset_collate();


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name_customertag'") != $table_name_customertag){
            $sql = "
            CREATE TABLE $table_name_customertag (
            id INT NOT NULL AUTO_INCREMENT,
            fkCustomer INT(11) NOT NULL,
            fkTag INT(11) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            ) $charset_collate;";
            // echo $sql;
            dbDelta($sql);
        }
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name_marketingcampaign'") != $table_name_marketingcampaign ){
            $sql = "
                CREATE TABLE `wp_marketingcampaign` (
                `PrimaryKey` int(10) NOT NULL COMMENT 'Unique identifier of each record in this table' AUTO_INCREMENT,
                `CreationTimestamp` timestamp NULL DEFAULT NULL COMMENT 'Date and time each record was created',
                `CreatedBy` int(10) DEFAULT NULL COMMENT 'Account name of the user who created each record',
                `ModificationTimestamp` timestamp NULL DEFAULT NULL,
                `ModifiedBy` int(10) DEFAULT NULL COMMENT 'Account name of the user who last modified each record',
                `fkCustomer` int(10) DEFAULT NULL,
                `Name` varchar(200) DEFAULT NULL,
                `Code` varchar(200) DEFAULT NULL,
                `isActive` int(10) DEFAULT NULL,
                `fkSampleOrder` int(10) DEFAULT NULL,
                `fkBranch` int(10) DEFAULT NULL,
                `fkEmployee` int(10) DEFAULT NULL,
                `SalesTarget` int(10) DEFAULT NULL COMMENT 'Mục tiêu chiến dịch',
                `StartDate` timestamp NULL DEFAULT NULL,
                `EndDate` timestamp NULL DEFAULT NULL,
                `SendType` int(10) DEFAULT NULL COMMENT '0: Zalo OA, 1: Zalo ZNS, 2: SMS',
                `CurrentRevenue` int(10) DEFAULT NULL COMMENT 'Doanh thu hiện tại từ chiến dịch',
                `Poster` varchar(255) DEFAULT NULL,
                `Files` varchar(255) DEFAULT NULL,
                `RepeatType` int(10) DEFAULT NULL,
                `RepeatOn` text DEFAULT NULL COMMENT 'gửi vào thứ mấy trong tuần ',
                `RepeatDate` timestamp NULL DEFAULT NULL COMMENT 'Nếu là hằng tháng hoặc hằng năm thì gửi vào ngày giờ này',
                `Content` text DEFAULT NULL,
                `Parameter` text DEFAULT NULL,
                `Status` int(10) DEFAULT NULL,
                `fkDeclareTemplate` int(10) DEFAULT NULL,
                `RepeatTime` time DEFAULT NULL,
                `RepeatDay` int(10) DEFAULT NULL,
                `RepeatMonth` int(10) DEFAULT NULL,
                `fkRegion` int(10) DEFAULT NULL,
                `arrRegion` text DEFAULT NULL,
                `arrBranch` text DEFAULT NULL,
                `arrCustomer` text DEFAULT NULL,
                `Description` text DEFAULT NULL,
                `Budget` int(10) DEFAULT NULL,
                `UUID` varchar(200) DEFAULT NULL,
                `fkPromotion` int(10) DEFAULT NULL,
                `Title` varchar(200) DEFAULT NULL,
                `JsonResult` text DEFAULT NULL,
                `PosterUrl` text DEFAULT NULL,
                `CountSending` int(10) DEFAULT NULL,
                `fkTag` int(10) DEFAULT NULL,
                `isShowClient` int(10) DEFAULT NULL,
                `arrTag` text DEFAULT NULL,
                `SendTime` time DEFAULT NULL,
                `SendDate` date DEFAULT NULL,
                `SearchField` text DEFAULT NULL, 
                PRIMARY KEY (`PrimaryKey`)
            ) $charset_collate;";
            dbDelta($sql);
        }
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name_tag'") != $table_name_tag){
            $sql = "
                CREATE TABLE `wp_tags` (
                    id INT NOT NULL AUTO_INCREMENT,
                    Name VARCHAR(100) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                ) $charset_collate;";
             dbDelta($sql);
        }
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name_schedulesendingv2'") != $table_name_schedulesendingv2){
            $sql = "
                CREATE TABLE `wp_schedulesendingv2` (
                    `PrimaryKey` int(10) NOT NULL AUTO_INCREMENT,
                    `CreationTimestamp` timestamp NULL DEFAULT NULL,
                    `CreatedBy` int(10) DEFAULT NULL,
                    `ModificationTimestamp` timestamp NULL DEFAULT NULL,
                    `ModifiedBy` int(10) DEFAULT NULL,
                    `Status` int(10) DEFAULT NULL,
                    `isActive` int(10) DEFAULT NULL,
                    `Link` varchar(255) DEFAULT NULL,
                    `SendDate` date DEFAULT NULL,
                    `SendTime` time DEFAULT NULL,
                    `Content` text DEFAULT NULL,
                    `fkSampleOrder` int(10) DEFAULT NULL,
                    `fkMarketingCampaign` int(10) DEFAULT NULL,
                    `fkCustomer` int(10) DEFAULT NULL,
                    `Code` varchar(200) DEFAULT NULL,
                    `SampleOrderLink` varchar(255) DEFAULT NULL,
                    `UUID` varchar(200) DEFAULT NULL,
                    `Title` varchar(200) DEFAULT NULL,
                    `PosterUrl` varchar(255) DEFAULT NULL,
                    `JsonResultPromotion` varchar(200) DEFAULT NULL,
                    `isShowClient` int(10) DEFAULT NULL,
                    `SearchField` text DEFAULT NULL,
                    PRIMARY KEY (`PrimaryKey`)
                    ) $charset_collate;";
                dbDelta($sql);
        }
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name_customertoken'") != $table_name_customertoken){
            $sql = "
            CREATE TABLE $table_name_customertoken (
                `PrimaryKey` int(10) NOT NULL AUTO_INCREMENT,
                `CreationTimestamp` timestamp NULL DEFAULT NULL,
                `CreatedBy` int(10) DEFAULT NULL,
                `ModificationTimestamp` timestamp NULL DEFAULT NULL,
                `ModifiedBy` int(10) DEFAULT NULL,
                `fkCustomer` int(10) DEFAULT NULL,
                `token` varchar(200) DEFAULT NULL,
                `expireEpoch` int(10) DEFAULT NULL,
                `sendLink` varchar(200) DEFAULT NULL,
                `activityHistory` text DEFAULT NULL,
                `isActive` int(10) DEFAULT NULL,
                PRIMARY KEY (`PrimaryKey`)
                ) $charset_collate;";
            dbDelta($sql);
        }
    }
    //nếu bảng chưa tồn tại thì mới hiển thị nút tạo csdl, nếu có rồi thì hiển thị thông báo là đã có rồi
    if( 
        $wpdb->get_var("SHOW TABLES LIKE '$table_name_tag'") != $table_name_tag || 
        $wpdb->get_var("SHOW TABLES LIKE '$table_name_customertag'") != $table_name_customertag || 
        $wpdb->get_var("SHOW TABLES LIKE '$table_name_marketingcampaign'") != $table_name_marketingcampaign ||  
        $wpdb->get_var("SHOW TABLES LIKE '$table_name_schedulesendingv2'") != $table_name_schedulesendingv2 ||
        $wpdb->get_var("SHOW TABLES LIKE '$table_name_customertoken'") != $table_name_customertoken
    )
        {
        // Hiển thị nội dung trang "Thiết lập"
            echo '<div class="wrap">';
            echo '<h2>Thiết lập Plugin Quản lý Người theo dõi</h2>';
            echo '<form method="post">';
            echo '<p>Nhấn nút dưới đây để tạo bảng CSDL:</p>';
            echo '<input type="submit" name="create_table" class="button button-primary" value="Tạo bảng CSDL">';
            echo '</form>';
            echo '</div>';
        }
    else{
        echo '<div class="updated"><p><strong>Thiết lập csdl đã hoàn tất !!!</strong></p></div>';
    }
     ?>  
        <h3>Thiết lập template zns</h3>
        <div class="row">
            <div class="card col-4 m-4">
                <div class="card-body">
                    <img src="https://soadmin.matkinhantai.com/assets/images/logo.png" alt="" height="32" style="margin-bottom: 12px;">
                    <p style="font-weight: bold;">kinh chào {customer_name}</p>
                    <p style="margin-bottom: 12px;">cảm ơn bạn đã mũa sản phẩm <a class="" style="font-weight: bold; color: black; text-decoration: none;">{product_name}</a>
                        theo đơn hàng <a style="font-weight: bold; color: black; text-decoration: none;">{order_number}</a>, ngày <a style="font-weight: bold; color: black; text-decoration: none;">{order_date}</a> tại cửa hàng của chúng tôi. </br>
                        </br>
                        Chân thành cảm ơn bạn đã tin tưởng và lựa chọn sản phẩm của Mắt Kính An Tài. Xin vui lòng bấm Xem Chi Tiết để xem điểm tích lũy của bạn.
                        </br> </br>
                        Trân trọng
                        </br> </br>
                        An Tai OPTIC
                    </p>
                    <button class="btn btn-primary w-100">Xem chi tiết</button>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Áp dụng</button>
                </div>
            </div
        </div>
    <?php
  
}
// 
function marketing_management_page() {
    require_once('page/marketing/index.php');
}
function marketing_dashboard_page(){
    require_once('page/dashboard/index.php');
}


// trang gửi thông báo chiến dịch
function send_calendar_page(){
    session_start();
    if (isset($_GET['ids'])) {
        global $wpdb;
        $ids = $_GET['ids'];
        $errors = [];
        try{
            foreach(explode(",", $ids) as $id){
                // $id = $_GET['id'];
                $data = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}schedulesendingv2` WHERE PrimaryKey = $id")[0];
                $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
                $date_now = new DateTime('now', $timezone);
                $token = bin2hex(random_bytes(30));
                if($data->isShowClient){
                    $sendLink = "https://shop.matkinhantai.com/token/".$token."?url=marketing/detail/".$data->CampaignKey;
                }else {
                    $sendLink = "https://shop.matkinhantai.com/token/".$token;
                }
                // echo 'aaa';
                $expires = (int)$app->ExpiresEpoch;
                $expireEpoch = $date_now->modify("+$expires hours");
                // Thêm thông tin token vào bảng customer_token;
                $createTokenQuery = $wpdb->prepare(
                "INSERT INTO {$wpdb->prefix}customer_token (fkCustomer, token, isActive, expireEpoch, sendLink)
                VALUES (%d, %s, %d, %s, %s)",
                $data->fkCustomer,
                $token,
                1, // isActive value
                $expireEpoch,
                $sendLink
                )  ;
                $result = $wpdb->query($createTokenQuery);

                // Call Api gửi tin qua Zalo OA
                $marketing = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}marketingcampaign` WHERE UUID = '$data->UUID'")[0];

                $user_id = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}zalo_followers WHERE fk_wc_customer_id = $data->fkCustomer")[0]->Zalo_ID;
                $headers = [
                    'X-header' => 'value',
                    'Content-Type'=> 'application/json'
                ];

                $apiURL = 'https://webhook.mekong-connector.com/sendnotify';

                $postInput = [
                    "app_id" => get_option('zalo_follow_management_zalo_app_id'),
                    "user_id" => $user_id,
                    "message" => $data->Content,
                    "message_photo" => $data->PosterUrl,
                    "url" => $data->Link,
                    "customer-id"=>$data->fkCustomer,
                    "start-date"=>$marketing->StartDate,
                    "end-date"=>$marketing->EndDate,
                    "title" => $data->Title,
                ];
                
                $curl = curl_init($apiURL);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postInput));
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-header: value', 'x-api-key: '.get_option('zalo_follow_management_license_apikey').''));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($curl);
                $getBody = json_decode($result)->body;
         
                if ($getBody->error!=0) {
                    $schedule_sending_status = 5;
                    $update_schedulesendingv2 ="UPDATE {$wpdb->prefix}schedulesendingv2 SET {$wpdb->prefix}schedulesendingv2.Status = '$schedule_sending_status' WHERE PrimaryKey = $id";
                    // echo $update_schedulesendingv2;
                    $save = $wpdb->query($update_schedulesendingv2);
                    $errors[] = $id;
                } else {
                    $schedule_sending_status = 1;
                    $update_schedulesendingv2 ="UPDATE {$wpdb->prefix}schedulesendingv2 SET {$wpdb->prefix}schedulesendingv2.Status = '$schedule_sending_status' WHERE PrimaryKey = $id ";
                    // echo $update_schedulesendingv2;
                    $save = $wpdb->query($update_schedulesendingv2);
                }
       
            }

            if($errors == null){
                $_SESSION['success'] = "Mẫu tin quảng cáo đã được gửi thành công!";
                header('Location: ' .admin_url('admin.php?page=marketing-calendar&m='.$data->UUID));
            }else{
                $notify = "Mẫu tin có mã ";
                foreach($errors as $error){
                    $notify .= $error.", ";
                }
                $_SESSION['error'] = $notify." chưa được gửi vui lòng kiểm tra lại!";
                header('Location: ' .admin_url('admin.php?page=marketing-calendar&m='.$data->UUID));
            }
        } catch (Exception  $e){
            $_SESSION['warning'] = "Khách hàng chưa theo dõi ZALO OA, xin vui lòng kiểm tra lại!" ;
            header('Location: ' .admin_url('admin.php?page=marketing-calendar&m='.$data->UUID));
        };
    }
    
}
// trang hủy thông báo
function active_calendar_page(){
    session_start();
    global $wpdb;
    if(isset($_GET['ids'])){
        $ids = $_GET['ids'];
        $errors = [];
        foreach (explode(",", $ids) as $id){
            $update_schedulesendingv2 ="UPDATE {$wpdb->prefix}schedulesendingv2 SET Status = '4' WHERE PrimaryKey = '$id'";
            $save = $wpdb->query($update_schedulesendingv2);
            if (!$save){
                $errors[] = $id;
            }
        }
        if($errors == null){
            $_SESSION['success'] = "Hủy lịch thành công!";
            header("Location: ".$_SERVER['HTTP_REFERER']."");
        }else{
            $notify = "Mẫu tin có mã ";
            foreach($errors as $error){
                $notify .= $error.", ";
            }
            $_SESSION['error'] = $notify." Hủy không thành công!";
            header("Location: ".$_SERVER['HTTP_REFERER']."");
        }
    }
}
function delete_calendar_page(){
    session_start();
    global $wpdb;
    if(isset($_GET['ids'])){
        $ids = $_GET['ids'];
        $errors = [];
        foreach (explode(",", $ids) as $id){
            $delete_schedulesendingv2 ="DELETE FROM {$wpdb->prefix}schedulesendingv2 WHERE PrimaryKey = '$id'";
            $delete = $wpdb->query($delete_schedulesendingv2);
            if (!$delete){
                $errors[] = $id;
            }  
        }
        if($errors == null){
            $_SESSION['success'] = "Xóa lịch thành công!";
            header("Location: ".$_SERVER['HTTP_REFERER']."");
        }else{
            $notify = "Mẫu tin có mã ";
            foreach($errors as $error){
                $notify .= $error.", ";
            }
            $_SESSION['error'] = $notify." Xóa không thành công!";
            header("Location: ".$_SERVER['HTTP_REFERER']."");
        }
    }
}
// kết thúc trang chiến dịch quảng cáo


// Đăng ký các trường cài đặt cho plugin
function register_zalo_follow_management_settings() {
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_zalo_app_id');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_zalo_app_secret');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_zalo_access_token');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_zalo_refresh_token');
    
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_zalo_callback_url');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_zalo_redirect_url');
    
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_webhook_url');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_webhook_username');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_webhook_apikey');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_license_username');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_license_apikey');
    register_setting('zalo-follow-management-settings-group-reserved-for-tracking-id', 'zalo_follow_management_tracking_id');
    
    
    register_setting('zalo-follow-management-settings-group-active-notification-order-template', 'zalo_follow_management_active_notification_order_template');
    register_setting('zalo-follow-management-settings-group-active-notification-promotion-template', 'zalo_follow_management_active_notification_promotion_template');
    register_setting('zalo-follow-management-settings-group-auto-send-transaction-message-from-order', 'zalo_follow_management_auto_send_transaction_message_from_order');
    register_setting('zalo-follow-management-settings-group-auto-send-transaction-message-from-promotion', 'zalo_follow_management_auto_send_transaction_message_from_promotion');
    
    
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_woocommerce_consumer_key');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_woocommerce_consumer_secret');
    
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_user_name_chatbot_ai');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_key_chatbot_ai');
    register_setting('zalo-follow-management-settings-group', 'zalo_follow_management_chatbot_ai_status');
    add_option('zalo_follow_management_chatbot_ai_status', 'false');
}
add_action('admin_init', 'register_zalo_follow_management_settings');

// Đăng ký một endpoint API để update cài đặt Notification Center
function custom_api_init_active_and_auto_send_transaction_message_from_order() {
    register_rest_route('zalo-management/v1', '/update-settings-notification-center-from_order-callback', array(
        'methods' => 'POST',
        'callback' => 'update_settings_active_and_auto_send_transaction_message_from_order_callback',
    ));
}

add_action('rest_api_init', 'custom_api_init_active_and_auto_send_transaction_message_from_order');

function update_settings_active_and_auto_send_transaction_message_from_order_callback($request) {
    $params = $request->get_json_params();
    if (isset($params['isOrderNotificationEnabled']) && isset($params['isAutoSendTransactionEnabled'])) {
        $isOrderNotificationEnabled = $params['isOrderNotificationEnabled'];
        $isAutoSendTransactionEnabled = $params['isAutoSendTransactionEnabled'];
        update_option('zalo_follow_management_active_notification_order_template', $isOrderNotificationEnabled);
        update_option('zalo_follow_management_auto_send_transaction_message_from_order', $isAutoSendTransactionEnabled);
        global $wpdb;
        $table_name = $wpdb->prefix . 'define_templates_zns';
        $types_to_update = array('order-confirm', 'payment-confirm', 'order-status', 'order-review');
        foreach ($types_to_update as $type) {
            $wpdb->update(
                $table_name,
                array(
                    'active' => $isOrderNotificationEnabled,
                    'auto_send_transaction_message' => $isAutoSendTransactionEnabled,
                ),
                array('type' => $type),
                array('%d', '%d'),
                array('%s')
            );
        }
        $response = array('message' => 'Settings updated successfully.');
        return rest_ensure_response($response);
    } else {
        $response = array('message' => 'Invalid data.');
        return rest_ensure_response($response);
    }
}
//Đăng ký một endpoint lưu cài đặt thông báo khuyến mãi
function custom_api_init_active_and_auto_send_transaction_message_from_promotion() {
    register_rest_route('zalo-management/v1', '/update-settings-notification-center-from_promotion-callback', array(
        'methods' => 'POST',
        'callback' => 'update_settings_active_and_auto_send_transaction_message_from_promotion_callback',
    ));
}

add_action('rest_api_init', 'custom_api_init_active_and_auto_send_transaction_message_from_promotion');

function update_settings_active_and_auto_send_transaction_message_from_promotion_callback($request) {
    $params = $request->get_json_params();
    if (isset($params['isPromotionNotificationEnabled']) && isset($params['isAutoSendTransactionEnabled'])) {
        $isPromotionNotificationEnabled = $params['isPromotionNotificationEnabled'];
        $isAutoSendTransactionEnabled = $params['isAutoSendTransactionEnabled'];
        update_option('zalo_follow_management_active_notification_promotion_template', $isPromotionNotificationEnabled);
        update_option('zalo_follow_management_auto_send_transaction_message_from_promotion', $isAutoSendTransactionEnabled);
        global $wpdb;
        $table_name = $wpdb->prefix . 'define_templates_zns';
        $types_to_update = array('campaign', 'bonus-points');
        foreach ($types_to_update as $type) {
            $wpdb->update(
                $table_name,
                array(
                    'active' => $isPromotionNotificationEnabled,
                    'auto_send_transaction_message' => $isAutoSendTransactionEnabled,
                ),
                array('type' => $type),
                array('%d', '%d'),
                array('%s')
            );
        }
        $response = array('message' => 'Settings updated successfully.');
        return rest_ensure_response($response);
    } else {
        $response = array('message' => 'Invalid data.');
        return rest_ensure_response($response);
    }
}

// Hàm callback cho API cập nhật giá trị setting
function update_zalo_setting_callback($request) {
    $app_id = $request->get_param('zalo_app_id');
    $app_secret = $request->get_param('zalo_app_secret');
    $access_token = $request->get_param('zalo_access_token');
    $refresh_token = $request->get_param('zalo_refresh_token');

    update_option('zalo_follow_management_zalo_app_id', $app_id);
    update_option('zalo_follow_management_zalo_app_secret', $app_secret);
    update_option('zalo_follow_management_zalo_access_token', $access_token);
    update_option('zalo_follow_management_zalo_refresh_token', $refresh_token);

    return new WP_REST_Response('Settings updated', 200);
}

// Đăng ký route cho API cập nhật
add_action('rest_api_init', function () {
    register_rest_route('zalo-settings-management-api/v1', '/update', array(
        'methods' => 'POST',
        'callback' => 'update_zalo_setting_callback',
    ));
});

// Hàm callback cho API lấy dữ liệu setting
function get_zalo_setting_callback() {
    $settings = array(
        'zalo_app_id' => get_option('zalo_follow_management_zalo_app_id'),
        'zalo_app_secret' => get_option('zalo_follow_management_zalo_app_secret'),
        'zalo_access_token' => get_option('zalo_follow_management_zalo_access_token'),
        'zalo_refresh_token' => get_option('zalo_follow_management_zalo_refresh_token'),
    );

    return new WP_REST_Response($settings, 200);
}

// Đăng ký route cho API lấy dữ liệu
add_action('rest_api_init', function () {
    register_rest_route('zalo-settings-management-api/v1', '/get', array(
        'methods' => 'GET',
        'callback' => 'get_zalo_setting_callback',
    ));
});
//ĐĂNG KÍ API ĐỂ QUẢN LÝ TIN NHẮN TIN CỦA KHÁCH HÀNG, NHẬN TIN BẰNG WEBHOOK -- by minh 
function custom_api_send_message_route() {
    register_rest_route('zalo-management/v1', '/WhenUserInbox', array(
        'methods' => 'POST',
        'callback' => 'when_user_inbox',
    ));
    register_rest_route('zalo-management/v1', '/WhenOAInbox', array(
        'methods' => 'POST',
        'callback' => 'when_oa_inbox',
    ));
    register_rest_route('zalo-management/v1', '/GetMessage', array(
        'methods' => 'GET',
        'callback' => 'get_message_inbox',
    ));
}

add_action('rest_api_init', 'custom_api_send_message_route');
function get_message_inbox($request){
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $sql =  $wpdb->prepare("SELECT * FROM `wp_message_zalo` WHERE User_id_zalo = '$user_id' OR SendTo = '$user_id' ORDER BY create_at ASC");
    $messages = $wpdb->get_results($sql, ARRAY_A);
    return $messages;
}

function when_user_inbox($request){
    global $wpdb;
    $user_id_zalo = $request->get_param('user_id_zalo');
    $user_id_by_app = $request->get_param('user_id_by_app');
    $message_type = $request->get_param('message_type');
    $content = $request->get_param('content');
    $url = $request->get_param('url');
    $send_to = $request->get_param('send_to');
    $user_type = $request->get_param('user_type');
    $create_at = $request->get_param('create_at'); 

    $data = array(
        'User_id_zalo' => $user_id_zalo,
        'User_id_by_app' => $user_id_by_app,
        'message_type' => $message_type,
        'Content' => $content,
        'URL' => $url,
        'create_at' => $create_at,
        'User_type'=> $user_type,
        'SendTo' => $send_to, 
    );

    $save = $wpdb->insert($wpdb->prefix . 'message_zalo', $data);
    if($save)
    $response = [
        'status'=> 201,
        'message'=> 'Thêm thành công tin nhắn!',
    ];
    else 
    $response = [
        'status'=> 400,
        'message'=> 'Thêm tin nhắn không thành công!',
    ];
    return $response;
}


function when_oa_inbox($request){
    // return 'aaaa';
    global $wpdb;
    $user_id = $request->get_param('user_id');
    // $user_id = '6460647121848128725';
    $content = $request->get_param('content');
    $image = $request->get_file_params();
    
    if($image){
        $url = uploadImage($image['image']); // Hàm uploadImage lấy từ plugin article
    }
    else
        $url = null;
    $title = $request->get_param('title');
    $curl = curl_init();
    $access_token = get_option('zalo_follow_management_zalo_access_token'); // token lấy từ plugin zalo follow
    if($url !=null)
        $postData = [
            // "recipient" => [
            //     "user_id" =>  $user_id
            // ],
            // "message" => [
            //     "text" => $content,
            //     "attachment" => [
            //         "type" => "template",
            //         "payload" => [
            //             "template_type" => "media",
            //             "elements" => [
            //                 [
            //                     "media_type" => "image",
            //                     "url" => $url
            //                 ]
            //             ]
            //         ]
            //     ]
            // ]
            "app_id"=> get_option('zalo_follow_management_zalo_app_id'),
            "user_id"=> $user_id,
            "message"=> $content,
            "message_photo"=> $url,
            "url"=> $url,
            "title"=> "Heloo"
            
        ];
    else 
        $postData = [
            // "recipient" => [
            //     "user_id" =>  $user_id
            // ],
            // "message" => [
            //     "text" => $content,
            // ]
            
            "app_id"=> get_option('zalo_follow_management_zalo_app_id'),
            "user_id"=> $user_id,
            "message"=> $content,
            "title"=> "Heloo"
        ];
    // call api gửi tin nhắn đến khách hàng

    $url_zalo = 'https://webhook.mekong-connector.com/sendmessage';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_zalo);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'x-api-key:' . get_option('zalo_follow_management_license_apikey')
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
   
    $response = json_decode($response);
    $body = json_decode($response->body);
    curl_close($ch);
    if($body->error==0)
    {
        $data=[
            "url" => $url,
            "content" => $content
        ];
        return $data;
    }
    else 
        return 0;
}


// bắt đầu đăng ký api cho trang marketing calender
function custom_api_route() {
    register_rest_route('customer-api/v1', '/select', array(
        'methods' => 'GET',
        'callback' => 'customer_api_select',
    ));
    register_rest_route('customer-api/v1', '/by_ids', array(
        'methods' => 'GET',
        'callback' => 'get_customer_by_id_api_response',
    ));
    register_rest_route('customer-api/v1', '/customer_all', array(
        'methods' => 'GET',
        'callback' => 'get_customer_all',
    ));
    register_rest_route('calendar-api/v1', '/mtdata', array(
        'methods' => 'GET',
        'callback' => 'get_calendar_api_response',
    ));
    register_rest_route('calendar-api/v1', '/statistical', array(
        'methods' => 'GET',
        'callback' => 'get_statistical',
    ));
    register_rest_route('quota-api/v1', '/customer_all', array(
        'methods' => 'GET',
        'callback' => 'get_customer_all_quota',
    ));
    register_rest_route('quota-api/v1', '/select', array(
        'methods' => 'GET',
        'callback' => 'get_customer_seclect_quota',
    ));
     register_rest_route('quota-api/v1', '/by_ids', array(
        'methods' => 'GET',
        'callback' => 'get_customer_customer_tag_quota',
    ));
    register_rest_route('marketing-api/v1', '/get-records', array(
        'methods' => 'GET',
        'callback' => 'get_records_marketing',
    ));
}
add_action('rest_api_init', 'custom_api_route');
// api tìm khách hàng

function get_customer_customer_tag_quota(){
    global $wpdb;
    $keys = [];
    $ids = implode(',', $_GET['ids']);
    $query = "SELECT * FROM {$wpdb->prefix}customer_tag WHERE fkCustomer IS NOT NULL AND fkTag IN ({$ids})";
    $d = $wpdb->get_results($query);
    // return $d;
    foreach ($d as $i) {
        $keys[] = $i->fkCustomer;
    }
    
    $unique = implode(',', array_unique($keys));
    $option = [];
    $values = [];
    if (count(array_unique($keys)) > 0) {
        $data = $wpdb->get_results("
            SELECT {$wpdb->prefix}users.*, {$wpdb->prefix}zalo_followers.*
            FROM {$wpdb->prefix}users
            INNER JOIN {$wpdb->prefix}wc_customer_lookup ON {$wpdb->prefix}users.ID = {$wpdb->prefix}wc_customer_lookup.user_id
            INNER JOIN {$wpdb->prefix}zalo_followers ON {$wpdb->prefix}wc_customer_lookup.customer_id = {$wpdb->prefix}zalo_followers.fk_wc_customer_id 
            WHERE {$wpdb->prefix}wc_customer_lookup.customer_id IN ({$unique})
            AND {$wpdb->prefix}users.user_login REGEXP '^[0-9]+$'
            AND LENGTH({$wpdb->prefix}users.user_login) > 8
        ");
        foreach ($data as $i) {
            $option[] = [
                'text' => $i->display_name,
                'value' => $i->ID,
                "url_image" => $i->Zalo_URL_Img,
            ];
            $values[] = $i->ID;
        }
    }
    $render = [
        'options' => $option,
        'values' => $values,
    ];
    return $render;
}
function get_customer_seclect_quota(){
    global $wpdb;
    $search = $_GET['search'];
    $data = $wpdb->get_results("
            SELECT {$wpdb->prefix}users.*, {$wpdb->prefix}zalo_followers.* 
            FROM {$wpdb->prefix}users 
            INNER JOIN {$wpdb->prefix}zalo_followers ON {$wpdb->prefix}zalo_followers.Zalo_ID_By_App = {$wpdb->prefix}users.user_login
            WHERE CONCAT({$wpdb->prefix}users.display_name) LIKE '%$searchValue%' AND {$wpdb->prefix}users.user_login REGEXP '^[0-9]+$' AND LENGTH({$wpdb->prefix}users.user_login) > 8 LIMIT 10");
    // return $data;
    // return "SELECT * FROM {$wpdb->prefix}users WHERE CONCAT({$wpdb->prefix}users.display_name) LIKE '%$searchValue%' LIMIT 10";
    $option = [];
    foreach ($data as $i){
        $option[] = [
            'text' => $i->display_name,
            'value' => $i->ID,
            "url_image"=> $i->Zalo_URL_Img,
        ];
    }
    return $option;
}

function get_customer_all_quota(){
    global $wpdb;
    $option = [];
    $values = [];
    $user = $wpdb->get_results("
        SELECT {$wpdb->prefix}users.*, {$wpdb->prefix}zalo_followers.* 
        FROM {$wpdb->prefix}users
        INNER JOIN {$wpdb->prefix}zalo_followers ON {$wpdb->prefix}zalo_followers.Zalo_ID_By_App = {$wpdb->prefix}users.user_login
        WHERE {$wpdb->prefix}users.ID IS NOT NULL AND {$wpdb->prefix}users.user_login REGEXP '^[0-9]+$' AND LENGTH({$wpdb->prefix}users.user_login) > 8");
    // print_r($user);
    foreach ($user as $i) {
        
        $option[] = [
            'text' => $i->display_name,
            'value' => $i->ID,
            "url_image"=> $i->Zalo_URL_Img,
        ];
        $values[] = $i->ID;
    }
    $render = [
        'options' => $option,
        'values' => $values,
    ];
    return $render;
}


function get_records_marketing(){
    global $wpdb;
    $limit = $_GET['limit'];
    $skip = $_GET['skip'];
    if(isset($_GET['status'])){
        $marketingcampaign = $wpdb->get_results("
        SELECT EndDate, StartDate, PrimaryKey, Code, Name, isActive, UUID FROM {$wpdb->prefix}marketingcampaign WHERE isActive = ".$_GET['status']."
        ORDER BY PrimaryKey DESC LIMIT $limit OFFSET $skip");
    }else{
        $marketingcampaign = $wpdb->get_results("
        SELECT EndDate, StartDate, PrimaryKey, Code, Name, isActive,UUID FROM {$wpdb->prefix}marketingcampaign 
        ORDER BY PrimaryKey DESC LIMIT $limit OFFSET $skip");
    }
    
    return $marketingcampaign;
    
}
function customer_api_select() {
    global $wpdb;
    $search = $_GET['search'];
    $data = $wpdb->get_results("SELECT last_name, first_name ,customer_id FROM {$wpdb->prefix}wc_customer_lookup WHERE CONCAT({$wpdb->prefix}wc_customer_lookup.first_name, ' ', {$wpdb->prefix}wc_customer_lookup.last_name) LIKE '%$searchValue%' LIMIT 10");

    $option = [];
    foreach ($data as $i){
        $option[] = [
            'text' => $i->first_name .' '. $i->last_name,
            'value' => $i->customer_id
        ];
    }
    return $option;
}
// function get_statistical(){
//     global $wpdb;
//     $month = $_GET['month'];
//     $year = $_GET['year'];
//     $curl = curl_init();
//     curl_setopt_array($curl, array(
//         CURLOPT_URL => 'https://cvbt0dfnwh.execute-api.ap-southeast-1.amazonaws.com/mk_antai/dashboard-zalo-posts',
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_ENCODING => '',
//         CURLOPT_MAXREDIRS => 10,
//         CURLOPT_TIMEOUT => 0,
//         CURLOPT_FOLLOWLOCATION => true,
//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//         CURLOPT_CUSTOMREQUEST => 'POST',
//         CURLOPT_POSTFIELDS =>'{"month": '.$month.',"year":'.$year.'}',
//         CURLOPT_HTTPHEADER => array(  
//             'Content-Type: application/json'
//         ),
//     ));

//     $response = curl_exec($curl);

//     curl_close($curl);
//     return json_decode($response);
// }
function get_statistical(){
    global $wpdb;
    $current_datetime = current_time('mysql');
    $month = $_GET['month'];
    $year= $_GET['year'];
    // return $month . $year;
    $firstDayOfMonth = date($year . '-' . $month . '-01 00:00:00'); 
    $lastDayOfMonth = date($year . '-' . $month . '-30 23:59:59');
    $markerting_processing = $wpdb->get_results("SELECT Name as name, StartDate as startDate, EndDate as endDate, PrimaryKey as primaryKey, UUID as uuid, SendTime as sendTime, SendDate as sendDate FROM {$wpdb->prefix}marketingcampaign WHERE StartDate < '$current_datetime' AND EndDate > '$current_datetime'");
    $markerting_upcoming = $wpdb->get_results("SELECT Name as name, StartDate as startDate, EndDate as endDate, PrimaryKey as primaryKey, UUID as uuid, SendTime as sendTime, SendDate as sendDate FROM {$wpdb->prefix}marketingcampaign WHERE StartDate > '$current_datetime' ORDER BY StartDate ASC Limit 10");
    $marketing_dict = $wpdb->get_results("SELECT YEAR(WeekStart) AS Year, MONTH(WeekStart) AS Month, WEEK(WeekStart) AS Week, DATE_FORMAT(MIN(WeekStart), '%Y-%m-%d') AS WeekStartDate, DATE_FORMAT(MAX(DATE_ADD(WeekStart, INTERVAL 7 DAY)), '%Y-%m-%d') AS WeekEndDate, IFNULL(COUNT(wp_marketingcampaign.PrimaryKey), 0) AS CampaignCount FROM ( SELECT DATE('$year-$month-01') + INTERVAL n WEEK AS WeekStart FROM ( SELECT n FROM ( SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 ) AS Numbers ) AS Weeks ) AS DateList LEFT JOIN wp_marketingcampaign ON YEAR(WeekStart) = YEAR(wp_marketingcampaign.StartDate) AND MONTH(WeekStart) = MONTH(wp_marketingcampaign.StartDate) AND WEEK(WeekStart) = WEEK(wp_marketingcampaign.StartDate) AND YEAR(wp_marketingcampaign.StartDate) = $year WHERE MONTH(WeekStart) = $month GROUP BY Year, Month, Week ORDER BY Year, Month, Week");
    $schedule_sent_dict = $wpdb->get_results("SELECT YEAR(WeekStart) AS Year, MONTH(WeekStart) AS Month, WEEK(WeekStart) AS Week, DATE_FORMAT(MIN(WeekStart), '%Y-%m-%d') AS WeekStartDate, DATE_FORMAT(MAX(DATE_ADD(WeekStart, INTERVAL 7 DAY)), '%Y-%m-%d') AS WeekEndDate, IFNULL(COUNT(wp_schedulesendingv2.Status), 0) AS SentCount FROM ( SELECT DATE('$year-$month-01') + INTERVAL n WEEK AS WeekStart FROM ( SELECT n FROM ( SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 ) AS Numbers ) AS Weeks ) AS DateList LEFT JOIN wp_schedulesendingv2 ON YEAR(WeekStart) = YEAR(wp_schedulesendingv2.SendDate) AND MONTH(WeekStart) = MONTH(wp_schedulesendingv2.SendDate) AND WEEK(WeekStart) = WEEK(wp_schedulesendingv2.SendDate) AND YEAR(wp_schedulesendingv2.SendDate) = $year AND wp_schedulesendingv2.Status = 1 WHERE MONTH(WeekStart) = $month GROUP BY Year, Month, Week ORDER BY Year, Month, Week");  
    $schedule_sent = $wpdb->get_results("SELECT COUNT(*) AS count FROM {$wpdb->prefix}schedulesendingv2 WHERE {$wpdb->prefix}schedulesendingv2.Status = 1 AND SendDate BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth' ");
    
    $customer = $wpdb->get_results("SELECT COUNT(*) AS count FROM {$wpdb->prefix}wc_customer_lookup WHERE date_registered BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'");
    
    $response = [
        'marketing_processing'=> $markerting_processing ? $markerting_processing : [],
        'marketing_upcoming'=> $markerting_upcoming ? $markerting_upcoming : [] ,
        'marketing'=> [ 
            (object) ['week1'=> intval($marketing_dict[0]->CampaignCount)],
            (object) ['week2'=> intval($marketing_dict[1]->CampaignCount)],
            (object) ['week3'=> intval($marketing_dict[2]->CampaignCount)],
            (object) ['week4'=> intval($marketing_dict[3]->CampaignCount)],
        ],
        'schedule_sent_weeks' => array(
            (object) ['week1'=> intval($schedule_sent_dict[0]->SentCount)],
            (object) ['week2'=> intval($schedule_sent_dict[1]->SentCount)],
            (object) ['week3'=> intval($schedule_sent_dict[2]->SentCount)],
            (object) ['week4'=> intval($schedule_sent_dict[3]->SentCount)],
        ),
        'schedule_sent'=>intval($schedule_sent[0]->count),
        'customer'=> intval($customer[0]->count),
    ];
    return $response;
}


// api chọn khách hàng trên tab
function get_customer_by_id_api_response() {
    global $wpdb;
    $keys = [];
    $ids = implode(',', $_GET['ids']);
    $query = "SELECT * FROM {$wpdb->prefix}customer_tag WHERE fkCustomer IS NOT NULL AND fkTag IN ({$ids})";
    $d = $wpdb->get_results($query);
    // return $d;
    foreach ($d as $i) {
        $keys[] = $i->fkCustomer;
    }
    
    $unique = implode(',', array_unique($keys));
    $option = [];
    $values = [];
    if (count(array_unique($keys)) > 0) {
        $data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}zalo_followers WHERE fk_wc_customer_id IN ({$unique})");
        foreach ($data as $i) {
            $option[] = [
                'text' => $i->Zalo_Name,
                'value' => $i->fk_wc_customer_id,
            ];
            $values[] = $i->fk_wc_customer_id;
        }
    }
    $render = [
        'options' => $option,
        'values' => $values,
    ];
    return $render;
}
function get_customer_all(){
    global $wpdb;
    $option = [];
    $values = [];
    $zalo = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}zalo_followers WHERE fk_wc_customer_id IS NOT NULL");
    foreach ($zalo as $i) {
        $option[] = [
            'text' => $i->Zalo_Name,
            'value' => $i->fk_wc_customer_id,
        ];
        $values[] = $i->fk_wc_customer_id;
    }
    $render = [
        'options' => $option,
        'values' => $values,
    ];
    return $render;
}
// hàm đếm số dòng trên bảng 
function countTotalRow($wpdb,$table,$columnName,$key)
{
    $query = "SELECT COUNT(*) AS count FROM $table WHERE $columnName = '$key'";
    $result = $wpdb->get_results($query,ARRAY_A);
    if ($result) {
        $row = $result[0];
        $totalCount = $row['count'];
        return $totalCount;
    } else {
        return "lỗi";
    }
}
// api thông tin lịch gửi và search
function get_calendar_api_response(){
    global $wpdb;
    $draw = $_GET['draw'];
    $start = $_GET["start"];
    $length = $_GET["length"]; // Rows display per page

    $columnIndex_arr = $_GET['order'];
    $columnName_arr = $_GET['columns'];
    // return $columnIndex_arr;
    $order_arr = $_GET['order'];
    $search_arr = $_GET['search'];

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    // $columnIndex = $columnIndex_arr[0]['column'];
    // return $columnIndex;
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    // return $columnName;
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value
    // countTotalRow đếm số bảng ghi có UUID = UUID thêm url tham số m
    $ss_summary = countTotalRow($wpdb,"{$wpdb->prefix}schedulesendingv2",'UUID',$_GET['m']);
    $recordsQuery = "SELECT {$wpdb->prefix}schedulesendingv2.*, {$wpdb->prefix}wc_customer_lookup.* FROM {$wpdb->prefix}schedulesendingv2 JOIN {$wpdb->prefix}wc_customer_lookup ON {$wpdb->prefix}schedulesendingv2.fkCustomer = {$wpdb->prefix}wc_customer_lookup.customer_id";
    
    if (isset($_GET['m'])) {
        $recordsWhere = " WHERE {$wpdb->prefix}schedulesendingv2.UUID = '".$_GET['m']."'";
    };
    if(isset($_GET['status'])){
        $status = $_GET['status'];
        $recordsWhere = $recordsWhere." AND {$wpdb->prefix}schedulesendingv2.Status = '$status'";
        $ss_summary = $wpdb->get_results("SELECT COUNT(*) as count FROM {$wpdb->prefix}schedulesendingv2 WHERE {$wpdb->prefix}schedulesendingv2.UUID = '".$_GET['m']."' AND {$wpdb->prefix}schedulesendingv2.Status = '".$_GET['status']."'")[0]->count;
    }
    if ($columnSortOrder == 'desc') {
        $recordsOrder = " ORDER BY $columnName DESC ";
    } elseif ($columnSortOrder == 'asc') {
        $recordsOrder = " ORDER BY $columnName ASC ";
    } else {
        $recordsOrder = " ORDER BY first_name DESC ";
    }
    // thêm đoạn truy vấn thông tin mà người dùng nhập vào ô tìm kiếm
    if ($searchValue) {
        $recordsWhere .= " AND CONCAT({$wpdb->prefix}wc_customer_lookup.first_name, ' ', {$wpdb->prefix}wc_customer_lookup.last_name) LIKE '%$searchValue%'";
        $recordsQuery .= $recordsWhere .$recordsOrder ." LIMIT $length" ;
        // return $recordsQuery;
        $records = $wpdb->get_results($recordsQuery ,ARRAY_A);
        // $ss_summary = count($records);
    } else {
        $recordsQuery .= $recordsWhere . $recordsOrder. " LIMIT $length OFFSET $start";
        $records = $wpdb->get_results($recordsQuery, ARRAY_A);
        // $ss_summary = count($records);
    }

    $data_arr = [];
    foreach ($records as $record) {
        $choose = '<input type="checkbox" name="schedue[]" class="check-schedule" value="'.$record['PrimaryKey'].'"/>';
        $code = $record['PrimaryKey'];
        $name = $record['first_name'] ." ". $record['last_name'];
        $email = $record['email'];
        $date = $record['SendDate'];
        $time = $record['SendTime'];
        $status = '';
        switch ($record['Status']) {
            case 0:
                $status = '<span class="badge badge-pill badge-secondary">Chưa gửi</span>';
                break;
            case 1:
                $status = '<span class="badge badge-pill badge-primary">Đã gửi</span>';
                break;
            case 2:
                $status = '<span class="badge badge-pill badge-success">Đã xem</span>';
                break;
            case 3:
                $status = '<span class="badge badge-pill badge-success">Đã đặt hàng</span>';
                break;
            case 4:
                $status = '<span class="badge badge-pill badge-danger">Đã hủy</span>';
                break;
            case 5:
                $status = '<span class="badge badge-pill badge-danger">Gửi lỗi</span>';
                break;
            case 6:
                $status = '<span class="badge badge-pill badge-warning">Yêu cầu hủy</span>';
        }

        $active = '<div class="dropdown">' .
            '<a class="text-body dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
            '<i class="mdi mdi-dots-vertical font-20"></i></a>' .
            '<div class="dropdown-menu dropdown-menu-right">' .
            '<a class="dropdown-item" href="'.admin_url('admin.php?page=send-calendar&ids='.$record['PrimaryKey']).'"><i class="fe-send"></i> Gửi ngay</a>' .
            '<a class="dropdown-item" href="'.admin_url('admin.php?page=active-calendar&ids='.$record['PrimaryKey']).'"><i class="fe-alert-triangle"></i> Hủy lịch gửi</a>' .
            '<a class="dropdown-item" onClick="confirmDelete(this)" href="javascript:void(0);" data-href="'.admin_url('admin.php?page=delete-calendar&ids='.$record['PrimaryKey']).'">' .
            '<i class="fe-trash-2"></i> Xóa lịch gửi</a>' .
            '</div></div>';

        $data_arr[] = [
            "Choose" => $choose,
            "PrimaryKey" => $code,
            "last_name" => $name,
            "email" => $email,
            "SendDate" => $date,
            "SendTime" => $time,
            "Status" => $status,
            "Active" => $active,
        ];
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $ss_summary,
        "iTotalDisplayRecords" => $ss_summary,
        "aaData" => $data_arr
    );
    return $response;
}
// kết thúc đăng ký api marketing calender

// thêm bootstrap 
function enqueue_bootstrap_assets() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');

    // Enqueue Bootstrap JS (with Popper.js included)
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_bootstrap_assets');









//Nhân

$access_token = get_option('zalo_follow_management_zalo_access_token');
    function sync(){
        global $access_token;
    
        $ch = curl_init();
        $url = 'https://openapi.zalo.me/v2.0/article/getslice?offset=0&limit=10&type=normal';
        $headers = array(
            'access_token: ' . $access_token
        );
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $response = curl_exec($ch);
        $data = json_decode($response, true);
    
    
        $data = json_decode($response, true)['data'];
        $medias = $data['medias']; 
        $total = $data['total'];
    
        $data_arr = [];
        $data1 = [];
        $time = (int)($total / 10);
        for ($i=0; $i<=$time; $i++){
            $temp = $i*10;
            $ch = curl_init();
            $url = 'https://openapi.zalo.me/v2.0/article/getslice?offset='.$temp.'&limit=10&type=normal';
            $headers = array(
                'access_token: ' . $access_token
            );
        
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
            $response = curl_exec($ch);
            $data = json_decode($response, true);
        
            // Xử lý dữ liệu response
            $data = json_decode($response, true)['data'];
            $medias = $data['medias']; 
            
    
            foreach ($medias as $media){
                if (isset($_GET['status']) && $_GET['status'] == 'show' && $media['status'] == 'show'){
                    $data1[] = $media;
                }
                if (isset($_GET['status']) && $_GET['status'] == 'hide' && $media['status'] == 'hide'){
                    $data1[] = $media;
                } 
                if(!isset($_GET['status'])) {
                    $data1[] = $media;
                }
            }
        }
    
        foreach ($data1 as $record) {
            $link = $record['link_view'];
            $status = $record['status'];
            $create_date = $record['create_date'];
            $update_date = $record['update_date'];
           
    
            
            $seconds = $create_date / 1000;
            $carbonDate = new DateTime();
            $carbonDate->setTimestamp($seconds);
            $create_date =  $carbonDate->format('d/m/Y H:i');
        
            
            $seconds = $update_date / 1000;
            $carbonDate = new DateTime();
            $carbonDate->setTimestamp($seconds);
            $update_date =  $carbonDate->format('d/m/Y H:i');
        
            $data_arr[] = [
                "title" => $record['title'],
                "total_view" => $record['total_view'],
                "total_share" => $record['total_share'],
                "link_view" => $link,
                "create_date" => $create_date, 
                "update_date" => $update_date, 
                "status" => $status,
                'id' => $record['id']
                
            ];
        }
        global $wpdb;
        $table_name = $wpdb->prefix . 'article_sync';
        foreach ($data_arr as $data){
            $new_data = array(
                'id_article' => $data['id'],
                'title' => $data['title'],
                'total_view' => $data['total_view'],
                'total_share' => $data['total_share'],
                'link_view' => $data['link_view'],
                'create_date' => $data['create_date'],
                'update_date' => $data['update_date'],
                'status' => $data['status']
            );
            $wpdb->insert($table_name, $new_data);
            if ($wpdb->last_error) {
                die('Error: ' . $wpdb->last_error);
            }
        }
        
    }
    
    
    add_action('rest_api_init', function () {
        register_rest_route('article', '/sync', array(
            'methods' => 'GET',
            'callback' => 'sync',
        ));
    });





function createImg()
{
    $headers = [
        'Content-Type' => 'application/json'
    ];
    $url = 'https://f7bs3nyfimfloihjuvdkiejqmu0qbqgp.lambda-url.ap-southeast-1.on.aws';
    $body = '{
      "feature": "VeHinh",
      "prompt": "' . $_REQUEST['message'] . '"
    }';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route('article', '/createImg', array(
        'methods' => 'GET',
        'callback' => 'createImg',
    ));
});
// upload Image api
function register_custom_upload_endpoint() {
    register_rest_route('custom/v1', '/upload-image', array(
        'methods' => 'POST',
        'callback' => 'handle_image_upload',
        'permission_callback' => '__return_true', // Cho phép mọi người sử dụng API
    ));
}

add_action('rest_api_init', 'register_custom_upload_endpoint');

function handle_image_upload($request) {
    $Poster = uploadImage($_FILES['Poster']);
    return $Poster;
}


function loadTopic()
{
    $url = 'https://f7bs3nyfimfloihjuvdkiejqmu0qbqgp.lambda-url.ap-southeast-1.on.aws';
    $headers = [
        'Content-Type: application/json'
    ];
    $body = '{"feature": "TaoChuDe"}';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route('article', '/loadTopic', array(
        'methods' => 'GET',
        'callback' => 'loadTopic',
    ));
});


function uploadImage($file)
{
    $api_key = get_option('zalo_follow_management_license_apikey');
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $rename = time() . '_' . rand(1000, 9999) . '.' . $extension;
    $image = imagecreatefromstring(file_get_contents($file['tmp_name']));
    imagejpeg($image, $rename, 50);
    imagedestroy($image);
    $newFilePath = realpath($rename);
    // $remoteServerUrl = 'https://cvbt0dfnwh.execute-api.ap-southeast-1.amazonaws.com/mk_antai/uploadPhoto/mk-antai/'.$rename;
    $remoteServerUrl = 'https://webhook.mekong-connector.com/zalo-connect/'.$rename;
    // echo $remoteServerUrl;
    $headers = [
        'x-api-key: '.$api_key,
        'Content-Type: image/jpeg' 
    ];
    $ch = curl_init($remoteServerUrl);
    curl_setopt($ch, CURLOPT_PUT, true);
    curl_setopt($ch, CURLOPT_INFILE, fopen($newFilePath, 'r')); 
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($newFilePath));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_exec($ch);
    curl_close($ch);

    unlink($newFilePath);
    // Replace with your own logic for generating the public URL
    // $publicUrl = 'https://mk-antai.s3.ap-southeast-1.amazonaws.com/' . $rename;
    $publicUrl = 'https://zalo-connect.s3.ap-southeast-1.amazonaws.com/' . $rename;
    return $publicUrl;
}


function uploadFile(){
    // print_r($_FILES['image']) ;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $file = $_FILES['image'];
        $responseData = ['url' => uploadImage($file)];
        // print_r($responseData);
        echo json_encode($responseData);
    }else{
        $responseData = ['error' => 'Invalid image'];
        http_response_code(400);
        echo json_encode($responseData);
    }

}

add_action('rest_api_init', function () {
    register_rest_route('article', '/uploadFile', array(
        'methods' => 'POST',
        'callback' => 'uploadFile',
    ));
});

function search(){
    global $access_token;
    $draw = $_GET['draw'];
    $start = $_GET['start'];
    $length = $_GET['length'];
    $columnIndex_arr = $_GET['order'];
    $columnName_arr = $_GET['columns'];
    $order_arr = $_GET['order'];
    $search_arr = $_GET['search'];
    $columnIndex = $columnIndex_arr[0]['column'];
    $columnName = $columnName_arr[$columnIndex]['data'];
    $columnSortOrder = $order_arr[0]['dir'];
    $searchValue = $search_arr['value'];
    
    $searchValue = $_GET['word'];
    $ch = curl_init();
    $url = 'https://openapi.zalo.me/v2.0/article/getslice?offset=0&limit=10&type=normal';
    $headers = array(
        'access_token: ' . $access_token
    );

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $data = json_decode($response, true);
    $data = json_decode($response, true)['data'];
    $medias = $data['medias']; 
    $total = $data['total'];

    $time = (int)($total / 10);
    $dataSearch = [];
    $count = 0;
    for ($i=0; $i<=$time; $i++){
        $temp = $i*10;
        $ch = curl_init();
        $url = 'https://openapi.zalo.me/v2.0/article/getslice?offset='.$temp.'&limit=10&type=normal';
        $headers = array(
            'access_token: ' . $access_token
        );
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $response = curl_exec($ch);
        $data = json_decode($response, true);
    
        // Xử lý dữ liệu response
        $data = json_decode($response, true)['data'];
        $medias = $data['medias']; 

        foreach ($medias as $media){
            if (stripos($media['title'], $searchValue) !== false) {
                $dataSearch[] = $media;
                $count = $count + 1;

            } 
        }
    }
    $arr_datatable = [];
    for($j=$start; $j<$start+$length; $j++){
        if ($dataSearch[$j]){
            $arr_datatable[] = $dataSearch[$j];
        }
    }
    foreach ($arr_datatable as $record) {
        // $choose = '<input type="checkbox">';
        $link = '<a href="' . $record['link_view'] . '" target="_blank">Chi tiết</a>';
        $status = $record['status'] == 'show' ? '<span class="ri-eye-fill text-primary"></span>' : '<span class="ri-eye-off-fill text-danger"></span>';
        $create_date = $record['create_date'];
        $update_date = $record['update_date'];
        
        $seconds = $create_date / 1000;
        $carbonDate = new DateTime();
        $carbonDate->setTimestamp($seconds);
        $create_date =  $carbonDate->format('d/m/Y H:i');
    
        
        $seconds = $update_date / 1000;
        $carbonDate = new DateTime();
        $carbonDate->setTimestamp($seconds);
        $update_date =  $carbonDate->format('d/m/Y H:i');
    
        $data_arr[] = [
            // "choose" => $choose,
            "title" => '<a href="' . admin_url("admin.php?page=article-detail&id=") . ''.$record['id'].'"> '.$record['title']  .'</a>',
            "total_view" => $record['total_view'],
            "total_share" => $record['total_share'],
            "link_view" => $link,
            "create_date" => $create_date, 
            "update_date" => $update_date, 
            "status" => $status,
        ];
    }
    $response1 = [
        "iTotalRecords" => $count,
        "iTotalDisplayRecords" => $count,
        "aaData" => $data_arr,
    ];
    $result = json_encode($response1);
    echo $result;

}


add_action('rest_api_init', function () {
    register_rest_route('article', '/search', array(
        'methods' => 'GET',
        'callback' => 'search',
    ));
});

function get_data(){
    $curl = curl_init();
    $appID = get_option('zalo_follow_management_zalo_app_id');
    $api_key = get_option('zalo_follow_management_license_apikey');
    curl_setopt_array($curl, array(
    // CURLOPT_URL => 'https://cvbt0dfnwh.execute-api.ap-southeast-1.amazonaws.com/mk_antai/dashboard-zalo-posts',
    CURLOPT_URL => 'https://webhook.mekong-connector.com/dashboard-zalo-posts',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{"app_id":"'.$appID.'","date":"'.$_GET['date'].'"}',
    CURLOPT_HTTPHEADER => array(
        'x-api-key: '.$api_key,
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}


add_action('rest_api_init', function () {
    register_rest_route('article', '/get_data', array(
        'methods' => 'GET',
        'callback' => 'get_data',
    ));
});

function get_data_zns(){
    $curl = curl_init();
    $appID = get_option('zalo_follow_management_zalo_app_id');
    $api_key = get_option('zalo_follow_management_license_apikey');
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://webhook.mekong-connector.com/zns-transaction-dashboard',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{"app-id":"'.$appID.'"}',
    CURLOPT_HTTPHEADER => array(
        'x-api-key: '.$api_key,
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}


add_action('rest_api_init', function () {
    register_rest_route('zns', '/get_data_zns', array(
        'methods' => 'GET',
        'callback' => 'get_data_zns',
    ));
});





// Hàm callback để hiển thị nội dung trang "Quản lý Bài viết"
function article_management_page() {
    // Hiển thị nội dung trang "Quản lý Bài viết"
    require_once('page/article/index.php');
}
// Hàm callback để hiển thị nội dung trang "Chi tiết bài viết"
function article_dashboard_page() {
    // Hiển thị nội dung trang "Chi tiết bài viết"
    require_once('page/article/dashboard.php');
}


function customer_dashboard_shortcode() {
    global $wpdb;
    $current_user = wp_get_current_user();
    $user_id="";
    $username="";
    if ($current_user->ID !== 0) {
        $username=$current_user->user_login; 
        $user_id=$current_user->id;
    } 
    $zalo_id_by_app = $username; // Replace with the actual Zalo_ID_By_App value
    
    $query = $wpdb->prepare(
        "SELECT `Zalo_URL_Img`, `fk_wc_customer_id`, `Zalo_ID`
        FROM {$wpdb->prefix}zalo_followers
        WHERE `Zalo_ID_By_App` = %s",
        $zalo_id_by_app
    );
    
    $result = $wpdb->get_row($query);
    
    if ($result) {
        $avatar = $result->Zalo_URL_Img;
        $fk_wc_user_id = $result->fk_wc_customer_id;
        $zalo_id = $result->Zalo_ID;
    } 
    $customer = new WC_Customer($user_id);
    // Kiểm tra xem khách hàng có tồn tại không
    if ($customer->get_id()) {
        // Lấy thông tin hồ sơ khách hàng
        $customer_data = $customer->get_data();
        $order_count = wc_get_customer_order_count($user_id);
        $total_spent = wc_get_customer_total_spent($user_id);
        // In thông tin khách hàng
    } else {
        echo "Không tìm thấy khách hàng với User ID này.";
    }
    // Lấy các thông tin cụ thể và lưu vào biến
    $user_id = $customer_data["id"];
    $email = $customer_data["email"];
    $first_name = $customer_data["first_name"];
    $last_name = $customer_data["last_name"];
    $display_name = $customer_data["display_name"];
    $role = $customer_data["role"];
    // Lưu thông tin địa chỉ thanh toán và giao hàng
    $billing_address = $customer_data["billing"];
    $shipping_address = $customer_data["shipping"];
    // Lấy đường dẫn tương đối đến thư mục "img" của plugin
    $img_url = plugins_url('page/customer-profile/img/', __FILE__);
    // Kết hợp đường dẫn tương đối với tên tệp hình ảnh bạn muốn sử dụng
    $icon_order = $img_url . 'icon-04.png';
    $icon_sales = $img_url . 'icon-02.png';
    $icon_point = $img_url . 'icon-05.png';
    $icon_promotion = $img_url . 'icon-03.png';
    // Truy vấn cơ sở dữ liệu để lấy tổng số điểm tích lũy của người dùng cụ thể
    $query = $wpdb->prepare(
        "SELECT SUM(point_amount) AS total_points
        FROM wp_reward_point_history
        WHERE fk_wc_customer_id = %d",
        $fk_wc_user_id
    );

    $total_points = $wpdb->get_var($query);
    // Hiển thị tổng số điểm tích lũy
    if ($total_points !== null) {
        $total_points= $total_points;
    } else {
        $total_points=0;
    }
    // Truy vấn SQL để tính tổng số lịch gửi đã gửi thành công cho khách hàng
    $query = $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}schedulesendingv2 WHERE fkCustomer = %d AND status = 1",
        $fk_wc_user_id
    );
    $total_successful_schedules = $wpdb->get_var($query);
    // Truy vấn SQL để lấy các tagname của khách hàng
    $query = $wpdb->prepare(
        "SELECT t.Name
        FROM {$wpdb->prefix}customer_tag AS ct
        INNER JOIN {$wpdb->prefix}tags AS t ON ct.fkTag = t.id
        WHERE ct.fkCustomer = %d",
        $fk_wc_user_id
    );
    // Thực thi truy vấn và lấy kết quả
    $tag_names = $wpdb->get_results($query);
    ob_start(); 
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
          href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
          rel="stylesheet" />
    </head>
    <style>
        /*.card{*/
        /*    min-width: 65vw !important;*/
        /*}*/
        .card-cus{
            margin-top:15px;
            border: 1px solid gainsboro;
            border-radius: 5px;
            min-width: 100%;
        }
        .top{
            @media (max-width: 576px){
                display: flex;
                flex-direction: column;
            }
        }
        .et_pb_text_0{
            @media (max-width: 576px){
                padding-left: 2% !important;
                padding-right: 2% !important;
            }
        }
    </style>
    <body>
        <div class="layout-wrapper layout-content-navbar">
          <div class="layout-container">
            <div class="layout-page">
              <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                        <h5 class="card-header">Thông tin chi tiết</h5>
                        <div class="card-body">
                          <div class="d-flex align-items-start align-items-sm-center gap-4 top">
                            <img
                              src="<?php echo $avatar; ?>"
                              alt="user-avatar"
                              class="d-block rounded"
                              height="100"
                              width="100"
                              id="uploadedAvatar" />
                            <div class="button-wrapper">
                              <h5><?php echo $first_name." ".$last_name; ?></h5>
                              <div><i class="fa-solid fa-phone"></i><?php echo " ". $billing_address["phone"] ." ".$shipping_address["phone"] ;?> <br> <i class="fa-solid fa-envelope"></i><?php echo " ". $email; ?></div>
                              <p class="text-muted mb-0">Thẻ khách hàng: 
                              <?php
                                if ($tag_names) {
                                    // Lặp qua và hiển thị các tagname dưới dạng badge
                                    foreach ($tag_names as $tag_name) {
                                        $random_color = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Tạo màu sắc ngẫu nhiên
                                        echo '<span class="badge" style="background-color: ' . $random_color . ';">' . $tag_name->Name . '</span>&nbsp;';
                                    }
                                } else {
                                    echo "Khách hàng này không có tag nào.";
                                }
                              ?>
                              </p>
                            </div>
                          </div>
                        </div>
                        <hr class="my-0" />
                        <!--bắt đầu thống kê các thông số-->
                        <div class="d-flex flex-column justify-content-center align-items-center p-3">
                            <div class=" mb-6 d-flex justify-content-center align-items-center w-100" >
                              <div class="card-cus">
                                <div class="card-body">
                                  <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <!--hình ơ đây-->
                                        <img
                                        src="<?php echo $icon_order;?>"
                                        alt="Credit Card"
                                        class="rounded"
                                        width="50" height="50"/>
                                    </div>
                                    <div class="dropdown">
                                      <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt3"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                      </div>
                                    </div>
                                  </div>
                                  <span class="fw-medium d-block mb-1">Đơn hàng</span>
                                  <h3 class="card-title mb-2 fw-bold"><?php echo $order_count; ?></h3>
                                  <!--<small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>-->
                                </div>
                              </div>
                            </div>
                            <div class=" mb-6 d-flex justify-content-center align-items-center w-100"  >
                              <div class="card-cus">
                                <div class="card-body">
                                  <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img
                                        src="<?php echo $icon_sales;?>"
                                        alt="Credit Card"
                                        class="rounded" 
                                        width="50" height="50" />
                                    </div>
                                    <div class="dropdown">
                                      <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt6"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                      </div>
                                    </div>
                                  </div>
                                  <span class="fw-medium d-block mb-1">Doanh số</span>
                                  <h3 class="card-title text-nowrap mb-1 fw-bold "><?php echo number_format($total_spent, 0, ",", ".") . " đ"; ?></h3>
                                  <!--<small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>-->
                                </div>
                              </div>
                            </div>
                            <div class=" mb-6 d-flex justify-content-center align-items-center w-100"   >
                              <div class="card-cus">
                                <div class="card-body">
                                  <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img
                                        src="<?php echo $icon_point;?>"
                                        alt="Credit Card"
                                        class="rounded" 
                                        width="50" height="50" />
                                    </div>
                                    <div class="dropdown">
                                      <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt6"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                      </div>
                                    </div>
                                  </div>
                                  <span class="fw-medium d-block mb-1">Điểm</span>
                                  <h3 class="card-title text-nowrap mb-1 fw-bold"><?php echo $total_points; ?></h3>
                                  <!--<small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>-->
                                </div>
                              </div>
                            </div>
                            <div class=" mb-6 d-flex justify-content-center align-items-center w-100"  >
                              <div class="card-cus">
                                <div class="card-body">
                                  <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img
                                        src="<?php echo $icon_promotion;?>"
                                        alt="Credit Card"
                                        class="rounded"
                                        width="50" height="50" />
                                    </div>
                                    <div class="dropdown">
                                      <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt6"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                      </div>
                                    </div>
                                  </div>
                                  <span class="fw-medium d-block mb-1">Tin quảng cáo</span>
                                  <h3 class="card-title text-nowrap mb-1 fw-bold"><?php echo $total_successful_schedules; ?></h3>
                                  <!--<small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>-->
                                </div>
                              </div>
                            </div>
                         </div>
                        <!--kết thúc thống kê-->
                        <!-- /Account -->
                      </div>
                      <!--<div class="card">-->
                      <!--  <h5 class="card-header">Xóa tài khoản?</h5>-->
                      <!--  <div class="card-body">-->
                      <!--    <div class="mb-3 col-12 mb-0">-->
                      <!--      <div class="alert alert-warning">-->
                      <!--        <h6 class="alert-heading mb-1">Bạn chắc chắn muốn xóa tài khoản này không?</h6>-->
                      <!--        <p class="mb-0">Một khi bạn xóa tài khoản, bạn sẽ không thể quay lại. Xin hãy chắc chắn.</p>-->
                      <!--      </div>-->
                      <!--    </div>-->
                      <!--    <form id="formAccountDeactivation" onsubmit="return false">-->
                      <!--      <div class="form-check mb-3">-->
                      <!--        <input-->
                      <!--          class="form-check-input"-->
                      <!--          type="checkbox"-->
                      <!--          name="accountActivation"-->
                      <!--          id="accountActivation" />-->
                      <!--        <label class="form-check-label" for="accountActivation"-->
                      <!--          >Tôi xác nhận việc xóa tài khoản này</label-->
                      <!--        >-->
                      <!--      </div>-->
                      <!--      <button type="submit" class="btn btn-danger deactivate-account">Xóa tài khoản</button>-->
                      <!--    </form>-->
                      <!--  </div>-->
                      <!--</div>-->
                    </div>
                  </div>
                </div>
                <!-- / Content -->
    
                 <!--Footer -->
                <!--<footer class="content-footer footer bg-footer-theme">-->
                <!--  <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">-->
                <!--    <div class="mb-2 mb-md-0">-->
                <!--      ©-->
                <!--      <script>-->
                <!--        document.write(new Date().getFullYear());-->
                <!--      </script>-->
                <!--      , made by-->
                <!--      <a href="#" target="_blank" class="footer-link fw-medium">MKC</a>-->
                <!--    </div>-->
                <!--    <div class="d-none d-lg-inline-block">-->
                <!--      <a href="#" class="footer-link me-4" target="_blank">License</a>-->
                <!--      <a href="#" target="_blank" class="footer-link me-4">More Themes</a>-->
    
                <!--      <a-->
                <!--        href="#"-->
                <!--        target="_blank"-->
                <!--        class="footer-link me-4"-->
                <!--        >Documentation</a-->
                <!--      >-->
    
                <!--      <a-->
                <!--        href="#"-->
                <!--        target="_blank"-->
                <!--        class="footer-link me-4"-->
                <!--        >Support</a-->
                <!--      >-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</footer>-->
                 <!--/ Footer -->
    
                <div class="content-backdrop fade"></div>
              </div>
              <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
          </div>
    
          <!-- Overlay -->
          <div class="layout-overlay layout-menu-toggle"></div>
        </div>
    
        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
      </body>
    </html>
    <script>
        var divElement = document.querySelector('.woocommerce-MyAccount-content');

        // Lấy tất cả các thẻ <p> bên trong div
        var pElements = divElement.querySelectorAll('p');
        
        // Kiểm tra nếu có ít nhất 2 thẻ <p> thì xóa chúng
        if (pElements.length >= 2) {
            for (var i = 0; i < 2; i++) {
                pElements[i].remove();
            }
        }
        var dashboardLinks = document.querySelectorAll('.woocommerce-MyAccount-navigation-link--dashboard');
        dashboardLinks.forEach(function(link) {
            link.style.display = 'none';
        });
    </script>
    
    <?php
    $output = ob_get_clean(); 
    return $output; 
}
add_shortcode('customer_zalo_dashboard', 'customer_dashboard_shortcode');

//thêm shortcode customer_zalo_dashboard
function custom_account_content_dashboard() {
    global $wp;
    $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );

    if (strpos($current_url, 'dashboard-cus') !== false) {
        echo do_shortcode('[customer_zalo_dashboard]');
    } else {
        // Nội dung mặc định của trang My Account
        // ...
    }
}
add_action('woocommerce_account_content', 'custom_account_content_dashboard');



//hàm để thêm menu con trong trang my-account
add_filter('woocommerce_account_menu_items', 'add_custom_menu_items', 99, 1);

function add_custom_menu_items($items) {
    $custom_items = array(
        //'history-eye' => __('Lịch sử khám mắt', 'my_plugin'),
        'dashboard-cus' => __('Dashboard', 'my_plugin'),
    );

    // Chèn mục menu "Lịch sử khám mắt" và "Dashboard Cus" vào đầu danh sách menu
    $items = array_slice($items, 0, 1, true) +
        $custom_items +
        array_slice($items, 1, count($items), true);

    return $items;
}

function my_custom_endpoints() {
    add_rewrite_endpoint( 'dashboard-cus', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'my_custom_endpoints' );

function my_custom_query_vars( $vars ) {
    $vars[] = 'dashboard-cus';
    return $vars;
}

add_filter( 'query_vars', 'my_custom_query_vars', 0 );
function my_custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}

add_action( 'wp_loaded', 'my_custom_flush_rewrite_rules' );
function my_custom_endpoint_content() {
    echo '<p>Hello World!</p>';
}

add_action( 'woocommerce_account_order-a-kit_endpoint', 'my_custom_endpoint_content' );

//ẩn đi một nút sử dụng js file
function custom_hide_dashboard_enqueue_script() {
    $jsfilename = plugins_url('assets/js/', __FILE__);
    wp_enqueue_script('custom-script', $jsfilename . 'index.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'custom_hide_dashboard_enqueue_script');

function custom_hide_admin_enqueue_script() {
    $jsfilename = plugins_url('assets/js/', __FILE__);
    wp_enqueue_script('admin-custom', $jsfilename . 'admin-custom.js', array('jquery'), '1.0', true);
    wp_enqueue_script('language', $jsfilename . 'language.js', array('jquery'), '1.0', true);
}

add_action('admin_enqueue_scripts', 'custom_hide_admin_enqueue_script');


//Them các page Tag -datnc
//Callback function để hiển thị nội dung trang declare
function my_custom_subpage_content() {
    echo '<div class="wrap">';
    
    // Gọi file vào
    require plugin_dir_path(__FILE__) . '/page/tag-view/view/tagging.php';
    
    // Nội dung sau khi gọi file vào
    echo '</div>';
}

// Callback function để hiển thị nội dung trang
function tags_plugin_page_content() {
    require plugin_dir_path(__FILE__) . '/page/tag-view/view/indextag.php';
}

// Xử lý AJAX request để thêm Tag
add_action('wp_ajax_add_new_tag', 'add_new_tag_callback');
add_action('wp_ajax_nopriv_add_new_tag', 'add_new_tag_callback');
function add_new_tag_callback() {
    global $wpdb;
    if (isset($_POST['formData'])) {
        parse_str($_POST['formData'], $formData);
        
        // Xử lý dữ liệu và thêm Tag vào cơ sở dữ liệu
        $tag_name = sanitize_text_field($formData['Name']);
        
        $sql = $wpdb->prepare(
            "INSERT INTO {$wpdb->prefix}tags (Name) VALUES (%s)",
            $tag_name
        );
        
        $result = $wpdb->query($sql);
        
        if ($result !== false) {
            return 'success';
        } else {
            echo 'error';
        }
    }
}

// Xử lý AJAX request để lấy dữ liệu từ bảng tags
add_action('wp_ajax_get_tag_data', 'get_tag_data_callback');
add_action('wp_ajax_nopriv_get_tag_data', 'get_tag_data_callback');
function get_tag_data_callback() {
    global $wpdb;
    
    $tags_table = $wpdb->prefix . 'tags';

    $sql = "SELECT * FROM $tags_table";
    $results = $wpdb->get_results($sql);

    if (!empty($results)) {
        $data = array();
        foreach ($results as $result) {
            $data[] = array(
                "id" => $result->id,
                "Name" => $result->Name,
                "created_at" => $result->created_at,
                "updated_at" => $result->updated_at
            );
        }
        echo json_encode(array("data" => $data));
    } else {
        echo json_encode(array("data" => array()));
    }

    wp_die(); // Kết thúc xử lý AJAX
}

// Lấy dữ liệu customer tag
add_action('wp_ajax_get_customer_tag_data', 'get_customer_tag_data_callback');
add_action('wp_ajax_nopriv_get_customer_tag_data', 'get_customer_tag_data_callback');

function get_customer_tag_data_callback() {
    global $wpdb;
    
    $customer_tag_table = $wpdb->prefix . 'customer_tag';
    $wc_customer_lookup_table = $wpdb->prefix . 'wc_customer_lookup';
    $tags_table = $wpdb->prefix . 'tags';

    $tag_id = isset($_POST['tag_id']) ? intval($_POST['tag_id']) : 0;

    if ($tag_id > 0) {
    $sql = $wpdb->prepare("SELECT * FROM $customer_tag_table WHERE fkTag = %d", $tag_id);
    $results = $wpdb->get_results($sql);

    if ($results) {
        $data = array();

        foreach ($results as $result) {
            $data_entry = array();
            $sql1 = $wpdb->prepare("SELECT * FROM $wc_customer_lookup_table WHERE username = %d", $result->zalo_user_id_by_app);
            $results1 = $wpdb->get_results($sql1);
            foreach ($results1 as $result1) {
                $data_entry["id"] = $result->id;
                $data_entry["fk_tag"] = $result->fkTag;
                if (empty($result1->first_name) && empty($result1->last_name)) {
                // Nếu cả first_name và last_name đều rỗng, thực hiện lấy dữ liệu từ wp_zalo_followers
                $sql3 = $wpdb->prepare("SELECT zalo_name FROM wp_zalo_followers WHERE zalo_id_by_app = %s", $result1->username);
                $results3 = $wpdb->get_results($sql3);
                foreach ($results3 as $result3) {
                    $data_entry["firstname"] = $result3->zalo_name;
                    $data_entry["last_name"] = ""; // Gán last_name là rỗng
                }
                } else {
                    $data_entry["firstname"] = $result1->first_name;
                    $data_entry["last_name"] = $result1->last_name;
                }
                 $data_entry["created_at"] = $result->created_at;
                $data_entry["updated_at"] = $result->updated_at;
            }

            $sql2 = $wpdb->prepare("SELECT * FROM $tags_table WHERE id = %d", $result->fkTag);
            $results2 = $wpdb->get_results($sql2);
            foreach ($results2 as $result2) {
                $data_entry["NameTag"] = $result2->Name;
            }

            $data[] = $data_entry;
        }

                echo json_encode(array("data" => $data));
            } else {
                echo json_encode(array("data" => array()));
            }
        } else {
            echo json_encode(array("error" => "Invalid tag ID"));
        }



    wp_die(); // Kết thúc xử lý AJAX
}
// Xóa customer tag
function delete_customer_tag() {
    if (isset($_POST['id'])) {
        global $wpdb; // Sử dụng đối tượng $wpdb của WordPress để thực hiện truy vấn SQL
        $id = intval($_POST['id']);
        
        // Thực hiện câu lệnh SQL để xóa bản ghi với fkCustomer = tag_id
        $table_name = $wpdb->prefix . 'customer_tag'; // Thay thế 'your_table_name' bằng tên bảng của bạn
        $where_clause = array('id' => $id);
        
        $result = $wpdb->delete($table_name, $where_clause);
        
        if ($result !== false) {
            echo 'Customer tag has been deleted successfully.';
        } else {
            echo 'Failed to delete customer tag.';
        }
    }
    wp_die(); // Luôn gọi wp_die() ở cuối hàm callback Ajax.
}

add_action('wp_ajax_delete_customer_tag', 'delete_customer_tag'); // Đối với người dùng đã đăng nhập
add_action('wp_ajax_nopriv_delete_customer_tag', 'delete_customer_tag'); // Đối với người dùng chưa đăng nhập
// Lấy customer
function get_customer_lookup_data() {
    global $wpdb; // Sử dụng đối tượng $wpdb để thực hiện truy vấn SQL

    $table_name = $wpdb->prefix . 'wc_customer_lookup'; // Thay thế 'wp_' bằng tiền tố bảng thực tế của bạn
    $zalo_followers_table = $wpdb->prefix . 'zalo_followers'; // Thay thế 'wp_' bằng tiền tố bảng thực tế của bạn
    
    $query = "SELECT zalo_id, zalo_id_by_app, zalo_name, zalo_url_img FROM $zalo_followers_table ";

// Câu lệnh SQL để lấy tất cả dữ liệu

    $results = $wpdb->get_results($query, ARRAY_A);

    if ($results) {
        echo json_encode($results); // Trả về dữ liệu dưới dạng JSON
    } else {
        echo 'No data found.';
    }

    wp_die();
}

add_action('wp_ajax_get_customer_lookup_data', 'get_customer_lookup_data'); // Đối với người dùng đã đăng nhập
add_action('wp_ajax_nopriv_get_customer_lookup_data', 'get_customer_lookup_data'); // Đối với người dùng chưa đăng nhập

//Thêm tag khách hang
function customer_tag_add_callback() {
    global $wpdb;

    // Xử lý yêu cầu AJAX ở đây
    $formData = $_POST['formData'];
    // Thực hiện câu lệnh SQL để thêm dữ liệu vào cơ sở dữ liệu
    parse_str($formData, $outputArray);

    $fkTag = $outputArray['fk_tag'];
    $fkCustomer = $outputArray['fk_customer'];
    $zalo_id_parts = explode(".", $fkCustomer);

    if (count($zalo_id_parts) == 2) {
        $zalo_id = $zalo_id_parts[0];
        $zalo_id_by_app = $zalo_id_parts[1];
    } else {
        // Xử lý trường hợp không có dấu chấm hoặc nhiều hơn 2 phần
        // Tùy thuộc vào logic ứng dụng của bạn, bạn có thể gán giá trị mặc định hoặc thực hiện xử lý khác.
        $zalo_id = "";
        $zalo_id_by_app = "";
    }
    $table_name = $wpdb->prefix . 'customer_tag'; // Lấy tên bảng với tiền tố của WordPress
    $sql = $wpdb->prepare(
        "INSERT INTO $table_name (fkTag, zalo_user_id, zalo_user_id_by_app) VALUES (%d, %d, %d)",
        $fkTag, $zalo_id, $zalo_id_by_app
    );
    
    $result = $wpdb->query($sql);

    
    if ($result !== false) {
        echo "success" ; // Trả về thông báo thành công
    } else {
        echo "error"; // Trả về thông báo lỗi
    }

    wp_die();
}

add_action('wp_ajax_customer_tag_add', 'customer_tag_add_callback');
add_action('wp_ajax_nopriv_customer_tag_add', 'customer_tag_add_callback');


// Xử lý AJAX xóa dữ liệu bảng Tags
add_action('wp_ajax_delete_tag', 'delete_tag_callback');
add_action('wp_ajax_nopriv_delete_tag', 'delete_tag_callback');

function delete_tag_callback() {
    global $wpdb;

    $tag_id = $_POST['tag_id'];
    // Xóa bản ghi từ cơ sở dữ liệu
    $result = $wpdb->delete(
        "{$wpdb->prefix}tags",
        array('id' => $tag_id),
        array('%d')
    );

    if ($result !== false) {
        echo 'success';
    } else {
        echo 'error';
    }

    wp_die();
    
}
// Xử lý AJAX cập nhật
add_action('wp_ajax_update_tag', 'update_tag_callback');
add_action('wp_ajax_nopriv_update_tag', 'update_tag_callback');

function update_tag_callback() {
    global $wpdb;

    $tag_id = $_POST['tag_id'];
    $new_name = sanitize_text_field($_POST['new_name']);
    
    // Cập nhật bản ghi trong cơ sở dữ liệu
    $result = $wpdb->update(
        "{$wpdb->prefix}tags",
        array('Name' => $new_name),
        array('id' => $tag_id),
        array('%s'),
        array('%d')
    );

    if ($result !== false) {
        echo 'success';
    } else {
        echo 'error';
    }

    wp_die();
}


// Thêm action để xử lý AJAX request lấy tags
add_action('wp_ajax_get_tags', 'get_tags_callback');
add_action('wp_ajax_nopriv_get_tags', 'get_tags_callback');

function get_tags_callback() {
    global $wpdb;

    // Truy vấn để lấy dữ liệu từ bảng tags
    $tags = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tags");

    // Trả về dữ liệu dưới dạng JSON
    wp_send_json($tags);
}

// Thêm action để xử lý lấy product
// Thêm action để xử lý AJAX request
add_action('wp_ajax_get_products', 'get_products_callback');
add_action('wp_ajax_nopriv_get_products', 'get_products_callback');

function get_products_callback() {
    $products = array();

    // Truy vấn danh sách sản phẩm từ WooCommerce
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    while ($query->have_posts()) : $query->the_post();
        $product_id = get_the_ID();
        $product_title = get_the_title();

        $products[] = array(
            'id' => $product_id,
            'title' => $product_title,
        );
    endwhile;

    wp_reset_postdata();

    // Trả về dữ liệu dưới dạng JSON
    wp_send_json($products);
}
// Xử lý AJAX lấy tag option
add_action('wp_ajax_get_tagging_options', 'get_tagging_options_callback');
add_action('wp_ajax_nopriv_get_tagging_options', 'get_tagging_options_callback');

function get_tagging_options_callback() {
    global $wpdb;

    // Truy vấn để lấy dữ liệu từ bảng wp_tagging_option
    $tagging_options = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tagging_option");

    // Trả về dữ liệu dưới dạng JSON
    wp_send_json($tagging_options);
}
// Xử lý thêm Tagging
add_action('wp_ajax_save_tagging_data', 'save_tagging_data_callback');
add_action('wp_ajax_nopriv_save_tagging_data', 'save_tagging_data_callback');

function save_tagging_data_callback() {
    global $wpdb;

    // Lấy dữ liệu từ request
    $fkTag = sanitize_text_field($_POST['fkTag']);
    $name = sanitize_text_field($_POST['Name']);
    $conditions =$_POST['Setting'];
    $settingData = array();
    foreach ($conditions as $condition) {
        $filterName = $condition['filter'];
        $settingData[$filterName] = array(
            'value' => (int)$condition['value'],
            'condition' => $condition['condition'],
            'fk_product' => (int)$condition['fkProduct']
        );
    }

    $settingJson = json_encode($settingData);   
    $fromDay = intval($_POST['FromDay']);
    $repeatDay = intval($_POST['RepeatDay']);
    $fkTagCurrent = sanitize_text_field($_POST['fkTagCurrent']);

    // Thêm dữ liệu vào bảng wp_tagging
    $wpdb->insert(
        $wpdb->prefix . 'tagging',
        array(
            'fkTag' => $fkTag,
            'Name' => $name,
            'Setting' => $settingJson,
            'FromDay' => $fromDay,
            'RepeatDay' => $repeatDay,
            'fkTagCurrent' => $fkTagCurrent
        ),
        array('%d', '%s', '%s', '%d', '%d', '%s')
    );

    // Trả về kết quả cho client (có thể trả về thông báo thành công hoặc mã lỗi)
    // echo json_encode(array('status' => 'success'));
     return new WP_REST_Response(array('status' => 'success'), 200);
    wp_die(); // Kết thúc xử lý AJAX
}
// Lấy dữ liệu tagging 
add_action('wp_ajax_get_tagging_data', 'get_tagging_data_callback');
add_action('wp_ajax_nopriv_get_tagging_data', 'get_tagging_data_callback');

function get_tagging_data_callback() {
    global $wpdb;

    $tagging_table = $wpdb->prefix . 'tagging'; // Thay 'tagging' bằng tên bảng thực tế
    $tag_table = $wpdb->prefix . 'tags'; // Thay 'tags' bằng tên bảng thực tế

    $query = "SELECT t.*, tg.Name as TagName
              FROM $tagging_table t
              INNER JOIN $tag_table tg ON t.fkTag = tg.id"; // Thực hiện truy vấn kết hợp
    $results = $wpdb->get_results($query);

    $data = array();
    foreach ($results as $result) {
        $data[] = array(
            'id' => $result->id,
            'fkTag' => $result->TagName, // Sử dụng TagName thay vì fkTag
            'Name' => $result->Name,
            'Setting' => json_decode($result->Setting),
            'FromDay' => $result->FromDay,
            'RepeatDay' => $result->RepeatDay,
            'LastTimeRun' => $result->LastTimeRun,
            'fkTagCurrent' => $result->fkTagCurrent
        );
    }

    wp_send_json($data);
}
// Xử lý Ajax xóa tagging
add_action('wp_ajax_delete_tagging_record', 'delete_tagging_record_callback');

function delete_tagging_record_callback() {
    if (!isset($_POST['id'])) {
        wp_send_json(array('status' => 'error', 'message' => 'Missing ID'));
    }

    $id = intval($_POST['id']);

    global $wpdb;
    $table_name = $wpdb->prefix . 'tagging';

    $result = $wpdb->delete($table_name, array('id' => $id));

    if ($result) {
        wp_send_json(array('status' => 'success', 'message' => 'Record deleted successfully'));
    } else {
        wp_send_json(array('status' => 'error', 'message' => 'Error deleting record'));
    }
}
// Action cập nhật tagging
add_action('wp_ajax_update_tagging', 'update_tagging_callback');
add_action('wp_ajax_nopriv_update_tagging', 'update_tagging_callback'); // Cho phép cả người dùng không đăng nhập gọi action

function update_tagging_callback() {
    if (isset($_POST['PrimaryKey']) && isset($_POST['fkTag']) && isset($_POST['Name']) && isset($_POST['Setting']) && isset($_POST['FromDay']) && isset($_POST['RepeatDay']) && isset($_POST['fkTagCurrent'])) {
        global $wpdb;
        
        $id = sanitize_text_field($_POST['PrimaryKey']);
        $fkTag = sanitize_text_field($_POST['fkTag']);
        $name = sanitize_text_field($_POST['Name']);
        $conditions = $_POST['Setting'];// Dữ liệu JSON đã được chuẩn hóa trong JavaScript
        $settingData = array();
        foreach ($conditions as $condition) {
            $filterName = $condition['filter'];
            $settingData[$filterName] = array(
                'value' => (int)$condition['value'],
                'condition' => $condition['condition'],
                'fk_product' => (int)$condition['fkProduct']
            );
        }
        $settingJson = json_encode($settingData); 
        $fromDay = sanitize_text_field($_POST['FromDay']);
        $repeatDay = sanitize_text_field($_POST['RepeatDay']);
        $fkTagCurrent = sanitize_text_field($_POST['fkTagCurrent']);
        
        $tagging_table = $wpdb->prefix . 'tagging'; // Thay 'tagging' bằng tên bảng thực tế
        
        // Dữ liệu cần cập nhật
        $data = array(
            'fkTag' => $fkTag,
            'Name' => $name,
            'Setting' => $settingJson,
            'FromDay' => $fromDay,
            'RepeatDay' => $repeatDay,
            'fkTagCurrent' => $fkTagCurrent
        );
        
        // Điều kiện cập nhật cho dòng có ID tương ứng
        $where = array('id' => $id);
        
        // Cập nhật dữ liệu trong bảng wp_tagging
        $updated = $wpdb->update($tagging_table, $data, $where);
        
        if ($updated !== false) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }
    wp_die(); // Dừng tiến trình và trả về phản hồi
}
// API Tag Plugin

// Api tagging
function tagging_api() {
    global $wpdb;

    // Tên bảng wp_tagging
    $table_name = $wpdb->prefix . 'tagging';

    // Truy vấn để lấy tất cả dữ liệu từ bảng wp_tagging
    $query = "SELECT * FROM $table_name";
    $results = $wpdb->get_results($query);

    // Kiểm tra xem có kết quả không
    if ($results) {
        // Trả về kết quả dưới dạng JSON
        wp_send_json($results);
    } else {
        // Trả về thông báo lỗi nếu không có dữ liệu
        wp_send_json(['error' => 'No data found']);
    }
}

// Đăng ký một route API
add_action('rest_api_init', function () {
    register_rest_route('tagging/v1', 'get-tagging-data', [
        'methods' => 'GET',
        'callback' => 'tagging_api',
    ]);
});

// API customer tag
//Lấy dữ liệu customer tag theo fkTag
function customer_tag_api($request) {
    global $wpdb;

    // Kiểm tra xem có tham số fkTag trong yêu cầu không
    $fkTag = $request->get_param('fkTag');

    if (empty($fkTag)) {
        return new WP_Error('missing_param', 'Missing parameter fkTag', ['status' => 400]);
    }

    // Tên bảng wp_customer_tag
    $customer_tag_table = $wpdb->prefix . 'customer_tag';

    // Truy vấn để lấy dữ liệu từ bảng wp_customer_tag dựa trên fkTag
    $query = $wpdb->prepare("SELECT * FROM $customer_tag_table WHERE fkTag = %d", $fkTag);
    $results = $wpdb->get_results($query);

    // Kiểm tra xem có kết quả không
    if ($results) {
        // Trả về kết quả dưới dạng JSON
        return $results;
    } else {
        // Trả về thông báo lỗi nếu không có dữ liệu
        return new WP_Error('no_data', 'No data found for fkTag', ['status' => 404]);
    }
}

// Đăng ký một route API
add_action('rest_api_init', function () {
    register_rest_route('customer-tag/v1', 'get-customer-tag', [
        'methods' => 'GET',
        'callback' => 'customer_tag_api',
    ]);
});
//Xóa dữ liệu customer tag theo fkTag
// Register a custom REST API route for deleting a record by fkTag
function register_custom_delete_tag_endpoint() {
    register_rest_route('delete-customer-tag/v1', 'delete-tag/(?P<fkTag>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'delete_tag',
        'args' => [
            'fkTag' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                },
            ],
        ],
    ]);
}
add_action('rest_api_init', 'register_custom_delete_tag_endpoint');

// Callback function for deleting the record
function delete_tag($request) {
    global $wpdb;

    // Get the fkTag from the URL parameter
    $fkTag = $request->get_param('fkTag');

    // Name of the wp_customer_tag table
    $customer_tag_table = $wpdb->prefix . 'customer_tag';

    // Delete the record with matching fkTag
    $result = $wpdb->delete($customer_tag_table, ['fkTag' => $fkTag]);

    if ($result !== false) {
        return ['message' => 'Record deleted successfully'];
    } else {
        return new WP_Error('delete_error', 'Failed to delete record', ['status' => 500]);
    }
}
// Thêm customer tag
// Register a custom REST API route for adding a record
function register_custom_add_tag_endpoint() {
    register_rest_route('add-customer-tag/v1', 'add-tag', [
        'methods' => 'POST',
        'callback' => 'add_customer_tag',
    ]);
}
add_action('rest_api_init', 'register_custom_add_tag_endpoint');

// Callback function for adding a record
function add_customer_tag($request) {
    global $wpdb;

    // Get the data from the request
    $data = $request->get_json_params();
    
    // Validate the data (make sure fkCustomer, fkTag, zalo_user_id, and zalo_user_by_app are provided) || empty($data['zalo_user_id']) || empty($data['zalo_user_id_by_app'])
    if (empty($data['fkCustomer']) || empty($data['fkTag'])) {
        return new WP_Error('invalid_data', 'fkCustomer, fkTag, zalo_user_id, and zalo_user_by_app are required', ['status' => 400]);
    }
    
    // Name of the wp_customer_tag table
    $customer_tag_table = $wpdb->prefix . 'customer_tag';
    
    // Prepare the data to insert
    $insert_data = [
        'fkCustomer' => $data['fkCustomer'],
        'fkTag' => $data['fkTag'],
        'zalo_user_id' => $data['zalo_user_id'],
        'zalo_user_id_by_app' => $data['zalo_user_id_by_app'],
    ];
    
    // Insert the record into wp_customer_tag table
    $result = $wpdb->insert($customer_tag_table, $insert_data);
    
    if ($result !== false) {
        return ['message' => 'Record added successfully'];
    } else {
        return new WP_Error('insert_error', 'Failed to insert record', ['status' => 500]);
    }

}
//  api chat bot 

function register_save_log_endpoint () {
    register_rest_route('save-message-log', '/handle', [
        'methods' => 'POST',
        'callback' => 'handle_save_message_log',
    ]);
    register_rest_route('chat-bot/v1', '/change', [
        'methods' => 'GET',
        'callback' => 'handle_change_status_chatbot',
    ]);

    register_rest_route('chat-bot/v1','/status', [
        'methods' => 'GET',
        'callback' => 'handle_get_status_chatbot',
    ]);
}

add_action('rest_api_init', 'register_save_log_endpoint');

function handle_change_status_chatbot() {
    $status = $_GET['status'];
    // return $status;
    if ($status == 1) {
        update_option('zalo_follow_management_chatbot_ai_status', 'true');
    } else {
        update_option('zalo_follow_management_chatbot_ai_status', 'false');
    }
    return get_option('zalo_follow_management_chatbot_ai_status');
}
function handle_get_status_chatbot(){
    return get_option('zalo_follow_management_chatbot_ai_status');
}
function handle_save_message_log ($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'zalo_chatbot_log';
    $response = array();
    // Lấy dữ liệu từ request body và chuyển nó thành một mảng dữ liệu PHP.
    $request_data = $request->get_json_params();

    if (empty($request_data)) {
        $response['message'] = 'No POST data received';
    } else {
        $wpdb->query("SET time_zone = 'Asia/Ho_Chi_Minh'");
        $wpdb->insert(
            $table_name,
            array(
                'fkCustomer'=> $request_data['fkCustomer'],
                'question'  => $request_data['question'],
                'answer'    => $request_data['answer'],
                'token'     => $request_data['token'],
                'type_error' => $request_data['type_error'],
                'function_call' => $request_data['function_call'],
                'message_error' => $request_data['message_error'],
                'duration' => $request_data['duration']
            )
        );
        $response['message'] = 'Saved';
        $response['saved_data'] = $request_data;
    }

    return new WP_REST_Response($response, 200);

}

// Lấy customer_id
function register_custom_customer_id_endpoint() {
    register_rest_route('custom-api/v1', 'get-customer-id', [
        'methods' => 'GET',
        'callback' => 'custom_get_customer_id',
    ]);
}
add_action('rest_api_init', 'register_custom_customer_id_endpoint');

// Callback function for getting customer_id
function custom_get_customer_id($request) {
    global $wpdb;

    // Get the user_id parameter from the request
    $user_id = $request->get_param('user_id');

    // Name of the wc_customer_lookup table
    $customer_lookup_table = $wpdb->prefix . 'wc_customer_lookup';
    $zalo_followers_table = $wpdb->prefix . 'zalo_followers';
    // Prepare the SQL query to fetch customer_id by user_id
    $query = $wpdb->prepare(
        "SELECT cl.customer_id, zf.zalo_id, zf.zalo_id_by_app
    FROM $customer_lookup_table AS cl
    LEFT JOIN $zalo_followers_table AS zf ON cl.username = zf.zalo_id_by_app
    WHERE cl.user_id = %d",
        $user_id
    );

    // Execute the SQL query
    $results = $wpdb->get_results($query);

    if ($results !== null) {
        return $results;
    } else {
        return new WP_Error('not_found', 'Customer not found', ['status' => 404]);
    }
}

//APi cập nhật LastTimeRun
// Register a custom REST API route for updating LastTimeRun
function register_custom_update_last_time_run_endpoint() {
    register_rest_route('custom-api/v1', 'update-last-time-run', [
        'methods' => 'POST',
        'callback' => 'custom_update_last_time_run',
    ]);
}
add_action('rest_api_init', 'register_custom_update_last_time_run_endpoint');

// Callback function for updating LastTimeRun by ID
function custom_update_last_time_run($request) {
    global $wpdb;

    // Get the ID and new date value from the request
    $id = $request->get_param('id');
    $new_date = $request->get_param('new_date');

    // Name of the custom table where LastTimeRun is stored
    $custom_table = $wpdb->prefix . 'tagging'; // Replace with your table name

    // Prepare the SQL query to update LastTimeRun based on ID
    $query = $wpdb->prepare(
        "UPDATE $custom_table SET LastTimeRun = %s WHERE id = %d",
        $new_date,
        $id
    );

    // Execute the SQL query
    $result = $wpdb->query($query);

    if ($result !== false) {
        return ['message' => 'LastTimeRun updated successfully'];
    } else {
        return new WP_Error('update_failed', 'Failed to update LastTimeRun', ['status' => 500]);
    }
}

// Lấy user_id từ customer_id
// Register a custom REST API route for getting user_id by customer_id
function register_custom_user_id_endpoint() {
    register_rest_route('custom-api/v1', 'get-user-id', [
        'methods' => 'GET',
        'callback' => 'custom_get_user_id',
    ]);
}
add_action('rest_api_init', 'register_custom_user_id_endpoint');

// Callback function for getting user_id
function custom_get_user_id($request) {
    global $wpdb;

    // Get the customer_id parameter from the request
    $customer_id = $request->get_param('customer_id');

    // Name of the wc_customer_lookup table
    $customer_lookup_table = $wpdb->prefix . 'wc_customer_lookup';

    // Prepare the SQL query to fetch user_id by customer_id
    $query = $wpdb->prepare(
        "SELECT user_id FROM $customer_lookup_table WHERE customer_id = %d",
        $customer_id
    );

    // Execute the SQL query
    $user_id = $wpdb->get_var($query);

    if ($user_id !== null) {
        return ['user_id' => $user_id];
    } else {
        return new WP_Error('not_found', 'User not found', ['status' => 404]);
    }
}
//Api lấy user_id và meta_value theo metakey là birthday
function register_custom_user_birthday_endpoint() {
    register_rest_route('custom-api/v1', 'get-user-birthday', [
        'methods' => 'GET',
        'callback' => 'custom_get_user_birthday',
    ]);
}
add_action('rest_api_init', 'register_custom_user_birthday_endpoint');

// Callback function for fetching user_id and birthday
function custom_get_user_birthday($request) {
    global $wpdb;

    // Define the meta_key for birthday
    $meta_key = 'birthday';

    // Get user_id and meta_value where meta_key is 'birthday'
    $query = $wpdb->prepare(
        "SELECT user_id, meta_value FROM $wpdb->usermeta WHERE meta_key = %s",
        $meta_key
    );

    $results = $wpdb->get_results($query);

    if ($results) {
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'user_id' => $result->user_id,
                'birthday' => $result->meta_value,
            ];
        }
        return $data;
    } else {
        return new WP_Error('not_found', 'No user birthdays found', ['status' => 404]);
    }
}
//API check customer tag có tồn tại không
function register_custom_check_data_endpoint() {
    register_rest_route('custom-api/v1', 'check-data', [
        'methods' => 'POST',
        'callback' => 'custom_check_data',
    ]);
}
add_action('rest_api_init', 'register_custom_check_data_endpoint');

// Callback function for checking data
function custom_check_data($request) {
    global $wpdb;

    // Get the data from the request
    $data = $request->get_json_params();

    // Extract fkCustomer and fkTag from data
    $fkCustomer = $data['fkCustomer'];
    $fkTag = $data['fkTag'];

    // Name of the wp_customer_tag table
    $customer_tag_table = $wpdb->prefix . 'customer_tag';

    // Prepare the SQL query to check if data exists
    $query = $wpdb->prepare(
        "SELECT COUNT(*) FROM $customer_tag_table WHERE fkCustomer = %d AND fkTag = %d",
        $fkCustomer,
        $fkTag
    );

    // Execute the SQL query to count rows
    $count = $wpdb->get_var($query);

    if ($count > 0) {
        // Data exists, return true
        return true;
    } else {
        // Data does not exist, return false
        return false;
    }
}

//thêm lịch sử gửi zns
function add_sent_history_data_callback($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sent_zns_history';

    $data = json_decode($request->get_body(), true);

    if (is_array($data)) {
        $sent_date = isset($data['sent_date']) ? sanitize_text_field($data['sent_date']) : '';
        $tracking_id = isset($data['tracking_id']) ? sanitize_text_field($data['tracking_id']) : '';
        $customer_id = isset($data['customer_id']) ? intval($data['customer_id']) : 0;
        $customer_name = isset($data['customer_name']) ? sanitize_text_field($data['customer_name']) : '';
        $customer_phone = isset($data['customer_phone']) ? sanitize_text_field($data['customer_phone']) : '';
        $order_id = isset($data['order_id']) ? intval($data['order_id']) : 0;
        $status = isset($data['status']) ? (bool) $data['status'] : false;
        $error_details = isset($data['error_details']) ? sanitize_text_field($data['error_details']) : '';
        $type= isset($data['type']) ? sanitize_text_field($data['type']) : '';
        $wpdb->insert(
            $table_name,
            array(
                'type' => $type,
                'sent_date' => $sent_date,
                'tracking_id' => $tracking_id,
                'customer_id' => $customer_id,
                'customer_name' => $customer_name,
                'customer_phone' => $customer_phone,
                'order_id' => $order_id,
                'status' => $status,
                'error_details' => $error_details,
            ),
            array( '%s' ,'%s', '%s', '%d', '%s', '%s', '%d', '%d', '%s')
        );

        $inserted_id = $wpdb->insert_id;
        if ($inserted_id) {
            return rest_ensure_response(array('message' => 'Data added successfully. Inserted ID: ' . $inserted_id));
        } else {
            return new WP_Error('insert_error', 'Failed to add data', array('status' => 500));
        }
    } else {
        return new WP_Error('invalid_data', 'Invalid data provided', array('status' => 400));
    }
}

function register_add_sent_history_api_endpoint() {
    register_rest_route('zalo-management/v1', '/add-sent-zns-or-transaction-history-data', array(
        'methods' => 'POST',
        'callback' => 'add_sent_history_data_callback',
    ));
}

add_action('rest_api_init', 'register_add_sent_history_api_endpoint');


function getCustomerDataList() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'zalo_followers';
    $draw = $_GET['draw'];
    $start = $_GET["start"];
    $length = $_GET["length"]; 
    $columnIndex_arr = $_GET['order'];
    $columnName_arr = $_GET['columns'];
    $order_arr = $_GET['order'];
    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $search_arr = $_GET['search'];
	$searchValue = $search_arr['value']; // Search value
    //xử lý fillter ở đây
    $dateRange = $_GET['dateRange'];
    $linkedStatus = $_GET['linkedStatus'];
    $followStatus = $_GET['followStatus'];
    
    // Build the SQL query
    if(empty($searchValue))
        $query = "SELECT zf.id, zf.Zalo_ID, zf.Zalo_Name, zf.Zalo_URL_Img, zf.Zalo_ID_By_App, zf.Follow_Status, zf.Follow_Start_Date, zf.Unfollow_Date, zf.fk_wc_customer_id, cl.first_name, cl.last_name, um.meta_value AS billing_address_1 FROM $table_name AS zf LEFT JOIN {$wpdb->prefix}wc_customer_lookup AS cl ON zf.fk_wc_customer_id = cl.customer_id LEFT JOIN {$wpdb->prefix}usermeta AS um ON cl.user_id = um.user_id AND um.meta_key = 'billing_address_1' WHERE 1=1";        
    else 
        $query = "SELECT zf.id, zf.Zalo_ID, zf.Zalo_Name, zf.Zalo_URL_Img, zf.Zalo_ID_By_App, zf.Follow_Status, zf.Follow_Start_Date, zf.Unfollow_Date, zf.fk_wc_customer_id, cl.first_name, cl.last_name, um.meta_value AS billing_address_1 FROM $table_name AS zf LEFT JOIN {$wpdb->prefix}wc_customer_lookup AS cl ON zf.fk_wc_customer_id = cl.customer_id LEFT JOIN {$wpdb->prefix}usermeta AS um ON cl.user_id = um.user_id AND um.meta_key = 'billing_address_1' WHERE (zf.Zalo_Name LIKE '%$searchValue%' OR zf.Zalo_ID_By_App LIKE '%$searchValue%' OR zf.Follow_Start_Date LIKE '%$searchValue%' OR zf.Unfollow_Date LIKE '%$searchValue%' OR cl.first_name LIKE '%$searchValue%' OR cl.last_name LIKE '%$searchValue%' OR um.meta_value LIKE '%$searchValue%') ";
    $query_count_record= "SELECT COUNT(zf.id) as record_count FROM {$wpdb->prefix}zalo_followers AS zf LEFT JOIN {$wpdb->prefix}wc_customer_lookup AS cl ON zf.fk_wc_customer_id = cl.customer_id LEFT JOIN {$wpdb->prefix}usermeta AS um ON cl.user_id = um.user_id AND um.meta_key = 'billing_address_1' WHERE 1=1";
    // Thêm điều kiện cho bộ lọc
    if (!empty($dateRange)) {
        // Khởi tạo ngày bắt đầu và ngày kết thúc mặc định
        $startDate = '';
        $endDate = '';
    
        // Xác định ngày bắt đầu và kết thúc dựa trên giá trị của $dateRange
        switch ($dateRange) {
            case 'today':
                $startDate = date('Y-m-d', strtotime('today'));
                $endDate = date('Y-m-d', strtotime('today'));
                break;
            case 'yesterday':
                $startDate = date('Y-m-d', strtotime('yesterday'));
                $endDate = date('Y-m-d', strtotime('yesterday'));
                break;
            case 'this_week':
                $startDate = date('Y-m-d', strtotime('this week'));
                $endDate = date('Y-m-d', strtotime('today'));
                break;
            case 'last_week':
                $startDate = date('Y-m-d', strtotime('last week'));
                $endDate = date('Y-m-d', strtotime('last week +6 days'));
                break;
            case 'this_month':
                $startDate = date('Y-m-d', strtotime('first day of this month'));
                $endDate = date('Y-m-d', strtotime('today'));
                break;
            case 'last_month':
                $startDate = date('Y-m-d', strtotime('first day of last month'));
                $endDate = date('Y-m-d', strtotime('last day of last month'));
                break;
            case '6_months_ago':
                $startDate = date('Y-m-d', strtotime('-6 months'));
                $endDate = date('Y-m-d', strtotime('today'));
                break;
            case '1_year_ago':
                $startDate = date('Y-m-d', strtotime('-1 year'));
                $endDate = date('Y-m-d', strtotime('today'));
                break;
        }
        
        // Thêm điều kiện vào câu truy vấn SQL
        if (!empty($startDate) && !empty($endDate)) {
            $query .= " AND zf.Follow_Start_Date >= '$startDate' AND zf.Follow_Start_Date <= '$endDate' ";
            $query_count_record .= " AND zf.Follow_Start_Date >= '$startDate' AND zf.Follow_Start_Date <= '$endDate' ";
        }
        
    }

    if (!empty($linkedStatus)) {
        if ($linkedStatus === 'linked') {
            // Lấy những người đã có fk_wc_customer_id (không phải NULL)
            $query .= " AND zf.fk_wc_customer_id IS NOT NULL ";
            $query_count_record .= " AND zf.fk_wc_customer_id IS NOT NULL ";
        } elseif ($linkedStatus === 'not_linked') {
            // Lấy những người chưa có fk_wc_customer_id (NULL)
            $query .= " AND zf.fk_wc_customer_id IS NULL ";
            $query_count_record .= " AND zf.fk_wc_customer_id IS NULL ";
        }
    }

    if (!empty($followStatus)) {
        if ($followStatus === 'followed') {
            // Lấy những người có Follow_Status = 1
            $query .= " AND zf.Follow_Status = 1 ";
            $query_count_record .= " AND zf.Follow_Status = 1 ";
        } elseif ($followStatus === 'unfollowed') {
            // Lấy những người có Follow_Status = 0
            $query .= " AND zf.Follow_Status = 0 ";
            $query_count_record .= " AND zf.Follow_Status = 0 ";
        }
    }
    //tính tổng số record lấy về được
    $recordCount = $wpdb->get_var($query_count_record);
    //kết thúc thêm điều kiện bộ lọc
    
    if ($columnSortOrder == 'desc') {
        $recordsOrder = " ORDER BY $columnName DESC ";
    } elseif ($columnSortOrder == 'asc') {
        $recordsOrder = " ORDER BY $columnName ASC ";
    } else {
        $recordsOrder = " ORDER BY zf.Follow_Start_Date DESC ";
    }
    $query .=  $recordsOrder. " LIMIT $length OFFSET $start";
    $records = $wpdb->get_results($query);
    $data_arr = [];
    foreach ($records as $follower) {
        $dot="";
        if($follower->Follow_Status==1)
            $dot="dot dot-success";
        else
            $dot="dot dot-danger";
        $customer_name="";
        if($follower->fk_wc_customer_id==null)
            $customer_name="No linkage";
        else
            $customer_name=$follower->first_name." ".$follower->last_name;
        $follow_date=date('d/m/Y', strtotime($follower->Follow_Start_Date));
        $billing_address='';
        if($follower->billing_address_1==null)
            $billing_address='--';
        else
            $billing_address=$follower->billing_address_1;
        $link_route_user_chat=admin_url("admin.php?page=follower-chat&id=$follower->Zalo_ID");
        $link_route_user_detail=admin_url("admin.php?page=customer-detail&username=$follower->Zalo_ID_By_App&avt=$follower->Zalo_URL_Img&fk_wc_user_id=$follower->fk_wc_customer_id&zalo_id=$follower->Zalo_ID");
        $Zalo_URL_Img="<img src='$follower->Zalo_URL_Img' alt='Avatar' class='rounded-circle' style='width: 45px;' alt='Avatar'>";
        $Zalo_Name=$follower->Zalo_Name;
        $first_name= "<a href='$link_route_user_detail'>$customer_name</a>";
        $dot1="<div class='$dot'></div>";
        $dropdown="
            <div class='dropdown'>
                <button class='dropdown-item btn-action-menu' onclick='toggleDropdown($follower->id)'><i class='fas fa-ellipsis-v fa-lg'></i></button>
                <div class='dropdown-content' id='myDropdown$follower->id'>
                    <a id='chat' href='$link_route_user_chat' data-id='$follower->Zalo_ID_By_App' class='col ml-3 dropdown-item' data-bs-toggle='tooltip' data-bs-placement='top' title='Lịch sử chat'><i class='fas fa-envelope mr-1 larger-icon'></i> Chat history</a>
                    <a id='link-user' data-id='$follower->Zalo_ID_By_App' data-name='$follower->Zalo_Name' data-avatar='$follower->Zalo_URL_Img' class='col ml-3 dropdown-item' data-bs-toggle='tooltip' data-bs-placement='top' title='Liên kết khách hàng'><i class='fa-solid fa-link'></i> Linkage</a>
                    <a id='delete-user' data-id='' data-name='' data-avatar='' class='col ml-3 dropdown-item' data-bs-toggle='tooltip' data-bs-placement='top' title='Xóa zalo'><i class='fa-solid fa-trash'></i> Delete zalo</a>
                </div>
            </div>";
        $data_arr[] = [
            "Zalo_URL_Img" => $Zalo_URL_Img,
            "Zalo_Name" => $Zalo_Name,
            "Follow_Start_Date" => $follow_date,
            "first_name" => $first_name,
            "billing_address_1" => $billing_address,
            "dot" => $dot1,
            "dropdown" => $dropdown,
        ];
    }
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $recordCount,
        "iTotalDisplayRecords" => $recordCount,
        "aaData" => $data_arr
    );
    // return $query;
    // return $data_arr;
    // return $query_count_record . " LIMIT $length OFFSET $start";
    return $response;
    
}


function register_customer_data_list_api_endpoint() {
    register_rest_route('zalo-management/v1', '/get-customer-data-list', array(
        'methods' => 'GET',
        'callback' => 'getCustomerDataList',
    ));
}

add_action('rest_api_init', 'register_customer_data_list_api_endpoint');

function register_marketing_data_list_api_endpoint(){
    register_rest_route('marketing-management/v1', '/get-marketing-data-list', array(
        'methods' => 'GET',
        'callback' => 'getMarketingDataList',
    ));
}
add_action('rest_api_init', 'register_marketing_data_list_api_endpoint');
function getMarketingDataList() {
    global $wpdb;
    $draw = $_GET['draw'];
    $start = $_GET["start"];
    $length = $_GET["length"]; // Rows display per page

    $columnIndex_arr = $_GET['order'];
    $columnName_arr = $_GET['columns'];
    // return $columnIndex_arr;
    $order_arr = $_GET['order'];
    $search_arr = $_GET['search'];

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    // $columnIndex = $columnIndex_arr[0]['column'];
    // return $columnIndex;
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    // return $columnName;
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value
    // countTotalRow đếm số bảng ghi có UUID = UUID thêm url tham số m
    $ss_summary = $wpdb->get_results("SELECT COUNT(*) as count FROM {$wpdb->prefix}marketingcampaign WHERE 1")[0]->count;
    $recordsQuery = "SELECT {$wpdb->prefix}marketingcampaign.* FROM {$wpdb->prefix}marketingcampaign";
    

    if(isset($_GET['status'])){
        $status = $_GET['status'];
        $recordsWhere = " WHERE {$wpdb->prefix}marketingcampaign.isActive = '$status' ";
        $ss_summary = $wpdb->get_results("SELECT COUNT(*) as count FROM {$wpdb->prefix}marketingcampaign WHERE {$wpdb->prefix}marketingcampaign.isActive = '".$_GET['status']."'")[0]->count;
    }else{
        $recordsWhere = " WHERE 1 ";
    }
    
    if ($columnSortOrder == 'desc') {
        $recordsOrder = " ORDER BY $columnName DESC ";
    } elseif ($columnSortOrder == 'asc') {
        $recordsOrder = " ORDER BY $columnName ASC ";
    } else {
        $recordsOrder = " ORDER BY PrimaryKey DESC ";
    }
    // thêm đoạn truy vấn thông tin mà người dùng nhập vào ô tìm kiếm
    if ($searchValue) {
        $recordsWhere .= "AND ({$wpdb->prefix}marketingcampaign.PrimaryKey LIKE '%$searchValue%' OR {$wpdb->prefix}marketingcampaign.Name LIKE '%$searchValue%' OR {$wpdb->prefix}marketingcampaign.StartDate LIKE '%$searchValue%' OR {$wpdb->prefix}marketingcampaign.EndDate LIKE '%$searchValue%')";

        $recordsQuery .= $recordsWhere .$recordsOrder ." LIMIT $length" ;
        // return $recordsQuery;
        $records = $wpdb->get_results($recordsQuery ,ARRAY_A);
        $ss_summary = $wpdb->get_results("SELECT COUNT(*) as count FROM {$wpdb->prefix}marketingcampaign ". $recordsWhere)[0]->count;
        // $ss_summary = count($records); 
    } else {
        $recordsQuery .= $recordsWhere . $recordsOrder. " LIMIT $length OFFSET $start";
        $records = $wpdb->get_results($recordsQuery, ARRAY_A);
        $ss_summary = $wpdb->get_results("SELECT COUNT(*) as count FROM {$wpdb->prefix}marketingcampaign ". $recordsWhere)[0]->count;
        // $ss_summary = count($records);
    }
    // return $recordsQuery;
    $data_arr = [];
    // return $records;
    foreach ($records as $record) {
        $choose = '<input type="checkbox" name="schedue[]" class="check-schedule" value="'.$record['PrimaryKey'].'"/>';
        $code = $record['PrimaryKey'];
        $name = $record['Name'];
        $startdate = $record['StartDate'];
        $enddate = $record['EndDate'];

        $status = "<div class='dot dot-success'></div>";
       
        $active = '<div class="dropdown">
            <div class="action_view" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <a class="text-body dropdown-toggle" href="#">
                    <i class="mdi mdi-dots-vertical font-20"></i>
                </a>
            </div>
            <div class="dropdown-menu dropdown-menu-right">
                <a id="calendar" href="' . admin_url('admin.php?page=marketing-calendar&m=' . $record['UUID']) . '" class="dropdown-item">
                    <i class="mdi mdi-email-search"></i> <span key="Calendar_list">Danh sách lịch</span> 
                </a>
                <a id="detail" href="' . admin_url('admin.php?page=marketing-detail&id=' . $record['PrimaryKey'] . '&m=' . $record['UUID']) . '" class="dropdown-item">
                    <i class="mdi mdi-alert-circle-outline"></i> <span key="Details">Chi tiết</span> 
                </a>
                <a id="edit" href="' . admin_url('admin.php?page=marketing-edit&id=' . $record['PrimaryKey']) . '" class="dropdown-item">
                    <i class="mdi mdi-square-edit-outline"></i> <span key="Edit">Sửa</span> 
                </a>
                <a id="delete" data-href="' . admin_url('admin.php?page=marketing-delete&id=' . $record['UUID']) . '" class="dropdown-item" onClick="confirmDelete(this)">
                    <i class="mdi mdi-delete"></i> <span key="Remove">Xóa</span> 
                </a>
            </div>
        </div>';

      

        $data_arr[] = [
            "PrimaryKey" => $code,
            "Name" => $name,
            "StartDate" => $startdate,
            "EndDate" => $enddate,
            "Status" => $status,
            "Active" => $active,
        ];
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $ss_summary,
        "iTotalDisplayRecords" => $ss_summary,
        "aaData" => $data_arr
    );
    return $response;
    
}
function createQuatation($request){
    global $wpdb;
    $data = json_decode($request->get_body(), true);
    $customers = $data['users_id'];
    $products = $data['products'];
    $currentDate = $data['creationDate'];
    $wpdb->insert('wp_quotation', array(
        'quotationName' => $data['quotationName'],
        'creationDate' => $currentDate,
        'quotationStatus' => $data['quotationStatus'],
        'quotationTitle' => $data['quotationTitle'],
        'imgLink' => $data['imgLink'],
        'quotationContent' => $data['quotationContent'],
        'Fk_Product_ID_List' => $data['Fk_Product_ID_List'],
        'Product_Name_List' => $data['Product_Name_List'],
        'totalAmount' => $data['totalAmount']
    ));
    $quotation_id = $wpdb->insert_id;
    foreach ($customers as $customer_id) {
        $wpdb->insert('wp_customer_quotation_details', array(
            'Fk_quotation_id' => $quotation_id,
            'Fk_User_ID' => $customer_id
        ));
    }
    foreach ($products as $product) {
        $wpdb->insert('wp_product_quotation_details', array(
            'FK_quotation_id' => $quotation_id,
            'Fk_Product_ID' => $product['product_id'],
            'quantity' => $product['quantity']
        ));
    }
    if($data['quotationStatus']=="active"){
        $orderData = array();
        try{
            foreach ($customers as $customer_id) {
                $order = wc_create_order();
                $order->set_status('pending');
                $customer = new WC_Customer($customer_id);
                $customer_data = $customer->get_data();
                //lấy thông tin địa chỉ khách hàng
                $billing_address = $customer_data["billing"];
                $shipping_address = $customer_data["shipping"];
                foreach ($billing_address as $field => $value) {
                    if (empty($value)&& $field != "email") {
                        $billing_address[$field] = 'default '.$field;
                    }
                    if (empty($value)&& $field == "email") {
                        $billing_address[$field] = "defaultemail@email.com";
                    }
                }
                $order->set_address( $billing_address, 'billing' );
                $order->set_address( $shipping_address, 'shipping' );
                // Thêm khách hàng vào đơn hàng
                $order->set_customer_id($customer_id);
                // Thêm sản phẩm vào đơn hàng
                foreach ($products as $product) {
                    $product_id = $product['product_id'];
                    $quantity = $product['quantity'];
                    $product = wc_get_product($product_id);
                    $order->add_product($product, $quantity); 
                }
                //tính toán lại giá tiền
                $order->calculate_totals();
                // Lưu đơn hàng
                $order->save();
                $wpdb->insert('wp_quotation_sending_schedule', array(
                    'Fk_WC_Order_ID' => $order->get_id(),
                    'Fk_User_ID' => $customer_id,
                    'Fk_Quotation_ID' => $quotation_id
                ));
                $customerOrders[] = array(
                    'customer_id' => $customer_id,
                    'order_id' => $order->get_id()
                );
                $orderData = array_merge($orderData, $customerOrders);
            }
            $response = array('order_data' => $orderData);
            $jsonec=json_encode($response);
            return json_decode($jsonec);
        }
        catch ( Exception $e ) {
            return new WP_Error( 'error', $e->getMessage() );
        }
    }
    else{
        return $quotation_id;
    }
}


function register_create_quatation_api_endpoint() {
    register_rest_route('zalo-management/v1', '/create-quatation', array(
        'methods' => 'POST',
        'callback' => 'createQuatation',
    ));
}

add_action('rest_api_init', 'register_create_quatation_api_endpoint');

function publicQuatation($request){
    global $wpdb;
    $data = json_decode($request->get_body(), true);
    $quatationId=$data['id'];
    $newStatus = "active";
    $sql = $wpdb->prepare("UPDATE wp_quotation SET quotationStatus = %s WHERE id = %d", $newStatus, $quatationId);
    $wpdb->query($sql);
    $sql = $wpdb->prepare("SELECT Fk_User_ID FROM wp_customer_quotation_details WHERE Fk_quotation_id = %d", $quatationId);
    $results = $wpdb->get_results($sql);
    $customers = array();
    foreach ($results as $result) {
        $customers[] = $result->Fk_User_ID;
    }
    $sql = $wpdb->prepare("SELECT Fk_Product_ID, quantity FROM wp_product_quotation_details WHERE FK_quotation_id = %d", $quatationId);
    $results = $wpdb->get_results($sql);
    $products = array();
    foreach ($results as $result) {
        $product = array(
            "product_id" => $result->Fk_Product_ID,
            "quantity" => $result->quantity
        );
        $products[] = $product;
    }
    $orderData = array();
    try{
        foreach ($customers as $customer_id) {
            $order = wc_create_order();
            $order->set_status('pending');
            $customer = new WC_Customer($customer_id);
            $customer_data = $customer->get_data();
            //lấy thông tin địa chỉ khách hàng
            $billing_address = $customer_data["billing"];
            $shipping_address = $customer_data["shipping"];
            foreach ($billing_address as $field => $value) {
                if (empty($value)&& $field != "email") {
                    $billing_address[$field] = 'default '.$field;
                }
                if (empty($value)&& $field == "email") {
                    $billing_address[$field] = "defaultemail@email.com";
                }
            }
            $order->set_address( $billing_address, 'billing' );
            $order->set_address( $shipping_address, 'shipping' );
            // Thêm khách hàng vào đơn hàng
            $order->set_customer_id($customer_id);
            // Thêm sản phẩm vào đơn hàng
            foreach ($products as $product) {
                $product_id = $product['product_id'];
                $quantity = $product['quantity'];
                $product = wc_get_product($product_id);
                $order->add_product($product, $quantity); 
            }
            //tính toán lại giá tiền
            $order->calculate_totals();
            // Lưu đơn hàng
            $order->save();
            $wpdb->insert('wp_quotation_sending_schedule', array(
                'Fk_WC_Order_ID' => $order->get_id(),
                'Fk_User_ID' => $customer_id,
                'Fk_Quotation_ID' => $quatationId
            ));
            $customerOrders[] = array(
                'customer_id' => $customer_id,
                'order_id' => $order->get_id()
            );
            $orderData = array_merge($orderData, $customerOrders);
        }
        $response = array('order_data' => $orderData);
        $jsonec=json_encode($response);
        return json_decode($jsonec);
    }
    catch ( Exception $e ) {
        return new WP_Error( 'error', $e->getMessage() );
    }
}

function register_public_quatation_api_endpoint() {
    register_rest_route('zalo-management/v1', '/public-quatation', array(
        'methods' => 'POST',
        'callback' => 'publicQuatation',
    ));
}

add_action('rest_api_init', 'register_public_quatation_api_endpoint');

function editQuatation($request){
    global $wpdb;
    $data = json_decode($request->get_body(), true);
    $quatationId=$data['id'];
    $customers = $data['users_id'];
    $products = $data['products'];
    $currentDate = $data['creationDate'];
    $updatedata = array(
        'quotationName' => $data['quotationName'],
        'creationDate' => $currentDate,
        'quotationStatus' => $data['quotationStatus'],
        'quotationTitle' => $data['quotationTitle'],
        'imgLink' => $data['imgLink'],
        'quotationContent' => $data['quotationContent'],
        'Fk_Product_ID_List' => $data['Fk_Product_ID_List'],
        'Product_Name_List' => $data['Product_Name_List'],
        'totalAmount' => $data['totalAmount']
    );
    $where = array('id' => $quatationId);
    $updated = $wpdb->update('wp_quotation', $updatedata, $where);
    $customerDeleteQuery = $wpdb->prepare("DELETE FROM wp_customer_quotation_details WHERE Fk_quotation_id = %d", $quatationId);
    $wpdb->query($customerDeleteQuery);
    $productDeleteQuery = $wpdb->prepare("DELETE FROM wp_product_quotation_details WHERE FK_quotation_id = %d", $quatationId);
    $wpdb->query($productDeleteQuery);
    foreach ($customers as $customer_id) {
        $wpdb->insert('wp_customer_quotation_details', array(
            'Fk_quotation_id' => $quatationId,
            'Fk_User_ID' => $customer_id
        ));
    }
    foreach ($products as $product) {
        $wpdb->insert('wp_product_quotation_details', array(
            'FK_quotation_id' => $quatationId,
            'Fk_Product_ID' => $product['product_id'],
            'quantity' => $product['quantity']
        ));
    }
    return true;
}

function register_edit_quatation_api_endpoint() {
    register_rest_route('zalo-management/v1', '/edit-quatation', array(
        'methods' => 'POST',
        'callback' => 'editQuatation',
    ));
}

add_action('rest_api_init', 'register_edit_quatation_api_endpoint');

//fix lỗi webhook tự động disable
function overrule_webhook_disable_limit( $number ) {
    return 999999999999; 
}
add_filter( 'woocommerce_max_webhook_delivery_failures', 'overrule_webhook_disable_limit' );

//hàm trả về thông tin hình ảnh của trang view order nếu trạng thái chờ thanh toán
function getURL_Img_Thumbnail(){
    global $wpdb;
    $order_id=$_GET['orderId'];
    $order = wc_get_order($order_id);
    $payment_order_link="";
    $cancel_order_link="";
    if ($order) {
        $order_data = $order->get_data();
        $order_status = $order_data['status'];
        if($order_status=="pending"){
            $payment_order_link=$order->get_checkout_payment_url();
            $re=home_url().'/my-account/orders/';
            $cancel_order_link = $order->get_cancel_order_url($re);
        }
    }
    $sql = "SELECT q.imgLink
            FROM wp_quotation_sending_schedule s
            JOIN wp_quotation q ON s.Fk_Quotation_ID = q.id
            WHERE s.Fk_WC_Order_ID = %d";
    $result = $wpdb->get_var($wpdb->prepare($sql, $order_id));
    if ($result) {
        $imgLink = $result;
    } 
    
    $data = array(
        "order_status" => $order_status,
        "imgLink" => $imgLink,
        "payment_link" => $payment_order_link,
        "cancel_link" => $cancel_order_link
    );

    return new WP_REST_Response($data, 200);
}

function register_get_thumbnail_order_api_endpoint() {
    register_rest_route('zalo-management/v1', '/get-thumbnail-order', array(
        'methods' => 'GET',
        'callback' => 'getURL_Img_Thumbnail',
    ));
}

add_action('rest_api_init', 'register_get_thumbnail_order_api_endpoint');

function register_top_sales_product_wc() {
    register_rest_route('product-management/v1', '/product-sales', array(
        'methods' => 'GET',
        'callback' => 'getProducttopSales',
    ));
}

add_action('rest_api_init', 'register_top_sales_product_wc');

function getProducttopSales(){

	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 3,
		'meta_key' => 'total_sales',
		'orderby' => 'meta_value_num'
	);

    $getposts = new WP_query( $args);
    return $getposts;
}

function check_license_key(){
    $license_key= $_GET["license_key"];
    $request_data = json_encode(array("user_name" => $license_key));
    $api_url = "https://webhook.mekong-connector.com/count-request-api-key";
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
    // Thêm tiêu đề HTTP cho yêu cầu
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    // Thực hiện cuộc gọi API và lấy kết quả
    $response = curl_exec($ch);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        $data = json_decode($response, true);
        curl_close($ch);
        return $data;
    }
}
function register_check_license_key_api() {
    register_rest_route('zalo-management/v1', '/check_license_key', array(
        'methods' => 'GET',
        'callback' => 'check_license_key',
    ));
}
add_action('rest_api_init', 'register_check_license_key_api');

function submit_register_from($request){
    $data = json_decode($request->get_body(), true);
    $email_register= $data['email'];
    $fullname_register= $data['fullname'];
    $domain_register= get_site_url();
    $cleanedUrl = str_replace("https://", "", $domain_register);
    $company_register= $data['company'];
    $phone_register= $data['phone'];
    
    $api_url = 'https://webhook.mekong-connector.com/register-license';

    $data = json_encode(array(
        'email' => $email_register,
        'fullname' => $fullname_register,
        'domain' => $cleanedUrl,
        'company' => $company_register,
        'phone' => $phone_register
    ));

    $headers = array(
        'Content-Type: application/json',
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return 'cURL error: ' . curl_error($ch);
    }

    curl_close($ch);

    return $response;
    
}

function register_submit_register_from() {
    register_rest_route('zalo-management/v1', '/submit-register-from', array(
        'methods' => 'POST',
        'callback' => 'submit_register_from',
    ));
}
add_action('rest_api_init', 'register_submit_register_from');

function getWCOrderDataList() {
    global $wpdb;
    $draw = $_GET['draw'];
    $start = $_GET["start"];
    $length = $_GET["length"]; 
    $columnIndex_arr = $_GET['order'];
    $columnName_arr = $_GET['columns'];
    $order_arr = $_GET['order'];
    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $search_arr = $_GET['search'];
	$searchValue = $search_arr['value']; // Search value
    //xử lý fillter ở đây
    $user_id = $_GET['user_id'];
    
    $customer_orders = array(
        'customer' => $user_id, 
        'limit' => $length, 
        'offset' => $start, 
    );
    
    if ($columnSortOrder == 'desc') {
        $customer_orders['orderby'] = $columnName; 
        $customer_orders['order'] = "DESC";
    } elseif ($columnSortOrder == 'asc') {
        $customer_orders['orderby'] = $columnName; 
        $customer_orders['order'] = "ASC";
    } else {
        $customer_orders['orderby'] = "ID"; 
        $customer_orders['order'] = "DESC";
    }
    
    $records = wc_get_orders($customer_orders);
    $recordCount=wc_get_customer_order_count($user_id);
    $data_arr = [];
    foreach ($records as $order) {
        $order_id= $order->get_id();
        $order_detail_page= admin_url("post.php?post=$order_id&action=edit"); 
        $status = $order->get_status();
        $status_name = wc_get_order_status_name($status);
        // Một mảng ánh xạ giữa trạng thái và màu sắc badge tương ứng
        $status_badge_colors = array(
            'pending' => 'warning',  // Ví dụ: Màu và trạng thái tương ứng
            'failed' => 'danger',
            'processing' => 'info',
            'completed' => 'success',
            'on-hold' => 'primary',
            'cancelled' => 'secondary',
            'refunded' => 'secondary',
        );
        // Xác định màu sắc dựa trên trạng thái
        $badge_color = isset($status_badge_colors[$status]) ? $status_badge_colors[$status] : 'secondary';
        
        $order_id_element="<a href='$order_detail_page' class='view-order-details' target='_blank'>#$order_id</a>";
        $order_date= $order->get_date_created()->format('d/m/Y');
        $total= wc_price($order->get_total());
        $status_element="<span class='badge bg-$badge_color'>$status_name</span>";
        
        if(!empty($searchValue)){
            if (strpos("#".$order_id, $searchValue) !== false) {
                $data_arr[] = [
                    "ID" => $order_id_element,
                    "date" => $order_date,
                    "total" => $total,
                    "status" => $status_element,
                ];
            }
        }
        if(empty($searchValue)){
            $data_arr[] = [
                "ID" => $order_id_element,
                "date" => $order_date,
                "total" => $total,
                "status" => $status_element,
            ];
        }
    }
    if(!empty($searchValue)){
        $recordCount=count($data_arr);
    }
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $recordCount,
        "iTotalDisplayRecords" => $recordCount,
        "aaData" => $data_arr
    );
    // return $query;
    // return $data_arr;
    // return $query_count_record . " LIMIT $length OFFSET $start";
    return $response;
    
}

function register_wc_order_data_list_api_endpoint() {
    register_rest_route('zalo-management/v1', '/get-wc-order-data-list', array(
        'methods' => 'GET',
        'callback' => 'getWCOrderDataList',
    ));
}

add_action('rest_api_init', 'register_wc_order_data_list_api_endpoint');
