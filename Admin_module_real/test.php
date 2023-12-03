
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
    			<table id="employee_data" class="table table-striped table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Designation</th>
                        <th>Age</th>
                    </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                        </tr>
                </table>
</body>
</html>
<script type="text/javascript">
function html_table_to_excel(type)
  {
      var data = document.getElementById('employee_data');

      var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

      XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

      XLSX.writeFile(file, 'file.' + type);
  }

      html_table_to_excel('xlsx');
      window.location.href = "index.php";
</script>
