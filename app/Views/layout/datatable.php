<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html>

<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

    <!-- Dynamic Styling from Controller -->
    <style>
        /* Base styles using controller configuration */
        body {
            font-family: <?= $styles['typography']['fontFamily'] ?? 'system-ui, -apple-system, sans-serif' ?>;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .table-image {
            width: 80px;
            /* Fixed width */
            height: 80px;
            /* Fixed height */
            object-fit: cover;
            /* Maintains aspect ratio and covers area */
            border-radius: 4px;
            /* Slightly rounded corners */
            display: block;
            /* Remove any extra spacing */
        }

        /* Add padding to the table cell containing image */
        td .table-image {
            margin: 5px 0;
            /* Add some vertical spacing */
        }

        .datatable-container {
            background: <?= $styles['container']['background'] ?? 'white' ?>;
            border-radius: <?= $styles['container']['borderRadius'] ?? '12px' ?>;
            box-shadow: 0 4px 6px -1px <?= $styles['colors']['shadow'] ?? 'rgba(0, 0, 0, 0.1)' ?>;
            padding: <?= $styles['container']['padding'] ?? '25px' ?>;
            margin: 20px auto;
            max-width: <?= $styles['container']['maxWidth'] ?? '1400px' ?>;
            <?php if ($styles['animations']['enable'] ?? true): ?>animation: fadeIn <?= $styles['animations']['duration'] ?? '0.5s' ?> <?= $styles['animations']['type'] ?? 'ease-out' ?>;
            <?php endif; ?>
        }

        .datatable-title {
            font-size: <?= $styles['typography']['titleSize'] ?? '24px' ?>;
            font-weight: <?= $styles['typography']['titleWeight'] ?? '600' ?>;
            color: <?= $styles['colors']['primary'] ?? '#2563eb' ?>;
            margin-bottom: <?= $styles['typography']['titleMargin'] ?? '25px' ?>;
            text-align: center;
            position: relative;
            padding-bottom: 10px;
        }

        .datatable-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: <?= $styles['colors']['primary'] ?? '#2563eb' ?>;
            border-radius: 2px;
        }

        /* Table Styles */
        .<?= explode(' ', $styles['tableClass'])[0] ?> {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid <?= $styles['colors']['border'] ?? '#e5e7eb' ?>;
            border-radius: 8px;
            overflow: hidden;
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 14px;
            margin: 0 3px;
            border-radius: 6px;
            border: 1px solid <?= $styles['colors']['border'] ?? '#e5e7eb' ?>;
            background: white;
            color: <?= $styles['colors']['primary'] ?? '#2563eb' ?> !important;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: <?= $styles['colors']['primary'] ?? '#2563eb' ?> !important;
            border-color: <?= $styles['colors']['primary'] ?? '#2563eb' ?>;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: <?= $styles['colors']['primary'] ?? '#2563eb' ?> !important;
            color: white !important;
            border-color: <?= $styles['colors']['primary'] ?? '#2563eb' ?>;
        }

        /* Animation Definitions */
        <?php if ($styles['animations']['enable'] ?? true): ?>@keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        <?php endif; ?>
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .datatable-container {
                padding: calc(<?= $styles['container']['padding'] ?? '25px' ?> / 2);
                margin: 10px;
            }

            .datatable-title {
                font-size: calc(<?= $styles['typography']['titleSize'] ?? '24px' ?> - 4px);
            }
        }
    </style>
</head>

<body>
    <div class="datatable-container">
        <div class="datatable-title"><?= esc($tableTitle) ?></div>

        <table id="<?= esc($tableName) ?>" class="<?= esc($styles['tableClass']) ?>" style="width:100%">
            <thead class="<?= esc($styles['headerClass']) ?>">
                <tr>
                    <?php foreach ($columns as $column): ?>
                        <th><?= esc($column['title']) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Process columns to add image renderer
            const processedColumns = <?= json_encode($columns) ?>.map(column => {
                if (column.title.toLowerCase() === 'image') {
                    return {
                        ...column,
                        className: 'image-cell', // Add a class to the cell
                        width: '100px', // Set column width
                        render: function(title, type, row) {
                            if (type === 'display') {
                                if (!title) return 'No image';
                                return `<img src="<?= base_url('uploads/') ?>${title}" 
                                   class="table-image" 
                                   alt="Table image" 
                                   onerror="this.onerror=null; this.src='<?= base_url('public/uploads/default.jpg') ?>';">`;
                            }
                            return title;
                        }
                    };
                }
                return column;
            });
            const table = $('#<?= esc($tableName) ?>').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?= base_url($apiEndpoint) ?>',
                columns: processedColumns,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print'
                    }
                ],
                <?php if ($styles['animations']['enable'] ?? true): ?>
                    drawCallback: function() {
                        $('tbody tr').css('opacity', 0).each(function(i) {
                            $(this).delay(i * 50).animate({
                                opacity: 1
                            }, 300);
                        });
                    }
                <?php endif; ?>
            });
        });
    </script>
</body>

</html>
<?= $this->endSection() ?>