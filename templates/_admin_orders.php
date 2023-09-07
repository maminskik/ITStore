<?php
include_once './classes/Orders.php';
include_once './helpers/session_helper.php';
include_once './classes/User.php';

$order = new Orders();
$orders = $order->getAllOrders();

$user = new User();
?>

<section class="admin-orders">
    <div class="container-dashboard">
        <div class="row">
            <div class="col-lg-12">
                <h1>ZAMÓWIENIA</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Wartość</th>
                            <th>Data Wystawienia</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>

                    <?php if (is_array($orders) || is_object($orders)) : ?>
                    <tbody>
                        <?php foreach ($orders as $o) {
                                $name = $user->findUseryById($o->UserId);
                            ?>
                        <tr>
                            <td><?php echo $name->Name; ?></td>
                            <td><?php echo $name->Surname; ?></td>
                            <td><?= $o->Value; ?></td>
                            <td><?= $o->Date_Invoice ?></td>
                            <td> <a href="admin_orders_details.php?order_id=<?= $o->OrderId; ?>">
                                    <ion-icon name="information-sharp" class="admin-panel-icon" style="color:black">
                                    </ion-icon>
                                </a></td>

                        </tr>
                        <?php } ?>
                    </tbody>
                    <?php else : ?>
                    <tbody>
                        <tr>
                            <td colspan="5">Brak zamówień</td>
                        </tr>
                    </tbody>
                    <?php endif; ?>

                </table>
            </div>
        </div>
    </div>
</section>