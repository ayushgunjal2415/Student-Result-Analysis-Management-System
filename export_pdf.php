<?php

require 'vendor/autoload.php';
include 'db.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Grade helper
function getGrade($marks){

    if($marks >= 90){
        return "O";
    }
    elseif($marks >= 80){
        return "A+";
    }
    elseif($marks >= 70){
        return "A";
    }
    elseif($marks >= 60){
        return "B";
    }
    elseif($marks >= 50){
        return "C";
    }
    elseif($marks >= 40){
        return "D";
    }
    else{
        return "F";
    }
}

// Dompdf config
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Fetch data
$result = $conn->query("SELECT * FROM students ORDER BY id ASC");

// HTML
$html = '
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<style>

body{
    font-family: Arial, sans-serif;
}

h2{
    text-align:center;
    color:#333;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th, td{
    border:1px solid #000;
    padding:10px;
    text-align:center;
}

th{
    background:#5f2c82;
    color:white;
}

tr:nth-child(even){
    background:#f2f2f2;
}

</style>

</head>

<body>

<h2>Student Results Report</h2>

<table>

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Subject</th>
    <th>Marks</th>
    <th>Grade</th>
</tr>
';

while($row = $result->fetch_assoc()){

    $html .= '
    <tr>
        <td>'.$row['id'].'</td>
        <td>'.$row['name'].'</td>
        <td>'.$row['subject'].'</td>
        <td>'.$row['marks'].'</td>
        <td>'.getGrade((float)$row['marks']).'</td>
    </tr>
    ';
}

$html .= '
</table>

</body>
</html>
';

// Load HTML
$dompdf->loadHtml($html);

// Paper size
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Download PDF
$dompdf->stream("student_results.pdf", ["Attachment" => true]);

?>