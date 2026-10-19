# Point of Sale & Inventory (CodeIgniter 4)

![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-EF4223) ![PHP](https://img.shields.io/badge/PHP-8-777BB4) ![MySQL](https://img.shields.io/badge/MySQL-database-4479A1)

A retail point-of-sale and inventory system for small shops, built with CodeIgniter 4.

## Features

| Area | Controller | What it does |
|---|---|---|
| POS | `Admin/POSController` | Sell at the counter, print invoices, invoice history |
| Inventory | `Admin/Inventory` | Stock levels and stock adjustments |
| Purchasing | `Admin/PurchasesController`, `Admin/Vendor` | Purchases from vendors |
| Catalogue | `Admin/ProductController`, `Admin/BrandController`, `Admin/Units` | Products, brands, units of measure |
| Locations | `Admin/WarehouseController` | Multiple warehouses |
| Customers | `Admin/CustomerController` | Customer records |
| Expenses | `Admin/ExpenseController` | Expense tracking |
| Access | `AuthController`, `Admin/RolesPermissionsController` | Login, profiles, role-based permissions |
| Modules | `ModuleManagementController` | Install new features by uploading a ZIP package |
| Updates | `VersionController` | Checks for new versions, applies updates with a backup, and rolls back if an update fails |
| Tables | `DatatableController` | Server-side DataTables for large lists |

## What's in this repo

This repo holds the application layer: `app/Controllers` and `app/Views`. Models, config and migrations are being cleaned up and will be added next, so it doesn't run on its own yet.

## Author
**Salman Tariq** · [GitHub](https://github.com/salmantariq596) · [Portfolio](https://salmantariq596.github.io)
