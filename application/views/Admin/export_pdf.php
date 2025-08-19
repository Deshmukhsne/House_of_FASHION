<!DOCTYPE html>
<html>
<head>
    <title>Customer List - Printable PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .print-btn {
            display: block;
            margin: 0 auto 30px auto;
            padding: 10px 20px;
            background-color: #b37b16;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }

        @media print {
            .print-btn {
                display: none;
                height:40px ;
                 width: 100px;
            }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">🖨️ Print / Save as PDF</button>

    <h2>Customer List</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $cust): ?>
                <tr>
                    <td><?= $cust->id ?></td>
                    <td><?= htmlspecialchars($cust->name) ?></td>
                    <td><?= htmlspecialchars($cust->contact) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
