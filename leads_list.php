<?php

/**
 * @return array
 */

function getIdLeadsNoTask() 
{
    
    $subdomain = SUBDOMAIN; #Задан в файле index.php

    $link = 'https://' . $subdomain . '.amocrm.ru/private/api/v2/json/leads/list'; #$subdomain уже объявляли выше
    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    #Устанавливаем необходимые опции для сеанса cURL
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__DIR__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__DIR__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl); #Завершаем сеанс cURL
    /**
     * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
     * нам придётся перевести ответ в формат, понятный PHP
     */
    $Response = json_decode($out, true);

    if ($leads = $Response['response']['leads']) {

        //Выбираем сделки без открытых задач
        foreach ($leads as $lead) {
            if ($lead['closest_task'] === 0) {
                $idLeadsNoTask[] = $lead['id'];
            }
        }
        
        if (isset($idLeadsNoTask)) {
            return $idLeadsNoTask;
        }else {
            die("<br>Задачи добавить не можем, все сделки с задачами");
        }
        
    }
    
}
