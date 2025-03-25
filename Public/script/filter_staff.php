<?php
session_start();
require_once('../../Models/Admin/user.class.php');
require_once("../../Models/Admin/devise.class.php");
$users = new User();
$devise = new Devise();

$devise2 = $devise->getDevises2();
$devise3 = $devise->getDevises3();
$datas = $users->getStaffBrancheSalaire($_POST['id']);
if(!empty($datas)):
?>

<table size="100%" width="100%" class="table table-condensed table-stripped" id="data-table">
<thead>
    <tr class="tb-tnx-head">
        <th>Noms</th>
        <th>Salaire Net</th>
        <th>A Payer</th>
    </tr>
</thead>
<tbody>
  <?php
foreach ($datas as $e) : ?>
  <tr style="margin-top:7;">
    <td><strong><?= $e->noms ?></strong></td>
    <input type="hidden" name="staff_id[]" id="staff_id" readonly value="<?= $e->staff_id ?>">
    <input type="hidden" name="devise[]" id="devise" readonly value="<?= $e->devise_id ?>">
    <td>
      <div class="form-group">
        <input type="text" class="form-control" id="default-05" readonly value="<?= $e->salaire ?><?= $e->short ?> (<?= number_format($e->salaire * $devise3->taux) ?> <?= $devise3->short ?>) ">
      </div>
    </td>
    <td class="fw-bold">
      <div class="form-group">
        <input type="text" class="form-control" name="salaire[]" id="salaire" value="<?= $e->salaire ?>">
      </div>
    </td>
  </tr>
<?php endforeach; ?>

</tbody>
</table>
<?php  else: echo "<h3>Aucune Donnee</h3>"; endif?>