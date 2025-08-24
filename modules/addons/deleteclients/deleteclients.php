<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;

/**
 * Module Configuration
 */
function deleteclients_config()
{
    return [
        'name' => 'Delete Clients',
        'description' => 'Addon to delete clients from WHMCS with all related data.',
        'version' => '1.2',
        'author' => 'Puffx Host',
        'fields' => []
    ];
}

/**
 * Module Activation
 */
function deleteclients_activate()
{
    return ['status' => 'success', 'description' => 'Delete Clients Addon activated successfully.'];
}

/**
 * Module Deactivation
 */
function deleteclients_deactivate()
{
    return ['status' => 'success', 'description' => 'Delete Clients Addon deactivated.'];
}

/**
 * Module Output (Admin Area)
 */
function deleteclients_output($vars)
{
    // CSS Styles
    echo '<style>
        .delete-clients-container {
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        .delete-clients-header {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .client-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        .client-table th {
            background-color: #3498db;
            color: white;
            padding: 12px 15px;
            text-align: left;
        }
        .client-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .client-table tr:hover {
            background-color: #f5f5f5;
        }
        .client-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #c0392b;
        }
        .btn-secondary {
            background-color: #95a5a6;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .checkbox-cell {
            text-align: center;
        }
        .search-box {
            margin-bottom: 10px;
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .filter-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        .filter-label {
            margin-bottom: 5px;
            font-weight: 600;
            color: #495057;
        }
        .filter-select {
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            min-width: 200px;
        }
        .status-active {
            color: #28a745;
            font-weight: 600;
        }
        .status-inactive {
            color: #dc3545;
            font-weight: 600;
        }
        .email-verified {
            color: #28a745;
        }
        .email-unverified {
            color: #dc3545;
        }
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        .pagination li {
            margin-right: 5px;
        }
        .pagination a {
            display: block;
            padding: 8px 12px;
            background-color: #f1f1f1;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
        .pagination .active a {
            background-color: #3498db;
            color: white;
        }
        .badge {
            display: inline-block;
            padding: 3px 7px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border-radius: 10px;
        }
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
    </style>';

    echo '<div class="delete-clients-container">';
    echo '<h1 class="delete-clients-header">Delete Clients</h1>';
    echo '<p>Select clients to delete and all their associated data (orders, services, invoices, transactions).</p>';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_ids'])) {
        $clientIds = $_POST['client_ids'];
        $successCount = 0;
        $errorCount = 0;

        foreach ($clientIds as $clientId) {
            try {
                // Start transaction for each client
                Capsule::connection()->transaction(function() use ($clientId) {
                    // Delete related data first to maintain referential integrity
                    Capsule::table('tblorders')->where('userid', $clientId)->delete();
                    Capsule::table('tblhosting')->where('userid', $clientId)->delete();
                    Capsule::table('tbldomains')->where('userid', $clientId)->delete();
                    Capsule::table('tblinvoices')->where('userid', $clientId)->delete();
                    Capsule::table('tblinvoiceitems')->where('userid', $clientId)->delete();
                    Capsule::table('tbltransactions')->where('userid', $clientId)->delete();
                    Capsule::table('tbltickets')->where('userid', $clientId)->delete();
                    Capsule::table('tblticketreplies')->where('userid', $clientId)->delete();
                    Capsule::table('tblnotes')->where('userid', $clientId)->delete();
                    
                    // Finally delete the client
                    Capsule::table('tblclients')->where('id', $clientId)->delete();
                });
                $successCount++;
            } catch (Exception $e) {
                echo '<div class="alert alert-error">Error deleting client ID ' . htmlspecialchars($clientId) . ': ' . htmlspecialchars($e->getMessage()) . '</div>';
                $errorCount++;
            }
        }

        if ($successCount > 0) {
            echo '<div class="alert alert-success">Successfully deleted ' . $successCount . ' client(s). ' . ($errorCount > 0 ? 'Failed to delete ' . $errorCount . ' client(s).' : '') . '</div>';
        }
    }

    // Pagination setup
    $perPage = 25;
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $perPage;

    // Filter setup
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
    $emailVerifiedFilter = isset($_GET['email_verified']) ? $_GET['email_verified'] : '';
    
    $query = Capsule::table('tblclients')->orderBy('id', 'desc');

    // Apply filters
    if (!empty($searchTerm)) {
        $query->where(function($q) use ($searchTerm) {
            $q->where('firstname', 'like', '%' . $searchTerm . '%')
              ->orWhere('lastname', 'like', '%' . $searchTerm . '%')
              ->orWhere('email', 'like', '%' . $searchTerm . '%')
              ->orWhere('id', 'like', '%' . $searchTerm . '%');
        });
    }

    if ($statusFilter === 'active') {
        $query->where('status', 'Active');
    } elseif ($statusFilter === 'inactive') {
        $query->where('status', 'Inactive');
    }

    if ($emailVerifiedFilter === 'verified') {
        $query->where('email_verified', 1);
    } elseif ($emailVerifiedFilter === 'unverified') {
        $query->where('email_verified', 0);
    }

    $totalClients = $query->count();
    $clients = $query->skip($offset)->take($perPage)->get();
    $totalPages = ceil($totalClients / $perPage);

    // Filter form
    echo '<form method="get" action="">';
    echo '<input type="hidden" name="module" value="deleteclients">';
    
    echo '<div class="filter-container">';
    
    // Search filter
    echo '<div class="filter-group">';
    echo '<label class="filter-label">Search</label>';
    echo '<input type="text" class="search-box" name="search" placeholder="Search clients..." value="' . htmlspecialchars($searchTerm) . '">';
    echo '</div>';
    
    // Status filter
    echo '<div class="filter-group">';
    echo '<label class="filter-label">Status</label>';
    echo '<select class="filter-select" name="status">';
    echo '<option value="">All Statuses</option>';
    echo '<option value="active"' . ($statusFilter === 'active' ? ' selected' : '') . '>Active</option>';
    echo '<option value="inactive"' . ($statusFilter === 'inactive' ? ' selected' : '') . '>Inactive</option>';
    echo '</select>';
    echo '</div>';
    
    // Email verification filter
    echo '<div class="filter-group">';
    echo '<label class="filter-label">Email Verification</label>';
    echo '<select class="filter-select" name="email_verified">';
    echo '<option value="">All</option>';
    echo '<option value="verified"' . ($emailVerifiedFilter === 'verified' ? ' selected' : '') . '>Verified</option>';
    echo '<option value="unverified"' . ($emailVerifiedFilter === 'unverified' ? ' selected' : '') . '>Unverified</option>';
    echo '</select>';
    echo '</div>';
    
    // Submit button
    echo '<div class="filter-group">';
    echo '<button type="submit" style="padding: 8px 15px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">Apply Filters</button>';
    echo '</div>';
    
    // Clear filters button
    if (!empty($searchTerm) || !empty($statusFilter) || !empty($emailVerifiedFilter)) {
        echo '<div class="filter-group">';
        echo '<a href="?module=deleteclients" class="btn btn-secondary" style="text-decoration: none;">Clear Filters</a>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</form>';

    if ($totalClients == 0) {
        echo '<p>No clients found matching your criteria.</p>';
        echo '</div>';
        return;
    }

    // Client deletion form
    echo '<form method="post" onsubmit="return confirm(\'Are you sure you want to delete the selected clients? This will permanently delete all their data including orders, services, invoices, and transactions.\')">';
    echo '<table class="client-table">';
    echo '<thead><tr>';
    echo '<th width="50px"><input type="checkbox" id="select-all"></th>';
    echo '<th>ID</th>';
    echo '<th>Name</th>';
    echo '<th>Email</th>';
    echo '<th>Status</th>';
    echo '<th>Email Verified</th>';
    echo '<th>Company</th>';
    echo '<th>Date Created</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    foreach ($clients as $client) {
        $statusClass = strtolower($client->status) === 'active' ? 'status-active' : 'status-inactive';
        $emailVerifiedClass = $client->email_verified ? 'email-verified' : 'email-unverified';
        $emailVerifiedText = $client->email_verified ? 'Verified' : 'Unverified';
        
        echo '<tr>';
        echo '<td class="checkbox-cell"><input type="checkbox" name="client_ids[]" value="' . $client->id . '"></td>';
        echo '<td>' . $client->id . '</td>';
        echo '<td>' . htmlspecialchars($client->firstname . ' ' . $client->lastname) . '</td>';
        echo '<td>' . htmlspecialchars($client->email) . '</td>';
        echo '<td><span class="' . $statusClass . '">' . $client->status . '</span></td>';
        echo '<td><span class="' . $emailVerifiedClass . '">' . $emailVerifiedText . '</span></td>';
        echo '<td>' . htmlspecialchars($client->companyname) . '</td>';
        echo '<td>' . date('Y-m-d', strtotime($client->datecreated)) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    // Pagination
    if ($totalPages > 1) {
        echo '<ul class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = $i == $currentPage ? ' class="active"' : '';
            $queryParams = ['module' => 'deleteclients', 'page' => $i];
            if (!empty($searchTerm)) $queryParams['search'] = $searchTerm;
            if (!empty($statusFilter)) $queryParams['status'] = $statusFilter;
            if (!empty($emailVerifiedFilter)) $queryParams['email_verified'] = $emailVerifiedFilter;
            $url = '?' . http_build_query($queryParams);
            echo '<li' . $active . '><a href="' . $url . '">' . $i . '</a></li>';
        }
        echo '</ul>';
    }

    echo '<button type="submit" class="btn">Delete Selected Clients</button>';
    echo '</form>';

    // JavaScript for select all functionality
    echo '<script>
        document.getElementById("select-all").addEventListener("change", function() {
            var checkboxes = document.querySelectorAll("input[name=\"client_ids[]\"]");
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>';

    echo '</div>';
}
