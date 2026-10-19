<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>Add Brand</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>
    <?= $this->section('content') ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Card Wrapper -->
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h2 class="mb-0">Add New Brand</h2>
                    </div>
                    <div class="card-body">
                        <!-- Form Starts -->
                        <form action="/brands/store" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Brand Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter brand name" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save Brand
                                </button>
                            </div>
                        </form>
                        <!-- Form Ends -->
                    </div>
                    <div class="card-footer text-center">
                        <a href="/brands" class="btn btn-link text-decoration-none">
                            <i class="bi bi-arrow-left"></i> Back to All Brands
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
