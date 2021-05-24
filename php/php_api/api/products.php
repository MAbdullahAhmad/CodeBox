<?php
  if (!isset($conn))
  require "../conn.php";

  // Configuration
  $table_name = "products";
  $fields = ['id', 'title', 'category_id', 'price', 'description'];
  $orderable_fields = $fields;
  $conditionable_fields = array_diff($fields, ['description']);

  // Response Initial
  $response = [
    'status' => false,
    'data' => []
  ];

  // Building Query
  $qry = "SELECT `" . implode("`,`", $fields) . "` FROM `$table_name`";

  // Exact
  $condition_started = false;
  foreach($_GET as $key => $value)
    if(in_array($key, $conditionable_fields)){
      if(!$condition_started){
        $qry .= " WHERE ";
        $condition_started = true;
      } else $qry .= " AND ";
      $value = clean($value);
      $qry .= "`$key` = '$value'";
    } elseif (in_array($key, $fields)) $response['msg'] = "Sorry! I can only apply condition on these fields: " . implode(", ", $conditionable_fields);
  // Order
  if (isset($_GET['order_by'])) {
    if (in_array($_GET['order_by'], $orderable_fields)) {
      $qry .= " ORDER BY `" . $_GET['order_by'] . "` " . ((isset($_GET['order']) && in_array($_GET['order'], ['DESC', 'desc', '-']))?"DESC":"ASC");
    } else $response['msg'] = "Can only ordery by these fields: " . implode(", ", $orderable_fields);
  }
  $qry .= ";";

  // Fetch
  if(!isset($response['msg'])){
    if($qry_res = mysqli_query($conn, $qry)){
      $response['status'] = true;
      while($row=mysqli_fetch_assoc($qry_res))
        $response['data'] []= $row;
    } else $response['msg'] = 'Error while fetching data!';
  }

  // Limit & Pagination
  if (isset($_GET['limit'])){
    if(is_numeric($_GET['limit'])){
      $_GET['limit'] = (int)$_GET['limit'];
      if ($_GET['limit'] > 0){
        if (isset($_GET['page'])){
          if(is_numeric($_GET['page'])){
            $_GET['page'] = (int)$_GET['page'];
            if ($_GET['page'] > 0){
              $response['data'] = array_slice($response['data'], $_GET['limit']*($_GET['page']-1)-1, $_GET['limit']);
            } else $response = [
              "status" => false,
              "msg" => "Page must be positive integer!",
              "data" => [],
            ];
          } else $response = [
            "status" => false,
            "msg" => "Page must be numeric!",
            "data" => [],
          ];
        }
      } else $response = [
        "status" => false,
        "msg" => "Limit must be positive integer!",
        "data" => [],
      ];
    } else $response = [
      "status" => false,
      "msg" => "Limit must be numeric!",
      "data" => [],
    ];
  }

  // Send JSON Response
  echo json_encode($response);
?>