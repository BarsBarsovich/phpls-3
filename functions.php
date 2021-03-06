<?php

const FILE_URL = 'data.xml';
const WIKI_URL = 'https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json';

const OUTPUT_1 = 'output.xml';
const OUTPUT_2 = 'output2.xml';
function task1()
{
    $file = file_get_contents(FILE_URL);
    $xml = new SimpleXMLElement($file);

    echo '<strong> Сведения о заказе </strong><br/>';
    echo '<strong>Номер заказа: </strong>' . $xml->attributes()->PurchaseOrderNumber . '<br/>';
    echo '<strong>Дата доставки: </strong>' . $xml->attributes()->OrderDate . '<br/>';

    foreach ($xml->Address as $address) {
        echo '<ul>';
        echo '<li><strong>Тип адреса:</strong>' . $address->attributes()->Type . '</li>';
        echo '<li><strong>Кому:</strong>' . $address->Name . '</li>';
        echo '<li><strong>Страна:</strong>' . $address->Country . '</li>';
        echo '<li><strong>Штат:</strong>' . $address->State . '</li>';
        echo '<li><strong>Город:</strong>' . $address->City . '</li>';
        echo '<li><strong>Улица:</strong>' . $address->Street . '</li>';
        echo '<li><strong>Почтовый индекс:</strong>' . $address->Zip . '</li>';
        echo '</ul>';
    }

    echo '<p><strong>Список товаров</strong></p>';

    foreach ($xml->Items->Item as $i) {
        echo '<ul>';
        echo '<li>  <strong>Артикул: </strong>' . $i->attributes()->PartNumber . '</li>';
        echo '<li>  <strong>Наименование: </strong>' . $i->ProductName . '</li>';
        echo '<li>  <strong>Количество: </strong>' . $i->Quantity . '</li>';
        echo '<li>  <strong>Цена: </strong>' . $i->USPrice . '</li>';
        echo '<li>  <strong>Комментарий: </strong>' . $i->Comment . '</li>';
        echo '<li>  <strong>Дата доставки: </strong>' . $i->ShipDate . '</li>';
        echo '</ul>';
    }

    echo '<p><strong>Примечания: </strong>';
    echo $xml->DeliveryNotes;

}

function task2()
{
//

    $users = [
        'items' => [
            ['name' => 'Router', 'price' => '150'],
            ['name' => 'Mouse', 'price' => '160'],
            ['name' => 'Notebook', 'price' => '170'],
        ]
    ];
    $json = json_encode($users);

    file_put_contents(OUTPUT_1, $json);

    $file1 = file_get_contents(OUTPUT_1);


    $needUpdate = rand(0, 10);
    echo $needUpdate;
    if ($needUpdate > 5) {
        $json_object = json_decode($json);
        $json_object->items[0]->name = 'Switch';
        file_put_contents(OUTPUT_2, json_encode($json_object));
    } else {
        file_put_contents(OUTPUT_2, json_encode($json));
    }

    $file2 = file_get_contents(OUTPUT_2);
    print_r(array_diff_assoc_recursive(json_decode($file1, true), json_decode($file2, true)));

}


function task3()
{
    $array = [];
    $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/test.csv', 'w');
    for ($i = 0; $i < 50; $i++) {
        $res = rand($i, 100);
        array_push($array, $res);
    }
    fputcsv($file, $array);

    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/test.csv', 'r');
    if (!$fp) {
        die("Can't open file");
    }

    $sum = 0;
    while ($str = fgetcsv($fp, 1000 * 1024, ';')) {
        $array = explode(',', $str[0]);

        foreach ($array as $i) {
            $int = (int)$i;
            if ($int % 2 === 0) {
                $sum += $int;
            }
        }
    }

    echo $sum;
}

function task4()
{
    $response = file_get_contents(WIKI_URL);

    $result = json_decode($response);

    foreach ($result->query->pages as $page) {
        foreach ($page as $key => $value) {
            if ($key === 'pageid' || $key === 'title') {
                echo $key . ' ' . $value . '<br/>';
            }
        }
    }
}


function array_diff_assoc_recursive($array1, $array2)
{
    foreach ($array1 as $key => $value) {
        if (is_array($value)) {
            if (!isset($array2[$key])) {
                $difference[$key] = $value;
            } elseif (!is_array($array2[$key])) {
                $difference[$key] = $value;
            } else {
                $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                if ($new_diff != false) {
                    $difference[$key] = $new_diff;
                }
            }
        } elseif (!isset($array2[$key]) || $array2[$key] != $value) {
            $difference[$key] = $value;
        }
    }
    return !isset($difference) ? 0 : $difference;
}
