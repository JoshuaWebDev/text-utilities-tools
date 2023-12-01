<?php

/**
 * Remove pontos (.)
 *
 * @param  string $value
 * @return string
 */
function removePoints($value)
{
    return str_replace(".", "", $value);
}

/**
 * Remove traços (-)
 *
 * @param  string $value
 * @return string
 */
function removeDash($value)
{
    return str_replace("-", "", $value);
}

/**
 * Remove barras (/)
 *
 * @param  string $value
 * @return string
 */
function removeSlash($value)
{
    return str_replace("/", "", $value);
}

/**
 * Verifica se o valor informado é um cpf
 *
 * @param  string $value
 * @return boolean
 */
function isCpf($value)
{
    $temp = removePoints($value);
    $temp = removeDash($temp);
    $temp = removeSlash($temp);

    if (strlen($temp) == 11) {
        return true;
    }

    return false;
}