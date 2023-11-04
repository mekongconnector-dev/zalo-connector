<?php
global $wpdb;
$apikey= get_option('zalo_follow_management_license_apikey');
function fillter_by_week(){
    global $wpdb;
    $current_date = date('Y-m-d');
    // Ngày bắt đầu tuần này (ngày hiện tại là ngày kết thúc)
    $start_of_this_week = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
    $end_of_this_week = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));
    // Ngày bắt đầu tuần trước và kết thúc tuần trước
    $start_of_last_week = date('Y-m-d', strtotime('monday last week', strtotime($current_date)));
    $end_of_last_week = date('Y-m-d', strtotime('sunday last week', strtotime($current_date)));
    // Truy vấn số lượng follow cho tuần hiện tại
    $query_follow_this_week = $wpdb->prepare("
        SELECT COUNT(*) AS count_follow_this_week
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 1
        AND Follow_Start_Date >= %s
        AND Follow_Start_Date <= %s
    ", $start_of_this_week, $end_of_this_week);
    
    // Truy vấn số lượng unfollow cho tuần hiện tại
    $query_unfollow_this_week = $wpdb->prepare("
        SELECT COUNT(*) AS count_unfollow_this_week
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 0
        AND Unfollow_Date >= %s
        AND Follow_Start_Date <= %s
    ", $start_of_this_week, $end_of_this_week);
    
    // Truy vấn % khách hàng đã liên kết
    $query_linked_customer_percentage  = "
        SELECT (SUM(CASE WHEN fk_wc_customer_id IS NOT NULL THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Linked_Customer_Percentage
        FROM wp_zalo_followers;
    ";
    
    // Truy vấn số lượng follow cho tuần trước
    $query_follow_last_week = $wpdb->prepare("
        SELECT COUNT(*) AS count_follow_last_week
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 1
        AND Follow_Start_Date >= %s
        AND Follow_Start_Date <= %s
    ", $start_of_last_week, $end_of_last_week);
    
    // Truy vấn số lượng unfollow cho tuần trước
    $query_unfollow_last_week = $wpdb->prepare("
        SELECT COUNT(*) AS count_unfollow_last_week
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 0
        AND Unfollow_Date >= %s
        AND Follow_Start_Date <= %s
    ", $start_of_last_week, $end_of_last_week);
    
    // Lấy thông tin tin nhắn tuần này
    $query_sent_this_week = "
        SELECT COUNT(*) as count_sent_this_week
        FROM wp_message_zalo
        WHERE User_type = 'user_oa'
        AND create_at >= '$start_of_this_week' 
        AND create_at <= '$end_of_this_week';
    ";
    
    $query_received_this_week = "
        SELECT COUNT(*) as count_received_this_week
        FROM wp_message_zalo
        WHERE User_type = 'user'
        AND create_at >= '$start_of_this_week' 
        AND create_at <= '$end_of_this_week';
    ";
    
    // Lấy thông tin tuần trước
    $query_sent_last_week = "
        SELECT COUNT(*) as count_sent_last_week
        FROM wp_message_zalo
        WHERE User_type = 'user_oa'
        AND create_at >= '$start_of_last_week' 
        AND create_at <= '$end_of_last_week';
    ";
    
    $query_received_last_week = "
        SELECT COUNT(*) as count_received_last_week
        FROM wp_message_zalo
        WHERE User_type = 'user'
        AND create_at >= '$start_of_last_week' 
        AND create_at <= '$end_of_last_week';
    ";
    
    // Thực hiện truy vấn và lấy kết quả
    $count_follow_this_week = $wpdb->get_var($query_follow_this_week);
    $count_unfollow_this_week = $wpdb->get_var($query_unfollow_this_week);
    $linked_customer_percentage = $wpdb->get_var($query_linked_customer_percentage);
    $count_follow_last_week = $wpdb->get_var($query_follow_last_week);
    $count_unfollow_last_week = $wpdb->get_var($query_unfollow_last_week);
    $count_sent_this_week = $wpdb->get_var($query_sent_this_week);
    $count_received_this_week = $wpdb->get_var($query_received_this_week);
    $count_sent_last_week = $wpdb->get_var($query_sent_last_week);
    $count_received_last_week = $wpdb->get_var($query_received_last_week);

    $data = array(
        'count_follow_this_week' => $count_follow_this_week,
        'count_unfollow_this_week' => $count_unfollow_this_week,
        'linked_customer_percentage' => $linked_customer_percentage,
        'count_follow_last_week' => $count_follow_last_week,
        'count_unfollow_last_week' => $count_unfollow_last_week,
        'count_sent_this_week' => $count_sent_this_week,
        'count_received_this_week' => $count_received_this_week,
        'count_sent_last_week' => $count_sent_last_week,
        'count_received_last_week' => $count_received_last_week,
    );
    $json_data = json_encode($data);
    return $json_data;
}
function fillter_by_month(){
    global $wpdb;
    $current_date = date('Y-m-d');
    // Ngày bắt đầu tháng này (ngày hiện tại là ngày kết thúc)
    $start_of_this_month = date('Y-m-d', strtotime('first day of this month', strtotime($current_date)));
    $end_of_this_month = date('Y-m-d', strtotime('last day of this month', strtotime($current_date)));
    // Ngày bắt đầu tháng trước và kết thúc tháng trước
    $start_of_last_month = date('Y-m-d', strtotime('first day of last month', strtotime($current_date)));
    $end_of_last_month = date('Y-m-d', strtotime('last day of last month', strtotime($current_date)));
    // Truy vấn số lượng follow cho tháng hiện tại
    $query_follow_this_month = $wpdb->prepare("
        SELECT COUNT(*) AS count_follow_this_month
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 1
        AND Follow_Start_Date >= %s
        AND Follow_Start_Date <= %s
    ", $start_of_this_month, $end_of_this_month);
    
    // Truy vấn số lượng unfollow cho tháng hiện tại
    $query_unfollow_this_month = $wpdb->prepare("
        SELECT COUNT(*) AS count_unfollow_this_month
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 0
        AND Unfollow_Date >= %s
        AND Follow_Start_Date <= %s
    ", $start_of_this_month, $end_of_this_month);
    
    // Truy vấn % khách hàng đã liên kết
    $query_linked_customer_percentage  = "
        SELECT (SUM(CASE WHEN fk_wc_customer_id IS NOT NULL THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Linked_Customer_Percentage
        FROM wp_zalo_followers;
    ";
    
    // Truy vấn số lượng follow cho tháng trước
    $query_follow_last_month = $wpdb->prepare("
        SELECT COUNT(*) AS count_follow_last_month
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 1
        AND Follow_Start_Date >= %s
        AND Follow_Start_Date <= %s
    ", $start_of_last_month, $end_of_last_month);
    
    // Truy vấn số lượng unfollow cho tháng trước
    $query_unfollow_last_month = $wpdb->prepare("
        SELECT COUNT(*) AS count_unfollow_last_month
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 0
        AND Unfollow_Date >= %s
        AND Follow_Start_Date <= %s
    ", $start_of_last_month, $end_of_last_month);
    
    
    // Lấy thông tin nhắn tháng này
    $query_sent_this_month = "
        SELECT COUNT(*) as count_sent_this_month
        FROM wp_message_zalo
        WHERE User_type = 'user_oa'
        AND create_at >= '$start_of_this_month' 
        AND create_at <= '$end_of_this_month';
    ";
    
    $query_received_this_month = "
        SELECT COUNT(*) as count_received_this_month
        FROM wp_message_zalo
        WHERE User_type = 'user'
        AND create_at >= '$start_of_this_month' 
        AND create_at <= '$end_of_this_month';
    ";
    
    // Lấy thông tin tháng trước
    $query_sent_last_month = "
        SELECT COUNT(*) as count_sent_last_month
        FROM wp_message_zalo
        WHERE User_type = 'user_oa'
        AND create_at >= '$start_of_last_month' 
        AND create_at <= '$end_of_last_month';
    ";
    
    $query_received_last_month = "
        SELECT COUNT(*) as count_received_last_month
        FROM wp_message_zalo
        WHERE User_type = 'user'
        AND create_at >= '$start_of_last_month' 
        AND create_at <= '$end_of_last_month';
    ";
    // Thực hiện truy vấn và lấy kết quả
    $count_follow_this_month = $wpdb->get_var($query_follow_this_month);
    $count_unfollow_this_month = $wpdb->get_var($query_unfollow_this_month);
    $linked_customer_percentage = $wpdb->get_var($query_linked_customer_percentage);
    $count_follow_last_month = $wpdb->get_var($query_follow_last_month);
    $count_unfollow_last_month = $wpdb->get_var($query_unfollow_last_month);
    $count_sent_this_month = $wpdb->get_var($query_linked_customers_this_month);
    $count_received_this_month = $wpdb->get_var($query_received_this_month);
    $count_sent_last_month = $wpdb->get_var($query_sent_last_month);
    $count_received_last_month = $wpdb->get_var($query_received_last_month);
    // Tạo một mảng chứa kết quả
    $data = array(
        'count_follow_this_month' => $count_follow_this_month,
        'count_unfollow_this_month' => $count_unfollow_this_month,
        'linked_customer_percentage' => $linked_customer_percentage,
        'count_follow_last_month' => $count_follow_last_month,
        'count_unfollow_last_month' => $count_unfollow_last_month,
        'count_sent_this_month' => $count_sent_this_month,
        'count_received_this_month' => $count_received_this_month,
        'count_sent_last_month' => $count_sent_last_month,
        'count_received_last_month' => $count_received_last_month,
    );
    
    // Chuyển mảng thành chuỗi JSON
    $json_data = json_encode($data);
    return $json_data;
}
function chart_follow_by_week(){
    // Ngày bắt đầu tuần này (ngày hiện tại là ngày kết thúc)
    $current_date = date('Y-m-d'); // Ngày hiện tại
    $start_of_this_week = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
    $end_of_this_week = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));
    global $wpdb;
    // Truy vấn SQL
    $query_follows_per_day_this_week = "
        SELECT 
            DATE(Follow_Start_Date) AS date,
            COUNT(*) AS count_follows
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 1
        AND Follow_Start_Date >= '{$start_of_this_week}'
        AND Follow_Start_Date <= '{$end_of_this_week}'
        GROUP BY date
        ORDER BY date ASC;
    ";
    // Thực hiện truy vấn
    $follows_per_day_this_week = $wpdb->get_results($query_follows_per_day_this_week);
    // Tạo danh sách các ngày trong tuần này
    $week_dates = array();
    $current_date = $start_of_this_week;
    while ($current_date <= $end_of_this_week) {
        $week_dates[] = $current_date;
        $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
    }
    //mảng để chứa giá trị trả về key là ngày, giá trị là tổng fl
    $follows_per_day_data = array();
    foreach ($week_dates as $day) {
        $found = false;
        foreach ($follows_per_day_this_week as $result) {
            if ($result->date == $day) {
                $follows_per_day_data[] = array(
                    'day' => $result->date,
                    'count_follows' => $result->count_follows
                );
                $found = true;
                break;
            }
        }
        if (!$found) {
            $follows_per_day_data[] = array(
                'day' => $day,
                'count_follows' => 0
            );
        }
    }
    return json_encode($follows_per_day_data);
}
function chart_follow_by_month(){
    global $wpdb;
    $current_date = date('Y-m-d'); // Ngày hiện tại
     // Ngày bắt đầu tháng này (ngày hiện tại là ngày kết thúc)
    $start_of_this_month = date('Y-m-d', strtotime('first day of this month', strtotime($current_date)));
    $end_of_this_month = date('Y-m-d', strtotime('last day of this month', strtotime($current_date)));
    // Truy vấn SQL
    $query_follow_counts = "
        SELECT DATE(Follow_Start_Date) AS follow_date, COUNT(*) AS count_follows
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 1
        AND Follow_Start_Date >= '{$start_of_this_month}'
        AND Follow_Start_Date <= '{$end_of_this_month}'
        GROUP BY follow_date;
    ";
    $follow_count_results = $wpdb->get_results($query_follow_counts);
    $count_week1=0;
    $count_week2=0;
    $count_week3=0;
    $count_week4=0;
    foreach ($follow_count_results as $day){
        $follow_date = $day->follow_date;
        $dayOfMonth = date('d', strtotime($follow_date));
        if($dayOfMonth>=1 && $dayOfMonth<=7){
            $count_week1 += $day->count_follows;
        }
        if($dayOfMonth>=8 && $dayOfMonth<=14){
            $count_week2 += $day->count_follows;
        }
        if($dayOfMonth>=15 && $dayOfMonth<=21){
            $count_week3 += $day->count_follows;
        }
        if($dayOfMonth>=22 && date('d', strtotime( $end_of_this_month ))){
            $count_week4 += $day->count_follows;
        }
    }
    $data = array(
        'count_follow_week1' => $count_week1,
        'count_follow_week2' => $count_week2,
        'count_follow_week3' => $count_week3,
        'count_follow_week4' => $count_week4,
    );
    return json_encode($data);
}
function chart_unfollow_by_week(){
    // Ngày bắt đầu tuần này (ngày hiện tại là ngày kết thúc)
    $current_date = date('Y-m-d'); // Ngày hiện tại
    $start_of_this_week = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
    $end_of_this_week = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));
    global $wpdb;
    // Truy vấn SQL
    $query_unfollow_per_day_this_week = "
        SELECT 
            DATE(Unfollow_Date) AS date,
            COUNT(*) AS count_unfollows
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 0
        AND Unfollow_Date >= '{$start_of_this_week}'
        AND Follow_Start_Date <= '{$end_of_this_week}'
        GROUP BY date
        ORDER BY date ASC;
    ";
    // Thực hiện truy vấn
    $unfollow_per_day_this_week = $wpdb->get_results($query_unfollow_per_day_this_week);
    // Tạo danh sách các ngày trong tuần này
    $week_dates = array();
    $current_date = $start_of_this_week;
    while ($current_date <= $end_of_this_week) {
        $week_dates[] = $current_date;
        $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
    }
    $days_data = array();
    foreach ($week_dates as $day) {
        $found = false;
        foreach ($unfollow_per_day_this_week as $result) {
            if ($result->date == $day) {
                $days_data[] = array(
                    'date' => $result->date,
                    'count_unfollows' => $result->count_unfollows
                );
                $found = true;
                break;
            }
        }
        if (!$found) {
            $days_data[] = array(
                'date' => $day,
                'count_unfollows' => 0
            );
        }
    }
    return json_encode($days_data);
}
function chart_unfollow_by_month(){
    global $wpdb;
    $current_date = date('Y-m-d'); // Ngày hiện tại
     // Ngày bắt đầu tháng này (ngày hiện tại là ngày kết thúc)
    $start_of_this_month = date('Y-m-d', strtotime('first day of this month', strtotime($current_date)));
    $end_of_this_month = date('Y-m-d', strtotime('last day of this month', strtotime($current_date)));
    // Truy vấn SQL
    $query_unfollow_counts = "
        SELECT DATE(Unfollow_Date) AS unfollow_date, COUNT(*) AS count_unfollows
        FROM {$wpdb->prefix}zalo_followers
        WHERE Follow_Status = 0
        AND Unfollow_Date >= '{$start_of_this_month}'
        AND Unfollow_Date <= '{$end_of_this_month}'
        GROUP BY unfollow_date;
    ";
    $unfollow_count_results = $wpdb->get_results($query_unfollow_counts);
    $count_week1 = 0;
    $count_week2 = 0;
    $count_week3 = 0;
    $count_week4 = 0;
    foreach ($unfollow_count_results as $day) {
        $unfollow_date = $day->unfollow_date;
        $dayOfMonth = date('d', strtotime($unfollow_date));
    
        if ($dayOfMonth >= 1 && $dayOfMonth <= 7) {
            $count_week1 += $day->count_unfollows;
        }
        if ($dayOfMonth >= 8 && $dayOfMonth <= 14) {
            $count_week2 += $day->count_unfollows;
        }
        if ($dayOfMonth >= 15 && $dayOfMonth <= 21) {
            $count_week3 += $day->count_unfollows;
        }
        if ($dayOfMonth >= 22 && $dayOfMonth <= date('d', strtotime($end_of_this_month))) {
            $count_week4 += $day->count_unfollows;
        }
    }
    $data = array(
        'count_unfollow_week1' => $count_week1,
        'count_unfollow_week2' => $count_week2,
        'count_unfollow_week3' => $count_week3,
        'count_unfollow_week4' => $count_week4,
    );
    return json_encode($data);
}
function chart_sent_mess_from_oa_to_user_by_week(){
    // Ngày bắt đầu tuần này (ngày hiện tại là ngày kết thúc)
    global $wpdb;
    $current_date = date('Y-m-d'); // Ngày hiện tại
    $start_of_this_week = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
    $end_of_this_week = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));
    // Truy vấn SQL
    $query_sent_per_day_this_week = "
        SELECT 
            DATE(create_at) AS date,
            COUNT(*) AS count_sent
        FROM wp_message_zalo
        WHERE User_type = 'user_oa'
        AND create_at >= '{$start_of_this_week}'
        AND create_at <= '{$end_of_this_week}'
        GROUP BY date
        ORDER BY date ASC;
    ";
    
    // Thực hiện truy vấn
    $sent_per_day_this_week = $wpdb->get_results($query_sent_per_day_this_week);
    // Kết quả số tin nhắn đã gửi từ OA theo từng ngày trong tuần
    // foreach ($sent_per_day_this_week as $result) {
    //     echo "Ngày " . $result->date . ": Số tin nhắn đã gửi từ OA: " . $result->count_sent . "<br>";
    // }
    $week_dates = array();
    $current_date = $start_of_this_week;
    while ($current_date <= $end_of_this_week) {
        $week_dates[] = $current_date;
        $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
    }
    $sent_data = array();
    foreach ($week_dates as $day) {
        $found = false;
        foreach ($sent_per_day_this_week as $result) {
            if ($result->date == $day) {
                $sent_data[] = array(
                    'date' => $result->date,
                    'count_sent' => $result->count_sent
                );
                $found = true;
                break;
            }
        }
        if (!$found) {
            $sent_data[] = array(
                'date' => $day,
                'count_sent' => 0
            );
        }
    }
    return json_encode($sent_data);
}
function chart_sent_mess_from_oa_to_user_by_month(){
    global $wpdb;
    $current_date = date('Y-m-d'); // Ngày hiện tại
     // Ngày bắt đầu tháng này (ngày hiện tại là ngày kết thúc)
    $start_of_this_month = date('Y-m-d', strtotime('first day of this month', strtotime($current_date)));
    $end_of_this_month = date('Y-m-d', strtotime('last day of this month', strtotime($current_date)));
    // Truy vấn SQL
    $query_sent_counts = "
        SELECT DATE(create_at) AS sent_date, COUNT(*) AS count_sent
        FROM wp_message_zalo
        WHERE User_type = 'user_oa'
        AND create_at >= '{$start_of_this_month}'
        AND create_at <= '{$end_of_this_month}'
        GROUP BY sent_date;
    ";
    $sent_count_results = $wpdb->get_results($query_sent_counts);
    
    $count_week1 = 0;
    $count_week2 = 0;
    $count_week3 = 0;
    $count_week4 = 0;
    
    foreach ($sent_count_results as $day) {
        $sent_date = $day->sent_date;
        $dayOfMonth = date('d', strtotime($sent_date));
    
        if ($dayOfMonth >= 1 && $dayOfMonth <= 7) {
            $count_week1 += $day->count_sent;
        }
        if ($dayOfMonth >= 8 && $dayOfMonth <= 14) {
            $count_week2 += $day->count_sent;
        }
        if ($dayOfMonth >= 15 && $dayOfMonth <= 21) {
            $count_week3 += $day->count_sent;
        }
        if ($dayOfMonth >= 22 && $dayOfMonth <= date('d', strtotime($end_of_this_month))) {
            $count_week4 += $day->count_sent;
        }
    }
    
    $data = array(
        'count_sent_mess_week1' => $count_week1,
        'count_sent_mess_week2' => $count_week2,
        'count_sent_mess_week3' => $count_week3,
        'count_sent_mess_week4' => $count_week4,
    );
    
    return json_encode($data);

}
//tin nhắn đã nhận từ user
function chart_sent_mess_from_user_to_oa_by_week(){
    // Ngày bắt đầu tuần này (ngày hiện tại là ngày kết thúc)
    $current_date = date('Y-m-d'); // Ngày hiện tại
    $start_of_this_week = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
    $end_of_this_week = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));
    global $wpdb;
    $query_sent_per_day_this_week = "
        SELECT 
            DATE(create_at) AS date,
            COUNT(*) AS count_sent
        FROM wp_message_zalo
        WHERE User_type = 'user'
        AND create_at >= '{$start_of_this_week}'
        AND create_at <= '{$end_of_this_week}'
        GROUP BY date
        ORDER BY date ASC;
    ";
    
    // Thực hiện truy vấn
    $received_per_day_this_week = $wpdb->get_results($query_sent_per_day_this_week);
    $week_dates = array();
    $current_date = $start_of_this_week;
    while ($current_date <= $end_of_this_week) {
        $week_dates[] = $current_date;
        $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
    }
    $received_data = array();
    foreach ($week_dates as $day) {
        $found = false;
        foreach ($received_per_day_this_week as $result) {
            if ($result->date == $day) {
                $received_data[] = array(
                    'date' => $result->date,
                    'count_received' => $result->count_sent
                );
                $found = true;
                break;
            }
        }
        if (!$found) {
            $received_data[] = array(
                'date' => $day,
                'count_received' => 0
            );
        }
    }
    return json_encode($received_data);
}
function chart_sent_mess_from_user_to_oa_by_month(){
    global $wpdb;
    $current_date = date('Y-m-d'); // Ngày hiện tại
     // Ngày bắt đầu tháng này (ngày hiện tại là ngày kết thúc)
    $start_of_this_month = date('Y-m-d', strtotime('first day of this month', strtotime($current_date)));
    $end_of_this_month = date('Y-m-d', strtotime('last day of this month', strtotime($current_date)));
    // Truy vấn SQL
    $query_received_counts = "
        SELECT DATE(create_at) AS received_date, COUNT(*) AS count_received
        FROM wp_message_zalo
        WHERE User_type = 'user'
        AND create_at >= '{$start_of_this_month}'
        AND create_at <= '{$end_of_this_month}'
        GROUP BY received_date;
    ";
    $received_count_results = $wpdb->get_results($query_received_counts);
    
    $count_week1 = 0;
    $count_week2 = 0;
    $count_week3 = 0;
    $count_week4 = 0;
    
    foreach ($received_count_results as $day) {
        $received_date = $day->received_date;
        $dayOfMonth = date('d', strtotime($received_date));
    
        if ($dayOfMonth >= 1 && $dayOfMonth <= 7) {
            $count_week1 += $day->count_received;
        }
        if ($dayOfMonth >= 8 && $dayOfMonth <= 14) {
            $count_week2 += $day->count_received;
        }
        if ($dayOfMonth >= 15 && $dayOfMonth <= 21) {
            $count_week3 += $day->count_received;
        }
        if ($dayOfMonth >= 22 && $dayOfMonth <= date('d', strtotime($end_of_this_month))) {
            $count_week4 += $day->count_received;
        }
    }
    
    $data = array(
        'count_received_mess_week1' => $count_week1,
        'count_received_mess_week2' => $count_week2,
        'count_received_mess_week3' => $count_week3,
        'count_received_mess_week4' => $count_week4,
    );
    
    return json_encode($data);

}
// // var_dump(chart_follow_by_week());
// // echo "<br>";
// var_dump(chart_follow_by_month());
// // echo "<br>";
// // var_dump(chart_unfollow_by_week());
// echo "<br>";
// var_dump(chart_unfollow_by_month());
// // echo "<br>";
// // var_dump(chart_sent_mess_from_oa_to_user_by_week());
// echo "<br>";
// var_dump(chart_sent_mess_from_oa_to_user_by_month());
// // echo "<br>";
// // var_dump(chart_sent_mess_from_user_to_oa_by_week());
// echo "<br>";
// var_dump(chart_sent_mess_from_user_to_oa_by_month());
// // echo "<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<style>
    body{
        background-color: rgba(239, 239, 246, 1);
    }
    .carcus{
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-wrap: wrap;
        align-items: center;
        align-content: center;
        background-color: white;
        width: 22%;
        height: 200px;
        border-radius: 5px;
        box-shadow: 0px 19px 28px 0px rgba(0, 0, 0, 0.03);
    }
    .carcus svg{
        width: 50px;
        height: 50px;
        padding-bottom: 5px;
    }
    .carcus .up{
        width: 30px;
        height: 30px;
        color: #00B81D;
    }
    .carcus .down{
        width: 30px;
        height: 30px;
        color: #BA2121;
    }
    .carcus .upvalue{
        font-size: 12px;
        color:rgba(0, 184, 29, 1);
    }
    .carcus .downvalue{
        font-size: 12px;
        color:rgba(176, 0, 0, 1);
    }
    .carcus .titlecus{
        font-size: 18px;
        text-align: center;
        color: gray;
    }
    .titlecus{
        @media(max-width: 576px){
            font-size: 14px !important;
        }
    }
    .progress-bar {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-wrap: wrap;
        align-items: center;
        align-content: center;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: radial-gradient(closest-side, white 79%, transparent 80% 100%), conic-gradient(blue 95%, rgba(201, 213, 231, 1) 0);    
        @media (max-width: 576px){
            width: 70px;
            height: 70px;
        }
    }
    .chartcar{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-wrap: wrap;
        align-items: end;
        align-content: center;
        background-color: white;
        width: 74%;
        height: 400px;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0px 19px 28px 0px rgba(0, 0, 0, 0.03);
    }
    #chart{
        width: 100%;
        height: auto;
    }
    #select-type-chart{
        
    }
    .chatcar{
        display: flex;
        flex-direction: column;
        /*flex-wrap: wrap;*/
        overflow: scroll;
        align-items: start;
        background-color: white;
        width: 100%;
        height: 650px;
        padding: 25px;
        border-radius: 5px;
        box-shadow: 0px 19px 28px 0px rgba(0, 0, 0, 0.03);
    }
    /*.chatcar hr{*/
    /*    border-top: 1px solid red;*/
    /*}*/
    .messuser{
        display: flex;
        flex-direction: row;
        transition: background-color 0.3s;
        width: 100%;
        border-radius: 8px;
        padding: 10px;
        text-decoration: none;
    }
    .messuser:hover {
        background-color: #D7DDEF;
    }
    .messuser img{
        width: 50px;
        height: 50px;
        border-radius: 100px;
    }
    .chatinfo{
        padding-left: 15px;
    }
    .chatinfo .chatmess{
        max-width:150px;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: gray;
    }
    .hide{
        display: none !important;
    }
    .content-zalo{
        @media (max-width: 1234px){
            flex-direction: column !important;
        }
        @media (max-width: 576px){
            padding: 50px 10px !important;
        }
        
    }
    .content-zalo-left{
        @media (max-width: 1234px){
            width: 100% !important;
        }
    }
    .content-zalo-right{
        @media (max-width: 1234px){
            width: 100% !important;
        }
    }
    .titlecus{
        @media(max-width: 576px){
            font-size: 14px !important;
        }
    }
    .qs{
        @media (max-width: 576px){
            display: none;
        }
    }
    #selectOption{
        
    }
