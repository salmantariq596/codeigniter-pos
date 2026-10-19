<aside class="sidebar">
    <div class="accordion" id="sidebarAccordion">
        <div class="d-flex align-items-center px-3 py-2">
            <i class="bi bi-speedometer2 fs-4 text-primary me-3"></i>
            <a class="text-dark fw-medium text-decoration-none fs-5" href="/dashboard-new">Dashboard</a>
        </div>
        
        <?php $menuData = $menuData ?? []; ?>
        <?php foreach ($menuData as $index => $section): ?>
            <div class="accordion-item border-0">
                <h2 class="accordion-header" id="heading<?= $index ?>">
                    <button class="accordion-button collapsed py-2" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $index ?>"
                        aria-expanded="false"
                        aria-controls="collapse<?= $index ?>">
                        <i class="bi bi-<?= esc($section['icon']) ?> me-3"></i>
                        <?= esc($section['name']) ?>
                    </button>
                </h2>
                <div id="collapse<?= $index ?>"
                    class="accordion-collapse collapse"
                    aria-labelledby="heading<?= $index ?>"
                    data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body py-2">
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($section['items'] as $item): ?>
                                <li class="mb-2">
                                    <a href="<?= site_url($item['url']) ?>"
                                        class="text-decoration-none text-secondary d-flex align-items-center">
                                        <i class="bi bi-<?= esc($item['icon']) ?> me-2"
                                            style="color: <?= esc($item['icon_color']) ?>;">
                                        </i>
                                        <span><?= esc($item['name']) ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</aside>