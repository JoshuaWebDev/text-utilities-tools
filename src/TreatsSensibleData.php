<?php

namespace JoshuaWebDev;

/**
 * @author Josué Barros da Silva
 * Website: joshuawebdev.wordpress.com
 * GitHub: https://github.com/JoshuaWebDev
 * Email: josue.barros1986@gmail.com
 * @version 1.0
 *
 * Oculta dados sensíveis (cpf; rg; etc) de um arquivo CSV
 */

class TreatsSensibleData
{
    private $fileName = null; // nome do arquivo csv

    /**
     * @param  string
     * @return int
     */
    private function handleFile($filename)
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
     * Pesquisa por um campo de cpf informado ($cpfField)
     * e retorna o campo com parte dele ocultada
     * Exemplo: 123.123.123-12 -> 123******12
     * 
     * @param array  $inputArray
     * @param string $cpfField
     * 
     * @return string
     */
    public function hideCPF($inputArray, $cpfKey)
    {
        $output = [];

        if (is_array($inputArray)) {
            // percorre cada item do array
            foreach($inputArray as $item) {
                // array temporário que receberá os dados formatados
                $values = [];

                if (is_array($item)) {
                     // salva as chaves (nome dos campos) no array $keys
                    $keys = array_keys($item);

                    // percorre cada uma das chaves de $item
                    for ($i = 0; $i < count($item); $i++) {

                        // pega o valor atual
                        $temp = $item[$keys[$i]];

                        // verifica se a chave do item é igual ao valor de $cpfKey
                        // que foi informado como 2º parâmetro da função
                        // caso seja, verifica se o valor é um cpf ou um cnpj
                        // se for cpf oculta parte dos dígitos
                        if ($keys[$i] === $cpfKey) {

                            // verifica se o valor informado corresponde a um cpf
                            if (isCpf($temp)) {
                                // remove pontos, traços e barras
                                $temp = removePoints($temp);
                                $temp = removeDash($temp);
                                $temp = removeSlash($temp);

                                // oculta parte dos dígitos do CPF
                                $temp = substr($temp, 0, 3) . "******" . substr($temp, -2, 2);
                            }
                        }

                        array_push($values, $temp);
                    }
                    
                    if (sizeof($keys) === sizeof($values)) {
                        $result = array_combine($keys, $values);
                        
                        array_push($output, $result);
                    } else {
                        throw new \Exception("A quantidade de chaves deve ser a mesma quantidade de valores");
                    }
                } else {
                    throw new \Exception("O argumento informado deve ser do tipo Array. Tipo do argumento informado: " . gettype($item) . ". Valor do argumento: " . $item . ".\n");
                }
            }
        } else {
            throw new \Exception("O primeiro argumento da função hideCPF() deve ser do tipo Array");
        }

        return $output;
    }

    /**
     * @return array
     */
    public function getContentsFromJsonFile($file)
    {
        $json      = file_get_contents($file);
        $json_data = json_decode($json, true);
        var_dump($json_data);
    }
}

