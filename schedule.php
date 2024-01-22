<head>
    <meta charset="utf-8">
    <title>Schedule</title>
    <style>
        a {
            color: white;
        }
        
        p {
            font-size: 1em;
            color: white;
            opacity: 1;
            padding: 5px;
            background-image: linear-gradient(to right, rgba(218,142,231, 0) 0%, rgba(218,142,231, 1) 35%, rgba(218,142,231, 1) 65%, rgba(218,142,231, 0) 100%);
        }
        
        caption {
            font-size: 1.25em;
            font-weight: thin;
            color: #ffffff;
            padding: 10px;
            background-image: linear-gradient(to right, rgba(218,142,231, 0) 0%, rgba(218,142,231, 1) 35%, rgba(218,142,231, 1) 65%, rgba(218,142,231, 0) 100%);
        }
        thead {
            border: 1px solid #673ab7;
            position: sticky;
            z-index: 9999;
            top: 0; /* 将表头固定在页面顶部 */
        }
        /* 设置表格边框和间距 */
        table {
          width: 95%;
          top: 0px;
          margin-bottom: 15px;
          border-collapse: collapse;
          border-spacing: 0;
          text-align: center;
          font-size: 1.25em;
        }
        
        /* 设置表头样式 */
        th {
          font-weight: bold;
          background-color: #673ab7;
          color: #ffffff;
          padding: 0.5vw;
        }
        
        /* 设置表格单元格样式 */
        td {
          border: 1px solid #673ab7;
          color: #ffffff;
          padding: 0.5vw;
          word-wrap: break-word;
          white-space: pre-wrap;
        }
        
        td.diagonal {
          transform: rotate(45deg);
        }
        
        td.upcoming {
            font-weight: bold;
        }

        tr {
          background-color: #DA8EE7;
        }
        
        tr:hover {
          background-color: #673ab7!important;
          color: #ffffff;
        }
        
        tr.today {
          background-color: #9A6ED7;
          color: #ffffff;
        }
        
        #id {
            width: 4vw;
        }
        
        #name {
            width: 15vw;
        }
        
        #reply {
            width: 53vw;
        }
        
        #time {
            width: 20vw;
        }
        
        #ip {
            width: 8vw;
        }
        @media (orientation: portrait){
            table {
                font-size: 1.25em;
            }
            th {
                padding: 0.5vh;
            }
            td {
                padding: 0.5vh;
            }
            td:nth-child(5),
            th:nth-child(5) {
              display: none;
            }
        
            #name {
                width: 19vw;
            }
            
            #reply {
                width: 57vw;
            }
        }
        
        @media (max-width: 500px) {
            table {
                font-size: 0.8em;
            }
        }
        
        ::-webkit-scrollbar {
            width: 0.8em;
            background-color: #E1BEE7;
        }
        
        ::-webkit-scrollbar-thumb {
            background-color: #BA68C8;
        }
    
        ::selection {
            background-color: #AB47BC;
            color: #ffffff;
        }
    </style>
</head>
<?php
// 设置请求参数
$from = time(); // 当前时间戳
$to = strtotime('+1 month'); // 一个月后的时间戳
$utc_offset = 28800;

// 缓存文件路径
$cache_file = './data/schedule_cache.json';

$json_data = file_get_contents($cache_file);


// 解析 JSON 数据
$data = json_decode($json_data, true);

// 解码 JSON 数据为 PHP 对象或数组
$data = json_decode($json_data);

// 检查 JSON 解码是否成功
if ($data === null) {
    echo "JSON 解码失败:";
    echo $url;
    exit;
}

echo '<table class="schedule" align="center">';
echo '<caption>Momo的本月日程</caption>';
echo '<thead style="white-space:nowrap"><tr>
        <th>事项</th>
        <th>时间</th>
        <th>地点</th>
    </tr></thead><tbody>';

$upcoming = false;
foreach ($data->public_events as $event) {
    if(date('Y-m-d', $event->start_at / 1000)===date('Y-m-d'))
        echo '<tr class="today">';
    else
        echo '<tr>';
    if(($event->start_at / 1000) >= time() && $upcoming === false){
        echo '<td class="upcoming">' . $event->title . '(即将到来)</td>';
        $upcoming = true;
    } else {
        echo '<td>' . $event->title . '</td>';
    }
    echo '<td>' . date('Y-m-d H:i:s', $event->start_at / 1000) . '</td>';
    echo '<td>';
    if($event->location_url) {
        echo '<a href="' . $event->location_url . '" target="_blank">Link</a>';
    }
    else {
        echo '/';
    }
    echo '</td>';
    echo '</tr>';
}

echo '<tbody></table>';
echo '<center><p>最新日程表请参考<a href="https://timetreeapp.com/public_calendars/momomitsuki" target="_blank">Timetreeapp</a></p></center>';
?>
