<?php

require("../DB/conn.php");
require("../controller/pedidosController.php");

    $data = loadPedidosList($conn);
    header('Content-type:application/json');
    echo json_encode($data);

?>