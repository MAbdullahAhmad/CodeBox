<?php
  if (!isset($conn))
  require "../conn.php";

  // Configuration
  // - Create
  $table_name = "products";
  $create_required_fields = ['title', 'category_id', 'price', 'description'];
  // - Edit
  $edit_required_fields = ['id'];
  $editable_fields = ['title', 'category_id', 'price', 'description'];
  $editable_field_validators = [
    'category_id' => function ($value) {
      global $conn;
      $qry = "SELECT count(id) FROM categories WHERE id='$value';";
      return ($res = mysqli_query($conn, $qry)) &&
        (mysqli_num_rows($res) == 1) &&
        (mysqli_fetch_row($res)[0] == 1);
    }
  ];

  // - Delete
  $delete_required_fields = [
    'delete' => 'id',
  ];

  // Response Initial
  $response = [
    'status' => false,
    'msg' => 'Unable to create due to unknown error!'
  ];

  // Validating Data - Create
  $valid_create = true;
  foreach ($create_required_fields as $field)
    if (!array_key_exists($field, $_POST)){
      $valid_create = false;
      // $response['msg'] = 'These fields are rquired: ' . implode(", ", $create_required_fields);
      $response['msg'] = 'Invalid Data!';
    } else $_POST[$field] = clean($_POST[$field]);

  if ($valid_create){
    // Building Query - Create
    $qry = "INSERT INTO `$table_name`(`" . implode("`,`", $create_required_fields) . "`) VALUES (";
    foreach($create_required_fields as $field)
      $qry .= "'" . $_POST[$field] . "', ";
    $qry = substr($qry, 0, strlen($qry) - 2) . ");";

    // Running Query - Create
    if (mysqli_query($conn, $qry)) {
      $response['status'] = true;
      $response['msg'] = 'Created successfully!';
    } else $response['msg'] = 'Unable to create due to DB error!';
  } else {
    // Validating Data - Edit
    $valid_edit = true;
    foreach($edit_required_fields as $field)
      if (!array_key_exists($field, $_POST)){
        $valid_edit = false;
        $response['msg'] = 'Invalid Data!';
      } else $_POST[$field] = clean($_POST[$field]);
    
    if($valid_edit){
      // Further Validating - Edit
      $qry = "UPDATE `$table_name` SET ";
      $edit_data = false;
      foreach($editable_fields as $field)
        if(array_key_exists($field, $_POST))
        $edit_data = true;

      if(!$edit_data) $response['msg'] = 'Kindly provide a value to update (You can update: ' . implode(", ", $editable_fields) . ')!';
      else {
        // Building Query - Edit
        foreach($editable_fields as $field)
          if(array_key_exists($field, $_POST)){
            $updated_value = clean($_POST[$field]);
            $qry .= "`$field` = '$updated_value', ";
          }
        $qry = substr($qry, 0, strlen($qry)-2) . "WHERE ";
        foreach($edit_required_fields as $field)
          $qry .= "`$field` = '". $_POST[$field] ."' AND ";
        $qry = substr($qry, 0, strlen($qry)-5) . ";";

        // Running Query - Edit
        if (mysqli_query($conn, $qry)) {
          $response['status'] = true;
          $response['msg'] = 'Edited successfully!';
        } else $response['msg'] = 'Unable to edit due to DB error!';
      }
    } else {
      // Validating Data - Delete
      $valid_delete = true;
      foreach(array_keys($delete_required_fields) as $field)
        if (!array_key_exists($field, $_POST)){
          $valid_delete = false;
          $response['msg'] = 'Invalid Data!';
          break;
        } else {
          $_POST[$field] = clean($_POST[$field]);
          if( in_array($field, $editable_field_validators) &&
            !$editable_field_validators[$field]($_POST[$field])
          ){ $valid_delete = false;
            $response['msg'] = "Invalid $field!";
            break;
          }
        }
      
      if($valid_delete){
        // Building Query - Delete
        $qry = "DELETE FROM `$table_name` WHERE ";
        foreach($delete_required_fields as $field => $db_field)
          $qry .= "`$db_field` = '". $_POST[$field] ."' AND ";
        $qry = substr($qry, 0, strlen($qry)-5) . ";";

        // Running Query - Delete
        if (mysqli_query($conn, $qry)) {
          $response['status'] = true;
          $response['msg'] = 'Deleted successfully!';
        } else $response['msg'] = 'Unable to delete due to DB error!';
      }
    }
  }

  // Send JSON Response
  echo json_encode($response);
?>