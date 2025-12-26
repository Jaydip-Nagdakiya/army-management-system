<?php
include('check_login.php');
header('Content-Type: application/json');

$location = $_POST['location'] ?? '';
$unit     = $_POST['unit'] ?? '';

if ($location && $unit) {

    $rules = [
        'Border Camp' => [
            'Infantry'       => ['Sepoy', 'Lance Naik', 'Naik', 'Havildar', 'Naib Subedar'],
            'Artillery'      => ['Lance Naik', 'Naik', 'Havildar', 'Naib Subedar'],
            'Engineering'    => ['Sepoy', 'Lance Naik', 'Naik', 'Havildar'],
            'Medical'        => ['Naik', 'Havildar', 'Captain', 'Medical Officer'],
            'Communication'  => ['Lance Naik', 'Naik', 'Havildar'],
            'Logistics'      => ['Naik', 'Havildar', 'Naib Subedar', 'Logistics Officer'],
            'Special Forces' => ['Havildar', 'Naib Subedar', 'Subedar', 'Special Forces Officer']
        ],

        'Base Camp' => [
            'Infantry'       => ['Sepoy', 'Lance Naik', 'Naik', 'Havildar', 'Naib Subedar'],
            'Artillery'      => ['Naik', 'Havildar', 'Naib Subedar'],
            'Engineering'    => ['Naik', 'Havildar', 'Subedar'],
            'Medical'        => ['Naik', 'Havildar', 'Subedar', 'Medical Officer'],
            'Communication'  => ['Naik', 'Havildar', 'Subedar'],
            'Logistics'      => ['Naik', 'Havildar', 'Naib Subedar', 'Logistics Officer'],
            'Special Forces' => ['Havildar', 'Subedar', 'Special Forces Officer']
        ],

        'Training Center' => [
            'Infantry'       => ['Havildar', 'Naib Subedar', 'Subedar', 'Subedar Major'],
            'Artillery'      => ['Havildar', 'Naib Subedar', 'Subedar'],
            'Engineering'    => ['Havildar', 'Subedar', 'Subedar Major'],
            'Medical'        => ['Havildar', 'Subedar', 'Medical Officer'],
            'Communication'  => ['Naib Subedar', 'Subedar'],
            'Logistics'      => ['Havildar', 'Subedar', 'Logistics Officer'],
            'Special Forces' => ['Subedar', 'Subedar Major', 'Special Forces Officer']
        ],

        'Headquarters' => [
            'Infantry'       => ['Subedar Major', 'Lieutenant', 'Captain', 'Major', 'Lieutenant Colonel', 'Colonel', 'Brigadier'],
            'Artillery'      => ['Subedar Major', 'Captain', 'Major', 'Lieutenant Colonel'],
            'Engineering'    => ['Captain', 'Major', 'Lieutenant Colonel'],
            'Medical'        => ['Captain', 'Major', 'Lieutenant Colonel', 'Medical Officer'],
            'Communication'  => ['Captain', 'Major', 'Lieutenant Colonel'],
            'Logistics'      => ['Captain', 'Major', 'Lieutenant Colonel', 'Logistics Officer'],
            'Special Forces' => ['Major', 'Lieutenant Colonel', 'Special Forces Officer']
        ],

        'Field Hospital' => [
            'Medical'   => ['Naik', 'Havildar', 'Captain', 'Major', 'Medical Officer'],
            'Logistics' => ['Naik', 'Havildar', 'Subedar', 'Logistics Officer']
        ],

        'Forward Operating Base' => [
            'Infantry'       => ['Sepoy', 'Lance Naik', 'Naik', 'Havildar'],
            'Artillery'      => ['Lance Naik', 'Naik', 'Havildar'],
            'Engineering'    => ['Naik', 'Havildar', 'Naib Subedar'],
            'Medical'        => ['Naik', 'Havildar', 'Medical Officer'],
            'Communication'  => ['Lance Naik', 'Naik', 'Havildar'],
            'Logistics'      => ['Naik', 'Havildar', 'Logistics Officer'],
            'Special Forces' => ['Havildar', 'Subedar', 'Special Forces Officer']
        ],

        'Command Center' => [
            'Infantry'       => ['Colonel', 'Brigadier', 'Major General', 'Lieutenant General', 'General'],
            'Artillery'      => ['Colonel', 'Brigadier', 'Major General'],
            'Engineering'    => ['Colonel', 'Brigadier'],
            'Medical'        => ['Colonel', 'Brigadier', 'Major General', 'Medical Officer'],
            'Communication'  => ['Lieutenant Colonel', 'Colonel'],
            'Logistics'      => ['Lieutenant Colonel', 'Colonel', 'Logistics Officer'],
            'Special Forces' => ['Colonel', 'Brigadier', 'Special Forces Officer']
        ],

        'Supply Depot' => [
            'Logistics' => ['Naik', 'Havildar', 'Naib Subedar', 'Subedar', 'Logistics Officer'],
            'Engineering' => ['Naik', 'Havildar', 'Subedar'],
            'Communication' => ['Naik', 'Havildar'],
        ],

        'Military Hospital' => [
            'Medical' => ['Naik', 'Havildar', 'Subedar', 'Captain', 'Major', 'Lieutenant Colonel', 'Medical Officer'],
            'Logistics' => ['Naik', 'Havildar', 'Subedar', 'Logistics Officer']
        ]
    ];

    $allowedRanks = $rules[$location][$unit] ?? [];

    if (!empty($allowedRanks)) {
        $placeholders = implode(',', array_fill(0, count($allowedRanks), '?'));
        $types = str_repeat('s', count($allowedRanks));

        $stmt = $con->prepare("SELECT id, name, rank FROM soldiers WHERE rank IN ($placeholders) AND status='Active'");
        $stmt->bind_param($types, ...$allowedRanks);
        $stmt->execute();
        $result = $stmt->get_result();

        $soldiers = [];
        while ($row = $result->fetch_assoc()) {
            $soldiers[] = $row;
        }

        echo json_encode(['success' => true, 'soldiers' => $soldiers]);
        exit;
    }
}

echo json_encode(['success' => false, 'soldiers' => []]);
exit;
