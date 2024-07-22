<?php

require __DIR__ . '/vendor/autoload.php';

use JoshuaWebDev\Csv2Array;
use JoshuaWebDev\TreatsSensibleData;

$csv2array  = new Csv2Array;
$treatsData = new TreatsSensibleData;

// Verifica se o argumento foi informado corretamente
if ($argc < 3 || $argc > 3) {
    print("Após invocar o nome do programa digite o nome do arquivo que será convertido e o nome do campo onde encontram-se os CPFs/CNPJ!\n");
    exit();
}

/**
 * salva o nome do arquivo e define o nome e local de saída
 */
$filename = $argv[1];

if (file_exists($filename)) {
    $newfile  = substr(basename($filename), 0, -4);
    $destiny  = $csv2array->getOutPutPath() . $newfile . ' (TREATED).csv';

    /**
     * salva o nome do campo onde encontram-se os CPFs/CNPJ
     */
    $cpfCnpjField = $argv[2];

    /**
     * define o separador (; ou ,) e as aspas (duplas ou simples)
     */
    $csv2array->setSeparator(';');
    $csv2array->setQuotes('"');

    /**
     * converte o conteúdo do arquivo em um array
     * e salva o cabeçalho no array $keys
     */
    $data = $csv2array->convertToArray($filename);
    $keys = $csv2array->getHeaders();

    /**
     * inicia a formatação dos dados em csv
     */

    $contentTreated = "";

    foreach ($keys as $key) {
        $contentTreated .= $key . ";";
    }

    $contentTreated = rtrim($contentTreated, ";");

    try {
        $temp = $treatsData->hideCpf($data, $cpfCnpjField);
    
        foreach ($temp as $t) {
            $contentTreated .= "\n";
    
            foreach ($keys as $key => $value) {
                $contentTreated .= $t[$value] . ";";
            }
    
            $contentTreated = rtrim($contentTreated, ";");
        }
    
    } catch(\Exception $e) {
        echo $e->getMessage();
    }
    
    if (file_put_contents($destiny, $contentTreated)) {
        echo "O arquivo " . basename($filename) . " foi tratado e salvo em " . $destiny;
    } else {
        echo "Ocorreu algum erro durante a conversão";
    }

} else {
    echo "O arquivo {$filename} não existe";
}
