<?php
    // echo "teste";exit();
    $title = 'Lista Produtos';
?>


<?php include_once(__DIR__ . '/../components/header.php'); ?>

<body style="background-color: #f8f9fa">
    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>
    <?php 
        $breadcrumbs = [
            ['label' => 'Produtos']
        ];
        include_once(__DIR__ . '/../components/breadcrumb.php');
    ?>
    
    <div class="container mt-4">

        <form class="d-flex my-5" role="search">
            <input class="form-control me-2" type="search" placeholder="Pesquisar Produto" aria-label="Pesquisar Produto"/>
            <button class="btn btn-outline-success" type="submit"> Pesquisar </button>
        </form>

        <!-- listagem de produtos -->
        <div class="row">
        </div>
    </div>
</body>

<?php include_once(__DIR__ . '/../components/footer.php'); ?>

<script src="../../assets/js/lista-produtos.js"></script>