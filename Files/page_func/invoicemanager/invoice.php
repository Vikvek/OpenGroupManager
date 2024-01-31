<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    die("No tasks to generate an invoice.");
}

$totalMonetaryValue = 0;
$tasksTable = '<table border="1"><tr><th>Task</th><th>Colleague</th><th>Monetary Value</th></tr>';

foreach ($_SESSION['tasks'] as $task) {
    $tasksTable .= '<tr>';
    $tasksTable .= '<td>' . $task['task'] . '</td>';
    $tasksTable .= '<td>' . $task['colleague'] . '</td>';
    $tasksTable .= '<td>' . $task['monetary_value'] . '</td>';
    $tasksTable .= '</tr>';

    $totalMonetaryValue += $task['monetary_value'];
}

$tasksTable .= '</table>';

// You can customize the invoice format as needed
$invoiceContent = "
    <h2>Self-Billing Invoice</h2>
    <p>Total Monetary Value: $totalMonetaryValue</p>
    $tasksTable
";

echo $invoiceContent;
