 <style>
table {
  width:100%;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  text-align: left;
}
table#t01 tr:nth-child(even) {
  background-color: #eee;
}
table#t01 tr:nth-child(odd) {
 background-color: #fff;
}
table#t01 th {
  background-color: black;
  color: white;
}
</style>
<div class="clearfix"></div>
<div class="clearfix"></div>

  <div class="clearfix divider_line9 lessm"></div>
  <div class="clearfix"></div>
       <h2 >Qeydiyyatdan Keçənlər</h2>



<table id="t01" cellspacing="5" cellpadding="5" style="padding:5px">
  <tr>
    <th>ID</th>
    <th>Name / Surname </th>
    <th>Project name</th> 
    <th>Category</th>
    <th>Problem</th>
    <th>Solution</th>
    <th>Customers</th>
    <th>Money</th>
    <th>Additional Information</th>
    <th>Institution </th>
    <th>Type</th>
    <th>Gender</th>
    <th>Age</th>
    <th>E-mail</th>
    <th>Phone</th>
    <th>Time-stamp</th>
  </tr>
  <?php foreach ($users as $user) {?>
  <tr>
    <td><?=$user['id']?></td>
    <td><?=$user['name']?></td>
    <td><?=$user['name_your_idea']?></td>
    <td><?=$user['category']?></td>
    <td><?=$user['problem']?></td>
    <td><?=$user['solution']?></td>
    <td><?=$user['customers']?></td>
    <td><?=$user['money']?></td>
    <td><?=$user['additional_information']?></td>
    <td><?=$user['institution']?></td>
    <td><?=$user['etype']?></td>
    <td><?=$user['gender']?></td>
    <td><?=$user['age']?></td>
    <td><?=$user['email']?></td>
    <td><?=$user['phone']?></td>
    <td><?=$user['create_time']?></td>
  </tr>
 <?php }?>
</table>

  <div class="clearfix divider_line9 lessm"></div>
  <div class="clearfix"></div>

 

