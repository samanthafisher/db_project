<!DOCTYPE html>
<html>
    <script language="javascript" type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
  <head>
  <title>Modern Shadow</title>
  </head>
  <body>

  <header>
    <h1>Friend Requests</h1>
  </header>
  
  <?php
    include "util.php";

    $q = "select uid1, first_name, last_name, age, gender, location, requesttime, response from friendrequests, userinfo where uid2 = '13092' and friendrequests.uid1 = userinfo.uid";
    $errormsg = "You do not have any friends.";    

    function print_table_with_checkbox($query_result) {
      echo "<table>";
      echo "<tr>";
      echo "<th></th>";
      $checkboxes = "<input type='checkbox' id='check' name='selected[]' value='yes'/><br />";


      for ($i = 1; $i < pg_num_fields($query_result); $i++) {
        $fieldname = pg_field_name($query_result, $i);
        echo "<th>$fieldname</th>";
      }
      echo "</tr>";

      while ($row = pg_fetch_row($query_result)) {
        echo "<tr>"; 
        echo "<td>$checkboxes</td>";
        $num = pg_num_fields($query_result);
        for ($i = 0; $i < $num; $i++) {
          echo "<td> $row[$i]</td>";
        }
        echo "<tr>";
      }
      echo "</table>";
  }

    print_table_with_checkbox(get_query($q, $errormsg));

  ?>

  <input type="submit" class="button" id="accept_request" name="accept" value="Accept" />
  <input type="submit" class="button" id="decline_request" name="decline" value="Decline" />

  <script type="text/javascript">

  $(document).ready(init);

  function init() {
    $('#accept_request').click(call_ajax);
    $('#decline_request').click(call_ajax);
    $('#check').click(call_ajax);
  }

  function call_ajax(event) {
    var clickBtnValue = $("#uid_input").val();
    console.log($("#uid_input").val());
    var ajaxurl = 'ajax.php';
    data =  {'action': clickBtnValue};
    $.post(ajaxurl, data, handle_result);
  }

  function handle_result(response) {
      alert(response);
  }
  </script>

</html>