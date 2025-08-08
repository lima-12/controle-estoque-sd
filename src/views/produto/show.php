<?php
    // echo "teste";exit();
    $title = 'Detalhes Produto';
?>


<?php include_once(__DIR__ . '/../components/header.php'); ?>

<body style="background-color: #f8f9fa">
    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>
    <?php 
        $breadcrumbs = [
            ['label' => 'Produtos', 'href' => dirname($_SERVER['SCRIPT_NAME']) . '/index.php'],
            ['label' => 'Detalhes']
        ];
        include_once(__DIR__ . '/../components/breadcrumb.php');
    ?>
    
    <div class="container mt-4">
        <div id="produto-detalhes"></div>
    </div>
</body>

<?php include_once(__DIR__ . '/../components/footer.php'); ?>

<script src="../../assets/js/produto/show.js"></script>