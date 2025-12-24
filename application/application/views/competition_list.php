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



<table id="t01">
  <tr>
    <th>ID</th>
    <th>Ad,Soyad</th>
    <th>Layihə adı</th> 
    <th>Layihə Haqqında</th>
    <th>Həll etdiyi problem(lər)</th>
    <th>İcra müddəti</th>
    <th>Minimal ələb olunan vəsait</th>
    <th>Komanda üzvlərinin sayı</th>
    <th>Telefon</th>
    <th>E-mail</th>
    <th>Əlavələr</th>
    <th>Tarix</th>
  </tr>
  <?php foreach ($users as $user) {?>
  <tr>
    <td><?=$user['id']?></td>
    <td><?=$user['name']?></td>
    <td><?=$user['project_name']?></td>
    <td><?=$user['about_project']?></td>
    <td><?=$user['slovedproblems']?></td>
    <td><?=$user['implementation_period']?></td>
    <td><?=$user['minimum_required_funds']?></td>
    <td><?=$user['number_of_team_members']?></td>
    <td><?=$user['telephone']?></td>
    <td><?=$user['email']?></td>
    <td><?=$user['other']?></td>
    <td><?=$user['createdAt']?></td>
  </tr>
 <?php }?>
</table>

  <div class="clearfix divider_line9 lessm"></div>
  <div class="clearfix"></div>

 

