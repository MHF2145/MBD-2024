<?php
include '../../service/db.php';

// Delete membership if delete request is made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Set the Membership_MembershipID to NULL for customers with the membership to be deleted
    $sql = 'UPDATE Customers SET Membership_MembershipID = NULL WHERE Membership_MembershipID = ?';
    $statement = $pdo->prepare($sql);
    $statement->execute([$delete_id]);

    // Delete the membership
    $sql = 'DELETE FROM Membership WHERE MembershipID = ?';
    $statement = $pdo->prepare($sql);
    $statement->execute([$delete_id]);

    header('Location: memberships.php');
    exit;
}

// Fetch all memberships
$sql = 'SELECT * FROM Membership';
$statement = $pdo->prepare($sql);
$statement->execute();
$memberships = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Memberships</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-4 text-center">Memberships</h1>
        <a href="add.php" class="block text-center mb-4 text-blue-500 hover:text-blue-700">Add Membership</a>
        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Membership ID</th>
                    <th class="border border-gray-300 px-4 py-2">Customer ID</th>
                    <th class="border border-gray-300 px-4 py-2">Rank</th>
                    <th class="border border-gray-300 px-4 py-2">Join Date</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($memberships as $membership) : ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($membership['MembershipID']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($membership['CustomerID']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($membership['Rank']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($membership['JoinDate']) ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="memberships.php?delete_id=<?= htmlspecialchars($membership['MembershipID']) ?>" onclick="return confirm('Are you sure you want to delete this membership?');" class="ml-2 text-red-500 hover:text-red-700">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../../dashboard.php" class="block text-center mt-4 text-blue-500 hover:text-blue-700">Back to Main Dashboard</a>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4 mt-auto">
        <?php include '../../layout/footer.html'; ?>
    </footer>

</body>
</html>
