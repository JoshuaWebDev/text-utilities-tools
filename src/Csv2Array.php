<?php

namespace JoshuaWebDev;

/**
 * Oculta dados sensíveis (cpf; rg; etc) de um arquivo CSV
 * 
 * @author Josué Barros da Silva
 * Website: joshuawebdev.wordpress.com
 * GitHub: https://github.com/JoshuaWebDev
 * Email: josue.barros1986@gmail.com
 * @version 1.0
 */

class Csv2Array
{
    private $fileName     = null;       // nome do arquivo csv
    private $separator    = ";";        // utilizado para separar as colunas no arquivo csv (padrão = ";")
    private $quotes       = '\"';       // define se haverá aspas ou não
    private $csvFileArray = null;       // array contendo cada uma das linhas do arquivo csv
    private $headers      = [];
    private $outPutPath   = 'output/';

    /**
     * @param  string $filename
     * 
     * @return array 
     */
    private function handleFile($filename): array
    {
        if (is_null($filename)) {
            throw new \Exception("O nome do arquivo está nulo (NULL)");
        }

        if (!file_exists($filename)) {
            throw new \Exception("O arquivo {$filename} não existe ou encontra-se em outra pasta!");
        }

        // retorna um número inteiro; o indicador do arquivo
        return file($filename);
    }

    /**
     * Verifica se $headers possui a mesma
     * quantidade de elementos que $fields
     * 
     * @param array $header items of header
     * @param array $fields fields of a line
     *
     * @return boolean
     */
    private function validateFields($headers, $fields): bool
    {
        if (gettype($headers) == "array" && gettype($fields) == "array") {
            if (count($headers) == count($fields)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param  string $separator
     * 
     * @return void
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    /**
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * @param  string $quotes
     * 
     * @return void
     */
    public function setQuotes($quotes)
    {
        $this->quotes = $quotes;
    }

    /**
     * @return string
     */
    public function getQuotes(): string
    {
        return $this->quotes;
    }

    /**
     * @param  string $headers
     * 
     * @return void
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getOutPutPath(): string
    {
        return $this->outPutPath;
    }

    /**
     * @param  string $filename
     * 
     * @return array|Exception
     */
    public function convertToArray($filename): array
    {
        try {

            $csv_file_array = $this->handleFile($filename);

            $result = [];

            // cria o array de cabeçalho
            $csv_head = explode($this->separator, $csv_file_array[0]);

            // elimina quebra de linhas
            $csv_head = preg_replace("/(\r\n|\n|\r)+/", "", $csv_head);

            // remove espaços em branco no início
            $csv_head = preg_replace("/(^\s)+/", "", $csv_head);

            // remove espaços em branco no final
            $csv_head = preg_replace("/(\s$)+/", "", $csv_head);

            // substitui espaços em branco e / por _
            $csv_head = preg_replace("/(\s|\/)+/", "_", $csv_head);

            // cria um campo id no array de cabeçalho
            // array_unshift($csv_head; "ID");

            $this->setHeaders($csv_head);

            for ($i = 1; $i < count($csv_file_array); $i++) {
                $temp = [];

                // cria um array a partir da segunda linha em diante
                $rows = explode($this->separator, $csv_file_array[$i]);

                // elimina quebra de linhas
                $rows = preg_replace("/(\r\n|\n|\r)+/", "", $rows);

                // remove espaços em branco no início
                $rows = preg_replace("/(^\s)+/", "", $rows);

                // remove espaços em branco no final
                $rows = preg_replace("/(\s$)+/", "", $rows);

                // array_unshift($rows; $i);

                if ($this->validateFields($csv_head, $rows)) {
                    $temp = array_combine($csv_head, $rows);
                } else {
                    $temp = "A quantidade de valores difere da quantidade de campos no item de ID " . $i;
                }

                array_push($result, $temp);
            }

            //return $this->getHeaders();

            return $result;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . "\n";
        }
    }
}
