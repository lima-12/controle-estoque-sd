<?php
    /**
     * Componente de Breadcrumb (Bootstrap 5)
     *
     * Espera um array $breadcrumbs com itens no formato:
     * [
     *   ['label' => 'Texto', 'href' => '/caminho/opcional'],
     *   ['label' => 'Atual (sem href)']
     * ]
     * O último item é marcado como ativo automaticamente.
     */

    // Garante que $breadcrumbs exista como array
    $breadcrumbs = isset($breadcrumbs) && is_array($breadcrumbs) ? $breadcrumbs : [];

    // Fallback simples usando $title se nenhum breadcrumb for passado
    if (empty($breadcrumbs)) {
        $breadcrumbs = [
            ['label' => $title ?? 'Página']
        ];
    }
?>

<nav style="font-weight: bold; --bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <div class="container py-2">
        <ol class="breadcrumb mb-0">
            <?php foreach ($breadcrumbs as $index => $item): ?>
                <?php
                    $isLast = ($index === array_key_last($breadcrumbs));
                    $label = htmlspecialchars($item['label'] ?? '');
                    $href  = $item['href'] ?? null;
                ?>

                <?php if ($isLast): ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $label; ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item">
                        <?php if (!empty($href)): ?>
                            <a href="<?php echo htmlspecialchars($href); ?>"><?php echo $label; ?></a>
                        <?php else: ?>
                            <?php echo $label; ?>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>

