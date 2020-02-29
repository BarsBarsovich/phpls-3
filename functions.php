<?php

const FILE_URL = 'data.xml';

function task1()
{
    $file = file_get_contents(FILE_URL);
    $xml = new SimpleXMLElement($file);

    echo '<strong> Сведения о заказе </strong><br/>';
    echo '<strong>Номер заказа: </strong>' . $xml-> attributes()-> PurchaseOrderNumber . '<br/>';
    echo '<strong>Дата доставки: </strong>' . $xml-> attributes()-> OrderDate . '<br/>';

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
}

function task3()
{
}