</style>
<body>
    <div class="row content-zalo" style="padding: 50px">
        <div class="col-8 d-flex flex-column content-zalo-left">
            <!-- tiêu đề -->
            <div class="d-flex flex-row align-items-center justify-content-between" style="padding-bottom: 50px;">
                <div class="d-flex flex-row">
                    <!--<h5 style="padding-right: 5px;">Dashboard</h5>-->
                    <!--<select id="selectOption">-->
                    <!--    <option value="<?php echo admin_url();?>admin.php?page=main-menu" selected>ZALO</option>-->
                    <!--    <option value="<?php echo admin_url();?>admin.php?page=marketing-dashboard">QUẢNG CÁO</option>-->
                    <!--    <option value="<?php echo admin_url();?>admin.php?page=article-dashboard">BÀI VIẾT</option>-->
                    <!--</select>-->
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                        <label class="btn btn-outline-primary titlecus" for="btnradio1">Zalo</label>
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary titlecus" for="btnradio2" key="advertisement">Quảng cáo</label>
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary titlecus" for="btnradio3" key="article">Bài viết</label>
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-primary titlecus" for="btnradio4" key="zns">ZNS</label>
                    </div>
                    <!--<h3 style="padding-right: 5px;">ZALO KHÁCH HÀNG</h3>-->
                    <div class="rounded-circle qs" style="background-color: white; width: 25px; height: 25px; text-align: center; margin-left:10px;">
                        <i class="fa-solid fa-question"></i>
                    </div>
                </div>
                <div>
                    <select name="" id="fillter_dashboard">
                        <option value="week" key="this_week">Tuần này</option>
                        <option value="month" key="this_month">Tháng này</option>
                    </select>
                </div>
            </div>
            <!-- kết thúc tiêu đề -->
            <!-- thống kê row 1 -->
            <div class="d-flex flex-row align-items-center justify-content-between" style="padding-bottom: 50px;">
                <div class="carcus">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="#184A9B" fill-opacity="0.8"/>
                        <path d="M14 13C14.663 13 15.2989 13.2634 15.7678 13.7322C16.2366 14.2011 16.5 14.837 16.5 15.5V16C16.5 16.2652 16.3946 16.5196 16.2071 16.7071C16.0196 16.8946 15.7652 17 15.5 17H8.5C8.23478 17 7.98043 16.8946 7.79289 16.7071C7.60536 16.5196 7.5 16.2652 7.5 16V15.5C7.5 14.837 7.76339 14.2011 8.23223 13.7322C8.70107 13.2634 9.33696 13 10 13H14ZM16.707 10.5405C16.7968 10.4499 16.9178 10.397 17.0453 10.3927C17.1728 10.3883 17.2971 10.4329 17.3928 10.5172C17.4885 10.6016 17.5483 10.7193 17.5601 10.8463C17.5719 10.9733 17.5346 11.1 17.456 11.2005L17.414 11.248L16 12.662C15.9139 12.7481 15.7994 12.7998 15.6778 12.8074C15.5563 12.8151 15.4362 12.7781 15.34 12.7035L15.293 12.662L14.586 11.955C14.4954 11.8652 14.4425 11.7442 14.4382 11.6167C14.4338 11.4892 14.4784 11.3649 14.5627 11.2692C14.6471 11.1735 14.7648 11.1136 14.8918 11.1019C15.0188 11.0901 15.1455 11.1274 15.246 11.206L15.293 11.248L15.6465 11.6015L16.707 10.5405ZM12 7C12.663 7 13.2989 7.26339 13.7678 7.73223C14.2366 8.20107 14.5 8.83696 14.5 9.5C14.5 10.163 14.2366 10.7989 13.7678 11.2678C13.2989 11.7366 12.663 12 12 12C11.337 12 10.7011 11.7366 10.2322 11.2678C9.76339 10.7989 9.5 10.163 9.5 9.5C9.5 8.83696 9.76339 8.20107 10.2322 7.73223C10.7011 7.26339 11.337 7 12 7Z" fill="white"/>
                    </svg>
                    <h3 class="reportnumber" id="count_follow">0</h3>
                    <div class="d-flex flex-row">
                        <i class="fa-solid fa-arrow-trend-up up" id="follow_trend_icon"></i>
                        <div class="upvalue" id="follow_evolution">0%</div>
                    </div>
                    
                    <p class="titlecus">Folllow</p>
                </div>
                <div class="carcus">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.3333" cy="12" r="12" fill="#184A9B" fill-opacity="0.8"/>
                        <path d="M14.1945 13.625C14.817 13.625 15.414 13.8723 15.8542 14.3125C16.2944 14.7527 16.5417 15.3497 16.5417 15.9722V16.5C16.5417 16.7026 16.4612 16.8969 16.3179 17.0402C16.1747 17.1834 15.9804 17.2639 15.7778 17.2639H8.3889C8.1863 17.2639 7.99201 17.1834 7.84875 17.0402C7.70549 16.8969 7.62501 16.7026 7.62501 16.5V15.9722C7.62501 15.3497 7.87231 14.7527 8.3125 14.3125C8.75269 13.8723 9.34971 13.625 9.97223 13.625H14.1945ZM12.0833 7.29167C12.7059 7.29167 13.3029 7.53896 13.7431 7.97915C14.1833 8.41934 14.4306 9.01637 14.4306 9.63889C14.4306 10.2614 14.1833 10.8584 13.7431 11.2986C13.3029 11.7388 12.7059 11.9861 12.0833 11.9861C11.4608 11.9861 10.8638 11.7388 10.4236 11.2986C9.98342 10.8584 9.73612 10.2614 9.73612 9.63889C9.73612 9.01637 9.98342 8.41934 10.4236 7.97915C10.8638 7.53896 11.4608 7.29167 12.0833 7.29167Z" fill="white" stroke="white" stroke-width="0.583333"/>
                        <path d="M15.345 10.0118C15.3804 9.97633 15.4224 9.94822 15.4686 9.92905C15.5149 9.90987 15.5645 9.9 15.6145 9.9C15.6646 9.9 15.7142 9.90987 15.7604 9.92905C15.8067 9.94822 15.8487 9.97632 15.884 10.0117L15.884 10.0117L15.8133 10.0824L15.8841 10.0118L16.8334 10.9607L17.7828 10.0117C17.7828 10.0117 17.7828 10.0117 17.7828 10.0117C17.8182 9.97631 17.8602 9.94824 17.9064 9.92909C17.9526 9.90994 18.0022 9.90008 18.0522 9.90008C18.1023 9.90008 18.1518 9.90994 18.1981 9.92909C18.2443 9.94824 18.2863 9.97632 18.3217 10.0117C18.3571 10.0471 18.3852 10.0891 18.4043 10.1353C18.4235 10.1816 18.4333 10.2311 18.4333 10.2812C18.4333 10.3312 18.4235 10.3808 18.4043 10.427C18.3852 10.4733 18.3571 10.5153 18.3217 10.5506C18.3217 10.5507 18.3217 10.5507 18.3217 10.5507L17.3727 11.5L18.3217 12.4494C18.3217 12.4494 18.3217 12.4494 18.3217 12.4494C18.3932 12.5209 18.4333 12.6178 18.4333 12.7189C18.4333 12.82 18.3932 12.9169 18.3217 12.9884C18.2503 13.0598 18.1533 13.1 18.0522 13.1C17.9512 13.1 17.8542 13.0599 17.7828 12.9884C17.7828 12.9884 17.7828 12.9884 17.7828 12.9884L16.8334 12.0393L15.884 12.9884C15.884 12.9884 15.884 12.9884 15.884 12.9884C15.8125 13.0599 15.7156 13.1 15.6145 13.1C15.5135 13.1 15.4165 13.0598 15.345 12.9884C15.2736 12.9169 15.2334 12.82 15.2334 12.7189C15.2334 12.6178 15.2736 12.5209 15.345 12.4494C15.345 12.4494 15.345 12.4494 15.345 12.4494L16.2941 11.5L15.3451 10.5507L15.345 10.5506L15.4158 10.48L15.345 10.0118ZM15.345 10.0118L15.4158 10.0824L15.345 10.0118Z" fill="white" stroke="white" stroke-width="0.2"/>
                    </svg>
                    <h3 class="reportnumber" id="count_unfollow">0</h3>
                    <div class="d-flex flex-row">
                        <i class="fa-solid fa-arrow-trend-down down" id="unfollow_trend_icon"></i>
                        <div class="downvalue" id="unfollow_evolution">0%</div>
                    </div>
                    <p class="titlecus">Unfollow</p>
                </div>
                <div class="carcus">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.6667" cy="12" r="12" fill="#184A9B" fill-opacity="0.8"/>
                        <g clip-path="url(#clip0_47_207)">
                        <path d="M11.1667 10.5L13.4167 12L15.6667 10.5M8.16667 12.75H9.16667M7.16667 11.25H9.16667" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.16667 9.75V9.5C9.16667 9.23478 9.27203 8.98043 9.45956 8.79289C9.6471 8.60536 9.90146 8.5 10.1667 8.5H16.6667C16.9319 8.5 17.1862 8.60536 17.3738 8.79289C17.5613 8.98043 17.6667 9.23478 17.6667 9.5V14.5C17.6667 14.7652 17.5613 15.0196 17.3738 15.2071C17.1862 15.3946 16.9319 15.5 16.6667 15.5H10.1667C9.90146 15.5 9.6471 15.3946 9.45956 15.2071C9.27203 15.0196 9.16667 14.7652 9.16667 14.5V14.25" stroke="white" stroke-linecap="round"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_47_207">
                        <rect width="12" height="12" fill="white" transform="translate(6.66667 6)"/>
                        </clipPath>
                        </defs>
                    </svg>
                    <h3 class="reportnumber" id="sent_mess">0</h3>
                    <div class="d-flex flex-row">
                        <i class="fa-solid fa-arrow-trend-up up" id="sent_mess_trend_icon"></i>
                        <div class="upvalue" id="sent_mess_evolution">0%</div>
                    </div>
                    <p class="titlecus" key="oa_has_sent">OA đã gửi</p>
                </div>
                <div class="carcus">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="#184A9B" fill-opacity="0.8"/>
                        <path d="M12 15.5H8.5C8.23478 15.5 7.98043 15.3946 7.79289 15.2071C7.60536 15.0196 7.5 14.7652 7.5 14.5V9.5C7.5 9.23478 7.60536 8.98043 7.79289 8.79289C7.98043 8.60536 8.23478 8.5 8.5 8.5H15.5C15.7652 8.5 16.0196 8.60536 16.2071 8.79289C16.3946 8.98043 16.5 9.23478 16.5 9.5V12.25M15.5 14V17M15.5 17L17 15.5M15.5 17L14 15.5" stroke="white" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7.5 9.5L12 12.5L16.5 9.5" stroke="white" stroke-width="1.17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3 class="reportnumber" id="received_mess">0</h3>
                    <div class="d-flex flex-row">
                        <i class="fa-solid fa-arrow-trend-up up" id="received_mess_trend_icon"></i>
                        <div class="upvalue" id="received_mess_evolution">0%</div>
                    </div>
                    <p class="titlecus" key="oa_has_received">OA đã nhận</p>
                </div>
            </div>
            <!-- kết thúc thống kê row 1 -->
            <!-- thống kê row 2 -->
            <div class="d-flex flex-row align-items-center justify-content-between" style="padding-bottom: 50px;">
                <div class="carcus" style="height: 400px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="#184A9B" fill-opacity="0.8"/>
                        <g clip-path="url(#clip0_47_165)">
                        <path d="M14.6515 10.762L16.2425 12.353C16.5007 12.6077 16.7059 12.911 16.8464 13.2454C16.9868 13.5798 17.0598 13.9386 17.061 14.3013C17.0622 14.664 16.9917 15.0233 16.8534 15.3587C16.7152 15.694 16.512 15.9986 16.2556 16.2551C15.9991 16.5115 15.6945 16.7147 15.3591 16.853C15.0238 16.9912 14.6645 17.0617 14.3018 17.0605C13.9391 17.0593 13.5803 16.9864 13.2459 16.8459C12.9115 16.7054 12.6082 16.5002 12.3535 16.242L11.8235 15.712C11.7518 15.6428 11.6947 15.5601 11.6553 15.4686C11.616 15.3771 11.5952 15.2787 11.5943 15.1792C11.5934 15.0796 11.6123 14.9808 11.65 14.8886C11.6877 14.7964 11.7433 14.7127 11.8137 14.6422C11.8841 14.5718 11.9678 14.516 12.0599 14.4783C12.1521 14.4405 12.2509 14.4215 12.3504 14.4223C12.45 14.4231 12.5484 14.4438 12.64 14.483C12.7315 14.5223 12.8143 14.5794 12.8835 14.651L13.4145 15.1815C13.6493 15.4142 13.9667 15.5444 14.2973 15.5436C14.6279 15.5429 14.9447 15.4112 15.1784 15.1774C15.4121 14.9436 15.5437 14.6268 15.5444 14.2962C15.545 13.9656 15.4148 13.6482 15.182 13.4135L13.591 11.8225C13.419 11.6505 13.2006 11.5323 12.9625 11.4826C12.7244 11.4329 12.4769 11.4537 12.2505 11.5425C12.1695 11.5745 12.0945 11.6075 12.0235 11.6405L11.7915 11.749C11.4815 11.889 11.243 11.949 10.9395 11.646C10.5035 11.21 10.6165 10.8075 11.148 10.441C11.6775 10.0769 12.3178 9.90961 12.9578 9.96825C13.5977 10.0269 14.197 10.3077 14.6515 10.762ZM11.6465 7.757L12.1765 8.287C12.3132 8.42839 12.3889 8.61781 12.3873 8.81445C12.3856 9.0111 12.3068 9.19925 12.1679 9.33837C12.0289 9.4775 11.8408 9.55646 11.6441 9.55826C11.4475 9.56006 11.258 9.48456 11.1165 9.348L10.586 8.818C10.4707 8.69858 10.3328 8.60332 10.1803 8.53776C10.0278 8.47221 9.86383 8.43768 9.69785 8.43619C9.53188 8.4347 9.36727 8.46628 9.21363 8.52909C9.06 8.5919 8.9204 8.68467 8.80301 8.80201C8.68561 8.91934 8.59275 9.05888 8.52986 9.21248C8.46696 9.36608 8.43529 9.53067 8.43668 9.69665C8.43808 9.86262 8.47251 10.0267 8.53798 10.1792C8.60345 10.3317 8.69864 10.4697 8.81799 10.585L10.409 12.176C10.581 12.348 10.7994 12.4662 11.0375 12.5159C11.2756 12.5656 11.523 12.5448 11.7495 12.456C11.8305 12.424 11.9055 12.391 11.9765 12.358L12.2085 12.2495C12.5185 12.1095 12.7575 12.0495 13.0605 12.3525C13.4965 12.7885 13.3835 13.191 12.852 13.5575C12.3225 13.9216 11.6822 14.0889 11.0422 14.0303C10.4023 13.9716 9.80303 13.6908 9.34849 13.2365L7.75749 11.6455C7.49932 11.3908 7.29409 11.0875 7.15362 10.7531C7.01314 10.4187 6.9402 10.0599 6.93898 9.69719C6.93777 9.3345 7.0083 8.97516 7.14654 8.63985C7.28477 8.30454 7.48796 7.99989 7.74442 7.74343C8.00088 7.48697 8.30553 7.28378 8.64084 7.14555C8.97615 7.00731 9.33549 6.93677 9.69818 6.93799C10.0609 6.9392 10.4197 7.01215 10.7541 7.15262C11.0885 7.2931 11.3918 7.49883 11.6465 7.757Z" fill="white"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_47_165">
                        <rect width="12" height="12" fill="white" transform="translate(6 6)"/>
                        </clipPath>
                        </defs>
                    </svg>
                    <div class="progress-bar" id="linked_customer_percentage">
                    </div>
                    <p class="titlecus" key="customer_linkage">Liên kết khách hàng</p>
                </div>
                <div class="chartcar">
                    <select name="" id="select-type-chart" >
                        <option value="follow" key="followers">Lượt follow</option>
                        <option value="unfollow" key="unfollowers">Lượt unfollow</option>
                        <option value="messageSent" key="sent_messages">Tin nhắn đã gửi</option>
                        <option value="messageReceived" key="received_messages">Tin nhắn đã nhận</option>
                    </select>
                    <div id="chart"></div>
                </div>
            </div>
            <!-- kết thúc thống kê row 2 -->


        </div>
        <div class="col-4 d-flex flex-column content-zalo-right">
            <div class="btn-group" style="padding-bottom: 50px; max-width: 350px;">
                <button type="button" class="btn btn-primary cus" style="" key="new_messages">
                    <i class="fa-solid fa-envelope"></i> Tin nhắn mới
                </button>
                <button type="button" class="btn btn-outline-primary cus" key="recent_follows">
                    <i class="fa-solid fa-clock" ></i> Theo dõi gần đây
                </button>
            </div>  
            <div class="d-flex flex-row align-items-center" style="padding-bottom: 50px;" id="recentlychat">
                <div class="chatcar">
                    
                    <?php
                    // Kết nối đến cơ sở dữ liệu của bạn ở đây
                    
                    // Truy vấn SQL để lấy top 10 người nhắn tin gần đây nhất và tin nhắn mới nhất của họ
                    $query = "
                        SELECT zf.Zalo_Name, zf.Zalo_URL_Img, m.User_id_zalo, m.create_at AS latest_message_date, m.Content AS latest_message_content
                        FROM wp_message_zalo AS m
                        JOIN wp_zalo_followers AS zf ON m.User_id_zalo = zf.Zalo_ID
                        WHERE m.User_type = 'user'
                        AND (m.User_id_zalo, m.create_at) IN (
                            SELECT User_id_zalo, MAX(create_at) AS latest_message_date
                            FROM wp_message_zalo
                            WHERE User_type = 'user'
                            GROUP BY User_id_zalo
                        )
                        ORDER BY latest_message_date DESC
                        LIMIT 10
                    ";
                    // echo $query;
                    // Thực hiện truy vấn
                    $results = $wpdb->get_results($query);
                    
                    // In ra thông tin top 10 người nhắn tin gần đây nhất và tin nhắn mới nhất của họ
                    foreach ($results as $message) {
                        $user_name = $message->Zalo_Name; // Tên người dùng từ wp_zalo_followers
                        $user_avatar = $message->Zalo_URL_Img; // Ảnh đại diện từ wp_zalo_followers
                        $user_id = $message->User_id_zalo;
                        $latest_message_date = $message->latest_message_date; // Ngày tin nhắn mới nhất
                        $latest_message_content = $message->latest_message_content; // Nội dung tin nhắn mới nhất
                        
                        $link_route_user_chat = admin_url("admin.php?page=follower-chat&id=$user_id");
                    
                        echo '<a class="messuser" href="' . $link_route_user_chat . '">';
                        echo '<img src="' . $user_avatar . '" alt="">';
                        echo '<div class="chatinfo">';
                        echo '<h6 class="chatname">' . $user_name . '</h6>';
                        echo '<label for="" class="chatmess">' . $latest_message_content . '</label>'; // Tin nhắn mới nhất
                        echo '</div>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div> 
            <div class="d-flex flex-row align-items-center hide" style="padding-bottom: 50px;" id="recentlyfollowed">
                <div class="chatcar">
                    <?php
                    // Kết nối đến cơ sở dữ liệu của bạn ở đây
                    
                    // Truy vấn SQL để lấy top 10 người theo dõi gần đây nhất
                    $query = "
                        SELECT zf.Zalo_Name, zf.Zalo_URL_Img, zf.Follow_Start_Date
                        FROM wp_zalo_followers AS zf
                        WHERE zf.Follow_Status = 1
                        ORDER BY zf.Follow_Start_Date DESC
                        LIMIT 10
                    ";
                    
                    // Thực hiện truy vấn
                    $results = $wpdb->get_results($query);
                    
                    // In ra thông tin top 10 người theo dõi gần đây nhất
                    foreach ($results as $follower) {
                        $user_name = $follower->Zalo_Name; // Tên người theo dõi từ wp_zalo_followers
                        $user_avatar = $follower->Zalo_URL_Img; // Ảnh đại diện từ wp_zalo_followers
                        $follow_start_date = $follower->Follow_Start_Date; // Ngày bắt đầu theo dõi
                        
                        // Chuyển định dạng ngày theo ý muốn (ví dụ: dd/mm/yyyy)
                        $formatted_follow_start_date = date("d/m/Y", strtotime($follow_start_date));
                        
                        echo '<div class="messuser">';
                        echo '<img src="' . $user_avatar . '" alt="">';
                        echo '<div class="chatinfo">';
                        echo '<h6 class="chatname">' . $user_name . '</h6>';
                        echo '<label for="" class="chatmess">' . $formatted_follow_start_date . '</label>'; // Ngày bắt đầu theo dõi
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div> 
            

        </div>
    </div>
    
</body>
<script>
    var apiUrl = "/wp-json/zalo-management/v1/check_license_key";
    var licenseKey = "<?php if(!empty($apikey)) echo $apikey; else echo "null"; ?>";
    if(licenseKey=="null"){
        alert("Please check license key and try again");
        window.location.href = '/wp-admin/admin.php?page=follower-setup';
    }
    // jQuery.ajax({
    //     type: "GET",
    //     url: apiUrl + "?license_key=" + licenseKey,
    //     success: function (response) {
    //         if (response.status === 200 && response.message === "Success") {
               
    //         } else {
    //             alert("Erro: " + response.message +". Please check license key and try again");
    //             window.location.href = '/wp-admin/admin.php?page=follower-setup';
    //         }
    //     },
    //     error: function (error) {
    //         // Xử lý lỗi trong quá trình gọi API
    //         console.log("Lỗi khi gọi API: " + JSON.stringify(error));
    //     }
    // });
</script>
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
    // Lấy ra các phần tử cần làm việc với
    const btnNewMessage = document.querySelector('.btn.btn-primary.cus');
    const btnRecentFollowed = document.querySelector('.btn.btn-outline-primary.cus');
    const recentlychat = document.getElementById('recentlychat');
    const recentlyfollowed = document.getElementById('recentlyfollowed');

    // Sử dụng Event Listener để thực hiện chuyển đổi
    btnNewMessage.addEventListener('click', () => {
    // Thêm class 'hide' vào phần tử "Theo dõi gần đây" và loại bỏ class 'hide' khỏi phần tử "Tin nhắn mới"
    recentlyfollowed.classList.add('hide');
    recentlychat.classList.remove('hide');
    
    // Thay đổi class của nút "Tin nhắn mới" và loại bỏ class khỏi nút "Theo dõi gần đây"
    btnNewMessage.classList.add('btn-primary');
    btnNewMessage.classList.remove('btn-outline-primary');
    btnRecentFollowed.classList.add('btn-outline-primary');
    btnRecentFollowed.classList.remove('btn-primary');
    });

    btnRecentFollowed.addEventListener('click', () => {
    // Thêm class 'hide' vào phần tử "Tin nhắn mới" và loại bỏ class 'hide' khỏi phần tử "Theo dõi gần đây"
    recentlychat.classList.add('hide');
    recentlyfollowed.classList.remove('hide');
    
    // Thay đổi class của nút "Theo dõi gần đây" và loại bỏ class khỏi nút "Tin nhắn mới"
    btnRecentFollowed.classList.add('btn-primary');
    btnRecentFollowed.classList.remove('btn-outline-primary');
    btnNewMessage.classList.add('btn-outline-primary');
    btnNewMessage.classList.remove('btn-primary');
    });
</script>
<script>
    // Function to make the AJAX request and update data
    function getDashBoardByWeek(){
        var apiUrl = "/wp-json/zalo-management/v1/GetDashBoardByWeek/";
        // Thực hiện cuộc gọi AJAX
        $.ajax({
            type: "GET",
            url: apiUrl,
            success: function(response) {
                $("#count_follow").text(response.data.count_follow);
                $("#count_unfollow").text(response.data.count_unfollow);
                $("#sent_mess").text(response.data.count_sent);
                $("#received_mess").text(response.data.count_received);
                $("#linked_customer_percentage").text(response.data.linked_customer_percentage);
                //sự tăng trưởng
                $("#follow_evolution").text(response.data.follower_percent +"%");
                $("#unfollow_evolution").text(response.data.unfollow_percent +"%");
                $("#sent_mess_evolution").text(response.data.message_sent_percent +"%");
                $("#received_mess_evolution").text(response.data.message_received_percent +"%");
                // Xử lý class cho các phần tử
                updateClassBasedOnValue(response.data.follower_percent, "#follow_evolution" , "#follow_trend_icon");
                updateClassBasedOnValue(response.data.unfollow_percent, "#unfollow_evolution", "#unfollow_trend_icon");
                updateClassBasedOnValue(response.data.message_sent_percent, "#sent_mess_evolution", "#sent_mess_trend_icon");
                updateClassBasedOnValue(response.data.message_received_percent, "#received_mess_evolution" , "#received_mess_trend_icon");
                //xử lý progressbar
                updateProgressBar(response.data.linked_customer_percentage); 
            },
            error: function(xhr, status, error) {
            }
        });
    }
    function getDashBoardByMonth(){
        var apiUrl = "/wp-json/zalo-management/v1/GetDashBoardByMonth/";
        // Thực hiện cuộc gọi AJAX
        $.ajax({
            type: "GET",
            url: apiUrl,
            success: function(response) {
                $("#count_follow").text(response.data.count_follow);
                $("#count_unfollow").text(response.data.count_unfollow);
                $("#sent_mess").text(response.data.count_sent);
                $("#received_mess").text(response.data.count_received);
                $("#linked_customer_percentage").text(response.data.linked_customer_percentage);
                //sự tăng trưởng
                $("#follow_evolution").text(response.data.follower_percent +"%");
                $("#unfollow_evolution").text(response.data.unfollow_percent +"%");
                $("#sent_mess_evolution").text(response.data.message_sent_percent +"%");
                $("#received_mess_evolution").text(response.data.message_received_percent +"%");
                // Xử lý class cho các phần tử
                updateClassBasedOnValue(response.data.follower_percent, "#follow_evolution" , "#follow_trend_icon");
                updateClassBasedOnValue(response.data.unfollow_percent, "#unfollow_evolution", "#unfollow_trend_icon");
                updateClassBasedOnValue(response.data.message_sent_percent, "#sent_mess_evolution", "#sent_mess_trend_icon");
                updateClassBasedOnValue(response.data.message_received_percent, "#received_mess_evolution" , "#received_mess_trend_icon");
                 //xử lý progressbar
                updateProgressBar(response.data.linked_customer_percentage); 
            },
            error: function(xhr, status, error) {
            }
        });
    }
    // Tạo một hàm để cập nhật giá trị của progress-bar
    function updateProgressBar(percentage) {
        // Tạo gradient mới dựa trên giá trị percentage
        const newGradient = `radial-gradient(closest-side, white ${percentage}%, transparent ${percentage}% 100%), conic-gradient(blue ${percentage}%,
                             rgba(201, 213, 231, 1) 0)`;
        
        const progressBar = document.getElementById("linked_customer_percentage");
        // Đặt lại thuộc tính background của progress-bar
        progressBar.style.background = newGradient;
    }
    
    function updateClassBasedOnValue(value, elementId, iconID) {
        var element = $(elementId);
        var icon= $(iconID);
        if (value < 0) {
            element.removeClass("upvalue");
            element.addClass("downvalue");
            icon.attr("class", "fa-solid fa-arrow-trend-down down");
        } else {
            element.removeClass("downvalue");
            element.addClass("upvalue");
            icon.attr("class", "fa-solid fa-arrow-trend-up up");
        }
    }
    // Event handler for dropdown change
    $("#fillter_dashboard").change(function() {
        const selectedValue = $(this).val();
        // Define the start and end date based on the selected option
        if (selectedValue === "week") {
            getDashBoardByWeek();
            //cập nhật lại biểu đồ
            const selectTypeChart = document.getElementById("select-type-chart");
            const selectedType = selectTypeChart.value;
            updateChart(selectedType);
        } else if (selectedValue === "month") {
            getDashBoardByMonth();
            const selectTypeChart = document.getElementById("select-type-chart");
            const selectedType = selectTypeChart.value;
            updateChart(selectedType);
        }
    });
    getDashBoardByWeek();
</script>

<!-- js bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- js datatable -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Tải jQuery từ Google CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Function to update the chart based on the selected type
    function updateChart(selectedType) {
        // Make an AJAX request to your API
        const selectedDashboard = document.getElementById("fillter_dashboard").value;
        const apiUrl = `/wp-json/zalo-management/v1/GetDashBoardChart?type=${selectedDashboard}&chartType=${selectedType}`;
        var name="";
        if(selectedType=="follow")
            name="Lượt theo dõi";
        else if(selectedType=="unfollow")
            name="Lượt bỏ theo dõi";
        else if(selectedType=="messageSent")
            name="Số tin nhắn gửi từ OA";
        else if(selectedType=="messageReceived")
            name="Số tin nhắn nhận từ khách hàng";
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                // Extract data from the API response
                const labels = data.label;
                const values = data.value;
                //bắt đầu update chart
                ApexCharts.exec('chartColumn', 'updateOptions', {
                    series: [
                        {
                          name: name,
                          data: values,
                        },
                    ],
                    xaxis: {
                        categories:labels,
                     },
                    yaxis: {
                        title: {
                          text: name,
                        },
                    },

                }, true);
                //kết thúc update chart
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }

    // Listen for changes in the select box
    const selectTypeChart = document.getElementById("select-type-chart");
    selectTypeChart.addEventListener("change", function () {
        const selectedType = this.value;
        updateChart(selectedType);
    });
</script>
<script>
    var options = {
      series: [
        {
          name: "Lượt theo dõi",
          data: [],
        },
      ],
      chart: {
        type: "bar",
        height: 300,
        id: 'chartColumn',
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: "85%",
          endingShape: "rounded",
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
      },
      xaxis: {
        categories: [
          
        ],
      },
      yaxis: {
        title: {
          text: "%",
        },
      },
      fill: {
        opacity: 1,
      },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
    
    const selectTypeChart1 = document.getElementById("select-type-chart");
    const selectedType1 = selectTypeChart1.value;
    updateChart(selectedType1);
</script>
</html>