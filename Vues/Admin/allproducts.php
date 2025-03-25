<div class="col-md-12">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb pl-0">
      <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
      <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
    </ol>
  </nav>
  <div class="card has-shadow p-2">
    <div class="card-header bg-light">
      <h3 class="box-title m-b-0"><a href="javascript:void(0)" data-id="Tous" class="cat_products" style="cursor:pointer">Tous Les articles</a></h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <table class="table table-bordered table-striped table-sm display">
            <thead>
              <tr>
                <th>Categorie</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($cats as $un) {
                $parent = $categories->getCategoryParent($un->category_parent);
                echo '<tr><td><a href="javascript:void(0)" data-id="' . $un->category_id . '" class="cat_products" style="cursor:pointer">' . $un->category_name . '</a>';
                echo '</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-9">
          <div class="table-responsive">
            <?php
            if (!empty($_GET['cat_id'])) {
              if ($_GET['cat_id'] == 'Tous') {
                $datas = $prod->select_all();
                echo '<h3>Catégorie : Tous</h3>';
              } else {
                $datas = $products->select_all_cat($_GET['cat_id']);
                $cat = $categories->getCategoryId($_GET['cat_id']);
                echo '<h3>Catégorie : ' . $cat->category_name . '</h3>';
              }
            } else {
              $dat = $products->select_all_date(date('Y-m-d'));
              echo '<h3>Dernièrs enregistrements</h3>';
            }

            ?>
            <table class="table table-striped table-bordered table-hover table-sm tab" id="data-table">
              <thead>
                <tr>
                  <th>Categorie</th>
                  <th>Produits</th>
                  <th>Cond</th>
                  <th>Qt Min</th>
                  <th>Tarif</th>
                  <th>Modifier</th>
                  <th>Supprimer</th>
                </tr>
              </thead>

              <tbody>
                <?php

                foreach ($dat as $un):
                  $cat = $categories->getCategoryId($un->category_id);

                  if (!empty($un->prod_equiv)) {
                    $e = $products->getProductId($un->prod_equiv);
                    $equiv = $e->product_name;
                  } else {
                    $equiv = '-';
                  }
                ?>
                  <tr>
                    <td><?= $cat->category_name ?></td>
                    <td><?= $un->product_name ?></td>
                    <td><?= $un->unt_mes ?></td>
                    <td><?= $un->qt_min ?></td>
                    <td>
                      <a type="button" href="index.php?p=ProductTarif&product_id=<?= $un->product_id ?>"> Afficher <span class="fa fa-plus"></span></a>
                    </td>
                    <td> <a href="index.php?p=ProductMod&product_id=<?= $un->product_id ?>" class="modifier_product" id="<?= $un->product_id ?>"><span class="fa fa-edit"></span></a></td>
                    <?php if($_SESSION['role']==1):?>
                    <td>
                      <a href="#" class='trash_art' id='<?= $un->category_id ?>'><i class="fa fa-times"></i></a>
                    </td>
                    <?php else: ?>
                      <td>
                      -
                    </td>
                      <?php   endif?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>